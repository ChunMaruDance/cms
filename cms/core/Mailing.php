<?php

namespace core;
use core\Core;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

class Mailing {

    private $mailingModel;

    public function __construct(){
        $this->mailingModel = new PHPMailer(true);

        $this->mailingModel->isSMTP();
        $this->mailingModel->Host = Config::get()->SMTP_HOST;
        $this->mailingModel->SMTPAuth = Config::get()->SMTP_AUTH;
        $this->mailingModel->Username = Config::get()->SMTP_USERNAME;
        $this->mailingModel->Password = Config::get()->SMTP_PASSWORD;
        $this->mailingModel->SMTPSecure = Config::get()->SMTP_SECURE;
        $this->mailingModel->Port = Config::get()->SMTP_PORT;
        $this->mailingModel->CharSet = Config::get()->SMTP_CHARSET;
        $this->mailingModel->SMTPOptions =  array(
            Config::get()->SMTP_SECURE => array(
                'verify_peer' => Config::get()->VERIFY_PEER,
                'verify_peer_name' => Config::get()->VERIFY_PEER_NAME,
                'allow_self_signed' => Config::get()->ALLOW_SELF_SIGNED
            )
        );   
        $this->mailingModel->isHTML(true);

        $this->mailingModel->setFrom(Config::get()->SMTP_FROM_EMAIL, Config::get()->SMTP_FROM_NAME);
    }

    public function sendMessage($subject, $message, $emails) {
        try {
            foreach ($emails as $email) {
                $this->mailingModel->addAddress($email);
            }
            
            $this->mailingModel->Subject = $subject;
            $this->mailingModel->Body = $message;

            $this->mailingModel->send();

            return true; 
        } catch (Exception $e) {
            var_dump($e);
            return false;
        }
    }


    function generateOrderMessage($orderNumber, $totalAmount) {
        return '
        <html>
        <head>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    line-height: 1.6;
                    color: #333;
                }
                h1 {
                    color: #ff6600;
                }
                p {
                    margin-bottom: 20px;
                }
                .order-info {
                    background-color: #f9f9f9;
                    padding: 20px;
                    border-radius: 5px;
                }
                .thank-you {
                    font-style: italic;
                }
            </style>
        </head>
        <body>
            <h1>Замовлення успішно відправлено!</h1>
            <div class="order-info">
                <p>Ваше замовлення №' . $orderNumber . ' на суму: ' . $totalAmount . '$ було успішно відправлено!!!</p>
                <p>У разі труднощів опрацювання вашого замовлення, ми зв\'яжемось з вами.</p>
            </div>
            <p class="thank-you">Дякуємо за покупку.</p>
        </body>
        </html>
        ';
    }



}


?>