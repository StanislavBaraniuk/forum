<?php

    class UserModel extends Model
    {

        public function login ($login, $password) {

            ErrorHandler::createError('AuthorizationFail');

            $user = $this->query(
                SQL::SELECT(
                    ["GET" => ["id", "password"], 'WHERE' => ["login" => $login]],
                    0,
                    'users'
                )
            );

            $user = isset($user[0]) ? $user[0] : '';

            if (!empty($user)) {

                if (crypt($password, $user['password']) == $user['password']) {

                    $this->startSession($user);

                    Aquilon::redirect('/');
                } else {
                    ErrorHandler::createError('AuthorizationFail');
                    ErrorHandler::setError('AuthorizationFail', 'Invalid password');
                }
            } else {
                ErrorHandler::createError('AuthorizationFail');
                ErrorHandler::setError('AuthorizationFail', 'Undefined login');
            }
        }

        public function registration ($login, $password) {

            if (!$this->validate($login, $password)) {
                return false;
            }

            ErrorHandler::createError('AuthorizationFail');

            $userExists = empty(
                $this->query(SQL::SELECT(
                    array("GET" => ["id"], 'WHERE' => ["login" => $login]),
                    0,
                    'users')
                )[0]
            ) ? false : true;

            if (!$userExists) {

                $this->query(
                    SQL::INSERT(
                        array(
                            "create_at" => ( new DateTime('now', new DateTimeZone('GMT')) )
                                ->format('Y-m-d H:i'),
                            "login" => $login,
                            "password" => crypt($password),
                        ),
                        0,
                        'users'
                    )
                );

                $user = $this->query(
                    SQL::SELECT(
                        ["GET" => ["id"], 'WHERE' => ["login" => $login]],
                        0,
                        'users'
                    )
                )[0];

                $this->query(
                    SQL::UPDATE(
                        ["SET" => ["name" => "User ".$user['id']], 'WHERE' => ["login" => $login]],
                        0,
                        'users'
                    )
                );

                $user['login'] = $login;

                $this->startSession($user);

                Aquilon::redirect('/');
            } else {
                ErrorHandler::createError('AuthorizationFail');
                ErrorHandler::setError('AuthorizationFail', 'Login is used already');
            }

            return true;
        }


        private function validate ($login, $password) {

            $isValid = true;

            if (!Validator::email($login)) {
                $isValid = false;
                ErrorHandler::createError('AuthorizationFail');
                ErrorHandler::createError('ValidateEmailFail', 'Email incorrect');
            }

            if (!Validator::password($password)) {
                $isValid = false;
                ErrorHandler::createError('AuthorizationFail');
                ErrorHandler::createError('ValidatePasswordFail', 'Need to contain 0-9, a-z, A-Z, minimum length 8');
            }

            return $isValid;
        }

        private function startSession ($user) {

            /** @var $user UserObject */
            $userObject = new UserObject();
            $userObject
                ->setId($user['id'])
                ->setLogin($user['login'])
                ->setToken(TokenGenerator::generate());
            ;

            if (Session::start($userObject)) {
                return true;
            } else {
                return false;
            }
        }

        public function logout () : bool {

            $userObject = new UserObject();

            if (!empty($_SESSION)) {
                $userObject
                    ->setId( $_SESSION[ 'id' ] )
                    ->setToken( $_SESSION[ 'token' ] );
            }

            if (Session::destroy($userObject)) {
                return true;
            } else {
                return false;
            }
        }

        public function getUserProfile () {
            if (isset($_SESSION)) {
                $user = $this->query(
                    SQL::SELECT(
                        [ "GET" => [ "name" , "login" , "create_at" ] , 'WHERE' => [ "id" => Aquilon::_SESSION('id') ] ] ,
                        0 ,
                        'users'
                    )
                );

                return isset($user[0]) ? $user[0] : null;
            }

            return null;
        }

        public function getId ($token) {
            if (isset($_SESSION)) {
                $user = $this->query(
                    SQL::SELECT(
                        [ "GET" => [ "user_id" ] , 'WHERE' => [ "token" => $token ] ] ,
                        0 ,
                        'sessions'
                    )
                );

                return isset($user[0]) ? $user[0] : null;
            }

            return null;
        }

        public function updateName ($string) {
            return empty($this->query(
                SQL::UPDATE(
                    [ "SET" => [ "name" => $string ] , 'WHERE' => [ "id" => Aquilon::_SESSION('id') ] ] ,
                    0 ,
                    'users'
                )
            ));
        }

        public function updateEmail ($string) {
            return empty($this->query(
                SQL::UPDATE(
                    [ "SET" => [ "login" => $string ] , 'WHERE' => [ "id" => Aquilon::_SESSION('id') ] ] ,
                    0 ,
                    'users'
                )
            ));
        }

        public function updatePassword ($new, $old) {

            if (!Validator::password($new)) {
                ErrorHandler::createError('AuthorizationFail', 'Need to contain 0-9, a-z, A-Z, minimum length 8');
                return false;
            }

            $user = $this->query(
                SQL::SELECT(
                    ["GET" => ["password"], 'WHERE' => [ "id" => Aquilon::_SESSION('id')]],
                    0,
                    'users'
                )
            );

            $user = isset($user[0]) ? $user[0] : '';

            if (!empty($user)) {

                if (crypt($old, $user['password']) === $user['password']) {
                    $this->query(
                        SQL::UPDATE(
                            [ "SET" => [ "password" => crypt($new) ] , 'WHERE' => [ "id" => Aquilon::_SESSION('id') ] ] ,
                            0 ,
                            'users'
                        )
                    );

                } else {
                    ErrorHandler::createError('AuthorizationFail');
                    ErrorHandler::setError('AuthorizationFail', 'Invalid password');
                }
            } else {
                ErrorHandler::createError('AuthorizationFail');
                ErrorHandler::setError('AuthorizationFail', 'Undefined login');
            }

            return true;
        }

        public function closeAllUserSessions () {
            $this->query(
                SQL::DELETE(
                    [ "user_id" => Aquilon::_SESSION('id'), 'token !=' => Aquilon::_SESSION('token') ] ,
                    0 ,
                    'sessions'
                )
            );
        }
    }