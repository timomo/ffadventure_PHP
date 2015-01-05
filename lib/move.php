<?php
/**
 * Created by IntelliJ IDEA.
 * User: timomo
 * Date: 15/01/05
 * Time: 14:51
 */

function read_stamina( &$data ) {
    $stamina_path = read_config_option( 'stamina_path' );
    $stamina_ext = read_config_option( 'stamina_ext' );
    $stamina_max = read_config_option( 'stamina_max' );
    $path = cat_file( $stamina_path, $data["id"]. '.'. $stamina_ext );
    $data["stamina"] = $stamina_max;
    $data["maxstamina"] = $stamina_max;
    $data["staminadate"] = time();
    
    if ( file_exists( $path ) == false ) {
        return false;
    }

    $contents = file_get_contents( $path );
    rtrim( $contents );
    
    $tmp = explode( "<>", $contents );
    
    $data["stamina"] = $tmp[0];
    $data["maxstamina"] = $tmp[1];
    $data["staminadate"] = $tmp[2];
}

function read_battlepoint( &$data ) {
    $battlepoint_path = read_config_option( 'battlepoint_path' );
    $battlepoint_ext = read_config_option( 'battlepoint_ext' );
    $battlepoint_max = read_config_option( 'battlepoint_max' );
    $path = cat_file( $battlepoint_path, $data["id"]. '.'. $battlepoint_ext );
    $data["battlepoint"] = $battlepoint_max;
    $data["maxbattlepoint"] = $battlepoint_max;
    $data["battlepointdate"] = time();

    if ( file_exists( $path ) == false ) {
        return false;
    }

    $contents = file_get_contents( $path );
    rtrim( $contents );

    $tmp = explode( "<>", $contents );

    $data["battlepoint"] = $tmp[0];
    $data["maxbattlepoint"] = $tmp[1];
    $data["battlepointdate"] = $tmp[2];
}

function use_stamina( &$data, $x = 0 ) {
    $data["stamina"] -= $x;
    calc_stamina( $data );
}

function use_battlepoint( &$data, $x = 0 ) {
    $data["battlepoint"] -= $x;
    
}

function calc_stamina( &$data ) {
    $stamina_time = read_config_option( 'stamina_time' );
    $x = floor( ( time() - $data["staminadate"] ) / $stamina_time );
    
    if ( $x > 0 ) {
        $data["staminadate"] = time();
    }
    $data["stamina"] += $x;
    if ( $data["stamina"] > $data["maxstamina"] ) {
        $data["stamina"] = $data["maxstamina"];
    }
    if ( $data["stamina"] < 0 ) {
        $data["stamina"] = 0;
    }
}

function calc_battlepoint( &$data ) {
    $battlepoint_time = read_config_option( 'battlepoint_time' );
    $x = floor( ( time() - $data["battlepointdate"] ) / $battlepoint_time );

    if ( $x > 0 ) {
        $data["battlepointdate"] = time();
    }
    $data["battlepoint"] += $x;
    if ( $data["battlepoint"] > $data["maxbattlepoint"] ) {
        $data["battlepoint"] = $data["maxbattlepoint"];
    }
    if ( $data["battlepoint"] < 0 ) {
        $data["battlepoint"] = 0;
    }
}

function regist_stamina( &$data ) {
    $stamina_path = read_config_option( 'stamina_path' );
    $stamina_ext = read_config_option( 'stamina_ext' );
    $path = cat_file( $stamina_path, $data["id"]. '.'. $stamina_ext );
    $text = implode( "<>", array( $data["stamina"], $data["maxstamina"], time() ) );
    
    file_put_contents( $path, $text );
}

function regist_battlepoint( &$data ) {
    $battlepoint_path = read_config_option( 'battlepoint_path' );
    $battlepoint_ext = read_config_option( 'battlepoint_ext' );
    $path = cat_file( $battlepoint_path, $data["id"]. '.'. $battlepoint_ext );
    $text = implode( "<>", array( $data["battlepoint"], $data["maxbattlepoint"], time() ) );

    file_put_contents( $path, $text );
}
