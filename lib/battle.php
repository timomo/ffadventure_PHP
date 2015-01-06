<?php
/**
 * Created by IntelliJ IDEA.
 * User: timomo
 * Date: 15/01/06
 * Time: 14:55
 */

function duel_battle( $in ) {
    $chara = login_chara_data( $in );
    
    if ( $chara["battlepoint"] == 0 ) {
        $battlepoint_time = read_config_option( 'battlepoint_time' );
        error_page( "バトルポイントが0の為、戦えません。<br />バトルポイントは". $battlepoint_time. "秒で1つ回復します。" );
    }
    
    $winner = load_winner_data();
    
    
}

/**
 * @param array $data
 * @return array
 */
function get_player_attack_calculation( $data ) {
    /**
     * 挑戦者ダメージ計算
     */
    $dmg1 = 0;
    $com1 = "";

    if ( $data["syoku"] == 0 ) {
        $dmg1 = rand( 0, $data["n_0"] );
        $com1 = $data["name"]. "は、剣で切りつけた！！";
    } elseif ( $data["syoku"] == 1 ) {
        $dmg1 = rand( 0, $data["kn_1"] );
        $com1 = $data["name"]. "は、魔法を唱えた！！";
    } elseif ( $data["syoku"] == 2 ) {
        $dmg1 = rand( 0, $data["n_2"] );
        $com1 = $data["name"]. "は、魔法を唱えた！！";
    } elseif ( $data["syoku"] == 3 ) {
        $dmg1 = rand( 0, $data["n_4"] );
        $com1 = $data["name"]. "は、背後から切りつけた！！";
    } elseif ( $data["syoku"] == 4 ) {
        $dmg1 = rand( 0, $data["n_3"] ) + rand( 0, $data["n_0"] );
        $com1 = $data["name"]. "は、弓で攻撃！！";
    } elseif ( $data["syoku"] == 5 ) {
        $dmg1 = rand( 0, $data["n_1"] ) + rand( 0, $data["n_4"] );
        $com1 = $data["name"]. "は、魔法を唱えた！！";
    } elseif ( $data["syoku"] == 6 ) {
        $dmg1 = rand( 0, $data["n_1"] ) + rand( 0, $data["n_4"] );
        $com1 = $data["name"]. "は、呪歌を歌った！！";
    } elseif ( $data["syoku"] == 7 ) {
        $dmg1 = rand( 0, $data["n_1"] ) + rand( 0, $data["n_3"] );
        $com1 = $data["name"]. "は、超能力を使った！！";
    } elseif ( $data["syoku"] == 8 ) {
        $dmg1 = rand( 0, $data["n_1"] ) + rand( 0, $data["n_2"] );
        $com1 = $data["name"]. "は、精霊魔法と、神聖魔法を同時に唱えた！！";
    } elseif ( $data["syoku"] == 9 ) {
        $dmg1 = rand( 0, $data["n_0"] ) + rand( 0, $data["n_2"] );
        $com1 = $data["name"]. "は、槍を突き刺した！！";
    } elseif ( $data["syoku"] == 10 ) {
        $dmg1 = rand( 0, $data["n_0"] ) + rand( 0, $data["n_2"] );
        $com1 = $data["name"]. "は、神聖魔法を唱えつつ、剣で切りつけた！！";
    } elseif ( $data["syoku"] == 11 ) {
        $dmg1 = rand( 0, $data["n_4"] ) + rand( 0, $data["n_5"] );
        $com1 = $data["name"]. "は、見えない速さで切りつけた！！";
    } elseif ( $data["syoku"] == 12 ) {
        $dmg1 = rand( 0, $data["n_0"] ) + rand( 0, $data["n_2"] );
        $com1 = $data["name"]. "は、殴りつけた！！";
    } elseif ( $data["syoku"] == 13 ) {
        $dmg1 = rand( 0, $data["n_0"] ) + rand( 0, $data["n_2"] );
        $com1 = $data["name"]. "は、蹴りつけた！！";
    }

    return array( "dmg" => $dmg1, "com" => $com1 );
}