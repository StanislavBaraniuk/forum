<?php
/**
 * Created by PhpStorm.
 * User: stanislaw
 * Date: 1/15/19
 * Time: 15:04
 */

class SQL extends DB
{
//    static private $db;

    function __construct()
    {
        $this->db = new DB();
    }

    static public function INSERT($params = [], $DEFAULT_TF_INDEX = 0, $table_name = null, $additional = '') {

        if ($table_name !== null)
            $sql = "INSERT INTO $table_name (";
        else
            $sql = "INSERT INTO ".(new self)->findTable($params)[$DEFAULT_TF_INDEX]."  (";

        $count = 1;

        foreach ($params as $key => $item) {
            $sql .= "`".$key."`";
            if ($count < count($params)) {
                $sql .=', ';
            }
            $count++;
        }

        $sql .= ') VALUES (';

        $count = 1;

        foreach ($params as $key => $item) {
            $sql .= "'".htmlentities($item)."'";
            if ($count < count($params)) {
                $sql .=', ';
            }
            $count++;
        }

        $sql .= ") $additional";

        return $sql;

    }

    static public function UPDATE($params = [],  $DEFAULT_TF_INDEX = 0, $table_name = null, $additional = '') {
        if ($table_name !== null)
            $sql = "UPDATE $table_name SET ";
        else
            $sql = "UPDATE ".(new self)->findTable($params)[$DEFAULT_TF_INDEX]." SET ";

        $count = 1;

        foreach ($params[SQL_UPDATE_SET_NAME] as $key => $item) {
            $sql .= "`".$key."` = '".$item."'";
            if ($count < count($params[SQL_UPDATE_SET_NAME])) {
                $sql .=', ';
            }
            $count++;
        }

        if (!isset($params[SQL_UPDATE_WHERE_NAME])) return $sql;

        $sql .= ' WHERE ';

        $count = 1;

        foreach ($params[SQL_UPDATE_WHERE_NAME] as $key => $item) {
            $sql .= "`".$key."` = '".$item."'";
            if ($count < count($params[SQL_UPDATE_WHERE_NAME])) {
                $sql .=' AND ';
            }
            $count++;
        }

        $sql .= " $additional";

        return $sql;

    }

    static public function DELETE($params = [],  $DEFAULT_TF_INDEX = 0, $table_name = null, $additional = '') {
        if ($table_name !== null)
            $sql = "DELETE FROM $table_name WHERE ";
        else
            $sql = "DELETE FROM ".(new self)->findTable($params)[$DEFAULT_TF_INDEX]." WHERE ";

        $count = 1;

        foreach ($params as $key => $item) {
            if (count(explode(' ',$key)) > 1) {
                $sql .= "`".explode(' ',$key)[0]."` ".explode(' ',$key)[1]." '".$item."'";
            } else {
                $sql .= "`".$key."` = '".$item."'";
            }

            if ($count < count($params)) {
                $sql .=' AND ';
            }
            $count++;
        }

        $sql .= " $additional;";

        return $sql;
    }

    static public function SELECT(
        array $params = [
            SQL_SELECT_GET_NAME => [],
            SQL_SELECT_WHERE_NAME => [],
            SQL_SELECT_EXCEPT_NAME => []
        ],
        $DEFAULT_TF_INDEX = 0,
        $table_name = null,
        $additional = '')
    {
        $sql = "SELECT ";
        $count = 1;

        foreach ( $params[SQL_SELECT_GET_NAME] as $item) {
            if (
                !array_search(
                    $item,
                    isset($params[SQL_SELECT_EXCEPT_NAME]) ? $params[SQL_SELECT_EXCEPT_NAME] : array()
                )
            )
            {
                $sql .= $item;
                if ($count < count($params[SQL_SELECT_GET_NAME])) {
                    $sql .= ', ';
                }
                $count++;
            }
        }

        $autoFindTable = (new self)->findTable($params);
        $autoFindTable = isset($autoFindTable[$DEFAULT_TF_INDEX]) ? $autoFindTable[$DEFAULT_TF_INDEX] : null;

        if ($table_name !== null)
            $sql .= " FROM $table_name ";
        else
            $sql .= " FROM " . $autoFindTable . " ";

        if (!isset($params[SQL_SELECT_WHERE_NAME])) return $sql;

        $count = 1;

        $sql .= " WHERE ";

        foreach ($params[SQL_SELECT_WHERE_NAME] as $key => $item) {
            if (count(explode(' ',$key)) > 1) {
                $sql .= "`".explode(' ',$key)[0]."` ".explode(' ',$key)[1]." '".$item."'";
            } else {
                $sql .= "`".$key."` = '".$item."'";
            }

            if ($count < count($params[SQL_SELECT_WHERE_NAME])) {
                $sql .=' AND ';
            }
            $count++;
        }

        $sql .= $additional;

        return $sql;
    }

}