<body class="flex flex-col">
    <div class="w-full h-screen flex">
        <?php require __DIR__ . '../../includes/nav.php'; ?>

        <main class="w-full flex flex-col p-4 gap-4 mb-8">
            <h2 class="font-Urbanist font-semibold text-4xl text-black w-full border-b-2 border-b-lightGray p-2">Detalhes do agendamento</h2>

            <!-- collaborator date -->
            <?php if($schedule->getStatus() === "Confirmado"){?>
                <div class="w-full p-4 rounded bg-principal10 flex items-center">
                    <div class="point w-full flex flex-col items-center justify-center text-white">
                        <div class="bullet schedule first complete">
                            <span><i class='bx bx-time text-3xl text-white'></i></span>
                        </div>
                        <span >aguardando pagamento</span>
                    </div>

                    <div class="point w-full flex flex-col items-center justify-center text-white">
                        <div class="bullet schedule complete">
                            <span><i class='bx bx-like text-3xl text-white'></i></span>
                        </div>
                        <span >Pagamento confirmado</span>
                    </div>

                    <div class="point w-full flex flex-col items-center justify-center text-white">
                        <div class="bullet schedule last complete">
                            <span><i class='bx bxs-check-circle text-3xl text-white'></i></span>
                        </div>
                        <span>Agendamento concluido</span>
                    </div>
                </div>
            <?php }else if($schedule->getStatus() === "Aguardando pagamento"){ ?>
                <div class="w-full p-4 rounded bg-principal10 flex items-center">
                    <div class="point w-full flex flex-col items-center justify-center text-white">
                        <div class="bullet schedule first complete">
                            <span><i class='bx bx-time text-3xl text-white'></i></span>
                        </div>
                        <span >aguardando pagamento</span>
                    </div>

                    <div class="point w-full flex flex-col items-center justify-center text-white">
                        <div class="bullet schedule">
                            <span><i class='bx bx-like text-3xl text-white'></i></span>
                        </div>
                        <span >Pagamento confirmado</span>
                    </div>

                    <div class="point w-full flex flex-col items-center justify-center text-white">
                        <div class="bullet schedule last ">
                            <span><i class='bx bxs-check-circle text-3xl text-white'></i></span>
                        </div>
                        <span>Agendamento concluido</span>
                    </div>
                </div>
            <?php }else if($schedule->getStatus() === "Cancelado"){ ?>
                <div class="w-full p-4 rounded bg-principal10 flex items-center">
                    <div class="point w-full flex flex-col items-center justify-center text-white">
                        <div class="bullet schedule first last">
                            <span><i class='bx bx-error-circle text-3xl text-errorColor'></i></i></span>
                        </div>
                        <span class="text-errorColor" >Cancelado</span>
                    </div>
                </div>
            <?php } ?>


            <section class="w-full border border-lightGray shadow-sm shadow-black rounded-md flex flex-col">
                <h3 class="font-Urbanist font-normal text-xl text-white bg-principal10 w-full p-2 rounded">Detalhes do agendamento</h3>
                <div class="flex ">
                    <div class="w-2/4 flex flex-col p-4">
                        <span class="font-Poppins font-bold">Horario <span class="font-normal"><?php echo $schedule->getStartTime()->format('H:i') ?></span></span>
                        <span class="font-Poppins font-bold">Data <span class="font-normal"><?php echo $schedule->getDateSchedule()->format('d/m/Y') ?></span></span>
                    </div>

                    <div class="w-2/4 border-l border-lightGray p-4 flex flex-col">
                        <span class="font-Poppins font-bold">Forma de pagamento <span class="font-normal"><?php echo $schedule->getStartTime()->format('H:i') ?></span></span>
                        <span class="font-Poppins font-bold">Total pago <span class="font-normal"><?php echo $schedule->getDateSchedule()->format('d/m/Y') ?></span></span>
                        <span class="flex items-center gap-2 font-Poppins font-bold">Prazo para cancelamento até as <?php echo $schedule->getStartTime()->sub(new \DateInterval('PT1H'))->format('H:i')?><i class='bx bxs-info-circle text-2xl'></i></span>
                    </div>
                </div>
            </section>

            <section class="w-full border border-lightGray shadow-sm shadow-black rounded-md flex flex-col">
                <h3 class="font-Urbanist font-normal text-xl text-white bg-principal10 w-full p-2 rounded">Serviços agendados</h3>
                    <?php if(count($schedule->getServices()) !== 0){ ?>
                        <?php foreach ($schedule->getServices() as $service) { ?>
                            <div class="w-full p-4 flex  items-center border border-lightGray rounded">
                                <span class="flex flex-1 items-center gap-4 font-Poppins text-lg"><i class='bx bx-chevron-right text-3xl'></i><?php echo $service->getName(); ?></span>
                                <span class="flex-1 font-Poppins text-lg"><span class="font-Poppins font-bold"><?php echo 'Valor R$ '.$service->getPrice(); ?></span></span>
                            </div>
                        <?php } ?>
                    <?php } ?>
            </section>

            <section class="w-full border border-lightGray shadow-sm shadow-black rounded-md flex flex-col items-start">
                <h3 class="font-Urbanist font-normal text-xl text-white bg-principal10 w-full p-2 rounded">Colaboradores</h3>
                    <?php if(count($schedule->getCollaborators()) !== 0){ ?>
                        <?php foreach ($schedule->getCollaborators() as $collaborator) {?>
                            <div class="p-4" >
                                <label for="collaborator<?php echo $collaborator->getId()?>" class=" flex flex-col items-center"> 
                                    <img src="<?php echo $collaborator->getAvatar()?>" alt="" class="collaborator redondShapeImageCollaborator  ">
                                    <span><?php echo $collaborator->getName()?></span>
                                </label>
                            </div>
                        <?php } ?>
                    <?php } ?>
            </section>

            <div class="w-2/5 flex gap-4">
                <?php if($schedule->getStatus() !== "Cancelado" && $schedule->getStatus() !== "Confirmado"){?>
                    <a href="#" class="w-full bg-red text-white text-center font-Poppins font-normal p-2 rounded  hover:underline hover:cursor-pointer  ">Cancelar</a>
                <?php } ?>
                <a href="/schedule" class="w-full border border-lightGray text-principal10 text-center font-Poppins font-semibold rounded p-2 hover:cursor-pointer hover:underline">Voltar</a>
            </div>
        </main>
    </div>
    <script type="module"  src="/assets/js/showCompany.js"></script>

</body>