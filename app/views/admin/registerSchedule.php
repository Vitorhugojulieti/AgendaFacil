<?php echo flash('resultInsertSchedule');  ?>

<main class="lg:w-5/6 w-full flex lg:absolute " style="left:17%; top:10%; ">
        <?php  require __DIR__ . '/../includes/nav.php'; ?>


        <section class="w-full min-h-screen flex flex-col justify-start items-start bg-bgPrincipal p-4 pl-8">
            <form action="/admin/schedule/store" method="post" class="bg-white shadow shadow-borderFormColor p-2 rounded-lg w-5/6 md:w-full flex flex-col items-start justify-start gap-6 px-8">
                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['token']; ?>">
                <input type="hidden" name="date" id="inputDate">
                <legend class="w-full font-Urbanist font-semibold text-black text-2xl md:text-3xl ">Cadastrar novo agendamento</legend>


                <fieldset id="fieldsetSearchClient" class="w-full flex flex-col gap-2 border-t border-t-lightGrayInput pt-4">
                    <?php if(!isset($client)){?>
                        <h3 class="font-Urbanist font-semibold text-black text-xl">Selecionar cliente</h3>
                        <div class="w-full flex items-center gap-4 relative">
                            <div class="field w-full focus-within:text-principal10 text-grayInput ">
                                <div class="flex items-center border-2 border-grayInput   rounded focus-within:border-principal10 focus-within:text-principal10 focus-within:bg-white" style="box-shadow:0 0 10px 5px rgb(0,0,0,0.02);">
                                    <i class='bx bx-search'  style=' padding-left:1rem; padding-right:1rem;'></i>
                                    <div class="relative w-full">
                                        <input id="inputSearchClient" type="text" placeholder="Digite para buscar..." class="w-full p-2 outline-none bg-transparent border-l-2 border-borderFormColor transition-all duration-300 focus:border-principal10 focus:text-black" />
                                    </div>
                                </div>
                            </div>

                           

                            <div id="listClients" class="w-11/12 bg-white rounded-b-md shadow-sm shadow-black p-2 hidden flex-col gap-4 absolute z-10" style="top:110%; left:2%;">
                                <div class="client w-full flex items-center gap-4 border-b border-lightGray p-2">
                                    <img src="<?php echo AVATAR_DEFAULT?>" alt="img-cliente" class="redondShapeImageCollaborator">
                                    <div class="w-full flex justify-between items-center">
                                        <span>Nome: Cliente Padrão</span>
                                        <span>telefone:(xx)xxxxx-xxxx</span>
                                        <a href="/admin/schedule/store/client/default" class="bg-principal10 text-white text-sm p-2 rounded">Selecionar</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php }else{ ?>

                        <div class="w-full hidden items-center gap-4 relative">
                            <div  class=" flex  search w-full  items-center bg-white  rounded focus-within:shadow-sm focus-within:shadow-black focus-within:border-grayInput shadow shadow-borderFormColor">
                                <input type="text" id="inputSearchClient" class="w-full ml-2 outline-none bg-transparent p-2 placeholder:text-placeholder" placeholder="Digite o telefone do cliente buscado">
                                <i class='bx bx-search p-2  text-principal10 cursor-pointer'></i>
                            </div>
                            <i class='bx bxs-help-circle text-2xl hover:text-principal10 hover:cursor-pointer' id="btnOpenModalPassword"></i>

                            <div id="listClients" class="w-11/12 bg-white rounded-b-md shadow-sm shadow-black p-2 hidden flex-col gap-4 absolute z-10" style="top:110%; left:2%;">
                                <div class="client w-full flex items-center gap-4 border-b border-lightGray p-2">
                                    <img src="<?php echo AVATAR_DEFAULT?>" alt="img-cliente" class="redondShapeImageCollaborator">
                                    <div class="w-full flex justify-between items-center">
                                        <span>Nome: Cliente Padrão</span>
                                        <span>telefone:(xx)xxxxx-xxxx</span>
                                        <a href="/admin/schedule/store/client/default" class="bg-principal10 text-white text-sm p-2 rounded">Selecionar</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- visible -->
                        <h3 class="font-Urbanist font-semibold text-black text-xl">Cliente selecionado</h3>
                        <div class="client w-full flex items-center gap-4 border-b border-lightGray p-2">
                            <img src="<?php echo $client->getAvatar()?>" alt="img-cliente" class="redondShapeImageCollaborator">
                            <div class="w-full flex justify-between items-center">
                                <span>Nome: <?php echo $client->getName()?></span>
                                <span>telefone:<?php echo $client->getPhone()?></span>
                                <a href="/admin/schedule/store/client/remove/<?php echo $client->getId()?>" class="bg-principal10 text-white text-sm p-2 rounded">Remover</a>
                                <input type="hidden" name="client" value="<?php echo $client->getId();?>">
                            </div>
                        </div>
                    <?php } ?>
                </fieldset>

       

                

                <fieldset id="fieldsetServices" class="w-full flex flex-col gap-4">
                    <h3 class="font-Urbanist font-semibold text-black text-xl">Selecionar serviços</h3>
                    <?php if(count($services) != 0){ ?>

                        <?php foreach ($services as $index => $service) { ?>
                                    <section class="acordion active service w-full bg-white p-2 border border-lightGray rounded-lg shadow shadow-borderFormColor " >
                                        <div class="col1 w-full flex  justify-start">
                                            <div class="circle bg-sucessColor text-white text-center w-6 h-6 rounded-full flex items-center justify-center">
                                                <i class='bx bx-check' style='color:#ffffff'  ></i>
                                            </div>
                                        </div>

                                        <div class="col2 w-full flex flex-col ml-4">
                                            <div class="details mr-8 pb-2 flex justify-between items-center gap-8 border-b border-b-lightGray box-border" id="services">
                                                <span class="flex items-center gap-4 font-Poppins text-lg">
                                                
                                                    <?php echo ucfirst($service->getName()); ?>
                                                </span>
                                                <span class="font-Poppins text-lg font-semibold"><?php echo 'R$ '.number_format($service->getPrice(), 2, ',', '.'); ?></span>
                                            </div>

                                            <div class="collaborators pt-2">
                                                <span class="font-Poppins text-lg pt-2">Colaboradores disponiveis</span>

                                                <div class="body w-full pt-4">
                                                    <div class="collaborators-service w-full flex gap-6">
                                                        <?php if(count($service->getCollaborators()) !== 0){ ?>
                                                            <?php foreach ($service->getCollaborators() as $indexCollaborator => $collaborator) {?>
                                                                <div class="collaborator-selection w-max flex gap-4 p-2" data-service-index="<?php echo $index; ?>">
                                                                    <label for="collaborator<?php echo $collaborator->getId()?>" class="labelCollaborator flex flex-col items-center gap-2 hover:cursor-pointer <?php echo $indexCollaborator == 0 ? 'collaborator-selected' : ''?>" onclick="selectCollaborator(<?php echo $index; ?>, <?php echo $collaborator->getId(); ?>)"> 
                                                                        <img src="<?php echo IMAGES_DIR.$collaborator->getAvatar()?>" alt="" class="collaborator redondShapeImageCollaborator  " style="width:5rem; height:5rem;">
                                                                        <input type="radio" name="collaborator[<?php echo $index?>]" value="<?php echo $collaborator->getId()?>" id="collaborator<?php echo $collaborator->getId()?>" class="hidden"  <?php echo $indexCollaborator == 0 ? 'checked' : ''?>>
                                                                        <span class="font-Poppins text-sm"><?php echo $collaborator->getName()?></span>
                                                                    </label>
                                                                </div>
                                                            <?php } ?>  
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col3 w-full flex justify-start">
                                            <a href="/admin/schedule/removeToCart/<?php echo $service->getId()?>" class="bg-white text-lightGray hover:underline"><i class='bx bx-x text-3xl'></i></a>
                                        </div>
                                    </section>
                                <?php } ?>
                            <?php } ?>

                            <?php if(count($servicesCompany) > 0){?>
                                <button type="button" class="font-Poppins font-normal flex items-center gap-4 p-4 pl-0" id="btnOpenModalServices"><i class='bx bx-plus text-2xl' ></i>Adicionar serviço</button>
                            <?php }?>
                </fieldset>

                <fieldset id="fieldsetDate" class="w-full flex flex-col gap-4">
                    <h3 class="font-Urbanist font-semibold text-black text-xl">Selecionar data e horario</h3>
                    <div class="w-full flex flex-col gap-4 ">
                        <div id="calendar" class="w-full"></div>
                      
                        <section class="flex flex-col gap-2">
                            <h2 class="font-Urbanist font-semibold text-xl text-black w-full" id="legendTimes"></h2>

                            <div class="bg-white w-full flex flex-col gap-2 border border-lightGray  rounded-md p-2 ">
                                <div class="w-full  max-h-60 flex flex-col gap-4 p-2  " id="containerTimes"></div>
                            </div>
                        </section>
                    </div>
                </fieldset>

                <section class="acordion active check w-full flex flex-col gap-4" id="sectionData">
                    <span  class="flex items-center gap-4 text-grayInput"><i class='bx bx-message-detail text-2xl'  ></i>Adicionar observação para empresa (opcional)</span>
                    <textarea name="message" id="inputMessage" class="w-full h-full resize-none p-4 text-start border-2 border-grayInput rounded focus-within:border-principal10 focus-within:text-principal10" cols="1">
                    </textarea>
                </section>

              

                <section class="acordion active check w-full  flex flex-col gap-4 mt-4 " id="sectionData">
                        <legend class="w-full font-Urbanist font-semibold text-black text-xl  border-b border-b-lightGray">Finalizar agendamento</legend>
                        
                        <div class="flex flex-col items-start gap-1">
                            <span class="font-Urbanist font-semibold  flex items-end gap-2">
                                <span class="text-base ">Total</span>
                                <span class="text-2xl font-bold"><?php echo 'R$ '.number_format($amount, 2, ',', '.');?></span>
                            </span>
                            <span class="font-Urbanist font-semibold text-base text-grayInput">Duração <?php echo $totalDuration;?></span>
                        </div>

                </section>

                
                <div class="buttons w-3/6 flex gap-4 mb-4 mt-8">
                        <button type="submit" class=" bg-principal10 text-white font-Poppins font-semibold rounded p-2 hover:cursor-pointer hover:underline">Confirmar</button>
                        <button type="button" id="btnOpenModalCancel" class="border border-lightGray bg-white text-principal10 font-Poppins font-semibold rounded p-2 hover:cursor-pointer hover:underline">cancelar</button>
                </div>
            </form>
        </section>


        <dialog id="modalServices" class="w-2/4 bg-white text-black rounded p-4 shadow-lg shadow-black ">
            <div class="w-full flex justify-between items-center mb-4">
                <div class="flex gap-4 items-center">
                    <h1 class="text-2xl font-semibold font-Urbanist">Adicionar serviço</h1>
                </div>
                <button id="btnCloseModalServices" class="outline-none"><i class='bx bx-x text-2xl text-lightGray'></i></button>
            </div>
            <div class="w-full flex flex-col gap-4">
                <?php foreach ($servicesCompany as $service) { ?>
                    <div class="w-full p-4 flex justify-between items-center border border-lightGray rounded">
                        <span class="flex items-center gap-4 font-Poppins text-lg"><i class='bx bx-chevron-right text-3xl'></i><?php echo $service->getName(); ?></span>
                        <span class="font-Poppins text-lg"><?php echo 'R$ '.$service->getPrice(); ?></span>
                        <div class="buttons flex items-center gap-4">
                            <a href="/admin/schedule/store/<?php echo $service->getId()?>" class="text-white bg-principal10 font-Poppins border border-lightGray p-2 rounded hover:underline">Adicionar</a>
                        </div>
                    </div>
                <?php }?>
            </div>
        </dialog>

    <dialog id="modalCancel" class="w-2/5 bg-white text-black rounded p-4 shadow-lg shadow-black ">
        <div class="w-full flex justify-between items-center mb-4">
            <div class="flex gap-4 items-center">
                <h1 class="text-2xl font-semibold font-Urbanist">Descartar agendamento?</h1>
            </div>
        </div>
        <div class="w-full flex flex-col gap-4">
            <p>Você tem certeza de querer abortar o processo de agendamento? Mudanças não salvas serão perdidas</p>
            <div class="buttons w-full flex flex-col gap-4">
                <button type="button" id="btnCloseModalCancel" class="bg-principal10 text-white text-center border border-lightGray rounded p-2 hover:cursor-pointer hover:underline">Concluir agendamento</button>
                <a href="/admin/schedule" class="border border-lightGray bg-white text-principal10 text-center font-Poppins font-semibold rounded p-2 hover:cursor-pointer hover:underline">Descartar</a>
            </div>
        </div>
    </dialog>

       

    <script src='/assets/js/dist/index.global.min.js'></script>
    <script src='/assets/js/dist/locales-all.global.min.js'></script>
    <script type="module"  src="/assets/js/registerSchedule.js" defer></script>

</main>