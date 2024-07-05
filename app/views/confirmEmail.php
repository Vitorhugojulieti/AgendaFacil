<body style="overflow:none;">
    <div class="w-full min-h-screen flex flex-col justify-center items-center bg-principal10">
        <form action="<?php echo $action; ?>" method="POST" id="formOtp" class="w-2/6 h-5/6 bg-white rounded p-4">
            <div class="w-full h-full flex flex-col gap-6 items-center">
                <div class="w-full h-1/3 flex flex-col items-center">
                    <i class='bx bx-envelope text-4xl' ></i>
                    <h2 class="text-xl font-semibold">Por favor verifique seu email.</h2>
                    <h3>Enviamos um código para <span class="font-semibold"><?php echo $emailSend;?></span></h3>
                </div>
                <div class="fields flex justify-around items-center gap-4">
                    <input type="number" name="field1" maxlength="1" class="otp-input w-14 h-14 p-2 border-2 border-borderFormColor text-2xl text-center font-semibold text-principal10 rounded outline-principal10 focus:shadow-lg shadow-black" >
                    <input type="number" name="field2" maxlength="1" class="otp-input w-14 h-14 p-2 border-2 border-borderFormColor text-2xl text-center font-semibold text-principal10 rounded outline-principal10 focus:shadow-lg shadow-black" >
                    <input type="number" name="field3" maxlength="1" class="otp-input w-14 h-14 p-2 border-2 border-borderFormColor text-2xl text-center font-semibold text-principal10 rounded outline-principal10 focus:shadow-lg shadow-black" >
                    <input type="number" name="field4" maxlength="1" class="otp-input w-14 h-14 p-2 border-2 border-borderFormColor text-2xl text-center font-semibold text-principal10 rounded outline-principal10 focus:shadow-lg shadow-black" >
                </div>
                <!-- <a href="/signup/confirmEmail/resend" class="bg-principal10 text-white font-semibold p-2 pl-4 pr-4 rounded hover:underline">Reenviar codigo</a> -->
                <div class="w-full flex flex-col items-center justify-center gap-4">
                    <button type="submit"  class="w-3/4 bg-principal10 text-white font-semibold p-2 pl-4 pr-4 rounded hover:underline">Verificar</button>
                    <a href="/signup/confirmEmail/resend" id="resendEmailBtn" class="w-3/4 text-center border-borderFormColor border-2 p-2 pl-4 pr-4 rounded font-semibold hover:underline">Reenviar codigo</a>
                    <span class="text-errorColor " id="msgNameError"><?php echo flash('confirmEmail');  ?></span>

                    <ul class="w-3/4 flex flex-col gap-2 text-start">
                        <h3>Não recebeu o codigo?</h3>
                        <li class="ml-6 list-disc text-sm ">Os codigos podem levar até 5 minutos para chegar</li>
                        <li class="ml-6 list-disc text-sm">Verifique a pasta de spam de seu e-mail</li>
                    </ul>
                </div>
            </div>
        </form>    
    </div>
    <script type="module" src="/assets/js/confirmEmail.js" deffer></script>
</body>
