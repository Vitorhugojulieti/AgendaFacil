<main class="lg:w-5/6 w-full flex lg:absolute" style="left:17%; top:10%;">
    <?php require __DIR__ . '/../includes/nav.php'; ?>

    <div class="w-full min-h-screen flex flex-col justify-start items-start bg-bgPrincipal p-4">
    <?php echo $breadcrumb?>

        <div class="w-full  bg-bgPrincipal ">
            <div class="w-full flex items-center justify-between py-4 ">
                <div class="w-full flex flex-col items-start">
                    <h2 class="text-principal10 text-3xl font-Urbanist font-semibold">Colaboradores</h2>
                </div>
                <div class="w-3/4 flex items-center gap-4">
                    <div class=" flex  search w-full  items-center bg-white  rounded focus-within:shadow-sm focus-within:shadow-black focus-within:border-grayInput shadow shadow-borderFormColor">
                        <input type="text" id="inputSearch" class="w-full ml-2 outline-none bg-transparent p-2 placeholder:text-placeholder" placeholder="Buscar">
                        <i class='bx bx-search p-2  text-principal10 cursor-pointer'></i>
                    </div>

                    <div class="w-full btns flex items-center gap-4  justify-end">
                        <button type="button"  id="btnOpenModalFilters" class="flex items-center gap-2 p-2 bg-white shadow shadow-borderFormColor rounded"><i class='bx bx-filter' style='color:#223249' ></i>Filtros</button>
                        <a href="/admin/collaborator/store" class="bg-principal10 text-white text-sm rounded p-3 flex items-center"><i class='bx bx-plus'></i>Add colaborador</a>
                    </div>
                </div>
            </div>
            <table class="w-full bg-white shadow shadow-borderFormColor p-2 rounded-lg">
                <thead class="bg-white p-4  border-b-2 border-lightGray ">
                    <tr>
                        <th class="font-Urbanist font-semibold text-grayInput text-start p-2">Colaborador</th>
                        <th class="font-Urbanist font-semibold text-grayInput text-center p-2">Data de registro</th>
                        <th class="font-Urbanist font-semibold text-grayInput text-center p-2">Ativo</th>
                        <th class="font-Urbanist font-semibold text-grayInput text-center p-2">Nivel</th>
                        <th class="font-Urbanist font-semibold text-grayInput text-center p-2">Ação</th>
                    </tr>
                </thead>
                <tbody>
                
                    <?php foreach ($collaborators as $collaborator) { ?>
                        <tr class="row even:bg-grayBg">
                            <!-- collaborator image -->
                            <td class="p-2">
                                <div class="flex items-center gap-2">
                                    <img src="<?php echo $collaborator ? '../'.$collaborator->getAvatar() : '/assets/images/avatar_default.png';?>" alt="" class="redondShapeImageCollaborator">
                                    <div class="flex flex-col ">
                                        <span class="font-semibold"><?php echo $collaborator->getName();?></span>
                                        <span><?php echo $collaborator->getEmail();?></span>
                                    </div>
                                </div>
                            </td>
                            <!-- collaborator date -->
                            <td class="p-2 text-center">
                                <span><?php echo $collaborator->getRegistrationDate()->format('d-m-Y');?></span>
                            </td>
                              <!-- collaborator ative -->
                            <?php if($collaborator->getActive() === 1){ ?>
                                <td class="p-2 text-center">
                                    <span class="w-max text-sm font-medium text-white bg-sucessColor rounded p-1">Ativo</span>
                                </td>
                            <?php }else{ ?>
                                <td class="p-2 text-center">
                                    <span class="w-max text-sm font-medium text-white bg-errorColor rounded p-1">Inativo</span>
                                </td>
                            <?php } ?>
                            <!-- collaborator nivel -->
                            <?php if($collaborator->getNivel() === 'manager'){ ?>
                                <td class="p-2 text-center">
                                    <span class="w-max text-sm font-medium text-white bg-principal7 rounded p-1"><?php echo $collaborator->getNivel();?></span>
                                </td>
                            <?php }else{ ?>
                                <td class="p-2 text-center">
                                    <span class="w-max text-sm font-medium text-white bg-orange rounded p-1"><?php echo $collaborator->getNivel();?></span>
                                </td>
                            <?php } ?>
                            
                            <!-- collaborator actions -->
                            <?php if($collaborator->getNivel() == 'manager'){?>
                                <td class="flex items-center gap-4 p-2 text-center justify-center">
                                    <a  href="/admin/collaborator/edit/<?php echo $collaborator->getId();?>"><i class='bx bx-pencil text-xl m-3'></i></a>
                                    <a href="/admin/collaborator/show/<?php echo $collaborator->getId();?>" class="hover:underline">Detalhes</a>
                                </td>
                            <?php }else {?>
                                <td class="flex items-center gap-4 p-2 text-center justify-center">
                                    <button type="button" onclick="openModalDelete(<?php echo $collaborator->getId() ?>,'<?php echo $collaborator->getName();?>')" ><i class='bx bx-trash text-xl m-3' ></i></button>
                                    <a  href="/admin/collaborator/edit/<?php echo $collaborator->getId();?>"><i class='bx bx-pencil text-xl m-3'></i></a>
                                    <a href="/admin/collaborator/show/<?php echo $collaborator->getId();?>" class="hover:underline">Detalhes</a>
                                </td>
                            <?php }?>
                        </tr> 
                    <?php } ?>
                </tbody>
            </table>
            <div class="w-full flex items-center justify-between p-4 ">
                    <span>Pagina 1 de 10</span>
                    <div class="buttons flex items-center gap-4">
                        <button class="border-2 border-lightGray rounded-xl p-2 hover:underline">Anterior</button>
                        <button class="border-2 border-lightGray rounded-xl p-2 hover:underline">Proxima</button>
                    </div>
            </div>
        </div>
    </div>
    <!-- crud flash messages -->
    <?php echo flash('resultInsertCollaborator');  ?>
    <?php echo flash('resultUpdateCollaborator');  ?>
    <?php echo flash('reultDeleteCollaborator');  ?>

     <!-- modais -->
     <dialog id="modalCollaborators" class="w-1/4 bg-white text-black rounded p-4 ">
        <div class="w-full flex justify-between items-center mb-4">
            <div class="flex flex-col gap-4 items-start ">
                <i class='bx bx-trash text-3xl' style='color:#223249'  ></i>
                <h2 class="text-xl text-principal10 font-Poppins font-semibold" id="messageDelete"></h2>  
            </div>
        </div>
        <div class="w-full flex items-center gap-4">
            <button id="btnCloseModalCollaborator"  class="w-full border border-grayInput text-principal10 p-2 rounded hover:underline ">Cancelar</button>
            <a id="btnDelete"  class="w-full bg-errorColor text-white text-center rounded p-2 border border-red hover:underline ">Inativar</a>
        </div>
    </dialog>

     <dialog id="modalFilters" class="w-2/4 bg-white text-black rounded p-4 ">
        <div class="w-full flex justify-between items-center mb-4">
            <div class="flex gap-4 items-center">
                <h2 >Filtros</h2>  
            </div>
            <button id="btnCloseModalFilters" class="outline-none"><i class='bx bx-x-circle text-3xl'></i></button>
        </div>
        <div>
            <a id="btnDelete" href="">Excluir</a>
        </div>
    </dialog>

    <script type="module"  src="/assets/js/collaborators.js"></script>

</main>