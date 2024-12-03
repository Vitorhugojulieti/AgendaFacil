<main class="lg:w-5/6 w-full flex lg:absolute" style="left:17%; top:10%;">
    <?php require __DIR__ . '/../includes/nav.php'; ?>
    <!-- crud flash messages -->
    <?php echo flash('resultInsertService');  ?>
    <?php echo flash('resultUpdateService');  ?>

    <div class="w-full min-h-screen flex flex-col justify-start items-start bg-bgPrincipal p-4 ">

        <div class="w-full  bg-bgPrincipal ">
            <div class="w-full flex items-center justify-between py-4">
                <div class="w-full flex flex-col items-start">
                    <h2 class="text-principal10 text-3xl font-Urbanist font-semibold">Notificações</h2>
                </div>
              
            </div>
            <?php if(count($notifications) !== 0 ){ ?>
            <table class="w-full bg-white shadow shadow-borderFormColor p-2 rounded-lg">
                <thead class="bg-white p-4  border-b-2 border-lightGray  ">
                    <tr >
                        <th class="font-Urbanist font-semibold text-grayInput text-start p-2">Mensagem</th>
                        <th class="font-Urbanist font-semibold text-grayInput text-center p-2">Data</th>
                        <th class="font-Urbanist font-semibold text-grayInput text-center p-2">Visualizada</th>
                        <th class="font-Urbanist font-semibold text-grayInput text-center p-2">Ação</th>
                    </tr>
                </thead>
                <tbody>
                        <?php foreach ($notifications as $notification) { ?>
                            <tr class="row even:bg-grayBg">
                                <!-- collaborator image -->
                                <td class="p-2 ">
                                    <div class="flex items-center gap-2">
                                        <div class="w-full flex flex-col">
                                            <h3 class="font-semibold"><?php echo $notification->getMessage();?></h3>
                                        </div>
                                    </div>
                                </td>
                             
                                <!-- collaborator date -->
                                <td class="p-2 text-center">
                                    <span><?php echo $notification->getDate()->format('d-m-Y');?></span>
                                </td>

                                <?php if($notification->getNotified() == 1){ ?>
                                    <td class="p-2 text-center">
                                        <span class="bg-sucessColor text-white rounded p-1">Sim</span>
                                    </td>
                                <?php }else{ ?>
                                    <td class="p-2 text-center">
                                        <span class="bg-errorColor text-white rounded p-1">Não</span>
                                    </td>
                                <?php } ?>
                                

                           
                                <!-- collaborator actions -->
                                <td class="flex items-center justify-center gap-4 p-2 text-center">
                                    <a  class="hover:underline" href="<?php echo IMAGES_DIR.$notification->getLink();?>">Detalhes</a>
                                    <a class="hover:underline" href="/admin/notification/markNotified/<?php echo $notification->getId();?>" >Marcar como lida</a>
                                </td>
                            </tr> 
                        <?php } ?> 
                </tbody>
            </table>
       

            <?php }else{ ?>
                    <div class="w-full  text-grayInput flex flex-col gap-2 items-center justify-center p-12" >
                        <i class='bx bxs-info-circle text-4xl'></i>
                        <span class="font-Urbanist font-semibold text-xl">Você não tem notificações!</span>
                    </div>
                <?php } ?>
        </div>
    
    </div>



    <script type="module"  src="/assets/js/service.js"></script>

</main>