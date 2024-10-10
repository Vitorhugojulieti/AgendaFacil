<main class="lg:w-5/6 w-full flex lg:absolute " style="left:17%; top:10%; ">
        <?php  require __DIR__ . '/../includes/nav.php'; ?>

        <section class="w-full min-h-screen flex flex-col justify-start items-start bg-bgPrincipal p-4 pl-8">
            <form action="" method="post" class="bg-white shadow shadow-borderFormColor p-2 rounded-lg w-5/6 md:w-full flex flex-col items-start justify-start gap-6 px-8">
                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['token']; ?>">
                <legend class="w-full font-Urbanist font-semibold text-black text-2xl md:text-3xl ">Cadastrar novo agendamento</legend>

                <fieldset id="fieldsetSearchClient" class="w-full flex flex-col gap-2 border-t border-t-lightGrayInput pt-4">
                    <h3 class="font-Urbanist font-semibold text-black text-xl">Selecionar cliente</h3>
                    <div class="w-full flex items-center gap-4">
                        <div id="btnOpenModalSearchClient" class=" flex  search w-full  items-center bg-white  rounded focus-within:shadow-sm focus-within:shadow-black focus-within:border-grayInput shadow shadow-borderFormColor">
                            <input type="text" id="inputSearch" class="w-full ml-2 outline-none bg-transparent p-2 placeholder:text-placeholder" placeholder="Digite o telefone do cliente buscado">
                            <i class='bx bx-search p-2  text-principal10 cursor-pointer'></i>
                        </div>
                        <i class='bx bxs-help-circle text-2xl hover:text-principal10 hover:cursor-pointer' id="btnOpenModalPassword"></i>
                    </div>
                </fieldset>

                <fieldset id="fieldsetServices" class="w-full flex flex-col gap-4">
                    <h3 class="font-Urbanist font-semibold text-black text-xl">Selecionar serviços</h3>
                    <?php if(count($services) !== 0){ ?>
                        <?php foreach ($services as $service) { ?>
                            <div class="w-full p-4 flex justify-between items-center border border-lightGray rounded-lg border-l-8 border-l-principal10 shadow shadow-borderFormColor">
                                <span class="flex items-center gap-4 font-Poppins text-lg"><?php echo $service->getName(); ?></span>
                                <span class="font-Poppins text-lg"><?php echo 'R$ '.$service->getPrice(); ?></span>
                                <div class="buttons flex items-center gap-4">
                                    <a href="/schedule/removeToCart/<?php echo $service->getId()?>" class="bg-white text-principal10 font-Poppins p-2 rounded hover:underline"><i class='bx bx-trash text-2xl'></i></a>
                                </div>
                            </div>
                        <?php } ?>
                    <?php } ?>
                    <button type="button" class="font-Poppins font-normal flex items-center gap-4 p-4 pl-0" id="btnOpenModalServices"><i class='bx bx-plus text-2xl' ></i>Adicionar serviço</button>
                </fieldset>

                <fieldset id="fieldsetDate" class="w-full flex flex-col gap-4">
                    <h3 class="font-Urbanist font-semibold text-black text-xl">Selecionar data e horario</h3>
                    <div class="w-full flex flex-col gap-4 lg:flex-row">
                        <section class="w-full lg:w-2/4 flex flex-col gap-4" id="containerCalendar">
                        
                        </section>
                        <section class="bg-white w-full lg:w-2/4 flex flex-col gap-2 border border-lightGray shadow-sm shadow-black rounded-md p-2 ">
                            <h2 class="font-Urbanist font-semibold text-xl text-black w-full" id="legendTimes"></h2>
                            <div class="w-full  max-h-60 flex flex-col gap-4 p-2 overflow-y-scroll " id="containerTimes">
                        
                            </div>
                        </section>
                    </div>
                </fieldset>

                <fieldset id="fieldsetCollaborator" class="w-full flex flex-col gap-4">
                    <h3 class="font-Urbanist font-semibold text-black text-xl">Selecionar colaborador</h3>

                    <div class="w-full flex items-center justify-between ">
                        <?php if(count($collaborators) !== 0){ ?>
                            <?php foreach ($collaborators as $collaborator) {?>
                                <div class="w-full flex gap-4 p-2">
                                    <label for="collaborator<?php echo $collaborator->getId()?>" class=" flex flex-col items-center gap-2"> 
                                        <img src="<?php echo $collaborator->getAvatar()?>" alt="" class="collaborator redondShapeImageCollaborator  " style="width:5rem; height:5rem;">
                                        <input type="checkbox" name="collaborators[]" value="<?php echo $collaborator->getId()?>" id="collaborator<?php echo $collaborator->getId()?>" value="<?php echo $collaborator->getId()?>" class="hidden">
                                        <span class="name font-Poppins text-sm"><?php echo $collaborator->getName()?></span>
                                    </label>
                                </div>
                            <?php } ?>
                        <?php } ?>
                    </div>
                </fieldset>

                <fieldset id="fieldsetPayment" class="w-full flex flex-col gap-4">
                    <h3 class="font-Urbanist font-semibold text-black text-xl">Selecionar forma de pagamento</h3>
                    <div class="w-full flex items-center gap-8 p-2 pl-0">
                        <label  for="inputMethodMoney" class="method w-1/4 border border-principal10 text-principal10 rounded flex items-center justify-center gap-4 p-4 shadow shadow-borderFormColor hover:bg-principal10 hover:text-white hover:cursor-pointer" style="transition:0.4s;">
                            <input type="radio" name="method" id="inputMethodMoney" class="hidden">
                            <span>Dinheiro</span>
                            <i class='bx bx-money text-2xl'  ></i>
                        </label>

                        <label  for="inputMethodCredit" class="method w-1/4 border border-principal10 text-principal10 rounded flex items-center justify-center gap-4 p-4 shadow shadow-borderFormColor hover:bg-principal10 hover:text-white hover:cursor-pointer" style="transition:0.4s;">
                            <input type="radio" name="method" id="inputMethodCredit" class="hidden">
                            <span>Cartão de crédito</span>
                            <i class='bx  bx-credit-card text-2xl'  ></i>
                        </label>

                        <label  for="inputMethodDebit" class="method w-1/4 border border-principal10 text-principal10 rounded flex items-center justify-center gap-4 p-4 shadow shadow-borderFormColor hover:bg-principal10 hover:text-white hover:cursor-pointer" style="transition:0.4s;">
                            <input type="radio" name="method" id="inputMethodDebit" class="hidden">
                            <span>Cartão de débito</span>
                            <i class='bx  bx-credit-card text-2xl'  ></i>
                        </label>

                        <label  for="inputMethodPix" class="method w-1/4 border border-principal10 text-principal10 rounded flex items-center justify-center gap-4 p-4 shadow shadow-borderFormColor hover:bg-principal10 hover:text-white hover:cursor-pointer" style="transition:0.4s;">
                            <input type="radio" name="method" id="inputMethodPix" class="hidden">
                            <span>Pix</span>
                            <i class='bx bx-qr text-2xl' ></i>
                        </label>
                    </div>
                </fieldset>
                
                <div class="buttons w-4/6 flex gap-4 mb-4 mt-4">
                    <button type="submit" class="bg-principal10 text-white font-Poppins font-semibold rounded p-2 hover:cursor-pointer hover:underline">Cadastrar</button>
                    <a href="/" class="border border-lightGray text-principal10 font-Poppins font-semibold rounded p-2 hover:cursor-pointer hover:underline">Voltar</a>
                </div>
            </form>
        </section>



        <!-- dialog search clients -->
        <dialog id="modalSearchClient" class=" w-2/4 bg-white "  >
            <div class="w-full flex justify-between items-center mb-4">
                <button id="btnCloseModalSearchClient" class="outline-none"><i class='bx bx-x text-2xl' style='color:#dbdbdb'  ></i></button>
            </div>
        
           
        </dialog>

    <script type="module"  src="/assets/js/registerSchedule.js"></script>

</main>