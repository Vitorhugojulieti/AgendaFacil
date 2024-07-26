<?php
namespace app\controllers\admin;
use app\models\database\Db;
use app\models\Collaborator;
use app\models\Notification;
use app\classes\BlockNotAdmin;
use app\classes\CodeGenerator;

class NotificationController {
    public array $data = [];
    public string $view;
    public string $master = 'masterAdmin.php';

    // ok
    public function index(array $args){
        $db = new Db();
        $db->connect();

        $notifications = new Notification();
        NotificationController::store(1,2,"testando notificações","","test");
        // usar id da empresa para adm? 
        $notifications = $notifications->getAll($db);
        var_dump($notifications);
        die();

        $this->view = 'admin/vouchers.php';
        $this->data = [
            'title'=>'Vales de serviços | AgendaFacil',
            'vouchers'=>$vouchers,
            'navActive'=>'Cupons',
        ];
    }

    public static function store($idRecipient,$idSender,$message,$link,$typeNotification){
        $db = new Db();
        $db->connect();

        $format = 'Y-m-d H:i:s';
        $actualDate = date($format);

        $notification = new Notification(
            $idRecipient,
            $idSender,
            $message,
            $link,
            $typeNotification,
            $actualDate);
        return $notification->insert($db);
    }


    public static function destroy(int $id){
        $db = new Db();
        $db->connect();
        $notification = new Notification();
        return $notification->delete($db,$id);
    }
}
?>