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
    
    $chara = load_chara_data( $_SESSION["id"] );
    $file_message = read_config_option( "message_file" );
    $max_message = read_config_option( "max" );
    $to = load_chara_data( $in["mesid"] );
    $script = read_config_option( "script" );
    
    $messages = file( $file_message );
    $line = implode( "<>", array( $to["id"], $chara["id"], $chara["name"], $in["mes"], $to["name"], time(), "" ) );
    
    array_unshift( $messages, $line );
    
    if ( count( $messages ) > $max_message ) {
        array_pop( $messages );
    }
    
    var_dump( $messages );
    
    file_put_contents( $file_message, implode( "¥n", $messages ) );

    ?>
    <h1><?php echo $to["name"] ?>さんへメッセージを送りました。</h1>
    <hr size="0" />
    <form action="<?php echo $script ?>" method="post">
        <input type="hidden" name="mode" value="" />
        <input type="submit" value="ステータス画面へ" />
    </form>
    <?php
}