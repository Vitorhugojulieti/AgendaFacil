<body class="flex flex-col">
    <div class="w-full h-screen flex">
        <?php require __DIR__ . '../../includes/nav.php'; ?>

        <main class="w-full h-full flex flex-col gap-8 p-4"  style="background-color:#F8F8FF;">
            <legend >
                <h2 class="font-Urbanist font-semibold text-4xl text-black w-full border-b-2 border-b-lightGray p-2">Agendar serviços</h2>
            </legend>
            <form action="/schedule/store"  method="POST" class="flex flex-col gap-4" >
                <div class="w-full flex flex-col gap-4 lg:flex-row">
                    <section class="w-full lg:w-2/4 flex flex-col gap-4" id="containerCalendar">
                        
                        <!-- <table id="calendar" class="w-2/4">
                            O calendário será gerado aqui pelo JavaScript
                        </table> -->
                    </section>
                    <section class="bg-white w-full lg:w-2/4 flex flex-col gap-2 border border-lightGray shadow-sm shadow-black rounded-md p-2 ">
                        <h2 class="font-Urbanist font-semibold text-xl text-black w-full" id="legendTimes"></h2>
                        <div class="w-full  max-h-60 flex flex-col gap-4 p-2 overflow-y-scroll " id="containerTimes">
                    
                        </div>
                    </section>
                </div>

                <section class="bg-white w-full flex flex-col gap-4 border border-lightGray shadow-sm shadow-black rounded-md p-2">
                    <h2 class="font-Urbanist font-semibold text-xl text-black w-full">Colaboradores disponiveis</h2>
                    <div class="w-full flex ">
                        <?php if(count($collaborators) !== 0){ ?>
                            <?php foreach ($collaborators as $collaborator) {?>
                                <div class="w-full flex gap-4 p-2">
                                    <label for="collaborator<?php echo $collaborator->getId()?>" class=" flex flex-col items-center gap-2"> 
                                        <img src="<?php echo '../'.$collaborator->getAvatar()?>" alt="" class="collaborator redondShapeImageCollaborator  " style="width:5rem; height:5rem;">
                                        <input type="checkbox" name="collaborators[]" value="<?php echo $collaborator->getId()?>" id="collaborator<?php echo $collaborator->getId()?>" value="<?php echo $collaborator->getId()?>" class="hidden">
                                        <span class="font-Poppins text-sm"><?php echo $collaborator->getName()?></span>
                                    </label>
                                </div>
                            <?php } ?>
                        <?php } ?>
                    </div>
                </section>

                <section class="bg-white w-full flex flex-col gap-4 border border-lightGray shadow-sm shadow-black rounded-md p-2">
                    <h2 class="font-Urbanist font-semibold text-xl text-black w-full">Serviços selecionados</h2>
                    <?php if(count($services) !== 0){ ?>
                        <?php foreach ($services as $service) { ?>
                            <div class="w-full p-4 flex justify-between items-center border border-lightGray rounded">
                                <span class="flex items-center gap-4 font-Poppins text-lg"><i class='bx bx-chevron-right text-3xl'></i><?php echo $service->getName(); ?></span>
                                <span class="font-Poppins text-lg"><?php echo 'R$ '.$service->getPrice(); ?></span>
                                <div class="buttons flex items-center gap-4">
                                    <a href="/schedule/removeToCart/<?php echo $service->getId()?>" class="bg-white text-principal10 font-Poppins p-2 rounded hover:underline"><i class='bx bx-trash text-2xl'></i></a>
                                </div>
                            </div>
                        <?php } ?>
                    <?php } ?>
                    <button type="button" class="font-Poppins font-normal flex items-center gap-4 p-4 pl-0" id="btnOpenModalServices"><i class='bx bx-plus text-2xl' ></i>Adicionar outro serviço</button>
                </section>
                
                
                <section class="w-full flex flex-col border-t-2 border-lightGray p-4 pl-0">
                    <span class="font-Poppins text-xl">Total</span>
                    <span class="font-Poppins font-bold text-3xl">R$ <?php echo $amount ?></span>
                </section>

                <div class="buttons w-3/6 flex gap-4 mb-4">
                    <button type="submit" class="bg-principal10 text-white font-Poppins font-semibold rounded p-2 hover:cursor-pointer hover:underline">Ir para pagamento</button>
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
    <script type="module"  src="/assets/js/storeSchedule.js"></script>

</body>