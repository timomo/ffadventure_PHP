<?php
/**
 * Created by IntelliJ IDEA.
 * User: timomo
 * Date: 14/12/30
 * Time: 20:25
 */

include( dirname( __FILE__ ). '/config.php' );

$config = array();

$names_array = array(
    'ver',
    'mente',
    'script',
    'script_url',
    'chara_path',
    'chara_ext',
    'recode_file',
    'winner_file',
    'message_file',
    'syoku_file',
    'monster_file',
    'item_file',
    'syoku_html',
    'title_img',
    'mark',
    'img_path',
    'lockkey',
    'lockfile',
    'home_title',
    'homepage',
    'kanri_message',
    'chara_stop',
    'b_time',
    'm_time',
    'chara_name',
    'chara_img',
    'chara_syoku',
    'kiso_nouryoku',
    'FIGHTER',
    'MAGE',
    'PRIEST',
    'THIEF',
    'RANGER',
    'ALCHEMIST',
    'BARD',
    'PSIONIC',
    'VALKYRIE',
    'BISHOP',
    'LORD',
    'SAMURAI',
    'MONK',
    'NINJA',
    'hissatu',
    'main_title',
    'b_size',
    'backgif',
    'bgcolor',
    'text',
    'link',
    'vlink',
    'alink',
    'lv_up',
    'turn',
    'limit',
    'chanp_milit',
    'sentou_limit',
    'rank_top',
    'yado_dai',
    'refresh',
    'level_sa',
    'waza_ritu',
    'kiso_hp',
    'kiso_exp',
    'max',
    'max_gyo'
);

foreach ( $names_array as $key ) {
    $config[ $key ] = $GLOBALS[ $key ];
}

function cat_file() {
    $args = func_get_args();
    $path = implode( DIRECTORY_SEPARATOR, $args );
    return $path;
}

function cat_dir() {
    $args = func_get_args();
    $path = implode( DIRECTORY_SEPARATOR, $args );
    return $path;
}

function autoload_ffadv_lib() {
    $libdir = cat_dir( dirname( __FILE__ ), "..", "lib" );
    $dirs = scandir( $libdir );
    foreach ( $dirs as $filename ) {
        if ( preg_match( "/.php$/", $filename ) ) {
            require_once cat_file( $libdir, $filename );
        }
    }
}

autoload_ffadv_lib();