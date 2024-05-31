<?php
namespace controllers;

use core\Controller;
use core\Template;
use core\Core;
use models\Accessory;

use models\MainBanner;  
use utils\BannerItemValidator;

class MainPageController extends Controller{


    public function actionRenderBanner(){
        
        $this->checkIsUserLoggin();
        $bannerItems = MainBanner::getAllWithEncodeImage();
        return $this->render(null,['bannerItems' => $bannerItems]);
    }


    public function actionRenderTrends(){
        
        $this->checkIsUserLoggin();
        
        $bannerItems = MainBanner::getAllWithEncodeImage();
        return $this->render(null,['bannerItems' => $bannerItems]);
    }


    renderTrends


    public function actionDeleteBannerItem($params){

        $this->checkIsUserLoggin();
 
        MainBanner::deleteById($params[0]);
 
        return $this->redirect('/mainPage/renderBanner');
    } 





    public function actionCreateBannerItem(){

        $this->checkIsUserLoggin();

        $errors = BannerItemValidator::validateFields($this->post,$_FILES);
       
        if (!empty($errors)) {
            $this->setErrorMessage(implode('<br>', $errors));
            $bannerItems = MainBanner::getAllWithEncodeImage();

            return $this->render('views/mainPage/renderBanner.php', [
                // 'errors' => $errors,
                'bannerItems' => $bannerItems
            ]);
        }

        // model
        $bannerItem = new MainBanner();
        $bannerItem->link = $this->post->link;
        $bannerItem->image = file_get_contents($_FILES['image']['tmp_name']);

        $bannerItem->save();
        
        return $this->redirect('/mainPage/renderBanner');
            

    } 


}

?>