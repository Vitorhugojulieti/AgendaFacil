<main class="lg:w-5/6 w-full flex lg:absolute" style="left:17%; top:10%;">
    <?php require __DIR__ . '/../includes/nav.php'; ?>

    <div class="w-full min-h-screen flex flex-col justify-start items-start bg-bgPrincipal p-4">

        <div class="w-full  bg-bgPrincipal flex flex-col gap-4">
            <h2 class="text-principal10 text-2xl font-Urbanist font-semibold">Sua agenda</h2>

            <div class="w-full flex justify-end ">
                <a href="/admin/schedule/store" class=" add-schedule bg-principal10 text-white text-sm rounded-full p-3 flex items-center "><i class='bx bx-plus text-3xl'></i></a>
            </div>
            <div id="calendar"></div>

            <div class="w-full  bg-bgPrincipal ">
                <div class="w-full flex items-center justify-between py-4">
                    <div class="w-3/4 flex flex-col items-start">
                        <h2 class="text-principal10 text-3xl font-Urbanist font-semibold">Agendamentos</h2>
                    </div>
                    <div class="w-full  flex items-center gap-4">
                        <div class=" flex  search w-full  items-center bg-white  rounded focus-within:shadow-sm focus-within:shadow-black focus-within:border-grayInput shadow shadow-borderFormColor">
                            <input type="text" id="inputSearch" class="w-full ml-2 outline-none bg-transparent p-2 placeholder:text-placeholder" placeholder="Buscar">
                            <i class='bx bx-search p-2  text-principal10 cursor-pointer'></i>
                        </div>

                            <button type="button"  id="btnOpenModalFilters" class="flex items-center gap-2 p-2 bg-white shadow shadow-borderFormColor rounded"><i class='bx bx-filter' style='color:#223249' ></i>Filtros<span id="iconFilter" class="rounded-full bg-principal10 text-white text-sm p-1 h-6 w-6 hidden justify-center items-center"></span></button>
                        

                        </div>
                    </div>
                </div>
            <?php if(count($schedules) !== 0 ){ ?>
                <table class="w-full bg-white shadow shadow-borderFormColor p-2 rounded-lg">
                    <thead class="bg-white p-4  border-b-2 border-lightGray  ">
                        <tr >
                            <th class="font-Urbanist font-semibold text-grayInput text-start p-2">Cliente</th>
                            <th class="font-Urbanist font-semibold text-grayInput text-center p-2">Data</th>
                            <th class="font-Urbanist font-semibold text-grayInput text-center p-2">Hora</th>
                            <th class="font-Urbanist font-semibold text-grayInput text-center p-2">Status</th>
                            <th class="font-Urbanist font-semibold text-grayInput text-center p-2">Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                            <?php foreach ($schedules as $schedule) { ?>
                                <tr class="row even:bg-grayBg">
                                    <!-- collaborator image -->
                                    <td class="p-2 ">
                                        <div class="flex items-center gap-2">
                                            <div class="w-full flex flex-col">
                                                <h3 class="font-semibold"><?php echo $schedule->getClient()->getName();?></h3>
                                            </div>
                                        </div>
                                    </td>
                                    <!-- collaborator service -->
                                    <td class="p-2 text-center">
                                        <span><?php echo $schedule->getDateSchedule()->format('d-m-Y'); ?></span>
                                    </td>
                                    <td class="p-2 text-center">
                                        <span><?php echo $schedule->getStartTime()->format('H:i');?></span>
                                    </td>
                                    <?php if ($schedule->getStatus() == 'cancelado') { ?>
                                        <td class="p-2 text-center">
                                            <span class="bg-errorColor text-white rounded p-1">Ativo</span>
                                        </td>
                                    <?php } elseif ($schedule->getStatus() == 'confirmado') { ?>
                                        <td class="p-2 text-center">
                                            <span class="bg-yellow text-white rounded p-1">Inativo</span>
                                        </td>
                                    <?php } elseif ($schedule->getStatus() == 'concluido') { ?>
                                        <td class="p-2 text-center">
                                            <span class="bg-yellow text-white rounded p-1">Inativo</span>
                                        </td>
                                    <?php } ?>
                                    

                                        <!-- TODO arrumar aqui e paginacao + filtros -->
                                    <!-- collaborator actions -->
                                    <td class="flex items-center justify-center gap-4 p-2 text-center">
                                    </td>
                                </tr> 
                            <?php } ?> 
                    </tbody>
                </table>
           

            <?php }else{ ?>
                        <div class="w-full  text-grayInput flex flex-col gap-2 items-center justify-center p-12" >
                            <i class='bx bxs-info-circle text-4xl'></i>
                            <span class="font-Urbanist font-semibold text-xl">Você não tem serviços cadastrados!</span>
                        </div>
            <?php } ?>
            </div>
        
        </div>
        </div>               
            
    </div>
    <!-- crud flash messages -->
    <?php echo flash('resultInsertCollaborator');  ?>
    <?php echo flash('resultUpdateCollaborator');  ?>
    <?php echo flash('reultDeleteCollaborator');  ?>

    

    <!-- <script type="module"  src="/assets/js/agendaAdmin.js"></script> -->
    <!-- <script  src="https://cdn.jsdelivr.net/npm/@fullcalendar/core@6/main.min.js" defer></script> -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid@6/main.min.js" defer></script> -->
    <script src='/assets/js/dist/index.global.min.js'></script>
    <!-- <script src="js/bootstrap5/index.global.min.js"></script> -->
    <script src='/assets/js/dist/locales-all.global.min.js'></script>
    <script    src="/assets/js/noModuleAgendaAdmin.js" defer></script>

</main>