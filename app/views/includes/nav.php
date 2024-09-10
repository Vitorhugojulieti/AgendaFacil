<!-- NAV FOR COMPANY -->
<?php  if(isset($_SESSION['collaborator'])){ ?>

    <nav class="lg:flex hidden w-1/5 min-h-full bg-principal10 text-white  flex-col gap-16 p-4 " >
    <ul class="w-full flex flex-col gap-4 font-Poppins">
        <h2 class="border-b-2 border-b-white">Menu</h2>

        <li class="<?php echo $navActive ==='dashboard' ? 'bg-white p-2 rounded text-principal10' : ''?> hover:cursor-pointer flex items-center gap-2"><i class='bx bx-home'></i><a  href="/admin/" class="hover:underline">Dashboard</a></li>
        <li class="<?php echo $navActive ==='Agenda' ? 'bg-white p-2 rounded text-principal10' : ''?> hover:cursor-pointer flex items-center gap-2"><i class='bx bx-calendar'></i><a  href="#" class="hover:underline">Agenda</a></li>
        <li class="<?php echo $navActive ==='servicos' ? 'bg-white p-2 rounded text-principal10' : ''?> hover:cursor-pointer flex items-center gap-2"><i class='bx bx-folder'></i><a href="/admin/service"  class="hover:underline">Serviços</a></li>
        <li class="<?php echo $navActive ==='colaboradores' ? 'bg-white p-2 rounded text-principal10' : ''?> hover:cursor-pointer flex items-center gap-2"><i class='bx bx-user' ></i><a href="/admin/collaborator"  class="hover:underline">Colaboradores</a></li>
        <li class="<?php echo $navActive ==='Relatorios' ? 'bg-white p-2 rounded text-principal10' : ''?> hover:cursor-pointer flex items-center gap-2"><i class='bx bx-bar-chart-square'></i><a href="#"  class="hover:underline">Relatorios</a></li>
        <li class="<?php echo $navActive ==='Cupons' ? 'bg-white p-2 rounded text-principal10' : ''?> hover:cursor-pointer flex items-center gap-2"><i class="fa-solid fa-ticket"></i><a href="#"  class="hover:underline">Cupons</a> <span class="border-2 border-principal5 text-principal5 rounded px-2 text-sm">Pro</span></li>
        <li class="<?php echo $navActive ==='Dados' ? 'bg-white p-2 rounded text-principal10' : ''?> hover:cursor-pointer flex items-center gap-2"><i class='bx bx-data'></i><a href="#"  class="hover:underline">Dados empresa</a></li>
    </ul>

    <div class="btns flex flex-col gap-4">
        <a href="#" class="flex items-center gap-2 hover:cursor-pointer"><i class='bx bx-cog'></i><span class="hover:underline">Configurações</span></a>
        <a href="#" class="flex items-center gap-2 hover:cursor-pointer"><i class='bx bx-log-out'></i><span class="hover:underline">Sair</span></a>
    </div>
</nav>

<nav class="menuMobile w-screen h-screen absolute top-0 right-0 z-10  flex flex-col gap-8 p-4 bg-principal10 text-white" style="display:none;">
    <h2 class="border-b-2 border-b-white">Menu</h2>
    <ul class="w-full flex flex-col gap-4 font-Poppins">
        <li class="hover:cursor-pointer flex items-center gap-2"><i class='bx bx-calendar'></i><a  href="#">Agenda</a></li>
        <li class="hover:cursor-pointer flex items-center gap-2"><i class='bx bx-folder'></i><a href="#" >Serviços</a></li>
        <li class="hover:cursor-pointer flex items-center gap-2"><i class='bx bx-user' ></i><a href="#" >Colaboradores</a></li>
        <li class="hover:cursor-pointer flex items-center gap-2"><i class='bx bx-bar-chart-square'></i><a href="#" >Relatorios</a></li>
        <li class="hover:cursor-pointer flex items-center gap-2"><i class="fa-solid fa-ticket"></i><a href="#" >Vales serviços</a> <span class="border-2 border-principal5 text-principal5 rounded px-2">Pro</span></li>
        <li class="hover:cursor-pointer flex items-center gap-2"><i class='bx bx-data'></i><a href="#" >Dados empresa</a></li>
    </ul>

    <div class="btns flex flex-col gap-4">
        <a href="#" class="flex items-center gap-2"><i class='bx bx-cog'></i><span>Configurações</span></a>
        <a href="/admin/login/destroy" class="flex items-center gap-2"><i class='bx bx-log-out'></i><span>Sair</span></a>
    </div>
</nav>

<!-- NAV FOR USER -->
<?php }else if(isset($_SESSION['user'])){ ?>

<nav class="lg:flex hidden w-1/5 min-h-full bg-principal10 text-white  flex-col gap-16 p-4 " >
    <ul class="w-full flex flex-col gap-4 font-Poppins">
        <h2 class="border-b-2 border-b-white">Menu</h2>

        <li class="<?php echo $navActive ==='home' ? 'bg-white p-2 rounded text-principal10' : ''?> hover:cursor-pointer flex items-center gap-2"><i class='bx bx-home'></i><a  href="/" class="hover:underline">Home</a></li>
        <li class="<?php echo $navActive ==='Agenda' ? 'bg-white p-2 rounded text-principal10' : ''?> hover:cursor-pointer flex items-center gap-2"><i class='bx bx-calendar'></i><a  href="/schedule/" class="hover:underline">Agenda</a></li>
        <li class="<?php echo $navActive ==='Cupons' ? 'bg-white p-2 rounded text-principal10' : ''?> hover:cursor-pointer flex items-center gap-2"><i class="fa-solid fa-ticket"></i><a href="#"  class="hover:underline">Cupons</a> <span class="border-2 border-principal5 text-principal5 rounded px-2 text-sm">Pro</span></li>
        <li class="<?php echo $navActive ==='Dados' ? 'bg-white p-2 rounded text-principal10' : ''?> hover:cursor-pointer flex items-center gap-2"><i class='bx bx-data'></i><a href="/data"  class="hover:underline">Dados usuario</a></li>
    </ul>

    <div class="btns flex flex-col gap-4">
        <a href="#" class="flex items-center gap-2 hover:cursor-pointer"><i class='bx bx-cog'></i><span class="hover:underline">Configurações</span></a>
        <a href="#" class="flex items-center gap-2 hover:cursor-pointer"><i class='bx bx-log-out'></i><span class="hover:underline">Sair</span></a>
    </div>
</nav>

<?php } ?>