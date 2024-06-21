<body style="overflow:none;">
    <div class="w-full min-h-screen flex flex-col justify-center items-center bg-principal10 p-4 mb-4">
        <form action="" method="post" class="w-3/5 flex flex-col items-center justify-center gap-4 ">
            <img src="/assets/images/logo-white.png" alt="logo">
            <legend class="font-Urbanist font-semibold text-white text-3xl">Redefinir senha</legend>
            <fieldset class="w-2/4 flex flex-col items-start justify-center gap-4 ">
                 <!-- campo -->
                 <div class="field w-full focus-within:text-white text-borderFormColor">
                    <div>
                        <label for="inputPassword" >Nova senha</label>
                    </div>
                    <div class="flex items-center border-2 border-borderFormColor rounded focus-within:border-white focus-within:text-white">
                        <i class='bx bx-lock-alt' style='padding-left:1rem; padding-right:1rem; ' ></i>
                        <input type="password" name="password" id="inputPassword" class="w-full p-2 outline-none bg-transparent border-l-2 border-borderFormColor transition-all duration-300 focus:bg-white focus:border-white focus:text-black" placeholder="Digite sua senha">
                        <i class="fa-regular fa-eye pl-2 pr-2" id="btnNotViewPassword" style="display:none;"></i>
                        <i class="fa-regular fa-eye-slash pl-2 pr-2" id="btnViewPassword"></i>
                    </div>
                    <!-- <span class="text-errorColor "><i class='bx bxs-info-circle' style='color:#fd837c'  ></i>Nome invalido Exemplo</span> -->
                </div>
                 <!-- campo -->
                 <div class="field w-full focus-within:text-white text-borderFormColor">
                    <div>
                        <label for="inputPassword" >Confirmar senha</label>
                    </div>
                    <div class="flex items-center border-2 border-borderFormColor rounded focus-within:border-white focus-within:text-white">
                        <i class='bx bx-lock-alt' style='padding-left:1rem; padding-right:1rem; ' ></i>
                        <input type="password" name="password" id="inputConfirmPassword" class="w-full p-2 outline-none bg-transparent border-l-2 border-borderFormColor transition-all duration-300 focus:bg-white focus:border-white focus:text-black" placeholder="Digite sua senha">
                        <i class="fa-regular fa-eye pl-2 pr-2" id="btnNotViewConfirmPassword" style="display:none;"></i>
                        <i class="fa-regular fa-eye-slash pl-2 pr-2" id="btnViewConfirmPassword"></i>
                    </div>
                    <!-- <span class="text-errorColor "><i class='bx bxs-info-circle' style='color:#fd837c'  ></i>Nome invalido Exemplo</span> -->
                </div>
                <div class="w-full">
                    <input type="submit" value="FINALIZAR" class="w-full bg-white text-principal10 font-Poppins font-semibold p-2 hover:cursor-pointer hover:underline">
                </div>
            </fieldset>
        </form>
    </div>
    <script src="/assets/js/viewPassword.js" deffer></script>
</body>
