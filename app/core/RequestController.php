<?php
    /**
     * Created by PhpStorm.
     * User: stanislaw
     * Date: 4/4/19
     * Time: 14:09
     */

    class RequestController
    {
        public static function check ($request) {

            $request = json_decode($request);

            foreach ($request as $item) {
                if ($item === null) {
                    return false;
                }
            }

            return true;
        }

    }