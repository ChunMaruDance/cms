<?php
namespace controllers;

use core\Controller;
use core\Template;

// Models
use models\Categories;
use models\MainBanner;
use models\Trends;

class SiteController extends Controller
{
    public function actionIndex()
    {   
        $cacheFile = 'cache/index_cache.json';
        $cacheTime = 3600; // 1 година

        
        $configFile = 'files/mainPageConfig.json';
        $config = json_decode(file_get_contents($configFile), true);


        if (file_exists($cacheFile) && (time() - filemtime($cacheFile) < $cacheTime)) {
            $cachedData = json_decode(file_get_contents($cacheFile), true);
            $categories_arrays = $cachedData['categories'];
            $bannerItems_arrays = $cachedData['bannerItems'];
            $trendsItems_arrays = $cachedData['trendsItems'];

        } else {
            $categories = Categories::getAllWithEncodeImage();
            $bannerItems = MainBanner::getAllWithEncodeImage();
            $trendsItems = Trends::getAllWithEncodeImage();

            $categories_arrays = array_map(function ($category) {
                return json_decode(json_encode($category), true);
            }, $categories);

            $bannerItems_arrays = array_map(function ($category) {
                return json_decode(json_encode($category), true);
            }, $bannerItems);

            $trendsItems_arrays = array_map(function ($category) {
                return json_decode(json_encode($category), true);
            }, $trendsItems);

            $cacheData = [
                'categories' => $categories,
                'bannerItems' => $bannerItems,
                'trendsItems' => $trendsItems,
            ];
            file_put_contents($cacheFile, json_encode($cacheData));
        }


        return $this->render(null, [
            'categories' => $categories_arrays,
            'bannerItems' => $bannerItems_arrays,
            'trendsItems' => $trendsItems_arrays,
            'config' => $config
        ]);
    }
}
?>
