<?php
/**
 * Created by IntelliJ IDEA.
 * User: timomo
 * Date: 15/01/05
 * Time: 15:41
 */

function battle_monster( $in ) {
    $chara = login_chara_data( $in );
    $max_turn = read_config_option( "turn" );
    $chara_syoku = read_config_option( "chara_syoku" );
    
    if ( $chara["stamina"] == 0 ) {
        $stamina_time = read_config_option( 'stamina_time' );
        error_page( "スタミナが0の為、戦えません。<br />スタミナは". $stamina_time. "秒で1つ回復します。" );
    }
    
    $monster_file = read_config_option( 'monster_file' );
    $monsters = file( $monster_file );
    
    $r_no = count( $monsters );
    $r_no = rand( 0, $r_no );
    
    $tmp = explode( "<>", $monsters[ $r_no ] );
    $mob["name"] = $tmp[0];
    $mob["ex"] = $tmp[1];
    $mob["hp"] = $tmp[2];
    $mob["sp"] = $tmp[3];
    $mob["dmg"] = $tmp[4];

    $khp = $chara["hp"];
    $khp_flg = $khp;
    $mhp = rand( 0, $mob["hp"] ) + $mob["sp"];
    $mhp_flg = $mhp;
    $win_flg = 0;
    
    foreach ( range( 1, $max_turn ) as $turn ) {
        $dmg1 = $chara["lv"] * ( rand( 0, 5 ) + 1 );
        $dmg2 = ( rand( 0, $mob["dmg"] ) + 1 ) + $mob["dmg"];
        $clit1 = "";
        $clit2 = "";
        $com1 = "";
        $com2 = $mob["name"]. "が襲いかかった！！";
        $kawasi1 = "";
        $kawasi2 = "";
        
        $calc = get_player_attack_calculation( $chara );
        
        $com1 = $calc["com"];
        $dmg1 += $calc["dmg"];
        
        if ( rand( 0, 20 ) == 0 ) {
            $clit1 = <<<EOF
            <font size="5">{$chara["name"]}「<b>{$chara["waza"]}</b>」</font><p><b class="clit">クリティカル！！</b>
EOF;
            $dmg1 = $dmg1 * 2;
        }
        
        if ( rand( 0, 30 ) == 0 ) {
            $clit2 = <<<EOF
            <b class="clit">クリティカル！！</b>
EOF;
            $dmg2 = $dmg2 * 1.5;
        }
        ?>
        <table border="0">
            <tr>
                <td class="b2" colspan="3" align="center">
                    <?php $turn ?>ターン
                </td>
            </tr>
            <tr>
                <td>
                    <table border="1">
                        <tr>
                            <td class="b1">
                                名前
                            </td>
                            <td class="b1">
                                HP
                            </td>
                            <td class="b1">
                                職業
                            </td>
                            <td class="b1">
                                LV
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <?php echo $chara["name"] ?>
                            </td>
                            <td>
                                <?php echo $khp_flg ?>/<?php echo $chara["maxhp"] ?>
                            </td>
                            <td>
                                <?php echo $chara_syoku[ $chara["syoku"] ] ?>
                            </td>
                            <td>
                                <?php echo $chara["lv"] ?>
                            </td>
                        </tr>
                    </table>
                </td>
                <td>
                    <span style="font-size: 10pt; color: #9999DD;">VS</span>
                </td>
                <td>
                    <table border="1">
                        <tr>
                            <td class="b1">
                                名前
                            </td>
                            <td class="b1">
                                HP
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <?php echo $mob["name"] ?>
                            </td>
                            <td>
                                <?php echo $mhp_flg ?>/<?php echo $mhp ?>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <div>
            <?php echo $com1 ?> <?php echo $clit1 ?> <?php echo $kawasi2 ?> <?php echo $mob["name"] ?>に <span class="dmg"><?php echo $dmg1 ?></span> のダメージを与えた。<br />
            <?php echo $com2 ?> <?php echo $clit2 ?> <?php echo $kawasi1 ?> <?php echo $chara["name"] ?>に <span class="dmg"><?php echo $dmg2 ?></span> のダメージを与えた。<br />
        </div>
        <?php
        
        $khp_flg -= $dmg2;
        $mhp_flg -= $dmg1;
        
        if ( $mhp_flg <= 0 ) {
            $win_flg = 1;
            break;
        } elseif ( $khp_flg <= 0 ) {
            $win_flg = 0;
            break;
        }
    }
    
    if ( $win_flg == 1 ) {
        $chara["total"] += 1;
        $chara["kati"] += 1;
        $chara["ex"] += $mob["ex"];
        use_stamina( $chara, 1 );
        $gold = $chara["lv"] * 10 + rand( 0, $chara["lp"] );
        $chara["gold"] += $gold;
        $comment = "";
    }
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