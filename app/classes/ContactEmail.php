<?php

namespace app\classes;

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

    public static function sendConfirmationEmail(String $name,String $email){
        $name = $_SESSION['nameSend'] ? $_SESSION['nameSend'] : $name;
        $email = $_SESSION['emailSend'] ? $_SESSION['emailSend'] : $email;
         //generate code confirm
         $code = CodeValidate::generate();
         $_SESSION['emailSend'] = $email;
         $_SESSION['nameSend'] = $name;
 
          //message for email
          $message= "
          <div>
              <h1>Bem vindo ao Agenda Facil!</h1>
              <h2>Confirme seu E-mail</h2>
              <p>Codigo para confirmacaoo: {$code}</p>
          </div>";
                 
         //send email
         try {
             $contactEmail = new ContactEmail();
             $contactEmail->setTo(["email"=>$email,"name"=>$name]);
             $contactEmail->setFrom(["email"=>"vitorhugo6331@outlook.com","name"=>"vitor"]);
             $contactEmail->setSubject("Confirmar E-mail");
             $contactEmail->setMessage($message);
             $contactEmail->send();
             return true;
             unset($_SESSION['nameSend']);
             unset($_SESSION['emailSend']);
 
         } catch (\Throwable $th) {
            return false;
         }
    }
}

?>