<main class="lg:w-5/6 w-full flex lg:absolute" style="left:17%; top:10%;">
    <?php require __DIR__ . '/../includes/nav.php'; ?>
    <!-- crud flash messages -->
    <?php echo flash('resultInsertService');  ?>
    <?php echo flash('resultUpdateService');  ?>

    <div class="w-full min-h-screen flex flex-col justify-start items-start bg-bgPrincipal p-4 ">

        <div class="w-full  bg-bgPrincipal ">
            <div class="w-full flex items-center justify-between py-4">
                <div class="w-full flex flex-col items-start">
                    <h2 class="text-principal10 text-3xl font-Urbanist font-semibold">Notificações</h2>
                </div>
              
            </div>
            <?php if(count($notifications) !== 0 ){ ?>
            <table class="w-full bg-white shadow shadow-borderFormColor p-2 rounded-lg">
                <thead class="bg-white p-4  border-b-2 border-lightGray  ">
                    <tr >
                        <th class="font-Urbanist font-semibold text-grayInput text-start p-2">Mensagem</th>
                        <th class="font-Urbanist font-semibold text-grayInput text-center p-2">Data</th>
                        <th class="font-Urbanist font-semibold text-grayInput text-center p-2">Visualizada</th>
                        <th class="font-Urbanist font-semibold text-grayInput text-center p-2">Ação</th>
                    </tr>
                </thead>
                <tbody>
                        <?php foreach ($notifications as $notification) { ?>
                            <tr class="row even:bg-grayBg">
                                <!-- collaborator image -->
                                <td class="p-2 ">
                                    <div class="flex items-center gap-2">
                                        <div class="w-full flex flex-col">
                                            <h3 class="font-semibold"><?php echo $notification->getMessage();?></h3>
                                        </div>
                                    </div>
                                </td>
                             
                                <!-- collaborator date -->
                                <td class="p-2 text-center">
                                    <span><?php echo $notification->getDate()->format('d-m-Y');?></span>
                                </td>

                                <?php if($notification->getNotified() == 1){ ?>
                                    <td class="p-2 text-center">
                                        <span class="bg-sucessColor text-white rounded p-1">Sim</span>
                                    </td>
                                <?php }else{ ?>
                                    <td class="p-2 text-center">
                                        <span class="bg-errorColor text-white rounded p-1">Não</span>
                                    </td>
                                <?php } ?>
                                

                           
                                <!-- collaborator actions -->
                                <td class="flex items-center justify-center gap-4 p-2 text-center">
                                    <a  class="hover:underline" href="<?php echo $notification->getLink();?>">Detalhes</a>
                                    <a class="hover:underline" href="/admin/notification/markNotified/<?php echo $notification->getId();?>" >Marcar como lida</a>
                                </td>
                            </tr> 
                        <?php } ?> 
                </tbody>
            </table>
       

            <?php }else{ ?>
                    <div class="w-full  text-grayInput flex flex-col gap-2 items-center justify-center p-12" >
                        <i class='bx bxs-info-circle text-4xl'></i>
                        <span class="font-Urbanist font-semibold text-xl">Você não tem notificações!</span>
                    </div>
                <?php } ?>
        </div>
    
    </div>


     <!-- modais -->
    <dialog id="modalService" class="w-1/4 bg-white text-black rounded p-4 ">
        <div class="w-full flex justify-between items-center mb-4">
            <div class="flex flex-col gap-4 items-start ">
                <i class='bx bx-trash text-3xl' style='color:#223249'  ></i>
                <h2 class="text-xl text-principal10 font-Poppins font-semibold" id="messageDelete"></h2>  
            </div>
        </div>
        <div class="w-full flex items-center gap-4">
            <button id="btnCloseModalService"  class="w-full border border-grayInput text-principal10 p-2 rounded hover:underline ">Cancelar</button>
            <a id="btnDelete"  class="w-full bg-red text-white text-center rounded p-2 border  hover:underline ">Inativar</a>
        </div>
    </dialog>

     <dialog id="modalFilters" class="w-1/4 bg-white text-black rounded p-4 ">
        <div class="w-full flex justify-between items-center pb-2 border-b border-b-lightGray mb-4">
            <h2 class="text-xl font-Urbanist font-semibold" >Filtros</h2>  
            <button id="btnCloseModalFilters" class="outline-none"><i class='bx bx-x text-2xl' style='color:#dbdbdb'  ></i></button>
        </div>
        <div  class="flex flex-col gap-6">
            <div class="flex flex-col justify-start gap-2 ">
                <h4 class="text-base font-Urbanist font-semibold ">Duração</h4>
                <div class="w-full flex flex-col gap-2">
                    <input type="range" name="maxDuration" id="inputRangeDuration" step=10 value="0">
                    <span id="viewRangeDuration"></span>
                </div>
            </div>

            <div class="flex flex-col justify-start gap-2 ">
                <h4 class="text-base font-Urbanist font-semibold ">Preço</h4>
                <div class="w-full flex flex-col gap-2">
                    <input type="range" name="maxPrice" id="inputRangePrice" step=10 value="0">
                    <span id="viewRangePrice"></span>
                </div>
            </div>

            <div class="flex flex-col justify-start gap-2">
                <h4 class="text-base font-Urbanist font-semibold ">Status</h4>
                <div class="filter-status w-full flex items-center justify-between gap-8" id="containerStatus">
                    <label for="radioActive" class="w-full flex items-center gap-2 bg-principal5 text-white justify-center p-2 rounded hover:cursor-pointer hover:underline">
                        <input type="radio" name="status" value="1" id="radioActive" class="hidden">
                        <span class="text-sm">Ativos</span>
                    </label>

                    <label for="radioInactive" class="w-full flex items-center gap-2 bg-principal5 text-white justify-center p-2 rounded hover:cursor-pointer hover:underline">
                        <input type="radio" name="status" value="0" id="radioInactive" class="hidden">
                        <span class="text-sm">Inativos</span>
                    </label>

                    <label for="radioAll" class="w-full flex items-center gap-2 bg-principal10 text-white justify-center p-2 rounded hover:cursor-pointer hover:underline">
                        <input type="radio" name="status" value="" id="radioAll" class="hidden" checked>
                        <span class="text-sm">Todos</span>
                    </label>
                
                </div>
            </div>

            <div class="w-full flex justify-center items-center gap-4 mt-4">
                <button id="btnReset" class="w-1/4 border border-grayInput text-principal10 text-sm p-2 rounded hover:underline ">Resetar</button>
                <button id="btnFilter" class="w-1/4 bg-principal10 text-white text-sm text-center rounded p-2 border  hover:underline ">Aplicar</button>
            </div>
        </div>
    </dialog>

    <script type="module"  src="/assets/js/service.js"></script>

</main>