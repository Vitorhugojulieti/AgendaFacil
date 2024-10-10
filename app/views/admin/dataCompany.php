<main class="lg:w-5/6 w-full flex lg:absolute !overflow-x-hidden" style="left:17%; top:10%;">
        <?php echo flash('resultUpdateCompany');  ?>
        <?php require __DIR__ . '/../includes/nav.php'; ?>

        <div class=" w-full min-h-screen flex flex-col justify-start  items-start bg-bgPrincipal p-4 gap-4 ">
        <?php echo $breadcrumb?>

            <form action="<?php echo $actionCompany;?>" method="POST" enctype="multipart/form-data" id="formUpdateCompany" class="bg-white w-5/6 md:w-full flex flex-col items-start justify-start gap-4 shadow shadow-borderFormColor p-2 rounded-lg">
                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['token']; ?>">
                <!-- container data admin -->
                <fieldset id="containerDataCompany" class="w-full flex flex-col justify-start items-start gap-4">

                    <div class="w-1/4 hover:cursor-pointer flex flex-col items-center justify-center p-4 gap-4 border-2 border-grayInput border-dashed rounded ">
                        <input type="file" name="logo" id="inputLogo" class="hidden">
                        <label for="inputLogo" class="flex flex-col items-center gap-2 pt-4 pb-4">
                            <img id="previewLogo"  alt="logo" src="<?php echo isset($company) ? '../../'.$company->getLogo() : AVATAR_DEFAULT?>">
                            <!-- <i class='hidden bx bx-image text-4xl text-grayInput' id="iconLogo"></i>
                            <span class="hidden text-grayInput hover:underline hover:cursor-pointer" id="spanLogo"><span class="font-semibold text-principal5">Insira</span> a logo da empresa aqui</span> -->
                        </label>
                        <!-- <span class="text-errorColor " id="msgInputLogo"><?php echo flash('image1');  ?></span> -->
                    </div>

                    <h2 class="w-full font-Urbanist font-semibold text-black text-xl md:text-2xl border-b-2 border-b-lightGray mb-4">Dados da empresa</h2>

                    <div class="w-full lg:grid lg:grid-rows-1 lg:grid-cols-2 gap-12 md:flex md:w-5/6 md:flex-col justify-start items-start">
                            <!-- column 1 -->
                            <div class="w-full col-span-1 row-span-1 col-start-1 flex flex-col items-start justify-center gap-4 ">
                                <!-- campo -->
                                <div class="field w-full focus-within:text-principal10 text-borderFormColor">
                                    <div>
                                        <label for="inputName" >Nome</label>
                                    </div>
                                    <div class="flex items-center border-2 border-borderFormColor rounded focus-within:border-principal10 focus-within:text-principal10">
                                        <i class='bx bx-user' style=' padding-left:1rem; padding-right:1rem;'></i>
                                        <input type="text" name="name" id="inputName" value="<?php echo old('name') ?? (isset($company) ? $company->getName() : ''); ?>" class="w-full p-2 outline-none bg-transparent border-l-2 border-borderFormColor transition-all duration-300 focus:border-principal10 focus:text-black" placeholder="Digite seu nome completo">
                                    </div>
                                    <span class="text-errorColor " id="msgNameError"><?php echo flash('name');  ?></span>
                                </div>
                                <!-- campo -->
                                <div class="field w-full focus-within:text-principal10 text-borderFormColor">
                                    <label for="inputPhone" >Telefone</label>
                                    <div class="flex items-center border-2 border-borderFormColor rounded focus-within:border-principal10 focus-within:text-principal10">
                                        <i class='bx bx-phone' style='padding-left:1rem; padding-right:1rem; '></i>
                                        <input type="text" name="phone" id="inputPhone" maxlength="15" value="<?php echo old('phone') ?? (isset($company) ? $company->getPhone() : ''); ?>" class="w-full p-2 outline-none bg-transparent border-l-2 border-borderFormColor transition-all duration-300 focus:border-principal10 focus:text-black" placeholder="Digite seu telefone">
                                    </div>
                                    <span class="text-errorColor " id="msgPhoneError"><?php echo flash('phone');  ?></span>
                                </div>
                                <!-- campo -->
                                <div class="field w-full focus-within:text-principal10 text-borderFormColor">
                                    <label for="inputCpf" >CNPJ</label>
                                    <div class="flex items-center border-2 border-borderFormColor rounded focus-within:border-principal10 focus-within:text-principal10">
                                        <i class='bx bx-id-card' style='padding-left:1rem; padding-right:1rem;'></i>
                                        <input type="text" name="cnpj" id="inputCpf" maxlength="14" value="<?php echo old('cpf') ?? (isset($company) ? $company->getCnpj() : ''); ?>" class="w-full p-2 outline-none bg-transparent border-l-2 border-borderFormColor transition-all duration-300 focus:border-principal10 focus:text-black" placeholder="Digite seu cpf">
                                    </div>
                                    <span class="text-errorColor " id="msgCpfError"><?php echo flash('cpf');  ?></span>
                                </div>

                                    <!-- campo -->
                                    <div class="field w-full focus-within:text-principal10 text-grayInput ">
                                    <div>
                                        <label for="inputActive" >Categoria</label>
                                    </div>
                                    <div class="flex items-center border-2 border-grayInput   rounded focus-within:border-principal10 focus-within:text-principal10 focus-within:bg-white" style="box-shadow:0 0 10px 5px rgb(0,0,0,0.02);">
                                        <i class='bx bx-rename' style=' padding-left:1rem; padding-right:1rem;'></i>
                                        <select name="category" id="inputActive"class="w-full p-2 outline-none bg-transparent border-l-2 border-grayInput transition-all duration-300 focus:border-principal10 focus:text-black placeholder:text-placeholder ">
                                            <option value="barbbarber-shope">Barbearia</option>
                                            <option value="barbbarber-shope">Barbearia</option>
                                            <option value="barbbarber-shope">Barbearia</option>
                                            <option value="barbbarber-shope">Barbearia</option>
                                        </select>
                                    </div>
                                    <span class="text-errorColor " id="msgNameError"><?php echo flash('name');  ?></span>
                                </div>

                            </div>

                            <!-- column 2 -->
                            <div class="w-full col-span-1 row-span-1 col-start-2 flex flex-col items-start justify-center gap-4 ">
                               
                                <!-- campo -->
                                <div class="field w-full focus-within:text-principal10 text-borderFormColor">
                                    <div>
                                        <label for="inputOpeningHoursMorningStart" class="flex items-center gap-1">Horario de funcionamento manhã*inicio<span class="text-red">*</span></label>
                                    </div>
                                    <div class="flex items-center border-2 border-borderFormColor rounded focus-within:border-principal10 focus-within:text-principal10">
                                        <i class='bx bx-time-five' style='padding-left:1rem; padding-right:1rem;'></i>
                                        <input type="time" name="openingHoursMorningStart" id="inputOpeningHoursMorningStart" value="<?php echo old('openingHoursMorningStart') ?? (isset($company) ? $company->getOpeningHoursMorningStart()->format('H:i') : ''); ?>" class="w-full p-2 outline-none bg-transparent border-l-2 border-borderFormColor transition-all duration-300 focus:border-principal10 focus:text-black" >
                                    </div>
                                    <span class="text-errorColor " id="msgOpeningHoursMorningStartError"><?php echo flash('openingHoursMorningStart');  ?></span>
                                </div>

                                 <!-- campo -->
                                 <div class="field w-full focus-within:text-principal10 text-borderFormColor">
                                    <div>
                                        <label for="inputOpeningHoursMorningEnd" class="flex items-center gap-1">Horario de funcionamento manhã*final<span class="text-red">*</span></label>
                                    </div>
                                    <div class="flex items-center border-2 border-borderFormColor rounded focus-within:border-principal10 focus-within:text-principal10">
                                        <i class='bx bx-time-five' style='padding-left:1rem; padding-right:1rem;'></i>
                                        <input type="time" name="openingHoursMorningEnd" id="inputOpeningHoursMorningEnd" value="<?php echo old('openingHoursMorningEnd') ?? (isset($company) ? $company->getOpeningHoursMorningEnd()->format('H:i') : ''); ?>" class="w-full p-2 outline-none bg-transparent border-l-2 border-borderFormColor transition-all duration-300 focus:border-principal10 focus:text-black">
                                    </div>
                                    <span class="text-errorColor " id="msgOpeningHoursMorningEndError"><?php echo flash('openingHoursMorningEnd');  ?></span>
                                </div>

                                <!-- campo -->
                                <div class="field w-full focus-within:text-principal10 text-borderFormColor">
                                    <div>
                                        <label for="inputOpeningHoursStart" class="flex items-center gap-1">Horario de funcionamento tarde*inicio<span class="text-red">*</span></label>
                                    </div>
                                    <div class="flex items-center border-2 border-borderFormColor rounded focus-within:border-principal10 focus-within:text-principal10">
                                        <i class='bx bx-time-five' style='padding-left:1rem; padding-right:1rem;'></i>
                                        <input type="time" name="openingHoursAfternoonStart" id="inputOpeningHoursAfternoonStart" value="<?php echo old('openingHoursAfternoonStart') ?? (isset($company) ? $company->getOpeningHoursAfternoonStart()->format('H:i') : ''); ?>" class="w-full p-2 outline-none bg-transparent border-l-2 border-borderFormColor transition-all duration-300 focus:border-principal10 focus:text-black" >
                                    </div>
                                    <span class="text-errorColor " id="msgOpeningHoursStartError"><?php echo flash('openingHoursAfternoonStart');  ?></span>
                                </div>
                                 

                                <!-- campo -->
                                <div class="field w-full focus-within:text-principal10 text-borderFormColor">
                                    <div>
                                        <label for="inputOpeningHoursAfternoonEnd" class="flex items-center gap-1">Horario de funcionamento tarde*final<span class="text-red">*</span></label>
                                    </div>
                                    <div class="flex items-center border-2 border-borderFormColor rounded focus-within:border-principal10 focus-within:text-principal10">
                                        <i class='bx bx-time-five' style='padding-left:1rem; padding-right:1rem;'></i>
                                        <input type="time" name="openingHoursAfternoonEnd" id="inputOpeningHoursAfternoonEnd" value="<?php echo old('openingHoursAfternoonEnd') ?? (isset($company) ? $company->getOpeningHoursAfternoonEnd()->format('H:i') : ''); ?>" class="w-full p-2 outline-none bg-transparent border-l-2 border-borderFormColor transition-all duration-300 focus:border-principal10 focus:text-black">
                                    </div>
                                    <span class="text-errorColor " id="msgOpeningHoursAfternoonEndError"><?php echo flash('openingHoursAfternoonEnd');  ?></span>
                                </div>
                            </div>
                        </div>
                </fieldset>

            
                <fieldset id="containerDataCompany2" class="w-full flex flex-col justify-start items-start gap-4">
                    <h2 class="w-full font-Urbanist font-semibold text-black text-xl md:text-2xl border-b-2 border-b-lightGray mb-4">Dados de endereço</h2>

                    <div class="w-full lg:grid lg:grid-rows-1 lg:grid-cols-2 gap-12 md:flex md:w-5/6 md:flex-col ">
                            <!-- column 1 -->
                            <div class="w-full col-span-1 row-span-1 col-start-1 flex flex-col items-start justify-center gap-4 ">
                                <!-- campo -->
                                <div class="field w-full focus-within:text-principal10 text-borderFormColor">
                                    <div>
                                        <label for="inputName" >Cep</label>
                                    </div>
                                    <div class="flex items-center border-2 border-borderFormColor rounded focus-within:border-principal10 focus-within:text-principal10">
                                        <i class='bx bx-user' style=' padding-left:1rem; padding-right:1rem;'></i>
                                        <input type="text" name="cep" id="inputName" value="<?php echo old('name') ?? (isset($company) ? $company->getCep() : ''); ?>" class="w-full p-2 outline-none bg-transparent border-l-2 border-borderFormColor transition-all duration-300 focus:border-principal10 focus:text-black" placeholder="Digite seu nome completo">
                                    </div>
                                    <span class="text-errorColor " id="msgNameError"><?php echo flash('name');  ?></span>
                                </div>
                                <!-- campo -->
                                <div class="field w-full focus-within:text-principal10 text-borderFormColor">
                                    <label for="inputPhone" >Rua</label>
                                    <div class="flex items-center border-2 border-borderFormColor rounded focus-within:border-principal10 focus-within:text-principal10">
                                        <i class='bx bx-phone' style='padding-left:1rem; padding-right:1rem; '></i>
                                        <input type="text" name="road" id="inputPhone" maxlength="15" value="<?php echo old('phone') ?? (isset($company) ? $company->getRoad() : ''); ?>" class="w-full p-2 outline-none bg-transparent border-l-2 border-borderFormColor transition-all duration-300 focus:border-principal10 focus:text-black" placeholder="Digite seu telefone">
                                    </div>
                                    <span class="text-errorColor " id="msgPhoneError"><?php echo flash('phone');  ?></span>
                                </div>
                                <!-- campo -->
                                <div class="field w-full focus-within:text-principal10 text-borderFormColor">
                                    <label for="inputCpf" >Bairro</label>
                                    <div class="flex items-center border-2 border-borderFormColor rounded focus-within:border-principal10 focus-within:text-principal10">
                                        <i class='bx bx-id-card' style='padding-left:1rem; padding-right:1rem;'></i>
                                        <input type="text" name="district" id="inputCpf" maxlength="14" value="<?php echo old('cpf') ?? (isset($company) ? $company->getDistrict() : ''); ?>" class="w-full p-2 outline-none bg-transparent border-l-2 border-borderFormColor transition-all duration-300 focus:border-principal10 focus:text-black" placeholder="Digite seu cpf">
                                    </div>
                                    <span class="text-errorColor " id="msgCpfError"><?php echo flash('cpf');  ?></span>
                                </div>

                            </div>

                            <!-- column 2 -->
                            <div class="w-full col-span-1 row-span-1 col-start-2 flex flex-col items-start justify-center gap-4 ">
                                   <!-- campo -->
                                <div class="field w-full focus-within:text-principal10 text-borderFormColor">
                                    <label for="inputCpf" >Numero</label>
                                    <div class="flex items-center border-2 border-borderFormColor rounded focus-within:border-principal10 focus-within:text-principal10">
                                        <i class='bx bx-id-card' style='padding-left:1rem; padding-right:1rem;'></i>
                                        <input type="text" name="number" id="inputCpf" maxlength="14" value="<?php echo old('cpf') ?? (isset($company) ? $company->getNumber() : ''); ?>" class="w-full p-2 outline-none bg-transparent border-l-2 border-borderFormColor transition-all duration-300 focus:border-principal10 focus:text-black" placeholder="Digite seu cpf">
                                    </div>
                                    <span class="text-errorColor " id="msgCpfError"><?php echo flash('cpf');  ?></span>
                                </div>
                                <!-- campo -->
                                <div class="field w-full focus-within:text-principal10 text-borderFormColor">
                                    <label for="inputCpf" >Cidade</label>
                                    <div class="flex items-center border-2 border-borderFormColor rounded focus-within:border-principal10 focus-within:text-principal10">
                                        <i class='bx bx-id-card' style='padding-left:1rem; padding-right:1rem;'></i>
                                        <input type="text" name="city" id="inputCpf" maxlength="14" value="<?php echo old('cpf') ?? (isset($company) ? $company->getCity() : ''); ?>" class="w-full p-2 outline-none bg-transparent border-l-2 border-borderFormColor transition-all duration-300 focus:border-principal10 focus:text-black" placeholder="Digite seu cpf">
                                    </div>
                                    <span class="text-errorColor " id="msgCpfError"><?php echo flash('cpf');  ?></span>
                                </div>
                                 

                                <!-- campo -->
                                <div class="field w-full focus-within:text-principal10 text-borderFormColor">
                                    <div>
                                        <label for="inputState" class="flex items-center gap-1">Estado<span class="text-red">*</span></label>
                                    </div>
                                    <div class="flex items-center border-2 border-borderFormColor rounded focus-within:border-principal10 focus-within:text-principal10">
                                        <i class='bx bx-map-alt' style='padding-left:1rem; padding-right:1rem;' ></i>
                                        <select name="state" id="inputState" class="w-full p-2 outline-none bg-transparent border-l-2 border-borderFormColor transition-all duration-300 focus:border-principal10 focus:text-black">
                                            <option value="AC" <?php if (isset($company) && $company->getState() === 'AC') echo 'selected'; ?>>Acre</option>
                                            <option value="AL" <?php if (isset($company) && $company->getState() === 'AL') echo 'selected'; ?>>Alagoas</option>
                                            <option value="AP" <?php if (isset($company) && $company->getState() === 'AP') echo 'selected'; ?>>Amapá</option>
                                            <option value="AM" <?php if (isset($company) && $company->getState() === 'AM') echo 'selected'; ?>>Amazonas</option>
                                            <option value="BA" <?php if (isset($company) && $company->getState() === 'BA') echo 'selected'; ?>>Bahia</option>
                                            <option value="CE" <?php if (isset($company) && $company->getState() === 'CE') echo 'selected'; ?>>Ceará</option>
                                            <option value="DF" <?php if (isset($company) && $company->getState() === 'DF') echo 'selected'; ?>>Distrito Federal</option>
                                            <option value="ES" <?php if (isset($company) && $company->getState() === 'ES') echo 'selected'; ?>>Espírito Santo</option>
                                            <option value="GO" <?php if (isset($company) && $company->getState() === 'GO') echo 'selected'; ?>>Goiás</option>
                                            <option value="MA" <?php if (isset($company) && $company->getState() === 'MA') echo 'selected'; ?>>Maranhão</option>
                                            <option value="MT" <?php if (isset($company) && $company->getState() === 'MT') echo 'selected'; ?>>Mato Grosso</option>
                                            <option value="MS" <?php if (isset($company) && $company->getState() === 'MS') echo 'selected'; ?>>Mato Grosso do Sul</option>
                                            <option value="MG" <?php if (isset($company) && $company->getState() === 'MG') echo 'selected'; ?>>Minas Gerais</option>
                                            <option value="PA" <?php if (isset($company) && $company->getState() === 'PA') echo 'selected'; ?>>Pará</option>
                                            <option value="PB" <?php if (isset($company) && $company->getState() === 'PB') echo 'selected'; ?>>Paraíba</option>
                                            <option value="PR" <?php if (isset($company) && $company->getState() === 'PR') echo 'selected'; ?>>Paraná</option>
                                            <option value="PE" <?php if (isset($company) && $company->getState() === 'PE') echo 'selected'; ?>>Pernambuco</option>
                                            <option value="PI" <?php if (isset($company) && $company->getState() === 'PI') echo 'selected'; ?>>Piauí</option>
                                            <option value="RJ" <?php if (isset($company) && $company->getState() === 'RJ') echo 'selected'; ?>>Rio de Janeiro</option>
                                            <option value="RN" <?php if (isset($company) && $company->getState() === 'RN') echo 'selected'; ?>>Rio Grande do Norte</option>
                                            <option value="RS" <?php if (isset($company) && $company->getState() === 'RS') echo 'selected'; ?>>Rio Grande do Sul</option>
                                            <option value="RO" <?php if (isset($company) && $company->getState() === 'RO') echo 'selected'; ?>>Rondônia</option>
                                            <option value="RR" <?php if (isset($company) && $company->getState() === 'RR') echo 'selected'; ?>>Roraima</option>
                                            <option value="SC" <?php if (isset($company) && $company->getState() === 'SC') echo 'selected'; ?>>Santa Catarina</option>
                                            <option value="SP" <?php if (isset($company) && $company->getState() === 'SP') echo 'selected'; ?>>São Paulo</option>
                                            <option value="SE" <?php if (isset($company) && $company->getState() === 'SE') echo 'selected'; ?>>Sergipe</option>
                                            <option value="TO" <?php if (isset($company) && $company->getState() === 'TO') echo 'selected'; ?>>Tocantins</option>
                                        </select>
                                    </div>
                                    <span class="text-errorColor " id="msgStateError"><?php echo flash('state');  ?></span>
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