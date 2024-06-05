<?php

namespace controllers;

use core\Controller;
use core\Template;
use core\Core;

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

            if(Core::get()->mailing->sendMessage($title,$description,$emails)){
                echo json_encode(['success' => true, 'message' => 'Повідомлення надіслано всім користувачам.']);
            }else{
                echo json_encode(['success' => false, 'message' => "Повідомлення не може бути надіслане. Помилка: {$mail->ErrorInfo}"]);
            }  
       
        } else {
            echo json_encode(['success' => false, 'message' => 'Невірний запит.']);
        }

        exit;
    }


}
?>