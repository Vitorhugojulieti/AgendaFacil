<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Home</h1>
    <?php var_dump($_SESSION['user']); ?>
    <img src="<?php echo $_SESSION['user']->getAvatar();?>" alt="">
    <a href="login/destroy">Logout</a>
    ?>
</body>
</html>