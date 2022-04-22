<?php

namespace models;

class Cart extends Model
{
    public function loadCart(array $value): array
    {
        try{
            $query = "SELECT pid FROM cart WHERE uid = ?";
            $statement = $this->connect()->prepare($query);
            $statement->execute($value);

            return $this->render($statement);
        } catch (\PDOException $e){
            return [$e->getMessage()];
        }
    }
}