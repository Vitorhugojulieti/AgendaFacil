<body class="flex flex-col">
<?php require __DIR__ . '../../includes/nav.php'; ?>

    <div class="lg:w-5/6 w-full flex lg:absolute" style="left:17%; top:10%;">

        <main class="w-full flex flex-col p-4 gap-4 mb-8" style="background-color:#F8F8FF;">

            <section class="flex flex-col gap-4 bg-white p-4 border border-lightGray rounded-lg shadow shadow-borderFormColor">
                <h3 class="font-Urbanist font-semibold text-2xl  w-full pb-2 border-b border-lightGray">Detalhes do agendamento</h3>
                <div class="flex ">
                    <div class="w-2/4 flex flex-col p-4 gap-2">
                        <span class="font-Poppins font-bold">Horario agendado<span class="font-normal"><?php echo ' '.$schedule->getStartTime()->format('H:i') ?></span></span>
                        <span class="font-Poppins font-bold">Data do agendamento<span class="font-normal"><?php echo ' '.$schedule->getDateSchedule()->format('d/m/Y') ?></span></span>
                        <?php if($schedule->getStatus() == "cancelado"){?>
                            <span class="font-Poppins font-bold">Status<span class="font-normal text-sm p-1 rounded bg-errorColor text-white"><?php echo ' '.$schedule->getStatus() ?></span></span>
                        <?php }else if($schedule->getStatus() == "confirmado"){ ?>
                            <span class="font-Poppins font-bold">Status<span class="font-normal text-sm p-2 rounded bg-orange text-white"><?php echo ' '.$schedule->getStatus() ?></span></span>
                        <?php }else{ ?>
                            <span class="font-Poppins font-bold">Status<span class="font-normal text-sm p-2 rounded bg-sucessColor text-white"><?php echo ' '.$schedule->getStatus() ?></span></span>
                        <?php } ?>
                    </div>

                    <div class="w-2/4 p-4 flex flex-col gap-2">
                        <span class="font-Poppins font-bold">Valor total <span class="font-normal"><?php echo 'R$ '.number_format($schedule->getTotalPaid(), 2, ',', '.'); ?></span></span>
                        <span class="flex items-center gap-2 font-Poppins font-bold">Prazo para cancelamento até as <?php echo $schedule->getStartTime()->sub(new \DateInterval('PT1H'))->format('H:i')?><i class='bx bxs-info-circle text-2xl'></i></span>
                    </div>
                </div>

                <h3 class="font-Urbanist font-semibold text-xl  w-full pb-2 border-b border-lightGray">Serviços agendados</h3>
                
                <?php if(isset($orders) && count($orders) != 0){ ?>
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
                    <?php if($schedule->isCancellable()){?>
                        <button class="w-full bg-red text-white text-center font-Poppins font-normal p-2 rounded  hover:underline hover:cursor-pointer  "  id="btnOpenModalCancel">Cancelar</button>
                    <?php } ?>

                    <?php if($schedule->isComplete() && isset($_SESSION['collaborator'])){?>
                        <button class="w-full bg-sucessColor text-white text-center font-Poppins font-normal p-2 rounded  hover:underline hover:cursor-pointer  "  id="btnOpenModalComplete">Concluir</button>
                    <?php } ?>

                    <a href="<?php echo $linkBack; ?>" class="w-full border border-lightGray text-principal10 text-center font-Poppins font-semibold rounded p-2 hover:cursor-pointer hover:underline">Voltar</a>
                </div>
            </section>
       
        </main>
    </div>


    <dialog id="modalCancel" class="w-2/5 bg-white text-black rounded p-4 shadow-lg shadow-black ">
        <form action="<?php echo $actionCancel;?>" id="formCancel" method="post" class="w-full flex flex-col gap-4">
            <input type="number" class="hidden" name="idSchedule" value="<?php echo $schedule->getId();?>">
            <legend class="text-xl font-semibold font-Urbanist">Deseja cancelar o agendamento?</legend>

            <div class="w-full flex-col gap-4">
                <!-- <h2>Motivo do cancelamento</h2> -->
                <div class="w-full flex flex-col gap-2" id="containerRadiosReason">
                    <?php foreach ($reasons as $index => $reason) { ?>
                        <label for="inputReason<?php echo $index;?>" class="flex p-2 rounded border border-lightGray hover:bg-grayBg   hover:cursor-pointer" <?php echo $index == 1 ? 'checked' : ''?>>
                            <input type="radio" name="reason" id="inputReason<?php echo $index;?>" value="<?php echo $reason['value'];?>" class="hidden">
                            <span><?php echo $reason['label'];?></span>
                        </label>
                    <?php } ?>

                    <label for="inputmessage">
                        <span class="flex flex-col items-start ">Detalhes</span>
                        <textarea name="message" id="inputmessage" class="w-full border border-lightGray p-2 outline-none resize-none rounded"></textarea>
                    </label>
                    
                </div>
                <span class="text-red " id="msgFormCancel"></span>
            </div>

            <div class="buttons w-full flex  gap-4">
                <?php if($schedule->getStatus() != 'cancelado'){ ?>
                    <button type="submit"  class="w-full bg-red text-white text-base text-center border border-lightGray rounded p-2 hover:cursor-pointer hover:underline">Cancelar agendamento</button>
                <?php }?>
                <button id="btnCloseModalCancel" type="button" class="w-full border border-lightGray bg-white text-principal10 text-center text-base font-Poppins font-semibold rounded p-2 hover:cursor-pointer hover:underline">Descartar</button>
            </div>
        </form>
    </dialog>

    <dialog id="modalComplete" class="w-2/5 bg-white text-black rounded p-4 shadow-lg shadow-black ">
        <form action="<?php echo $actionComplete;?>" method="post" class="w-full flex flex-col gap-4">
            <input type="number" class="hidden" name="idSchedule" value="<?php echo $schedule->getId();?>">
            <legend class="text-xl font-semibold font-Urbanist">Concluir agendamento?</legend>

            <div class="buttons w-full flex  gap-4">
                <button type="submit"  class="w-full bg-sucessColor text-white text-base text-center border border-lightGray rounded p-2 hover:cursor-pointer hover:underline">Concluir</button>
                <button id="btnCloseModalComplete" type="button" class="w-full border border-lightGray bg-white text-principal10 text-center text-base font-Poppins font-semibold rounded p-2 hover:cursor-pointer hover:underline">Descartar</button>
            </div>
        </form>
    </dialog>
    <script type="module"  src="/assets/js/showSchedule.js"></script>

</body>