<?php
use app\classes\Flash;


function verifySession(){
    // Verifica se a sessão está inativa
    if(isset($_SESSION['lastAcess'])){
        $downtime = 1800; // 30 minutos
        if(time() - $_SESSION['lastAcess'] > $downtime) {
            // session_unset();
            // session_destroy();
            unset($_SESSION['user']);
            unset($_SESSION['auth']);
            unset($_SESSION['lastAcess']);
            Flash::set('session_expired', 'Sua sessão expirou, por favor faça login novamente!',"w-full bg-errorColor text-white p-4  border-l-8 border-l-red");
            redirect('/login');
        }
    }
    $_SESSION['lastAcess'] = time();
}

function setCompanyActive($active){
    $_SESSION['activeCompany'] = $active;
}

function getCompanyActive(){
    if(isset($_SESSION['activeCompany'])){
        if($_SESSION['activeCompany']  == 1){
            return '<span class="bg-sucessColor text-white text-sm text-center w-32 rounded p-1 flex gap-2 items-center"><i class="bx bxs-circle"></i>Empresa ativa</span>';
        }else{
            return '<span class="bg-errorColor text-white text-sm text-center w-32 rounded p-1 flex gap-2 items-center"><i class="bx bxs-circle" ></i>Empresa inativa</span>';
        }
    }
}

?>