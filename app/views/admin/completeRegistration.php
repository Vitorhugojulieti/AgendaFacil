<main class="lg:w-5/6 w-full flex lg:absolute" style="left:17%; top:10%;">
    <?php echo flash('resultCompleteRegistration');  ?>
        <?php  require __DIR__ . '/../includes/nav.php'; ?>

        <div class="w-full min-h-screen flex flex-col justify-start items-start bg-bgPrincipal p-4 pl-8">
            <form action="/admin/signup/completeRegistration" method="post" enctype="multipart/form-data" id="formCompleteRegistration" class="bg-white w-5/6 md:w-full flex flex-col items-start justify-start gap-4 shadow shadow-borderFormColor p-2 rounded-lg ">
                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['token']; ?>">
                <legend id="legendForm" class="w-full font-Urbanist font-semibold text-black text-2xl md:text-3xl ">Concluir cadastro</legend>
                <input type="hidden" name="idNotification" id="id"  value="<?php echo isset($idNotification) ? $idNotification:'';?>">
                <!-- container data service -->
                <fieldset id="containerDataService" class="w-full  justify-start items-start">

                    <div id="containerDataImage" class=" w-full ">
                        <div class="w-full flex  items-center justify-around gap-4">
                            <div class="w-2/5 hover:cursor-pointer flex flex-col items-center justify-center p-4 gap-4 border-2 border-grayInput border-dashed rounded ">
                                <input type="file" name="logo" id="inputLogo" class="hidden">
                                <label for="inputLogo" class="flex flex-col items-center gap-2 pt-4 pb-4">
                                    <img id="previewLogo"  alt="logo" >
                                    <i class='bx bx-image text-4xl text-grayInput' id="iconLogo"></i>
                                    <span class="text-grayInput text-center hover:underline hover:cursor-pointer" id="spanLogo"><span class="font-semibold text-principal5">Insira</span> a logo da empresa </span>
                                </label>
                                <span class="text-errorColor " id="msgInputLogo"><?php echo flash('image1');  ?></span>
                            </div>

                            

                            <div class="w-2/5 hover:cursor-pointer flex flex-col items-center justify-center p-4 gap-4 border-2 border-grayInput border-dashed rounded ">
                                <input type="file" name="image" id="inputImage" class="hidden">
                                <label for="inputImage" class="flex flex-col items-center gap-2 pt-4 pb-4">
                                    <img id="previewImage"  alt="image" >
                                    <i class='bx bx-image text-4xl text-grayInput'  id="iconImage"></i>
                                    <span class="text-grayInput text-center hover:underline hover:cursor-pointer" id="spanImage"><span class="font-semibold text-principal5">Insira</span> a imagem da empresa aqui</span>
                                </label>
                                <span class="text-errorColor " id="msgInputImage"><?php echo flash('image1');  ?></span>
                            </div>
                        </div>
                    </div>
                </fieldset>

                <fieldset class="w-full flex flex-col gap-4">
                    <h2 class="w-full font-Urbanist font-semibold text-black text-xl md:text-2xl border-b-2 border-b-lightGray mb-4">Horario de funcionamento</h2>
                    <div class="w-full flex flex-col items-start gap-4">
                        <div class="w-full flex flex-col justify-start border border-lightGray rounded">
                            <div class="w-full border-b border-b-lightGray flex items-center justify-between p-2">
                                <span class="flex items-center gap-4 text-grayInput font-semibold text-base"><i class='bx bxs-info-circle'  ></i>Selecione os dias e adicione o horario desejado.</span>
                            </div>

                            <div class="w-full border-b border-b-lightGray flex items-center justify-between p-2" id="container-checkboxs">
                                <label for="inputDomingo" class="day flex items-center bg-principal5 text-white rounded">
                                    <span class="w-32  font-semibold p-2  text-center cursor-pointer hover:underline">Domingo</span>
                                    <input type="checkbox"  id="inputDomingo" class="check-day hidden" value="6">
                                </label >

                                <label for="inputSegunda" class="day flex items-center bg-principal5 text-white rounded">
                                    <span class="w-32  font-semibold p-2  text-center cursor-pointer hover:underline">Segunda-feira</span>
                                    <input type="checkbox"  id="inputSegunda" class="hidden" value="0">
                                </label >

                                <label for="inputTerca" class="day flex items-center bg-principal5 text-white rounded">
                                    <span class="w-32  font-semibold p-2  text-center cursor-pointer hover:underline">Terça-feira</span>
                                    <input type="checkbox"  id="inputTerca" class="hidden" value="1">
                                </label >

                                <label for="inputQuarta" class="day flex items-center bg-principal5 text-white rounded">
                                    <span class="w-32  font-semibold p-2  text-center cursor-pointer hover:underline">Quarta-feira</span>
                                    <input type="checkbox"  id="inputQuarta" class="hidden" value="2">
                                </label >

                                <label for="inputQuinta" class="day flex items-center bg-principal5 text-white rounded">
                                    <span class="w-32  font-semibold p-2  text-center cursor-pointer hover:underline">Quinta-feira</span>
                                    <input type="checkbox"  id="inputQuinta" class="hidden" value="3">
                                </label >

                                <label for="inputSexta" class="day flex items-center bg-principal5 text-white rounded">
                                    <span class="w-32  font-semibold p-2  text-center cursor-pointer hover:underline">Sexta-feira</span>
                                    <input type="checkbox"  id="inputSexta" class="hidden" value="4">
                                </label >

                                <label for="inputSabado" class="day flex items-center bg-principal5 text-white rounded">
                                    <span class="w-32  font-semibold p-2  text-center cursor-pointer hover:underline">Sabado</span>
                                    <input type="checkbox"  id="inputSabado" class="hidden" value="5">
                                </label >

                            </div>

                            <div class="w-full border-b border-b-lightGray flex flex-col items-start gap-4 p-2">
                                <button class="flex items-center gap-4 " id="btnAddHour">
                                    <i class='bx bx-plus text-principal10 text-xl'></i>
                                    <span class="hover:underline">Adicionar novo horario</span>
                                </button>
                            </div>

                            <div class="w-full" id="containerInputs">

                            </div>

                            


                        </div>
                    </div>

                    <div id="containerHours" class="w-full flex flex-col gap-4">
                        
                    </div>
                </fieldset>


                <div class="buttons mt-8 w-2/5 flex items-center gap-4">
                    <button type="submit" id="sendButton" class="w-2/4 bg-principal10 text-white font-Poppins font-semibold p-2 hover:cursor-pointer hover:underline">Concluir</button>
                    <a id="cancel" href="/admin/service" class="w-2/4 bg-white text-principal10 text-center font-Poppins font-semibold p-2 border-2 border-lightGray hover:cursor-pointer hover:underline">Cancelar</a>
                </div>
            </form>
        </div>
        <script type="module" src="/assets/js/completeRegistration.js" deffer></script>

    </main>

    <div class="message">
        <?php echo flash('reultInsertservice');  ?>
    </div>

    <!-- modal -->
    <dialog id="modalCep" class="w-2/4 bg-white text-black rounded p-4 ">
        <div class="w-full flex justify-between items-center mb-4">
            <div class="flex gap-4 items-center">
                <i class='bx bx-lock-alt text-2xl'></i>
                <h1 class="text-2xl font-semibold font-Urbanist">CEP</h1>
            </div>
            <button id="btnCloseModalCep" class="outline-none"><i class='bx bx-x-circle text-3xl'></i></button>
        </div>
        <h3 class="text-base border-b-lightGray border-b-2 mb-2">Para sua segurança sua senha deve conter:</h3>
        <ul class="flex flex-col gap-2">
            <li class="list-disc ml-4">Minimo de 8 caracteres.</li>
            <li class="list-disc ml-4">Ao menos um caractere especial. (*&@!#%)</li>
            <li class="list-disc ml-4">Ao menos um numero.</li>
        </ul>
    </dialog>
   