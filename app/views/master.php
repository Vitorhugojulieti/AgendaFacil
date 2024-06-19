<!DOCTYPE html>
<html lang="pt-br" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="/assets/css/output.css">
    <script src="/assets/js/index.js" deffer></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="//use.fontawesome.com/releases/v5.0.7/css/all.css">
    <title><?php echo $title?></title>
</head>
<body>
    <?php echo require VIEW_PATH.$this->controller->view ?>
</body>
</html>