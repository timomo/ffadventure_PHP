<?php
/**
 * Created by IntelliJ IDEA.
 * User: tomoyuki
 * Date: 15/01/19
 * Time: 16:34
 */

/**
 * @param array $in
 */
function send_message( $in ) {
    if ( $in["mes"] == "" ) {
        error_page( "メッセージが記入されていません" );
    }
    if ( $in["mesid"] == "" ) {
        error_page( "相手が指定されていません" );
    }
    
    
}