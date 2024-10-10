    <main class="lg:w-5/6 w-full flex lg:absolute" style="left:17%; top:10%;">
    <?php echo flash('resultInsertService');  ?>
    <?php echo flash('resultUpdateService');  ?>
    <?php echo flash('reultDeleteService');  ?>
        <?php  require __DIR__ . '/../includes/nav.php'; ?>

        <div class="w-full min-h-screen flex flex-col justify-start items-start bg-bgPrincipal p-4 pl-8">
            <form action="<?php echo $action;?>" method="post" enctype="multipart/form-data" id="formCadService" class="bg-white w-5/6 md:w-full flex flex-col items-start justify-start gap-4 shadow shadow-borderFormColor p-2 rounded-lg">
                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['token']; ?>">
                <legend id="legendForm" class="w-full font-Urbanist font-semibold text-black text-2xl md:text-3xl mb-4"><?php echo $legend; ?></legend>
                <input type="hidden" name="id" id="id" type="number" value="<?php echo isset($service) ? $service->getId():'';?>">
                <!-- container data service -->
                <fieldset id="containerDataService" class="w-full  justify-start items-start">

                   <div class="images w-full flex items-start justify-between mb-8">
                        <div class="w-1/4 hover:cursor-pointer flex flex-col items-center justify-center  ">
                            <input type="file" name="image1" id="inputImage1" class="hidden">
                            <label for="inputImage1" class="flex flex-col items-center p-4 gap-4 border-2 border-grayInput border-dashed rounded">
                                <img id="previewImage1"  alt="imagem1" src="<?php echo isset($service) ? '../../../'.$service->getImage(0) : ''?>">
                                <i class='bx bx-image text-4xl text-grayInput' id="iconImage1"></i>
                                <span class="text-grayInput hover:underline hover:cursor-pointer" id="spanImage1"><span class="font-semibold text-principal5">Insira</span> a foto do serviço aqui</span>
                            </label>
                            <span class="text-errorColor " id="msgInputImage1"><?php echo flash('image1');  ?></span>
                        </div>

                        <div class="w-1/4 hover:cursor-pointer flex flex-col items-center justify-center  ">
                            <input type="file" name="image2" id="inputImage2" class="hidden">
                            <label for="inputImage2" class="flex flex-col items-center p-4 gap-4 border-2 border-grayInput border-dashed rounded">
                                <img id="previewImage2"  alt="imagem2" src="<?php echo isset($service) ? '../../../'.$service->getImage(1) : ''?>">
                                <i class='bx bx-image text-4xl text-grayInput' id="iconImage2"></i>
                                <span class="text-grayInput hover:underline hover:cursor-pointer" id="spanImage2"><span class="font-semibold text-principal5">Insira</span> a foto do serviço aqui</span>
                            </label>
                            <span class="text-errorColor " id="msgInputImage2"><?php echo flash('image2');  ?></span>
                        </div>

                        
                        <div class="w-1/4 hover:cursor-pointer flex flex-col items-center justify-center  ">
                            <input type="file" name="image3" id="inputImage3" class="hidden">
                            <label for="inputImage3" class="flex flex-col items-center p-4 gap-4 border-2 border-grayInput border-dashed rounded">
                                <img id="previewImage3"  alt="imagem3" src="<?php echo isset($service) ? '../../../'.$service->getImage(2) : ''?>">
                                <i class='bx bx-image text-4xl text-grayInput' id="iconImage3"></i>
                                <span class="text-grayInput hover:underline hover:cursor-pointer" id="spanImage3"><span class="font-semibold text-principal5">Insira</span> a foto do serviço aqui</span>
                            </label>
                            <span class="text-errorColor " id="msgInputImage3"><?php echo flash('image3');  ?></span>
                        </div>

                   </div>

                    <h2 class="w-full font-Urbanist font-semibold text-black text-xl md:text-2xl border-b-2 border-b-lightGray mb-4">Dados do serviço</h2>

                        <div class="w-full lg:grid lg:grid-rows-1 lg:grid-cols-2 gap-12 md:flex md:w-5/6 md:flex-col ">
                            <!-- column 1 -->
                            <div class="w-full col-span-1 row-span-1 col-start-1 flex flex-col items-start justify-center gap-2 ">
                                 <!-- campo -->
                                 <div class="field w-full focus-within:text-principal10 text-grayInput ">
                                    <div>
                                        <label for="inputActive" >Ativo</label>
                                    </div>
                                    <div class="flex items-center border-2 border-grayInput   rounded focus-within:border-principal10 focus-within:text-principal10 focus-within:bg-white" style="box-shadow:0 0 10px 5px rgb(0,0,0,0.02);">
                                        <i class='bx bx-rename' style=' padding-left:1rem; padding-right:1rem;'></i>
                                        <select name="visible" id="inputActive"class="w-full p-2 outline-none bg-transparent border-l-2 border-grayInput transition-all duration-300 focus:border-principal10 focus:text-black placeholder:text-placeholder ">
                                            <option value=1  <?php if (isset($service) && $service->getVisible() === 1) echo 'selected'; ?>>Habilitado</option>
                                            <option value=0  <?php if (isset($service) && $service->getVisible() === 0) echo 'selected'; ?>>Desabilitado</option>
                                        </select>
                                    </div>
                                    <span class="text-errorColor " id="msgVisibleError"><?php echo flash('visible');  ?></span>
                                </div>
                                <!-- campo -->
                                <div class="field w-full focus-within:text-principal10 text-grayInput ">
                                    <div>
                                        <label for="inputName" >Nome</label>
                                    </div>
                                    <div class="flex items-center border-2 border-grayInput   rounded focus-within:border-principal10 focus-within:text-principal10 focus-within:bg-white" style="box-shadow:0 0 10px 5px rgb(0,0,0,0.02);">
                                        <i class='bx bx-rename' style=' padding-left:1rem; padding-right:1rem;'></i>
                                        <input type="text" name="name" id="inputName" value="<?php echo old('name') ?? (isset($service) ? $service->getName() : ''); ?>" class="w-full p-2 outline-none bg-transparent border-l-2 border-grayInput transition-all duration-300 focus:border-principal10 focus:text-black placeholder:text-placeholder " placeholder="Digite nome do serviço">
                                    </div>
                                    <span class="text-errorColor " id="msgNameError"><?php echo flash('name');  ?></span>
                                </div>
                                <!-- campo -->
                                <div class="field w-full focus-within:text-principal10 text-grayInput">
                                    <div>
                                        <label for="inputPrice" >Preço</label>
                                    </div>
                                    <div class="flex items-center border-2 border-grayInput rounded focus-within:border-principal10 focus-within:text-principal10 focus-within:bg-white">
                                        <i class='bx bx-purchase-tag'  style='padding-left:1rem; padding-right:1rem;'></i>
                                        <input type="text" name="price" id="inputPrice" maxlength="14" value="<?php echo old('price') ?? (isset($service) ? $service->getPrice() : ''); ?>" class="w-full p-2 outline-none bg-transparent border-l-2 border-grayInput transition-all duration-300 focus:border-principal10 focus:text-black" placeholder="Digite o valor do serviço">
                                    </div>
                                    <span class="text-errorColor " id="msgPriceError"><?php echo flash('price');  ?></span>
                                </div>

                                <!-- campo -->
                                <div class="field w-full focus-within:text-principal10 text-grayInput">
                                    <div>
                                        <label for="inputDuration" >Duração</label>
                                    </div>
                                    <div class="flex items-center border-2 border-grayInput rounded focus-within:border-principal10 focus-within:text-principal10 focus-within:bg-white">
                                        <i class='bx bx-time-five' style='padding-left:1rem; padding-right:1rem;'></i>
                                        <input type="time" name="duration" id="inputDuration" value="<?php echo old('duration') ?? (isset($service) ? $service->getDuration()->format('H:i') : ''); ?>" class="w-full p-2 outline-none bg-transparent border-l-2 border-grayInput transition-all duration-300 focus:border-principal10 focus:text-black" >
                                    </div>
                                    <span class="text-errorColor " id="msgDurationError"><?php echo flash('duration');  ?></span>
                                </div>

                            </div>

                            <!-- column 2 -->
                            <div class="w-full col-span-1 row-span-1 col-start-2 flex flex-col items-start justify-center gap-4 ">
                                <div  class="field w-full h-full focus-within:text-principal10 text-grayInput">
                                    <div>
                                        <label for="inputDescription" >Descrição</label>
                                        <i class='bx bxs-help-circle hover:text-principal10 hover:cursor-pointer' id="btnOpenModalPassword"></i>
                                    </div>
                                    <div class="h-5/6 flex items-center border-2 border-grayInput text-start rounded focus-within:border-principal10 focus-within:text-principal10 focus-within:bg-white">
                                        <textarea name="description" id="inputDescription" class="w-full h-full resize-none p-4 text-start" cols="1">
                                        <?php echo trim(old('description') ?? (isset($service) ? $service->getDescription() : '')); ?>
                                        </textarea>
                                    </div>
                                    <span class="text-errorColor " id="msgDescriptionError"><?php echo flash('description');  ?></span>
                                </div>

                            </div>
                        </div>
                </fieldset>

                <div class="buttons mt-2 w-2/5 flex items-center gap-4">
                    <button type="submit" id="sendButton" class="w-2/4 bg-principal10 text-white font-Poppins font-semibold p-2 hover:cursor-pointer hover:underline"><?php echo $buttonText ?></button>
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
   