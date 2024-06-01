<?php
namespace controllers;

use core\Controller;
use core\Template;
use core\Core;
use models\Accessory;

use models\MainBanner;  
use models\Trends;

use utils\BannerItemValidator;
use utils\TrendItemValidator;

class MainPageController extends Controller{


    public function actionRenderBanner(){
        
        $this->checkIsUserLoggin();
        $bannerItems = MainBanner::getAllWithEncodeImage();
        return $this->render(null,['bannerItems' => $bannerItems]);
    }


    public function actionRenderTrends(){
        
        $this->checkIsUserLoggin();

        $trendsItems = Trends::getAllWithEncodeImage();
        return $this->render(null,['trendsItems' => $trendsItems]);
    }

    public function actionDeleteBannerItem($params){

        $this->checkIsUserLoggin();
 
        MainBanner::deleteById($params[0]);
 
        return $this->redirect('/mainPage/renderBanner');
    } 

    public function actionDeleteTrendsItem($params){

        $this->checkIsUserLoggin();
 
        Trends::deleteById($params[0]);
 
        return $this->redirect('/mainPage/renderTrends');
    } 

    public function actionToggleFeature(){

        $configFile = 'files/mainPageConfig.json';
       
        $config = json_decode(file_get_contents($configFile), true);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $input = json_decode(file_get_contents('php://input'), true);
          
            $config[$input['feature']] = $input['isEnabled'];
        
            file_put_contents($configFile, json_encode($config));
        
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
        }
        exit;

    }

    public function actionCreateTrendItem(){

        $this->checkIsUserLoggin();

        $errors = TrendItemValidator::validateFields($this->post,$_FILES);
       
        if (!empty($errors)) {
            $this->setErrorMessage(implode('<br>', $errors));
            $trendsItems = Trends::getAllWithEncodeImage();

            return $this->render('views/mainPage/renderTrends.php', [
                'trendsItems' => $trendsItems
            ]);
        }

        // model
        $trendsItem = new Trends();
        $trendsItem->link = $this->post->link;
        $trendsItem->image = file_get_contents($_FILES['image']['tmp_name']);
        $trendsItem->title = $this->post->title;
        $trendsItem->text = $this->post->text;
        
        $trendsItem->save();
        
        return $this->redirect('/mainPage/renderTrends');
            

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