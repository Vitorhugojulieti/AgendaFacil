<body class="flex flex-col">
    <div class="flex">
        <?php  require __DIR__ . '/../includes/nav.php'; ?>


        <main id="container" class="bg-bgPrincipal w-full p-4 flex flex-col gap-8">
            <h2 class="font-Urbanist font-semibold italic text-4xl text-black w-full border-b-2 border-b-lightGray p-2">Olá <?php echo $nameCollaborator;?>!</h2>
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
                <div class="bg-white lg:w-2/5 w-full flex flex-col gap-4 border-2 border-lightGray rounded p-4 shadow shadow-borderFormColor">
                    <h3 class="font-Poppins font-medium text-text-gray">Agendamentos</h3>
                    <div class="w-full flex items-center justify-between">
                    <span class="font-semibold font-Poppins text-2xl"><?php echo $totalSchedules; ?></span>
                    <span class="text-sucessColor">+36%<i class='bx bx-up-arrow-alt'></i></span>
                    </div>
                </div>
                <!-- item -->
                <div class="bg-white lg:w-2/5 w-full flex flex-col gap-4 border-2 border-lightGray rounded p-4 shadow shadow-borderFormColor">
                    <h3 class="font-Poppins font-medium text-text-gray">Serviços</h3>
                    <div class="w-full flex items-center justify-between">
                    <span class="font-semibold font-Poppins text-2xl"><?php echo $totalServices;?></span>
                    <span class="text-sucessColor">+36%<i class='bx bx-up-arrow-alt'></i></span>
                    </div>
                </div>
                <!-- item -->
                <div class="bg-white lg:w-2/5 w-full flex flex-col gap-4 border-2 border-lightGray rounded p-4 shadow shadow-borderFormColor">
                    <h3 class="font-Poppins font-medium text-text-gray">Colaboradores</h3>
                    <div class="w-full flex items-center justify-between">
                    <span class="font-semibold font-Poppins text-2xl"><?php echo $totalCollaborators;?></span>
                    <span class="text-errorColor">+36%<i class='bx bx-down-arrow-alt'></i></span>
                    </div>
                </div>
                <!-- item -->
                <div class="bg-white lg:w-2/5 w-full flex flex-col gap-4 border-2 border-lightGray rounded p-4 shadow shadow-borderFormColor">
                    <h3 class="font-Poppins font-medium text-text-gray">Total recebimentos</h3>
                    <div class="w-full flex items-center justify-between">
                    <span class="font-semibold font-Poppins text-2xl">R$ 3.298,00   </span>
                    <span class="text-sucessColor">+36%<i class='bx bx-up-arrow-alt'></i></span>
                    </div>
                </div>
            </div>

            <div class="w-full flex   items-start gap-8">
                <div class="w-full">
                    <div class="box" id="line-chart"></div>
                </div>
                <div class="w-full">
                    <div class="box" id="donut-chart"></div>
                </div>
            </div>
            <div id="column-chart"></div>
        <main>
    </div>
    <script type="module" src="/assets/js/indexAdm.js" deffer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
</body>