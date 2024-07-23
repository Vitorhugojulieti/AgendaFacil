<!-- HEADER FOR COMPANY -->
<?php if(isset($_SESSION['collaborator'])){ ?>
<header class="flex flex-col  gap-4 p-4 border-b-2 border-lightGray">
    <div class="w-full flex justify-between items-center">
        <a href="#"><img src="/assets/images/logo.png" alt="logo agendaFacil"></a>

        <div class="search w-2/4 flex border-lightGray border-2 rounded">
            <input type="text" class="w-full ml-2 outline-none" placeholder="Faça sua pesquisa">
            <i class='bx bx-search p-2 border-l-2 border-l-lightGray text-lightGray'></i>
        </div>

        <div class="buttons flex items-center gap-6">
            <button class="flex items-center gap-2">
                <i class='bx bx-bell' ></i>
                <span>Notificações</span>
                <span>1</span>
            </button>

            <div class="avatar-user relative">
                <!-- <img src="" alt=""> -->
                <img id="btnOpenPopUpAvatar" src="<?php echo isset($_SESSION['collaborator']) ? '../'.$_SESSION['collaborator']->getAvatar() : '/assets/images/avatar_default.png';?>" alt="" class="redondShapeImageCollaborator">

                <div id="popUpAvatar" class="hidden flex-col items-start bg-white  rounded-xl pop-menu shadow-sm shadow-black ">
                    <a href="" class="flex items-center gap-1 p-2 border-b-2 border-lightGray hover:bg-lightGray"><i class='bx bx-cog' style='color:#223249'  ></i>Configurações</a>
                    <a href="/admin/login/destroy" class="p-2 flex items-center gap-1 hover:bg-lightGray" ><i class='bx bx-log-out' style='color:#223249' ></i>Logout</a>
                </div>
            </div>
        </div>
    </div>


    <script type="module" src="/assets/js/header.js" deffer></script>
</header>

<!-- HEADER FOR USER -->
<?php    }else if(isset($_SESSION['user'])){ ?>

<header class="flex flex-col  gap-4 p-4 border-b-2 border-lightGray">
    <div class="w-full flex justify-between items-center">
        <a href="#"><img src="/assets/images/logo.png" alt="logo agendaFacil"></a>

        <div class="search w-2/4 flex border-lightGray border-2 rounded">
            <input type="text" class="w-full ml-2 outline-none" placeholder="Faça sua pesquisa">
            <i class='bx bx-search p-2 border-l-2 border-l-lightGray text-lightGray'></i>
        </div>

        <div class="buttons flex items-center gap-6">
            <button class="flex items-center gap-2">
                <i class='bx bx-bell' ></i>
                <span>Notificações</span>
                <span>1</span>
            </button>

            <div class="avatar-user relative">
                <!-- <img src="" alt=""> -->
                <img id="btnOpenPopUpAvatar" src="<?php echo isset($_SESSION['user']) ? $_SESSION['user']->getAvatar() : '/assets/images/avatar_default.png';?>" alt="" class="redondShapeImageCollaborator">

                <div id="popUpAvatar" class="hidden flex-col items-start bg-white  rounded-xl pop-menu shadow-sm shadow-black ">
                    <a href="" class="flex items-center gap-1 p-2 border-b-2 border-lightGray hover:bg-lightGray"><i class='bx bx-cog' style='color:#223249'  ></i>Configurações</a>
                    <a href="/login/destroy" class="p-2 flex items-center gap-1 hover:bg-lightGray" ><i class='bx bx-log-out' style='color:#223249' ></i>Logout</a>
                </div>
            </div>
        </div>
    </div>

    <div class="w-full flex items-center justify-between mt-2">
        <div class="location w-2/4 flex gap-1 items-center justify-start ">
            <i class='bx bxs-map text-principal10'></i>
            <span>Birigui-sp</span>
        </div>

        <nav class="w-full">
            <ul class="flex items-center gap-4">
                <li class="bg-principal10 px-2 py-1 rounded text-white font-normal text-sm hover:cursor-pointer hover:underline">Categoria1</li>
                <li class="font-normal text-sm hover:cursor-pointer hover:underline">Categoria1</li>
                <li class="font-normal text-sm hover:cursor-pointer hover:underline">Categoria1</li>
                <li class="font-normal text-sm hover:cursor-pointer hover:underline">Categoria1</li>
            </ul>
        </nav>
    </div>
    <script type="module" src="/assets/js/header.js" deffer></script>
</header>
<?php    } ?>
