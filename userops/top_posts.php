<?php

require "../dbconfig/conn.php";
require "../components/session.php";
require "../components/errorfunc.php";
require "../components/banner.php";
require "../components/customnav.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Top Posts</title>
</head>

<body>
    <?php
    $get_posts = "select `title`, `views` from `lyrics` order by `views` desc limit 10";
    $data = $conn->query($get_posts);
    ?>
    <h3>
        Top Posts<br>
        <small class="text-muted">Evaluated By Most Views.</small>
    </h3>

    <ul class="list-group">
        <?php foreach ($data as $d) { ?>
            <li class="list-group-item"><?php echo $d['title']; ?> &nbsp; &nbsp; Views: <?php echo $d['views'];
                                                                                    } ?></li>

    </ul>

</body>

</html>