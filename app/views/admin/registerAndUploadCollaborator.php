    <main class="flex">
        <?php require __DIR__ . '/../includes/nav.php'; ?>

        <div class="w-full min-h-screen flex flex-col justify-start items-start bg-white p-4">
            <form action="<?php echo $action;?>" method="post" enctype="multipart/form-data" id="formCadCollaborator" class="w-5/6 md:w-full flex flex-col items-start justify-start gap-4 ">
                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['token']; ?>">
                <legend id="legendForm" class="w-full font-Urbanist font-semibold text-black text-2xl md:text-3xl border-b-2 border-b-lightGray"><?php echo $legend; ?></legend>
                <input type="hidden" name="idCollaborator" id="idCollaborator" type="number" value="<?php echo isset($collaborator) ? $collaborator->getId():'';?>">
                <!-- container data admin -->
                <fieldset id="containerDataAdmin" class="w-full  justify-start items-start">

                    <div class="w-max flex flex-col gap-4 justify-start items-start">
                        <input type="file" name="avatar" id="inputAvatar" class="hidden">
                        <label for="inputAvatar" class="hover:cursor-pointer w-4/5 flex flex-col items-center justify-center p-2">
                            <img id="previewAvatar" src="<?php echo isset($collaborator) ? $collaborator->getAvatar() : AVATAR_DEFAULT?>"  alt="avatar" class="redondShapeImage" style="width:10rem; height:8rem;">
                        </label>
                        <span class="text-errorColor " id="msgAvatarError"><?php echo flash('avatar');  ?></span>
                    </div>

                    <h2 class="w-full font-Urbanist font-semibold text-black text-xl md:text-2xl border-b-2 border-b-lightGray mb-4">Dados do colaborador</h2>

                    <div class="w-full lg:grid lg:grid-rows-1 lg:grid-cols-2 gap-12 md:flex md:w-5/6 md:flex-col ">
                            <!-- column 1 -->
                            <div class="w-full col-span-1 row-span-1 col-start-1 flex flex-col items-start justify-center gap-4 ">
                                <!-- campo -->
                                <div class="field w-full focus-within:text-principal10 text-borderFormColor">
                                    <div>
                                        <label for="inputName" >Nome</label>
                                    </div>
                                    <div class="flex items-center border-2 border-borderFormColor rounded focus-within:border-principal10 focus-within:text-principal10">
                                        <i class='bx bx-user' style=' padding-left:1rem; padding-right:1rem;'></i>
                                        <input type="text" name="name" id="inputName" value="<?php echo old('name') ?? (isset($collaborator) ? $collaborator->getName() : ''); ?>" class="w-full p-2 outline-none bg-transparent border-l-2 border-borderFormColor transition-all duration-300 focus:border-principal10 focus:text-black" placeholder="Digite seu nome completo">
                                    </div>
                                    <span class="text-errorColor " id="msgNameError"><?php echo flash('name');  ?></span>
                                </div>
                                <!-- campo -->
                                <div class="field w-full focus-within:text-principal10 text-borderFormColor">
                                    <label for="inputPhone" >Telefone</label>
                                    <div class="flex items-center border-2 border-borderFormColor rounded focus-within:border-principal10 focus-within:text-principal10">
                                        <i class='bx bx-phone' style='padding-left:1rem; padding-right:1rem; '></i>
                                        <input type="text" name="phone" id="inputPhone" maxlength="15" value="<?php echo old('phone') ?? (isset($collaborator) ? $collaborator->getPhone() : ''); ?>" class="w-full p-2 outline-none bg-transparent border-l-2 border-borderFormColor transition-all duration-300 focus:border-principal10 focus:text-black" placeholder="Digite seu telefone">
                                    </div>
                                    <span class="text-errorColor " id="msgPhoneError"><?php echo flash('phone');  ?></span>
                                </div>
                                <!-- campo -->
                                <div class="field w-full focus-within:text-principal10 text-borderFormColor">
                                    <label for="inputCpf" >CPF</label>
                                    <div class="flex items-center border-2 border-borderFormColor rounded focus-within:border-principal10 focus-within:text-principal10">
                                        <i class='bx bx-id-card' style='padding-left:1rem; padding-right:1rem;'></i>
                                        <input type="text" name="cpf" id="inputCpf" maxlength="14" value="<?php echo old('cpf') ?? (isset($collaborator) ? $collaborator->getCpf() : ''); ?>" class="w-full p-2 outline-none bg-transparent border-l-2 border-borderFormColor transition-all duration-300 focus:border-principal10 focus:text-black" placeholder="Digite seu cpf">
                                    </div>
                                    <span class="text-errorColor " id="msgCpfError"><?php echo flash('cpf');  ?></span>
                                </div>

                                <!-- campo -->
                                <div class="field w-full focus-within:text-principal10 text-borderFormColor">
                                    <div>
                                        <label for="inputEmail" >Email</label>
                                    </div>
                                    <div class="flex items-center border-2 border-borderFormColor rounded focus-within:border-principal10 focus-within:text-principal10">
                                        <i class='bx bx-envelope' style='padding-left:1rem; padding-right:1rem;' ></i>
                                        <input type="text" name="email" id="inputEmail" value="<?php echo old('email') ?? (isset($collaborator) ? $collaborator->getEmail() : ''); ?>" class="w-full p-2 outline-none bg-transparent border-l-2 border-borderFormColor transition-all duration-300 focus:border-principal10 focus:text-black" placeholder="Digite seu email">
                                    </div>
                                    <span class="text-errorColor " id="msgEmailError"><?php echo flash('email');  ?></span>
                                </div>
                                <!-- campo -->
                                <div class="field w-full focus-within:text-principal10 text-borderFormColor">
                                    <div>
                                        <label for="inputPassword" >Senha</label>
                                        <i class='bx bxs-help-circle hover:text-white hover:cursor-pointer' id="btnOpenModalPassword"></i>
                                    </div>
                                    <div class="flex items-center border-2 border-borderFormColor rounded focus-within:border-principal10 focus-within:text-principal10">
                                        <i class='bx bx-lock-alt' style='padding-left:1rem; padding-right:1rem; ' ></i>
                                        <input type="password" name="password" id="inputPassword" value="<?php echo old('password') ?>" class="w-full p-2 outline-none bg-transparent border-l-2 border-borderFormColor transition-all duration-300 focus:border-principal10 focus:text-black" placeholder="Digite sua senha">
                                        <i class="fa-regular fa-eye pl-2 pr-2" id="btnNotViewPassword" style="display:none;"></i>
                                        <i class="fa-regular fa-eye-slash pl-2 pr-2" id="btnViewPassword"></i>
                                    </div>
                                    <span class="text-errorColor " id="msgPasswordError"><?php echo flash('password');  ?></span>
                                </div>
                                <div class="field w-full focus-within:text-principal10 text-borderFormColor">
                                    <div>
                                        <label for="inputPassword" >Confirmar senha</label>
                                    </div>
                                    <div class="flex items-center border-2 border-borderFormColor rounded focus-within:border-principal10 focus-within:text-principal10">
                                        <i class='bx bx-lock-alt' style='padding-left:1rem; padding-right:1rem; ' ></i>
                                        <input type="password" name="password" id="inputConfirmPassword" class="w-full p-2 outline-none bg-transparent border-l-2 border-borderFormColor transition-all duration-300 focus:border-principal10 focus:text-black" placeholder="Confirme sua senha">
                                        <i class="fa-regular fa-eye pl-2 pr-2" id="btnNotViewConfirmPassword" style="display:none;"></i>
                                        <i class="fa-regular fa-eye-slash pl-2 pr-2" id="btnViewConfirmPassword"></i>
                                    </div>
                                    <span class="text-errorColor " id="msgConfirmPasswordError"></span>
                                </div>

                            </div>

                            <!-- column 2 -->
                            <div class="w-full col-span-1 row-span-1 col-start-2 flex flex-col items-start justify-center gap-4 ">
                                <div  class="field w-full focus-within:text-principal10 text-borderFormColor">
                                    <div>
                                        <label for="inputNivel" >Nivel</label>
                                    </div>
                                    <div class="flex items-center border-2 border-borderFormColor rounded focus-within:border-principal10 focus-within:text-principal10">
                                        <i class='bx bx-envelope' style='padding-left:1rem; padding-right:1rem;' ></i>
                                        <select name="nivel" id="inputNivel" value="<?php echo old('nivel') ?? (isset($collaborator) ? $collaborator->getNivel() : ''); ?>" class="w-full p-2 outline-none bg-transparent border-l-2 border-borderFormColor transition-all duration-300 focus:border-principal10 focus:text-black">
                                            <option value="manager">Administrador</option>
                                            <option value="collaborator">colaborador</option>
                                        </select>
                                    </div>
                                    <span class="text-errorColor " id="msgNivelError"><?php echo flash('state');  ?></span>
                                </div>

                                <div  class="field w-full h-full  text-borderFormColor flex flex-col items-start gap-2 ">
                                    <div class="w-full mb-2 border-b-2 border-lightGray text-xl">
                                        <label  >Serviços realizados</label>
                                    </div>

                                    <div class="pl-5">
                                        <?php foreach ($services as $service) { ?>
                                            <label for="checkCorte2" class="flex items-center gap-2 hover:text-principal10 hover:cursor-pointer scale-125">
                                                <input type="checkbox" name="services[]" value="<?php echo $service->getId() ?>" <?php echo in_array($service->getId(), $servicesCollaborator) ? "checked" : ''; ?> class="check"><?php echo $service->getName() ?>
                                            </label>
                                        <?php } ?>
                                    </div>
                                    <span class="text-errorColor " id="msgServicesError"></span>
                                </div>

                            </div>
                        </div>
                </fieldset>

                <div class="buttons mt-2 w-2/5 flex items-center gap-4">
                    <button type="submit" id="sendButton" class="w-2/4 bg-principal10 text-white font-Poppins font-semibold p-2 hover:cursor-pointer hover:underline">Cadastrar</button>
                    <a id="cancel" href="/admin/collaborator" class="w-2/4 bg-white text-principal10 text-center font-Poppins font-semibold p-2 border-2 border-lightGray hover:cursor-pointer hover:underline">Cancelar</a>
                </div>
            </form>
        </div>
    </main>

    <div class="message">
        <?php echo flash('reultInsertCollaborator');  ?>
    </div>

    <!-- modal -->
    <dialog id="modalCep" class="w-2/4 bg-white text-black rounded p-4 ">
        <div class="w-full flex justify-between items-center mb-4">
            <div class="flex gap-4 items-center">
                <i class='bx bx-lock-alt text-2xl'></i>
                <h1 class="text-2xl font-semibold font-Urbanist">CEP</h1>
            </div>
            <button id="btnCloseModalCep" class="outline-none"><i class='bx bx-x-circle text-3xl'></i></button>
        </div>
        <h3 class="text-base border-b-lightGray border-b-2 mb-2">Para sua segurança sua senha deve conter:</h3>
        <ul class="flex flex-col gap-2">
            <li class="list-disc ml-4">Minimo de 8 caracteres.</li>
            <li class="list-disc ml-4">Ao menos um caractere especial. (*&@!#%)</li>
            <li class="list-disc ml-4">Ao menos um numero.</li>
        </ul>
    </dialog>
   
    <script type="module" src="/assets/js/formCadCollaborator.js" deffer></script>