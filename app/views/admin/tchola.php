<?php if(count($schedules) !== 0 ){ ?>
            <table class="w-full bg-white shadow shadow-borderFormColor p-2 rounded-lg">
                <thead class="bg-white p-4  border-b-2 border-lightGray ">
                    <tr>
                        <th class="font-Urbanist font-semibold text-grayInput text-start p-2">Cliente</th>
                        <th class="font-Urbanist font-semibold text-grayInput text-center p-2">Data</th>
                        <th class="font-Urbanist font-semibold text-grayInput text-center p-2">Horario</th>
                        <th class="font-Urbanist font-semibold text-grayInput text-center p-2">Status</th>
                        <th class="font-Urbanist font-semibold text-grayInput text-center p-2">Ação</th>
                    </tr>
                </thead>
                <tbody>
                
                <?php foreach ($schedules as $schedule) { ?>
                            <tr class="row even:bg-grayBg">
                                <!-- collaborator image -->
                                <td class="p-2">
                                    <div class="flex items-center gap-2">
                                        <img src="<?php echo $schedule ? $schedule->getClient()->getAvatar() : '/assets/images/avatar_default.png';?>" alt="" class="redondShapeImageCollaborator">
                                        <div class="flex flex-col ">
                                            <span class="font-semibold"><?php echo $schedule->getClient()->getName();?></span>
                                            <span><?php echo $schedule->getClient()->getEmail();?></span>
                                        </div>
                                    </div>
                                </td>
                                <!-- collaborator service -->
                                <td class="p-2 text-center">
                                    <span><?php echo $schedule->getDateSchedule()->format('d/m/Y');?></span>
                                </td>
                                <!-- collaborator date -->
                                <td class="p-2 text-center">
                                    <span><?php echo $schedule->getStartTime()->format('H:i');?></span>
                                </td>

                                <?php if($schedule->getStatus() === "confirmado"){ ?>
                                    <td class="p-2 text-center">
                                        <span class="bg-sucessColor text-white rounded p-1">Confirmado</span>
                                    </td>
                                <?php }else if($schedule->getStatus() === "Aguardando pagamento"){ ?>
                                    <td class="p-2 text-center">
                                        <span class="bg-orange text-white rounded p-1">Aguardando pagamento</span>
                                    </td>
                                <?php }else{ ?>
                                    <td class="p-2 text-center">
                                        <span class="bg-errorColor text-white rounded p-1">Cancelado</span>
                                    </td>
                                <?php } ?>
                                

                           
                                <!-- collaborator actions -->
                                <td class="flex items-center justify-center gap-4 p-2 text-center">
                                    <a href="/admin/schedule/show/<?php echo $schedule->getId();?>" class="hover:underline">Detalhes</a>
                                </td>
                            </tr> 
                        <?php } ?> 
                </tbody>
            </table>
            <div class="w-full flex items-center justify-between p-4 ">
                    <span>Pagina 1 de 10</span>
                    <div class="buttons flex items-center gap-4">
                        <button class="border-2 border-lightGray rounded-xl p-2 hover:underline">Anterior</button>
                        <button class="border-2 border-lightGray rounded-xl p-2 hover:underline">Proxima</button>
                    </div>
            </div>
            <?php }else{ ?>
                    <div class="w-full  text-grayInput flex flex-col gap-2 items-center justify-center p-12" >
                        <i class='bx bxs-info-circle text-4xl'></i>
                        <span class="font-Urbanist font-semibold text-xl">Você não tem Agendamentos cadastrados!</span>
                    </div>
                <?php } ?>
        </div>



































        <div class="w-full flex items-center justify-between p-4 ">
                    <span><?php echo 'Pagina '.$pagination['currentPage'].' de '.$pagination['totalPages']?></span>
                    <div class="buttons flex items-center gap-4">
                        <a href="/admin/service/<?php echo $pagination['currentPage'] != 1 ? $pagination['currentPage'] - 1 : '';?>" class="flex items-center gap-4 text-sm   "><i class='bx bx-left-arrow-alt text-2xl hover:scale-50'   ></i>Anterior</a>
                        <a href="/admin/service/<?php echo $pagination['currentPage'] +1;?>" class="flex items-center gap-4 text-sm   ">Proxima<i class='bx bx-right-arrow-alt text-2xl hover:scale-50'  ></i></a>
                    </div>
            </div>