<body style="overflow:none;">
    <div class="w-full min-h-full flex flex-col justify-center items-center bg-principal10 p-4">
        <form action="" method="post" class="w-3/5 flex flex-col items-center justify-center gap-2 ">
            <img src="/assets/images/logo-white.png" alt="logo" style="width:20%;">
            <legend class="font-Urbanist font-semibold text-white text-3xl">Bem vindo a plataforma</legend>
            <fieldset class="w-2/4 flex flex-col items-start justify-center gap-6 ">
                <!-- campo -->
                <div class="field w-full">
                    <label for="inputName" class="text-borderFormColor">Nome</label>
                    <div class="flex items-center border-2 border-borderFormColor rounded">
                        <i class='bx bx-user' style='color:#afb6c2; padding-left:1rem; padding-right:1rem;'></i>
                        <input type="text" name="name" id="inputName" class="w-full p-2 outline-none">
                    </div>
                    <!-- <span class="text-errorColor "><i class='bx bxs-info-circle' style='color:#fd837c'  ></i>Nome invalido Exemplo</span> -->
                </div>
                <!-- campo -->
                <div class="field w-full">
                    <label for="inputPhone" class="text-borderFormColor">Telefone</label>
                    <div class="flex items-center border-2 border-borderFormColor rounded">
                        <i class='bx bx-phone' style='color:#afb6c2; padding-left:1rem; padding-right:1rem; '></i>
                        <input type="text" name="phone" id="inputPhone" class="w-full p-2 outline-none">
                    </div>
                    <!-- <span class="text-errorColor "><i class='bx bxs-info-circle' style='color:#fd837c'  ></i>Nome invalido Exemplo</span> -->
                </div>
                <!-- campo -->
                <div class="field w-full">
                    <label for="inputCpf" class="text-borderFormColor">CPF</label>
                    <div class="flex items-center border-2 border-borderFormColor rounded">
                        <i class='bx bx-id-card' style='color:#afb6c2; padding-left:1rem; padding-right:1rem;'></i>
                        <input type="text" name="cpf" id="inputCpf" class="w-full p-2 outline-none">
                    </div>
                    <!-- <span class="text-errorColor "><i class='bx bxs-info-circle' style='color:#fd837c'  ></i>Nome invalido Exemplo</span> -->
                </div>
                <!-- campo -->
                <div class="field w-full">
                    <div>
                        <label for="inputEmail" class="text-borderFormColor">Email</label>
                        <i class='bx bxs-help-circle' style='color:#ffffff'  ></i>
                    </div>
                    <div class="flex items-center border-2 border-borderFormColor rounded">
                        <i class='bx bx-envelope' style='color:#afb6c2;padding-left:1rem; padding-right:1rem;' ></i>
                        <input type="text" name="email" id="inputEmail" class="w-full p-2 outline-none">
                    </div>
                    <!-- <span class="text-errorColor "><i class='bx bxs-info-circle' style='color:#fd837c'  ></i>Nome invalido Exemplo</span> -->
                </div>
                <!-- campo -->
                <div class="field w-full">
                    <div>
                        <label for="inputPassword" class="text-borderFormColor">Senha</label>
                        <i class='bx bxs-help-circle' style='color:#ffffff'  ></i>
                    </div>
                    <div class="flex items-center border-2 border-borderFormColor rounded">
                        <i class='bx bx-lock-alt' style='color:#afb6c2;padding-left:1rem; padding-right:1rem; ' ></i>
                        <input type="password" name="password" id="inputPassword" class="w-full p-2 outline-none">
                        <i class="fa-regular fa-eye" style="color: #868686;"></i>
                        <i class="fa-regular fa-eye-slash" style="color: #868686;"></i>
                    </div>
                    <!-- <span class="text-errorColor "><i class='bx bxs-info-circle' style='color:#fd837c'  ></i>Nome invalido Exemplo</span> -->
                </div>
                <div class="w-full">
                    <input type="submit" value="CADASTRAR" class="w-full bg-white text-principal10 font-Poppins font-semibold p-2 hover:cursor-pointer">
                    <a href="#" class="text-white">Já possui uma conta? <span class="font-semibold">Fazer login</span></a>
                </div>
            </fieldset>
        </form>
    </div>
</body>
