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

    public function index(array $args){
        $db = new Db();
        $db->connect();
        $notifications = new Notification();
        $notifications = $notifications->getByCompany($db,$_SESSION['collaborator']->getIdCompany());

        $this->view = 'admin/notifications.php';
        $this->data = [
            'title'=>'Notificações | AgendaFacil',
            'notifications'=>$notifications
        ];
    }

    public static function store($idSender,$message,$link,$actualDate,$idCompanyRecipient,$idUserRecipient){
        $db = new Db();
        $db->connect();

        // $format = 'Y-m-d H:i:s';
        // $actualDate = date($format);

        $notification = new Notification(
            $idSender,
            $message,
            $link,
            $actualDate,
            0,
            $idCompanyRecipient,
            $idUserRecipient,
            );
        return $notification->insert($db);
    }

    public function markNotified($idNotification){
        $db = new Db();
        $db->connect();
        
        $notification = new Notification();
        $notification->setNotified(1);
        if($notification->update($db,$idNotification)){
            return redirect('/admin/');
        }
    }

    public function markAllNotified($idCompany){
        $db = new Db();
        $db->connect();

        if($db->update("idCompanyRecipient={$idCompany}","notified=1")){
            return redirect('/admin/');
        }
    }


    public  function destroy(int $id){
        $db = new Db();
        $db->connect();
        $notification = new Notification();
        if($notification->delete($db,$id)){
            return redirect('/admin/');
        }
    }
}
?>