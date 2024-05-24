<?php

namespace models;

use core\Model;
use core\Core;  

class MainBanner extends Model {

    // public $id;
    // public $link;
    // public $image;

    public static $table = 'main_banner';

    public function __construct(){}

    public function getAllWithEncodeImage(){
        $bannerItems = self::getAll();
        foreach ($bannerItems as $item) {
            $item->image = 'data:image/png;base64,' . base64_encode($item->image);   
         }
         return $bannerItems;
    }


}

?>