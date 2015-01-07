<?php
/**
 * Created by IntelliJ IDEA.
 * User: timomo
 * Date: 15/01/06
 * Time: 14:55
 */

function battle_duel( $in ) {
    $chara = login_chara_data( $in );
    $max_turn = read_config_option( "turn" );
    $level_sa = read_config_option( "level_sa" );
    $chara_syoku = read_config_option( "chara_syoku" );
    $kiso_exp = read_config_option( "kiso_exp" );
    $lv_up = read_config_option( "lv_up" );
    $script = read_config_option( "script" );
    
    if ( $chara["battlepoint"] == 0 ) {
        $battlepoint_time = read_config_option( 'battlepoint_time' );
        error_page( "バトルポイントが0の為、戦えません。<br />バトルポイントは". $battlepoint_time. "秒で1つ回復します。" );
    }
    
    $winner = load_winner_data();
    
    if ( $winner["id"] == $chara["id"] ) {
        error_page( "現在チャンプなので闘えません。" );
    }
    
    $chara_item = load_item_data( $chara["item"] );
    $winner_item = load_item_data( $winner["item"] );
    
    $khp_flg = $chara["hp"];
    $whp_flg = $winner["hp"];
    $win_flg = 0;
    
    show_header();
    
    ?>
    <h1><?php echo $chara["name"] ?>は、<?php echo $winner["name"] ?>に戦いを挑んだ！！</h1>
    <hr size="0">
    <?php
    
    foreach ( range( 1, $max_turn ) as $turn ) {
        $dmg1 = $chara["lv"] * (rand(0, 3) + 1);
        $dmg2 = $winner["lv"] * (rand(0, 3) + 1);
        $clit1 = "";
        $clit2 = "";
        $com1 = "";
        $com2 = "";
        $kawasi1 = "";
        $kawasi2 = "";

        $calc1 = get_player_attack_calculation2($chara, $com1, $dmg1);
        $calc2 = get_player_attack_calculation2($winner, $com2, $dmg2);

        $com1 = $calc1["com"];
        $dmg1 = $calc1["dmg"];
        $com2 = $calc2["com"];
        $dmg2 = $calc2["dmg"];

        if (rand(0, 20) == 0) {
            $clit1 = <<<EOF
            <font size="5">{$chara["name"]}「<b>{$chara["waza"]}</b>」</font><p><b class="clit">クリティカル！！</b>
EOF;
            $dmg1 = $dmg1 * 2;
        }

        if (rand(0, 30) == 0) {
            $clit2 = <<<EOF
            <b class="clit">クリティカル！！</b>
EOF;
            $dmg2 = $dmg2 * 1.5;
        }

        if ($winner["lv"] - $chara["lv"] >= $level_sa && $turn == 1) {
            $sa = $winner["lv"] - $chara["lv"];
            $clit1 .= <<<EOF
<p><span><b>{$chara["name"]}の体から青い炎のようなものが湧き上がる・・・。</b></span>
EOF;
            $dmg1 = $dmg1 + $chara["maxhp"];
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
                                <?php echo $chara_syoku[$chara["syoku"]] ?>
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
                            <td class="b1">
                                職業
                            </td>
                            <td class="b1">
                                LV
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <?php echo $winner["name"] ?>
                            </td>
                            <td>
                                <?php echo $whp_flg ?>/<?php echo $winner["maxhp"] ?>
                            </td>
                            <td>
                                <?php echo $chara_syoku[$winner["syoku"]] ?>
                            </td>
                            <td>
                                <?php echo $winner["lv"] ?>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <div>
            <?php echo $com1 ?> <?php echo $clit1 ?> <?php echo $kawasi2 ?> <?php echo $winner["name"] ?>に <span
                class="dmg"><?php echo $dmg1 ?></span> のダメージを与えた。<br/>
            <?php echo $com2 ?> <?php echo $clit2 ?> <?php echo $kawasi1 ?> <?php echo $chara["name"] ?>に <span
                class="dmg"><?php echo $dmg2 ?></span> のダメージを与えた。<br/>
        </div>
        <?php

        $khp_flg -= $dmg2;
        $whp_flg -= $dmg1;

        if ($whp_flg <= 0) {
            $win_flg = 1;
            break;
        } elseif ($khp_flg <= 0) {
            $win_flg = 0;
            break;
        }

    }
        
    if ( $win_flg == 1 ) {
        $chara["total"] += 1;
        $chara["kati"] += 1;
        $mex = $winner["lv"] * $kiso_exp + rand( 0, $chara["lp"] ) + 1;
        $chara["ex"] += $mex;
        use_battlepoint( $chara, 1 );
        $gold = $chara["lv"] * 10 + rand( 0, $chara["lp"] );
        $chara["gold"] += $gold;
        ?>
        <div>
            <span style="font-size: 10pt;"><?php echo $chara["name"] ?>は戦闘に勝利した！！</span>
            <?php echo $mex ?>の経験値を手に入れた。<br />
            <?php echo $gold ?>Gを手に入れた。
        </div>
    <?php
    } else {
        $chara["total"] += 1;
        $mex = $winner["lv"] * rand( 0, $chara["lp"] ) + 1;
        $chara["ex"] += $mex;
        use_battlepoint( $chara, 1 );
        $gold = rand( 0, $chara["lp"] );
        $chara["gold"] += $gold;
        ?>
        <div>
            <span style="font-size: 10pt;"><?php echo $chara["name"] ?>は戦闘に負けた・・・。</span>
            <?php echo $mex ?>の経験値を手に入れた。<br />
            <?php echo $gold ?>Gを手に入れた。
        </div>
    <?php
    }

    if ( $chara["ex"] > ( $chara["lv"] * $lv_up ) ) {
        $maxhp_flg = rand( 0, $chara["n_3"] ) + 1;
        $chara["maxhp"] += $maxhp_flg;
        $chara["hp"] = $chara["maxhp"];
        $chara["ex"] = 0;
        $chara["lv"] += 1;
        $t = array( "", "", "", "", "", "", "" );

        if ( rand( 0, 5 ) == 0 ) {
            $chara["n_0"] += 1;
            $t[0] = "力";
        }
        if ( rand( 0, 5 ) == 0 ) {
            $chara["n_1"] += 1;
            $t[1] = "知力";
        }
        if ( rand( 0, 5 ) == 0 ) {
            $chara["n_2"] += 1;
            $t[2] = "信仰心";
        }
        if ( rand( 0, 5 ) == 0 ) {
            $chara["n_3"] += 1;
            $t[3] = "生命力";
        }
        if ( rand( 0, 5 ) == 0 ) {
            $chara["n_4"] += 1;
            $t[3] = "器用さ";
        }
        if ( rand( 0, 5 ) == 0 ) {
            $chara["n_5"] += 1;
            $t[3] = "速さ";
        }
        if ( rand( 0, 5 ) == 0 ) {
            $chara["n_6"] += 1;
            $t[3] = "魅力";
        }

        foreach ( range( 0, 6 ) as $i ) {
            if ( $t[$i] == "" ) {
                continue;
            }
            ?>
            <?php echo $t[$i] ?>が上がった。<br />
        <?php
        }
    }

    $chara["hp"] = $khp_flg + rand( 0, $chara["n_3"] );
    $winner["hp"] = $whp_flg + rand( 0, $winner["n_3"] );
    if ( $chara["hp"] > $chara["maxhp"] ) {
        $chara["hp"] = $chara["maxhp"];
    }
    if ( $chara["hp"] <= 0 ) {
        $chara["hp"] = 0;
    }
    if ( $winner["hp"] > $winner["maxhp"] ) {
        $winner["hp"] = $winner["maxhp"];
    }
    if ( $winner["hp"] <= 0 ) {
        $winner["hp"] = 0;
    }

    save_chara_data( $chara );
    
    if ( $win_flg == 1 ) {
        $loser = $winner;
        $winner = $chara;
        $winner["count"] = 1;
        $winner["l_site"] = $loser["site"];
        $winner["l_url"] = $loser["url"];
        $winner["l_name"] = $loser["name"];
        save_winner_data( $winner );
    } else {
        $loser = $chara;
        $winner["count"] += 1;
        $winner["l_site"] = $loser["site"];
        $winner["l_url"] = $loser["url"];
        $winner["l_name"] = $loser["name"];
        save_winner_data( $winner );
        
        $record = array();
        $record["count"] = $winner["count"];
        $record["name"] = $winner["name"];
        $record["site"] = $winner["site"];
        $record["url"] = $winner["url"];
        
        save_record_data( $record );
    }
    
    ?>
    <form action="<?php echo $script ?>" method="post">
        <input type="hidden" name="mode" value="log_in" />
        <input type="hidden" name="id" value="<?php echo $chara["id"] ?>" />
        <input type="hidden" name="pass" value="<?php echo $chara["pass"] ?>" />
        <input type="submit" value="ステータス画面へ" />
    </form>
    <?php

    show_footer();
}

function get_player_attack_calculation2( $data, $com1, $dmg1 ) {
    $waza_ritu = read_config_option( "waza_ritu" );
    $hissatu = read_config_option( "hissatu" );
    $item = load_item_data( $data["item"] );
    $hissatu_flg = 0;
    /**
     * ダメージ計算
     */
    if ( $data["syoku"] == 0 ) {
        if( 0 == rand( 0, $waza_ritu ) ) {
            $hissatu_flg = 1;
            $dmg1 = $dmg1 * 5;
        }
        $dmg1 = $dmg1 + rand( 0, $data["n_0"] ) + $item["dmg"];
    } elseif ( $data["syoku"] == 1 ) {
        if ( 0 == rand( 0, $waza_ritu ) ) {
            $hissatu_flg = 1;
            $dmg1 = $dmg1 * 5;
        }
        $dmg1 = $dmg1 + rand( 0, $data["n_1"] ) + $item["dmg"];
    } elseif ( $data["syoku"] == 2 ) {
        if ( 0 == rand( 0, $waza_ritu ) ) {
            $hissatu_flg = 1;
            $dmg1 = $dmg1 * 5;
        }
        $dmg1 = $dmg1 + rand( 0, $data["n_2"] ) + $item["dmg"];
    } elseif ( $data["syoku"] == 3 ) {
        if ( 0 == rand( 0, $waza_ritu ) ) {
            $hissatu_flg = 1;
            $dmg1 = $dmg1 * 5;
        }
        $dmg1 = $dmg1 + rand( 0, $data["n_3"] ) + $item["dmg"];
    } elseif ( $data["syoku"] == 4 ) {
        if ( 0 == rand( 0, $waza_ritu ) ) {
            $hissatu_flg = 1;
            $dmg1 = $dmg1 * 5;
        }
        $dmg1 = $dmg1 + rand( 0, $data["n_3"] ) + rand( 0, $data["n_0"] ) + $item["dmg"];
    } elseif ( $data["syoku"] == 5 ) {
        if ( 0 == rand( 0, $waza_ritu ) ) {
            $hissatu_flg = 1;
            $dmg1 = $dmg1 * 6;
        }
        $dmg1 = $dmg1 + rand( 0, $data["n_1"] ) + rand( 0, $data["n_4"] ) + $item["dmg"];
    } elseif ( $data["syoku"] == 6 ) {
        if ( 0 == rand( 0, $waza_ritu ) ) {
            $hissatu_flg = 1;
            $dmg1 = $dmg1 * 6;
        }
        $dmg1 = $dmg1 + rand( 0, $data["n_1"] ) + rand( 0, $data["n_4"] ) + $item["dmg"];
    } elseif ( $data["syoku"] == 7 ) {
        if ( 0 == rand( 0, 7 ) ) {
            $hissatu_flg = 1;
            $dmg1 = $dmg1 * 6;
        }
        $dmg1 = $dmg1 + rand( 0, $data["n_1"] ) + rand( 0, $data["n_3"] ) + $item["dmg"];
    } elseif ( $data["syoku"] == 9 ) {
        if(0 == rand( 0, $waza_ritu ) ) {
            $hissatu_flg = 1;
            $dmg1 = $dmg1 * 8;
        }
        $dmg1 = $dmg1 * rand( 0, $data["n_1"] ) + rand( 0, $data["n_2"] ) + $item["dmg"];
    } elseif ( $data["syoku"] == 8 ) {
        if ( 0 == rand( 0, $waza_ritu ) ) {
            $hissatu_flg = 1;
            $dmg1 = $dmg1 * 8;
        }
        $dmg1 = $dmg1 + rand( 0, $data["n_0"] ) + rand( 0, $data["n_2"] ) + $item["dmg"];
    } elseif ( $data["syoku"] == 10 ) {
        if ( 0 == rand( 0, $waza_ritu ) ) {
            $hissatu_flg = 1;
            $dmg1 = $dmg1 * 9;
        }
        $dmg1 = $dmg1 + rand( 0, $data["n_0"] ) + rand( 0, $data["n_2"] ) + $item["dmg"];
    } elseif ( $data["syoku"] == 11 ) {
        if ( 0 == rand( 0, $waza_ritu ) ) {
            $hissatu_flg = 1;
            $dmg1 = $dmg1 * 9;
        }
        $dmg1 = $dmg1 + rand( 0, $data["n_4"] ) + rand( 0, $data["n_5"] ) + $item["dmg"];
    } elseif ( $data["syoku"] == 12 ) {
        if ( 0 == rand( 0, $waza_ritu ) ) {
            $hissatu_flg = 1;
            $dmg1 = $dmg1 * 9;
        }
        $dmg1 = $dmg1 + rand( 0, $data["n_0"] ) + rand( 0, $data["n_2"] ) + $item["dmg"];
    } elseif ( $data["syoku"] == 13 ) {
        if(0 == rand( 0, $waza_ritu )) {
            $dmg1 = $dmg1 * 9;
        }
        $dmg1 = $dmg1 + rand( 0, $data["n_0"] ) + rand( 0, $data["n_2"] ) + $item["dmg"];
    }

    $com1 .= <<<EOF
        {$data["name"]}は{$item["name"]}で攻撃！！<br />
EOF;
    if ( $hissatu_flg == 1 ) {
        $com1 .= <<<EOF
        <span>{$data["name"]}「<b>{$data["waza"]}</b>」</span><br /><span style="#CC6699"><b>{$hissatu[ $data["syoku"] ]}</b></span><br />
EOF;
    }
    
    return array( "dmg" => $dmg1, "com" => $com1 );
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
        $com1 .= $data["name"]. "は、剣で切りつけた！！";
    } elseif ( $data["syoku"] == 1 ) {
        $dmg1 = rand( 0, $data["kn_1"] );
        $com1 .= $data["name"]. "は、魔法を唱えた！！";
    } elseif ( $data["syoku"] == 2 ) {
        $dmg1 = rand( 0, $data["n_2"] );
        $com1 .= $data["name"]. "は、魔法を唱えた！！";
    } elseif ( $data["syoku"] == 3 ) {
        $dmg1 = rand( 0, $data["n_4"] );
        $com1 .= $data["name"]. "は、背後から切りつけた！！";
    } elseif ( $data["syoku"] == 4 ) {
        $dmg1 = rand( 0, $data["n_3"] ) + rand( 0, $data["n_0"] );
        $com1 .= $data["name"]. "は、弓で攻撃！！";
    } elseif ( $data["syoku"] == 5 ) {
        $dmg1 = rand( 0, $data["n_1"] ) + rand( 0, $data["n_4"] );
        $com1 .= $data["name"]. "は、魔法を唱えた！！";
    } elseif ( $data["syoku"] == 6 ) {
        $dmg1 = rand( 0, $data["n_1"] ) + rand( 0, $data["n_4"] );
        $com1 .= $data["name"]. "は、呪歌を歌った！！";
    } elseif ( $data["syoku"] == 7 ) {
        $dmg1 = rand( 0, $data["n_1"] ) + rand( 0, $data["n_3"] );
        $com1 .= $data["name"]. "は、超能力を使った！！";
    } elseif ( $data["syoku"] == 8 ) {
        $dmg1 = rand( 0, $data["n_1"] ) + rand( 0, $data["n_2"] );
        $com1 .= $data["name"]. "は、精霊魔法と、神聖魔法を同時に唱えた！！";
    } elseif ( $data["syoku"] == 9 ) {
        $dmg1 = rand( 0, $data["n_0"] ) + rand( 0, $data["n_2"] );
        $com1 .= $data["name"]. "は、槍を突き刺した！！";
    } elseif ( $data["syoku"] == 10 ) {
        $dmg1 = rand( 0, $data["n_0"] ) + rand( 0, $data["n_2"] );
        $com1 .= $data["name"]. "は、神聖魔法を唱えつつ、剣で切りつけた！！";
    } elseif ( $data["syoku"] == 11 ) {
        $dmg1 = rand( 0, $data["n_4"] ) + rand( 0, $data["n_5"] );
        $com1 .= $data["name"]. "は、見えない速さで切りつけた！！";
    } elseif ( $data["syoku"] == 12 ) {
        $dmg1 = rand( 0, $data["n_0"] ) + rand( 0, $data["n_2"] );
        $com1 .= $data["name"]. "は、殴りつけた！！";
    } elseif ( $data["syoku"] == 13 ) {
        $dmg1 = rand( 0, $data["n_0"] ) + rand( 0, $data["n_2"] );
        $com1 .= $data["name"]. "は、蹴りつけた！！";
    }

    return array( "dmg" => $dmg1, "com" => $com1 );
}