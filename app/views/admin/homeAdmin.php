<body class="flex flex-col">
    <?php  require __DIR__ . '/../includes/nav.php'; ?>
    <div class="lg:w-5/6 w-full flex flex-col lg:absolute p-4 bg-bgPrincipal" style="left:17%; top:10%;">
        <h2 class="text-principal10 text-2xl font-Urbanist font-semibold mb-3">Dashboard</h2>

        <main id="container" class=" w-full min-h-screen flex flex-col gap-8">

            <!-- details -->
            <div class="w-full flex lg:flex-row flex-col items-center gap-4 ">
         
                <!-- item -->
                <div class="bg-white lg:w-2/5 w-full flex items-center  gap-4 border border-lightGray rounded p-4 shadow shadow-borderFormColor border-r-8 border-r-principal10">
                    <span class="bg-white px-4">
                        <i class='bx bx-calendar-check text-3xl text-principal10'   ></i>
                    </span>
                    <span>
                        <span class="font-semibold font-Poppins text-2xl"><?php echo $totalSchedules; ?></span>
                        <h3 class="font-Poppins font-semibold text-grayInput">Agendamentos</h3>
                    </span>
                </div>
                <!-- item -->
                <div class="bg-white lg:w-2/5 w-full flex items-center  gap-4 border border-lightGray rounded p-4 shadow shadow-borderFormColor border-r-8 border-r-principal10">
                    <span class="bg-white px-4">
                        <i class='bx bx-briefcase-alt-2 text-3xl text-principal10' ></i>
                    </span>
                    <span>
                        <span class="font-semibold font-Poppins text-2xl"><?php echo $totalServices; ?></span>
                        <h3 class="font-Poppins font-semibold text-grayInput">Serviços</h3>
                    </span>
                </div>
                <!-- item -->
                <div class="bg-white lg:w-2/5 w-full flex items-center  gap-4 border border-lightGray rounded p-4 shadow shadow-borderFormColor border-r-8 border-r-principal10">
                    <span class="bg-white px-4">
                        <i class='bx bxs-user text-3xl text-principal10' ></i>
                    </span>
                    <span>
                        <span class="font-semibold font-Poppins text-2xl"><?php echo $totalCollaborators; ?></span>
                        <h3 class="font-Poppins font-semibold text-grayInput">Colaboradores</h3>
                    </span>
                </div>
                <!-- item -->
                <div class="bg-white lg:w-2/5 w-full flex items-center  gap-4 border border-lightGray rounded p-4 shadow shadow-borderFormColor border-r-8 border-r-principal10">
                    <span class="bg-white px-4">
                        <i class='bx bx-dollar text-3xl text-principal10' ></i>
                    </span>
                    <span>
                        <span class="font-semibold font-Poppins text-2xl"><?php echo 'R$ '.number_format($receipts, 2, ',', '.'); ?></span>
                        <h3 class="font-Poppins font-semibold text-grayInput">Recebimentos</h3>
                    </span>
                </div>
            </div>

            <section id="containerCharts" class="w-full flex flex-col gap-4 border-t border-t-lightGray pt-8" >
                <div class="w-full flex  lg:flex-row flex-col items-start gap-8">
                    <div class="w-3/4 " style="max-height: 500px;">
                        <div  id="donut-chart" ></div>
                    </div>

                    <div class="w-full" style="max-height: 500px;">
                        <div  id="line-chart"></div>
                    </div>
                    
                </div>

                <div class="w-full border-t border-t-lightGray pt-8">
                    <div id="column-chart"></div>
                </div>
           

                
        
            </section>
        <main>
    </div>
    <script type="module" src="/assets/js/indexAdm.js" deffer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
</body>