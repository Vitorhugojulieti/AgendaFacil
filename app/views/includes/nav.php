<!-- NAV FOR COMPANY -->
<?php  if(isset($_SESSION['collaborator'])  && $_SESSION['collaborator']->getNivel() === 'manager'){ ?>

<nav class="lg:flex hidden w-1/6 min-h-full bg-principal10 text-white  flex-col justify-start items-center gap-16 p-4 fixed left-0 top-0" >
    <a href="/admin"><img src="/assets/images/logo-white.png" alt="logo agendaFacil" style="width:75%"></a>
    
    <ul class="w-full flex flex-col gap-4 font-Poppins">
        <h2 class="border-b-2 border-b-white">Menu</h2>

        <li class="<?php echo $navActive ==='dashboard' ? 'bg-white p-2 rounded text-principal10' : ''?> hover:cursor-pointer flex items-center gap-2"><i class='bx bx-home'></i><a  href="/admin" class="hover:underline">Dashboard</a></li>
        <li class="<?php echo $navActive ==='agenda' ? 'bg-white p-2 rounded text-principal10' : ''?> hover:cursor-pointer flex items-center gap-2"><i class='bx bx-calendar'></i><a  href="/admin/schedule" class="hover:underline">Agenda</a></li>
        <li class="<?php echo $navActive ==='servicos' ? 'bg-white p-2 rounded text-principal10' : ''?> hover:cursor-pointer flex items-center gap-2"><i class='bx bx-folder'></i><a href="/admin/service"  class="hover:underline">Serviços</a></li>
        <li class="<?php echo $navActive ==='colaboradores' ? 'bg-white p-2 rounded text-principal10' : ''?> hover:cursor-pointer flex items-center gap-2"><i class='bx bx-user' ></i><a href="/admin/collaborator"  class="hover:underline">Colaboradores</a></li>
        <li class="<?php echo $navActive ==='relatorios' ? 'bg-white p-2 rounded text-principal10' : ''?> hover:cursor-pointer flex items-center gap-2"><i class='bx bx-bar-chart-square'></i><a href="/admin/report"  class="hover:underline">Relatorios</a></li>
        <li class="<?php echo $navActive ==='data' ? 'bg-white p-2 rounded text-principal10' : ''?> hover:cursor-pointer flex items-center gap-2"><i class='bx bx-data'></i><a href="/admin/data"  class="hover:underline">Dados empresa</a></li>
        <li class="<?php echo $navActive ==='dataAdm' ? 'bg-white p-2 rounded text-principal10' : ''?> hover:cursor-pointer flex items-center gap-2"><i class='bx bx-data'></i><a href="/admin/data/admin"  class="hover:underline">Dados admin</a></li>
        <a href="/admin/login/destroy" class="flex items-center gap-2 hover:cursor-pointer"><i class='bx bx-log-out'></i><span class="hover:underline">Sair</span></a>
    </ul>
</nav>

<nav class="menuMobile w-screen h-screen absolute top-0 right-0 z-10  flex flex-col gap-8 p-4 bg-principal10 text-white" style="display:none;">
    <h2 class="border-b-2 border-b-white">Menu</h2>
    <ul class="w-full flex flex-col gap-4 font-Poppins">
        <li class="hover:cursor-pointer flex items-center gap-2"><i class='bx bx-calendar'></i><a  href="/admin/schedule">Agenda</a></li>
        <li class="hover:cursor-pointer flex items-center gap-2"><i class='bx bx-folder'></i><a href="/admin/service" >Serviços</a></li>
        <li class="hover:cursor-pointer flex items-center gap-2"><i class='bx bx-user' ></i><a href="/admin/collaborator" >Colaboradores</a></li>
        <li class="hover:cursor-pointer flex items-center gap-2"><i class='bx bx-bar-chart-square'></i><a href="#" >Relatorios</a></li>
        <li class="hover:cursor-pointer flex items-center gap-2"><i class='bx bx-data'></i><a href="#" >Dados empresa</a></li>
    </ul>

    <div class="btns flex flex-col gap-4">
        <a href="#" class="flex items-center gap-2"><i class='bx bx-cog'></i><span>Configurações</span></a>
        <a href="/admin/login/destroy" class="flex items-center gap-2"><i class='bx bx-log-out'></i><span>Sair</span></a>
    </div>
</nav>

<!-- NAV FOR collaborator -->
<?php }else if(isset($_SESSION['collaborator'])  && $_SESSION['collaborator']->getNivel() === 'collaborator'){ ?>

<nav class="lg:flex hidden w-1/6 min-h-full bg-principal10 text-white  flex-col justify-start items-center gap-16 p-4 fixed left-0 top-0" >
    <a href="/admin"><img src="/assets/images/logo-white.png" alt="logo agendaFacil" style="width:75%"></a>
    
    <ul class="w-full flex flex-col gap-4 font-Poppins">
        <h2 class="border-b-2 border-b-white">Menu</h2>

        <li class="<?php echo $navActive ==='agenda' ? 'bg-white p-2 rounded text-principal10' : ''?> hover:cursor-pointer flex items-center gap-2"><i class='bx bx-calendar'></i><a  href="/admin/schedule" class="hover:underline">Agenda</a></li>
        <li class="<?php echo $navActive ==='data' ? 'bg-white p-2 rounded text-principal10' : ''?> hover:cursor-pointer flex items-center gap-2"><i class='bx bx-data'></i><a href="/admin/data"  class="hover:underline">Meus dados</a></li>
        <a href="/admin/login/destroy" class="flex items-center gap-2 hover:cursor-pointer"><i class='bx bx-log-out'></i><span class="hover:underline">Sair</span></a>
    </ul>
</nav>

<nav class="menuMobile w-screen h-screen absolute top-0 right-0 z-10  flex flex-col gap-8 p-4 bg-principal10 text-white" style="display:none;">
    <h2 class="border-b-2 border-b-white">Menu</h2>
    <ul class="w-full flex flex-col gap-4 font-Poppins">
        <li class="hover:cursor-pointer flex items-center gap-2"><i class='bx bx-calendar'></i><a  href="/admin/schedule">Agenda</a></li>
        <li class="hover:cursor-pointer flex items-center gap-2"><i class='bx bx-folder'></i><a href="/admin/service" >Serviços</a></li>
        <li class="hover:cursor-pointer flex items-center gap-2"><i class='bx bx-user' ></i><a href="/admin/collaborator" >Colaboradores</a></li>
        <li class="hover:cursor-pointer flex items-center gap-2"><i class='bx bx-bar-chart-square'></i><a href="#" >Relatorios</a></li>
        <li class="hover:cursor-pointer flex items-center gap-2"><i class='bx bx-data'></i><a href="#" >Dados empresa</a></li>
    </ul>

    <div class="btns flex flex-col gap-4">
        <a href="#" class="flex items-center gap-2"><i class='bx bx-cog'></i><span>Configurações</span></a>
        <a href="/admin/login/destroy" class="flex items-center gap-2"><i class='bx bx-log-out'></i><span>Sair</span></a>
    </div>
</nav>

<!-- NAV FOR USER -->
<?php }else if(isset($_SESSION['user'])){ ?>

<nav class="lg:flex hidden w-1/6 min-h-full bg-principal10 text-white  flex-col justify-start items-center gap-16 p-4 fixed left-0 top-0" >
    <a href="/"><img src="/assets/images/logo-white.png" alt="logo agendaFacil" style="width:75%"></a>
    
    <ul class="w-full  flex flex-col gap-4 font-Poppins">
        <h2 class="border-b-2 border-b-white">Menu</h2>

        <li class="<?php echo $navActive ==='home' ? 'bg-white p-2 rounded text-principal10' : ''?> hover:cursor-pointer flex items-center gap-2"><i class='bx bx-home'></i><a  href="/" class="hover:underline">Home</a></li>
        <li class="<?php echo $navActive ==='Agenda' ? 'bg-white p-2 rounded text-principal10' : ''?> hover:cursor-pointer flex items-center gap-2"><i class='bx bx-calendar'></i><a  href="/schedule/" class="hover:underline">Agenda</a></li>
        <li class="<?php echo $navActive ==='Dados' ? 'bg-white p-2 rounded text-principal10' : ''?> hover:cursor-pointer flex items-center gap-2"><i class='bx bx-data'></i><a href="/data/"  class="hover:underline">Dados usuario</a></li>
        <a href="/login/destroy" class="flex items-center gap-2 hover:cursor-pointer"><i class='bx bx-log-out'></i><span class="hover:underline">Sair</span></a>
    </ul>

</nav>

<?php } ?>