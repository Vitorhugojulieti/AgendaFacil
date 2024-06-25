<body style="overflow:none;">
    <div class="w-full min-h-screen flex flex-col justify-center items-center bg-principal10 p-4 mb-4">
        <form action="" method="post" id="formFinishRegistration" class="w-3/5 flex flex-col items-center justify-center gap-4 ">
            <img src="/assets/images/logo-white.png" alt="logo">
            <legend class="font-Urbanist font-semibold text-white text-3xl">Finalize seu cadastro!</legend>
            <fieldset class="w-2/4 flex flex-col items-start justify-center gap-4 ">
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
                <div class="w-full">
                    <input type="submit" value="FINALIZAR" class="w-full bg-white text-principal10 font-Poppins font-semibold p-2 hover:cursor-pointer hover:underline">
                </div>
            </fieldset>
        </form>
    </div>
    <script type="module" src="/assets/js/finishRegistration.js" deffer></script>
</body>
