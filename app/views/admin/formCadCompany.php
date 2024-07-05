<form action="/admin/signup/store" method="post" enctype="multipart/form-data">
    <!-- company -->
     name
    <input type="text" name="nameCompany" id="inputName" value="<?php echo old('nameCompany') ?>" class="w-full p-2 outline-none bg-transparent border-l-2 border-borderFormColor transition-all duration-300 focus:bg-white focus:border-white focus:text-black" placeholder="Digite seu email completo">
    <?php echo old('nameCompany') ?>
    <hr>
    pj
    <input type="text" name="cnpj" id="inputCnpj" value="<?php echo old('cnpjCompany') ?>" class="w-full p-2 outline-none bg-transparent border-l-2 border-borderFormColor transition-all duration-300 focus:bg-white focus:border-white focus:text-black" placeholder="Digite seu email completo">
    <?php echo old('cnpjCompany') ?>
    <hr>
    pf
    <input type="text" name="cpfCompany" id="inputCpf" value="<?php echo old('cpfCompany') ?>" class="w-full p-2 outline-none bg-transparent border-l-2 border-borderFormColor transition-all duration-300 focus:bg-white focus:border-white focus:text-black" placeholder="Digite seu email completo">
    <?php echo old('cpfCompany') ?>
    <hr>
    <select name="category" id="inputCategory">
        <option value="Salão de beleza">Salão de beleza</option>
        <option value="Barbearia">Barbearia</option>
        <option value="Salão">Salão</option>
    </select>
    <hr>
    cep
    <input type="text" name="cep" id="inputCep" value="<?php echo old('cepCompany') ?>" class="w-full p-2 outline-none bg-transparent border-l-2 border-borderFormColor transition-all duration-300 focus:bg-white focus:border-white focus:text-black" placeholder="Digite seu email completo">
    <?php echo old('cepCompany') ?>
    <hr>
    adress
    <input type="text" name="adress" id="inputAdress" value="<?php echo old('adressCompany') ?>" class="w-full p-2 outline-none bg-transparent border-l-2 border-borderFormColor transition-all duration-300 focus:bg-white focus:border-white focus:text-black" placeholder="Digite seu email completo">
    <?php echo old('adressCompany') ?>
    <hr>
    phone
    <input type="text" name="phoneCompany" id="inputPhoneCompany" value="<?php echo old('phoneCompany') ?>" class="w-full p-2 outline-none bg-transparent border-l-2 border-borderFormColor transition-all duration-300 focus:bg-white focus:border-white focus:text-black" placeholder="Digite seu email completo">
    <?php echo old('phoneCompany') ?>
    <hr>
    email
    <input type="text" name="emailCompany" id="inputEmailCompany" value="<?php echo old('emailCompany') ?>" class="w-full p-2 outline-none bg-transparent border-l-2 border-borderFormColor transition-all duration-300 focus:bg-white focus:border-white focus:text-black" placeholder="Digite seu email completo">
    <?php echo old('emailCompany') ?>



    <hr>
    name
    <input type="text" name="name" id="inputName" value="<?php echo old('name') ?>" class="w-full p-2 outline-none bg-transparent border-l-2 border-borderFormColor transition-all duration-300 focus:bg-white focus:border-white focus:text-black" placeholder="Digite seu email completo">
    <?php echo old('name') ?>
    <hr>
    pf
    <input type="text" name="cpf" id="inputCpf" value="<?php echo old('cpf') ?>" class="w-full p-2 outline-none bg-transparent border-l-2 border-borderFormColor transition-all duration-300 focus:bg-white focus:border-white focus:text-black" placeholder="Digite seu email completo">
    <?php echo old('cpf') ?>
    <hr>
    phone
    <input type="text" name="phone" id="inputPhone" value="<?php echo old('phone') ?>" class="w-full p-2 outline-none bg-transparent border-l-2 border-borderFormColor transition-all duration-300 focus:bg-white focus:border-white focus:text-black" placeholder="Digite seu email completo">
    <?php echo old('phone') ?>

    email
    <input type="text" name="email" id="inputEmail" value="<?php echo old('email') ?>" class="w-full p-2 outline-none bg-transparent border-l-2 border-borderFormColor transition-all duration-300 focus:bg-white focus:border-white focus:text-black" placeholder="Digite seu email completo">
    <?php echo old('email') ?>

     pass
    <input type="text" name="password" id="inputPassword" value="<?php echo old('password') ?>" class="w-full p-2 outline-none bg-transparent border-l-2 border-borderFormColor transition-all duration-300 focus:bg-white focus:border-white focus:text-black" placeholder="Digite seu email completo">
    <?php echo old('password') ?>

    avatar
    <input type="file" name="avatar" id="inputPassword" class="w-full p-2 outline-none bg-transparent border-l-2 border-borderFormColor transition-all duration-300 focus:bg-white focus:border-white focus:text-black" placeholder="Digite seu email completo">
    <?php echo old('avatar') ?>

    logo
    <input type="file" name="logo" id="inputPassword" class="w-full p-2 outline-none bg-transparent border-l-2 border-borderFormColor transition-all duration-300 focus:bg-white focus:border-white focus:text-black" placeholder="Digite seu email completo">
    <?php echo old('logo') ?>

    <input type="submit" value="enviar">
</form>

