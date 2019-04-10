<?php
/**
 * Created by PhpStorm.
 * User: stanislaw
 * Date: 1/30/19
 * Time: 09:47
 */

/** Work with api output data **/
class ResponseControl {

    /** Gets data and output it in JSON
     *
     * @param $data array || string
     * @param error will display if nothing to output
     **/
    public static function outputGet ($data = "OK", $info = ["code" => 302, "message" => "Nothing to output"]) {
        header("Content-Type: application/json; charset=UTF-8");

        if (!is_array($data)) {
            echo json_encode($data);
            return true;
        }

        if (count($data) > 0) {
            echo json_encode($data);
            return true;
        }

        http_response_code($info["code"]);
        echo $info["message"];
        return false;
    }

    /**
     * Generate HTTP response
     *
     * @param int $code
     * @param string $message
     */
    public static function generateStatus (int $code = 302, $message = "Nothing to output") {
        header("Content-Type: application/json; charset=UTF-8");
        http_response_code($code);
        echo $message;
    }
}