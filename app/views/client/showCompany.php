<body class="flex flex-col">
    <?php require __DIR__ . '../../includes/nav.php'; ?>

    <div class="lg:w-5/6 w-full flex lg:absolute" style="left:17%; top:10%;">

        <main class="w-full flex flex-col">
                <div class="w-full max-h-72"><?php echo $map;?></div>
                <div class="details p-4 w-full flex justify-between items-center ">
                    <div class="flex items-center gap-8">
                        <img src="<?php echo '../../'.$company->getLogo() ?>" alt="" class="redondShapeImageCollaborator" style="width:7rem;height:7rem;">
                        <div class="flex flex-col gap-2">
                            <div class="flex items-center gap-4">
                                <h2 class="font-Urbanist font-semibold text-3xl"><?php echo $company->getName()?></h2>
                                <div class="flex items-start gap-2">
                                    <i class='bx bxs-star text-xl' style='color:#fbec5d'  ></i>
                                    <span class="text-base text-yellow font-Poppins font-semibold" >4.5</span>
                                </div>
                            </div>

                            <h3><span class="font-semibold">Endereço:</span> <?php echo $company->getRoad(). ' - Numero: '.$company->getNumber() .' - '. $company->getCity().'-'. $company->getState()?></h3>
                            <div class="flex items-center gap-6">
                                <a href="tel:<?php echo $company->getPhone()?>" class="outline-none p-2 rounded bg-transparent flex items-center gap-4 border border-lightGray"><i class='bx bx-phone text-2xl' style='color:#223249'></i>Ligar</a>
                                <button id="btnShare" onclick="setShareData('<?php echo $company->getName(); ?>', 'Conheça a empresa <?php echo $company->getName(); ?> no AgendaFacil', '<?php echo IMAGES_DIR . 'company/show/' . $company->getId(); ?>')" class="outline-none p-2 rounded bg-transparent flex items-center gap-4 border border-lightGray"><i class='bx bxs-share-alt text-2xl' style='color:#223249'  ></i>Compartilhar</button>
                            </div>

                        </div>
                        
                    </div>
                </div>

                <div class="w-full flex flex-col">
                    <nav class="menu w-full pt-4  flex items-center justify-around " id="menuTab">
                        <label class="w-full opt opt-selected text-center border-b-2 border-lightGray pb-2  hover:cursor-pointer" for="inputServicos">
                            <input type="radio" name="opt" id="inputServicos" class="hidden" name="opt" value="services" checked>
                            <span >Serviços disponiveis</span>
                        </label>

                        <label class="w-full opt text-center  border-b-2 border-lightGray pb-2   hover:cursor-pointer" for="inputGalery">
                            <input type="radio" name="opt" id="inputGalery" class="hidden" name="opt" value="galery">
                            <span>Galeria</span>
                        </label>

                        <label class="w-full opt text-center  border-b-2 border-lightGray pb-2   hover:cursor-pointer" for="inputDetails">
                            <input type="radio" name="opt" id="inputDetails" class="hidden" name="opt" value="details">
                            <span>Sobre</span>
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

                   
                    <section id="galery" class="bg-bgPrincipal w-full h-full p-4 hidden flex-col gap-4">
                        <h2 class="font-Urbanist font-semibold text-xl flex items-center gap-4">Galeria da empresa</h2>

                            <?php if(isset($images) && count($images) != 0){?>
                               <div class="w-full flex flex-wrap gap-4">
                                <?php foreach ($images as $image) { ?>
                                        <div class="w-1/4 border border-lightGray rounded-lg shadow shadow-borderFormColor p-2">
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

                    <section id="details" class="bg-bgPrincipal w-full h-full p-4 hidden  gap-4">
                       

                        <?php if(isset($evaluations) && count($evaluations) != 0){?>
                            <div class="w-full flex flex-col gap-4">
                             <h2 class="font-Urbanist font-semibold text-xl flex items-center gap-4">Avaliações da empresa</h2>

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


                        <div class="flex flex-col w-full bg-white items-start gap-2 border border-lightGray rounded-lg shadow shadow-borderFormColor p-2">
                            <h2 class="font-Urbanist font-semibold text-xl flex items-center gap-4">Horario de funcionamento</h2>
                            <?php $daysOfWeek = ['Domingo','Segunda-feira', 'Terça-feira', 'Quarta-feira', 'Quinta-feira', 'Sexta-feira', 'Sábado']; ?>
                            <?php foreach ($daysOfWeek as $key => $dayName) { ?>
                                <?php $hour = $company->getHourByDay($key); ?>
                                
                                <div class="flex  items-start justify-between w-full">
                                    <!-- Coluna para o nome do dia -->
                                    <div class="flex flex-col items-start w-1/2">
                                        <span class="text-grayInput<?php echo ($key == date('w')) ? 'font-bold' : ''; ?> ">
                                            <?php echo $dayName; ?>
                                        </span>
                                    </div>

                                    <!-- Coluna para os horários -->
                                    <div class="flex justify-end  gap-2 w-1/2 ">
                                        <?php if ($hour) { ?>
                                            <span class=" <?php echo !($key == date('w')) ? 'text-grayInput' : ''; ?>"><?php echo '<b>Manhã</b> ' . $hour->getOpeningHoursMorningStart()->format('H:i') . ' às ' . $hour->getOpeningHoursMorningEnd()->format('H:i'); ?></span>
                                            <span class=" <?php echo !($key == date('w')) ? 'text-grayInput' : ''; ?>"><?php echo '<b>Tarde</b>' . $hour->getOpeningHoursAfternoonStart()->format('H:i') . ' às ' . $hour->getOpeningHoursAfternoonEnd()->format('H:i'); ?></span>
                                        <?php } else { ?>
                                            <span class="text-red">Fechado</span>
                                        <?php } ?>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </section>

                </div>

        </main>
    </div>
    <script type="module"  src="/assets/js/showCompany.js"></script>

</body>