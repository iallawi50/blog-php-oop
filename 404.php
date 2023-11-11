<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background-color: #123;
            min-height: 100vh;
            font-family: sans-serif;
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
        }
    </style>
</head>

<body>
    <h1>404 | Page Not Found</h1>
    <?php 
    $home = home(); 
    echo <<<script

    <script>

    setTimeout(() => {
        window.location.href = "$home";
    }, 3000)

    </script>
    script;
    ?>
</body>

</html>