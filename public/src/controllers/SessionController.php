<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once('../controllers/DatabaseController.php');
require_once('../controllers/jwt.php');

class SessionController {
    
    private $connection;

    public function __construct() {
        $this->connection = DatabaseController::connect();
    }

    public static function userSignUp($name, $surname, $phone, $email, $password) {
        $controller = new self();
    
        if ($controller->exist($name, $email)) {
            $_SESSION['status'] = "El usuario ya existe";
            header('Location: /register');
            exit();
        } else {
            try {
                $sql = "INSERT INTO usuarios (name, surname, phone, email, password, token) VALUES (:name, :surname, :phone, :email, :password, :token)";
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $token = ''; // Valor vacío para el token
    
                $statement = $controller->connection->prepare($sql);
                $statement->bindValue(':name', $name);
                $statement->bindValue(':surname', $surname);
                $statement->bindValue(':phone', $phone);
                $statement->bindValue(':email', $email);
                $statement->bindValue(':password', $hashed_password);
                $statement->bindValue(':token', $token);
    
                if ($statement->execute()) {
                    $_SESSION['status'] = "Usuario registrado correctamente";
                    header('Location: /login');
                    exit();
                } else {
                    $_SESSION['status'] = "Error al registrar el usuario";
                    header('Location: /register');
                    exit();
                }
            } catch (PDOException $error) {
                $_SESSION['status'] = "Error al registrar el usuario: " . $error->getMessage();
                header('Location: /register');
                exit();
            }
        }
    }

    public static function userLogin($email, $password) {
        $controller = new self();
    
        try {
            $sql = "SELECT id, name, email, password FROM usuarios WHERE email = :email";
            $statement = $controller->connection->prepare($sql);
            $statement->bindValue(':email', $email);
            $statement->execute();
            $user = $statement->fetch(PDO::FETCH_OBJ);
    
            if ($user && password_verify($password, $user->password)) {
                $_SESSION['user_id'] = $user->id;
                $_SESSION['name'] = $user->name;
                $_SESSION['email'] = $user->email;
    
                // Datos para el JWT
                $header = [
                    'alg' => 'HS256',
                    'typ' => 'JWT'
                ];
    
                $payload = [
                    'user_id' => $user->id,
                    'username' => $user->name,
                    'exp' => time() + 3600 // Expira en 1 hora
                ];
    
                // Generar el token y crear la cookie
                $jwt = generarJWT($header, $payload, 'your_secret_key');
                setcookie("token", $jwt, time() + 3600, "/");
    
                // Guardar el token en la base de datos
                $statement = $controller->connection->prepare("UPDATE usuarios SET token = :token WHERE id = :id");
                $statement->bindValue(':token', $jwt);
                $statement->bindValue(':id', $user->id);
                $statement->execute();
    
                // Redirigir al perfil del usuario
                header('Location: /profile');
                exit();
            } else {
                $_SESSION['status'] = "Correo electrónico o contraseña incorrectos";
                header('Location: /login');
                exit();
            }
        } catch (PDOException $error) {
            $_SESSION['status'] = "Error al iniciar sesión: " . $error->getMessage();
            header('Location: /login');
            exit();
        }
    }

    public static function logout() {
        // Eliminar el token de la base de datos
        if (isset($_SESSION['user_id'])) {
            $controller = new self();
            $statement = $controller->connection->prepare("UPDATE usuarios SET token = NULL WHERE id = :id");
            $statement->bindValue(':id', $_SESSION['user_id']);
            $statement->execute();
        }
    
        // Destruir todas las variables de sesión
        session_unset();
        session_destroy();
    
        // Eliminar la cookie del token
        setcookie("token", "", time() - 3600, "/");
    
        // Redirigir al usuario a la página de inicio de sesión
        header('Location: /login');
        exit();
    }

    public static function verifyTokenCookie() {
        if (isset($_COOKIE['token'])) {
            $token = $_COOKIE['token'];

            $statement = (new self)->connection->prepare("SELECT id, name FROM usuarios WHERE token = :token");
            $statement->bindValue(":token", $token);
            $statement->setFetchMode(PDO::FETCH_OBJ);
            $statement->execute();
            $user = $statement->fetch();

            if ($user) {
                $_SESSION['user_id'] = $user->id;
                $_SESSION['name'] = $user->name;

                return true;
            } else {
                setcookie("token", "", time() - 3600, "/");
                header("Location: /login");
                exit();
            }
        }
        return false;
    }

    public static function exist($name, $email = null) {

        if ($email === null) {
            try  {
       
                $sql = "SELECT * 
                        FROM usuarios
                        WHERE name = :name";
            
                $statement = (new self)->connection->prepare($sql);
                $statement->bindValue(':name', $name);
                $statement->setFetchMode(PDO::FETCH_OBJ);
                $statement->execute();
    
                $result = $statement->fetch();
                return !$result ? false : true;
    
              } catch(PDOException $error) {
                  echo $sql . "<br>" . $error->getMessage();
              }

        } else {

            try  {
       
                $sql = "SELECT * 
                        FROM usuarios
                        WHERE name = :name AND email = :email";
            
                $statement = (new self)->connection->prepare($sql);
                $statement->bindValue(':name', $name);
                $statement->bindValue(':email', $email);
                $statement->setFetchMode(PDO::FETCH_OBJ);
                $statement->execute();
    
                $result = $statement->fetch();
                return !$result ? false : true;
    
              } catch(PDOException $error) {
                  echo $sql . "<br>" . $error->getMessage();
              }
        }

    }

    public static function isLoggedIn() {
        return self::verifyTokenCookie();
    }
}

if (isset($_POST['register_btn'])) {
    if (!empty($_POST['name']) && !empty($_POST['surname']) && !empty($_POST['phone']) && !empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['confirm_password'])) {
        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $_SESSION['status'] = "Formato de correo electrónico no válido";
            header('Location: /register');
            exit();
        }
        if ($_POST['password'] === $_POST['confirm_password']) {
            $controller = new SessionController();
            $controller->userSignUp($_POST['name'], $_POST['surname'], $_POST['phone'], $_POST['email'], $_POST['password']);
        } else {
            $_SESSION['status'] = "Las contraseñas no coinciden";
            header('Location: /register');
            exit();
        }
    } else {
        $_SESSION['status'] = "Todos los campos son obligatorios";
        header('Location: /register');
        exit();
    }
}

if (isset($_POST['login_btn'])) {
    if (!empty($_POST['email']) && !empty($_POST['password'])) {
        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $_SESSION['status'] = "Formato de correo electrónico no válido";
            header('Location: /login');
            exit();
        }
        $controller = new SessionController();
        $controller->userLogin($_POST['email'], $_POST['password']);
    } else {
        $_SESSION['status'] = "Todos los campos son obligatorios";
        header('Location: /login');
        exit();
    }
}

?>