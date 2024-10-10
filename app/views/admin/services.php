<main class="lg:w-5/6 w-full flex lg:absolute" style="left:17%; top:10%;">
    <?php require __DIR__ . '/../includes/nav.php'; ?>
    <!-- crud flash messages -->
    <?php echo flash('resultInsertService');  ?>
    <?php echo flash('resultUpdateService');  ?>

    <div class="w-full min-h-screen flex flex-col justify-start items-start bg-bgPrincipal p-4 ">
        <?php echo $breadcrumb?>

        <div class="w-full  bg-bgPrincipal ">
            <div class="w-full flex items-center justify-between py-4">
                <div class="w-full flex flex-col items-start">
                    <h2 class="text-principal10 text-3xl font-Urbanist font-semibold">Serviços</h2>
                </div>
                <div class="w-3/4 flex items-center gap-2">
                    <div class=" flex  search w-full  items-center bg-white  rounded focus-within:shadow-sm focus-within:shadow-black focus-within:border-grayInput shadow shadow-borderFormColor">
                        <input type="text" id="inputSearch" class="w-full ml-2 outline-none bg-transparent p-2 placeholder:text-placeholder" placeholder="Buscar">
                        <i class='bx bx-search p-2  text-principal10 cursor-pointer'></i>
                    </div>

                    <div class="w-full btns flex items-center gap-4 justify-end">
                        <button type="button"  id="btnOpenModalFilters" class="flex items-center gap-2 p-2 bg-white shadow shadow-borderFormColor rounded"><i class='bx bx-filter' style='color:#223249' ></i>Filtros</button>
                        <!-- pop up filter -->
                        <div class="hidden items-center gap-2 p-2 bg-white shadow shadow-borderFormColor rounded">
                            <i class='bx bx-filter' style='color:#223249' ></i>
                            <select name="" id="" class="border-none outline-none" >
                                <option value="" check>Todos</option>
                                <option value="">Confirmados</option>
                                <option value="">Cancelados</option>
                                <option value="">Aguardando pagamento</option>
                            </select>
                        </div>

                        <a href="/admin/service/store" class="bg-principal10 text-white hover:underline text-sm rounded p-3 flex items-center"><i class='bx bx-plus'></i>Add serviço</a>
                    </div>
                </div>
            </div>
            <?php if(count($services) !== 0 ){ ?>
            <table class="w-full bg-white shadow shadow-borderFormColor p-2 rounded-lg">
                <thead class="bg-white p-4  border-b-2 border-lightGray  ">
                    <tr >
                        <th class="font-Urbanist font-semibold text-grayInput text-start p-2">Serviço</th>
                        <th class="font-Urbanist font-semibold text-grayInput text-center p-2">Preço</th>
                        <th class="font-Urbanist font-semibold text-grayInput text-center p-2">Duração</th>
                        <th class="font-Urbanist font-semibold text-grayInput text-center p-2">Ativo</th>
                        <th class="font-Urbanist font-semibold text-grayInput text-center p-2">Ação</th>
                    </tr>
                </thead>
                <tbody>
                        <?php foreach ($services as $service) { ?>
                            <tr class="row even:bg-grayBg">
                                <!-- collaborator image -->
                                <td class="p-2 ">
                                    <div class="flex items-center gap-2">
                                        <div class="w-full flex flex-col">
                                            <h3 class="font-semibold"><?php echo $service->getName();?></h3>
                                        </div>
                                    </div>
                                </td>
                                <!-- collaborator service -->
                                <td class="p-2 text-center">
                                    <span><?php echo $service->getPrice();?></span>
                                </td>
                                <!-- collaborator date -->
                                <td class="p-2 text-center">
                                    <span><?php echo $service->getDuration()->format('H:i');?></span>
                                </td>

                                <?php if($service->getVisible() == 1){ ?>
                                    <td class="p-2 text-center">
                                        <span class="bg-sucessColor text-white rounded p-1">Ativo</span>
                                    </td>
                                <?php }else{ ?>
                                    <td class="p-2 text-center">
                                        <span class="bg-errorColor text-white rounded p-1">Inativo</span>
                                    </td>
                                <?php } ?>
                                

                           
                                <!-- collaborator actions -->
                                <td class="flex items-center justify-center gap-4 p-2 text-center">
                                    <button type="button" onclick="openModalDelete(<?php echo $service->getId() ?>,'<?php echo $service->getName();?>')" ><i class='bx bx-trash text-xl m-3' ></i></button>
                                    <a  href="/admin/service/edit/<?php echo $service->getId();?>"><i class='bx bx-pencil text-xl m-3'></i></a>
                                    <a href="/admin/service/show/<?php echo $service->getId();?>" class="hover:underline">Detalhes</a>
                                </td>
                            </tr> 
                        <?php } ?> 
                </tbody>
            </table>
            <div class="w-full flex items-center justify-between p-4 ">
                    <span>Pagina 1 de 10</span>
                    <div class="buttons flex items-center gap-4">
                        <button class="border-2 border-grayInput rounded-xl p-2 hover:underline">Anterior</button>
                        <button class="border-2 border-grayInput rounded-xl p-2 hover:underline">Proxima</button>
                    </div>
            </div>

            <?php }else{ ?>
                    <div class="w-full  text-grayInput flex flex-col gap-2 items-center justify-center p-12" >
                        <i class='bx bxs-info-circle text-4xl'></i>
                        <span class="font-Urbanist font-semibold text-xl">Você não tem serviços cadastrados!</span>
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
            <a id="btnDelete"  class="w-full bg-errorColor text-white text-center rounded p-2 border border-red hover:underline ">Inativar</a>
        </div>
    </dialog>

     <dialog id="modalFilters" class="w-2/4 bg-white text-black rounded p-4 ">
        <div class="w-full flex justify-between items-center mb-4">
            <h2 class="text-2xl font-Urbanist font-semibold" >Filtros</h2>  
            <button id="btnCloseModalFilters" class="outline-none"><i class='bx bx-x text-2xl' style='color:#dbdbdb'  ></i></button>
        </div>
        <div class="flex flex-col justify-start gap-2">
            <h4 class="text-xl font-Urbanist font-semibold ">Periodo</h4>
           
        </div>

        <div class="flex flex-col justify-start gap-2">
            <h4 class="text-xl font-Urbanist font-semibold ">Status</h4>
            <div class="filter-status w-full flex items-center justify-between">
                <label for="checkCanceled" class="flex items-center gap-2">
                    <input type="checkbox" name="canceled" id="checkCanceled">
                    <span>Concluido</span>
                </label>

                <label for="checkCanceled" class="flex items-center gap-2">
                    <input type="checkbox" name="canceled" id="checkCanceled">
                    <span>Cancelado</span>
                </label>

                <label for="checkCanceled" class="flex items-center gap-2">
                    <input type="checkbox" name="canceled" id="checkCanceled">
                    <span>Aguardando pagamento</span>
                </label>
            
            </div>
        </div>
    </dialog>

    <script type="module"  src="/assets/js/service.js"></script>

</main>