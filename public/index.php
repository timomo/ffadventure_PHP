<?php
/**
 * Created by IntelliJ IDEA.
 * User: timomo
 * Date: 14/12/30
 * Time: 17:44
 */

require_once '../include/global.php';

$IN = decode_param();
var_dump( $IN );
forward( $IN );