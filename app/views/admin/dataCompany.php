<main class="lg:w-5/6 w-full flex lg:absolute !overflow-x-hidden" style="left:17%; top:10%;">
        <?php echo flash('resultUpdateCompany');  ?>
        <?php require __DIR__ . '/../includes/nav.php'; ?>

        <div class=" w-full min-h-screen flex flex-col justify-start  items-start bg-bgPrincipal p-4 gap-4 ">

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
                               

                            </div>

                            <!-- column 2 -->
                            <div class="w-full col-span-1 row-span-1 col-start-2 flex flex-col items-start justify-center gap-4 ">
                               
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
                                        <select name="category" id="inputCategory" class="w-full p-2 outline-none bg-transparent  transition-all duration-300 focus:bg-white focus:border-white focus:text-black">
                                            <option value="Barbearia" <?php if (isset($company) && $company->getCategory() === 'Barbearia') echo 'selected'; ?>>Barbearia</option>
                                            <option value="Salão de beleza" <?php if (isset($company) && $company->getCategory() === 'Salão de beleza') echo 'selected'; ?>>Salão de beleza</option>
                                            <option value="Spa" <?php if (isset($company) && $company->getCategory() === 'Spa') echo 'selected'; ?>>Spa</option>
                                            <option value="Clínica de estética" <?php if (isset($company) && $company->getCategory() === 'Clínica de estética') echo 'selected'; ?>>Clínica de estética</option>
                                            <option value="Estudio de tatuagem" <?php if (isset($company) && $company->getCategory() === 'Estudio de tatuagem') echo 'selected'; ?>>Estudio de tatuagem</option>
                                            <option value="Pet-shop" <?php if (isset($company) && $company->getCategory() === 'Pet-shop') echo 'selected'; ?>>Pet-shop</option>
                                            <option value="Manutenção e Reformas" <?php if (isset($company) && $company->getCategory() === 'Manutenção e Reformas') echo 'selected'; ?>>Manutenção e Reformas</option>
                                            <option value="Outros serviços" <?php if (isset($company) && $company->getCategory() === 'Outros serviços') echo 'selected'; ?>>Outros serviços</option>
                                        </select>    
                                    </div>
                                    <span class="text-errorColor " id="msgNameError"><?php echo flash('name');  ?></span>
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

                <fieldset id="openingHours" class="w-full flex flex-col gap-4" >
                    <h2 class="w-full font-Urbanist font-semibold text-black text-xl md:text-2xl border-b-2 border-b-lightGray mb-4">Horario de funcionamento</h2>

                    <div id="containerHours" class="w-full flex flex-col gap-4">
                    <?php $groupedHours = [];

                    // Agrupar os dias com os mesmos horários
                    foreach ($company->getArrayHours() as $hour) {
                        // Cria uma chave única com base nos horários de funcionamento
                        $key = $hour->getOpeningHoursMorningStart()->format('H:i') . '-' . 
                            $hour->getOpeningHoursMorningEnd()->format('H:i') . '-' . 
                            $hour->getOpeningHoursAfternoonStart()->format('H:i') . '-' . 
                            $hour->getOpeningHoursAfternoonEnd()->format('H:i');

                        // Se a chave ainda não existe, cria um novo grupo
                        if (!isset($groupedHours[$key])) {
                            $groupedHours[$key] = [
                                'days' => [],
                                'morningStart' => $hour->getOpeningHoursMorningStart(),
                                'morningEnd' => $hour->getOpeningHoursMorningEnd(),
                                'afternoonStart' => $hour->getOpeningHoursAfternoonStart(),
                                'afternoonEnd' => $hour->getOpeningHoursAfternoonEnd()
                            ];
                        }

                        // Adiciona o dia ao grupo correspondente
                        $groupedHours[$key]['days'][] = $hour->getDayOfWeek();
                    }

                    // Exibir os grupos
                    $daysOfWeek = ['Domingo','Segunda-feira', 'Terça-feira', 'Quarta-feira', 'Quinta-feira', 'Sexta-feira', 'Sábado'];
                    $indexHours = 0;
                    foreach ($groupedHours as $index => $group) { ?>
                        <div class="hour w-full flex items-center justify-between border border-lightGray rounded p-2">
                            <div class="w-full flex flex-col">
                                <div class="w-full flex items-center gap-4">
                                    <?php
                                    // Exibir os dias agrupados
                                    foreach ($group['days'] as $dayOfWeek) {
                                        echo "<span class='text-base text-grayInput font-semibold'>{$daysOfWeek[$dayOfWeek]}</span>";
                                    }
                                    ?>
                                </div>

                                <span class="text-base text-principal10 font-semibold">
                                    Manhã: <?= $group['morningStart']->format('H:i') ?> às <?= $group['morningEnd']->format('H:i') ?> 
                                    - Tarde: <?= $group['afternoonStart']->format('H:i') ?> às <?= $group['afternoonEnd']->format('H:i') ?>
                                </span>
                            </div>

                            <button type="button" onclick="deleteHour(this)">
                                <i class='bx bx-x text-3xl' style='color:#e22b20'></i>
                            </button>

                            <div class="hidden">
                                <?php
                                foreach ($group['days'] as $dayOfWeek) {
                                    echo "<input type='checkbox' name='days[]' value='{$dayOfWeek}' checked>";
                                }
                                ?>
                                <input type="time" value="<?= $group['morningStart']->format('H:i') ?>" name="inputOpeningHoursMorningStart[<?= $indexHours ?>]" class="w-full p-2 outline-none bg-transparent transition-all duration-300 focus:border-principal10 focus:text-black placeholder:text-placeholder" />
                                
                                <input type="time" value="<?= $group['morningEnd']->format('H:i') ?>" name="inputOpeningHoursMorningEnd[<?= $indexHours ?>]" class="w-full p-2 outline-none bg-transparent transition-all duration-300 focus:border-principal10 focus:text-black placeholder:text-placeholder" />
                                
                                <input type="time" value="<?= $group['afternoonStart']->format('H:i') ?>" name="inputOpeningHoursAfternoonStart[<?= $indexHours ?>]" class="w-full p-2 outline-none bg-transparent transition-all duration-300 focus:border-principal10 focus:text-black placeholder:text-placeholder" />
                                
                                <input type="time" value="<?= $group['afternoonEnd']->format('H:i') ?>" name="inputOpeningHoursAfternoonEnd[<?= $indexHours ?>]" class="w-full p-2 outline-none bg-transparent transition-all duration-300 focus:border-principal10 focus:text-black placeholder:text-placeholder" />
                            </div>
                        </div>
                    
                    <?php  $indexHours = $indexHours +1; ?>
                    <?php } ?>
                        
                    </div>

                    <div class="w-full flex flex-col items-start gap-4">
                        <div class="w-full flex flex-col justify-start border border-lightGray rounded">
                            <div class="w-full border-b border-b-lightGray flex items-center justify-between p-2">
                                <span class="flex items-center gap-4 text-grayInput font-semibold text-base"><i class='bx bxs-info-circle'  ></i>Selecione os dias e adicione o horario desejado.</span>
                            </div>

                            <div class="w-full border-b border-b-lightGray flex items-center justify-between p-2" id="container-checkboxs">
                                <label for="inputDomingo" class="day flex items-center bg-principal5 text-white rounded">
                                    <span class="w-32  font-semibold p-2  text-center cursor-pointer hover:underline">Domingo</span>
                                    <input type="checkbox"  id="inputDomingo" class="check-day hidden" value="6">
                                </label >

                                <label for="inputSegunda" class="day flex items-center bg-principal5 text-white rounded">
                                    <span class="w-32  font-semibold p-2  text-center cursor-pointer hover:underline">Segunda-feira</span>
                                    <input type="checkbox"  id="inputSegunda" class="hidden" value="0">
                                </label >

                                <label for="inputTerca" class="day flex items-center bg-principal5 text-white rounded">
                                    <span class="w-32  font-semibold p-2  text-center cursor-pointer hover:underline">Terça-feira</span>
                                    <input type="checkbox"  id="inputTerca" class="hidden" value="1">
                                </label >

                                <label for="inputQuarta" class="day flex items-center bg-principal5 text-white rounded">
                                    <span class="w-32  font-semibold p-2  text-center cursor-pointer hover:underline">Quarta-feira</span>
                                    <input type="checkbox"  id="inputQuarta" class="hidden" value="2">
                                </label >

                                <label for="inputQuinta" class="day flex items-center bg-principal5 text-white rounded">
                                    <span class="w-32  font-semibold p-2  text-center cursor-pointer hover:underline">Quinta-feira</span>
                                    <input type="checkbox"  id="inputQuinta" class="hidden" value="3">
                                </label >

                                <label for="inputSexta" class="day flex items-center bg-principal5 text-white rounded">
                                    <span class="w-32  font-semibold p-2  text-center cursor-pointer hover:underline">Sexta-feira</span>
                                    <input type="checkbox"  id="inputSexta" class="hidden" value="4">
                                </label >

                                <label for="inputSabado" class="day flex items-center bg-principal5 text-white rounded">
                                    <span class="w-32  font-semibold p-2  text-center cursor-pointer hover:underline">Sabado</span>
                                    <input type="checkbox"  id="inputSabado" class="hidden" value="5">
                                </label >

                            </div>

                            <div class="w-full border-b border-b-lightGray flex flex-col items-start gap-4 p-2">
                                <button class="flex items-center gap-4 " id="btnAddHour">
                                    <i class='bx bx-plus text-principal10 text-xl'></i>
                                    <span class="hover:underline">Adicionar novo horario</span>
                                </button>
                            </div>

                            <div class="w-full" id="containerInputs">

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
   
    <script type="module" src="/assets/js/dataAdmin.js" deffer></script>