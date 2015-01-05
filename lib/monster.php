<?php
/**
 * Created by IntelliJ IDEA.
 * User: timomo
 * Date: 15/01/05
 * Time: 15:41
 */

function battle_monster( $in ) {
    $chara = login_chara_data( $in );
    
    if ( $chara["stamina"] == 0 ) {
        $stamina_time = read_config_option( 'stamina_time' );
        error_page( "スタミナが0の為、戦えません。<br />スタミナは". $stamina_time. "秒で1つ回復します。" );
    }
    
    $monster_file = read_config_option( 'monster_file' );
    $monsters = file( $monster_file );
    var_dump( $monsters );
}