<?php

namespace controllers;

use core\Controller;
use core\Template;
use core\Core;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';


class MailingController extends Controller {

    const FILE_PATH = "files/emails.json";

    public function actionAddEmail() {

        if ($this->isPost) {

            $data = json_decode(file_get_contents('php://input'), true);
            $email = htmlspecialchars($data['email']);

            if (file_exists(self::FILE_PATH)) {
                $emails = json_decode(file_get_contents(self::FILE_PATH), true);
                if ($emails === null) {
                    $emails = [];
                }
            } else {
                $emails = [];
            }

            if (!in_array($email, $emails)) {
                $emails[] = $email;
                file_put_contents(self::FILE_PATH, json_encode($emails, JSON_PRETTY_PRINT));
                echo json_encode(['success' => true, 'message' => 'Email додано до списку.']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Email вже існує у списку.']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Невірний запит.']);
        }

        exit;

    }

    public function actionView(){
         
        if (file_exists(self::FILE_PATH)) {
            $emails = json_decode(file_get_contents(self::FILE_PATH), true);
            if ($emails === null) {
                $emails = [];
            }
        } else {
            $emails = [];
        }

        if (file_exists(self::FILE_PATH)) {
            $emails = json_decode(file_get_contents(self::FILE_PATH), true);
            if ($emails === null) {
                $emails = [];
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Список електронних адрес порожній.']);
            exit;
        }
        return $this->render(null,['emails'=>$emails]);

    }

    public function actionSendMessage() {
        if ($this->isPost) {

            $data = json_decode(file_get_contents('php://input'), true);
            $title = htmlspecialchars($data['subject']);
            $description = htmlspecialchars($data['message']);
            
            if (file_exists(self::FILE_PATH)) {
                $emails = json_decode(file_get_contents(self::FILE_PATH), true);
                if ($emails === null) {
                    $emails = [];
                }
            } else {
                echo json_encode(['success' => false, 'message' => 'Список електронних адрес порожній.']);
                exit;
            }
          
          
        $mail = new PHPMailer(true);

        try {

            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'maksesuariv@gmail.com'; 
            $mail->Password = 'yaxq buzw uauv biux';
            $mail->SMTPSecure = 'ssl';
            $mail->Port = 465;
            $mail->CharSet='UTF-8';
            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );   
            $mail->setFrom('maksesuariv@gmail.com', 'Магазин Аксесуарів');

            foreach ($emails as $email) {
                $mail->addAddress($email);
            }

         
            $mail->isHTML(true);
            $mail->Subject = $title;
            $mail->Body = $description;
           
            $mail->send();
            echo json_encode(['success' => true, 'message' => 'Повідомлення надіслано всім користувачам.']);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => "Повідомлення не може бути надіслане. Помилка: {$mail->ErrorInfo}"]);
        }
        } else {
            echo json_encode(['success' => false, 'message' => 'Невірний запит.']);
        }

        exit;
    }


}
?>