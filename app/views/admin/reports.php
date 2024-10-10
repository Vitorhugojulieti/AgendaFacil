<main class="lg:w-5/6 w-full flex lg:absolute" style="left:17%; top:10%;">
    <?php require __DIR__ . '/../includes/nav.php'; ?>

    <div class="w-full min-h-screen flex flex-col justify-start items-start bg-bgPrincipal p-4 gap-8">
        <?php echo $breadcrumb?>

        <div class="w-full flex flex-col gap-4">
            <h2 class="text-principal10 text-3xl font-Urbanist font-semibold">Relatorios</h2>

            <div class="w-full bg-white shadow shadow-borderFormColor rounded-lg">
                <div class="w-full border-b border-b-lightGray p-4 ">
                    <span class="flex items-center gap-4"><i class='bx bxs-filter-alt text-2xl' style='color:#223249'  ></i>Filtros de pesquisa</span>
                </div>

                <div class="fields flex-col gap-8">
                    <div class="row w-full flex items-center gap-8 p-4">

                        <div class="field w-full focus-within:text-principal10 text-grayInput ">
                            <div>
                                <label for="inputActive" >Categoria</label>
                            </div>
                            <div class="flex items-center border-2 border-grayInput   rounded focus-within:border-principal10 focus-within:text-principal10 focus-within:bg-white" style="box-shadow:0 0 10px 5px rgb(0,0,0,0.02);">
                                <i class='bx bx-rename' style=' padding-left:1rem; padding-right:1rem;'></i>
                                <select name="category" id="inputActive"class="w-full p-2 outline-none bg-transparent border-l-2 border-grayInput transition-all duration-300 focus:border-principal10 focus:text-black placeholder:text-placeholder ">
                                    <option value=1  >Agendamentos</option>
                                    <option value=1  >Cancelamentos</option>
                                    <option value=0  >Pagamentos</option>
                                    <option value=0  >Recebimentos</option>
                                </select>
                            </div>
                            <span class="text-errorColor " id="msgNameError"><?php echo flash('name');  ?></span>
                        </div>

                        <!-- campo -->
                        <div class="field w-full focus-within:text-principal10 text-borderFormColor">
                            <div>
                                <label for="inputOpeningHoursStart" class="flex items-center gap-1">Data inicial</label>
                            </div>
                            <div class="flex items-center border-2 border-borderFormColor rounded focus-within:border-principal10 focus-within:text-principal10">
                                <i class='bx bxs-calendar' style='padding-left:1rem; padding-right:1rem;'></i>
                                <input type="date" name="openingHoursStart" id="inputOpeningHoursStart" value="<?php echo old('duration') ?? (isset($company) ? $company->getOpeningHoursStart()->format('H:i') : ''); ?>" class="w-full p-2 outline-none bg-transparent border-l-2 border-borderFormColor transition-all duration-300 focus:border-principal10 focus:text-black" >
                            </div>
                            <span class="text-errorColor " id="msgOpeningHoursStartError"><?php echo flash('openingHoursStart');  ?></span>
                        </div>

                         <!-- campo -->
                         <div class="field w-full focus-within:text-principal10 text-borderFormColor">
                            <div>
                                <label for="inputOpeningHoursStart" class="flex items-center gap-1">Data final</label>
                            </div>
                            <div class="flex items-center border-2 border-borderFormColor rounded focus-within:border-principal10 focus-within:text-principal10">
                                <i class='bx bxs-calendar' style='padding-left:1rem; padding-right:1rem;'></i>
                                <input type="date" name="openingHoursStart" id="inputOpeningHoursStart" value="<?php echo old('duration') ?? (isset($company) ? $company->getOpeningHoursStart()->format('H:i') : ''); ?>" class="w-full p-2 outline-none bg-transparent border-l-2 border-borderFormColor transition-all duration-300 focus:border-principal10 focus:text-black" >
                            </div>
                            <span class="text-errorColor " id="msgOpeningHoursStartError"><?php echo flash('openingHoursStart');  ?></span>
                        </div>  

                    </div>

                    <div class="row w-full flex items-center gap-8 p-4">

                        <div class="field w-full focus-within:text-principal10 text-grayInput ">
                            <div>
                                <label for="inputActive" >Colaborador</label>
                            </div>
                            <div class="flex items-center border-2 border-grayInput   rounded focus-within:border-principal10 focus-within:text-principal10 focus-within:bg-white" style="box-shadow:0 0 10px 5px rgb(0,0,0,0.02);">
                                <i class='bx bx-rename' style=' padding-left:1rem; padding-right:1rem;'></i>
                                <select name="category" id="inputActive"class="w-full p-2 outline-none bg-transparent border-l-2 border-grayInput transition-all duration-300 focus:border-principal10 focus:text-black placeholder:text-placeholder ">
                                    <option value=1  >Serviço</option>
                                    <option value=0  >Colaborador</option>
                                    <!-- <option value=0  >Recebimentos</option> -->
                                </select>
                            </div>
                            <span class="text-errorColor " id="msgNameError"><?php echo flash('name');  ?></span>
                        </div>

                        <div class="field w-full focus-within:text-principal10 text-grayInput ">
                            <div>
                                <label for="inputActive" >Serviço</label>
                            </div>
                            <div class="flex items-center border-2 border-grayInput   rounded focus-within:border-principal10 focus-within:text-principal10 focus-within:bg-white" style="box-shadow:0 0 10px 5px rgb(0,0,0,0.02);">
                                <i class='bx bx-rename' style=' padding-left:1rem; padding-right:1rem;'></i>
                                <select name="category" id="inputActive"class="w-full p-2 outline-none bg-transparent border-l-2 border-grayInput transition-all duration-300 focus:border-principal10 focus:text-black placeholder:text-placeholder ">
                                    <option value=1  >Serviço</option>
                                    <option value=0  >Colaborador</option>
                                    <!-- <option value=0  >Recebimentos</option> -->
                                </select>
                            </div>
                            <span class="text-errorColor " id="msgNameError"><?php echo flash('name');  ?></span>
                        </div>

                        <div class="field w-full focus-within:text-principal10 text-grayInput ">
                            <div>
                                <label for="inputActive" >Categoria</label>
                            </div>
                            <div class="flex items-center border-2 border-grayInput   rounded focus-within:border-principal10 focus-within:text-principal10 focus-within:bg-white" style="box-shadow:0 0 10px 5px rgb(0,0,0,0.02);">
                                <i class='bx bx-rename' style=' padding-left:1rem; padding-right:1rem;'></i>
                                <select name="category" id="inputActive"class="w-full p-2 outline-none bg-transparent border-l-2 border-grayInput transition-all duration-300 focus:border-principal10 focus:text-black placeholder:text-placeholder ">
                                    <option value=1  >Serviço</option>
                                    <option value=0  >Colaborador</option>
                                    <!-- <option value=0  >Recebimentos</option> -->
                                </select>
                            </div>
                            <span class="text-errorColor " id="msgNameError"><?php echo flash('name');  ?></span>
                        </div>
                        

                        
                    </div>

                    <div class="buttons bg-grayBg p-4 flex justify-end items-center gap-4 rounded-b">
                        <button class="flex items-center gap-2 rounded p-2 border border-lightGray hover:underline"><i class='bx bx-x text-xl hover:no-underline' style='color:#223249' ></i>Limpar</button>
                        <button class="flex items-center gap-2 rounded p-2 bg-principal10 text-white hover:underline"><i class='bx bx-search hover:no-underline'></i>Buscar </button>
                    </div>
                </div>
            </div>




            <div class="w-full bg-white shadow shadow-borderFormColor rounded-lg">
                <div class="w-full border-b border-b-lightGray p-4 ">
                    <span class="flex items-center gap-4"><i class='bx bx-list-ul text-2xl' style='color:#223249'  ></i>Resultados da pesquisa</span>
                </div>
                <div class="w-full border-b border-b-lightGray p-4 flex items-center justify-between">
                    <span class="flex items-center gap-2 hover:underline hover:cursor-pointer"><i class='bx bxs-file-pdf text-2xl text-principal10'></i>Exportar para PDF</span>
                    <div class="lg:flex hidden search w-2/4  items-center bg-graySearchInput  rounded focus-within:shadow-sm focus-within:shadow-black focus-within:border-grayInput">
                        <input type="text" class="w-full ml-2 outline-none bg-transparent p-2 placeholder:text-placeholder" placeholder="Buscar">
                        <i class='bx bx-search p-2  text-principal10 cursor-pointer'></i>
                    </div>
                </div>

                <div class="fields flex-col gap-8">
                        <table class="w-full bg-white shadow shadow-borderFormColor p-2 ">
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
                                        <tr class="even:bg-grayBg">
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

                        
                    </div>

                    <div class="pagination bg-grayBg p-4 flex justify-end items-center gap-4 rounded-b">
                        <button class="flex items-center gap-2 rounded p-2 border border-lightGray hover:underline"><i class='bx bx-x text-xl hover:no-underline' style='color:#223249' ></i>Limpar</button>
                        <button class="flex items-center gap-2 rounded p-2 bg-principal10 text-white hover:underline"><i class='bx bx-search hover:no-underline'></i>Buscar </button>
                    </div>
                </div>
            </div>


            
        </div>
    </div>
</main>