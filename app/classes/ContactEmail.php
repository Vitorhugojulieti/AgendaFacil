<?php

namespace app\classes;
use app\classes\CodeGenerator;

class ContactEmail extends Email{
    public function send(){
        $this->config();

        $this->mailer->setFrom($this->from['email'], $this->from['name']);
        $this->mailer->addAddress($this->to['email'], $this->to['name']);

        $this->mailer->isHTML(true);                               
        $this->mailer->Subject = $this->subject;
        $this->mailer->Body    = $this->message;
        $this->mailer->AltBody = 'This is the body in plain text for non-HTML dsdail clients';

        $send = $this->mailer->send();

        if(!$send){
            throw new Exception($this->mailer->ErrorInfo);
        }
    }

    //TODO enviar email para agendamento
    public static function sendConfirmationEmail(String $name,String $email){
         
         try {
            $contactEmail = new ContactEmail();
            $contactEmail->setTo(["email"=>$email,"name"=>$name]);
            $contactEmail->setFrom(["email"=>"vitorhugojulieti@gmail.com","name"=>"vitor hugo"]);
            $contactEmail->setSubject("Confirmar E-mail");

            $code = CodeGenerator::generate(4);
            $_SESSION['codeConfirmEmail'] = $code;
    
            $template = file_get_contents(__DIR__ .'../../views/templateEmail.html');
                
            $message = str_replace('{{name}}', $name, $template);
            $message = str_replace('{{code}}', $code, $message);

            $contactEmail->setMessage($message);
            $contactEmail->send();
            return true;
 
         } catch (\Throwable $th) {
            return false;
         }
    }

    public static function sendScheduleEmail(String $adminCompany,String $email){
         
        try {
           $contactEmail = new ContactEmail();
           $contactEmail->setTo(["email"=>$email,"name"=>$name]);
           $contactEmail->setFrom(["email"=>"vitorhugojulieti@gmail.com","name"=>"vitor hugo"]);
           $contactEmail->setSubject("Confirmar E-mail");

           $code = CodeGenerator::generate(4);
           $_SESSION['codeConfirmEmail'] = $code;
   
           $template = file_get_contents(__DIR__ .'../../views/templateEmail.html');
               
           $message = str_replace('{{name}}', $name, $template);
           $message = str_replace('{{code}}', $code, $message);

           $contactEmail->setMessage($message);
           $contactEmail->send();
           return true;

        } catch (\Throwable $th) {
           return false;
        }
   }
}

?>