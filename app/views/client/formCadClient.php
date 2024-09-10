<body style="overflow:none;">
    <div class="w-full min-h-screen flex flex-col justify-center items-center bg-principal10 p-4 ">
        <form action="signup/store" method="POST"  id="formCadClient" class="w-4/5 md:w-3/5 flex flex-col items-center justify-center gap-8 ">
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['token']; ?>">
            <a href="/"><img src="/assets/images/logo-white.png" alt="logo" ></a>
            <legend class="font-Urbanist font-semibold text-white text-2xl md:text-3xl">Bem vindo a plataforma!</legend>
            <fieldset class="w-full lg:grid lg:grid-rows-1 lg:grid-cols-2 gap-8 md:flex md:w-5/6 md:flex-col ">
                <!-- container 1 -->
                <div class="w-full col-span-1 row-span-1 col-start-1 flex flex-col items-start justify-center gap-1 ">
                    <!-- campo -->
                    <div class="field w-full focus-within:text-white text-lightGrayInput">
                        <label for="inputName" >Nome</label>
                        <div class="flex items-center border-2 border-lightGrayInput rounded focus-within:border-white focus-within:text-white ">
                            <i class='bx bx-user' style=' padding-left:1rem; padding-right:1rem;'></i>
                            <input type="text" name="name" id="inputName" value="<?php echo old('name') ?>" class="w-full p-2 outline-none bg-transparent border-l-2 border-lightGrayInput transition-all duration-300 focus:bg-white focus:border-white focus:text-black" placeholder="Digite seu nome completo">
                        </div>
                        <span class="text-errorColor " id="msgNameError"><?php echo flash('name');  ?></span>
                    </div>
                    <!-- campo -->
                    <div class="field w-full focus-within:text-white text-lightGrayInput">
                        <label for="inputPhone" >Telefone</label>
                        <div class="flex items-center border-2 border-lightGrayInput rounded focus-within:border-white focus-within:text-white">
                            <i class='bx bx-phone' style='padding-left:1rem; padding-right:1rem; '></i>
                            <input type="text" name="phone" id="inputPhone" maxlength="15" value="<?php echo old('phone') ?>" class="w-full p-2 outline-none bg-transparent border-l-2 border-lightGrayInput transition-all duration-300 focus:bg-white focus:border-white focus:text-black" placeholder="Digite seu nome completo">
                        </div>
                        <span class="text-errorColor " id="msgPhoneError"><?php echo flash('phone');  ?></span>
                    </div>
                    <!-- campo -->
                    <div class="field w-full focus-within:text-white text-lightGrayInput">
                        <label for="inputCpf" >CPF</label>
                        <div class="flex items-center border-2 border-lightGrayInput rounded focus-within:border-white focus-within:text-white">
                            <i class='bx bx-id-card' style='padding-left:1rem; padding-right:1rem;'></i>
                            <input type="text" name="cpf" id="inputCpf" maxlength="14" value="<?php echo old('cpf') ?>" class="w-full p-2 outline-none bg-transparent border-l-2 border-lightGrayInput transition-all duration-300 focus:bg-white focus:border-white focus:text-black" placeholder="Digite seu nome completo">
                        </div>
                        <span class="text-errorColor " id="msgCpfError"><?php echo flash('cpf');  ?></span>
                    </div>
                </div>
                <!-- container 2 -->
                <div class="w-full col-span-2 row-span-1 col-start-2 flex flex-col items-start justify-center gap-1">
                    <!-- campo -->
                    <div class="field w-full focus-within:text-white text-lightGrayInput">
                        <div>
                            <label for="inputEmail" >Email</label>
                        </div>
                        <div class="flex items-center border-2 border-lightGrayInput rounded focus-within:border-white focus-within:text-white">
                            <i class='bx bx-envelope' style='padding-left:1rem; padding-right:1rem;' ></i>
                            <input type="text" name="email" id="inputEmail" value="<?php echo old('email') ?>" class="w-full p-2 outline-none bg-transparent border-l-2 border-lightGrayInput transition-all duration-300 focus:bg-white focus:border-white focus:text-black" placeholder="Digite seu email completo">
                        </div>
                        <span class="text-errorColor " id="msgEmailError"><?php echo flash('email');  ?></span>
                    </div>
                    <!-- campo -->
                    <div class="field w-full focus-within:text-white text-lightGrayInput">
                        <div>
                            <label for="inputPassword" >Senha</label>
                            <i class='bx bxs-help-circle hover:text-white hover:cursor-pointer' id="btnOpenModalPassword"></i>
                        </div>
                        <div class="flex items-center border-2 border-lightGrayInput rounded focus-within:border-white focus-within:text-white">
                            <i class='bx bx-lock-alt' style='padding-left:1rem; padding-right:1rem; ' ></i>
                            <input type="password" name="password" id="inputPassword" value="<?php echo old('password') ?>" class="w-full p-2 outline-none bg-transparent border-l-2 border-lightGrayInput transition-all duration-300 focus:bg-white focus:border-white focus:text-black" placeholder="Digite seu nome completo">
                            <i class="fa-regular fa-eye pl-2 pr-2" id="btnNotViewPassword" style="display:none;"></i>
                            <i class="fa-regular fa-eye-slash pl-2 pr-2" id="btnViewPassword"></i>
                        </div>
                        <span class="text-errorColor " id="msgPasswordError"><?php echo flash('password');  ?></span>
                    </div>
                    <div class="field w-full focus-within:text-white text-lightGrayInput">
                        <div>
                            <label for="inputPassword" >Confirmar senha</label>
                        </div>
                        <div class="flex items-center border-2 border-lightGrayInput rounded focus-within:border-white focus-within:text-white">
                            <i class='bx bx-lock-alt' style='padding-left:1rem; padding-right:1rem; ' ></i>
                            <input type="password" name="password" id="inputConfirmPassword" class="w-full p-2 outline-none bg-transparent border-l-2 border-lightGrayInput transition-all duration-300 focus:bg-white focus:border-white focus:text-black" placeholder="Digite seu nome completo">
                            <i class="fa-regular fa-eye pl-2 pr-2" id="btnNotViewConfirmPassword" style="display:none;"></i>
                            <i class="fa-regular fa-eye-slash pl-2 pr-2" id="btnViewConfirmPassword"></i>
                        </div>
                        <span class="text-errorColor " id="msgConfirmPasswordError"></span>
                    </div>
                </div>
               
            </fieldset>
            <div class="w-full md:w-2/4">
                <input type="submit" value="CADASTRAR" class="w-full bg-white text-principal10 font-Poppins font-semibold p-2 hover:cursor-pointer hover:underline">
                <a href="/login" class="text-white hover:underline">Já possui uma conta? <span class="font-semibold">Fazer login</span></a>
            </div>
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

    <script type="module" src="/assets/js/formCadClient.js" deffer></script>
</body>
