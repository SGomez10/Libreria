<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA_compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?php if (isset($page_title)) {
            echo "$page_title";
        } ?> - Logo Name
    </title>
    <style>
        html,
        body {
            height: 100%;
        }

        body {
            display: flex;
            flex-direction: column;
        }

        .container {
            flex: 1;
        }
    </style>
    <link href="/assets/twbs/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>