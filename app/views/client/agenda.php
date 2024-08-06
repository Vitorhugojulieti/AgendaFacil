<main class="flex">
    <?php require __DIR__ . '/../includes/nav.php'; ?>

    <div class="w-full min-h-screen flex flex-col justify-start items-start bg-white p-4">
        <div class="w-full border-2 border-lightGray rounded-lg">
            <div class="flex items-center justify-between p-4 ">
                <div class="flex flex-col items-start">
                    <h2 class="text-black text-xl font-Urbanist font-normal flex items-center gap-2">Minha agenda <span class="text-xs font-medium text-principal10 bg-principal5 rounded p-1"><?php echo count($schedules);?> resultados</span></h2>
                    <h3 class="text-sm text-borderFormColor">Gerencie seus agendamentos.</h3>
                </div>
                <div class="flex items-center gap-4">
                    <div class="search w-2/4 text-lightGray flex border-lightGray border-2 rounded focus-within:border-principal10 focus-within:text-principal10">
                        <input type="text" id="inputSearch" class="w-full ml-2 outline-none" placeholder="Faça sua pesquisa">
                        <i class='bx bx-search p-2 border-l-2'></i>
                    </div>
                    <button type="button"  id="btnOpenModalFilters"><i class='bx bx-filter' style='color:#223249' ></i>Filtros</button>

                </div>
            </div>
            <table class="w-full ">
                <thead class="border-b-2 border-lightGray">
                    <tr>
                        <th class="font-Urbanist font-normal text-start p-2">Data</th>
                        <th class="font-Urbanist font-normal text-start p-2">Horario</th>
                        <th class="font-Urbanist font-normal text-start p-2">Status</th>
                        <th class="font-Urbanist font-normal text-start p-2">Ação</th>
                    </tr>
                </thead>
                <tbody>
                
                    <?php foreach ($schedules as $schedule) { ?>
                        <tr class="border-b-2 border-lightGray">
                            <!-- collaborator image -->
                            <td class="p-2">
                                <div class="flex items-center gap-2">
                                    <div class="flex flex-col ">
                                        <h3><?php echo $schedule->getDateSchedule()->format('d/m/Y');?></h3>
                                    </div>
                                </div>
                            </td>
                            <!-- collaborator service -->
                            <td class="p-2">
                                <h3><?php echo $schedule->getStartTime()->format('H:i');?></h3>
                            </td>
                            <!-- collaborator date -->
                            <?php if($schedule->getStatus() === "Confirmado"){?>
                                <td class="p-2">
                                    <h3 class="w-max text-sm font-medium text-white bg-sucessColor rounded p-1"><?php echo $schedule->getStatus()?></h3>
                                </td>
                            <?php }else if($schedule->getStatus() === "Aguardando pagamento"){ ?>
                                <td class="p-2">
                                    <h3 class="w-max text-sm font-medium text-white bg-orange rounded p-1"><?php echo $schedule->getStatus()?></h3>
                                </td>
                            <?php }else if($schedule->getStatus() === "Cancelado"){ ?>
                                <td class="p-2">
                                    <h3 class="w-max text-sm font-medium text-white bg-red rounded p-1"><?php echo $schedule->getStatus()?></h3>
                                </td>
                            <?php } ?>
                            <!-- collaborator actions -->
                            <td class="p-2 ">
                                <a class="bg-principal10 text-white p-2 rounded hover:cursor-pointer"  href="/schedule/show/<?php echo $schedule->getId();?>">Detalhes</a>
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
        </div>
    </div>
    <!-- crud flash messages -->
    <?php echo flash('resultInsertService');  ?>
    <?php echo flash('resultUpdateService');  ?>
    <?php echo flash('reultDeleteService');  ?>

     <!-- modais -->
     <dialog id="modalService" class="w-2/4 bg-white text-black rounded p-4 ">
        <div class="w-full flex justify-between items-center mb-4">
            <div class="flex gap-4 items-center">
                <h2 id="messageDelete"></h2>  
            </div>
            <button id="btnCloseModalService" class="outline-none"><i class='bx bx-x-circle text-3xl'></i></button>
        </div>
        <div>
            <a id="btnDelete" href="">Excluir</a>
        </div>
    </dialog>

     <dialog id="modalFilters" class="w-2/4 bg-white text-black rounded p-4 ">
        <div class="w-full flex justify-between items-center mb-4">
            <div class="flex gap-4 items-center">
                <h2 >Filtros</h2>  
            </div>
            <button id="btnCloseModalFilters" class="outline-none"><i class='bx bx-x-circle text-3xl'></i></button>
        </div>
        <div>
            <a id="btnDelete" href="">Excluir</a>
        </div>
    </dialog>

    <script type="module"  src="/assets/js/service.js"></script>

</main>