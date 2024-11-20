<body class="flex flex-col">
    <?php  require __DIR__ . '/../includes/nav.php'; ?>

    <div class="lg:w-5/6 w-full flex lg:absolute" style="left:17%; top:10%;">

        <main id="container" class="bg-bgPrincipal w-full min-h-screen p-4 flex flex-col gap-4">
            <h2 class="text-principal10 text-3xl font-Urbanist font-semibold">Dashboard</h2>

            <!-- details -->
            <div class="w-full flex lg:flex-row flex-col items-center gap-4 mt-4">
         
                <!-- item -->
                <div class="bg-white lg:w-2/5 w-full flex items-center  gap-4 border-2 border-lightGray rounded p-4 shadow shadow-borderFormColor border-r-8 border-r-red">
                    <span class="bg-red rounded-full p-4">
                        <i class='bx bx-calendar-check text-xl' style='color:#ffffff'  ></i>
                    </span>
                    <span>
                        <span class="font-semibold font-Poppins text-2xl"><?php echo $totalSchedules; ?></span>
                        <h3 class="font-Poppins font-semibold text-grayInput">Agendamentos</h3>
                    </span>
                </div>
                <!-- item -->
                <div class="bg-white lg:w-2/5 w-full flex items-center  gap-4 border-2 border-lightGray rounded p-4 shadow shadow-borderFormColor border-r-8 border-r-orange">
                    <span class="bg-orange rounded-full p-4">
                        <i class='bx bx-briefcase-alt-2 text-xl' style='color:#ffffff'></i>
                    </span>
                    <span>
                        <span class="font-semibold font-Poppins text-2xl"><?php echo $totalServices; ?></span>
                        <h3 class="font-Poppins font-semibold text-grayInput">Serviços</h3>
                    </span>
                </div>
                <!-- item -->
                <div class="bg-white lg:w-2/5 w-full flex items-center  gap-4 border-2 border-lightGray rounded p-4 shadow shadow-borderFormColor border-r-8 border-r-sucessColor">
                    <span class="bg-sucessColor rounded-full p-4">
                        <i class='bx bxs-user text-xl' style='color:#ffffff'></i>
                    </span>
                    <span>
                        <span class="font-semibold font-Poppins text-2xl"><?php echo $totalCollaborators; ?></span>
                        <h3 class="font-Poppins font-semibold text-grayInput">Colaboradores</h3>
                    </span>
                </div>
                <!-- item -->
                <div class="bg-white lg:w-2/5 w-full flex items-center  gap-4 border-2 border-lightGray rounded p-4 shadow shadow-borderFormColor border-r-8 border-r-principal10">
                    <span class="bg-principal10 rounded-full p-4">
                        <i class='bx bx-dollar text-xl' style='color:#ffffff'></i>
                    </span>
                    <span>
                        <span class="font-semibold font-Poppins text-2xl"><?php echo 'R$ '.number_format($receipts, 2, ',', '.'); ?></span>
                        <h3 class="font-Poppins font-semibold text-grayInput">Recebimentos</h3>
                    </span>
                </div>
            </div>

            <section id="containerCharts" class="w-full flex flex-col gap-4" >
                <div class="w-full flex  lg:flex-row flex-col items-start gap-8">
                    <div class="w-2/4 bg-white rounded shadow shadow-black" style="height:450px;">
                        <div  id="donut-chart" ></div>
                    </div>

                    <div class="w-3/4   bg-white rounded shadow shadow-black">
                        <!-- <h3 class="font-Urbanist font-medium text-2xl ">Agendamentos e cancelamentos</h3> -->
                        <div  id="line-chart"></div>
                    </div>
                    
                </div>
                <!-- <div class="w-full bg-white border-2 border-lightGray rounded p-4 shadow shadow-borderFormColor">
                    <h3 class="font-Urbanist font-medium text-2xl ">Agendamentos por colaboradores</h3>
                    <div id="column-chart"></div>
                </div> -->

                <div class="w-full  bg-bgPrincipal ">
                <div class="w-full flex items-center justify-between py-4">
                    <div class="w-3/4 flex flex-col items-start">
                        <h2 class="text-principal10 text-2xl font-Urbanist font-semibold">Agendamentos recentes</h2>
                    </div>
                
                </div>
            <?php if(count($schedules) !== 0 ){ ?>
                <table class="w-full bg-white shadow shadow-borderFormColor p-2 rounded-lg">
                    <thead class="bg-white p-4  border-b-2 border-lightGray  ">
                        <tr >
                            <th class="font-Urbanist font-semibold text-grayInput text-start p-2"></th>
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
                                                <img src="<?php echo $schedule->getClient()->getAvatar();?>" alt="client image" class="redondShapeImageCollaborator">
                                            </div>
                                        </div>
                                    </td>

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
                                            <span class="bg-errorColor text-white rounded p-1">Cancelado</span>
                                        </td>
                                    <?php } elseif ($schedule->getStatus() == 'confirmado') { ?>
                                        <td class="p-2 text-center">
                                            <span class="bg-orange text-white rounded p-1">Confirmado</span>
                                        </td>
                                    <?php } elseif ($schedule->getStatus() == 'concluido') { ?>
                                        <td class="p-2 text-center">
                                            <span class="bg-sucessColor  text-white rounded p-1">Concluido</span>
                                        </td>
                                    <?php } ?>
                                    

                                        <!-- TODO arrumar aqui e paginacao + filtros -->
                                    <!-- collaborator actions -->
                                    <td class="flex items-center justify-center gap-4 p-2 text-center">
                                        <button type="button"><i class='bx bx-trash text-xl m-3' ></i></button>
                                        <a  href="/admin/service/edit/<?php echo $schedule->getId();?>"><i class='bx bx-pencil text-xl m-3'></i></a>
                                        <a href="/admin/service/show/<?php echo $schedule->getId();?>" class="hover:underline">Detalhes</a>
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
            </section>
        <main>
    </div>
    <script type="module" src="/assets/js/indexAdm.js" deffer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
</body>