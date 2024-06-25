<body style="overflow:none;">
    <div class="w-full min-h-screen flex flex-col justify-center items-center bg-principal10 p-4 mb-4">
        <form action="" method="post" id="formCadClient" class="w-3/5 flex flex-col items-center justify-center gap-8 ">
            <img src="/assets/images/logo-white.png" alt="logo" >
            <legend class="font-Urbanist font-semibold text-white text-3xl">Bem vindo a plataforma!</legend>
            <fieldset class="w-5/6 lg:grid lg:grid-rows-1 lg:grid-cols-2 gap-8 md:flex md:flex-col">
                <!-- container 1 -->
                <div class="w-full col-span-1 row-span-1 col-start-1 flex flex-col items-start justify-center gap-4 ">
                    <!-- campo -->
                    <div class="field w-full focus-within:text-white text-borderFormColor">
                        <label for="inputName" >Nome</label>
                        <div class="flex items-center border-2 border-borderFormColor rounded focus-within:border-white focus-within:text-white ">
                            <i class='bx bx-user' style=' padding-left:1rem; padding-right:1rem;'></i>
                            <input type="text" name="name" id="inputName" class="w-full p-2 outline-none bg-transparent border-l-2 border-borderFormColor transition-all duration-300 focus:bg-white focus:border-white focus:text-black" placeholder="Digite seu nome completo">
                        </div>
                        <span class="text-errorColor " id="msgNameError"></span>
                    </div>
                    <!-- campo -->
                    <div class="field w-full focus-within:text-white text-borderFormColor">
                        <label for="inputPhone" >Telefone</label>
                        <div class="flex items-center border-2 border-borderFormColor rounded focus-within:border-white focus-within:text-white">
                            <i class='bx bx-phone' style='padding-left:1rem; padding-right:1rem; '></i>
                            <input type="text" name="phone" id="inputPhone" maxlength="15" class="w-full p-2 outline-none bg-transparent border-l-2 border-borderFormColor transition-all duration-300 focus:bg-white focus:border-white focus:text-black" placeholder="Digite seu nome completo">
                        </div>
                        <span class="text-errorColor " id="msgPhoneError"></span>
                    </div>
                    <!-- campo -->
                    <div class="field w-full focus-within:text-white text-borderFormColor">
                        <label for="inputCpf" >CPF</label>
                        <div class="flex items-center border-2 border-borderFormColor rounded focus-within:border-white focus-within:text-white">
                            <i class='bx bx-id-card' style='padding-left:1rem; padding-right:1rem;'></i>
                            <input type="text" name="cpf" id="inputCpf" maxlength="14" class="w-full p-2 outline-none bg-transparent border-l-2 border-borderFormColor transition-all duration-300 focus:bg-white focus:border-white focus:text-black" placeholder="Digite seu nome completo">
                        </div>
                        <span class="text-errorColor " id="msgCpfError"></span>
                    </div>
                </div>
                <!-- container 2 -->
                <div class="w-full col-span-2 row-span-1 col-start-2 flex flex-col items-start justify-center gap-4">
                    <!-- campo -->
                    <div class="field w-full focus-within:text-white text-borderFormColor">
                        <div>
                            <label for="inputEmail" >Email</label>
                            <i class='bx bxs-help-circle hover:text-white hover:cursor-pointer' id="btnOpenModalEmail" ></i>
                        </div>
                        <div class="flex items-center border-2 border-borderFormColor rounded focus-within:border-white focus-within:text-white">
                            <i class='bx bx-envelope' style='padding-left:1rem; padding-right:1rem;' ></i>
                            <input type="text" name="email" id="inputEmail" class="w-full p-2 outline-none bg-transparent border-l-2 border-borderFormColor transition-all duration-300 focus:bg-white focus:border-white focus:text-black" placeholder="Digite seu nome completo">
                        </div>
                        <span class="text-errorColor " id="msgEmailError"></span>
                    </div>
                    <!-- campo -->
                    <div class="field w-full focus-within:text-white text-borderFormColor">
                        <div>
                            <label for="inputPassword" >Senha</label>
                            <i class='bx bxs-help-circle hover:text-white hover:cursor-pointer' id="btnOpenModalPassword"></i>
                        </div>
                        <div class="flex items-center border-2 border-borderFormColor rounded focus-within:border-white focus-within:text-white">
                            <i class='bx bx-lock-alt' style='padding-left:1rem; padding-right:1rem; ' ></i>
                            <input type="password" name="password" id="inputPassword" class="w-full p-2 outline-none bg-transparent border-l-2 border-borderFormColor transition-all duration-300 focus:bg-white focus:border-white focus:text-black" placeholder="Digite seu nome completo">
                            <i class="fa-regular fa-eye pl-2 pr-2" id="btnNotViewPassword" style="display:none;"></i>
                            <i class="fa-regular fa-eye-slash pl-2 pr-2" id="btnViewPassword"></i>
                        </div>
                        <span class="text-errorColor " id="msgPasswordError"></span>
                    </div>
                    <div class="field w-full focus-within:text-white text-borderFormColor">
                        <div>
                            <label for="inputPassword" >Confirmar senha</label>
                        </div>
                        <div class="flex items-center border-2 border-borderFormColor rounded focus-within:border-white focus-within:text-white">
                            <i class='bx bx-lock-alt' style='padding-left:1rem; padding-right:1rem; ' ></i>
                            <input type="password" name="password" id="inputConfirmPassword" class="w-full p-2 outline-none bg-transparent border-l-2 border-borderFormColor transition-all duration-300 focus:bg-white focus:border-white focus:text-black" placeholder="Digite seu nome completo">
                            <i class="fa-regular fa-eye pl-2 pr-2" id="btnNotViewConfirmPassword" style="display:none;"></i>
                            <i class="fa-regular fa-eye-slash pl-2 pr-2" id="btnViewConfirmPassword"></i>
                        </div>
                        <span class="text-errorColor " id="msgConfirmPasswordError"></span>
                    </div>
                </div>
               
            </fieldset>
            <div class="w-2/4">
                <input type="submit" value="CADASTRAR" class="w-full bg-white text-principal10 font-Poppins font-semibold p-2 hover:cursor-pointer hover:underline">
                <a href="#" class="text-white hover:underline">Já possui uma conta? <span class="font-semibold">Fazer login</span></a>
            </div>
        </form>
    </div>

    <!-- modais -->
    <dialog id="modalEmail" class="w-2/4 bg-white text-black rounded p-4">
        <div class="w-full flex justify-between items-center mb-4">
            <div class="flex gap-4 items-center">
                <i class='bx bx-envelope text-2xl' ></i>
                <h1 class="text-2xl font-semibold font-Urbanist">modal teste email</h1>
            </div>
            <button id="btnCloseModalEmail" class="outline-none"><i class='bx bx-x-circle text-3xl'></i></button>
        </div>
        <p class="font-Poppins">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Optio, corrupti. Perspiciatis nostrum, atque provident velit voluptatem ea praesentium quae, deserunt sed esse reprehenderit unde vero harum. Inventore praesentium deserunt nostrum.</p>
    </dialog>

    <dialog id="modalPassword" class="w-2/4 bg-white text-black rounded p-4 ">
        <div class="w-full flex justify-between items-center mb-4">
            <div class="flex gap-4 items-center">
                <i class='bx bx-lock-alt text-2xl'></i>
                <h1 class="text-2xl font-semibold font-Urbanist">Proteção da senha</h1>
            </div>
            <button id="btnCloseModalPassword" class="outline-none"><i class='bx bx-x-circle text-3xl'></i></button>
        </div>
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Asperiores dolorem mollitia commodi repudiandae natus molestias beatae deleniti, cum voluptatibus odit, nostrum aut eos. Excepturi ipsum a vero fuga veniam eos?</p>
    </dialog>

    <script type="module" src="/assets/js/formCadClient.js" deffer></script>
</body>
