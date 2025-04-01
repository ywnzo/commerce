<?php

class DB {
    static function query($sql) {
        global $conn;
        try {
            $sql = $conn->prepare($sql);
            $sql->execute();
            $result = $sql->fetchAll(PDO::FETCH_ASSOC);

            if(is_array($result) && count($result) > 1 || !is_array($result)) {
                return $result;
            }
            if(is_array($result) && count($result) == 1) {
                return $result[0];
            }
        } catch(PDOException $e) {
            echo 'Error occured: ' . $e->getMessage();
            return false;
        }
    }

    public static function select($columns, $table, $params) {
        $sql = "SELECT $columns FROM $table WHERE $params";
        return self::query($sql);
    }

    public static function update($table, $values, $params) {
        $sql = "UPDATE $table SET $values WHERE $params";
        return self::query($sql);
    }

    public static function delete($table, $params) {
        $sql = "DELETE FROM $table WHERE $params";
        return self::query($sql);
    }

    public static function insert($table, $columns) {
        $properties = '';
        $values = '';
        foreach($columns as $property => $value) {
            $properties .= $property;
            $values .= "'" . $value . "'";
            if(array_key_last($columns) != $property) {
                $properties .= ', ';
                $values .= ', ';
            }
        }

        $sql = "INSERT INTO $table ($properties) VALUES ($values)";
        try {
            $result = self::query($sql);
        } catch(PDOException $e) {
            echo 'Error occured: ' . $e->getMessage();
            return false;
        }
        return $result;
    }
}

?>
