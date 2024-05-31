<?php

namespace models;

use core\Model;
use core\Core;  


class Trends extends Model {

    // public $id;
    // public $title;
    // public $text;
    // public $image longblob;
    // public $link string;

    public static $table = 'trends';

    public function __construct(){}


    public static function getAllWithEncodeImage(){
        $items = self::getAll();
        foreach ($items as $item) {
            $item->image = 'data:image/png;base64,' . base64_encode($item->image);   
         }
         return $items;
    }



}


?>