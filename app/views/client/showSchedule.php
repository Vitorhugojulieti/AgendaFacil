<body class="flex flex-col">
<?php require __DIR__ . '../../includes/nav.php'; ?>

    <div class="lg:w-5/6 w-full flex lg:absolute" style="left:17%; top:10%;">

        <main class="w-full flex flex-col p-4 gap-4 mb-8" style="background-color:#F8F8FF;">

            <section class="flex flex-col gap-4 bg-white p-4 border border-lightGray rounded-lg shadow shadow-borderFormColor">
                <h3 class="font-Urbanist font-semibold text-2xl  w-full pb-2 border-b border-lightGray">Detalhes do agendamento</h3>
                <div class="flex ">
                    <div class="w-2/4 flex flex-col p-4">
                        <span class="font-Poppins font-bold">Horario agendado<span class="font-normal"><?php echo ' '.$schedule->getStartTime()->format('H:i') ?></span></span>
                        <span class="font-Poppins font-bold">Data do agendamento<span class="font-normal"><?php echo ' '.$schedule->getDateSchedule()->format('d/m/Y') ?></span></span>
                    </div>

                    <div class="w-2/4 p-4 flex flex-col">
                        <span class="font-Poppins font-bold">Forma de pagamento <span class="font-normal"><?php echo $schedule->getStartTime()->format('H:i') ?></span></span>
                        <span class="font-Poppins font-bold">Total pago <span class="font-normal"><?php echo $schedule->getTotalPaid() ?></span></span>
                        <span class="flex items-center gap-2 font-Poppins font-bold">Prazo para cancelamento até as <?php echo $schedule->getStartTime()->sub(new \DateInterval('PT1H'))->format('H:i')?><i class='bx bxs-info-circle text-2xl'></i></span>
                    </div>
                </div>

                <h3 class="font-Urbanist font-semibold text-xl  w-full pb-2 border-b border-lightGray">Serviços agendados</h3>
                
                <?php if(count($orders) != 0){ ?>
                    <?php foreach ($orders as $order) {?>
                        <section class="acordion active service w-full bg-white p-2 border border-lightGray rounded-lg shadow shadow-borderFormColor " >
                                        <div class="col1 w-full flex  justify-start">
                                            <div class="circle bg-sucessColor text-white text-center w-6 h-6 rounded-full flex items-center justify-center">
                                                <i class='bx bx-check' style='color:#ffffff'  ></i>
                                            </div>
                                        </div>

                                        <div class="col2 w-full flex flex-col ml-4">
                                            <div class="details mr-8 pb-2 flex justify-between items-center gap-8 border-b border-b-lightGray box-border" id="services">
                                                <span class="flex items-center gap-4 font-Poppins text-lg">
                                                
                                                    <?php echo ucfirst($order->getService()->getName()); ?>
                                                </span>
                                                <span class="font-Poppins text-lg font-semibold"><?php echo 'R$ '.number_format($order->getService()->getPrice(), 2, ',', '.'); ?></span>
                                            </div>

                                            <div class="collaborators pt-2">
                                                <span class="font-Poppins text-lg pt-2">Colaborador selecionado</span>

                                                <div class="body w-full pt-4">
                                                    <div class="collaborators-service w-full flex gap-6">
                                                                <div class="collaborator-selection w-max flex gap-4 p-2">
                                                                    <label for="collaborator<?php echo $order->getCollaborator()->getId()?>" class="labelCollaborator flex flex-col items-center gap-2 hover:cursor-pointer" > 
                                                                        <img src="<?php echo IMAGES_DIR.$order->getCollaborator()->getAvatar()?>" alt="" class="collaborator redondShapeImageCollaborator  " style="width:5rem; height:5rem;">
                                                                        <input type="radio" name="collaborator[<?php echo $index?>]" value="<?php echo $order->getCollaborator()->getId()?>" id="collaborator<?php echo $order->getCollaborator()->getId()?>" class="hidden" >
                                                                        <span class="font-Poppins text-sm"><?php echo $order->getCollaborator()->getName()?></span>
                                                                    </label>
                                                                </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </section>
                    <?php } ?>
                                    
                <?php } ?>


                <div class="w-2/5 flex gap-4 p-4">
                    <?php if($schedule->getStatus() !== "Cancelado" && $schedule->getStatus() !== "Confirmado"){?>
                        <a href="#" class="w-full bg-red text-white text-center font-Poppins font-normal p-2 rounded  hover:underline hover:cursor-pointer  ">Cancelar</a>
                    <?php } ?>
                    <a href="/schedule" class="w-full border border-lightGray text-principal10 text-center font-Poppins font-semibold rounded p-2 hover:cursor-pointer hover:underline">Voltar</a>
                </div>
            </section>
       
        </main>
    </div>
    <script type="module"  src="/assets/js/showCompany.js"></script>

</body>