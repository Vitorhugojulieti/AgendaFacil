<body class="flex flex-col overflow-x-hidden">
    <?php require __DIR__ . '../includes/nav.php'; ?>

    <div class="lg:w-5/6 w-full flex lg:absolute" style="left:17%; top:10%;">

    <main class="bg-white w-full flex flex-col items-center p-4 gap-8">
       


        <?php if(count($companys) != 0 ){ ?>

            <div id="slidesBanners" style="max-width:90%;">
                <img src="<?php echo IMAGES_DIR.'assets/images/banner1.png'?>" class=" rounded" alt="">
                <img src="<?php echo IMAGES_DIR.'assets/images/banner2.png'?>" class=" rounded" alt="">
                <img src="<?php echo IMAGES_DIR.'assets/images/banner3.png'?>" class=" rounded" alt="">
            </div>

    
            <div class="w-full flex items-center justify-start gap-8">
                <button type="button"  id="btnOpenModalFilters" class="flex items-center gap-2 p-2 bg-white shadow shadow-borderFormColor rounded"><i class='bx bx-filter' style='color:#223249' ></i>Filtros<span id="iconFilter" class="rounded-full bg-principal10 text-white text-sm p-1 h-6 w-6 hidden justify-center items-center"></span></button>
                <div class=" flex  search w-full  items-center bg-white  rounded focus-within:shadow-sm focus-within:shadow-black focus-within:border-grayInput shadow shadow-borderFormColor">
                    <input type="text" id="inputSearchCompany" class="w-full ml-2 outline-none bg-transparent p-2 placeholder:text-placeholder" placeholder="Buscar">
                    <i class='bx bx-search p-2  text-principal10 cursor-pointer'></i>
                </div>
            </div>
       
                <h1 class="w-full font-Urbanist font-bold text-principal10 text-3xl ">Empresas perto de você em <?php echo $_SESSION['location']['localidade']?>(<?php echo count($companys)?>)</h1>
                
                

                <div class="w-full flex items-center justify-between flex-wrap  gap-4 " id="listCompanys">
                    <!-- companys -->
                    <?php foreach ($companys as $company) { ?>

                        <div class="  border border-lightGray p-4  flex flex-col gap-4 rounded" style="max-width:30%;">
                            <div class="w-full relative">
                                <img src="<?php echo IMAGES_DIR.$company->getLogo() ?>" alt="" class="w-full rounded-md" style="max-height: 200px;">
                                <img src="<?php echo IMAGES_DIR.$company->getLogo() ?>" alt="" class="w-full rounded-md redondShapeImageCollaborator absolute bottom-0 left-0 z-10" style="width:4rem; height:4rem;">
                            </div>
                            
                            <div class="w-full h-full flex flex-col gap-4 px-4 items-start justify-start">
                                <a href="http://localhost:8889/company/show/<?php echo $company->getId()?>" class="font-Urbanist font-semibold text-2xl flex items-center gap-4"><?php echo $company->getName()?><span class="text-base text-yellow font-Poppins font-semibold" ><i class='bx bxs-star text-xl' style='color:#fbec5d'  ></i>4.5</span></a>
                                <h3 class="w-full font-Poppins font-normal text-sm "><?php echo $company->getRoad().', numero: '.$company->getNumber().', '.$company->getDistrict().' - '.$company->getCity().'-'.$company->getState()?></h3>
                              
                                <a href="http://localhost:8889/company/show/<?php echo $company->getId();?>" class="w-2/4 p-2 bg-principal10 text-sm text-white text-center font-Urbanist font-normal rounded cursor-pointer hover:underline">Ver mais</a>
                            </div>
                        </div>

                    <?php } ?>
                    
                </div>
                <div class="w-full flex items-center justify-between p-4 ">
                    <span><?php echo 'Pagina '.$pagination['currentPage'].' de '.$pagination['totalPages']?></span>
                    <div class="buttons flex items-center gap-4">
                        <a href="/home/<?php echo $pagination['currentPage'] != 1 ? $pagination['currentPage'] - 1 : '';?>" class="flex items-center gap-4 text-sm   "><i class='bx bx-left-arrow-alt text-2xl hover:scale-50'   ></i>Anterior</a>
                        <a href="/home/<?php echo $pagination['currentPage'] +1;?>" class="flex items-center gap-4 text-sm   ">Proxima<i class='bx bx-right-arrow-alt text-2xl hover:scale-50'  ></i></a>
                    </div>
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
                        <span class="font-Urbanist font-semibold text-xl">Não há empresas disponiveis para sua região!</span>
                    </div>
                <?php } ?>
        </main>
    </div>

    <div class="message">
        <?php echo flash('resultLocation');  ?>
    </div>

 
    <dialog id="modalFilters" class="w-2/4 bg-white text-black rounded p-4 ">
        <div class="w-full flex justify-between items-center pb-2 border-b border-b-lightGray mb-4">
            <h2 class="text-xl font-Urbanist font-semibold" >Filtros</h2>  
            <button id="btnCloseModalFilters" class="outline-none"><i class='bx bx-x text-2xl' style='color:#dbdbdb'  ></i></button>
        </div>
        <h4 class="text-base font-Urbanist font-semibold mb-4">Categorias</h4>

        <div  class="flex flex-col gap-4">

            <div class="flex flex-wrap  gap-4 " id="containerCategory">
                <label for="radioBarbearia" class="category p-2 rounded border border-principal10 hover:cursor-pointer">Barbearia
                    <input class="hidden" id="radioBarbearia" type="radio" name="category" value="Barbearia">
                </label>

                <label for="radioSalão" class="category p-2 rounded border border-principal10 hover:cursor-pointer">Salão de beleza
                    <input class="hidden" id="radioSalão" type="radio" name="category" value="Salão de beleza">
                </label>

                <label for="radioSpa" class="category p-2 rounded border border-principal10 hover:cursor-pointer">Spa
                    <input class="hidden" id="radioSpa" type="radio" name="category" value="Spa">
                </label>

                <label for="radioClínica" class="category p-2 rounded border border-principal10 hover:cursor-pointer">Clínica de estética
                    <input class="hidden" id="radioClínica" type="radio" name="category" value="Clínica de estética">
                </label>

                <label for="radioEstudio" class="category p-2 rounded border border-principal10 hover:cursor-pointer">Estudio de tatuagem
                    <input class="hidden" id="radioEstudio" type="radio" name="category" value="Estudio de tatuagem">
                </label>

                <label for="radioPet" class="category p-2 rounded border border-principal10 hover:cursor-pointer">Pet-shop
                    <input class="hidden" id="radioPet" type="radio" name="category" value="Pet-shop">
                </label>

                <label for="radioManutencao" class="category p-2 rounded border border-principal10 hover:cursor-pointer">Manutenção e Reformas
                    <input class="hidden" id="radioManutencao" type="radio" name="category" value="Manutenção e Reformas">
                </label>

                <label for="radioOutros" class="category p-2 rounded border border-principal10 hover:cursor-pointer">Outros serviços
                    <input class="hidden" id="radioOutros" type="radio" name="category" value="Outros serviços">
                </label>

                <label for="radioAll" class="category p-2 rounded border border-principal10 hover:cursor-pointer">Todos
                    <input class="hidden" id="radioAll" type="radio" name="category" value="">
                </label>
            </div>

            <div class="w-full flex justify-center items-center gap-4 mt-4">
                <button id="btnReset" class="w-1/4 border border-grayInput text-principal10 text-sm p-2 rounded hover:underline ">Resetar</button>
                <button id="btnFilter" class="w-1/4 bg-principal10 text-white text-sm text-center rounded p-2 border  hover:underline ">Aplicar</button>
            </div>
        </div>
    </dialog>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="/assets/js/slick.min.js"></script>
    <script type="module"  src="/assets/js/homeClient.js" ></script>


</body>