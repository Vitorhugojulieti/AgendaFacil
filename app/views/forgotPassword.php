<body style="overflow:none;">
    <div class="w-full min-h-screen flex flex-col justify-center items-center bg-principal10 p-4 mb-4">
            <form action="<?php echo $action; ?>" method="post" id="formForgotPassword" class="w-3/5 flex flex-col items-center justify-center gap-4 ">
            <a href="/"><img src="/assets/images/logo-white.png" alt="logo" ></a>
            <legend class="font-Urbanist font-semibold text-white text-3xl">Esqueceu a senha?</legend>
            <fieldset class="w-2/4 flex flex-col items-start justify-center gap-4 ">
                <span class="w-full bg-principal5 text-white text-center rounded" id="msgPasswordError"><?php echo flash('redefinePassword');  ?></span>

                <!-- campo -->
                <div class="field w-full focus-within:text-white text-borderFormColor">
                    <div>
                        <label for="inputEmail" >Email</label>
                    </div>
                    <div class="flex items-center border-2 border-borderFormColor rounded focus-within:border-white focus-within:text-white">
                        <i class='bx bx-envelope' style='padding-left:1rem; padding-right:1rem;' ></i>
                        <input type="text" name="email" id="inputEmail" class="w-full p-2 outline-none bg-transparent border-l-2 border-borderFormColor transition-all duration-300 focus:bg-white focus:border-white focus:text-black" placeholder="Digite seu email">
                    </div>
                </div>
                <div class="w-full">
                    <input type="submit" value="VERIFICAR" class="w-full bg-white text-principal10 font-Poppins font-semibold p-2 hover:cursor-pointer hover:underline">
                </div>
            </fieldset>
        </form>
    </div>
    <script type="module" src="/assets/js/forgotPassword.js" deffer></script>
</body>
