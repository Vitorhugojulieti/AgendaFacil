<!-- HEADER FOR COMPANY -->
<?php if(isset($_SESSION['collaborator']) && $_SESSION['collaborator']->getNivel() === 'manager'){ ?>
<header class="lg:flex  bg-white lg:w-5/6 sm:w-full md:w-full hidden flex-col items-center justify-center gap-4 p-4 border-b-2 border-lightGray absolute md:left-0 sm:left-0 " style="left:17%; height:10%;">
    <div class="w-full flex justify-between items-center">

       <div><?php echo getCompanyActive(); ?></div>

        <div class="lg:flex hidden buttons items-center gap-8">
            <div class="flex items-center gap-2 relative">
                <div id="btnOpenPopUpNotification" class="p-3 flex items-center gap-4 hover:cursor-pointer ">
                    <i class='bx bx-bell text-principal10 text-xl' ></i>
                    <span class="font-Urbanist font-medium hover:underline">Notificações</span>
                    <?php if(isset($_SESSION['unmarkedNotifications']) && $_SESSION['unmarkedNotifications'] > 0){ ?>
                        <span class="w-6 h-6 rounded-full bg-principal9 text-white text-center" id="displayNotifications"><?php echo $unmarkedNotifications ;?></span>
                    <?php }?> 
                </div>

                <div id="popUpNotification" class="pop-menu-notification hidden w-96 flex-col items-start bg-white z-10 rounded-xl  shadow-sm shadow-black">
                    <span class="w-full font-Urbanist text-xl font-semibold text-black p-4 pb-8">Notificações</span>
                    <div class="notificationList pt-2 pb-2  max-h-80">
                        <?php echo getCompanysNotifications();?>
                        
                    </div>
                    <span class="w-full flex justify-between items-center p-2 bg-white">
                        <a href="" class="text-sm hover:underline">Marcar todas como lida</a>
                        <a href="/admin/notification" class="text-sm hover:underline">Ver todas notificações</a>
                    </span>
                </div>
            </div>

            <div class="avatar-user relative">
                <!-- <img src="" alt=""> -->
                <img id="btnOpenPopUpAvatar" src="<?php echo isset($_SESSION['collaborator']) ? IMAGES_DIR.$_SESSION['collaborator']->getAvatar() : '/assets/images/avatar_default.png';?>" alt="" class="redondShapeImageCollaborator hover:cursor-pointer">

                <div id="popUpAvatar" class="hidden flex-col items-start bg-white  rounded-xl pop-menu-avatar shadow-sm shadow-black ">
                    <a href="" class="flex items-center gap-1 p-2 border-b-2 border-lightGray rounded-t-xl hover:bg-lightGray"><i class='bx bx-cog' style='color:#223249'  ></i>Configurações</a>
                    <a href="/admin/login/destroy" class="p-2 flex items-center gap-1 rounded-b-xl hover:bg-lightGray" ><i class='bx bx-log-out' style='color:#223249' ></i>Logout</a>
                </div>
            </div>
        </div>
    </div>
    <script type="module" src="/assets/js/header.js" deffer></script>
</header>
<!-- menu mobile -->
<header class="lg:hidden bg-white w-full flex flex-col items-center justify-center gap-4 p-4 border-b-2 border-lightGray">
    <div class=" w-full flex justify-between items-center">
       <a href="#" ><img src="/assets/images/logo.png" alt="logo agendaFacil"></a>
       <button id="btnOpenMenuMobile" class="md:block lg:hidden"><i class='bx bx-menu text-2xl' style='color:#223249'  ></i></button>
    </div>

    <div id="menuMobile" class="hidden bg-principal10 text-white w-3/4 min-h-full p-4  flex-col items-start gap-8 fixed top-0 left-0 z-10">
        <div id="btnCloseMenuMobile" class="w-full flex justify-end"><i class='bx bx-x text-2xl text-white'></i></div>
        <div class="avatar-user w-full flex flex-col items-start gap-4 p-4 border-b border-lightGrayInput">
            <img id="btnOpenPopUpAvatar" src="<?php echo isset($_SESSION['collaborator']) ? IMAGES_DIR.$_SESSION['collaborator']->getAvatar() : '/assets/images/avatar_default.png';?>" alt="" class="redondShapeImageCollaborator " >
            <span class="w0full text-xl font-Urbanist font-semibold"><?php echo isset($_SESSION['collaborator']) ? $_SESSION['collaborator']->getName() : 'usuario';?></span>
        </div>

        <nav class=" flex w-full  bg-principal10 text-white  flex-col p-4 " >
            <ul class="w-full flex flex-col gap-8 font-Poppins">
                <h2 class="text-2xl border-b-2 border-b-white">Menu</h2>

                <li class="<?php echo $navActive ==='dashboard' ? 'bg-white p-2 rounded text-principal10' : ''?> hover:cursor-pointer flex items-center gap-2"><i class='bx bx-home'></i><a  href="/admin" class="hover:underline  text-xl">Dashboard</a></li>
                <li class="<?php echo $navActive ==='Agenda' ? 'bg-white p-2 rounded text-principal10' : ''?> hover:cursor-pointer flex items-center gap-2"><i class='bx bx-calendar'></i><a  href="#" class="hover:underline  text-xl">Agenda</a></li>
                <li class="<?php echo $navActive ==='servicos' ? 'bg-white p-2 rounded text-principal10' : ''?> hover:cursor-pointer flex items-center gap-2"><i class='bx bx-folder'></i><a href="/admin/service"  class="hover:underline  text-xl">Serviços</a></li>
                <li class="<?php echo $navActive ==='colaboradores' ? 'bg-white p-2 rounded text-principal10' : ''?> hover:cursor-pointer flex items-center gap-2"><i class='bx bx-user' ></i><a href="/admin/collaborator"  class="hover:underline  text-xl">Colaboradores</a></li>
                <li class="<?php echo $navActive ==='Relatorios' ? 'bg-white p-2 rounded text-principal10' : ''?> hover:cursor-pointer flex items-center gap-2"><i class='bx bx-bar-chart-square'></i><a href="#"  class="hover:underline  text-xl">Relatorios</a></li>
                <li class="<?php echo $navActive ==='Cupons' ? 'bg-white p-2 rounded text-principal10' : ''?> hover:cursor-pointer flex items-center gap-2"><i class="fa-solid fa-ticket"></i><a href="#"  class="hover:underline  text-xl">Cupons</a> <span class="border-2 border-principal5 text-principal5 rounded px-2 text-sm">Pro</span></li>
                <li class="<?php echo $navActive ==='Dados' ? 'bg-white p-2 rounded text-principal10' : ''?> hover:cursor-pointer flex items-center gap-2"><i class='bx bx-data'></i><a href="#"  class="hover:underline  text-xl">Dados empresa</a></li>
                <a href="/admin/login/destroy" class="flex items-center gap-2 hover:cursor-pointer"><i class='bx bx-log-out'></i><span class="hover:underline">Sair</span></a>
            </ul>
        </nav>
    </div>
    <script type="module" src="/assets/js/header.js" deffer></script>
</header>
<!-- end menu mobile -->

<!-- end header company -->

<?php }else if(isset($_SESSION['collaborator']) && $_SESSION['collaborator']->getNivel() === 'collaborator'){ ?>
<header class="lg:flex  bg-white lg:w-5/6 sm:w-full md:w-full hidden flex-col items-center justify-center gap-4 p-4 border-b-2 border-lightGray absolute md:left-0 sm:left-0 " style="left:17%; height:10%;">
    <div class="w-full flex justify-end items-center">

        <div class="lg:flex hidden buttons items-center gap-8">
            <div class="flex items-center gap-2 relative">
                <div id="btnOpenPopUpNotification" class="p-3 flex items-center gap-4 hover:cursor-pointer ">
                    <i class='bx bx-bell text-principal10 text-xl' ></i>
                    <span class="font-Urbanist font-medium hover:underline">Notificações</span>
                    <?php if(isset($unmarkedNotifications) && $unmarkedNotifications > 0){ ?>
                        <span class="w-6 h-6 rounded-full bg-principal9 text-white text-center" id="displayNotifications"><?php echo $unmarkedNotifications ;?></span>
                    <?php }?> 
                </div>

                <div id="popUpNotification" class="pop-menu-notification hidden w-96 flex-col items-start bg-white  rounded-xl  shadow-sm shadow-black">
                    <span class="w-full font-Urbanist text-xl font-semibold text-black p-4 pb-8">Notificações</span>
                    <div id="notificationList pt-2 pb-2 overflow-y-auto">
                        <?php foreach ($notifications as $notification) { 
                            $now = new DateTime(); 
                            $interval = $now->diff($notification->getDate());
                        ?>
                            <!-- notification -->
                            <div class="w-full <?php echo $notification->getNotified() === 0 ? 'bg-grayNotification' : 'bg-white'?> flex gap-4 items-center p-2 border-b border-b-grayInput">
                                <div class="circle-notification">
                                    <i class='bx bxs-message text-2xl' style='color:#ffff'  ></i>
                                </div>
                                <div class="bodyNotification flex flex-col items-start gap-1">
                                    <span class="text-base text-black font-semibold font-Urbanist"><?php echo $notification->getMessage();?></span>
                                    <span class="text-sm"><?php echo 'Há '.$interval->i.'minutos' ?> </span>
                                    <a href="<?php echo $notification->getLink(); ?>" class="text-sm hover:underline">Ver detalhes</a>
                                </div>
                            </div>
                        <?php } ?>
                        
                    </div>
                    <span class="w-full flex justify-between items-center p-2">
                        <a href="" class="text-sm hover:underline">Marcar todas como lida</a>
                        <a href="" class="text-sm hover:underline">Ver todas notificações</a>
                    </span>
                </div>
            </div>

            <div class="avatar-user relative">
                <!-- <img src="" alt=""> -->
                <img id="btnOpenPopUpAvatar" src="<?php echo isset($_SESSION['collaborator']) ? IMAGES_DIR.$_SESSION['collaborator']->getAvatar() : '/assets/images/avatar_default.png';?>" alt="" class="redondShapeImageCollaborator hover:cursor-pointer">

                <div id="popUpAvatar" class="hidden flex-col items-start bg-white  rounded-xl pop-menu-avatar shadow-sm shadow-black ">
                    <a href="" class="flex items-center gap-1 p-2 border-b-2 border-lightGray rounded-t-xl hover:bg-lightGray"><i class='bx bx-cog' style='color:#223249'  ></i>Configurações</a>
                    <a href="/admin/login/destroy" class="p-2 flex items-center gap-1 rounded-b-xl hover:bg-lightGray" ><i class='bx bx-log-out' style='color:#223249' ></i>Logout</a>
                </div>
            </div>
        </div>
    </div>
    <script type="module" src="/assets/js/header.js" deffer></script>
</header>
<!-- menu mobile -->
<header class="lg:hidden bg-white w-full flex flex-col items-center justify-center gap-4 p-4 border-b-2 border-lightGray">
    <div class=" w-full flex justify-between items-center">
       <a href="#" ><img src="/assets/images/logo.png" alt="logo agendaFacil"></a>
       <button id="btnOpenMenuMobile" class="md:block lg:hidden"><i class='bx bx-menu text-2xl' style='color:#223249'  ></i></button>
    </div>

    <div id="menuMobile" class="hidden bg-principal10 text-white w-3/4 min-h-full p-4  flex-col items-start gap-8 fixed top-0 left-0 z-10">
        <div id="btnCloseMenuMobile" class="w-full flex justify-end"><i class='bx bx-x text-2xl text-white'></i></div>
        <div class="avatar-user w-full flex flex-col items-start gap-4 p-4 border-b border-lightGrayInput">
            <img id="btnOpenPopUpAvatar" src="<?php echo isset($_SESSION['collaborator']) ? IMAGES_DIR.$_SESSION['collaborator']->getAvatar() : '/assets/images/avatar_default.png';?>" alt="" class="redondShapeImageCollaborator " >
            <span class="w0full text-xl font-Urbanist font-semibold"><?php echo isset($_SESSION['collaborator']) ? $_SESSION['collaborator']->getName() : 'usuario';?></span>
        </div>

        <nav class=" flex w-full  bg-principal10 text-white  flex-col p-4 " >
            <ul class="w-full flex flex-col gap-8 font-Poppins">
                <h2 class="text-2xl border-b-2 border-b-white">Menu</h2>

                <li class="<?php echo $navActive ==='dashboard' ? 'bg-white p-2 rounded text-principal10' : ''?> hover:cursor-pointer flex items-center gap-2"><i class='bx bx-home'></i><a  href="/admin" class="hover:underline  text-xl">Dashboard</a></li>
                <li class="<?php echo $navActive ==='Agenda' ? 'bg-white p-2 rounded text-principal10' : ''?> hover:cursor-pointer flex items-center gap-2"><i class='bx bx-calendar'></i><a  href="#" class="hover:underline  text-xl">Agenda</a></li>
                <li class="<?php echo $navActive ==='servicos' ? 'bg-white p-2 rounded text-principal10' : ''?> hover:cursor-pointer flex items-center gap-2"><i class='bx bx-folder'></i><a href="/admin/service"  class="hover:underline  text-xl">Serviços</a></li>
                <li class="<?php echo $navActive ==='colaboradores' ? 'bg-white p-2 rounded text-principal10' : ''?> hover:cursor-pointer flex items-center gap-2"><i class='bx bx-user' ></i><a href="/admin/collaborator"  class="hover:underline  text-xl">Colaboradores</a></li>
                <li class="<?php echo $navActive ==='Relatorios' ? 'bg-white p-2 rounded text-principal10' : ''?> hover:cursor-pointer flex items-center gap-2"><i class='bx bx-bar-chart-square'></i><a href="#"  class="hover:underline  text-xl">Relatorios</a></li>
                <li class="<?php echo $navActive ==='Cupons' ? 'bg-white p-2 rounded text-principal10' : ''?> hover:cursor-pointer flex items-center gap-2"><i class="fa-solid fa-ticket"></i><a href="#"  class="hover:underline  text-xl">Cupons</a> <span class="border-2 border-principal5 text-principal5 rounded px-2 text-sm">Pro</span></li>
                <li class="<?php echo $navActive ==='Dados' ? 'bg-white p-2 rounded text-principal10' : ''?> hover:cursor-pointer flex items-center gap-2"><i class='bx bx-data'></i><a href="#"  class="hover:underline  text-xl">Dados empresa</a></li>
                <a href="/admin/login/destroy" class="flex items-center gap-2 hover:cursor-pointer"><i class='bx bx-log-out'></i><span class="hover:underline">Sair</span></a>
            </ul>
        </nav>
    </div>
    <script type="module" src="/assets/js/header.js" deffer></script>
</header>
<!-- end menu mobile -->

<!-- end header company -->

<!----------------------------- HEADER FOR USER ------------------------------------------------------->
<?php    }else if(isset($_SESSION['user']) && isset($_SESSION['auth'])){ ?>

<header  class="lg:flex  bg-white lg:w-5/6 sm:w-full md:w-full hidden flex-col items-center justify-center gap-4 p-4 border-b-2 border-lightGray fixed md:left-0 sm:left-0 z-10 " style="top:0; left:17%; height:10%;">
    <div class="w-full flex justify-between items-center">
        <?php if(isset($location)){?>
            <button class="location  flex gap-1 items-center justify-start " id="btnOpenModalLocation">
                <i class='bx bxs-map text-principal10'></i>
                <span id="spanLocation"><?php echo  $location; ?></span>
            </button>
        <?php } ?>

        <!-- <div class="lg:flex hidden search w-2/4  items-center bg-graySearchInput  rounded focus-within:shadow-sm focus-within:shadow-black focus-within:border-grayInput">
            <input type="text" class="w-full ml-2 outline-none bg-transparent p-2 placeholder:text-placeholder" placeholder="Buscar">
            <i class='bx bx-search p-2  text-principal10 cursor-pointer'></i>
        </div> -->

        <div class="lg:flex hidden  buttons  items-center gap-8">
            <div class="flex items-center gap-2 relative">
                <div id="btnOpenPopUpNotification" class="p-3 flex items-center gap-4 hover:cursor-pointer ">
                    <i class='bx bx-bell text-principal10 text-xl' ></i>
                    <span class="font-Urbanist font-medium hover:underline">Notificações</span>
                    <?php if(isset($unmarkedNotifications) && $unmarkedNotifications > 0){ ?>
                        <span class="w-6 h-6 rounded-full bg-principal9 text-white text-center" id="displayNotifications"><?php echo $unmarkedNotifications ;?></span>
                    <?php }?> 
                </div>

                <div id="popUpNotification" class="pop-menu-notification hidden w-96 flex-col items-start bg-white  rounded-xl  shadow-sm shadow-black">
                    <span class="w-full font-Urbanist text-xl font-semibold text-black p-4 pb-8">Notificações</span>
                    <div id="notificationList pt-2 pb-2 overflow-y-auto">
                        <?php foreach ($notifications as $notification) { 
                            $now = new DateTime(); 
                            $interval = $now->diff($notification->getDate());
                        ?>
                            <!-- notification -->
                            <div class="w-full <?php echo $notification->getNotified() === 0 ? 'bg-grayNotification' : 'bg-white'?> flex gap-4 items-center p-2 border-b border-b-grayInput">
                                <div class="circle-notification">
                                    <i class='bx bxs-message text-2xl' style='color:#ffff'  ></i>
                                </div>
                                <div class="bodyNotification flex flex-col items-start gap-1">
                                    <span class="text-base text-black font-semibold font-Urbanist"><?php echo $notification->getMessage();?></span>
                                    <span class="text-sm"><?php echo 'Há '.$interval->i.'minutos' ?> </span>
                                    <a href="<?php echo $notification->getLink(); ?>" class="text-sm hover:underline">Ver detalhes</a>
                                </div>
                            </div>
                        <?php } ?>
                        
                    </div>
                    <span class="w-full flex justify-between items-center p-2">
                        <a href="" class="text-sm hover:underline">Marcar todas como lida</a>
                        <a href="" class="text-sm hover:underline">Ver todas notificações</a>
                    </span>
                </div>
            </div>

            <div class=" avatar-user relative">
                <!-- <img src="" alt=""> -->
                <img id="btnOpenPopUpAvatar" src="<?php echo isset($_SESSION['user']) ? $_SESSION['user']->getAvatar() : '/assets/images/avatar_default.png';?>" alt="" class="redondShapeImageCollaborator hover:cursor-pointer">

                <div id="popUpAvatar" class="hidden flex-col items-start bg-white  rounded-xl pop-menu-avatar shadow-sm shadow-black ">
                    <a href="" class="flex items-center gap-1 p-2 border-b-2 border-lightGray hover:bg-lightGray"><i class='bx bx-cog' style='color:#223249'  ></i>Configurações</a>
                    <a href="/login/destroy" class="p-2 flex items-center gap-1 hover:bg-lightGray" ><i class='bx bx-log-out' style='color:#223249' ></i>Logout</a>
                </div>
            </div>
        </div>
    </div>

     <!-- modais -->
     <dialog id="modalLocation" class="w-screen h-screen lg:h-max lg:w-2/6 bg-white text-black rounded-xl p-4 border border-grayInput shadow-lg shadow-black overflow-y-hidden"  >
        <form action="/home/setLocation" method="post" id="formLocation" class="h-screen lg:h-max w-full flex justify-center items-center">
            <fieldset class="w-full p-4 text-center flex flex-col items-center  gap-6">
                <legend class="font-Urbanist font-bold italic text-3xl">Onde você está?</legend>
                <span class="text-sm mb-2">Ajude-nos a encontrar os serviços mais perto de você!</span>
              
                <div class="w-full flex flex-col gap-2 text-start">
                    <div class="field w-full border border-grayInput rounded p-2 relative">
                        <input type="text" name="locationUser"  id="inputLocation" class="animationLabel w-full border-none outline-none" required maxlength="9">
                        <label for="inputLocation" class="w-max absolute bg-white text-sm text-grayInput pl-2 pr-2" >CEP</label>
                    </div>
                    <span class="text-errorColor " id="spanErrorCep"></span>
                </div>

                <span id="viewLocation" class="text-xl font-Urbanist font-semibold flex items-center"><?php echo "<i class='bx bxs-map text-principal10'></i>". $location; ?></span>

                <div class="lg:w-full w-2/4 flex items-center gap-4">
                    <button class="w-full p-4 rounded bg-principal10 text-white font-Urbanist font-bold opacity-90 transition-opacity hover:underline hover:opacity-100">Confirmar</button>
                    <button id="btnCloseModalLocation" class="hidden w-full p-4 rounded border border-principal10 bg-white text-principal-10 font-Urbanist font-bold  hover:underline">Cancelar</button>
                </div>
            </fieldset>
        </form>
    </dialog>

    <script type="module" src="/assets/js/header.js" deffer></script>
</header>
<!-- menu mobile -->
<header class="lg:hidden bg-white w-full flex flex-col items-center justify-center gap-4 p-4 border-b-2 border-lightGray ">
    <div class=" w-full flex justify-between items-center">
       <a href="#" ><img src="/assets/images/logo.png" alt="logo agendaFacil"></a>
       <button id="btnOpenMenuMobile" class="md:block lg:hidden"><i class='bx bx-menu text-2xl' style='color:#223249'  ></i></button>
    </div>
    <div id="menuMobile" class="hidden bg-principal10 text-white w-3/4 h-screen p-4  flex-col items-start gap-8 fixed top-0 left-0 z-10">
        <div id="btnCloseMenuMobile" class="w-full flex justify-end"><i class='bx bx-x text-2xl text-white'></i></div>
        <div class="avatar-user w-full flex gap-4 p-4 border-b border-lightGrayInput">
            <img id="btnOpenPopUpAvatar" src="<?php echo isset($_SESSION['user']) ? IMAGES_DIR.$_SESSION['user']->getAvatar() : '/assets/images/avatar_default.png';?>" alt="" class="redondShapeImageCollaborator " >
            <div class="flex flex-col items-start">
                <span class="w0full text-xl font-Urbanist font-semibold"><?php echo isset($_SESSION['user']) ? $_SESSION['user']->getName() : 'usuario';?></span>
                <button class="location w-full flex gap-1 items-center justify-start " id="btnOpenModalLocation">
                    <i class='bx bxs-map text-white'></i>
                    <span id="spanLocation"><?php echo  $location; ?></span>
                </button>
            </div>
        </div>

        <nav class=" flex w-full  bg-principal10 text-white  flex-col p-4 " >
            <ul class="w-full flex flex-col gap-8 font-Poppins">
                <h2 class="text-2xl border-b-2 border-b-white">Menu</h2>

                <li class="<?php echo $navActive ==='home' ? 'bg-white p-4 rounded text-principal10' : ''?> hover:cursor-pointer flex items-center gap-2"><i class='bx bx-home text-2xl'></i><a  href="/" class="hover:underline text-xl">Home</a></li>
                <li class="<?php echo $navActive ==='Agenda' ? 'bg-white p-4 rounded text-principal10' : ''?> hover:cursor-pointer flex items-center gap-2"><i class='bx bx-calendar text-2xl'></i><a  href="/schedule/" class="hover:underline text-xl">Agenda</a></li>
                <li class="<?php echo $navActive ==='Cupons' ? 'bg-white p-4 rounded text-principal10' : ''?> hover:cursor-pointer flex items-center gap-2"><i class="fa-solid fa-ticket text-2xl"></i><a href="#"  class="hover:underline text-xl">Cupons</a> <span class="border-2 border-principal5 text-principal5 rounded px-2 text-sm">Pro</span></li>
                <li class="<?php echo $navActive ==='Dados' ? 'bg-white p-4 rounded text-principal10' : ''?> hover:cursor-pointer flex items-center gap-2"><i class='bx bx-data text-2xl'></i><a href="/data"  class="hover:underline text-xl">Dados usuario</a></li>
                <a href="#" class="flex items-center gap-2 hover:cursor-pointer"><i class='bx bx-cog text-2xl'></i><span class="hover:underline text-xl">Configurações</span></a>
                <a href="/login/destroy" class="flex items-center gap-2 hover:cursor-pointer"><i class='bx bx-log-out text-2xl'></i><span class="hover:underline text-xl">Sair</span></a>
            </ul>
        </nav>
    </div>

       <!-- modais -->
       <dialog id="modalLocation" class="w-screen h-screen lg:h-max lg:w-2/6 bg-white text-black rounded-xl p-4 border border-grayInput shadow-lg shadow-black overflow-y-hidden"  >
        <form action="/home/setLocation" method="post" id="formLocation" class="h-screen lg:h-max w-full flex justify-center items-center">
            <fieldset class="w-full p-4 text-center flex flex-col items-center  gap-6">
                <legend class="font-Urbanist font-bold italic text-3xl">Onde você está?</legend>
                <span class="text-sm mb-2">Ajude-nos a encontrar os serviços mais perto de você!</span>
              
                <div class="w-full flex flex-col gap-2 text-start">
                    <div class="field w-full border border-grayInput rounded p-2 relative">
                        <input type="text" name="locationUser"  id="inputLocation" class="animationLabel w-full border-none outline-none" required maxlength="9">
                        <label for="inputLocation" class="w-max absolute bg-white text-sm text-grayInput pl-2 pr-2" >CEP</label>
                    </div>
                    <span class="text-errorColor " id="spanErrorCep"></span>
                </div>

                <span id="viewLocation" class="text-xl font-Urbanist font-semibold flex items-center"><?php echo "<i class='bx bxs-map text-principal10'></i>". $location; ?></span>

                <div class="lg:w-full w-2/4 flex items-center gap-4">
                    <button class="w-full p-4 rounded bg-principal10 text-white font-Urbanist font-bold opacity-90 transition-opacity hover:underline hover:opacity-100">Confirmar</button>
                    <button id="btnCloseModalLocation" class="hidden w-full p-4 rounded border border-principal10 bg-white text-principal-10 font-Urbanist font-bold  hover:underline">Cancelar</button>
                </div>
            </fieldset>
        </form>
    </dialog>
    <script type="module" src="/assets/js/header.js" deffer></script>
</header>
<!-- end menu mobile -->
<?php    } ?>
