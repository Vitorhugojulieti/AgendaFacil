<body style="overflow-y:auto; overflow-x:hidden;">
    <div class="absolute w-full min-h-screen flex flex-col justify-center items-center bg-principal10 p-4 ">
        <form action="/admin/signup/store" id="formCadCompany" method="post" enctype="multipart/form-data" class="w-5/6 md:w-3/5 flex flex-col items-center justify-center gap-6 ">
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['token']; ?>">
            <a href="/" class="w-full flex items-center justify-center"><img src="/assets/images/logo-white.png" alt="logo" style="width:20%;"></a>
            <legend class="font-Urbanist font-semibold text-white text-2xl md:text-3xl">Bem vindo a plataforma!</legend>
            
            <div class="status-form w-full flex items-center">
                <div class="point w-full flex flex-col items-center justify-center text-white">
                    <div class="bullet  ">
                        <span>1</span>
                        <i class='bx bx-check text-2xl' style='color:#223249'  ></i>
                    </div>
                    <span  class="text-sm text-center">Dados empresa</span>
                </div>

                <div class="point w-full flex flex-col items-center justify-center text-white">
                    <div class="bullet ">
                        <span>2</span>
                        <i class='bx bx-check text-2xl' style='color:#223249'  ></i>
                    </div>
                    <span  class="text-sm text-center">Endereço empresa</span>
                </div>

                <div class="point w-full flex flex-col items-center justify-center text-white">
                    <div class="bullet">
                        <span>3</span>
                        <i class='bx bx-check text-2xl' style='color:#223249'  ></i>
                    </div>
                    <span class="text-sm text-center">Dados administrador</span>
                </div>


                <div class="point w-full flex flex-col items-center justify-center text-white">
                    <div class="bullet last">
                        <span>4</span>
                        <i class='bx bx-check text-2xl' style='color:#223249'  ></i>
                    </div>
                    <span class="text-sm text-center">Upload imagens</span>
                </div>
            </div>
            <!-- container data company -->
            <fieldset id="containerDataCompany" class="w-full flex justify-center items-center  <? echo flash('validDataCompany');?>">
                <div class="w-full lg:grid lg:grid-rows-1 lg:grid-cols-2 lg:gap-8 md:flex md:w-5/6 md:flex-col md:gap-1">
                            <!-- column 1 -->
                            <div class="w-full col-span-1 row-span-1 col-start-1 flex flex-col items-start justify-center gap-1 ">
                                <!-- campo -->
                                <div class="field flex flex-col gap-1 w-full focus-within:text-white text-lightGrayInput">
                                    <div>
                                        <label for="inputNameCompany" class="flex items-center gap-1">Nome <span class="text-red">*</span></label>
                                    </div>
                                    <div class="flex items-center border-2 border-lightGrayInput rounded focus-within:border-white focus-within:text-white">
                                        <i class='bx bx-briefcase'  style='padding-left:1rem; padding-right:1rem;'></i>
                                        <input type="text" name="nameCompany" id="inputNameCompany" value="<?php echo old('nameCompany') ?>" class="w-full p-2 outline-none bg-transparent border-l-2 border-lightGrayInput transition-all duration-300 focus:bg-white focus:border-white focus:text-black" placeholder="Digite o nome da empresa">
                                    </div>
                                    <span class="text-errorColor " id="msgNameCompanyError"><?php echo flash('nameCompany');  ?></span>
                                </div>
                                <!-- campo -->
                                <div class="field flex flex-col gap-1 w-full focus-within:text-white text-lightGrayInput">
                                    <label for="inputPhoneCompany" class="flex items-center gap-1">Telefone<span class="text-red">*</span></label>
                                    <div class="flex items-center border-2 border-lightGrayInput rounded focus-within:border-white focus-within:text-white">
                                        <i class='bx bx-phone' style='padding-left:1rem; padding-right:1rem; '></i>
                                        <input type="text" name="phoneCompany" id="inputPhoneCompany" maxlength="15" value="<?php echo old('phoneCompany') ?>" class="w-full p-2 outline-none bg-transparent border-l-2 border-lightGrayInput transition-all duration-300 focus:bg-white focus:border-white focus:text-black" placeholder="Digite o telefone da empresa">
                                    </div>
                                    <span class="text-errorColor " id="msgPhoneCompanyError"><?php echo flash('phoneCompany');  ?></span>
                                </div>

                                <!-- campo -->
                                <div class="field w-full focus-within:text-white text-lightGrayInput">
                                    <div>
                                        <label for="inputOpeningHoursMorningStart" >Horario de funcionamento *inicio*manhã</label>
                                    </div>
                                    <div class="flex items-center border-2 border-lightGrayInput rounded focus-within:border-white focus-within:text-white">
                                        <i class='bx bx-time-five' style='padding-left:1rem; padding-right:1rem;'></i>
                                        <input type="time" name="openingHoursMorningStart" id="inputOpeningHoursMorningStart" value="<?php echo old('openingHoursMorningStart') ?>" class="w-full p-2 outline-none bg-transparent border-l-2 border-lightGrayInput transition-all duration-300 focus:bg-white focus:border-white focus:text-black" placeholder="Digite seu nome completo">
                                    </div>
                                    <span class="text-errorColor " ></span>
                                </div>

                                <!-- campo -->
                                <div class="field w-full focus-within:text-white text-lightGrayInput">
                                    <div>
                                        <label for="inputOpeningHoursMorningEnd" >Horario de funcionamento *final*manhã</label>
                                    </div>
                                    <div class="flex items-center border-2 border-lightGrayInput rounded focus-within:border-white focus-within:text-white">
                                        <i class='bx bx-time-five' style='padding-left:1rem; padding-right:1rem;'></i>
                                        <input type="time" name="openingHoursMorningEnd" id="inputOpeningHoursMorningEnd" value="<?php echo old('openingHourssMorningEnd') ?>" class="w-full p-2 outline-none bg-transparent border-l-2 border-lightGrayInput transition-all duration-300 focus:bg-white focus:border-white focus:text-black" placeholder="Digite seu nome completo">
                                    </div>
                                    <span class="text-errorColor " id="msgOpeningHoursMorningError"><?php echo flash('openingHoursMorningStart');  ?><?php echo flash('openingHourssMorningEnd');  ?></span>
                                </div>
                            </div>

                            <!-- column 2 -->
                            <div class="w-full col-span-1 row-span-1 col-start-2 flex flex-col items-start justify-center gap-1 ">
                                <!-- campo -->
                                <div class="field flex flex-col gap-1 w-full focus-within:text-white text-lightGrayInput">
                                    <label for="inputCnpjCompany" class="flex items-center gap-1">CNPJ<span class="text-red">*</span></label>
                                    <div class="flex items-center border-2 border-lightGrayInput rounded focus-within:border-white focus-within:text-white">
                                        <i class='bx bx-id-card' style='padding-left:1rem; padding-right:1rem;'></i>
                                        <input type="text" name="cnpj" id="inputCnpjCompany" maxlength="14" value="<?php echo old('cnpjCompany') ?>" class="w-full p-2 outline-none bg-transparent border-l-2 border-lightGrayInput transition-all duration-300 focus:bg-white focus:border-white focus:text-black" placeholder="Digite o CNPJ da empresa">
                                    </div>
                                    <span class="text-errorColor " id="msgCnpjError"><?php echo flash('cnpjCompany');  ?></span>
                                </div>
                            
                                <!-- campo -->
                                <div class="field flex flex-col gap-1 w-full focus-within:text-white text-lightGrayInput">
                                    <div>
                                        <label for="inputCategory" class="flex items-center gap-1">Categoria</label>
                                    </div>
                                    <div class="flex items-center border-2 border-lightGrayInput rounded focus-within:border-white focus-within:text-white">
                                        <select name="category" id="inputCategory" value="<?php echo old('category') ?>" class="w-full p-2 outline-none bg-transparent  transition-all duration-300 focus:bg-white focus:border-white focus:text-black">
                                            <option value="barbbarber-shope">Barbearia</option>
                                            <option value="barbbarber-shope">Barbearia</option>
                                            <option value="barbbarber-shope">Barbearia</option>
                                            <option value="barbbarber-shope">Barbearia</option>
                                        </select>    
                                    </div>
                                    <span class="text-errorColor " id="msgCategoryCompanyError"><?php echo flash('category');  ?></span>
                                </div>

                                 <!-- campo -->
                                 <div class="field w-full focus-within:text-white text-lightGrayInput">
                                    <div>
                                        <label for="inputOpeningHoursAfternoonStart" >Horario de funcionamento *inicio*tarde</label>
                                    </div>
                                    <div class="flex items-center border-2 border-lightGrayInput rounded focus-within:border-white focus-within:text-white">
                                        <i class='bx bx-time-five' style='padding-left:1rem; padding-right:1rem;'></i>
                                        <input type="time" name="openingHoursAfternoonStart" id="inputOpeningHoursAfternoonStart" value="<?php echo old('openingHoursAfternoonStart') ?>" class="w-full p-2 outline-none bg-transparent border-l-2 border-lightGrayInput transition-all duration-300 focus:bg-white focus:border-white focus:text-black" placeholder="Digite seu nome completo">
                                    </div>
                                    <span class="text-errorColor " ></span>
                                </div>

                                <!-- campo -->
                                <div class="field w-full focus-within:text-white text-lightGrayInput">
                                    <div>
                                        <label for="inputOpeningHoursAfternoonEnd" >Horario de funcionamento *final*tarde</label>
                                    </div>
                                    <div class="flex items-center border-2 border-lightGrayInput rounded focus-within:border-white focus-within:text-white">
                                        <i class='bx bx-time-five' style='padding-left:1rem; padding-right:1rem;'></i>
                                        <input type="time" name="openingHoursAfternoonEnd" id="inputOpeningHoursAfternoonEnd" value="<?php echo old('openingHoursAfternoonEnd') ?>" class="w-full p-2 outline-none bg-transparent border-l-2 border-lightGrayInput transition-all duration-300 focus:bg-white focus:border-white focus:text-black" placeholder="Digite seu nome completo">
                                    </div>
                                    <span class="text-errorColor " id="msgOpeningHoursAfternoonError"><?php echo flash('openingHoursAfternoonStart');  ?><?php echo flash('openingHoursAfternoonEnd');  ?></span>
                                </div>

                        </div>
                    <!-- btns -->
            </fieldset>

              <!-- container data company2 -->
              <fieldset id="containerDataCompany2" class="w-full hidden justify-center items-center <? echo flash('validDataCompany2');?>">
                <div class="w-full lg:grid lg:grid-rows-1 lg:grid-cols-2 lg:gap-8 md:flex md:w-5/6 md:flex-col md:gap-1">
                            <!-- column 1 -->
                            <div class="w-full col-span-1 row-span-1 col-start-1 flex flex-col items-start  gap-1 ">
                                <!-- campo -->
                                <div class="field flex flex-col gap-1 w-full focus-within:text-white text-lightGrayInput">
                                    <div>
                                        <label for="inputCep" class="flex items-center gap-1">CEP<span class="text-red">*</span></label>
                                    </div>
                                    <div class="flex items-center border-2 border-lightGrayInput rounded focus-within:border-white focus-within:text-white">
                                        <i class='bx bx-rename' style='padding-left:1rem; padding-right:1rem;' ></i>
                                        <input type="text" name="cep" id="inputCep"  maxlength="9" value="<?php echo old('cep') ?>" class="w-full p-2 outline-none bg-transparent border-l-2 border-lightGrayInput transition-all duration-300 focus:bg-white focus:border-white focus:text-black" placeholder="Digite o CEP da empresa">
                                    </div>
                                    <span class="text-errorColor " id="msgCepError"><?php echo flash('cep');  ?></span>
                                </div>
                                <!-- campo -->
                                <div class="field flex flex-col gap-1 w-full focus-within:text-white text-lightGrayInput">
                                    <label for="inputRoad" class="flex items-center gap-1">Endereço<span class="text-red">*</span></label>
                                    <div class="flex items-center border-2 border-lightGrayInput rounded focus-within:border-white focus-within:text-white">
                                        <i class='bx bx-rename' style='padding-left:1rem; padding-right:1rem; '></i>
                                        <input type="text" name="road" id="inputRoad" maxlength="15" value="<?php echo old('road') ?>" class="w-full p-2 outline-none bg-transparent border-l-2 border-lightGrayInput transition-all duration-300 focus:bg-white focus:border-white focus:text-black" placeholder="Digite o endereço">
                                    </div>
                                    <span class="text-errorColor " id="msgRoadError"><?php echo flash('road');  ?></span>
                                </div>

                                <div class="field flex flex-col gap-1 w-full focus-within:text-white text-lightGrayInput">
                                    <div>
                                        <label for="inputState" class="flex items-center gap-1">Estado<span class="text-red">*</span></label>
                                    </div>
                                    <div class="flex items-center border-2 border-lightGrayInput rounded focus-within:border-white focus-within:text-white">
                                        <i class='bx bx-map-alt' style='padding-left:1rem; padding-right:1rem;' ></i>
                                        <select name="state" id="inputState" class="w-full p-2 outline-none bg-transparent border-l-2 border-lightGrayInput transition-all duration-300 focus:bg-white focus:border-white focus:text-black">
                                            <option value="AC">Acre</option>
                                            <option value="AL">Alagoas</option>
                                            <option value="AP">Amapá</option>
                                            <option value="AM">Amazonas</option>
                                            <option value="BA">Bahia</option>
                                            <option value="CE">Ceará</option>
                                            <option value="DF">Distrito Federal</option>
                                            <option value="ES">Espírito Santo</option>
                                            <option value="GO">Goiás</option>
                                            <option value="MA">Maranhão</option>
                                            <option value="MT">Mato Grosso</option>
                                            <option value="MS">Mato Grosso do Sul</option>
                                            <option value="MG">Minas Gerais</option>
                                            <option value="PA">Pará</option>
                                            <option value="PB">Paraíba</option>
                                            <option value="PR">Paraná</option>
                                            <option value="PE">Pernambuco</option>
                                            <option value="PI">Piauí</option>
                                            <option value="RJ">Rio de Janeiro</option>
                                            <option value="RN">Rio Grande do Norte</option>
                                            <option value="RS">Rio Grande do Sul</option>
                                            <option value="RO">Rondônia</option>
                                            <option value="RR">Roraima</option>
                                            <option value="SC">Santa Catarina</option>
                                            <option value="SP">São Paulo</option>
                                            <option value="SE">Sergipe</option>
                                            <option value="TO">Tocantins</option>
                                        </select>
                                    </div>
                                    <span class="text-errorColor " id="msgStateError"><?php echo flash('state');  ?></span>
                                </div>
                            </div>

                            <!-- column 2 -->
                            <div class="w-full col-span-1 row-span-1 col-start-2 flex flex-col items-start  gap-1 ">
                                <!-- campo -->
                                <div class="field flex flex-col gap-1 w-full focus-within:text-white text-lightGrayInput">
                                    <label for="inputNumber" class="flex items-center gap-1">Numero<span class="text-red">*</span></label>
                                    <div class="flex items-center border-2 border-lightGrayInput rounded focus-within:border-white focus-within:text-white">
                                        <i class='bx bx-rename' style='padding-left:1rem; padding-right:1rem;'></i>
                                        <input type="number" name="number" id="inputNumber" maxlength="14" value="<?php echo old('number') ?>" class="w-full p-2 outline-none bg-transparent border-l-2 border-lightGrayInput transition-all duration-300 focus:bg-white focus:border-white focus:text-black" placeholder="Digite o numero da empresa">
                                    </div>
                                    <span class="text-errorColor " id="msgNumberError"><?php echo flash('number');  ?></span>
                                </div>

                                <!-- campo -->
                                <div class="field flex flex-col gap-1 w-full focus-within:text-white text-lightGrayInput">
                                    <div>
                                        <label for="inputDistrict" class="flex items-center gap-1">Bairro<span class="text-red">*</span></label>
                                    </div>
                                    <div class="flex items-center border-2 border-lightGrayInput rounded focus-within:border-white focus-within:text-white">
                                        <i class='bx bx-map-alt' style='padding-left:1rem; padding-right:1rem;' ></i>
                                        <input type="text" name="district" id="inputDistrict" value="<?php echo old('district') ?>" class="w-full p-2 outline-none bg-transparent border-l-2 border-lightGrayInput transition-all duration-300 focus:bg-white focus:border-white focus:text-black" placeholder="Digite o nome do bairro">
                                    </div>
                                    <span class="text-errorColor " id="msgDistrictError"><?php echo flash('district');  ?></span>
                                </div>
                            
                            <!-- campo -->
                                <div class="field flex flex-col gap-1 w-full focus-within:text-white text-lightGrayInput">
                                    <div>
                                        <label for="inputCity" class="flex items-center gap-1">Cidade<span class="text-red">*</span></label>
                                    </div>
                                    <div class="flex items-center border-2 border-lightGrayInput rounded focus-within:border-white focus-within:text-white">
                                        <i class='bx bx-map' style='padding-left:1rem; padding-right:1rem;' ></i>
                                        <input type="text" name="city" id="inputCity" value="<?php echo old('city') ?>" class="w-full p-2 outline-none bg-transparent border-l-2 border-lightGrayInput transition-all duration-300 focus:bg-white focus:border-white focus:text-black" placeholder="Digite o nome da cidade">
                                    </div>
                                    <span class="text-errorColor " id="msgCityError"><?php echo flash('city');  ?></span>
                                </div>
                        </div>
                    <!-- btns -->
            </fieldset>


            <!-- container data admin -->
            <fieldset id="containerDataAdmin" class="hidden w-full  justify-center items-center <? echo flash('validDataClient');?>">
                <div class="w-full lg:grid lg:grid-rows-1 lg:grid-cols-2 lg:gap-8 md:flex md:w-5/6 md:flex-col md:gap-1">
                        <!-- column 1 -->
                        <div class="w-full col-span-1 row-span-1 col-start-1 flex flex-col items-start justify-center gap-1 ">
                            <!-- campo -->
                            <div class="field flex flex-col gap-1 w-full focus-within:text-white text-lightGrayInput">
                                <div>
                                    <label for="inputName" class="flex items-center gap-1">Nome<span class="text-red">*</span></label>
                                </div>
                                <div class="flex items-center border-2 border-lightGrayInput rounded focus-within:border-white focus-within:text-white">
                                    <i class='bx bx-user' style=' padding-left:1rem; padding-right:1rem;'></i>
                                    <input type="text" name="name" id="inputName" value="<?php echo old('name') ?>" class="w-full p-2 outline-none bg-transparent border-l-2 border-lightGrayInput transition-all duration-300 focus:bg-white focus:border-white focus:text-black" placeholder="Digite seu nome completo">
                                </div>
                                <span class="text-errorColor " id="msgNameError"><?php echo flash('name');  ?></span>
                            </div>
                            <!-- campo -->
                            <div class="field flex flex-col gap-1 w-full focus-within:text-white text-lightGrayInput">
                                <label for="inputPhone" class="flex items-center gap-1">Telefone<span class="text-red">*</span></label>
                                <div class="flex items-center border-2 border-lightGrayInput rounded focus-within:border-white focus-within:text-white">
                                    <i class='bx bx-phone' style='padding-left:1rem; padding-right:1rem; '></i>
                                    <input type="text" name="phone" id="inputPhone" maxlength="15" value="<?php echo old('phone') ?>" class="w-full p-2 outline-none bg-transparent border-l-2 border-lightGrayInput transition-all duration-300 focus:bg-white focus:border-white focus:text-black" placeholder="Digite seu telefone">
                                </div>
                                <span class="text-errorColor " id="msgPhoneError"><?php echo flash('phone');  ?></span>
                            </div>
                            <!-- campo -->
                            <div class="field flex flex-col gap-1 w-full focus-within:text-white text-lightGrayInput">
                                <label for="inputCpf" class="flex items-center gap-1">CPF<span class="text-red">*</span></label>
                                <div class="flex items-center border-2 border-lightGrayInput rounded focus-within:border-white focus-within:text-white">
                                    <i class='bx bx-id-card' style='padding-left:1rem; padding-right:1rem;'></i>
                                    <input type="text" name="cpf" id="inputCpf" maxlength="14" value="<?php echo old('cpf') ?>" class="w-full p-2 outline-none bg-transparent border-l-2 border-lightGrayInput transition-all duration-300 focus:bg-white focus:border-white focus:text-black" placeholder="Digite seu cpf">
                                </div>
                                <span class="text-errorColor " id="msgCpfError"><?php echo flash('cpf');  ?></span>
                            </div>

                        </div>

                        <!-- column 2 -->
                        <div class="w-full col-span-1 row-span-1 col-start-2 flex flex-col items-start justify-center gap-1 ">
                            
                            <!-- campo -->
                            <div class="field flex flex-col gap-1 w-full focus-within:text-white text-lightGrayInput">
                                <div>
                                    <label for="inputEmail" class="flex items-center gap-1">Email<span class="text-red">*</span></label>
                                </div>
                                <div class="flex items-center border-2 border-lightGrayInput rounded focus-within:border-white focus-within:text-white">
                                    <i class='bx bx-envelope' style='padding-left:1rem; padding-right:1rem;' ></i>
                                    <input type="text" name="email" id="inputEmail" value="<?php echo old('email') ?>" class="w-full p-2 outline-none bg-transparent border-l-2 border-lightGrayInput transition-all duration-300 focus:bg-white focus:border-white focus:text-black" placeholder="Digite seu email">
                                </div>
                                <span class="text-errorColor " id="msgEmailError"><?php echo flash('email');  ?></span>
                            </div>
                            <!-- campo -->
                            <div class="field flex flex-col gap-1 w-full focus-within:text-white text-lightGrayInput">
                                <div class="flex items-center gap-2">
                                    <label for="inputPassword" class="flex items-center gap-1">Senha<span class="text-red">*</span></label>
                                    <i class='bx bxs-help-circle hover:text-white hover:cursor-pointer' id="btnOpenModalPassword"></i>
                                </div>
                                <div class="flex items-center border-2 border-lightGrayInput rounded focus-within:border-white focus-within:text-white">
                                    <i class='bx bx-lock-alt' style='padding-left:1rem; padding-right:1rem; ' ></i>
                                    <input type="password" name="password" id="inputPassword" value="<?php echo old('password') ?>" class="w-full p-2 outline-none bg-transparent border-l-2 border-lightGrayInput transition-all duration-300 focus:bg-white focus:border-white focus:text-black" placeholder="Digite sua senha">
                                    <i class="fa-regular fa-eye pl-2 pr-2" id="btnNotViewPassword" style="display:none;"></i>
                                    <i class="fa-regular fa-eye-slash pl-2 pr-2" id="btnViewPassword"></i>
                                </div>
                                <span class="text-errorColor " id="msgPasswordError"><?php echo flash('password');  ?></span>
                            </div>
                            <!-- campo -->
                            <div class="field flex flex-col gap-1 w-full focus-within:text-white text-lightGrayInput">
                                <div>
                                    <label for="inputPassword" class="flex items-center gap-1">Confirmar senha<span class="text-red">*</span></label>
                                </div>
                                <div class="flex items-center border-2 border-lightGrayInput rounded focus-within:border-white focus-within:text-white">
                                    <i class='bx bx-lock-alt' style='padding-left:1rem; padding-right:1rem; ' ></i>
                                    <input type="password" name="password" id="inputConfirmPassword" class="w-full p-2 outline-none bg-transparent border-l-2 border-lightGrayInput transition-all duration-300 focus:bg-white focus:border-white focus:text-black" placeholder="Confirme sua senha">
                                    <i class="fa-regular fa-eye pl-2 pr-2" id="btnNotViewConfirmPassword" style="display:none;"></i>
                                    <i class="fa-regular fa-eye-slash pl-2 pr-2" id="btnViewConfirmPassword"></i>
                                </div>
                                <span class="text-errorColor " id="msgConfirmPasswordError"></span>
                            </div>
                            <!-- campo -->
                     
                        </div>
                    </div>
            </fieldset>

            <!-- container data images -->
            <fieldset id="containerDataImage" class="hidden w-full <? echo flash('validImages');?>">
                <div class="w-full flex  items-center justify-center gap-4 p-4">
                    <div class="w-1/4 hover:cursor-pointer flex flex-col items-center justify-center p-4 gap-4 border-2 border-grayInput border-dashed rounded ">
                        <input type="file" name="avatar" id="inputLogo" class="hidden">
                        <label for="inputLogo" class="flex flex-col items-center gap-2 pt-4 pb-4">
                            <img id="previewLogo"  alt="logo" >
                            <i class='bx bx-image text-4xl text-grayInput' id="iconLogo"></i>
                            <span class="text-grayInput hover:underline hover:cursor-pointer" id="spanLogo"><span class="font-semibold text-principal5">Insira</span> a logo da empresa aqui</span>
                        </label>
                        <span class="text-errorColor " id="msgInputLogo"><?php echo flash('image1');  ?></span>
                    </div>

                    <div class="w-1/4 hover:cursor-pointer flex flex-col items-center justify-center p-4 gap-4 border-2 border-grayInput border-dashed rounded ">
                        <input type="file" name="logo" id="inputAvatar" class="hidden">
                        <label for="inputAvatar" class="flex flex-col items-center gap-2 pt-4 pb-4">
                            <img id="previewAvatar"  alt="logo" >
                            <i class='bx bx-image text-4xl text-grayInput' id="iconAvatar"></i>
                            <span class="text-grayInput hover:underline hover:cursor-pointer" id="spanAvatar"><span class="font-semibold text-principal5">Insira</span> a imagem do administrador</span>
                        </label>
                        <span class="text-errorColor " id="msgInputAvatar"><?php echo flash('image1');  ?></span>
                    </div>

                    <div class="w-1/4 hover:cursor-pointer flex flex-col items-center justify-center p-4 gap-4 border-2 border-grayInput border-dashed rounded ">
                        <input type="file" name="image" id="inputImage" class="hidden">
                        <label for="inputImage" class="flex flex-col items-center gap-2 pt-4 pb-4">
                            <img id="previewImage"  alt="image" >
                            <i class='bx bx-image text-4xl text-grayInput'  id="iconImage"></i>
                            <span class="text-grayInput hover:underline hover:cursor-pointer" id="spanImage"><span class="font-semibold text-principal5">Insira</span> a imagem da empresa aqui</span>
                        </label>
                        <span class="text-errorColor " id="msgInputImage"><?php echo flash('image1');  ?></span>
                    </div>
                </div>
            </fieldset>

            <div id="controls" class="flex items-center gap-4">
                <button type="button" id="btnPrevious" class="circle-btn hover:cursor-pointer"><i class='bx bxs-chevron-left text-2xl'></i></button>
                <p id="counterStatusForm" class="text-white">1/4</p>
                <button type="button" id="btnNext" class="circle-btn hover:cursor-pointer"><i class='bx bxs-chevron-right text-2xl'></i></button>
            </div>

            <button type="submit" id="sendButton" class="hidden w-1/4 bg-white text-principal10 font-Poppins font-semibold p-2 hover:cursor-pointer hover:underline">Enviar</button>
        </form>
    </div>

    <div class="loading hidden" >
        <div class="loader"></div>
    </div>


    <script type="module" src="/assets/js/formCadCompany.js" deffer></script>
</body>