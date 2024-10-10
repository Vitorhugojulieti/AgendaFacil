<body class="flex flex-col ">
<?php require __DIR__ . '../../includes/nav.php'; ?>

    <div class="lg:w-5/6 w-full flex lg:absolute" style="left:17%; top:10%;">

        <main class="w-full h-full flex flex-col gap-8 p-4"  style="background-color:#F8F8FF;">
            <legend >
                <h2 class="font-Urbanist font-semibold text-4xl text-black w-full  p-2">Agendar serviços</h2>
            </legend>
            <form action="/schedule/store"  method="POST" class="flex flex-col gap-4" >

            <section class="acordion active check w-full bg-white p-4 border border-lightGray rounded-lg shadow shadow-borderFormColor flex flex-col gap-4" id="sectionData">
                    <legend class="flex items-center gap-4">
                        <div class="circle bg-sucessColor text-white text-center w-6 h-6 rounded-full flex items-center justify-center">
                            <i class='bx bx-check' style='color:#ffffff'  ></i>
                        </div>
                        <span class="font-Urbanist font-semibold text-xl">Selecionar data e horario</span>
                    </legend>

                    <div class="body w-full border-t border-t-lightGray flex gap-4 pt-4">
                        <div class="w-2/4" id="containerCalendar"></div>

                        <section class="bg-white w-2/4 flex flex-col gap-2 border border-lightGray shadow-sm shadow-black rounded-md p-2 " id="times">
                            <h2 class="font-Urbanist font-semibold text-xl text-black w-full" id="legendTimes"></h2>
                            <div class="w-full  max-h-60 flex flex-col gap-4 p-2 overflow-y-auto " id="containerTimes">
                    
                            </div>
                        </section>
                    </div>
                </section>

                        <?php if(count($services) !== 0){ ?>
                            <?php foreach ($services as $service) { ?>
                                <section class="acordion active service w-full bg-white p-4 border border-lightGray rounded-lg shadow shadow-borderFormColor " >
                                    <div class="col1 w-full flex  justify-start">
                                        <div class="circle bg-sucessColor text-white text-center w-6 h-6 rounded-full flex items-center justify-center">
                                            <i class='bx bx-check' style='color:#ffffff'  ></i>
                                        </div>
                                    </div>

                                    <div class="col2 w-full flex flex-col ml-4">
                                        <div class="details mr-8 pb-2 flex justify-between items-center gap-8 border-b border-b-lightGray box-border" id="services">
                                            <span class="flex items-center gap-4 font-Poppins text-lg">
                                               
                                                <?php echo $service->getName(); ?>
                                            </span>
                                            <span class="font-Poppins text-lg font-semibold"><?php echo 'R$ '.$service->getPrice(); ?></span>
                                        </div>

                                        <div class="collaborators">
                                            <span class="font-Poppins text-lg pt-2">Colaboradores</span>

                                            <div class="body w-full  flex gap-4 pt-4">
                                                <div class="w-full flex ">
                                                    <?php if(count($service->getCollaborators()) !== 0){ ?>
                                                        <?php foreach ($service->getCollaborators() as $collaborator) {?>
                                                            <div class="w-full flex gap-4 p-2">
                                                                <label for="collaborator<?php echo $collaborator->getId()?>" class="labelCollaborator flex flex-col items-center gap-2"> 
                                                                    <img src="<?php echo '../../'.$collaborator->getAvatar()?>" alt="" class="collaborator redondShapeImageCollaborator  " style="width:5rem; height:5rem;">
                                                                    <input type="checkbox" name="collaborators[]" value="<?php echo $collaborator->getId()?>" id="collaborator<?php echo $collaborator->getId()?>" value="<?php echo $collaborator->getId()?>" class="hidden">
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
                                        <a href="/schedule/removeToCart/<?php echo $service->getId()?>" class="bg-white text-principal10 font-Poppins hover:underline"><i class='bx bx-trash text-2xl'></i></a>
                                    </div>
                                </section>
                            <?php } ?>
                        <?php } ?>

                        <?php if(count($servicesCompany) > 0){?>
                            <button type="button" class="font-Poppins font-normal flex items-center gap-4 p-4 pl-0" id="btnOpenModalServices"><i class='bx bx-plus text-2xl' ></i>Adicionar serviço</button>
                        <?php }?>

               

              

               
                <div class="buttons w-3/6 flex gap-4 mb-4">
                    <button type="submit" class=" bg-principal10 text-white font-Poppins font-semibold rounded p-2 hover:cursor-pointer hover:underline">Confirmar</button>
                    <a href="/" class="border border-lightGray text-principal10 font-Poppins font-semibold rounded p-2 hover:cursor-pointer hover:underline">Voltar</a>
                </div>
            </form>
        </main>
    </div>

    <!-- modal add services -->
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
                        <a href="/schedule/store/<?php echo $service->getId()?>" class="text-white bg-principal10 font-Poppins border border-lightGray p-2 rounded hover:underline">Adicionar</a>
                    </div>
                </div>
            <?php }?>
        </div>
    </dialog>
    <?php echo flash('resultInsertSchedule');  ?>

    <script type="module"  src="/assets/js/storeSchedule.js"></script>

</body>