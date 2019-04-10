<?php
/**
 * Created by PhpStorm.
 * User: stanislaw
 * Date: 1/12/19
 * Time: 01:42
 */

class UnfController extends Controller
{
    function showAction() {
        Component::show('AquiNotFound');
    }
}