<body style="overflow:none;">
    <div class="w-full min-h-screen flex flex-col justify-center items-center bg-principal10 p-4 mb-4">
        <form action="" method="post" id="formFinishRegistration" class="w-3/5 flex flex-col items-center justify-center gap-4 ">
            <img src="/assets/images/logo-white.png" alt="logo">
            <legend class="font-Urbanist font-semibold text-white text-3xl">Finalize seu cadastro!</legend>
            <fieldset class="w-2/4 flex flex-col items-start justify-center gap-1">
                <!-- campo -->
                <div class="field w-full focus-within:text-white text-borderFormColor">
                    <label for="inputPhone" >Telefone</label>
                    <div class="flex items-center border-2 border-borderFormColor rounded focus-within:border-white focus-within:text-white">
                        <i class='bx bx-phone' style='padding-left:1rem; padding-right:1rem; '></i>
                        <input type="text" name="phone" id="inputPhone" class="w-full p-2 outline-none bg-transparent border-l-2 border-borderFormColor transition-all duration-300 focus:bg-white focus:border-white focus:text-black" placeholder="Digite seu telefone">
                    </div>
                    <span class="text-errorColor " id="msgPhoneError"></span>
                </div>
                <!-- campo -->
                <div class="field w-full focus-within:text-white text-borderFormColor">
                    <label for="inputCpf" >CPF</label>
                    <div class="flex items-center border-2 border-borderFormColor rounded focus-within:border-white focus-within:text-white">
                        <i class='bx bx-id-card' style='padding-left:1rem; padding-right:1rem;'></i>
                        <input type="text" name="cpf" id="inputCpf" class="w-full p-2 outline-none bg-transparent border-l-2 border-borderFormColor transition-all duration-300 focus:bg-white focus:border-white focus:text-black" placeholder="Digite seu CPF">
                    </div>
                    <span class="text-errorColor " id="msgCpfError"></span>
                </div>

                <div class="field w-full focus-within:text-white text-borderFormColor">
                        <div>
                            <label for="inputPassword" >Senha</label>
                            <i class='bx bxs-help-circle hover:text-white hover:cursor-pointer' id="btnOpenModalPassword"></i>
                        </div>
                        <div class="flex items-center border-2 border-borderFormColor rounded focus-within:border-white focus-within:text-white">
                            <i class='bx bx-lock-alt' style='padding-left:1rem; padding-right:1rem; ' ></i>
                            <input type="password" name="password" id="inputPassword" value="<?php echo old('password') ?>" class="w-full p-2 outline-none bg-transparent border-l-2 border-borderFormColor transition-all duration-300 focus:bg-white focus:border-white focus:text-black" placeholder="Digite seu nome completo">
                            <i class="fa-regular fa-eye pl-2 pr-2" id="btnNotViewPassword" style="display:none;"></i>
                            <i class="fa-regular fa-eye-slash pl-2 pr-2" id="btnViewPassword"></i>
                        </div>
                        <span class="text-errorColor " id="msgPasswordError"><?php echo flash('password');  ?></span>
                    </div>
                <div class="w-full">
                    <input type="submit" value="FINALIZAR" class="w-full bg-white text-principal10 font-Poppins font-semibold p-2 hover:cursor-pointer hover:underline">
                </div>
            </fieldset>
        </form>
    </div>

        <!-- modais -->
        <dialog id="modalPassword" class="w-2/4 bg-white text-black rounded p-4 ">
        <div class="w-full flex justify-between items-center mb-4">
            <div class="flex gap-4 items-center">
                <i class='bx bx-lock-alt text-2xl'></i>
                <h1 class="text-2xl font-semibold font-Urbanist">Proteção da senha</h1>
            </div>
            <button id="btnCloseModalPassword" class="outline-none"><i class='bx bx-x-circle text-3xl'></i></button>
        </div>
        <h3 class="text-base border-b-lightGray border-b-2 mb-2">Para sua segurança sua senha deve conter:</h3>
        <ul class="flex flex-col gap-2">
            <li class="list-disc ml-4">Minimo de 8 caracteres.</li>
            <li class="list-disc ml-4">Ao menos um caractere especial. (*&@!#%)</li>
            <li class="list-disc ml-4">Ao menos um numero.</li>
        </ul>
    </dialog>
    <script type="module" src="/assets/js/finishRegistration.js" deffer></script>
</body>
