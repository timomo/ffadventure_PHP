<?php
/**
 * Created by IntelliJ IDEA.
 * User: timomo
 * Date: 15/01/03
 * Time: 21:44
 */

function chara_make( $in ) {
    $script = read_config_option( 'script' );
    $kiso_nouryoku = read_config_option( 'kiso_nouryoku' );
    $chara_name = read_config_option( 'chara_name' );
    show_header();
    ?>
    <h1>キャラクタ作成画面</h1>
    <hr size=0 />
    <form action="<?php echo $script ?>" method="post">
        <input type="hidden" name="mode" value="make_end">
        <table border=1>
            <tr>
                <td class="b1">ID</td>
                <td><input type="text" name="id" size="10"><br><small>△お好きな半角英数字を4〜8文字以内でご記入ください。</small></td>
            </tr>
            <tr>
                <td class="b1">パスワード</td>
                <td><input type="password" name="pass" size="10"><br><small>△お好きな半角英数字を4〜8文字以内でご記入ください。</small></td>
            </tr>
            <tr>
                <td class="b1">ホームページ名</td>
                <td><input type="text" name="site" size="40"><br><small>△あなたのホームページの名前を入力してください。</small></td>
            </tr>
            <tr>
                <td class="b1">URL</td>
                <td><input type="text" name="url" size="50" value="http://"><br><small>△あなたのホームページのアドレスを記入してください。</small></td>
            </tr>
            <tr>
                <td class="b1">キャラクターの名前</td>
                <td><input type="text" name="c_name" size="30"><br><small>△作成するキャラクターの名前を入力してください。</small></td>
            </tr>
            <tr>
                <td class="b1">キャラクターの性別</td>
                <td><input type="radio" name="sex" value="0">女　<input type="radio" name="sex" value="1">男<br><small>△作成するキャラクターの性別を選択してください。</small></td>
            </tr>
            <tr>
                <td class="b1">キャラクターのイメージ</td>
                <td><select name="chara">
                        <?php
                        foreach( $chara_name as $no => $img ) {
                        ?>
                        <option value="<?php echo $no ?>"><?php echo $img ?></option>
                        <?php
                        }
                        ?>
                    </select><br><small>△作成するキャラクターの性別を選択してください。</small></td>
            </tr>
            <tr>
                <td class="b1">キャラクターの能力</td>
                <td>
                    <table border=1>
                        <tr>
                            <td class="b2" width="70">力</td><td class="b2" width="70">知能</td><td class="b2" width="70">信仰心</td><td class="b2" width="70">生命力</td><td class="b2" width="70">器用さ</td><td class="b2" width="70">速さ</td><td class="b2" width="70">魅力</td>
                        </tr>
                        <tr>
                            <?php
                            $point = rand( 0, 10 );
                            $point += 4;
                            foreach ( range( 0, 6 ) as $i ) {
                                ?>
                                <td><?php echo $kiso_nouryoku[$i] ?><select name="n_<?php echo $i ?>">
                                <?php
                                foreach( range( 0, $point ) as $j ) {
                                    ?>
                                    <option value="<?php echo $j ?>"><?php echo $j ?></option>
                                    <?php
                                }
                                ?>
                                </select>
                                </td>
                                <?php
                            }
                            ?>
                        </tr>
                    </table>
                    <small>△ボーナスポイント「<b><?php echo $point ?></b>」をそれぞれに振り分けてください。(振り分けた合計が、<?php echo $point ?>以下になるように。<br>又どれかが最低12以上になるように。最高は18までです)</small>
                </td>
            </tr>
            <tr>
                <td colspan="2" align="center"><input type="submit" value="これで登録"></td>
            </tr>
        </table>
        <input type="hidden" name=point value="<?php echo $point ?>">
    </form>
<?php
    show_footer();
}

function chara_make_end( $in ) {
    $chara_stop = read_config_option( 'chara_stop' );
    $kiso_nouryoku = read_config_option( 'kiso_nouryoku' );
    $chara_syoku = read_config_option( 'chara_syoku' );
    $script = read_config_option( 'script' );
    $img_path = read_config_option( 'img_path' );
    $chara_img = read_config_option( 'chara_img' );
    $lv_up = read_config_option( 'lv_up' );
    
    if ( $chara_stop == 1 ) {
        error_page( '現在キャラクターの作成登録はできません' );
    }
    if ( preg_match( '/[^0-9a-zA-Z]/', $in['id'] ) ) {
        error_page( 'IDに半角英数字以外の文字が含まれています。' );
    }
    if ( preg_match( '/[^0-9a-zA-Z]/', $in['pass'] ) ) {
        error_page( 'パスワードに半角英数字以外の文字が含まれています。' );
    }
    /**
     * 職業未選択の場合
     */
    if ( array_key_exists( 'syoku', $in ) == false ) {
        if ( $in['id'] == '' || strlen( $in['id'] ) < 4 || strlen( $in['id'] ) > 8 ) {
            error_page( 'IDは、4文字以上、8文字以下で入力して下さい。' );
        }
        if ( $in['pass'] == '' || strlen( $in['pass'] ) < 4 || strlen( $in['pass'] ) > 8 ) {
            error_page( 'パスワードは、4文字以上、8文字以下で入力して下さい。' );
        }
        if ( $in['site'] == '' ) {
            error_page( 'ホームページ名が未記入です' );
        }
        if ( $in['url'] == '' ) {
            error_page( 'URLが未記入です' );
        }
        if ( $in['c_name'] == '' ) {
            error_page( 'キャラクターの名前が未記入です' );
        }
        if ( $in['sex'] == '' ) {
            error_page( '性別が選択されていません' );
        }
        if ( check_dup_id( $in['id'] ) == false ) {
            error_page( 'そのIDはすでに登録されています' );
        }
        
        $g = $in['n_0'] + $in['n_1'] + $in['n_2'] + $in['n_3'] + $in['n_4'] + $in['n_5'] + $in['n_6'];
        
        if ( $g > $in['point'] ) {
            error_page( 'ポイントの振り分けが多すぎます。振り分けの合計を、'. $in['point'] .'以下にしてください。' );
        }

        show_header();

        ?>
        <h1>職業選択画面</h1>
        <hr size="0">
        <p>あなたがなることができる職業は以下のとおりです。</p>
        <form action="<?php echo $script ?>" method="post">
        <input type="hidden" name="mode" value="make_end" />
        <select name="syoku">
        <option value="0"><?php echo $chara_syoku[0] ?></option>
        <?php
        
        if ( $in['n_1'] + $kiso_nouryoku[1] > 11 ) {
            ?>
            <option value="1"><?php echo $chara_syoku[1] ?></option>
            <?php
        }
        if ( $in['n_2'] + $kiso_nouryoku[2] > 11 && $in['n_6'] + $kiso_nouryoku[6] > 7 ) {
            ?>
            <option value="2"><?php echo $chara_syoku[2] ?></option>
            <?php
        }
        if ( $in['n_4'] + $kiso_nouryoku[4] > 11 && $in['n_5'] + $kiso_nouryoku[5] > 7 ) {
            ?>
            <option value="3"><?php echo $chara_syoku[3] ?></option>
            <?php
        }
        if ( $in['n_0'] + $kiso_nouryoku[0] > 9 && $in['n_1'] + $kiso_nouryoku[1] > 7 && $in['n_2'] + $kiso_nouryoku[2] > 7 && $in['n_3'] + $kiso_nouryoku[3] > 10 && $in['n_4'] + $kiso_nouryoku[4] > 9 && $in['n_5'] + $kiso_nouryoku[5] > 7 && $in['n_6'] + $kiso_nouryoku[6] > 7 ) {
            ?>
            <option value="4"><?php echo $chara_syoku[4] ?></option>
            <?php
        }
        if ( $in['n_1'] + $kiso_nouryoku[1] > 12 && $in['n_4'] + $kiso_nouryoku[4] > 12 ) {
            ?>
            <option value="5"><?php echo $chara_syoku[5] ?></option>
            <?php
        }
        if ( $in['n_1'] + $kiso_nouryoku[1] > 9 && $in['n_4'] + $kiso_nouryoku[4] > 11 && $in['n_5'] + $kiso_nouryoku[5] > 7 && $in['n_6'] + $kiso_nouryoku[6] > 11 ) {
            ?>
            <option value="6"><?php echo $chara_syoku[6] ?></option>
            <?php
        }
        if ( $in['n_0'] + $kiso_nouryoku[0] > 9 && $in['n_1'] + $kiso_nouryoku[1] > 13 && $in['n_3'] + $kiso_nouryoku[3] > 13 && $in['n_6'] + $kiso_nouryoku[6] > 9 ) {
            ?>
            <option value="7"><?php echo $chara_syoku[7] ?></option>
            <?php
        }
        if ( $in['n_0'] + $kiso_nouryoku[0] > 9 && $in['n_2'] + $kiso_nouryoku[2] > 10 && $in['n_3'] + $kiso_nouryoku[3] > 10 && $in['n_4'] + $kiso_nouryoku[4] > 9 && $in['n_5'] + $kiso_nouryoku[5] > 10 && $in['n_6'] + $kiso_nouryoku[6] > 7 ) {
            ?>
            <option value="8"><?php echo $chara_syoku[8] ?></option>
            <?php
        }
        if ( $in['n_1'] + $kiso_nouryoku[1] > 14 && $in['n_2'] + $kiso_nouryoku[2] > 14 && $in['n_6'] + $kiso_nouryoku[6] > 7 ) {
            ?>
            <option value="9"><?php echo $chara_syoku[9] ?></option>
            <?php
        }
        if ( $in['n_0'] + $kiso_nouryoku[0] > 11 && $in['n_1'] + $kiso_nouryoku[1] > 8 && $in['n_2'] + $kiso_nouryoku[2] > 11 && $in['n_3'] + $kiso_nouryoku[3] > 11 && $in['n_4'] + $kiso_nouryoku[4] > 8 && $in['n_5'] + $kiso_nouryoku[5] > 8 && $in['n_6'] + $kiso_nouryoku[6] > 13 ) {
            ?>
            <option value="10"><?php echo $chara_syoku[10] ?></option>
            <?php
        }
        if ( $in['n_0'] + $kiso_nouryoku[0] > 11 && $in['n_1'] + $kiso_nouryoku[1] > 10 && $in['n_3'] + $kiso_nouryoku[3] > 8 && $in['n_4'] + $kiso_nouryoku[4] > 11 && $in['n_5'] + $kiso_nouryoku[5] > 13 && $in['n_6'] + $kiso_nouryoku[6] > 7 ) {
            ?>
            <option value="11"><?php echo $chara_syoku[11] ?></option>
            <?php
        }
        if ( $in['n_0'] + $kiso_nouryoku[0] > 12 && $in['n_1'] + $kiso_nouryoku[1] > 7 && $in['n_2'] + $kiso_nouryoku[2] > 12 && $in['n_4'] + $kiso_nouryoku[4] > 9 && $in['n_5'] + $kiso_nouryoku[5] > 12 && $in['n_6'] + $kiso_nouryoku[6] > 7 ) {
            ?>
            <option value="12"><?php echo $chara_syoku[12] ?></option>
            <?php
        }
        if ( $in['n_0'] + $kiso_nouryoku[0] > 11 && $in['n_1'] + $kiso_nouryoku[1] > 9 && $in['n_2'] + $kiso_nouryoku[2] > 9 && $in['n_3'] + $kiso_nouryoku[3] > 11 && $in['n_4'] + $kiso_nouryoku[4] > 11 && $in['n_5'] + $kiso_nouryoku[5] > 11 ) {
            ?>
            <option value="13"><?php echo $chara_syoku[13] ?></option>
            <?php
        }
        ?>
        </select>
        <input type="hidden" name="new" value="new" />
        <input type="hidden" name="id" value="<?php echo $in['id'] ?>" />
        <input type="hidden" name="pass" value="<?php echo $in['pass'] ?>" />
        <input type="hidden" name="site" value="<?php echo $in['site'] ?>" />
        <input type="hidden" name="url" value="<?php echo $in['url'] ?>" />
        <input type="hidden" name="c_name" value="<?php echo $in['c_name'] ?>" />
        <input type="hidden" name="sex" value="<?php echo $in['sex'] ?>" />
        <input type="hidden" name="chara" value="<?php echo $in['chara'] ?>" />
        <input type="hidden" name="n_0" value="<?php echo $in['n_0'] ?>" />
        <input type="hidden" name="n_1" value="<?php echo $in['n_1'] ?>" />
        <input type="hidden" name="n_2" value="<?php echo $in['n_2'] ?>" />
        <input type="hidden" name="n_3" value="<?php echo $in['n_3'] ?>" />
        <input type="hidden" name="n_4" value="<?php echo $in['n_4'] ?>" />
        <input type="hidden" name="n_5" value="<?php echo $in['n_5'] ?>" />
        <input type="hidden" name="n_6" value="<?php echo $in['n_6'] ?>" />
        <input type="submit" value="この職業でOK" />
        </form>
        <?php
        show_footer();
    } else {
        $data = chara_regist_new( $in );
        
        if ( $data['sex'] == 1 ) {
            $esex = '男';
        } else {
            $esex = '女';
        }
        $next_ex = $data['lv'] * $lv_up;
        show_header();
        ?>
        <h1>登録完了画面</h1>
        以下の内容で登録が完了しました。
        <hr size="0">
        <table border="1">
            <tr>
                <td class="b1">ホームページ</td>
                <td colspan="4"><a href="<?php echo $data['url'] ?>"><?php echo $data['site'] ?></a></td>
            </tr>
            <tr>
                <td rowspan="8" align="center"><img src="<?php echo $img_path ?>/<?php echo $chara_img[ $data['chara'] ] ?>"></td>
                <td class="b1">なまえ</td>
                <td><?php echo $data['name'] ?></td>
                <td class="b1">性別</td>
                <td><?php echo $esex ?></td>
            </tr>
            <tr>
                <td class="b1">職業</td>
                <td><?php echo $chara_syoku[ $data['syoku'] ] ?></td>
                <td class="b1">お金</td>
                <td><?php echo $data['gold'] ?></td>
            </tr>
            <tr>
                <td class="b1">レベル</td>
                <td><?php echo $data['lv'] ?></td>
                <td class="b1">経験値</td>
                <td><?php echo $data['ex'] ?>/<?php echo $next_ex ?></td>
            </tr>
            <tr>
                <td class="b1">HP</td>
                <td><?php echo $data['hp'] ?></td>
                <td class="b1"></td>
                <td></td>
            </tr>
            <tr>
                <td class="b1">力</td>
                <td><?php echo $data['n_0'] ?></td>
                <td class="b1">知能\</td>
                <td><?php echo $data['n_1'] ?></td>
            </tr>
            <tr>
                <td class="b1">信仰心</td>
                <td><?php echo $data['n_2'] ?></td>
                <td class="b1">生命力</td>
                <td><?php echo $data['n_3'] ?></td>
            </tr>
            <tr>
                <td class="b1">器用さ</td>
                <td><?php echo $data['n_4'] ?></td>
                <td class="b1">速さ</td>
                <td><?php echo $data['n_5'] ?></td>
            </tr>
            <tr>
                <td class="b1">魅力</td>
                <td><?php echo $data['n_6'] ?></td>
                <td class="b1">カルマ</td>
                <td><?php echo $data['lp'] ?></td>
            </tr>
        </table>
        <form action="<?php echo $script ?>" method="post">
            <input type="hidden" name="mode" value="log_in" />
            <input type="hidden" name="id" value="<?php echo $data['id'] ?>" />
            <input type="hidden" name="pass" value="<?php echo $data['pass'] ?>" />
            <input type="submit" value="ステータス画面へ">
        </form>
        <?php
        show_footer();
    }
}

/**
 * @param array $in
 * @return mixed
 */
function chara_regist_new( $in ) {
    $chara_file = get_chara_data_path( $in['id'] );
    $kiso_nouryoku = read_config_option( 'kiso_nouryoku' );
    $kiso_hp = read_config_option( 'kiso_hp' );

    /**
     * 念のため、もう一回ID重複チェック
     */
    if ( check_dup_id( $in['id'] ) == false ) {
        error_page( 'そのIDはすでに登録されています' );
    }
    $data = $in;
    $data['name'] = $data['c_name'];
    unset( $data['c_name'] );
    $data['lp'] = rand( 0, 15 );
    $data['hp'] = ( $in['n_3'] + $kiso_nouryoku[3] ) + rand( 0, $data['lp'] ) + $kiso_hp;
    $data['maxhp'] = $data['hp'];
    $data['ex'] = 0;
    $data['lv'] = 1;
    $data['gold'] = 0;
    $data['total'] = 0;
    $data['kati'] = 0;
    $data['waza'] = '';
    $data['item'] = '';
    $data['mons'] = 0;
    $data['host'] = '';
    $data['date'] = time();
    $data['n_0'] += $kiso_nouryoku[0];
    $data['n_1'] += $kiso_nouryoku[1];
    $data['n_2'] += $kiso_nouryoku[2];
    $data['n_3'] += $kiso_nouryoku[3];
    $data['n_4'] += $kiso_nouryoku[4];
    $data['n_5'] += $kiso_nouryoku[5];
    $data['n_6'] += $kiso_nouryoku[6];
    $text = convert_chara_data_array2scalar( $data );
    file_put_contents( $chara_file, $text );
    return $data;
}

function load_all_chara_data() {
    $chara_path = read_config_option( "chara_path" );
    $chara_ext = read_config_option( "chara_ext" );
    $charas = scandir( $chara_path );
    $ret = array();
    foreach ( $charas as $filename ) {
        if ( preg_match( "/(.+?).$chara_ext$/", $filename, $matches ) == false ) {
            continue;
        }
        $chara_data = load_chara_data( $matches[1] );
        $ret[ $chara_data["id"] ] = $chara_data;
    }
    return $ret;
}

function load_chara_data( $id ) {
    $chara_data = get_chara_data_path( $id );
    if ( file_exists( $chara_data ) == false ) {
        return null;
    }
    $text = file_get_contents( $chara_data );
    $data = convert_chara_data_scalar2array( $text );
    return $data;
}

function load_winner_data( $path = "" ) {
    if ( $path == "" ) {
        $path = read_config_option( "winner_file" );
    }
    if ( file_exists( $path ) == false ) {
        return null;
    }
    $text = file_get_contents( $path );
    $data = convert_chara_data_scalar2array( $text );
    return $data;
}

function login_chara_data( $in ) {
    $data = load_chara_data( $in["id"] );
    if ( $data["pass"] != $in["pass"] ) {
        error_page( "IDかパスワードが間違っています。" );
    }
    load_stamina( $data );
    use_stamina( $data, 0 );
    save_stamina( $data );
    load_battlepoint( $data );
    use_battlepoint( $data, 0 );
    save_battlepoint( $data );
    return $data;
}

function save_chara_data( $data ) {
    $text = convert_chara_data_array2scalar( $data );
    $path = get_chara_data_path( $data["id"] );
    file_put_contents( $path, $text );
    if ( array_key_exists( "stamina", $data ) ) {
        save_stamina( $data );
    }
    if ( array_key_exists( "battlepoint", $data ) ) {
        save_battlepoint( $data );
    }
}

function get_chara_data_path ( $id ) {
    $chara_path = read_config_option( 'chara_path' );
    $chara_ext = read_config_option( 'chara_ext' );
    $chara_file = cat_file( $chara_path, $id. '.'. $chara_ext );
    return $chara_file;
}

/**
 * @param array $data
 * @return string
 */
function convert_chara_data_array2scalar( $data ) {
    $text = implode( "<>", array(
            $data['id'], $data['pass'], $data['site'],
            $data['url'], $data['name'], $data['sex'],
            $data['chara'], $data['n_0'], $data['n_1'],
            $data['n_2'], $data['n_3'], $data['n_4'],
            $data['n_5'], $data['n_6'], $data['syoku'],
            $data['hp'], $data['maxhp'], $data['ex'],
            $data['lv'], $data['gold'], $data['lp'],
            $data['total'], $data['kati'], $data['waza'],
            $data['item'], $data['mons'], $data['host'],
            $data['date'], '' )
    );
    return $text;
}

/**
 * @param $text
 * @return array
 */
function convert_chara_data_scalar2array( $text ) {
    $tmp = explode( "<>", $text );
    $data = array();
    $data['id'] = $tmp[0];
    $data['pass'] = $tmp[1];
    $data['site'] = $tmp[2];
    $data['url'] = $tmp[3];
    $data['name'] = $tmp[4];
    $data['sex'] = $tmp[5];
    $data['chara'] = $tmp[6];
    $data['n_0'] = $tmp[7];
    $data['n_1'] = $tmp[8];
    $data['n_2'] = $tmp[9];
    $data['n_3'] = $tmp[10];
    $data['n_4'] = $tmp[11];
    $data['n_5'] = $tmp[12];
    $data['n_6'] = $tmp[13];
    $data['syoku'] = $tmp[14];
    $data['hp'] = $tmp[15];
    $data['maxhp'] = $tmp[16];
    $data['ex'] = $tmp[17];
    $data['lv'] = $tmp[18];
    $data['gold'] = $tmp[19];
    $data['lp'] = $tmp[20];
    $data['total'] = $tmp[21];
    $data['kati'] = $tmp[22];
    $data['waza'] = $tmp[23];
    $data['item'] = $tmp[24];
    $data['mons'] = $tmp[25];
    $data['host'] = $tmp[26];
    $data['date'] = $tmp[27];
    return $data;
}

function get_next_ex( $data ) {
    $lv_up = read_config_option( "lv_up" );
    $next_ex = $data["lv"] * $lv_up;
    return $next_ex;
}

function get_sex_name( $data ) {
    if ( $data["sex"] == 1 ) {
        return '男';
    }
    return '女';
}

function get_class_name( $data ) {
    $class = "";
    $FIGHTER = read_config_option( "FIGHTER" );
    $MAGE = read_config_option( "MAGE" );
    $PRIEST = read_config_option( "PRIEST" );
    $THIEF = read_config_option( "THIEF" );
    $RANGER = read_config_option( "RANGER" );
    $ALCHEMIST = read_config_option( "ALCHEMIST" );
    $BARD = read_config_option( "BARD" );
    $PSIONIC = read_config_option( "PSIONIC" );
    $VALKYRIE = read_config_option( "VALKYRIE" );
    $BISHOP = read_config_option( "BISHOP" );
    $LORD = read_config_option( "LORD" );
    $SAMURAI = read_config_option( "SAMURAI" );
    $MONK = read_config_option( "MONK" );
    $NINJA = read_config_option( "NINJA" );
    
    if ( $data["syoku"] == 0 ) {
        if ( $data["lv"] > 42 ) {
            $class = $FIGHTER[6];
        } elseif ( $data["lv"] < 7 ) {
            $class = $FIGHTER[0];
        } elseif ( $data["lv"] < 14 ) {
            $class = $FIGHTER[1];
        } elseif ( $data["lv"] < 21 ) {
            $class = $FIGHTER[2];
        } elseif ( $data["lv"] < 28 ) {
            $class = $FIGHTER[3];
        } elseif ( $data["lv"] < 35 ) {
            $class = $FIGHTER[4];
        } elseif ( $data["lv"] < 42 ) {
            $class = $FIGHTER[5];
        }
    } elseif ( $data["syoku"] == 1 ) {
		if ( $data["lv"] > 42 ) {
            $class = $MAGE[6];
        } elseif ( $data["lv"] < 7 ) {
            $class = $MAGE[0];
		} elseif ( $data["lv"] < 14 ) {
            $class = $MAGE[1];
		} elseif ( $data["lv"] < 21 ) {
            $class = $MAGE[2];
		} elseif ( $data["lv"] < 28 ) {
            $class = $MAGE[3];
		} elseif ( $data["lv"] < 35 ) {
            $class = $MAGE[4];
		} elseif ( $data["lv"] < 42 ) {  
            $class = $MAGE[5];
		}
	} elseif ( $data["syoku"] == 2 ) {
		if ( $data["lv"] > 42 ) {
            $class = $PRIEST[6];
        } elseif ( $data["lv"] < 7 ) {
            $class = $PRIEST[0];
		} elseif ( $data["lv"] < 14 ) {
            $class = $PRIEST[1];
		} elseif ( $data["lv"] < 21 ) {
            $class = $PRIEST[2];
		} elseif ( $data["lv"] < 28 ) {
            $class = $PRIEST[3];
		} elseif ( $data["lv"] < 35 ) {
            $class = $PRIEST[4];
		} elseif ( $data["lv"] < 42 ) {
            $class = $PRIEST[5];
		}
	} elseif ( $data["syoku"] == 3 ) {
		if ( $data["lv"] > 42 ) {
            $class = $THIEF[6];
        } elseif ( $data["lv"] < 7 ) {
            $class = $THIEF[0];
		} elseif ( $data["lv"] < 14 ) {
            $class = $THIEF[1];
		} elseif ( $data["lv"] < 21 ) {
            $class = $THIEF[2];
		} elseif ( $data["lv"] < 28 ) {
            $class = $THIEF[3];
		} elseif ( $data["lv"] < 35 ) {
            $class = $THIEF[4];
		} elseif ( $data["lv"] < 42 ) {
            $class = $THIEF[5];
		}
	} elseif ( $data["syoku"] == 4 ) {
		if ( $data["lv"] > 42) {
            $class = $RANGER[6];
        } elseif ( $data["lv"] < 7 ) {
            $class = $RANGER[0];
		} elseif ( $data["lv"] < 14 ) {
            $class = $RANGER[1];
		} elseif ( $data["lv"] < 21 ) {
            $class = $RANGER[2];
		} elseif ( $data["lv"] < 28 ) {
            $class = $RANGER[3];
		} elseif ( $data["lv"] < 35 ) {
            $class = $RANGER[4];
		} elseif ( $data["lv"] < 42 ) {
            $class = $RANGER[5];
		}
	} elseif ( $data["syoku"] == 5 ) {
		if ( $data["lv"] > 42) {
            $class = $ALCHEMIST[6];
        } elseif ( $data["lv"] < 7 ) {
            $class = $ALCHEMIST[0];
		} elseif ( $data["lv"] < 14 ) {
            $class = $ALCHEMIST[1];
		} elseif ( $data["lv"] < 21 ) {
            $class = $ALCHEMIST[2];
		} elseif ( $data["lv"] < 28 ) {
            $class = $ALCHEMIST[3];
		} elseif ( $data["lv"] < 35 ) {
            $class = $ALCHEMIST[4];
		} elseif ( $data["lv"] < 42 ) {
            $class = $ALCHEMIST[5];
		}
	} elseif ( $data["syoku"] == 6 ) {
		if ( $data["lv"] > 42) {
            $class = $BARD[6];
        } elseif ( $data["lv"] < 7 ) {
            $class = $BARD[0];
		} elseif ( $data["lv"] < 14 ) {
            $class = $BARD[1];
		} elseif ( $data["lv"] < 21 ) {
            $class = $BARD[2];
		} elseif ( $data["lv"] < 28 ) {
            $class = $BARD[3];
		} elseif ( $data["lv"] < 35 ) {
            $class = $BARD[4];
		} elseif ( $data["lv"] < 42 ) {
            $class = $BARD[5];
		}
	} elseif ( $data["syoku"] == 7 ) {
		if ( $data["lv"] > 42) {
            $class = $PSIONIC[6];
        } elseif ( $data["lv"] < 7 ) {
            $class = $PSIONIC[0];
		} elseif ( $data["lv"] < 14 ) {
            $class = $PSIONIC[1];
		} elseif ( $data["lv"] < 21 ) {
            $class = $PSIONIC[2];
		} elseif ( $data["lv"] < 28 ) {
            $class = $PSIONIC[3];
		} elseif ( $data["lv"] < 35 ) {
            $class = $PSIONIC[4];
		} elseif ( $data["lv"] < 42 ) {
            $class = $PSIONIC[5];
		}
	} elseif ( $data["syoku"] == 8 ) {
		if( $data["lv"] > 42) {
            $class = $VALKYRIE[6];
        } elseif ( $data["lv"] < 7 ) {
            $class = $VALKYRIE[0];
		} elseif ( $data["lv"] < 14 ) {
            $class = $VALKYRIE[1];
		} elseif ( $data["lv"] < 21 ) {
            $class = $VALKYRIE[2];
		} elseif ( $data["lv"] < 28 ) {
            $class = $VALKYRIE[3];
		} elseif ( $data["lv"] < 35 ) {
            $class = $VALKYRIE[4];
		} elseif ( $data["lv"] < 42 ) {
            $class = $VALKYRIE[5];
		}
	} elseif ( $data["syoku"] == 9 ) {
		if ( $data["lv"] > 42) {
            $class = $BISHOP[6];
        } elseif ( $data["lv"] < 7 ) {
            $class = $BISHOP[0];
		} elseif ( $data["lv"] < 14 ) {
            $class = $BISHOP[1];
		} elseif ( $data["lv"] < 21 ) {
            $class = $BISHOP[2];
		} elseif ( $data["lv"] < 28 ) {
            $class = $BISHOP[3];
		} elseif ( $data["lv"] < 35 ) {
            $class = $BISHOP[4];
		} elseif ( $data["lv"] < 42 ) {
            $class = $BISHOP[5];
		}
	} elseif ( $data["syoku"] == 10 ) {
		if( $data["lv"] > 42) {
            $class = $LORD[6];
        } elseif ( $data["lv"] < 7 ) {
            $class = $LORD[0];
		} elseif ( $data["lv"] < 14 ) {
            $class = $LORD[1];
		} elseif ( $data["lv"] < 21 ) {
            $class = $LORD[2];
		} elseif ( $data["lv"] < 28 ) {
            $class = $LORD[3];
		} elseif ( $data["lv"] < 35 ) {
            $class = $LORD[4];
		} elseif ( $data["lv"] < 42 ) {
            $class = $LORD[5];
		}
	} elseif ( $data["syoku"] == 11 ) {
		if ( $data["lv"] > 42) {
            $class = $SAMURAI[6];
        } elseif ( $data["lv"] < 7 ) {
            $class = $SAMURAI[0];
		} elseif ( $data["lv"] < 14 ) {
            $class = $SAMURAI[1];
		} elseif ( $data["lv"] < 21 ) {
            $class = $SAMURAI[2];
		} elseif ( $data["lv"] < 28 ) {
            $class = $SAMURAI[3];
		} elseif ( $data["lv"] < 35 ) {
            $class = $SAMURAI[4];
		} elseif ( $data["lv"] < 42 ) {
            $class = $SAMURAI[5];
		}
	} elseif ( $data["syoku"] == 12 ) {
		if($data["lv"] > 42) {
            $class = $MONK[6];
        } elseif ( $data["lv"] < 7 ) {
            $class = $MONK[0];
		} elseif ( $data["lv"] < 14 ) {
            $class = $MONK[1];
		} elseif ( $data["lv"] < 21 ) {
            $class = $MONK[2];
		} elseif ( $data["lv"] < 28 ) {
            $class = $MONK[3];
		} elseif ( $data["lv"] < 35 ) {
            $class = $MONK[4];
		} elseif ( $data["lv"] < 42 ) {
            $class = $MONK[5];
		}
	} elseif ( $data["syoku"] == 13 ) {
		if ( $data["lv"] > 42) {
            $class = $NINJA[6];
        } elseif ( $data["lv"] < 7 ) {
            $class = $NINJA[0];
		} elseif ( $data["lv"] < 14 ) {
            $class = $NINJA[1];
		} elseif ( $data["lv"] < 21 ) {
            $class = $NINJA[2];
		} elseif ( $data["lv"] < 28 ) {
            $class = $NINJA[3];
		} elseif ( $data["lv"] < 35 ) {
            $class = $NINJA[4];
		} elseif ( $data["lv"] < 42 ) {
            $class = $NINJA[5];
		}
	}
    return $class;
}