<?php
/**
 * Created by IntelliJ IDEA.
 * User: timomo
 * Date: 14/12/30
 * Time: 17:44
 */

require_once '../lib/functions.php';
require_once '../include/global.php';
require_once '../lib/login.php';
require_once '../lib/html.php';
require_once '../lib/chara.php';

$IN = decode_param();
var_dump( $IN );
forward( $IN );