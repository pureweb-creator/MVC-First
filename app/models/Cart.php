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

    public function getQuantity(int $uid)
    {
        try{
            $query_count = "SELECT count FROM cart WHERE uid = ?";
            $statement_count = $this->connect()->prepare($query_count);
            $statement_count->execute([$uid]);

            return $this->render($statement_count);
        } catch (\PDOException $e){
            return false;
        }
    }
}