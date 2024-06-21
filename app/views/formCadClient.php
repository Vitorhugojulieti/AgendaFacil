<body style="overflow:none;">
    <div class="w-full min-h-screen flex flex-col justify-center items-center bg-principal10 p-4 mb-4">
        <form action="" method="post" class="w-3/5 flex flex-col items-center justify-center gap-4 ">
            <img src="/assets/images/logo-white.png" alt="logo" style="width=20%;">
            <legend class="font-Urbanist font-semibold text-white text-3xl">Bem vindo a plataforma!</legend>
            <fieldset class="w-2/4 flex flex-col items-start justify-center gap-4 ">
                <!-- campo -->
                <div class="field w-full focus-within:text-white text-borderFormColor">
                    <label for="inputName" >Nome</label>
                    <div class="flex items-center border-2 border-borderFormColor rounded focus-within:border-white focus-within:text-white ">
                        <i class='bx bx-user' style=' padding-left:1rem; padding-right:1rem;'></i>
                        <input type="text" name="name" id="inputName" class="w-full p-2 outline-none bg-transparent border-l-2 border-borderFormColor transition-all duration-300 focus:bg-white focus:border-white focus:text-black" placeholder="Digite seu nome completo">
                    </div>
                    <!-- <span class="text-errorColor "><i class='bx bxs-info-circle' style='color:#fd837c'  ></i>Nome invalido Exemplo</span> -->
                </div>
                <!-- campo -->
                <div class="field w-full focus-within:text-white text-borderFormColor">
                    <label for="inputPhone" >Telefone</label>
                    <div class="flex items-center border-2 border-borderFormColor rounded focus-within:border-white focus-within:text-white">
                        <i class='bx bx-phone' style='padding-left:1rem; padding-right:1rem; '></i>
                        <input type="text" name="phone" id="inputPhone" class="w-full p-2 outline-none bg-transparent border-l-2 border-borderFormColor transition-all duration-300 focus:bg-white focus:border-white focus:text-black" placeholder="Digite seu nome completo">
                    </div>
                    <!-- <span class="text-errorColor "><i class='bx bxs-info-circle' style='color:#fd837c'  ></i>Nome invalido Exemplo</span> -->
                </div>
                <!-- campo -->
                <div class="field w-full focus-within:text-white text-borderFormColor">
                    <label for="inputCpf" >CPF</label>
                    <div class="flex items-center border-2 border-borderFormColor rounded focus-within:border-white focus-within:text-white">
                        <i class='bx bx-id-card' style='padding-left:1rem; padding-right:1rem;'></i>
                        <input type="text" name="cpf" id="inputCpf" class="w-full p-2 outline-none bg-transparent border-l-2 border-borderFormColor transition-all duration-300 focus:bg-white focus:border-white focus:text-black" placeholder="Digite seu nome completo">
                    </div>
                    <!-- <span class="text-errorColor "><i class='bx bxs-info-circle' style='color:#fd837c'  ></i>Nome invalido Exemplo</span> -->
                </div>
                <!-- campo -->
                <div class="field w-full focus-within:text-white text-borderFormColor">
                    <div>
                        <label for="inputEmail" >Email</label>
                        <i class='bx bxs-help-circle'   ></i>
                    </div>
                    <div class="flex items-center border-2 border-borderFormColor rounded focus-within:border-white focus-within:text-white">
                        <i class='bx bx-envelope' style='padding-left:1rem; padding-right:1rem;' ></i>
                        <input type="text" name="email" id="inputEmail" class="w-full p-2 outline-none bg-transparent border-l-2 border-borderFormColor transition-all duration-300 focus:bg-white focus:border-white focus:text-black" placeholder="Digite seu nome completo">
                    </div>
                    <!-- <span class="text-errorColor "><i class='bx bxs-info-circle' style='color:#fd837c'  ></i>Nome invalido Exemplo</span> -->
                </div>
                <!-- campo -->
                <div class="field w-full focus-within:text-white text-borderFormColor">
                    <div>
                        <label for="inputPassword" >Senha</label>
                        <i class='bx bxs-help-circle'   ></i>
                    </div>
                    <div class="flex items-center border-2 border-borderFormColor rounded focus-within:border-white focus-within:text-white">
                        <i class='bx bx-lock-alt' style='padding-left:1rem; padding-right:1rem; ' ></i>
                        <input type="password" name="password" id="inputPassword" class="w-full p-2 outline-none bg-transparent border-l-2 border-borderFormColor transition-all duration-300 focus:bg-white focus:border-white focus:text-black" placeholder="Digite seu nome completo">
                        <i class="fa-regular fa-eye pl-2 pr-2" id="btnNotViewPassword" style="display:none;"></i>
                        <i class="fa-regular fa-eye-slash pl-2 pr-2" id="btnViewPassword"></i>
                    </div>
                    <!-- <span class="text-errorColor "><i class='bx bxs-info-circle' style='color:#fd837c'  ></i>Nome invalido Exemplo</span> -->
                </div>
                <div class="w-full">
                    <input type="submit" value="CADASTRAR" class="w-full bg-white text-principal10 font-Poppins font-semibold p-2 hover:cursor-pointer hover:underline">
                    <a href="#" class="text-white">Já possui uma conta? <span class="font-semibold">Fazer login</span></a>
                </div>
            </fieldset>
        </form>
    </div>
    <script src="/assets/js/viewPassword.js" deffer></script>
</body>
