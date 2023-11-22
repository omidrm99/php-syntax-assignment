<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Item List</title>
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

        section {
            max-width: 600px;
            margin: 2em auto;
            padding: 1em;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        ul {
            list-style: none;
            padding: 0;
        }

        li {
            margin-bottom: 1em;
            padding: 1em;
            border: 1px solid #ddd;
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>
<header>
    <h1>Item List</h1>
</header>
<section>
    <ul>
        <?php
        /** @noinspection ALL */

        $books = $items['books'];
        foreach ($books as $book) {
            echo "<li>
                isbn : {$book?->isbn} <br>
                title: {$book?->title} <br>
                author: {$book?->authorName} <br>
                pages: {$book?->pageCount} <br>
                published time : {$book?->timeStamp} <br>
                </li>";
        }
        ?>
    </ul>
</section>
</body>
</html>
