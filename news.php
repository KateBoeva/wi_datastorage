<?php
$url = 'http://localhost:3000/api/v1/news_items';
$text = $_GET['search'];
$params = $text ? '?q=' . strtolower($text) : '';
$json = file_get_contents($url . $params);
$data = json_decode($json, JSON_OBJECT_AS_ARRAY);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Search</title>
    <style>
        img {
            height: 300px;
            width: auto;
        }
        a {
            text-decoration: none;
            color: black;
        }
        .block {
            background: #cfcfcf;
            border: 1px solid #cfcfcf;
            border-radius: 3px;
            padding: 0 15px 15px 15px;
        }
    </style>
</head>
<body>
<div class="search_block">
    <form>
        <label>Search: <input type="text" id="search" name="search"></label>
        <input type="submit" value="Find!">
    </form>
</div>
<br>
<?php foreach ($data as $article) { ?>
    <?php if ($text) {
        foreach ($article as $name => $field) {
            $article[$name] = preg_replace("/($text)/si", "<strong style='color: red;'>\\1</strong>", $article[$name]);
        }
    }
    ?>
    <div class="block">
        <p>Title: <?= $article['title'] ?></p>
        <p>Description: <?= $article['description'] ?></p>
        <p>Author: <?= $article['author']?: '-' ?></p>
        <p>Published at: <?= $article['publish_at'] ?></p>
        <?php if ($article['url_to_image']) { ?>
            <img src="<?= $article['url_to_image']?>" alt="" height="300">
        <?php } ?>
        <?php if ($article['url']) { ?>
            <br><a href="<?= $article['url'] ?>" style="color: blue !important;">More...</a>
        <?php } ?>
    </div>
    <br><br>
<?php } ?>
</body>
</html>