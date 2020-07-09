<?php
require 'auth.php';
echo auth(isset($_COOKIE['SESSIONID'])?$_COOKIE['SESSIONID']:'');