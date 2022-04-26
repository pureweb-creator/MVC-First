<?php

namespace models;

class Cart extends Model
{
    public function loadCart(array $value)
    {
        try{
            $query = "SELECT pid FROM cart WHERE uid = ?";
            $statement = $this->connect()->prepare($query);
            $statement->execute($value);

            return $this->render($statement);
        } catch (\PDOException $e){
            return false;
        }
    }
}