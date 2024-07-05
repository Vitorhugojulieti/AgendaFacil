<?php
namespace app\classes;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

abstract class Email {
    protected PHPMailer $mailer;
    protected array $from;
    protected array $to;
    protected string $subject;
    protected string $message;


   abstract public function send();

    public function setTo(array $to){
        if(!array_key_exists('name',$to) || !array_key_exists('email',$to)){
            throw new Exception("As propriedades name e email são obrigatorias!");
        }

        $this->to = $to;
    }

    public function setFrom(array $from){
        if(!array_key_exists('name',$from) || !array_key_exists('email',$from)){
            throw new Exception("As propriedades name e email são obrigatorias!");
        }
        $this->from = $from;
    }

    public function setSubject(string $subject){
        $this->subject = $subject;
    }

    public function setMessage(string $message){
        $this->message = $message;
    }
                                  
    protected function config(){
        // $this->mailer->SMTPDebug = SMTP::DEBUG_SERVER;     
        $this->mailer = new PHPMailer();
        $this->mailer->isSMTP();                                            
        $this->mailer->Host       = $_ENV['EMAIL_HOST'];                     
        $this->mailer->SMTPAuth   = true;                                  
        $this->mailer->Username   = $_ENV['EMAIL_USERNAME'];                    
        $this->mailer->Password   = $_ENV['EMAIL_PASSWORD'];                               
        // $this->mailer->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            
        $this->mailer->Port = $_ENV['EMAIL_PORT'];  
    }
}

?>