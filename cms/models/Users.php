<?php

namespace models;
use \core\Core;

/**
 * @property int $id,
 * @property string $login,
 * @property string $password,
 * @property string $name
 */
class Users extends \core\Model{

    public static $table = 'users';
    
    public static function fingByLoginAndPassword($login, $password){
        $rows = self::findByCondition(['login'=> $login, 'password' => $password]);
        if(!empty($rows)){
            return $rows[0];
        }else{
            return null;
        }
    } 

    public static function isUserLogged(){
        return !empty(Core::get()->session->get('user'));
    }

    public static function userLogin($user){
        Core::get()->session->set('user', $user);
    }

    public static function userLogout(){
        Core::get()->session->remove('user');
    }


}

?>