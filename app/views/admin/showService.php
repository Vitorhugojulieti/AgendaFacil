<main class="lg:w-5/6 w-full flex lg:absolute" style="left:17%; top:10%;">
    <?php require __DIR__ . '/../includes/nav.php'; ?>

    <div class="w-full min-h-screen flex flex-col justify-start items-start bg-bgPrincipal p-4 gap-4    ">
        <?php echo $breadcrumb?>

        <div class="w-full flex flex-col gap-4">
            <h2 class="text-principal10 text-3xl font-Urbanist font-semibold">Detalhes do serviço</h2>
            <div class="w-full  bg-white shadow shadow-borderFormColor p-4 rounded-lg flex items-center gap-8">
                
                <div class="flex flex-col items-center p-4 gap-4 border-2 border-grayInput border-dashed rounded">
                    <img id="previewImage1"  alt="imagem1" src="<?php echo isset($service) ? '../../../'.$service->getImage(0) : ''?>">
                </div>
    
                <div class="flex flex-col items-center p-4 gap-4 border-2 border-grayInput border-dashed rounded">
                    <img id="previewImage1"  alt="imagem1" src="<?php echo isset($service) ? '../../../'.$service->getImage(1) : ''?>">
                </div>

                <div class="flex flex-col items-center p-4 gap-4 border-2 border-grayInput border-dashed rounded">
                    <img id="previewImage1"  alt="imagem1" src="<?php echo isset($service) ? '../../../'.$service->getImage(2) : ''?>">
                </div>

            </div>

            <div class="w-full  bg-white shadow shadow-borderFormColor  rounded-lg flex items-center justify-between'">
                
                <div class="profile w-full flex items-center justify-between gap-8">
                    <div class="w-full flex flex-col  ">
                        <div class="row w-full flex items-center justify-between p-4">
                            <h3 class="font-Urbanist font-semibold text-grayInput text-xl">Nome: <span class="text-black  font-normal"><?php echo isset($service) ? $service->getName() : '' ?></span></h3>
                            <h3 class="font-Urbanist font-semibold text-grayInput text-xl">Preço: <span class="text-black    font-normal"><?php echo isset($service) ? $service->getPrice() : '' ?></span></h3>
                            <h3 class="font-Urbanist font-semibold text-grayInput text-xl">Duração: <span class="text-black font-normal"><?php echo isset($service) ? $service->getDuration()->format('H:i').' minutos' : '' ?></span></h3>
                        </div>

                        <div class="row bg-grayBg w-full flex items-center justify-between p-4">
                            <h3 class="font-Urbanist font-semibold text-grayInput text-xl">Descrição: <span class="text-black   font-normal"><?php echo isset($service) ? $service->getDescription() : '' ?></span></h3>
                        </div>

                        <div class="row w-full flex items-center gap-8 p-4">
                            <!-- active -->
                            <?php if($service->getVisible() === 1){ ?>
                                <h3 class="font-Urbanist font-semibold text-grayInput text-xl">Ativo: <span class="w-max  font-medium text-white bg-sucessColor rounded p-1">Ativo</span></h3>
                            <?php }else{ ?>
                                <h3 class="font-Urbanist font-semibold text-grayInput text-xl">Ativo: <span class="w-max  font-medium text-white bg-errorColor rounded p-1">Inativo</span></h3>
                            <?php } ?>

                            <h3 class="font-Urbanist font-semibold text-grayInput text-xl">Data de registro: <span class="text-black   font-normal"><?php echo isset($service) ? $service->getRegistrationDate()->format('d-m-Y') : '' ?></span></h3>
                          
                        </div>

                    </div>

                </div>

            </div>
        </div>

          <!-- services -->
          <div class="w-full flex flex-col gap-4">
            <div class="w-full  bg-white shadow shadow-borderFormColor p-2 rounded-lg flex flex-col items-center " id="containerChart">
                <h3 class="font-Urbanist font-medium text-2xl " >Agendamentos e cancelamentos</h3>
                <div class="w-full"><div id="line-chart"></div>  </div>   
            </div>       
        </div>    

    </div>
    <script type="module"  src="/assets/js/showService.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
</main>