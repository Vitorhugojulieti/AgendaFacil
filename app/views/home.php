<body class="flex flex-col overflow-x-hidden">
<?php require __DIR__ . '../includes/nav.php'; ?>

    <div class="lg:w-5/6 w-full flex lg:absolute" style="left:17%; top:10%;">

        <main class="bg-white w-full flex flex-col items-center p-4 gap-8">
   
        <div class="w-full flex items-center justify-start gap-8">
            <div class="btns flex items-center gap-4  bg-white text-principal10 p-2 rounded  border border-lightGray ">
                <button type="button"  id="btnOpenModalFilters" class="flex items-center gap-2"><i class='bx bx-filter' style='color:#223249' ></i>Filtros</button>
            </div>

            <div class="flex  search w-full  items-center bg-graySearchInput  rounded focus-within:shadow-sm focus-within:shadow-black focus-within:border-grayInput">
                <input type="text" class="w-full ml-2 outline-none bg-transparent p-2 placeholder:text-placeholder" placeholder="Buscar">
                <i class='bx bx-search p-2  text-principal10 cursor-pointer'></i>
            </div>
        </div>
        <?php if(count($companys) != 0 ){ ?>
       
                <h1 class="w-full font-Urbanist font-bold text-principal10 text-3xl ">Empresas perto de você em <?php echo $_SESSION['location']['localidade']?>(<?php echo count($companys)?>)</h1>
                
                

                <div class="w-full flex items-center justify-between flex-wrap  gap-4 ">
                    <!-- companys -->
                    
                    <?php foreach ($companys as $company) { ?>

<div class=" w-full border-b border-b-lightGray p-4  flex items-start justify-between">
    <div class="w-2/4">
        <img src="<?php echo $company->getLogo() ?>" alt="" class="w-full rounded-md">
    </div>
    
    <div class="w-full h-full flex flex-col gap-4 px-4 items-start justify-start">
        <a href="/company/show/<?php echo $company->getId()?>" class="font-Urbanist font-semibold text-2xl flex items-center gap-4"><?php echo $company->getName()?><span class="text-base text-yellow font-Poppins font-semibold" ><i class='bx bxs-star text-xl' style='color:#fbec5d'  ></i>4.5</span></a>
        <h3 class="w-full font-Poppins font-normal text-sm border-b border-lightGray pb-2"><?php echo $company->getRoad().', numero: '.$company->getNumber().', '.$company->getDistrict().' - '.$company->getCity().'-'.$company->getState()?></h3>
        <div class="w-full">
            <h4 class="text-base text-grayInput font-semibold">Serviços</h4>
            <?php $max = count($company->getServices()) > 0 ? count($company->getServices()) : [];  ?>
            <?php for($i = 0; $i < $max; $i++) { ?>
                <div class="w-full border-b border-b-lightGray py-4 flex items-center justify-between">
                    <div class="flex flex-col gap-1">
                        <span class="text-base"><?php echo $company->getServices()[$i]->getName() ?></span>
                        <span class="text-xs"><?php echo $company->getServices()[$i]->showDuration(); ?></span>
                    </div>
                    <a href="/schedule/store/<?php echo $company->getServices()[$i]->getId()?>" class="text-xs bg-principal10 text-white font-Poppins rounded p-2 hover:underline">Agendar</a>
                </div>
            <?php } ?>
        </div>
        <a href="company/show/<?php echo $company->getId();?>" class="w-2/4 p-2 bg-principal10 text-sm text-white text-center font-Urbanist font-normal rounded cursor-pointer hover:underline">Ver mais</a>
    </div>
</div>

<?php } ?>
                </div>

                
            </section>
            <!-- <section class="pagination w-1/4 flex items-center justify-around mt-8 sm:absolute sm:bottom-0">
                <i class='bx bx-left-arrow-alt text-2xl hover:cursor-pointer'></i>
                <span class="font-Poppins  ">Pagina 1 de 10</span>
                <i class='bx bx-right-arrow-alt text-2xl hover:cursor-pointer' ></i>
            </section> -->

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