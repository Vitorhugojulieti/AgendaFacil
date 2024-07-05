<body style="overflow:none;">
    <div class="w-full min-h-screen flex flex-col justify-center items-center bg-principal10 p-4 mb-4">
        <form action="/signup/chooseAvatar" method="post" enctype="multipart/form-data" id="formFinishRegistration" class="w-3/5 flex flex-col items-center justify-center gap-4 ">
            <img src="/assets/images/logo-white.png" alt="logo">
            <legend class="font-Urbanist font-semibold text-white text-3xl">Selecione seu avatar</legend>
            <fieldset class="w-2/4 flex flex-col items-start justify-center gap-4 ">
                <input type="file" name="avatar">
                <div class="w-full text-center">
                    <input type="submit" value="FINALIZAR" class="w-full bg-white text-principal10 font-Poppins font-semibold p-2 mb-4 hover:cursor-pointer hover:underline">
                    <a href="/" class="text-white underline">Pular esta etapa</a>
                    <span class="text-errorColor " id="msgNameError"><?php echo flash('chooseAvatar');  ?></span>
                </div>
            </fieldset>
        </form>
    </div>
    <script type="module" src="/assets/js/finishRegistration.js" deffer></script>
</body>
