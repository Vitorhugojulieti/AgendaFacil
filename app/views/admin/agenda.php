<main class="lg:w-5/6 w-full flex lg:absolute" style="left:17%; top:10%;">
    <?php require __DIR__ . '/../includes/nav.php'; ?>

    <div class="w-full min-h-screen flex flex-col justify-start items-start bg-bgPrincipal p-4">
    <?php echo $breadcrumb?>

        <div class="w-full  bg-bgPrincipal ">
            <div class="w-full flex items-center justify-between py-4 ">
                <div class="w-full flex flex-col items-start">
                    <h2 class="text-principal10 text-3xl font-Urbanist font-semibold">Agendamentos</h2>
                </div>
                <div class="w-3/4 flex items-center gap-4">
                    <div class=" flex  search w-3/4  items-center bg-white  rounded focus-within:shadow-sm focus-within:shadow-black focus-within:border-grayInput shadow shadow-borderFormColor">
                        <input type="text" id="inputSearch" class="w-full ml-2 outline-none bg-transparent p-2 placeholder:text-placeholder" placeholder="Buscar">
                        <i class='bx bx-search p-2  text-principal10 cursor-pointer'></i>
                    </div>

                    <div class="w-full btns flex items-center gap-4  justify-end">
                        <button type="button"  id="btnOpenModalFilters" class="flex items-center gap-2 p-2 bg-white shadow shadow-borderFormColor rounded"><i class='bx bx-filter' style='color:#223249' ></i>Filtros</button>
                        <a href="/admin/schedule/store" class="bg-principal10 text-white text-sm rounded p-3 flex items-center"><i class='bx bx-plus'></i>Add agendamento</a>
                    </div>
                </div>
            </div>
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
    </div>
    <!-- crud flash messages -->
    <?php echo flash('resultInsertCollaborator');  ?>
    <?php echo flash('resultUpdateCollaborator');  ?>
    <?php echo flash('reultDeleteCollaborator');  ?>

     <!-- modais -->
    <dialog id="modalFilters" class="w-2/4 bg-white text-black rounded p-4">
        <div class="w-full flex justify-between items-center mb-4">
            <h2 class="text-2xl font-Urbanist font-semibold" >Filtros</h2>  
            <button id="btnCloseModalFilters" class="outline-none"><i class='bx bx-x text-2xl' style='color:#dbdbdb'  ></i></button>
        </div>
        <div class="flex flex-col justify-start gap-2  border-b border-b-grayInput pb-4">
            <h4 class="text-xl font-Urbanist font-semibold ">Periodo</h4>

            <div class="flex items-center justify-between">
                <label for="inputStartDate" class="flex items-center gap-4">
                    <span class="font-Poppins font-medium text-principal10">Data inicial</span>
                    <input type="date" name="inputStartDate" id="">
                </label>

                <label for="inputStartDate" class="flex items-center gap-4">
                    <span class="font-Poppins font-medium text-principal10">Data Final</span>
                    <input type="date" name="inputEndDate" id="">
                </label>
            </div>
           
        </div>

        <div class="flex flex-col justify-start gap-2 py-4">
            <h4 class="text-xl font-Urbanist font-semibold ">Status</h4>
            <div class="filter-status w-full flex items-center justify-between">
                <label for="checkCompleted" class="flex items-center gap-2">
                    <input type="checkbox" name="completed" id="checkCompleted">
                    <span>Concluido</span>
                </label>

                <label for="checkCanceled" class="flex items-center gap-2">
                    <input type="checkbox" name="canceled" id="checkCanceled">
                    <span>Cancelado</span>
                </label>

                <label for="checkWaiting" class="flex items-center gap-2">
                    <input type="checkbox" name="waiting" id="checkWaiting">
                    <span>Aguardando pagamento</span>
                </label>
            
            </div>
        </div>
        <button class="bg-principal10 text-white rounded p-2 hover:underline">Aplicar</button>

    </dialog>

    <script type="module"  src="/assets/js/agendaAdmin.js"></script>

</main>