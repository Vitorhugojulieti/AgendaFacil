<body style="overflow-y:auto; overflow-x:hidden;">
    <div class="w-full min-h-screen flex flex-col justify-center items-center bg-principal10 p-4 mb-4">
        <form action="/admin/signup/store" method="post" enctype="multipart/form-data" class="w-5/6 md:w-3/5 flex flex-col items-center justify-center gap-10 ">
            <a href="/"><img src="/assets/images/logo-white.png" alt="logo" ></a>
            <legend class="font-Urbanist font-semibold text-white text-2xl md:text-3xl">Bem vindo a plataforma!</legend>
            
            <div class="status-form w-full flex items-center">
                <div class="point w-full flex flex-col items-center justify-center text-white">
                    <div class="bullet  ">
                        <span>1</span>
                        <i class='bx bx-check text-2xl' style='color:#223249'  ></i>
                    </div>
                    <span >Dados empresa</span>
                </div>

                <div class="point w-full flex flex-col items-center justify-center text-white">
                    <div class="bullet ">
                        <span>2</span>
                        <i class='bx bx-check text-2xl' style='color:#223249'  ></i>
                    </div>
                    <span >Endereço empresa</span>
                </div>

                <div class="point w-full flex flex-col items-center justify-center text-white">
                    <div class="bullet">
                        <span>3</span>
                        <i class='bx bx-check text-2xl' style='color:#223249'  ></i>
                    </div>
                    <span>Dados administrador</span>
                </div>


                <div class="point w-full flex flex-col items-center justify-center text-white">
                    <div class="bullet last">
                        <span>4</span>
                        <i class='bx bx-check text-2xl' style='color:#223249'  ></i>
                    </div>
                    <span>Imagens</span>
                </div>
            </div>
            <!-- container data company -->
            <fieldset id="containerDataCompany" class="w-full flex justify-center items-center  <? echo flash('validDataCompany');?>">
                <div class="w-full lg:grid lg:grid-rows-1 lg:grid-cols-2 gap-8 md:flex md:w-5/6 md:flex-col ">
                            <!-- column 1 -->
                            <div class="w-full col-span-1 row-span-1 col-start-1 flex flex-col items-start justify-center gap-4 ">
                                <!-- campo -->
                                <div class="field w-full focus-within:text-white text-borderFormColor">
                                    <div>
                                        <label for="inputNameCompany" >Nome</label>
                                    </div>
                                    <div class="flex items-center border-2 border-borderFormColor rounded focus-within:border-white focus-within:text-white">
                                        <i class='bx bx-briefcase'  style='padding-left:1rem; padding-right:1rem;'></i>
                                        <input type="text" name="nameCompany" id="inputNameCompany" value="<?php echo old('nameCompany') ?>" class="w-full p-2 outline-none bg-transparent border-l-2 border-borderFormColor transition-all duration-300 focus:bg-white focus:border-white focus:text-black" placeholder="Digite seu email completo">
                                    </div>
                                    <span class="text-errorColor " id="msgNameCompanyError"><?php echo flash('nameCompany');  ?></span>
                                </div>
                                <!-- campo -->
                                <div class="field w-full focus-within:text-white text-borderFormColor">
                                    <label for="inputPhoneCompany" >Telefone</label>
                                    <div class="flex items-center border-2 border-borderFormColor rounded focus-within:border-white focus-within:text-white">
                                        <i class='bx bx-phone' style='padding-left:1rem; padding-right:1rem; '></i>
                                        <input type="text" name="phoneCompany" id="inputPhoneCompany" maxlength="15" value="<?php echo old('phoneCompany') ?>" class="w-full p-2 outline-none bg-transparent border-l-2 border-borderFormColor transition-all duration-300 focus:bg-white focus:border-white focus:text-black" placeholder="Digite seu nome completo">
                                    </div>
                                    <span class="text-errorColor " id="msgPhoneCompanyError"><?php echo flash('phoneCompany');  ?></span>
                                </div>
                               

                            </div>

                            <!-- column 2 -->
                            <div class="w-full col-span-1 row-span-1 col-start-2 flex flex-col items-start justify-center gap-4 ">
                                <!-- campo -->
                                <div class="field w-full focus-within:text-white text-borderFormColor">
                                    <div>
                                        <label for="inputCategory" >Categoria</label>
                                    </div>
                                    <div class="flex items-center border-2 border-borderFormColor rounded focus-within:border-white focus-within:text-white">
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
                                 <div class="field w-full focus-within:text-white text-borderFormColor">
                                    <label for="inputCnpjCompany" >CNPJ</label>
                                    <div class="flex items-center border-2 border-borderFormColor rounded focus-within:border-white focus-within:text-white">
                                        <i class='bx bx-id-card' style='padding-left:1rem; padding-right:1rem;'></i>
                                        <input type="text" name="cnpjCompany" id="inputCnpjCompany" maxlength="14" value="<?php echo old('cnpjCompany') ?>" class="w-full p-2 outline-none bg-transparent border-l-2 border-borderFormColor transition-all duration-300 focus:bg-white focus:border-white focus:text-black" placeholder="Digite seu nome completo">
                                    </div>
                                    <span class="text-errorColor " id="msgCnpjError"><?php echo flash('cnpjCompany');  ?></span>
                                </div>
                        </div>
                    <!-- btns -->
            </fieldset>

              <!-- container data company2 -->
              <fieldset id="containerDataCompany2" class="w-full hidden justify-center items-center">
                <div class="w-full lg:grid lg:grid-rows-1 lg:grid-cols-2 gap-8 md:flex md:w-5/6 md:flex-col ">
                            <!-- column 1 -->
                            <div class="w-full col-span-1 row-span-1 col-start-1 flex flex-col items-start  gap-4 ">
                                <!-- campo -->
                                <div class="field w-full focus-within:text-white text-borderFormColor">
                                    <div>
                                        <label for="inputCep" >CEP</label>
                                    </div>
                                    <div class="flex items-center border-2 border-borderFormColor rounded focus-within:border-white focus-within:text-white">
                                        <i class='bx bx-envelope' style='padding-left:1rem; padding-right:1rem;' ></i>
                                        <input type="text" name="cep" id="inputCep"  maxlength="9" value="<?php echo old('cep') ?>" class="w-full p-2 outline-none bg-transparent border-l-2 border-borderFormColor transition-all duration-300 focus:bg-white focus:border-white focus:text-black" placeholder="Digite seu email completo">
                                    </div>
                                    <span class="text-errorColor " id="msgCepError"><?php echo flash('cep');  ?></span>
                                </div>
                                <!-- campo -->
                                <div class="field w-full focus-within:text-white text-borderFormColor">
                                    <label for="inputRoad" >Endereço</label>
                                    <div class="flex items-center border-2 border-borderFormColor rounded focus-within:border-white focus-within:text-white">
                                        <i class='bx bx-phone' style='padding-left:1rem; padding-right:1rem; '></i>
                                        <input type="text" name="road" id="inputRoad" maxlength="15" value="<?php echo old('road') ?>" class="w-full p-2 outline-none bg-transparent border-l-2 border-borderFormColor transition-all duration-300 focus:bg-white focus:border-white focus:text-black" placeholder="Digite seu nome completo">
                                    </div>
                                    <span class="text-errorColor " id="msgRoadError"><?php echo flash('road');  ?></span>
                                </div>

                                <div class="field w-full focus-within:text-white text-borderFormColor">
                                    <div>
                                        <label for="inputState" >Estado</label>
                                    </div>
                                    <div class="flex items-center border-2 border-borderFormColor rounded focus-within:border-white focus-within:text-white">
                                        <i class='bx bx-envelope' style='padding-left:1rem; padding-right:1rem;' ></i>
                                        <input type="text" name="state" id="inputState" value="<?php echo old('state') ?>" class="w-full p-2 outline-none bg-transparent border-l-2 border-borderFormColor transition-all duration-300 focus:bg-white focus:border-white focus:text-black" placeholder="Digite seu email completo">
                                    </div>
                                    <span class="text-errorColor " id="msgStateError"><?php echo flash('state');  ?></span>
                                </div>
                            </div>

                            <!-- column 2 -->
                            <div class="w-full col-span-1 row-span-1 col-start-2 flex flex-col items-start  gap-4 ">
                                <!-- campo -->
                                <div class="field w-full focus-within:text-white text-borderFormColor">
                                    <label for="inputNumber" >Numero</label>
                                    <div class="flex items-center border-2 border-borderFormColor rounded focus-within:border-white focus-within:text-white">
                                        <i class='bx bx-id-card' style='padding-left:1rem; padding-right:1rem;'></i>
                                        <input type="text" name="number" id="inputNumber" maxlength="14" value="<?php echo old('number  ') ?>" class="w-full p-2 outline-none bg-transparent border-l-2 border-borderFormColor transition-all duration-300 focus:bg-white focus:border-white focus:text-black" placeholder="Digite seu nome completo">
                                    </div>
                                    <span class="text-errorColor " id="msgNumberError"><?php echo flash('number');  ?></span>
                                </div>

                                <!-- campo -->
                                <i class="field w-full focus-within:text-white text-borderFormColor">
                                    <div>
                                        <label for="inputDistrict" >Bairro</label>
                                    </div>
                                    <div class="flex items-center border-2 border-borderFormColor rounded focus-within:border-white focus-within:text-white">
                                        <i class='bx bx-envelope' style='padding-left:1rem; padding-right:1rem;' ></i>
                                        <input type="text" name="district" id="inputDistrict" value="<?php echo old('district') ?>" class="w-full p-2 outline-none bg-transparent border-l-2 border-borderFormColor transition-all duration-300 focus:bg-white focus:border-white focus:text-black" placeholder="Digite seu email completo">
                                    </div>
                                    <span class="text-errorColor " id="msgDistrictError"><?php echo flash('district');  ?></span>
                                </div>
                            
                            <!-- campo -->
                                <div class="field w-full focus-within:text-white text-borderFormColor">
                                    <div>
                                        <label for="inputCity" >Cidade</label>
                                    </div>
                                    <div class="flex items-center border-2 border-borderFormColor rounded focus-within:border-white focus-within:text-white">
                                        <i class='bx bx-envelope' style='padding-left:1rem; padding-right:1rem;' ></i>
                                        <input type="text" name="city" id="inputCity" value="<?php echo old('city') ?>" class="w-full p-2 outline-none bg-transparent border-l-2 border-borderFormColor transition-all duration-300 focus:bg-white focus:border-white focus:text-black" placeholder="Digite seu email completo">
                                    </div>
                                    <span class="text-errorColor " id="msgCityError"><?php echo flash('city');  ?></span>
                                </div>
                               
                              
                        </div>
                    <!-- btns -->
            </fieldset>


            <!-- container data admin -->
            <fieldset id="containerDataAdmin" class="hidden w-full  justify-center items-center">
                <div class="w-full lg:grid lg:grid-rows-1 lg:grid-cols-2 gap-8 md:flex md:w-5/6 md:flex-col ">
                        <!-- column 1 -->
                        <div class="w-full col-span-1 row-span-1 col-start-1 flex flex-col items-start justify-center gap-4 ">
                            <!-- campo -->
                            <div class="field w-full focus-within:text-white text-borderFormColor">
                                <div>
                                    <label for="inputName" >Nome</label>
                                </div>
                                <div class="flex items-center border-2 border-borderFormColor rounded focus-within:border-white focus-within:text-white">
                                    <i class='bx bx-user' style=' padding-left:1rem; padding-right:1rem;'></i>
                                    <input type="text" name="name" id="inputName" value="<?php echo old('name') ?>" class="w-full p-2 outline-none bg-transparent border-l-2 border-borderFormColor transition-all duration-300 focus:bg-white focus:border-white focus:text-black" placeholder="Digite seu email completo">
                                </div>
                                <span class="text-errorColor " id="msgNameError"><?php echo flash('name');  ?></span>
                            </div>
                            <!-- campo -->
                            <div class="field w-full focus-within:text-white text-borderFormColor">
                                <label for="inputPhone" >Telefone</label>
                                <div class="flex items-center border-2 border-borderFormColor rounded focus-within:border-white focus-within:text-white">
                                    <i class='bx bx-phone' style='padding-left:1rem; padding-right:1rem; '></i>
                                    <input type="text" name="phone" id="inputPhone" maxlength="15" value="<?php echo old('phone') ?>" class="w-full p-2 outline-none bg-transparent border-l-2 border-borderFormColor transition-all duration-300 focus:bg-white focus:border-white focus:text-black" placeholder="Digite seu nome completo">
                                </div>
                                <span class="text-errorColor " id="msgPhoneError"><?php echo flash('phone');  ?></span>
                            </div>
                            <!-- campo -->
                            <div class="field w-full focus-within:text-white text-borderFormColor">
                                <label for="inputCpf" >CPF</label>
                                <div class="flex items-center border-2 border-borderFormColor rounded focus-within:border-white focus-within:text-white">
                                    <i class='bx bx-id-card' style='padding-left:1rem; padding-right:1rem;'></i>
                                    <input type="text" name="cpf" id="inputCpf" maxlength="14" value="<?php echo old('cpf') ?>" class="w-full p-2 outline-none bg-transparent border-l-2 border-borderFormColor transition-all duration-300 focus:bg-white focus:border-white focus:text-black" placeholder="Digite seu nome completo">
                                </div>
                                <span class="text-errorColor " id="msgCpfError"><?php echo flash('cpf');  ?></span>
                            </div>

                        </div>

                        <!-- column 2 -->
                        <div class="w-full col-span-1 row-span-1 col-start-2 flex flex-col items-start justify-center gap-4 ">
                            <!-- campo -->
                            <div class="field w-full focus-within:text-white text-borderFormColor">
                                <div>
                                    <label for="inputEmail" >Email</label>
                                </div>
                                <div class="flex items-center border-2 border-borderFormColor rounded focus-within:border-white focus-within:text-white">
                                    <i class='bx bx-envelope' style='padding-left:1rem; padding-right:1rem;' ></i>
                                    <input type="text" name="email" id="inputEmail" value="<?php echo old('email') ?>" class="w-full p-2 outline-none bg-transparent border-l-2 border-borderFormColor transition-all duration-300 focus:bg-white focus:border-white focus:text-black" placeholder="Digite seu email completo">
                                </div>
                                <span class="text-errorColor " id="msgEmailError"><?php echo flash('email');  ?></span>
                            </div>
                            <!-- campo -->
                            <div class="field w-full focus-within:text-white text-borderFormColor">
                                <div>
                                    <label for="inputPassword" >Senha</label>
                                    <i class='bx bxs-help-circle hover:text-white hover:cursor-pointer' id="btnOpenModalPassword"></i>
                                </div>
                                <div class="flex items-center border-2 border-borderFormColor rounded focus-within:border-white focus-within:text-white">
                                    <i class='bx bx-lock-alt' style='padding-left:1rem; padding-right:1rem; ' ></i>
                                    <input type="password" name="password" id="inputPassword" value="<?php echo old('password') ?>" class="w-full p-2 outline-none bg-transparent border-l-2 border-borderFormColor transition-all duration-300 focus:bg-white focus:border-white focus:text-black" placeholder="Digite seu nome completo">
                                    <i class="fa-regular fa-eye pl-2 pr-2" id="btnNotViewPassword" style="display:none;"></i>
                                    <i class="fa-regular fa-eye-slash pl-2 pr-2" id="btnViewPassword"></i>
                                </div>
                                <span class="text-errorColor " id="msgPasswordError"><?php echo flash('password');  ?></span>
                            </div>
                            <div class="field w-full focus-within:text-white text-borderFormColor">
                                <div>
                                    <label for="inputPassword" >Confirmar senha</label>
                                </div>
                                <div class="flex items-center border-2 border-borderFormColor rounded focus-within:border-white focus-within:text-white">
                                    <i class='bx bx-lock-alt' style='padding-left:1rem; padding-right:1rem; ' ></i>
                                    <input type="password" name="password" id="inputConfirmPassword" class="w-full p-2 outline-none bg-transparent border-l-2 border-borderFormColor transition-all duration-300 focus:bg-white focus:border-white focus:text-black" placeholder="Digite seu nome completo">
                                    <i class="fa-regular fa-eye pl-2 pr-2" id="btnNotViewConfirmPassword" style="display:none;"></i>
                                    <i class="fa-regular fa-eye-slash pl-2 pr-2" id="btnViewConfirmPassword"></i>
                                </div>
                                <span class="text-errorColor " id="msgConfirmPasswordError"></span>
                            </div>
                        </div>
                    </div>
            </fieldset>

            <!-- container data images -->
            <fieldset id="containerDataImage" class="hidden w-full">
                <div class="w-full flex  items-center justify-center gap-4 p-4">
                    <div class="flex flex-col gap-4 justify-center items-center">
                        <input type="file" name="logo" id="inputLogo" class="hidden">
                        <span class="text-lightGray">logo empresa</span>
                        <label for="inputLogo" class="hover:cursor-pointer w-4/5 flex flex-col items-center justify-center border-2  border-dashed border-lightGray p-10">
                            <span class="text-xl text-lightGray">Selecione a imagem</span>
                            <i class='bx bx-image-add text-3xl text-lightGray'></i>
                        </label>
                    </div>

                    <div class="flex flex-col gap-4 justify-center items-center">
                        <input type="file" name="logo" id="inputLogo" class="hidden">
                        <span class="text-lightGray">Avatar admin</span>
                        <label for="inputLogo" class="hover:cursor-pointer w-4/5 flex flex-col items-center justify-center border-2 border-dashed border-lightGray p-10">
                            <span class="text-xl text-lightGray">Selecione a imagem</span>
                            <i class='bx bx-image-add text-3xl text-lightGray'></i>
                        </label>
                    </div>

                    <div class="flex flex-col gap-4 justify-center items-center">
                        <input type="file" name="logo" id="inputLogo" class="hidden">
                        <span class="text-lightGray">Imagem empresa *opcional</span>
                        <label for="inputLogo" class="hover:cursor-pointer w-4/5 flex flex-col items-center justify-center border-2 border-dashed border-lightGray p-10 ">
                            <span class="text-xl text-lightGray">Selecione a imagem</span>
                            <i class='bx bx-image-add text-3xl text-lightGray'></i>
                        </label>
                    </div>
                </div>
            </fieldset>

            <div id="controls" class="flex items-center gap-4">
                <button type="button" id="btnPrevious" class="circle-btn hover:cursor-pointer"><i class='bx bxs-chevron-left text-2xl'></i></button>
                <p id="counterStatusForm" class="text-white">1/4</p>
                <button type="button" id="btnNext" class="circle-btn hover:cursor-pointer"><i class='bx bxs-chevron-right text-2xl'></i></button>
            </div>

            <button type="submit" id="sendButton" class="hidden hover:cursor-pointer">Enviar</button>
        </form>
    </div>

    <script type="module" src="/assets/js/formCadCompany.js" deffer></script>
</body>