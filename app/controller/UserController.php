
<?php

    class UserController extends Controller
    {

        private $request;

        public function __construct ()
        {
            parent::_initModel();
            $this->request = Parser::json();
        }

        public function profileAction () {

            if( !Access::_RUN_(array('isAuthorizated'), false)['value'] ) {
                Session::destroy();
            }

            if  (Aquilon::_SESSION('id') === null) {
                Aquilon::redirect('/');
            }

            $_POST = $this->_model->getUserProfile ();

            Component::show('includes');
            Component::show('header');
            Component::load('profile')
                ->setCollectionLikes(Aquilon::getModel('Discussion')->getByLikes())
                ->setCollectionOwn(Aquilon::getModel('Discussion')->getCollectionByFilter(array('user_id' => Aquilon::_SESSION('id'))))
                ->_toHtml();

            ErrorHandler::clearErrorList();
        }

        public function loginAction () {

            if( !Access::_RUN_(array('isAuthorizated'), false)['value'] ) {
                Session::destroy();
            }

            if  (Aquilon::_SESSION('id') !== null) {
                Aquilon::redirect('/');
            }

            $_GET['title'] = 'Sign In';
            $_GET['signLink'] = '/user/registration/';
            $_GET['signLabel'] = 'Sign Up';

            if (!empty($_POST)) {
                $this->_model->login($_POST['login'], $_POST['password']);
            }

            Component::show('includes');
            Component::show('header');
            Component::show('login');

            ErrorHandler::clearErrorList();
        }

        public function registrationAction () {

            if( !Access::_RUN_(array('isAuthorizated'), false)['value'] ) {
                Session::destroy();
            }

            if  (Aquilon::_SESSION('id') !== null) {
                Aquilon::redirect('/');
            }

            $_GET['title'] = 'Sign Up';
            $_GET['signLink'] = '/user/login/';
            $_GET['signLabel'] = 'Sign In';

            if (!empty($_POST)) {
                $this->_model->registration($_POST['login'], $_POST['password']);
            }

            Component::show('includes');
            Component::show('header');
            Component::show('login');

            ErrorHandler::clearErrorList();
        }

        public function logoutAction () {
            if ($this->_model->logout()) {
                Aquilon::redirect($_SERVER['HTTP_REFERER']);
            } else {
                Aquilon::redirect('/');
            }
        }

        public function updateAction ($actionType) {

            if( !Access::_RUN_(array('isAuthorizated'), false)['value'] ) {
                Session::destroy();
            }

            $updateData = $this->request === null ? $_POST : $this->request;

            $response = true;

            switch ($actionType) {
                case 'info':
                    $this->_model->updateName(Aquilon::getByKey($updateData, 'name'));
                    $this->_model->updateEmail(Aquilon::getByKey($updateData, 'email'));
                    break;
                case 'password':
                    $this->_model->updatePassword(Aquilon::getByKey($updateData, 'new_password'), Aquilon::getByKey($updateData, 'old_password'));
                    break;
                default:
                    $response = false;
                    ResponseControl::generateStatus(405, $actionType.' method is undefined');
                    break;
            }

            header("Location: /user/profile ");
        }

        public function sessionAction ($actionType) {
            $response = true;

            switch ($actionType) {
                case 'close':
                    $this->_model->closeAllUserSessions();
                    break;

                default:
                    $response = false;
                    ResponseControl::generateStatus(405, $actionType.' method is undefined');
                    break;
            }
        }

    }