<main class="lg:w-5/6 w-full flex lg:absolute" style="left:17%; top:10%;">
    <?php require __DIR__ . '/../includes/nav.php'; ?>

    <div class="w-full min-h-screen flex flex-col justify-start items-start bg-bgPrincipal p-4 gap-4    ">
        <?php echo $breadcrumb?>

        <div class="w-full flex flex-col gap-4">
            <h2 class="text-principal10 text-3xl font-Urbanist font-semibold">Detalhes do colaborador</h2>
            <div class="w-full  bg-white shadow shadow-borderFormColor  rounded-lg flex items-center justify-between'">
                
                <div class="profile w-full flex items-center justify-between gap-8">
                    <div class="w-1/5 p-2 flex flex-col items-center justify-center gap-4">
                        <img id="btnOpenPopUpAvatar" src="<?php echo isset($collaborator) ? '../../../'.$collaborator->getAvatar() : '/assets/images/avatar_default.png';?>" alt="" class="redondShapeImageCollaborator " style="width:7rem; height:7rem;">
                        <h3 class="font-Urbanist font-semibold text-black text-xl"><?php echo isset($collaborator) ? $collaborator->getName() : '' ?></h3>
                    </div>
                    <div class="w-4/5 flex flex-col  border-l border-l-lightGray ">
                        <div class="row w-full flex items-center justify-between p-4">
                            <h3 class="font-Urbanist font-semibold text-grayInput text-xl">Email: <span class="text-black  font-normal"><?php echo isset($collaborator) ? $collaborator->getEmail() : '' ?></span></h3>
                            <h3 class="font-Urbanist font-semibold text-grayInput text-xl">CPF: <span class="text-black    font-normal"><?php echo isset($collaborator) ? $collaborator->getCpf() : '' ?></span></h3>
                            <h3 class="font-Urbanist font-semibold text-grayInput text-xl">Comissão: <span class="text-black font-normal"><?php echo isset($collaborator) ? $collaborator->getCommission() .'%': '' ?></span></h3>
                        </div>

                        <div class="row bg-grayBg w-full flex items-center justify-between p-4">
                            <h3 class="font-Urbanist font-semibold text-grayInput text-xl">Telefone: <span class="text-black   font-normal"><?php echo isset($collaborator) ? $collaborator->getPhone() : '' ?></span></h3>
                            <h3 class="font-Urbanist font-semibold text-grayInput text-xl">Data de registro: <span class="text-black   font-normal"><?php echo isset($collaborator) ? $collaborator->getRegistrationDate()->format('d-m-Y') : '' ?></span></h3>
                        </div>

                        <div class="row w-full flex items-center gap-8 p-4">
                            <!-- active -->
                            <?php if($collaborator->getActive() === 1){ ?>
                                <h3 class="font-Urbanist font-semibold text-grayInput text-xl">Ativo: <span class="w-max  font-medium text-white bg-sucessColor rounded p-1">Ativo</span></h3>
                            <?php }else{ ?>
                                <h3 class="font-Urbanist font-semibold text-grayInput text-xl">Ativo: <span class="w-max  font-medium text-white bg-errorColor rounded p-1">Inativo</span></h3>
                            <?php } ?>

                            <!-- nivel -->
                            <?php if($collaborator->getNivel() === 'manager'){ ?>
                                <h3 class="font-Urbanist font-semibold text-grayInput text-xl">Nivel: <span class="w-max  font-medium text-white bg-principal7 rounded p-1"><?php echo isset($collaborator) ? $collaborator->getNivel() : '' ?></span></h3>
                            <?php }else{ ?>
                                <h3 class="font-Urbanist font-semibold text-grayInput text-xl">Nivel: <span class="w-max  font-medium text-white bg-orange rounded p-1"><?php echo isset($collaborator) ? $collaborator->getNivel() : '' ?></span></h3>
                            <?php } ?>
                        </div>

                        <div class="row bg-grayBg w-full flex flex-col  p-4">
                            <h3 class="font-Urbanist font-semibold text-grayInput text-xl">Serviços realizados:</h3>
                            <div class="w-full flex items-center gap-8">
                                <?php foreach ($services as $service) { ?>
                                    <h3 class="font-Urbanist  text-black text-xl font-normal"><?php echo $service->getName(); ?></h3>
                                <?php }?>
                            </div>
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
    <script type="module"  src="/assets/js/showCollaborator.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
</main>