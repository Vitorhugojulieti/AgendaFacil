<?php include 'includes/header.php';?>

<body class="flex flex-col">
    <div class="flex">
        <?php include 'includes/nav.php';?>

        <div id="container" class="w-full p-4 flex flex-col">
            <h2 class="font-Urbanist font-semibold italic text-4xl text-black w-full border-b-2 border-b-lightGray p-2">Olá administrador</h2>
            <!-- details -->
            <div class="w-full flex items-center gap-4 mt-4">
                <!-- item  skeleton-->
                <!-- <div class="w-2/5 bg-lightGray animate-pulse-skeleton p-4">
                    <h3 class="font-Poppins font-medium text-text-gray">Agendamentos</h3>
                    <div class="w-full flex items-center justify-between">
                    <span class="font-semibold font-Poppins text-2xl">100</span>
                    <span class="text-sucessColor">+36%<i class='bx bx-up-arrow-alt'></i></span>
                    </div>
                </div> -->
                <!-- item -->
                <div class="w-2/5 flex flex-col gap-4 border-2 border-lightGray rounded p-4 shadow shadow-borderFormColor">
                    <h3 class="font-Poppins font-medium text-text-gray">Agendamentos</h3>
                    <div class="w-full flex items-center justify-between">
                    <span class="font-semibold font-Poppins text-2xl">100</span>
                    <span class="text-sucessColor">+36%<i class='bx bx-up-arrow-alt'></i></span>
                    </div>
                </div>
                <!-- item -->
                <div class="w-2/5 flex flex-col gap-4 border-2 border-lightGray rounded p-4 shadow shadow-borderFormColor">
                    <h3 class="font-Poppins font-medium text-text-gray">Serviços</h3>
                    <div class="w-full flex items-center justify-between">
                    <span class="font-semibold font-Poppins text-2xl">100</span>
                    <span class="text-sucessColor">+36%<i class='bx bx-up-arrow-alt'></i></span>
                    </div>
                </div>
                <!-- item -->
                <div class="w-2/5 flex flex-col gap-4 border-2 border-lightGray rounded p-4 shadow shadow-borderFormColor">
                    <h3 class="font-Poppins font-medium text-text-gray">Colaboradores</h3>
                    <div class="w-full flex items-center justify-between">
                    <span class="font-semibold font-Poppins text-2xl">100</span>
                    <span class="text-errorColor">+36%<i class='bx bx-down-arrow-alt'></i></span>
                    </div>
                </div>
                <!-- item -->
                <div class="w-2/5 flex flex-col gap-4 border-2 border-lightGray rounded p-4 shadow shadow-borderFormColor">
                    <h3 class="font-Poppins font-medium text-text-gray">Total recebimentos</h3>
                    <div class="w-full flex items-center justify-between">
                    <span class="font-semibold font-Poppins text-2xl">R$ 3.298,00   </span>
                    <span class="text-sucessColor">+36%<i class='bx bx-up-arrow-alt'></i></span>
                    </div>
                </div>
            </div>
            <!-- teste graficos -->
            <div class="w-full flex mt-8">
                <div class="w-3/4">
                    <canvas id="chart1" width="200" height="200"></canvas> 
                </div>   
                <div class="w-1/4 h-max border-2 border-lightGray rounded p-4">
                    <div class="w-full flex flex-col border-b-2 border-b-lightGray p-2">
                        <div class="w-full flex items-center justify-between">
                            <span class="font-Poppins font-medium text-text-gray">Serviços agendados</span>
                            <i class='bx bxs-info-circle text-text-gray'></i>
                        </div>
                        <span class="text-2xl font-semibold">5.987</span>
                        <!-- <span class="font-Poppins font-medium text-text-gray">Junho 2024</span> -->
                    </div>
                    <canvas id="chart2" width="100" height="100"></canvas> 
                </div> 
            </div>
        <div>
    </div>
    <script type="module" src="/assets/js/indexAdm.js" deffer></script>
</body>