<?php

namespace models;

use core\Model;
use core\Core; 


class AccessoryImage extends Model {

    public static $table = 'accessory_image';

    public function __construct(){
        
    }

    public function save(){
        Core::get()->db->insertWithBlob(self::$table,[
            'accessory_id' => $this->accessory_id[0]->id,
            'image' => $this->image
        ]);
    }

}

?>