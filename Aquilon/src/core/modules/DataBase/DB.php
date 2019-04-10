<?php

/**
 * Class DB
 */
class DB
{

    /**
     * @var null
     */
    private static $pdo = null;

    /**
     * @return null|PDO
     */
    public function getConnection()
    {
        if (!self::$pdo) {
            $dsn = 'mysql:host='. MYSQL_HOST .';port='. MYSQL_PORT .';dbname='. DB_NAME . ';charset=utf8';
            $options = array(
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'",
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_EMULATE_PREPARES => false
            );
            try {
                self::$pdo = new PDO($dsn, DB_USERNAME , DB_PASSWORD, $options);
            } catch (PDOException $e) {
                echo "Connection failed: ".$e->getMessage();
                exit();
            }
        }
        return self::$pdo;
    }

    /**
     * @param $sql
     * @param array $parameters
     * @return array|bool
     */
    public function query($sql, $parameters = [])
    {
        $dbh = $this->getConnection();
        $stmt = $dbh->prepare($sql);
        $result = $stmt->execute($parameters);

        if ($result !== false)
        {
            try {
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $exception) {
                return true;
            }
        }
        else
        {
            return false;
        }
    }

    protected function findTable ($params = []) {
        $database_tables = $this->getTables();
        $is_find = true;
        $table = [];

        for ($i=0; $i < count($database_tables); $i++) {
            $columns = $this->getColumns($database_tables[$i]['Tables_in_'.DB_NAME]);

            if (count($params) > count($columns)) {
                continue;
            }

            for ($l=0; $l < count($columns); $l++) {
                $is_find = isset($params[$columns[$l]['Field']]);
                if (!$is_find) {
                    break;
                }
            }

            if ($is_find) {
                array_push($table, $database_tables[$i]['Tables_in_'.DB_NAME]);
            }
        }

        return $table;
    }

    private function getTables () {
        return $this->query("SHOW TABLES;");
    }

    private function getColumns ($table_name) {
        return $this->query("SHOW COLUMNS FROM ".$table_name.';');

    }

}