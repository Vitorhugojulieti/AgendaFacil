<body style="overflow:none;" class="flex">
    <!-- div img -->
     <div class="w-3/6 min-h-screen bg-white">

     </div>
    <!-- Formulario -->
    <div class="w-3/6 min-h-screen flex flex-col justify-center items-center bg-principal10 p-4 mb-4">
        <form action="" method="post" class="w-full flex flex-col items-center justify-center gap-4 ">
            <img src="/assets/images/logo-white.png" alt="logo" >
            <legend class="font-Urbanist font-semibold text-white text-3xl">Bem vindo de volta!</legend>
            <fieldset class="w-2/4 flex flex-col items-start justify-center gap-4 ">
                 <!-- Campo login com google -->
                 <div class="w-full bg-white text-principal10 font-semibold font-Poppins text-base flex items-center justify-center gap-4 p-2 rounded">
                    <img src="/assets/images/google_icon.png" alt="icone google">
                    <a href="">Continuar com Google</a>
                </div>
                <!-- campo -->
                <div class="field w-full focus-within:text-white text-borderFormColor">
                    <div>
                        <label for="inputEmail" >Email</label>
                    </div>
                    <div class="flex items-center border-2 border-borderFormColor rounded focus-within:border-white focus-within:text-white">
                        <i class='bx bx-envelope' style='padding-left:1rem; padding-right:1rem;' ></i>
                        <input type="text" name="email" id="inputEmail" class="w-full p-2 outline-none bg-transparent border-l-2 border-borderFormColor transition-all duration-300 focus:bg-white focus:border-white focus:text-black" placeholder="Digite seu email">
                    </div>
                    <!-- <span class="text-errorColor "><i class='bx bxs-info-circle' style='color:#fd837c'  ></i>Nome invalido Exemplo</span> -->
                </div>
                <!-- campo -->
                <div class="field w-full focus-within:text-white text-borderFormColor">
                    <div>
                        <label for="inputPassword" >Senha</label>
                    </div>
                    <div class="flex items-center border-2 border-borderFormColor rounded focus-within:border-white focus-within:text-white">
                        <i class='bx bx-lock-alt' style='padding-left:1rem; padding-right:1rem; ' ></i>
                        <input type="password" name="password" id="inputPassword" class="w-full p-2 outline-none bg-transparent border-l-2 border-borderFormColor transition-all duration-300 focus:bg-white focus:border-white focus:text-black" placeholder="Digite sua senha">
                        <i class="fa-regular fa-eye pl-2 pr-2" id="btnNotViewPassword" style="display:none;"></i>
                        <i class="fa-regular fa-eye-slash pl-2 pr-2" id="btnViewPassword"></i>
                    </div>
                    <!-- <span class="text-errorColor "><i class='bx bxs-info-circle' style='color:#fd837c'  ></i>Nome invalido Exemplo</span> -->
                </div>
                <div class="w-full">
                    <input type="submit" value="ENTRAR" class="w-full bg-white text-principal10 font-Poppins font-semibold p-2 hover:cursor-pointer hover:underline">
                    <a href="#" class="text-white">Não possui uma conta? <span class="font-semibold">Cadastre-se</span></a>
                </div>
            </fieldset>
        </form>
    </div>
    <script src="/assets/js/viewPassword.js" deffer></script>
</body>
