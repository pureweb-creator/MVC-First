<?php
/**
 * Filter class
 *
 * @author Roman S. <roman.semenikhin99@gmail.com>
 * @package Model
 */
namespace models;

/**
 * Filter. Class filters data by specified parameters
 *
 * @author Roman S. <roman.semenikhin99@gmail.com>
 * @package Model
 */
class Filter extends Model
{
    /**
     * Implements filtering products
     *
     * This method gets an array of parameters.
     * Has two required params: order_by and conditions.
     * First one, 'order_by' param sets ordering.
     * It must be an array of values, where first element is column and second is a method of filtering, ASC or DESC.
     *
     * @param array array parameters
     *
     * @return array
     */
    public function filterProducts($array): array
    {
        list($col,$type) = @array_values($array['order_by']);
        $condition = @$array['conditions'];
        $query = ''; // sql query

        $condition = array_filter($condition); // remove empty. For ex. if category_id is equal to false
        if (isset($condition) && !empty($condition)) {
            $keys = array_keys($condition);
            $values = array_values($condition);
            $sql_condition = '';
            $str_values = []; // array with quotation marks for PDO [?,?,?],[?,?,?]
            $exec_array = []; // array with values instead of "?"

            foreach ($values as $val) {
                $str_values[] = str_repeat('?,', count($val) - 1) . '?';
                $exec_array[] = implode(',', $val);
            }

            $exec_array = explode(',', implode(',', $exec_array)); // "1,2,3,4,5..."

            for ($i = 0; $i < count($keys); $i++)
                $sql_condition .= $keys[$i] . ' IN (' . $str_values[$i] . ') AND ';

            // remove last "AND" keyword
            $sql_condition = preg_replace('/\W\w+\s*(\W*)$/', '$1', $sql_condition);

            $query = "SELECT * FROM product WHERE $sql_condition";

            if (isset($array['order_by']) && !empty($array['order_by']))
                $query .= ' ORDER BY ' . $col . ' ' . $type;
        } else
            $query = 'SELECT * FROM product ORDER BY ' . $col . ' ' . $type;

        try {
            if (empty($condition)) {
                $stmt = $this->connect()->query($query);
                return $this->render($stmt);
            }

            $stmt = $this->connect()->prepare($query);
            $stmt->execute($exec_array);

            return $this->render($stmt);
        } catch (\PDOException $e) {
            return [$e->getMessage()];
        }
    }
}