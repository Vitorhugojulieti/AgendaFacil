<body class="flex flex-col">
    <div class="w-full h-screen flex">
        <?php require __DIR__ . '../../includes/nav.php'; ?>

        <main class="w-full flex flex-col">
                <img src="<?php echo '../../'.$company->getLogo() ?>" alt="" class="w-full max-h-48">
          
                <div class="details p-4 w-full flex justify-between items-center border-b-2 border-lightGray ">
                    <div class="flex items-center gap-8">
                        <img src="<?php echo '../../'.$company->getLogo() ?>" alt="" class="redondShapeImageCollaborator" style="width:7rem;height:7rem;">
                        <div class="flex flex-col">
                            <h2 class="font-Urbanist font-semibold text-3xl"><?php echo $company->getName().' - '. $company->getCity().'-'. $company->getState()?></h2>
                            <h3>Endereço <?php echo $company->getRoad(). ' - Numero: '.$company->getNumber()?></h3>
                        </div>
                    </div>
                    <div>
                        <div class="flex items-center gap-4">
                            <span>Horario de funcionamento: <?php echo $company->getOpeningHoursStart().' as '.$company->getOpeningHoursEnd() ?></span>
                            <i class='bx bx-time text-4xl'></i>
                        </div>
                    </div>
                </div>
                <div class="p-4 flex flex-col gap-4">
                    <h2 class="font-Urbanist font-semibold text-2xl flex items-center gap-4">Serviços disponiveis <span class="p-2 border border-white text-white rounded bg-principal5 text-xs"><?php echo count($company->getServices()).' Resultados';?></span></h2>
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
                </div>
        </main>
    </div>
    <script type="module"  src="/assets/js/showCompany.js"></script>

</body>