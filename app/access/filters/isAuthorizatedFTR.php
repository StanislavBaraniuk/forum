<?php

    Access::_USE_();

    $session_exist = (new DB)->query(SQL::SELECT(["GET" => ['id'], "WHERE" => ["token" => Aquilon::_SESSION('token')]], 0, 'sessions'));

    return [!empty($session_exist), "Need authorization", 401];