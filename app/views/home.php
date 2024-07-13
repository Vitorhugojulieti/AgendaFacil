<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<form action="/admin/services/update" method="post" enctype="multipart/form-data">
    <!-- company -->
     name
    <input type="text" name="name" id="inputName" value="<?php echo old('name') ?>" class="w-full p-2 outline-none bg-transparent border-l-2 border-borderFormColor transition-all duration-300 focus:bg-white focus:border-white focus:text-black" placeholder="Digite seu email completo">
    <?php echo flash('name') ?>
    <hr>
    des
    <input type="text" name="description" id="inputCnpj" value="<?php echo old('cpf') ?>" class="w-full p-2 outline-none bg-transparent border-l-2 border-borderFormColor transition-all duration-300 focus:bg-white focus:border-white focus:text-black" placeholder="Digite seu email completo">
    <?php echo flash('cpf') ?>
    <hr>
    pri
    <input type="text" name="price" id="inputCpf" value="<?php echo old('phone') ?>" class="w-full p-2 outline-none bg-transparent border-l-2 border-borderFormColor transition-all duration-300 focus:bg-white focus:border-white focus:text-black" placeholder="Digite seu email completo">
    <?php echo old('phone') ?>

    du
    <input type="text" name="duration" id="inputCep" value="<?php echo old('email') ?>" class="w-full p-2 outline-none bg-transparent border-l-2 border-borderFormColor transition-all duration-300 focus:bg-white focus:border-white focus:text-black" placeholder="Digite seu email completo">
    <?php echo flash('email') ?>
    <hr>

    id
    <input type="text" name="id" id="inputCep" value="13" class="w-full p-2 outline-none bg-transparent border-l-2 border-borderFormColor transition-all duration-300 focus:bg-white focus:border-white focus:text-black" placeholder="Digite seu email completo">
    <?php echo flash('email') ?>
    <hr>

    
    avatar
    <input type="file" name="avatar" id="inputPassword" class="w-full p-2 outline-none bg-transparent border-l-2 border-borderFormColor transition-all duration-300 focus:bg-white focus:border-white focus:text-black" placeholder="Digite seu email completo">
    <?php echo flash('avatar') ?>


    <input type="submit" value="enviar">
</form>



</body>
</html>