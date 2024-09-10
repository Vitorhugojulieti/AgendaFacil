<body style="overflow:hidden;" class="flex">
    <!-- Formulario -->
    <div class="w-full min-h-screen flex flex-col justify-center items-center bg-hexagonal p-4 mb-4">
        <form action="login/store" method="post" id="formloginClient" class="lg:w-3/6 w-full flex flex-col items-center justify-center gap-4 ">
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['token']; ?>">
            <a href="/"><img src="/assets/images/logo-white.png" alt="logo" ></a>
            <legend class="font-Urbanist font-semibold text-white text-3xl">Bem vindo de volta!</legend>
            <fieldset class="lg:w-2/4 w-3/4 flex flex-col items-start justify-center gap-2 ">
                <?php echo flash('session_expired');  ?>

                 <!-- Campo login com google -->
                 <div class="w-full bg-white text-principal10 font-semibold font-Poppins text-base flex items-center justify-center gap-4 p-2 rounded">
                    <img src="/assets/images/google_icon.png" alt="icone google">
                    <a href="<?php echo $linkGoogle; ?>">Continuar com Google</a>
                </div>
                <!-- campo -->
                <div class="field w-full focus-within:text-white text-lightGrayInput">
                    <div>
                        <label for="inputEmail" >Email</label>
                    </div>
                    <div class="flex items-center border-2 border-lightGrayInput rounded focus-within:border-white focus-within:text-white">
                        <i class='bx bx-envelope' style='padding-left:1rem; padding-right:1rem;' ></i>
                        <input type="text" name="email" id="inputEmail" class="w-full p-2 outline-none bg-transparent border-l-2 border-lightGrayInput transition-all duration-300 focus:bg-white focus:border-white focus:text-black" placeholder="Digite seu email">
                    </div>
                    <span class="text-errorColor" id="msgEmailError"><?php echo flash('login');  ?></span>
                </div>
                <!-- campo -->
                <div class="field w-full focus-within:text-white text-lightGrayInput">
                    <div>
                        <label for="inputPassword" >Senha</label>
                    </div>
                    <div class="flex items-center border-2 border-lightGrayInput rounded focus-within:border-white focus-within:text-white">
                        <i class='bx bx-lock-alt' style='padding-left:1rem; padding-right:1rem; ' ></i>
                        <input type="password" name="password" id="inputPassword" class="w-full p-2 outline-none bg-transparent border-l-2 border-lightGrayInput transition-all duration-300 focus:bg-white focus:border-white focus:text-black" placeholder="Digite sua senha">
                        <i class="fa-regular fa-eye pl-2 pr-2" id="btnNotViewPassword" style="display:none;"></i>
                        <i class="fa-regular fa-eye-slash pl-2 pr-2" id="btnViewPassword"></i>
                    </div>
                    <div class="flex flex-col items-start">
                        <span class="text-errorColor " id="msgPasswordError"><?php echo flash('passwordLogin');  ?></span>
                        <a href="login/edit" class="hover:text-white">Esqueceu a senha?</a>
                    </div>
                </div>
                <div class="w-full">
                    <input type="submit" value="ENTRAR" class="w-full bg-white text-principal10 font-Poppins font-semibold p-2 hover:cursor-pointer hover:underline">
                    <a href="/signup" class="text-white hover:underline">Não possui uma conta? <span class="font-semibold">Cadastre-se</span></a>
                </div>
            </fieldset>
        </form>
    </div>
    <script type="module" src="/assets/js/loginClient.js" deffer></script>
</body>
