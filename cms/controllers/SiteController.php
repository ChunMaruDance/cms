<?php
namespace controllers;

use core\Controller;
use core\Template;

class SiteController extends Controller
{
    public function actionIndex()
    {
        return [
            'Content' =>$this->template->getHTML(),
            'Title' =>'Main Page'
           ];
    }
}

?>