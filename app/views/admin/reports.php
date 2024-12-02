<main class="lg:w-5/6 w-full flex lg:absolute" style="left:17%; top:10%;">
    <?php require __DIR__ . '/../includes/nav.php'; ?>

    <div class="w-full min-h-screen flex flex-col justify-start items-start bg-bgPrincipal p-4 gap-8">

        <form   id="formReports" class="w-full flex flex-col gap-4">
            <legend class="text-principal10 text-3xl font-Urbanist font-semibold">Relatorios</legend>

            <div class="w-full bg-white shadow shadow-borderFormColor rounded-lg">
                <div class="w-full border-b border-b-lightGray p-4 ">
                    <span class="flex items-center gap-4"><i class='bx bxs-filter-alt text-2xl' style='color:#223249'  ></i>Filtros de pesquisa</span>
                </div>

                <div class="fields flex-col gap-8">
                    <div class="row w-full flex items-center gap-8 p-4">

                        <div class="field w-full focus-within:text-principal10 text-grayInput ">
                            <div>
                                <label for="inputFilter" >Filtro</label>
                            </div>
                            <div class="flex items-center border-2 border-grayInput   rounded focus-within:border-principal10 focus-within:text-principal10 focus-within:bg-white" style="box-shadow:0 0 10px 5px rgb(0,0,0,0.02);">
                                <i class='bx bx-rename' style=' padding-left:1rem; padding-right:1rem;'></i>
                                <select name="filter" id="inputFilter"class="w-full p-2 outline-none bg-transparent border-l-2 border-grayInput transition-all duration-300 focus:border-principal10 focus:text-black placeholder:text-placeholder ">
                                    <option value='agendamentos'  >Agendamentos</option>
                                    <option value='pagamentos'  >Pagamentos</option>
                                    <option value='recebimentos'  >Recebimentos</option>
                                </select>
                            </div>
                            <span class="text-errorColor " id="msgFilterError"></span>
                        </div>

                        <!-- campo -->
                        <div class="field w-full focus-within:text-principal10 text-borderFormColor">
                            <div>
                                <label for="inputStartDate" class="flex items-center gap-1">Data inicial</label>
                            </div>
                            <div class="flex items-center border-2 border-borderFormColor rounded focus-within:border-principal10 focus-within:text-principal10">
                                <i class='bx bxs-calendar' style='padding-left:1rem; padding-right:1rem;'></i>
                                <input type="date" name="startDate" id="inputStartDate"  class="w-full p-2 outline-none bg-transparent border-l-2 border-borderFormColor transition-all duration-300 focus:border-principal10 focus:text-black" >
                            </div>
                            <span class="text-errorColor " id="msgStartDate"></span>
                        </div>

                         <!-- campo -->
                         <div class="field w-full focus-within:text-principal10 text-borderFormColor">
                            <div>
                                <label for="inputEndDate" class="flex items-center gap-1">Data final</label>
                            </div>
                            <div class="flex items-center border-2 border-borderFormColor rounded focus-within:border-principal10 focus-within:text-principal10">
                                <i class='bx bxs-calendar' style='padding-left:1rem; padding-right:1rem;'></i>
                                <input type="date" name="endDate" id="inputEndDate"  class="w-full p-2 outline-none bg-transparent border-l-2 border-borderFormColor transition-all duration-300 focus:border-principal10 focus:text-black" >
                            </div>
                            <span class="text-errorColor " id="msgEndDate"></span>
                        </div>  

                    </div>

                    <div class="row w-full flex items-center gap-8 p-4">

                        <div class="field w-full focus-within:text-principal10 text-grayInput disabled:cursor-not-allowed">
                            <div>
                                <label for="inputStatus" >Status</label>
                            </div>
                            <div class="flex items-center border-2 border-grayInput   rounded focus-within:border-principal10 focus-within:text-principal10 focus-within:bg-white" style="box-shadow:0 0 10px 5px rgb(0,0,0,0.02);">
                                <i class='bx bx-rename' style=' padding-left:1rem; padding-right:1rem;'></i>
                                <select name="status" id="inputStatus"class="w-full p-2 outline-none bg-transparent border-l-2 border-grayInput transition-all duration-300 focus:border-principal10 focus:text-black placeholder:text-placeholder ">
                                    <option value="all">Todos</option>
                                    <option value='concluido'  >Concluido</option>
                                    <option value='confirmado'  >Confirmado</option>
                                    <option value='cancelado'  >Cancelado</option>
                                </select>
                            </div>
                            <span class="text-errorColor " id="msgStatusError"></span>
                        </div>

                        <div class="field w-full focus-within:text-principal10 text-grayInput disabled:cursor-not-allowed">
                            <div>
                                <label for="inputService" >Serviço</label>
                            </div>
                            <div class="flex items-center border-2 border-grayInput   rounded focus-within:border-principal10 focus-within:text-principal10 focus-within:bg-white" style="box-shadow:0 0 10px 5px rgb(0,0,0,0.02);">
                                <i class='bx bx-rename' style=' padding-left:1rem; padding-right:1rem;'></i>
                                <select name="service" id="inputService"class="w-full p-2 outline-none bg-transparent border-l-2 border-grayInput transition-all duration-300 focus:border-principal10 focus:text-black placeholder:text-placeholder ">
                                    <option value="all">Todos</option>
                                   <?php foreach ($services as $service) { ?>
                                        <option value=<?php echo $service->getId(); ?>  ><?php echo $service->getName();?></option>
                                   <?php } ?>
                                </select>
                            </div>
                            <span class="text-errorColor " id="msgServiceError"></span>
                        </div>

                        <div class="field w-full focus-within:text-principal10 text-grayInput disabled:cursor-not-allowed">
                            <div>
                                <label for="inputCollaborator" >Colaborador</label>
                            </div>
                            <div class="flex items-center border-2 border-grayInput   rounded focus-within:border-principal10 focus-within:text-principal10 focus-within:bg-white" style="box-shadow:0 0 10px 5px rgb(0,0,0,0.02);">
                                <i class='bx bx-rename' style=' padding-left:1rem; padding-right:1rem;'></i>
                                <select name="collaborator" id="inputCollaborator"class="w-full p-2 outline-none bg-transparent border-l-2 border-grayInput transition-all duration-300 focus:border-principal10 focus:text-black placeholder:text-placeholder ">
                                    <option value="all">Todos</option>
                                    <?php foreach ($collaborators as $collaborator) { ?>
                                        <option value=<?php echo $collaborator->getId(); ?>  ><?php echo $collaborator->getName();?></option>
                                   <?php } ?>
                                </select>
                            </div>
                            <span class="text-errorColor " id="msgCollaboratorError"></span>
                        </div>
                        

                        
                    </div>

                    <div class="buttons bg-grayBg p-4 flex justify-end items-center gap-4 rounded-b">
                        <button type="reset" id="btnReset" class="flex items-center gap-2 rounded p-2 border border-lightGray hover:underline"><i class='bx bx-x text-xl hover:no-underline' style='color:#223249' ></i>Limpar</button>
                        <button type="button" id="btnGenerate" class="flex items-center gap-2 rounded p-2 bg-principal10 text-white hover:underline"><i class='bx bxs-file-pdf text-2xl text-white'></i>Gerar </button>
                    </div>
                </div>
            </div>


            <span class="text-red " id="spanError"></span>                            

            


            
        </form>
    </div>

    <script type="module"  src="/assets/js/reports.js"></script>

</main>