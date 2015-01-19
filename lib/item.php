<?php
/**
 * Created by IntelliJ IDEA.
 * User: timomo
 * Date: 15/01/06
 * Time: 15:21
 */

function load_item_data( $id ) {
    if ( array_key_exists( "ITEMS", $GLOBALS ) == false ) {
        $GLOBALS["ITEMS"] = load_all_item_data();
    }
    if ( array_key_exists( $id, $GLOBALS["ITEMS"] ) == false ) {
        return array(
            "no" => "0000",
            "name" => "素手",
            "dmg" => 1,
            "gold" => 0
        );
    }
    return $GLOBALS["ITEMS"][ $id ];
}

function load_all_item_data() {
    $item_file = read_config_option( "item_file" );
    $items = file( $item_file );
    $ret = array();
    foreach ( $items as $no => $line ) {
        $item = convert_item_data_scalar2array( $line );
        $ret[ $item["no"] ] = $item;
    }
    return $ret;
}

function convert_item_data_scalar2array( $text ) {
    $tmp = explode( "<>", $text );
    $item = array();
    $item["no"] = $tmp[0];
    $item["name"] = $tmp[1];
    $item["dmg"] = $tmp[2];
    $item["gold"] = $tmp[3];
    return $item;
}