<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .error-container {
            max-width: 400px;
            margin: 5% auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        h1 {
            color: #e74c3c; /* Red color for error message */
        }

        p {
            color: #333;
        }

        a {
            color: #3498db; /* Blue color for links */
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
<div class="error-container">
    <h1>Oops! Something went wrong.</h1>
    <?php
    /** @noinspection ALL */
    $error = $items['error'];
    echo "<p>{$error?->message}</p>"
    ?>
</div>
</body>
</html>
