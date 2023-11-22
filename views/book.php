<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Item Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        header {
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 1em;
        }

        .item-container {
            max-width: 600px;
            margin: 2em auto;
            padding: 1em;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        img {
            max-width: 100%;
            height: auto;
            margin-bottom: 1em;
        }

        h1, p {
            margin-bottom: 1em;
        }
    </style>
</head>
<body>
<header>
    <h1>Item Details</h1>
</header>
<div class="item-container">
    <?php
    /** @noinspection ALL */

    $book = $items['book'];
        echo "
                isbn : {$book?->isbn} <br>
                title: {$book?->title} <br>
                author: {$book?->authorName} <br>
                pages: {$book?->pageCount} <br>
                published time : {$book?->timeStamp} <br>
                ";
    ?>
</div>
</body>
</html>
