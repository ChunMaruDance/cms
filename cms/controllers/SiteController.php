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
        $cacheTime = 3600;

        $config = $this->loadConfig();

        if (file_exists($cacheFile) && (time() - filemtime($cacheFile) < $cacheTime)) {
            $cachedData = json_decode(file_get_contents($cacheFile), true);
            $categories_arrays = $cachedData['categories'];
            $bannerItems_arrays = $cachedData['bannerItems'];
            $trendsItems_arrays = $cachedData['trendsItems'];

        } else {

            $categories_arrays = $this->convertObjectsToArray(Categories::getAllWithEncodeImage());
            $bannerItems_arrays = $this->convertObjectsToArray(MainBanner::getAllWithEncodeImage());
            $trendsItems_arrays = $this->convertObjectsToArray(Trends::getAllWithEncodeImage());

            $cacheData = [
                'categories' => $categories_arrays,
                'bannerItems' => $bannerItems_arrays,
                'trendsItems' => $trendsItems_arrays,
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


    private function loadConfig()
    {
        $configFile = 'files/mainPageConfig.json';
        return json_decode(file_get_contents($configFile), true);
    }

    private function convertObjectsToArray($objects)
    {
        return array_map(function ($object) {
            return json_decode(json_encode($object), true);
        }, $objects);
    }


}
?>
