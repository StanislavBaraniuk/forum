<?php
    /**
     * Created by PhpStorm.
     * User: stanislaw
     * Date: 3/30/19
     * Time: 14:53
     */

    class Session
    {
        public static function start (UserObject $userObject) : UserObject {

            session_start();

            $_SESSION['id'] = $userObject->getId();
            $_SESSION['login'] = $userObject->getLogin();
            $_SESSION['token'] = $userObject->getToken();

            Aquilon::getModel('User')->query(
                SQL::INSERT(
                    array(
                        "user_id" => $userObject->getId(),
                        "token" => $userObject->getToken(),
                        "start_datetime" =>  $userObject->getStart(),
                        "expiration_datetime" => $userObject->getExpiration()
                    ),
                    0,
                    'sessions'
                )
            );

            return $userObject;
        }

        public static function destroy (UserObject $userObject = null) : bool {

            $sessionExists = false;

            if ($userObject !== null) {

                $sessionExists = self::checkSessionExists( $userObject );

                if ($sessionExists) {
                    Aquilon::getModel( 'User' )->query(
                        SQL::DELETE(
                            [
                                "user_id" => $userObject->getId() ,
                                "token" => $userObject->getToken()
                            ] ,
                            0 ,
                            'sessions'
                        )
                    );
                }
            }

            session_destroy();

            if ($sessionExists) {
                return true;
            } else {
                return false;
            }
        }

        public static function checkSessionExists (UserObject $userObject) : bool {

            $session = Aquilon::getModel('User')->query(
                SQL::SELECT(
                    [
                        "GET" => [ "id" ],
                        'WHERE' => [
                            "user_id" => $userObject->getId(),
                            "token" => $userObject->getToken()
                        ]
                    ],
                    0,
                    'sessions'
                )
            );

            return !empty($session);
        }
    }