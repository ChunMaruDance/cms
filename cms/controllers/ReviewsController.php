<?php
namespace controllers;

use core\Controller;
use core\Template;
use core\Core;

//models
use models\Accessory;
use models\Feedback;

//validators
use utils\FeedbackValidator; 


class ReviewsController extends Controller {

    public function actionSubmitFeedback(){

        $errors = FeedbackValidator::validateFields($this->post);
        if (!empty($errors)) {
            $this->setErrorMessage($errors);
            
            return $this->render('views/reviews/contact.php');
        }

        $feedBack = new Feedback();
        $feedBack->name = $this->post->name;
        $feedBack->email = $this->post->email;
        $feedBack->message = $this->post->message;
        $feedBack->created_at = date('Y-m-d H:i:s');

        $feedBack->save();

        return $this->redirect('/');
    }

    public function actionContact(){

        return $this->render();
    }

    public function actionView(){

        $this->checkIsUserLoggin();

        $reviews = Feedback::getAll();

        return $this->render(null,['reviews' =>$reviews]);
    }

}

?>