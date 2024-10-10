<main class="lg:w-5/6 w-full flex lg:absolute " style="left:17%; top:10%; ">
        <?php  require __DIR__ . '/../includes/nav.php'; ?>
        <?php echo flash('resultAddService');  ?>
        <?php echo flash('resultInsertVoucher');  ?>
        <?php echo flash('resultUpdateVoucher');  ?>
        <?php echo flash('resultDeleteVoucher');  ?>

        <div class="w-full min-h-screen flex flex-col justify-start items-start bg-bgPrincipal p-4 pl-8">
            <form action="<?php echo $action;?>" method="post" enctype="multipart/form-data" id="formCadVoucher" class="bg-white shadow shadow-borderFormColor p-2 rounded-lg w-5/6 md:w-full flex flex-col items-start justify-start gap-4 px-8">
                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['token']; ?>">
                <legend id="legendForm" class="w-full font-Urbanist font-semibold text-black text-2xl md:text-3xl mb-4"><?php echo $legend; ?></legend>
                
                <!-- container data service -->
                <fieldset id="containerData" class="w-full flex flex-col justify-start items-start ">

                        <div class="w-full lg:grid lg:grid-rows-1 lg:grid-cols-2 gap-12 md:flex  md:flex-col items-start justify-start ">
                            <!-- column 1 -->
                            <div class="w-full col-span-1 row-span-1 col-start-1 flex flex-col items-start justify-center gap-2 ">
                                <h2 class="w-full font-Urbanist font-semibold text-black text-xl md:text-2xl border-b border-b-lightGray mb-4">Dados do voucher</h2>
                                
                                <!-- campo -->
                                <div class="field w-full focus-within:text-principal10 text-grayInput ">
                                    <div>
                                        <label for="inputActive" >Ativo</label>
                                        <!-- TODO resolver problemas dos selects -->
                                    </div>
                                    <div class="flex items-center border-2 border-grayInput   rounded focus-within:border-principal10 focus-within:text-principal10 focus-within:bg-white" style="box-shadow:0 0 10px 5px rgb(0,0,0,0.02);">
                                        <i class='bx bx-rename' style=' padding-left:1rem; padding-right:1rem;'></i>
                                        <select name="active" id="inputActive"class="w-full p-2 outline-none bg-transparent border-l-2 border-grayInput transition-all duration-300 focus:border-principal10 focus:text-black placeholder:text-placeholder ">
                                            <option value=1   <?php echo isset($voucher) ? $voucher->getActive() === 1 ? 'selected' : '' : '' ?>>Habilitado</option>
                                            <option value=0   <?php echo isset($voucher) ? $voucher->getActive() === 0 ? 'selected' : '' : '' ?>>Desabilitado</option>
                                        </select>
                                    </div>
                                    <span class="text-red flex items-center" id="msgActiveError"><?php echo flash('active');  ?></span>
                                </div>
                                <!-- campo -->
                                <div class="field w-full focus-within:text-principal10 text-grayInput ">
                                    <div>
                                        <label for="inputName" >Nome</label>
                                    </div>
                                    <div class="flex items-center border-2 border-grayInput   rounded focus-within:border-principal10 focus-within:text-principal10 focus-within:bg-white" style="box-shadow:0 0 10px 5px rgb(0,0,0,0.02);">
                                        <i class='bx bx-rename' style=' padding-left:1rem; padding-right:1rem;'></i>
                                        <input type="text" name="name" id="inputName" value="<?php echo old('name') ?? (isset($voucher) ? $voucher->getName() : ''); ?>" class="w-full p-2 outline-none bg-transparent border-l-2 border-grayInput transition-all duration-300 focus:border-principal10 focus:text-black placeholder:text-placeholder " placeholder="Digite nome do serviço">
                                    </div>
                                    <span class="text-red flex items-center " id="msgNameError"><?php echo flash('name');  ?></span>
                                </div>
                               

                                  <!-- campo -->
                                <div class="field w-full focus-within:text-principal10 text-grayInput ">
                                    <div>
                                        <label for="inputDuration" >Duração</label>
                                    </div>
                                    <div class="flex items-center border-2 border-grayInput   rounded focus-within:border-principal10 focus-within:text-principal10 focus-within:bg-white" style="box-shadow:0 0 10px 5px rgb(0,0,0,0.02);">
                                        <i class='bx bx-rename' style=' padding-left:1rem; padding-right:1rem;'></i>
                                        <select name="duration" id="inputDuration"class="w-full p-2 outline-none bg-transparent border-l-2 border-grayInput transition-all duration-300 focus:border-principal10 focus:text-black placeholder:text-placeholder ">
                                            <option value="1"  <?php echo isset($voucher) ? $voucher->getDuration() === 1 ? 'selected' : '' : '' ?> >1 Semana após criação</option>
                                            <option value="10" <?php echo isset($voucher) ? $voucher->getDuration() === 10 ? 'selected' : '' : ''  ?> >1 Mês após criação</option>
                                            <option value="60"  <?php echo isset($voucher) ? $voucher->getDuration() === 60 ? 'selected' : '' : ''  ?> >6 Mêses após criação</option>
                                            <option value="100"  <?php echo isset($voucher) ? $voucher->getDuration() === 100 ? 'selected' : '' : ''  ?> >1 Ano após criação</option>
                                        </select>
                                    </div>
                                    <span class="text-red flex items-center" id="msgDurationError"><?php echo flash('duration');  ?></span>
                                </div>
                                <!-- campo -->
                                <div  class="field w-full h-full focus-within:text-principal10 text-grayInput">
                                    <div>
                                        <label for="inputDescription" >Descrição</label>
                                        <i class='bx bxs-help-circle hover:text-principal10 hover:cursor-pointer' id="btnOpenModalDescription"></i>
                                    </div>
                                    <div class="h-5/6 flex items-center border-2 border-grayInput text-start rounded focus-within:border-principal10 focus-within:text-principal10 focus-within:bg-white">
                                        <textarea name="description" id="inputDescription" class="w-full h-full resize-none p-4 text-start" cols="1">
                                        <?php echo trim(old('description') ?? (isset($voucher) ? $voucher->getDescription() : '')); ?>
                                        </textarea>
                                    </div>
                                    <span class="text-red flex items-center" id="msgDescriptionError"><?php echo flash('description');  ?></span>
                                </div>


                            </div>

                            <!-- column 2 -->
                            <div class="w-full col-span-1 row-span-1 col-start-2 flex flex-col items-start justify-center gap-4 ">
                            
                                <section class=" w-full flex flex-col gap-4 " >
                                    <h2 class="w-full font-Urbanist font-semibold text-black text-xl md:text-2xl border-b border-b-lightGray mb-4">Serviços selecionados</h2>

                                    <?php if($services != 0 && count($services) > 0){ ?>
                                        <div class="w-full flex flex-col gap-2" id="containerSelectedServices">
                                                <?php foreach ($services as $service) { ?>
                                                    <div class="w-full p-4 flex justify-between items-center border border-lightGray shadow shadow-borderFormColor  rounded-lg border-l-8 border-l-principal10">
                                                        <span class="amount w-1/6 flex justify-center items-center gap-3 font-Urbanist text-xl">
                                                            <a href="<?php echo $hrefRemove.$service->getId()?>" class="reload">-</a>
                                                            <input type="text" disabled  value="<?php echo $service->getAmount();?>" class="w-1/5 text-center border border-grayInput">
                                                            <a href="<?php echo $hrefAdd.$service->getId()?>" class="reload">+</a>
                                                        </span>
                                                        <span class="flex flex-col items-center gap-2 font-Urbanist text-xl"><?php echo $service->getName(); ?><span class="text-grayInput text-sm font-semibold"><?php echo $service->getDuration()->format('H:i').' minutos'; ?></span></span>
                                                        <span class="font-Poppins text-lg"><?php echo 'R$ '.$service->getPrice() * $service->getAmount(); ?></span>
                                                        <div class="buttons flex items-center gap-4">
                                                            <a href="<?php echo $hrefDelete.$service->getId()?>" class="reload bg-white text-principal10 font-Poppins p-2 rounded hover:underline"><i class='bx bx-trash text-2xl'></i></a>
                                                        </div>
                                                    </div>
                                                <?php } ?>
                                            
                                        </div>
                                   
                                    <?php }else{ ?>
                                            <div class="w-full  text-grayInput flex flex-col gap-2 items-center justify-center p-12" >
                                                <i class='bx bxs-info-circle text-4xl'></i>
                                                <span class="font-Urbanist font-semibold text-xl">Nenhum serviço selecionado!</span>
                                            </div>
                                        <?php } ?>

                                    <span id="msgErrorServices" class="text-red flex items-center"></span>
                                    <button type="button" class="reload font-Poppins font-normal flex items-center gap-2 p-4 pl-0 " id="btnOpenModalServices"><i class='bx bx-plus text-2xl' ></i><span class="hover:underline">Adicionar serviço</span></button>
                                        
                                    <div class="w-full " id="managerDiscount">
                                        <div class="w-full flex  gap-3 items-center">
                                            <h3 class="font-semibold">Aplicar desconto no total</h3>
                                            <span class="amount w-3/6 flex justify-center items-center gap-3 font-Urbanist text-xl">
                                                <button type="button" id="btnLessDiscount">-</button>
                                                <div class="w-1/5 flex"><input type="number" value=<?php echo isset($voucher) ? $voucher->getDiscount() : 0.00 ?> name="discount" class="w-full text-center " id="displayDiscount">%</div>    
                                                <button type="button" id="btnAddDiscount">+</button>
                                            </span>
                                        </div>

                                    </div>
                                </section>
                            </div>
                        </div>
                </fieldset>

                <div class="w-full flex flex-col items-start gap-3 ">
                    <h2  class="w-full font-Urbanist font-semibold text-black text-xl  border-b-2 border-b-lightGray mb-4">Valor total</h2>
                    <span  class="w-1/4 font-semibold font-Poppins text-2xl">R$<span id="displayAmount"> <?php echo $amountCart;?></span></span>
                </div>


                <div class="buttons mt-2 w-2/5 flex items-center gap-4">
                    <button type="submit" id="sendButton" class="w-2/4 bg-principal10 text-white font-Poppins font-semibold p-2 hover:cursor-pointer hover:underline"><?php echo $buttonText ?></button>
                    <a id="cancel" href="/admin/voucher" class="w-2/4 bg-white text-principal10 text-center font-Poppins font-semibold p-2 border-2 border-lightGray hover:cursor-pointer hover:underline">Cancelar</a>
                </div>

            </form>
        </div>
        <script type="module" src="/assets/js/formCadVoucher.js" deffer></script>

    </main>

   <!-- modal add services -->
   <dialog id="modalServices" class="w-2/4 bg-white text-black rounded p-4 shadow-lg shadow-black ">
        <div class="w-full flex justify-between items-center mb-4">
            <div class="flex gap-4 items-center">
                <h1 class="text-2xl font-semibold font-Urbanist">Adicionar serviço</h1>
            </div>
            <button id="btnCloseModalServices" class="outline-none"><i class='bx bx-x text-2xl text-lightGray'></i></button>
        </div>
        <div class="w-full flex flex-col gap-4">
            <?php foreach ($availableServices as $service) { ?>
                <div class="w-full p-4 flex justify-between items-center border border-lightGray rounded">
                    <span class="flex items-center gap-4 font-Poppins text-lg"><i class='bx bx-chevron-right text-3xl'></i><?php echo $service->getName(); ?></span>
                    <span class="font-Poppins text-lg"><?php echo 'R$ '.$service->getPrice(); ?></span>
                    <div class="buttons flex items-center gap-4">
                        <a href="<?php echo $hrefAdd.$service->getId()?>" class="text-white bg-principal10 font-Poppins border border-lightGray p-2 rounded hover:underline">Adicionar</a>
                    </div>
                </div>
            <?php }?>
        </div>
    </dialog>

    

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

   