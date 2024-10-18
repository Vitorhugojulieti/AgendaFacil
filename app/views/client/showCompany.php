<body class="flex flex-col">
    <?php require __DIR__ . '../../includes/nav.php'; ?>

    <div class="lg:w-5/6 w-full flex lg:absolute" style="left:17%; top:10%;">

        <main class="w-full flex flex-col">
                <div class="w-full max-h-72"><?php echo $map;?></div>
                <div class="details p-4 w-full flex justify-between items-center ">
                    <div class="flex items-center gap-8">
                        <img src="<?php echo '../../'.$company->getLogo() ?>" alt="" class="redondShapeImageCollaborator" style="width:7rem;height:7rem;">
                        <div class="flex flex-col gap-1">
                            <div class="flex items-center gap-4">
                                <h2 class="font-Urbanist font-semibold text-3xl"><?php echo $company->getName()?></h2>
                                <div class="flex items-start gap-2">
                                    <i class='bx bxs-star text-xl' style='color:#fbec5d'  ></i>
                                    <span class="text-base text-yellow font-Poppins font-semibold" >4.5</span>
                                </div>
                            </div>

                            <h3><span class="font-semibold">Endereço:</span> <?php echo $company->getRoad(). ' - Numero: '.$company->getNumber() .' - '. $company->getCity().'-'. $company->getState()?></h3>
                            <div class="flex items-center gap-4">
                                <span class="flex gap-2">
                                    <span><span class="font-semibold">Manhã</span><?php echo ' '.$company->getOpeningHoursMorningStart()->format('H:i').' as '.$company->getOpeningHoursMorningEnd()->format('H:i') ?></span>
                                    <span><span class="font-semibold">Tarde</span><?php echo ' '.$company->getOpeningHoursAfternoonStart()->format('H:i').' as '.$company->getOpeningHoursAfternoonEnd()->format('H:i') ?></span>
                                </span>
                            </div>
                        </div>
                        <button id="btnShare" class="outline-none border-none bg-transparent"><i class='bx bxs-share-alt text-3xl' style='color:#223249'  ></i></button>
                    </div>
                </div>

                <div class="w-full flex flex-col">
                    <nav class="menu w-full pt-4  flex items-center justify-around " id="menuTab">
                        <label class="w-full opt opt-selected text-center border-b-2 border-lightGray pb-2  hover:cursor-pointer" for="inputServicos">
                            <input type="radio" name="opt" id="inputServicos" class="hidden" name="opt" value="services" checked>
                            <span >Serviços disponiveis</span>
                        </label>

                        <label class="w-full opt text-center  border-b-2 border-lightGray pb-2   hover:cursor-pointer" for="inputPack">
                            <input type="radio" name="opt" id="inputPack" class="hidden" name="opt" value="packs">
                            <span>Pacotes</span>
                        </label> 

                        <label class="w-full opt text-center  border-b-2 border-lightGray pb-2   hover:cursor-pointer" for="inputGalery">
                            <input type="radio" name="opt" id="inputGalery" class="hidden" name="opt" value="galery">
                            <span>Galeria</span>
                        </label>

                        <label class="w-full opt text-center  border-b-2 border-lightGray pb-2   hover:cursor-pointer" for="inputDetails">
                            <input type="radio" name="opt" id="inputDetails" class="hidden" name="opt" value="details">
                            <span>Avaliações</span>
                        </label>
                    </nav>

                    <section id="services" class="bg-bgPrincipal w-full p-4 hidden flex-col gap-4">
                        <div class="w-full flex items-center justify-between">
                            <h2 class="font-Urbanist font-semibold text-xl flex items-center gap-4">Serviços disponiveis <span class="p-2 border border-white text-white rounded bg-principal5 text-xs"><?php echo count($company->getServices()).' Resultados';?></span></h2>
                            <div class=" flex  search w-2/4  items-center bg-white  rounded focus-within:shadow-sm focus-within:shadow-black focus-within:border-grayInput shadow shadow-borderFormColor">
                                <input type="text" id="inputSearchService" class="w-full ml-2 outline-none bg-transparent p-2 placeholder:text-placeholder" placeholder="Buscar serviço">
                                <i class='bx bx-search p-2  text-principal10 cursor-pointer'></i>
                            </div>
                        </div>

                        <div class="services flex flex-col items-center gap-4">
                            <?php foreach ($company->getServices() as $service) { ?>
                                <div class="service bg-white w-full p-4 flex justify-between items-center border border-lightGray rounded-lg shadow shadow-borderFormColor">
                                    <div class="flex flex-col items-start">
                                        <span class="flex items-center gap-4 font-Poppins text-lg"><?php echo $service->getName(); ?></span>
                                        <span class="flex items-center gap-4 font-Poppins text-sm"><?php echo $service->showDuration(); ?></span>
                                    </div>
                                    <div class="buttons flex items-center gap-4">
                                        <span class="font-Poppins text-lg"><?php echo 'R$ '.number_format($service->getPrice(), 2, ',', '.'); ?></span>
                                        <a href="/schedule/store/<?php echo $service->getId()?>" class="bg-principal10 text-white font-Poppins rounded p-2 hover:underline">Agendar</a>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </section>

                    <section id="packs" class="bg-bgPrincipal w-full h-full p-4 hidden flex-col gap-4">
                        <h2 class="font-Urbanist font-semibold text-xl flex items-center gap-4">Pacotes disponiveis <span class="p-2 border border-white text-white rounded bg-principal5 text-xs"><?php echo count($vouchers).' Resultados';?></span></h2>

                        <div class="packs flex flex-col items-center gap-4">
                            <?php if(isset($vouchers) && count($vouchers) != 0){?>
                                <?php foreach ($vouchers as $voucher) { ?>
                                    <div class=" w-full flex flex-col items-center border border-lightGray rounded-lg shadow shadow-borderFormColor text-white">
                                        <div class="w-full bg-principal10 flex  items-center justify-between gap-4 p-6 rounded-lg">
                                                                                    
                                            <div class="w-full flex items-center justify-between">
                                                <div class="w-full flex flex-col gap-2 items-starts">
                                                    <span class="text-2xl"><?php echo $voucher->getName()?></span>
                                                    <span class="text-base"><?php echo 'Descrição: '.$voucher->getDescription() ?></span>
                                                </div>
                                                <span class="w-1/6 text-xl"><?php echo  'R$ '.number_format($voucher->getAmount(), 2, ',', '.'); ?></span>
                                            </div>

                                            <div class="w-1/4 flex items-center justify-between  pl-4 border-l border-lightGray">
                                                <span class="flex flex-col items-center gap-2">
                                                    <span class="text-3xl "><?php echo $voucher->getDiscount().' %';?></span>
                                                    <span class="text-sm ">Desconto</span>
                                                </span>
                                                <a href="/voucher/show/<?php echo $voucher->getId()?>" class="bg-white text-principal10 font-Poppins p-2 rounded hover:underline">Detalhes</a>
                                            </div>
                                        </div>
                                        <div class="w-full p-4 bg-white text-base text-text-gray rounded-lg flex items-center gap-2">
                                            <i class="bx bxs-info-circle text-xl" style="color:#71717a"  ></i>
                                            <span><?php echo 'Validade: '.$voucher->getDateExpiration()->format('d-m-Y')?></span>
                                        </div>
                                    </div>
                                <?php } ?>
                                
                            <?php }else{ ?>
                                <div class="w-full  text-grayInput flex flex-col gap-2 items-center justify-center p-12" >
                                    <i class='bx bxs-info-circle text-4xl'></i>
                                    <span class="font-Urbanist font-semibold text-xl">A empresa ainda não tem pacotes cadastrados!</span>
                                </div>
                            <?php } ?>
                        </div>
                    </section>

                    <section id="galery" class="bg-bgPrincipal w-full h-full p-4 hidden flex-col gap-4">
                        <h2 class="font-Urbanist font-semibold text-xl flex items-center gap-4">Galeria da empresa</h2>

                            <?php if(isset($images) && count($images) != 0){?>
                               <div class="w-full flex flex-col gap-4">
                                <?php foreach ($images as $image) { ?>
                                        <div class="w-2/4 border border-lightGray rounded-lg shadow shadow-borderFormColor p-2">
                                            <img src="<?php echo IMAGES_DIR.$image->getLink()?>" alt="" loading="lazy" >
                                        </div>
                                    <?php } ?>
                               </div>
                            
                            <?php }else{ ?>
                                <div class="w-full  text-grayInput flex flex-col gap-2 items-center justify-center p-12" >
                                    <i class='bx bxs-info-circle text-4xl'></i>
                                    <span class="font-Urbanist font-semibold text-xl">A empresa ainda não tem imagens cadastradas!</span>
                                </div>
                            <?php } ?>
                    </section>

                    <section id="details" class="bg-bgPrincipal w-full h-full p-4  hidden flex-col gap-4">
                        <h2 class="font-Urbanist font-semibold text-xl flex items-center gap-4">Avaliações da empresa</h2>
                            <?php if(isset($evaluations) && count($evaluations) != 0){?>
                                <div class="w-full flex flex-col gap-4">
                                    <?php foreach ($evaluations as $evaluation) { ?>
                                            <div class="w-1/4 bg-white flex flex-col items-center gap-2 border border-lightGray rounded-lg shadow shadow-borderFormColor p-2">
                                                <div class="profile flex flex-col gap-2 items-center">
                                                    <img class="redondShapeImageCollaborator" style="width:4rem; height:4rem;" src="<?php echo $evaluation->getClient()->getAvatar()?>" alt="" loading="lazy" >
                                                    <span class="font-semibold text-base"><?php echo $evaluation->getClient()->getName()?></span>
                                                </div>
                                                <div class="note">
                                                    <?php for ($i=0; $i < 5; $i++) { ?>
                                                        <?php if($i < (int) $evaluation->getNote()){ ?>
                                                            <i class='bx bxs-star text-2xl' style='color:#fbec5d'  ></i>
                                                        <?php }elseif ($i == (int) $evaluation->getNote() && ($evaluation->getNote() - (int) $evaluation->getNote()) >= 0.5) { ?>
                                                            <i class='bx bxs-star-half text-2xl' style='color:#fbec5d' ></i>
                                                        <?php }else{ ?>
                                                            <i class='bx bx-star text-2xl' style='color:#C1C1C1'  ></i>
                                                        <?php } ?>
                                                    <?php } ?>
                                                </div>
                                                <div class="feedback">
                                                    <p class="text-sm"><?php echo $evaluation->getFeedback()?></p>
                                                </div>
                                            </div>
                                        <?php } ?>
                                </div>
                            <?php }else{ ?>
                                <div class="w-full  text-grayInput flex flex-col gap-2 items-center justify-center p-12" >
                                    <i class='bx bxs-info-circle text-4xl'></i>
                                    <span class="font-Urbanist font-semibold text-xl">A empresa ainda não tem avaliações!</span>
                                </div>
                            <?php } ?>
                    </section>
                </div>

        </main>
    </div>
    <script type="module"  src="/assets/js/showCompany.js"></script>

</body>