<?php

    class DiscussionController extends Controller
    {

        private $request;

        public function __construct ()
        {
            parent::_initModel();
            $this->request = Parser::json();
        }

        public function openAction($id) {

            if( !Access::_RUN_(array('isAuthorizated'), false)['value'] ) {
                Session::destroy();
            }

            $item = $this->_model->getItem($id);


            if (empty(Aquilon::getByKey($item, 'discussion'))) header('Location: /');

            $this->_model->addView($id);

            Component::show('includes');

            Component::show('header');
            Component::load('discussionContent')
                ->setDiscussion( Aquilon::getByKey($item, 'discussion') )
                ->setMessages( Aquilon::getByKey($item, 'messages') )
                ->_toHtml();

        }

        public function likeAction ($ids) {

            if( !Access::_RUN_(array('isAuthorizated'), false)['value'] ) {
                Session::destroy();
            }

            $userId = isset($ids['user_id']) ? $ids['user_id'] : Aquilon::getByKey($ids, 0);
            $discussionId = isset($ids['discussion_id']) ? $ids['discussion_id'] : Aquilon::getByKey($ids, 1);

            $this->_model->addLike($discussionId , $userId);

            $numberOfLikes = $this->_model->getLikesCount($discussionId);

            ResponseControl::outputGet($numberOfLikes);
        }

        public function dislikeAction ($ids) {

            if( !Access::_RUN_(array('isAuthorizated'), false)['value'] ) {
                Session::destroy();
            }

            $userId = isset($ids['user_id']) ? $ids['user_id'] : Aquilon::getByKey($ids, 0);
            $discussionId = isset($ids['discussion_id']) ? $ids['discussion_id'] : Aquilon::getByKey($ids, 1);

            $this->_model->removeLike($discussionId , $userId);

            $numberOfLikes = $this->_model->getLikesCount($discussionId);

            ResponseControl::outputGet($numberOfLikes);
        }

        public function messageAction ($request) {

            if( !Access::_RUN_(array('isAuthorizated'), false)['value'] ) {
                Session::destroy();
            }

            $actionType = is_array($request) ? Aquilon::getByKey($request, 0) : $request;

            switch ($actionType) {
                case 'add':
                    $response = $this->_model->addMessage ($this->request);
                    break;

                default:
                    $response = false;
                    ResponseControl::generateStatus(405, $actionType.' method is undefined');
                    break;
            }

            ResponseControl::outputGet($response);

        }

        public function addAction ()
        {

            if( !Access::_RUN_(array('isAuthorizated'), false)['value'] ) {
                Session::destroy();
            }

            $target_dir = ROOT."/app/images/";
            $target_file = $target_dir . basename( $_FILES[ "image" ][ "name" ] );

            $req = array_merge($_POST, array('user_id' => Aquilon::_SESSION('id')));
            $req['image'] = isset($_SERVER["HTTPS"]) ? 'https' : 'http' . '://' . $_SERVER['HTTP_HOST'] . '/app/images/' . $_FILES[ "image" ][ "name" ];

            $id = $this->_model->addDiscussion($req);

            $uploadOk = 1;

            if (isset( $_POST[ "submit" ] )) {
                $check = getimagesize( $_FILES[ "image" ][ "tmp_name" ] );
                if ($check !== false) {
                    echo "File is an image - " . $check[ "mime" ] . ".";
                    $uploadOk = 1;
                } else {
                    echo "File is not an image.";
                    $uploadOk = 0;
                }
            }

            if ($uploadOk === 1) {
                move_uploaded_file( $_FILES[ "image" ][ "tmp_name" ] , $target_file );
            }

            header("Location: /discussion/open/".$id);
        }

        public function deleteAction ($id)
        {
            if( !Access::_RUN_(array('isAuthorizated'), false)['value'] ) {
                Session::destroy();
            } else {
                $this->_model->deleteDiscussion($id);
            }
        }
    }