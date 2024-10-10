<body class="flex flex-col">
    <?php  require __DIR__ . '/../includes/nav.php'; ?>

    <div class="lg:w-5/6 w-full flex lg:absolute" style="left:17%; top:10%;">

        <main id="container" class="bg-bgPrincipal w-full min-h-screen p-4 flex flex-col gap-4">
            <!-- <h2 class="font-Urbanist font-semibold italic text-xl text-black w-full border-b-2 border-b-lightGray p-2">Olá <?php echo $nameCollaborator;?>!👋</h2> -->
            <!-- details -->
            <div class="w-full flex lg:flex-row flex-col items-center gap-4 mt-4">
                <!-- item  skeleton-->
                <!-- <div class="w-2/5 bg-lightGray animate-pulse-skeleton p-4">
                    <h3 class="font-Poppins font-medium text-text-gray">Agendamentos</h3>
                    <div class="w-full flex items-center justify-between">
                    <span class="font-semibold font-Poppins text-2xl">100</span>
                    <span class="text-sucessColor">+36%<i class='bx bx-up-arrow-alt'></i></span>
                    </div>
                </div> -->
                <!-- item -->
                <div class="bg-white lg:w-2/5 w-full flex items-center  gap-4 border-2 border-lightGray rounded p-4 shadow shadow-borderFormColor border-r-8 border-r-red">
                    <span class="bg-red rounded-full p-4">
                        <i class='bx bx-calendar-check text-3xl' style='color:#ffffff'  ></i>
                    </span>
                    <span>
                        <span class="font-semibold font-Poppins text-2xl"><?php echo $totalSchedules; ?></span>
                        <h3 class="font-Poppins font-semibold text-grayInput">Agendamentos</h3>
                    </span>
                </div>
                <!-- item -->
                <div class="bg-white lg:w-2/5 w-full flex items-center  gap-4 border-2 border-lightGray rounded p-4 shadow shadow-borderFormColor border-r-8 border-r-orange">
                    <span class="bg-orange rounded-full p-4">
                        <i class='bx bx-briefcase-alt-2 text-3xl' style='color:#ffffff'></i>
                    </span>
                    <span>
                        <span class="font-semibold font-Poppins text-2xl"><?php echo $totalServices; ?></span>
                        <h3 class="font-Poppins font-semibold text-grayInput">Serviços</h3>
                    </span>
                </div>
                <!-- item -->
                <div class="bg-white lg:w-2/5 w-full flex items-center  gap-4 border-2 border-lightGray rounded p-4 shadow shadow-borderFormColor border-r-8 border-r-sucessColor">
                    <span class="bg-sucessColor rounded-full p-4">
                        <i class='bx bxs-user text-3xl' style='color:#ffffff'></i>
                    </span>
                    <span>
                        <span class="font-semibold font-Poppins text-2xl"><?php echo $totalCollaborators; ?></span>
                        <h3 class="font-Poppins font-semibold text-grayInput">Colaboradores</h3>
                    </span>
                </div>
                <!-- item -->
                <div class="bg-white lg:w-2/5 w-full flex items-center  gap-4 border-2 border-lightGray rounded p-4 shadow shadow-borderFormColor border-r-8 border-r-principal10">
                    <span class="bg-principal10 rounded-full p-4">
                        <i class='bx bx-dollar text-3xl' style='color:#ffffff'></i>
                    </span>
                    <span>
                        <span class="font-semibold font-Poppins text-2xl">R$ 3.298,00</span>
                        <h3 class="font-Poppins font-semibold text-grayInput">Recebimentos</h3>
                    </span>
                </div>
            </div>

            <section id="containerCharts" class="w-full flex flex-col gap-4" >
                <div class="w-full flex  lg:flex-row flex-col items-start gap-8">
                    <div class="w-full bg-white border-2 border-lightGray rounded p-4 shadow shadow-borderFormColor">
                        <h3 class="font-Urbanist font-medium text-2xl ">Agendamentos e cancelamentos</h3>
                        <div class="box" id="line-chart"></div>
                    </div>
                    <div class="w-full bg-white border-2 border-lightGray rounded p-4 shadow shadow-borderFormColor">
                        <h3 class="font-Urbanist font-medium text-2xl ">Serviços agendados</h3>
                        <div class="box " id="donut-chart"></div>
                    </div>
                </div>
                <div class="w-full bg-white border-2 border-lightGray rounded p-4 shadow shadow-borderFormColor">
                    <h3 class="font-Urbanist font-medium text-2xl ">Agendamentos por colaboradores</h3>
                    <div id="column-chart"></div>
                </div>
            </section>
        <main>
    </div>
    <script type="module" src="/assets/js/indexAdm.js" deffer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
</body>