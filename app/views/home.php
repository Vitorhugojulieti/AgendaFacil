<body class="flex flex-col">
<?php require __DIR__ . '../includes/header.php'; ?>
    <div class="w-full h-screen flex">
        <?php require __DIR__ . '../includes/nav.php'; ?>

        <main class="w-full flex flex-col">
            <section class="p-4 flex flex-col gap-4">
                <h1 class="w-full font-Urbanist font-bold text-principal10 text-4xl border-b border-borderFormColor p-1">Serviços disponiveis</h1>

                <div class="w-full flex items-center justify-end">
                    <div class="w-2/4 flex items-center gap-4">
                        <div class="search w-full text-lightGray flex border-lightGray border-2 rounded focus-within:border-principal10 focus-within:text-principal10">
                            <input type="text" id="inputSearch" class="w-full ml-2 outline-none" placeholder="Faça sua pesquisa">
                            <i class='bx bx-search p-2 border-l-2'></i>
                        </div>

                        <div class="btns flex items-center gap-4">
                            <button type="button"  id="btnOpenModalFilters"><i class='bx bx-filter' style='color:#223249' ></i>Filtros</button>
                        </div>
                    </div>
                </div>

                <div class="w-full flex flex-wrap gap-8 p-4">
                    <!-- companys -->
                    <?php foreach ($companys as $company) { ?>

                        <div class="w-2/5 border border-lightGray shadow-sm shadow-black rounded-md flex flex-col">
                            <div class="w-full relative">
                                <span class="assessment absolute bg-white text-black w-9 rounded">
                                    <span>
                                        5.0
                                        <span class="border-l border-lightGray p-2">105 avaliações</span>
                                    </span>
                                </span>
                                <img src="<?php echo $company->getLogo() ?>" alt="" class="border-l border-r rounded">
                            </div>
                            <div class="w-full flex flex-col gap-4 p-4">
                                <h2 class="font-Urbanist font-semibold text-xl">Barbearia jubileus means - Birigui-SP</h2>
                                <h3 class="font-Poppins font-normal text-sm">Endereço: Rua dos bobos N 0 - Alta noroeste</h3>
                                <a href="company/show/<?php echo $company->getId();?>" class="w-2/4 p-2 bg-principal10 text-white text-center font-Urbanist font-normal rounded cursor-pointer hover:underline">Detalhes</a>
                            </div>
                        </div>

                    <?php } ?>

                    <!-- companys -->
                    <?php foreach ($companys as $company) { ?>

<div class="w-2/5 border border-lightGray shadow-sm shadow-black rounded-md flex flex-col">
    <div class="w-full relative">
        <span class="assessment absolute bg-white text-black w-9 rounded">
            <span>
                5.0
                <span class="border-l border-lightGray p-2">105 avaliações</span>
            </span>
        </span>
        <img src="<?php echo $company->getLogo() ?>" alt="" class="border-l border-r rounded">
    </div>
    <div class="w-full flex flex-col gap-4 p-4">
        <h2 class="font-Urbanist font-semibold text-xl">Barbearia jubileus means - Birigui-SP</h2>
        <h3 class="font-Poppins font-normal text-sm">Endereço: Rua dos bobos N 0 - Alta noroeste</h3>
        <a href="" class="w-2/4 p-2 bg-principal10 text-white text-center font-Urbanist font-normal rounded cursor-pointer hover:underline">Detalhes</a>
    </div>
</div>

<?php } ?>

<!-- companys -->
<?php foreach ($companys as $company) { ?>

<div class="w-2/5 border border-lightGray shadow-sm shadow-black rounded-md flex flex-col">
    <div class="w-full relative">
        <span class="assessment absolute bg-white text-black w-9 rounded">
            <span>
                5.0
                <span class="border-l border-lightGray p-2">105 avaliações</span>
            </span>
        </span>
        <img src="<?php echo $company->getLogo() ?>" alt="" class="border-l border-r rounded">
    </div>
    <div class="w-full flex flex-col gap-4 p-4">
        <h2 class="font-Urbanist font-semibold text-xl">Barbearia jubileus means - Birigui-SP</h2>
        <h3 class="font-Poppins font-normal text-sm">Endereço: Rua dos bobos N 0 - Alta noroeste</h3>
        <a href="" class="w-2/4 p-2 bg-principal10 text-white text-center font-Urbanist font-normal rounded cursor-pointer hover:underline">Detalhes</a>
    </div>
</div>

<?php } ?>
                </div>

                
            </section>
        </main>
    </div>

</body>