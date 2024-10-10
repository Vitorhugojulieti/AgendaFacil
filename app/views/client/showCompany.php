<body class="flex flex-col">
    <?php require __DIR__ . '../../includes/nav.php'; ?>

    <div class="lg:w-5/6 w-full flex lg:absolute" style="left:17%; top:10%;">

        <main class="w-full flex flex-col">
                <div class="w-full max-h-72"><?php echo $map;?></div>
                <div class="details p-4 w-full flex justify-between items-center ">
                    <div class="flex items-center gap-8">
                        <img src="<?php echo '../../'.$company->getLogo() ?>" alt="" class="redondShapeImageCollaborator" style="width:7rem;height:7rem;">
                        <div class="flex flex-col gap-1">
                            <h2 class="font-Urbanist font-semibold text-3xl"><?php echo $company->getName()?></h2>
                            <h3><span class="font-semibold">Endereço:</span> <?php echo $company->getRoad(). ' - Numero: '.$company->getNumber() .' - '. $company->getCity().'-'. $company->getState()?></h3>
                            <div class="flex items-center gap-4">
                                <span class="flex gap-2">
                                    <span><span class="font-semibold">Manhã</span><?php echo ' '.$company->getOpeningHoursMorningStart()->format('H:i').' as '.$company->getOpeningHoursMorningEnd()->format('H:i') ?></span>
                                    <span><span class="font-semibold">Tarde</span><?php echo ' '.$company->getOpeningHoursAfternoonStart()->format('H:i').' as '.$company->getOpeningHoursAfternoonEnd()->format('H:i') ?></span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="w-full flex flex-col">
                    <nav class="menu w-full p-4  flex items-center justify-around " id="menuTab">
                        <label class="w-full opt opt-selected text-center border-b-2 border-lightGray pb-2  hover:cursor-pointer" for="inputServicos">
                            <input type="radio" name="opt" id="inputServicos" class="hidden" name="opt" value="services" checked>
                            <span class="font-semibold ">Serviços disponiveis</span>
                        </label>

                        <label class="w-full opt text-center  border-b-2 border-lightGray pb-2   hover:cursor-pointer" for="inputPack">
                            <input type="radio" name="opt" id="inputPack" class="hidden" name="opt" value="packs">
                            <span>Pacotes de serviços</span>
                        </label> 

                        <label class="w-full opt text-center  border-b-2 border-lightGray pb-2   hover:cursor-pointer" for="inputGalery">
                            <input type="radio" name="opt" id="inputGalery" class="hidden" name="opt" value="galery">
                            <span>Galeria</span>
                        </label>

                        <label class="w-full opt text-center  border-b-2 border-lightGray pb-2   hover:cursor-pointer" for="inputDetails">
                            <input type="radio" name="opt" id="inputDetails" class="hidden" name="opt" value="details">
                            <span>Detalhes</span>
                        </label>
                    </nav>

                    <section id="services" class="w-full p-4 hidden flex-col gap-4">
                        <h2 class="font-Urbanist font-semibold text-xl flex items-center gap-4">Serviços disponiveis <span class="p-2 border border-white text-white rounded bg-principal5 text-xs"><?php echo count($company->getServices()).' Resultados';?></span></h2>

                        <div class="services flex flex-col items-center gap-4">
                            <?php foreach ($company->getServices() as $service) { ?>
                                <div class="w-full p-4 flex justify-between items-center border border-lightGray rounded">
                                    <span class="flex items-center gap-4 font-Poppins text-lg"><i class='bx bx-chevron-right text-3xl'></i><?php echo $service->getName(); ?></span>
                                    <span class="font-Poppins text-lg"><?php echo 'R$ '.$service->getPrice(); ?></span>
                                    <div class="buttons flex items-center gap-4">
                                        <a href="#" class="bg-principal10 text-white font-Poppins p-2 rounded hover:underline">Detalhes</a>
                                        <a href="/schedule/store/<?php echo $service->getId()?>" class="text-principal10 font-Poppins border border-lightGray p-2 rounded hover:underline">Agendar</a>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </section>

                    <section id="packs" class="w-full h-full bg-orange hidden">dsasd</section>
                    <section id="galery" class="w-full h-full bg-errorColor hidden">dasd</section>
                    <section id="details" class="w-full h-full bg-sucessColor hidden">dasda</section>
                </div>

        </main>
    </div>
    <script type="module"  src="/assets/js/showCompany.js"></script>

</body>