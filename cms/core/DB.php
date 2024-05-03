<?php

namespace core;

class DB{

    public $pdo;

    public function __construct($host, $name, $login, $pass){
        
        $this->pdo = new \PDO("mysql:host={$host};dbname={$name}",
        $login, $pass,[
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_OBJ
        ]);
     
    }

    public function select($table, $fields = '*', $joins = [], $where = null) {

        if (is_array($fields)) {
            $field_string = implode(', ', $fields);
        } else {
            $field_string = $fields;
        }

        $join_string = '';
        foreach ($joins as $join) {
            $join_string .= " " . $join;
        }
        if(is_array($where)){
            $where_string = "WHERE ";
            $where_fields = array_keys($where);
           
    
            $parts = [];
    
            foreach($where_fields as $field){
                
                $part  = explode('.', $field);
                $val = end($part);

                $parts [] = "{$field} = :{$val}";
                $where_string  .= implode(' AND ', $parts);
            }
    
        }else{
            if(is_string($where)){
                $where_string = $where;
            }else{
                $where_string = ' ';
            }
        }
      

        $sql = "SELECT {$field_string} FROM {$table} {$join_string} {$where_string}";
       
        $sth = $this->pdo->prepare($sql);
        
    
       
        foreach($where as $key=> $value){

            $parts  = explode('.', $field);
            $val = end($parts);

            $sth->bindValue(":{$val}",$value);

        }
          
        $sth->execute();
        return $sth->fetchAll();
    
    }




}



?>