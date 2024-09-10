    <?php
use app\classes\Flash;

function welcome($index){
    if (isset($_SESSION[$index])) {
        $user = $_SESSION[$index];

        return $user->firstName.' '.$user->lastName . '| <a href="/login/destroy">Logout</a>';
    }

    return 'Visitante';
}

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


?>