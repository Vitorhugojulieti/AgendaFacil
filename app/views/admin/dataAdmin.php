<main class="lg:w-5/6 w-full flex lg:absolute !overflow-x-hidden" style="left:17%; top:10%;">
        <?php echo flash('resultUpdateAdmin');  ?>
        <?php require __DIR__ . '/../includes/nav.php'; ?>

        <div class=" w-full min-h-screen flex flex-col justify-start  items-start bg-bgPrincipal p-4 gap-4 ">
            <!-- data main collaborator -->
            <form action="<?php echo isset($isCollaborator) ? '/collaborator/data/store' : $actionCollaborator;?>" method="POST" enctype="multipart/form-data" id="formUpdateCollaborator" class="bg-white w-5/6 md:w-full flex flex-col items-start justify-start gap-4 shadow shadow-borderFormColor p-2 rounded-lg">
                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['token']; ?>">
                <!-- container data admin -->
                <fieldset id="containerDataAdmin" class="w-full  justify-start items-start">

                    <div class="w-full flex flex-col gap-4 justify-start lg:items-start items-center ">
                        <input type="file" name="avatar" id="inputAvatar" class="hidden">
                        <label for="inputAvatar" class="hover:cursor-pointer w-4/5 flex flex-col lg:items-start items-center justify-center p-2">
                            <img id="previewAvatar" src="<?php echo isset($admin) ? '../../'.$admin->getAvatar() : AVATAR_DEFAULT?>"  alt="avatar" class="redondShapeImage" style="width:10rem; height:8rem;">
                        </label>
                        <span class="text-errorColor " id="msgAvatarError"><?php echo flash('avatar');  ?></span>
                    </div>

                    <h2 class="w-full font-Urbanist font-semibold text-black text-xl md:text-2xl border-b-2 border-b-lightGray mb-4"><?php echo isset($isCollaborator) ? 'Dados do colaborador' : 'Dados do administrador'?></h2>
                    
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
                                        <input type="text" name="name" id="inputName" value="<?php echo old('name') ?? (isset($admin) ? $admin->getName() : ''); ?>" class="w-full p-2 outline-none bg-transparent border-l-2 border-borderFormColor transition-all duration-300 focus:border-principal10 focus:text-black" placeholder="Digite seu nome completo">
                                    </div>
                                    <span class="text-errorColor " id="msgNameError"><?php echo flash('name');  ?></span>
                                </div>
                                <!-- campo -->
                                <div class="field w-full focus-within:text-principal10 text-borderFormColor">
                                    <label for="inputPhone" >Telefone</label>
                                    <div class="flex items-center border-2 border-borderFormColor rounded focus-within:border-principal10 focus-within:text-principal10">
                                        <i class='bx bx-phone' style='padding-left:1rem; padding-right:1rem; '></i>
                                        <input type="text" name="phone" id="inputPhone" maxlength="15" value="<?php echo old('phone') ?? (isset($admin) ? $admin->getPhone() : ''); ?>" class="w-full p-2 outline-none bg-transparent border-l-2 border-borderFormColor transition-all duration-300 focus:border-principal10 focus:text-black" placeholder="Digite seu telefone">
                                    </div>
                                    <span class="text-errorColor " id="msgPhoneError"><?php echo flash('phone');  ?></span>
                                </div>
                                <!-- campo -->
                                <div class="field w-full focus-within:text-principal10 text-borderFormColor">
                                    <label for="inputCpf" >CPF</label>
                                    <div class="flex items-center border-2 border-borderFormColor rounded focus-within:border-principal10 focus-within:text-principal10">
                                        <i class='bx bx-id-card' style='padding-left:1rem; padding-right:1rem;'></i>
                                        <input type="text" name="cpf" id="inputCpf" maxlength="14" value="<?php echo old('cpf') ?? (isset($admin) ? $admin->getCpf() : ''); ?>" class="w-full p-2 outline-none bg-transparent border-l-2 border-borderFormColor transition-all duration-300 focus:border-principal10 focus:text-black" placeholder="Digite seu cpf">
                                    </div>
                                    <span class="text-errorColor " id="msgCpfError"><?php echo flash('cpf');  ?></span>
                                </div>

                                <!-- campo -->
                                <div class="field w-full focus-within:text-principal10 text-borderFormColor">
                                    <div>
                                        <label for="inputOpeningHoursEnd" class="flex items-center gap-1">Data de aniversario</label>
                                    </div>
                                    <div class="flex items-center border-2 border-borderFormColor rounded focus-within:border-principal10 focus-within:text-principal10">
                                        <i class='bx bx-time-five' style='padding-left:1rem; padding-right:1rem;'></i>
                                        <input type="date" name="birthDate" id="inputOpeningHoursEnd" value="<?php echo isset($collaborator) ? $collaborator->getBirthDate()->format('Y-m-d') : ''; ?>" class="w-full p-2 outline-none bg-transparent border-l-2 border-borderFormColor transition-all duration-300 focus:border-principal10 focus:text-black">
                                    </div>
                                    <span class="text-errorColor " id="msgOpeningHoursEndError"><?php echo flash('openingHoursEnd');  ?></span>
                                </div>
                                <!-- TODO corrigitr pq o campo nao mostra a data atual -->
                            </div>

                            <!-- column 2 -->
                            <div class="w-full col-span-1 row-span-1 col-start-2 flex flex-col items-start justify-center gap-4 ">
                                
                                 <!-- campo -->
                                <div class="field w-full focus-within:text-principal10 text-grayInput ">
                                    <div>
                                        <label for="inputActive" >Gênero</label>
                                    </div>
                                    <div class="flex items-center border-2 border-grayInput   rounded focus-within:border-principal10 focus-within:text-principal10 focus-within:bg-white" style="box-shadow:0 0 10px 5px rgb(0,0,0,0.02);">
                                        <i class='bx bx-rename' style=' padding-left:1rem; padding-right:1rem;'></i>
                                        <select name="category" id="inputActive"class="w-full p-2 outline-none bg-transparent border-l-2 border-grayInput transition-all duration-300 focus:border-principal10 focus:text-black placeholder:text-placeholder ">
                                            <option value='masculino'  <?php if (isset($collaborator) && $collaborator->getGender() === 'masculino') echo 'selected'; ?>>Masculino</option>
                                            <option value='feminino'  <?php if (isset($collaborator) && $collaborator->getGender() === 'feminino') echo 'selected'; ?>>Feminino</option>
                                            <option value='ni'  <?php if (isset($collaborator) && $collaborator->getGender() === 'ni') echo 'selected'; ?>>Não identificar</option>
                                        </select>
                                    </div>
                                    <span class="text-errorColor " id="msgNameError"><?php echo flash('name');  ?></span>
                                </div>
                                <!-- campo -->
                                 <div class="field w-full focus-within:text-principal10 text-borderFormColor">
                                    <div>
                                        <label for="inputEmail" >Email</label>
                                    </div>
                                    <div class="flex items-center border-2 border-borderFormColor rounded focus-within:border-principal10 focus-within:text-principal10">
                                        <i class='bx bx-envelope' style='padding-left:1rem; padding-right:1rem;' ></i>
                                        <input type="text" name="email" id="inputEmail" value="<?php echo old('email') ?? (isset($admin) ? $admin->getEmail() : ''); ?>" class="w-full p-2 outline-none bg-transparent border-l-2 border-borderFormColor transition-all duration-300 focus:border-principal10 focus:text-black" placeholder="Digite seu email">
                                    </div>
                                    <span class="text-errorColor " id="msgEmailError"><?php echo flash('email');  ?></span>
                                </div>
                                <!-- campo -->
                                <div class="field w-full focus-within:text-principal10 text-borderFormColor">
                                    <div>
                                        <label for="inputPassword" >Senha</label>
                                        <i class='bx bxs-help-circle hover:text-principal10 hover:cursor-pointer' id="btnOpenModalPassword"></i>
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
                        </div>
                </fieldset>

                <div class="buttons mt-2 lg:w-2/5 w-full flex items-center gap-4">
                    <button type="submit" id="sendButton" class="w-2/4 bg-principal10 text-white font-Poppins font-semibold p-2 hover:cursor-pointer hover:underline">Redefinir</button>
                </div>
            </form>
        </div>
</main>


<!-- TODO acertar modal de senha -->
    <!-- modal -->
    <dialog id="modalPassword" class="w-2/4 bg-white text-black rounded p-4 ">
        <div class="w-full flex justify-between items-center mb-4">
            <div class="flex gap-4 items-center">
                <i class='bx bx-lock-alt text-2xl'></i>
                <h1 class="text-2xl font-semibold font-Urbanist">Proteção da senha</h1>
            </div>
            <button id="btnCloseModalPassword" class="outline-none"><i class='bx bx-x-circle text-3xl'></i></button>
        </div>
        <h3 class="text-base border-b-lightGray border-b-2 mb-2">Para sua segurança sua senha deve conter:</h3>
        <ul class="flex flex-col gap-2">
            <li class="list-disc ml-4">Minimo de 8 caracteres.</li>
            <li class="list-disc ml-4">Ao menos um caractere especial. (*&@!#%)</li>
            <li class="list-disc ml-4">Ao menos um numero.</li>
        </ul>
    </dialog>
   
    <!-- <script type="module" src="/assets/js/formCadCollaborator.js" deffer></script> -->