    <main class="flex">
        <?php  require __DIR__ . '/../includes/nav.php'; ?>

        <div class="w-full min-h-screen flex flex-col justify-start items-start bg-white p-4">
            <form action="<?php echo $action;?>" method="post" enctype="multipart/form-data" id="formCadService" class="w-5/6 md:w-full flex flex-col items-start justify-start gap-4 ">
                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['token']; ?>">
                <legend id="legendForm" class="w-full font-Urbanist font-semibold text-black text-2xl md:text-3xl border-b-2 border-borderFormColor"><?php echo $legend; ?></legend>
                <input type="hidden" name="id" id="id" type="number" value="<?php echo isset($service) ? $service->getId():'';?>">
                <!-- container data service -->
                <fieldset id="containerDataService" class="w-full  justify-start items-start">

                   <div class="images flex items-start justify-around">
                        <div class="w-max flex flex-col gap-4 justify-start items-start">
                            <input type="file" name="image1" id="inputImage1" class="hidden">
                            <label for="inputImage1" class="hover:cursor-pointer w-4/5 flex flex-col items-center justify-center p-2">
                                <img id="previewImage1" src="<?php echo isset($service) ? '../../../'.$service->getImage(0) : IMAGE_DEFAULT?>"  alt="avatar" style="width:10rem; height:8rem;">
                            </label>
                            <span class="text-errorColor " id="msgImage1Error"><?php echo flash('image1');  ?></span>
                        </div>

                        <div class="w-max flex flex-col gap-4 justify-start items-start">
                            <input type="file" name="image2" id="inputImage2" class="hidden">
                            <label for="inputImage2" class="hover:cursor-pointer w-4/5 flex flex-col items-center justify-center p-2">
                                <img id="previewImage2" src="<?php echo isset($service) ? '../../../'.$service->getImage(1) : IMAGE_DEFAULT?>"  alt="avatar" style="width:10rem; height:8rem;">
                            </label>
                            <span class="text-errorColor " id="msgAvatarError"><?php echo flash('image2');  ?></span>
                        </div>

                        <div class="w-max flex flex-col gap-4 justify-start items-start">
                            <input type="file" name="image3" id="inputImage3" class="hidden">
                            <label for="inputImage3" class="hover:cursor-pointer w-4/5 flex flex-col items-center justify-center p-2">
                                <img id="previewImage3" src="<?php echo isset($service) ? '../../../'.$service->getImage(2) : IMAGE_DEFAULT?>"  alt="avatar" style="width:10rem; height:8rem;">
                            </label>
                            <span class="text-errorColor " id="msgAvatarError"><?php echo flash('image3');  ?></span>
                        </div>
                   </div>

                    <h2 class="w-full font-Urbanist font-semibold text-black text-xl md:text-2xl border-b-2 border-b-lightGray mb-4">Dados do serviço</h2>

                        <div class="w-full lg:grid lg:grid-rows-1 lg:grid-cols-2 gap-12 md:flex md:w-5/6 md:flex-col ">
                            <!-- column 1 -->
                            <div class="w-full col-span-1 row-span-1 col-start-1 flex flex-col items-start justify-center gap-4 ">
                                <!-- campo -->
                                <div class="field w-full focus-within:text-principal10 text-borderFormColor">
                                    <div>
                                        <label for="inputName" >Nome</label>
                                    </div>
                                    <div class="flex items-center border-2 border-borderFormColor rounded focus-within:border-principal10 focus-within:text-principal10">
                                        <i class='bx bx-rename' style=' padding-left:1rem; padding-right:1rem;'></i>
                                        <input type="text" name="name" id="inputName" value="<?php echo old('name') ?? (isset($service) ? $service->getName() : ''); ?>" class="w-full p-2 outline-none bg-transparent border-l-2 border-borderFormColor transition-all duration-300 focus:border-principal10 focus:text-black" placeholder="Digite nome do serviço">
                                    </div>
                                    <span class="text-errorColor " id="msgNameError"><?php echo flash('name');  ?></span>
                                </div>
                                <!-- campo -->
                                <div class="field w-full focus-within:text-principal10 text-borderFormColor">
                                    <label for="inputPrice" >Preço</label>
                                    <div class="flex items-center border-2 border-borderFormColor rounded focus-within:border-principal10 focus-within:text-principal10">
                                        <i class='bx bx-purchase-tag'  style='padding-left:1rem; padding-right:1rem;'></i>
                                        <input type="text" name="price" id="inputPrice" maxlength="14" value="<?php echo old('price') ?? (isset($service) ? $service->getPrice() : ''); ?>" class="w-full p-2 outline-none bg-transparent border-l-2 border-borderFormColor transition-all duration-300 focus:border-principal10 focus:text-black" placeholder="Digite o valor do serviço">
                                    </div>
                                    <span class="text-errorColor " id="msgPriceError"><?php echo flash('price');  ?></span>
                                </div>

                                <!-- campo -->
                                <div class="field w-full focus-within:text-principal10 text-borderFormColor">
                                    <div>
                                        <label for="inputDuration" >Duração</label>
                                    </div>
                                    <div class="flex items-center border-2 border-borderFormColor rounded focus-within:border-principal10 focus-within:text-principal10">
                                        <i class='bx bx-time-five' style='padding-left:1rem; padding-right:1rem;'></i>
                                        <input type="time" name="duration" id="inputDuration" value="<?php echo old('duration') ?? (isset($service) ? $service->getDuration() : ''); ?>" class="w-full p-2 outline-none bg-transparent border-l-2 border-borderFormColor transition-all duration-300 focus:border-principal10 focus:text-black" >
                                    </div>
                                    <span class="text-errorColor " id="msgDurationError"><?php echo flash('duration');  ?></span>
                                </div>

                            </div>

                            <!-- column 2 -->
                            <div class="w-full col-span-1 row-span-1 col-start-2 flex flex-col items-start justify-center gap-4 ">
                                <div  class="field w-full h-full focus-within:text-principal10 text-borderFormColor">
                                    <div>
                                        <label for="inputDescription" >Descrição</label>
                                        <i class='bx bxs-help-circle hover:text-principal10 hover:cursor-pointer' id="btnOpenModalPassword"></i>
                                    </div>
                                    <div class="h-5/6 flex items-center border-2 border-borderFormColor text-start rounded focus-within:border-principal10 focus-within:text-principal10">
                                        <textarea name="description" id="inputDescription" class="w-full h-full resize-none p-4 text-start" cols="1">
                                        <?php echo old('description') ?? (isset($service) ? $service->getDescription() : ''); ?>
                                        </textarea>
                                    </div>
                                    <span class="text-errorColor " id="msgDescriptionError"><?php echo flash('description');  ?></span>
                                </div>

                            </div>
                        </div>
                </fieldset>

                <div class="buttons mt-2 w-2/5 flex items-center gap-4">
                    <button type="submit" id="sendButton" class="w-2/4 bg-principal10 text-white font-Poppins font-semibold p-2 hover:cursor-pointer hover:underline">Cadastrar</button>
                    <a id="cancel" href="/admin/service" class="w-2/4 bg-white text-principal10 text-center font-Poppins font-semibold p-2 border-2 border-lightGray hover:cursor-pointer hover:underline">Cancelar</a>
                </div>
            </form>
        </div>
        <script type="module" src="/assets/js/formCadService.js" deffer></script>

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
   