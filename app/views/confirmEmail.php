<body style="overflow:none;">
    <div class="w-full min-h-screen flex flex-col justify-center items-center bg-principal10">
        <form action="" method="post" id="formOtp" class="w-2/6 h-5/6 bg-white rounded p-4">
            <div class="w-full h-full flex flex-col gap-6 items-center">
                <div class="w-full h-1/3 flex flex-col items-center">
                    <i class='bx bx-envelope text-4xl' ></i>
                    <h2 class="text-xl font-semibold">Por favor verifique seu email.</h2>
                    <h3>Enviamos um código para <span class="font-semibold">olivia@untitledui.com</span></h3>
                </div>
                <div class="fields flex justify-around items-center gap-4">
                    <input type="number" maxlength="1" class="otp-input w-14 h-14 p-2 border-2 border-borderFormColor text-2xl text-center font-semibold text-principal10 rounded outline-principal10 focus:shadow-lg shadow-black" >
                    <input type="number" maxlength="1" class="otp-input w-14 h-14 p-2 border-2 border-borderFormColor text-2xl text-center font-semibold text-principal10 rounded outline-principal10 focus:shadow-lg shadow-black" >
                    <input type="number" maxlength="1" class="otp-input w-14 h-14 p-2 border-2 border-borderFormColor text-2xl text-center font-semibold text-principal10 rounded outline-principal10 focus:shadow-lg shadow-black" >
                    <input type="number" maxlength="1" class="otp-input w-14 h-14 p-2 border-2 border-borderFormColor text-2xl text-center font-semibold text-principal10 rounded outline-principal10 focus:shadow-lg shadow-black" >
                </div>
                <h3>Não recebeu um código? <a href="" class="underline">Clique para reenviar</a></h3>
                <div class="w-full flex items-center justify-center gap-4">
                    <a href="" class="border-borderFormColor border-2 p-2 pl-4 pr-4 rounded font-semibold hover:underline">Cancelar</a>
                    <button type="submit"  class="bg-principal10 text-white font-semibold p-2 pl-4 pr-4 rounded hover:underline">Verificar</button>
                </div>
            </div>
        </form>    
    </div>
    <script type="module" src="/assets/js/confirmEmail.js" deffer></script>
</body>
