<?php

namespace controllers;

use core\Controller;
use core\Template;
use core\Core;

use models\Orders;

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

        $ordersEmails = Orders::getAllEmails();
        return $this->render(null,['emails_subscribers'=>$emails,'emails_orders'=>$ordersEmails]);

    }

    public function actionSendMessage() {
        if ($this->isPost) {
            $data = json_decode(file_get_contents('php://input'), true);
            $title = htmlspecialchars($data['subject']);
            $description = htmlspecialchars($data['message']);
            $email = isset($data['email']) ? htmlspecialchars($data['email']) : null;
            
            if (empty(trim($email))) {
                $email = null;
            }
            
            if ($email !== null) {
                $this->sendToSingleEmail($title, $description, $email);
            } else {
                $this->sendToAllUsers($title, $description);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Невірний запит.']);
        }
    
        exit;
    }
    
    private function sendToSingleEmail($title, $description, $email) {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo json_encode(['success' => false, 'message' => 'Недійсна електронна адреса.']);
            exit;
        }
    
        if(Core::get()->mailing->sendMessage($title, $description, [$email])){
            echo json_encode(['success' => true, 'message' => 'Повідомлення надіслано на вказану адресу.']);
        }else{
            echo json_encode(['success' => false, 'message' => "Повідомлення не може бути надіслане. Помилка: {$mail->ErrorInfo}"]);
        }
    }
    
    private function sendToAllUsers($title, $description) {
        $emails = $this->getEmailList();
        if($emails === null) {
            echo json_encode(['success' => false, 'message' => 'Список електронних адрес порожній.']);
            exit;
        }
    
        if(Core::get()->mailing->sendMessage($title, $description, $emails)){
            echo json_encode(['success' => true, 'message' => 'Повідомлення надіслано всім користувачам.']);
        }else{
            echo json_encode(['success' => false, 'message' => "Повідомлення не може бути надіслане. Помилка: {$mail->ErrorInfo}"]);
        }  
    }
    
    private function getEmailList() {
        if (file_exists(self::FILE_PATH)) {
            $emails = json_decode(file_get_contents(self::FILE_PATH), true);
            if ($emails === null) {
                $emails = [];
            }
            return $emails;
        } else {
            return null;
        }
    }


}
?>