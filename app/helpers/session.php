<?php
use app\classes\Flash;
use app\models\database\Db;
use app\models\Notification;

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

function setCompanyNotifications(){
        $db = new Db();
        $db = $db->connect();

        $notifications = new Notification();
        $notifications = $notifications->getByCompany($db,$_SESSION['collaborator']->getIdCompany());
        $_SESSION['notifications'] = $notifications;
}
function getCompanysNotifications() {
    // setCompanyNotifications();
    $html = ''; 

    if (isset($_SESSION['notifications']) && count($_SESSION['notifications']) > 0) {
            $unmarkedNotifications = 0;
        foreach ($_SESSION['notifications'] as $notification) { 
            if($notification->getNotified() === 0){
                $unmarkedNotifications += 1;
            }
            $_SESSION['unmarkedNotifications'] = $unmarkedNotifications;

            $now = new DateTime(); 
            $interval = $now->diff($notification->getDate());

            // Usando o operador de concatenação correto "."
            $html .= '<div class="w-full ' . ($notification->getNotified() === 0 ? 'bg-grayNotification' : 'bg-white') . ' flex gap-4 items-center p-2 border-b border-b-grayInput">
                        <div class="circle-notification">
                            <i class="bx bxs-message text-2xl" style="color:#ffff"></i>
                        </div>
                        <div class="bodyNotification flex flex-col items-start gap-1">
                            <span class="text-base text-black font-semibold font-Urbanist">' . $notification->getMessage() . '</span>
                            <span class="text-sm">' . 'Há ' . $interval->i . ' minutos' . '</span>
                            <a href="' . $notification->getLink() . '" class="text-sm hover:underline">Ver detalhes</a>
                        </div>
                    </div>';
        }
    } else {
        // Se não houver notificações, exibe uma mensagem informando
        $html .= '<div class="w-full text-grayInput flex flex-col gap-2 items-center justify-center p-12">
                    <i class="bx bxs-info-circle text-4xl"></i>
                    <span class="font-Urbanist font-semibold text-xl">Você não tem notificações!</span>
                  </div>';
    }

    return $html;
}


