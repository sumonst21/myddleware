<?php

namespace App\Service;

use Exception;
use Swift_Mailer;

class Mailer {

    /**
     * @var Swift_Mailer
     */
    private $mailer;


    private $transport;

    public function __construct(Swift_Mailer $mailer, $transport)
    {
        $this-> transport = $transport;
        $this->mailer = new Swift_Mailer($this->transport);
    }

    


    public function sendMail(array $data)
    {
        try {
            $message = $data['message'] ;
            $mail = $this->mailer->send($message);
            return $mail;
        } catch (Exception $e) {
            var_dump($e->getMessage().' '.$e->getFile().' '.$e->getLine());
            $this->logger->error($e->getMessage().' '.$e->getFile().' '.$e->getLine());
            return "Message could not be sent. PHP Error : {$e->getMessage()} line {$e->getLine()} at {$e->getFile()}";
        }
    }
}