<body class="flex flex-col">
    <div class="w-full h-screen flex">
        <?php require __DIR__ . '../../includes/nav.php'; ?>

        <main class="w-full flex flex-col">
            <section class="flex flex-col gap-4">
                <div class="w-full max-h-80 border-b border-borderFormColor">
                    <img src="<?php echo '../../'.$company->getLogo() ?>" alt="" class="w-full h-full" >
                </div>
                <div class="details">
                    <img src="" alt="">
                    <div>
                        <h2></h2>
                        <h3></h3>
                    </div>
                    <div>

                    </div>
                </div>
                <div class="services">
                    <?php foreach ($company->getServices() as $service) { ?>
                        <h1><?php echo $service->getName(); ?></h1>
                    <?php } ?>
                </div>
            </section>
        </main>
    </div>

</body>