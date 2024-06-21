<?php require 'includes/header.php';?>

<body class="w-screen h-screen overflow-y-auto overflow-x-hidden">    
<!-- hero -->
    <div class="w-full h-5/6 flex p-12 relative border-b-2 border-white">
        <div class="w-3/5 flex flex-col gap-8 p-4 text-start">
            <h1 class="font-Urbanist font-bold italic text-7xl text-principal10 ">A facilidade que cabe na sua agenda!</h1>
            <p class="w-3/5 text-xl">Com apenas alguns cliques, seus clientes podem reservar horários convenientes, garantindo um atendimento personalizado e seguro. </p>
            <button class="w-2/4 bg-principal9 text-white text-xl rounded-xl p-2 hover:underline hover:cursor-pointer">Saiba mais</button>
        </div>
        <div class="triangulo bg-principal10"></div>
        <img class="w-1/4 absolute bottom-0 right-10 " src="/assets/images/img_hero.png" alt="">
    </div>  

    <!-- servicos -->
    <div class="w-full h-max bg-principal10 text-center flex flex-col items-center p-12 gap-16 ">
        <h2 class="w-3/4 font-Urbanist font-bold italic text-5xl text-white">Economize tempo gerenciando sua agenda com nossos melhores serviços</h2>

        <!-- container serviços -->
       <div class="container w-full flex justify-around items-center">
         <!-- item servico -->
         <div class="container w-1/4 h-full border-t-2 border-l-2 border-r-2 border-b-8 border-principal3 rounded p-4 flex flex-col items-center gap-8">
            <i class='bx bx-check-circle text-7xl' style='color:#ffffff;'></i>
            <h3 class="text-white font-bold font-Urbanist text-3xl">Agendamento agil</h3>
            <p class="text-white text-xl">Cansado daquelas ligaçoes chatas? , mensagens que demroam a ser respondidas</p>
        </div>

         <!-- item servico -->
        <div class="container w-1/4 h-full border-t-2 border-l-2 border-r-2 border-b-8 border-principal3 rounded p-4 flex flex-col items-center gap-8">
            <i class='bx bx bx-lock-alt text-7xl' style='color:#ffffff;'></i>
            <h3 class="text-white font-bold font-Urbanist text-3xl">Agendamento agil</h3>
            <p class="text-white text-xl">Cansado daquelas ligaçoes chatas? , mensagens que demroam a ser respondidas</p>
        </div>

         <!-- item servico -->
        <div class="container w-1/4 h-full border-t-2 border-l-2 border-r-2 border-b-8 border-principal3 rounded p-4 flex flex-col items-center gap-8">
            <i class='bx bx-phone-off text-7xl' style='color:#ffffff;'></i>
            <h3 class="text-white font-bold font-Urbanist text-3xl">Agendamento agil</h3>
            <p class="text-white text-xl">Cansado daquelas ligaçoes chatas? , mensagens que demroam a ser respondidas</p>
        </div>
       </div>
    </div>

    <!-- planos -->
    <div class="w-full h-max text-center flex flex-col items-center p-12 pb-28 gap-16 border-b-2 border-black">
        <h2 class="w-2/4 font-Urbanist font-bold italic text-5xl text-black ">Comece hoje, com o plano basico ou premium, você escolhe</h2>

        <!-- container planos -->
        <div class="w-full h-full flex justify-center items-center gap-16 ">
            <!-- plano -->
            <div class="w-1/4 h-full p-8 border-2 border-principal10 rounded flex flex-col items-center gap-12 shadow-xl">
                <div class="">
                    <h2 class="text-5xl font-semibold italic text-principal9">Basico</h2>
                    <h3 class="text-4xl font-bold text-principal10">R$ 0.00 <span class="font-normal">/mês</span></h3>
                </div>

                <div class="container flex flex-col items-start gap-4 tex-center">
                        <!-- item check -->
                    <div class="flex items-center gap-2">
                        <i class='bx bx-check text-4xl' style='color:#0e7f0c'></i>
                        <h4 class="text-2xl">Cadastrar serviços</h4>
                    </div>
                           <!-- item check -->
                        <div class="flex items-center gap-2">
                        <i class='bx bx-check text-4xl' style='color:#0e7f0c'></i>
                        <h4 class="text-2xl">Consultar agendamentos</h4>
                    </div>
                           <!-- item check -->
                        <div class="flex items-center gap-2">
                        <i class='bx bx-check text-4xl' style='color:#0e7f0c'></i>
                        <h4 class="text-2xl">Cadastrar colaboradores</h4>
                    </div>
                           <!-- item check -->
                        <div class="flex items-center gap-2">
                        <i class='bx bx-x text-4xl' style='color:#e22b20'></i>
                        <h4 class="text-2xl">Gerar relatórios personalizados</h4>
                     </div>
                           <!-- item check -->
                        <div class="flex items-center gap-2">
                        <i class='bx bx-x text-4xl' style='color:#e22b20'></i>
                        <h4 class="text-2xl">Cadastrar vale serviços</h4>
                    </div>
                           <!-- item check -->
                        <div class="flex items-center gap-2">
                        <i class='bx bx-x text-4xl' style='color:#e22b20'></i>
                        <h4 class="text-2xl">Plataforma sem anuncios</h4>
                    </div>
                </div>

                <button class="w-3/4 bg-principal9 p-4 rounded outline-none text-white  text-lg hover:underline">COMPRAR AGORA</button>
            </div>

              <!-- plano -->
              <div class="w-1/4 h-full bg-principal10 p-8 border-2 border-principal10 rounded flex flex-col items-center gap-12 shadow-2xl scale-110">
                <div class="">
                    <h2 class="text-5xl font-semibold italic text-white">Premium</h2>
                    <h3 class="text-4xl font-bold text-white">R$ 0.00 <span class="font-normal">/mês</span></h3>
                </div>

                <div class="container flex flex-col items-start gap-4 tex-center">
                        <!-- item check -->
                    <div class="flex items-center gap-2">
                        <i class='bx bx-check text-4xl' style='color:#96DD8C'></i>
                        <h4 class="text-2xl text-white">Cadastrar serviços</h4>
                    </div>
                           <!-- item check -->
                        <div class="flex items-center gap-2">
                        <i class='bx bx-check text-4xl' style='color:#96DD8C'></i>
                        <h4 class="text-2xl text-white">Consultar agendamentos</h4>
                    </div>
                           <!-- item check -->
                        <div class="flex items-center gap-2">
                        <i class='bx bx-check text-4xl' style='color:#96DD8C'></i>
                        <h4 class="text-2xl text-white">Cadastrar colaboradores</h4>
                    </div>
                           <!-- item check -->
                        <div class="flex items-center gap-2">
                        <i class='bx bx-check text-4xl' style='color:#96DD8C'></i>
                        <h4 class="text-2xl text-white">Gerar relatórios personalizados</h4>
                     </div>
                           <!-- item check -->
                        <div class="flex items-center gap-2">
                        <i class='bx bx-check text-4xl' style='color:#96DD8C'></i>
                        <h4 class="text-2xl text-white">Cadastrar vale serviços</h4>
                    </div>
                           <!-- item check -->
                        <div class="flex items-center gap-2">
                        <i class='bx bx-check text-4xl' style='color:#96DD8C'></i>
                        <h4 class="text-2xl text-white">Plataforma sem anuncios</h4>
                    </div>
                </div>

                <button class="w-3/4 bg-white p-4 rounded outline-none text-black  text-lg hover:underline">COMPRAR AGORA</button>
            </div>

        </div>
    </div>

    <!-- sobre nos -->
    <div class="w-full h-full flex">
        <div class="w-2/4 h-full bg-img bg-cover bg-center"></div>

        <div class="w-2/4 h-full bg-principal10 p-16 flex flex-col items-start justify-around">
            <h2 class="w-3/4 font-Urbanist font-bold italic text-5xl text-white">O que é a agendaFacil ?</h2>
            <p class="w-3/5 text-xl text-white">
            Com apenas alguns cliques, seus clientes podem reservar horários convenientes, garantindo um atendimento personalizado e seguro. 
             demoradas e esperas frustrantes, descubra como podemos simplificar sua vida e proporcionar uma experiência única para seu público.
            </p>

            <button class="w-2/4 bg-white p-4 rounded outline-none text-black  text-lg hover:underline">SAIBA MAIS</button>
        </div>
    </div>

    <!-- contato -->
    <div class="w-full h-max flex flex-col items-center gap-8 p-12 text-center">
        <h2 class="w-full font-Urbanist font-bold italic text-5xl text-black ">Entre em contato com a gente</h2>

        <form action="" class="w-full flex flex-col items-center gap-8 p-8">
            <fieldset class="w-3/5 flex flex-col items-center gap-8">
                <!-- campo -->
                <div class="w-full text-start bg-inherit flex flex-col">
                    <label for="inputNome" >Nome completo</label>
                    <input type="text" id="inputNome" class="w-full border-2 border-black rounded p-2">
                </div>

                 <!-- campo -->
                 <div class="w-full text-start bg-inherit flex flex-col">
                    <label for="inputEmail" >Email</label>
                    <input type="text" id="inputEmail" class="w-full border-2 border-black rounded p-2">
                </div>

                 <!-- campo -->
                 <div class="w-full text-start bg-inherit flex flex-col">
                    <label for="inputMensagem" >Mensagem</label>
                    <textarea cols=1 rows="10" name="inputMensagem" id="inputMensagem" class="w-full border-2 border-black rounded p-2"></textarea>
                </div>
            </fieldset>

            <button type="submit" class="w-1/4 bg-principal9 p-2 rounded outline-none text-white  text-lg hover:underline">Enviar</button>
        </form>
    </div>
    <!-- duvidas -->
    <div class="w-full h-max bg-principal10 py-12 flex flex-col items-center gap-12">
        <h2 class="font-Urbanist font-bold italic text-5xl text-white text-center">Principais duvidas</h2>
        <!-- container acordions -->
        <div class="w-full border-t-2 border-white">
            <!-- acordion -->
            <div class="flex flex-col ">
                <button onclick="toggleAcordion(this)" class=" w-full border-b border-white p-4 text-left text-white text-2xl font-semibold flex justify-between items-center px-8">Pra quem é o sistema 
                    <i class='bx bx-chevron-down' style='color:#ffffff; font-size:3rem;' ></i>
                    <i class='bx bx-chevron-up' style='color:#ffffff; font-size:3rem;  display:none;' ></i>
                </button>
                
                <div class="panel bg-white text-principal10 w-full p-8">
                    <p>Prestadores de serviços que desejam uma nova forma de gerenciar seus agendamentos</p>
                </div>
            </div>

             <!-- acordion -->
             <div class="flex flex-col ">
                <button onclick="toggleAcordion(this)" class="w-full border-b border-white p-4 text-left text-white text-2xl font-semibold flex justify-between items-center px-8">Pra quem é o sistema 
                    <i class='bx bx-chevron-down' style='color:#ffffff; font-size:3rem;' ></i>
                    <i class='bx bx-chevron-up' style='color:#ffffff; font-size:3rem; display:none;' ></i>
                </button>
                
                <div class="panel bg-white text-principal10 w-full p-8">
                    <p>Lorem ipsum...</p>
                </div>
            </div>

             <!-- acordion -->
             <div class="flex flex-col ">
                <button onclick="toggleAcordion(this)" class="w-full border-b border-white p-4 text-left text-white text-2xl font-semibold flex justify-between items-center px-8">Pra quem é o sistema 
                    <i class='bx bx-chevron-down' style='color:#ffffff; font-size:3rem;' ></i>
                    <i class='bx bx-chevron-up' style='color:#ffffff; font-size:3rem; display:none;' ></i>
                </button>
                
                <div class="panel bg-white text-principal10 w-full p-8">
                    <p>Lorem ipsum...</p>
                </div>
            </div>

             <!-- acordion -->
             <div class="flex flex-col ">
                <button onclick="toggleAcordion(this)" class="w-full border-b-1 border-white p-4 text-left text-white text-2xl font-semibold flex justify-between items-center px-8">Pra quem é o sistema 
                    <i class='bx bx-chevron-down' style='color:#ffffff; font-size:3rem;' ></i>
                    <i class='bx bx-chevron-up' style='color:#ffffff; font-size:3rem; display:none;' ></i>
                </button>
                
                <div class="panel bg-white text-principal10 w-full p-8">
                    <p>Lorem ipsum...</p>
                </div>
            </div>
        </div>
    </div>
    <!-- footer -->
    <?php require 'includes/footer.php';?>
    <script src="/assets/js/acordions.js" deffer></script>
</body>
</html>


