<?php

    class IndexController extends Controller {
        public function indexAction() {

            if( !Access::_RUN_(array('isAuthorizated'), false)['value'] ) {
                Session::destroy();
            }

            $collection = Aquilon::getModel('Discussion')->getCollection();

            if ($collection == null) {
                $collection = array();
            }

            Component::show('includes');
            Component::show('header');
            Component::load('homeContent')
                ->setCollection($collection)
                ->_toHtml();
        }
    }