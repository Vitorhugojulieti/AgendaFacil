<body class="flex flex-col">
    <div class="w-full h-screen flex">
        <?php require __DIR__ . '../includes/nav.php'; ?>

        <main class="bg-bgPrincipal w-full flex flex-col items-center ">
        <?php if(count($companys) != 0 ){ ?>
            <section class="p-4 flex flex-col gap-4">
            <?php echo $breadcrumb?>

                <h1 class="w-full font-Urbanist font-bold text-principal10 text-4xl italic border-b border-borderFormColor p-1">Empresas disponiveis</h1>
                
                <div class="w-full flex items-center lg:justify-end justify-start">
                    <div class="lg:w-2/4 w-full flex items-center gap-4">
                    <div class="flex  search lg:w-2/4 w-full  items-center bg-graySearchInput  rounded focus-within:shadow-sm focus-within:shadow-black focus-within:border-grayInput">
                        <input type="text" class="w-full ml-2 outline-none bg-transparent p-2 placeholder:text-placeholder" placeholder="Buscar">
                        <i class='bx bx-search p-2  text-principal10 cursor-pointer'></i>
                    </div>

                        <div class="btns flex items-center gap-4">
                            <button type="button"  id="btnOpenModalFilters" class="flex items-center gap-2"><i class='bx bx-filter' style='color:#223249' ></i>Filtros</button>
                        </div>
                    </div>
                </div>

                <div class="w-full flex lg:flex-row flex-col flex-wrap gap-8 p-4">
                    <!-- companys -->
                    
                    <?php foreach ($companys as $company) { ?>

                        <div class="lg:w-2/5 w-full bg-white border border-lightGray shadow-sm shadow-black rounded-md flex  flex-col">
                            <div class="w-full relative">
                                <span class="assessment w-2/5 p-2 absolute bg-white text-black  rounded">
                                    <span>
                                        5.0
                                        <span class="border-l border-lightGray p-2">105 avaliações</span>
                                    </span>
                                </span>
                                <img src="<?php echo $company->getLogo() ?>" alt="" class=" border-l border-r rounded">
                            </div>
                            <div class="w-full flex flex-col gap-4 p-4">
                                <h2 class="font-Urbanist font-semibold text-xl"><?php echo $company->getName().' - '.$company->getCity().'-'.$company->getState()?></h2>
                                <h3 class="font-Poppins font-normal text-sm"><?php echo $company->getRoad().' Numero: '.$company->getNumber().' - '.$company->getDistrict()?></h3>
                                <a href="company/show/<?php echo $company->getId();?>" class="w-2/4 p-2 bg-principal10 text-white text-center font-Urbanist font-normal rounded cursor-pointer hover:underline">Detalhes</a>
                            </div>
                        </div>

                    <?php } ?>
                </div>

                
            </section>
            <section class="pagination w-1/4 flex items-center justify-around mt-8 absolute bottom-0">
                <i class='bx bx-left-arrow-alt text-2xl hover:cursor-pointer'></i>
                <span class="font-Poppins  ">Pagina 1 de 10</span>
                <i class='bx bx-right-arrow-alt text-2xl hover:cursor-pointer' ></i>
            </section>

        <?php }else{ ?>
                    <div class="w-full  text-grayInput flex flex-col gap-2 items-center justify-center p-12" >
                        <i class='bx bxs-info-circle text-4xl'></i>
                        <span class="font-Urbanist font-semibold text-xl">Não há serviços disponiveis para sua região!</span>
                    </div>
                <?php } ?>
        </main>
    </div>

    <div class="message">
        <?php echo flash('resultLocation');  ?>
    </div>

 

    <script type="module"  src="/assets/js/homeClient.js"></script>

</body>