<?php

namespace controllers;

use core\Controller;
use core\Template;
use core\Core;

class MailingController extends Controller {

    public function actionAddEmail() {

        if ($this->isPost) {

            $data = json_decode(file_get_contents('php://input'), true);
            $email = htmlspecialchars($data['email']);

            $filePath = "files/emails.json";
            if (file_exists($filePath)) {
                $emails = json_decode(file_get_contents($filePath), true);
                if ($emails === null) {
                    $emails = [];
                }
            } else {
                $emails = [];
            }

            if (!in_array($email, $emails)) {
                $emails[] = $email;
                file_put_contents($filePath, json_encode($emails, JSON_PRETTY_PRINT));
                echo json_encode(['success' => true, 'message' => 'Email додано до списку.']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Email вже існує у списку.']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Невірний запит.']);
        }

        exit;


    }
}
?>
