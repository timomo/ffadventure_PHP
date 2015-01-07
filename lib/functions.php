<?php
/**
 * Created by IntelliJ IDEA.
 * User: timomo
 * Date: 14/12/30
 * Time: 20:22
 */

/**
 * @param string $config_name
 * @return mixed
 */
function read_config_option( $config_name ) {
    global $config;
    if ( array_key_exists( $config_name, $config ) == false ) {
        return null;
    }
    return $config[ $config_name ];
}

/**
 * @param int $time
 * @return string
 */
function get_time( $time = null ) {
    $dt = new DateTime();
    if ( is_null( $time ) == false ) {
        $dt->setTimestamp( $time );
    }
    $tz = new DateTimeZone( 'Asia/Tokyo' );
    $dt->setTimezone( $tz );
    $gettime = $dt->format( 'Y-m-d H:i' );
    return $gettime;
}

function file_lock() {

}

function file_unlock() {

}

function error_page( $error ) {
    show_header();
    if ( is_array( $error ) == false ) {
        $error = array( $error );
    }
    ?>
    <hr width="400" />
    <h3>ERROR !</h3>
    <?php
    foreach ( $error as $e ) {
    ?>
    <p><span style="color: #ff0000; font-weight: bold;"><?php echo $e ?></span></p>
    <?php
    }
    ?>
    <hr size="400" />
    </body>
    </html>
    <?php
    exit;
}

/**
 * @param mixed $tmp
 */
function forward( $tmp ) {
    if ( array_key_exists( 'FFADV_COMMAND_MAP', $GLOBALS ) == false ) {
        set_command_map();
    }

    $mode = $tmp['mode'];
    $func = $GLOBALS['FFADV_COMMAND_MAP'][ $mode ];

    if ( function_exists( $func ) ) {
        call_user_func( $func, $tmp );
    } else {
        error_page( '指定されたページはありません' );
    }
}

/**
 * グローバル変数にフォワード用の連想配列を定義する
 *
 * @return void
 */
function set_command_map() {
    $GLOBALS['FFADV_COMMAND_MAP'] = array(
        '' => 'html_top',
        'log_in' => 'log_in',
        'chara_make' => 'chara_make',
        'make_end' => 'chara_make_end',
        'regist' => 'regist',
        'battle' => 'battle_duel',
        'tensyoku' => 'tensyoku',
        'monster' => 'battle_monster',
        'ranking' => 'ranking',
        'yado' => 'yado',
        'message' => 'message',
        'item_shop' => 'item_shop',
        'item_buy' => 'item_buy'
    );
}

/**
 * @param string $path
 * @return array
 */
function read_file( $path ) {
    if ( file_exists( $path ) == false ) {
        return array();
    }
    $contents = file( $path, FILE_USE_INCLUDE_PATH | FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES );
    return $contents;
}

function decode_param() {
    $IN = array();
    if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
        if ( $_SERVER['CONTENT_LENGTH'] > 51200 ) {
            error_page( '投稿量が大きすぎます' );
        }
        foreach ( $_POST as $key => $value ) {
            $IN[ $key ] = $value;
        }
    }
    foreach ( $_GET as $key => $value ) {
        $IN[ $key ] = $value;
    }
    return $IN;
}

/**
 * キャラクターの重複チェック
 * 
 * @param string $id
 * @return bool
 */
function check_dup_id ( $id ) {
    $chara_file = get_chara_data_path( $id );
    if ( file_exists( $chara_file ) ) {
        return false;
    }
    return true;
}
