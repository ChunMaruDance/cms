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

    protected function where($where){
        if(is_array($where)){
            $where_string = "WHERE ";
            $where_fields = array_keys($where);

            $parts = [];
            foreach($where_fields as $field){
                $parts [] = "{$field} = :{$field}";
            }
            $where_string .= implode(' AND ',$parts);
        }else{

            if(is_string($where)){
                $where_string = $where;
            }else{
                $where_string = '';
            }
        }   
        return $where_string;
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
            }
            $where_string  .= implode(' AND ', $parts);
    
        }else{
            if(is_string($where)){
                $where_string = $where;
            }else{
                $where_string = ' ';
            }
        }
      

        $sql = "SELECT {$field_string} FROM {$table} {$join_string} {$where_string}";
       
        $sth = $this->pdo->prepare($sql);
        if($where != null){
            foreach($where as $key => $value){

                if(!empty($joins)){
                    $parts  = explode('.', $field);
                    $val = end($parts);
                    $sth->bindValue(":{$val}",$value);
                }else{
                    $sth->bindValue(":{$key}",$value);
                }
               
            }
        }
        
        $sth->execute();
     
        return $sth->fetchAll();
    
    }


    public function insert($table, $row_to_insert){

        $fields_list = implode(", ",array_keys($row_to_insert));
        $params_array = [];

        foreach($row_to_insert as $key => $value){
            $params_array [] = ":{$key}";

        }
        $params_list = implode(", ",  $params_array);


        $sql = "INSERT INTO {$table} ($fields_list) VALUES ($params_list)";

        $sth = $this->pdo->prepare($sql);
        
        foreach($row_to_insert as $key => $value){
            $sth->bindValue(":{$key}",$value);
        }
          
        $sth->execute();

        return $sth->rowCount();
    }

    public function delete($table, $where){

        $where_string = $this->where($where);
        $sql = "DELETE FROM {$table} {$where_string}";
        $sth = $this->pdo->prepare($sql);

        foreach($where as $key => $value){
            $sth->bindValue(":{$key}",$value);
        }
          
        $sth->execute();

        return $sth->rowCount();
        

    }

    public function update($table, $row_to_update, $where){
        
        $where_string = $this->where($where);
        $set_array = [];
        foreach($row_to_update as $key => $value){
            $set_array [] = "{$key} = :{$key}";
        }

        $set_string  = implode(", ",$set_array);

        $sql = "UPDATE {$table} SET {$set_string} {$where_string}";
        $sth = $this->pdo->prepare($sql);
        foreach($where as $key => $value){
            $sth->bindValue(":{$key}",$value);
        }
        foreach($row_to_update as $key => $value){
            $sth->bindValue(":{$key}",$value);
        }
        $sth->execute();
        return $sth->rowCount();

    }




}



?>