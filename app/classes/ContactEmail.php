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
}

?>