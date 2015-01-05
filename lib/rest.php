<?php
/**
 * Created by IntelliJ IDEA.
 * User: timomo
 * Date: 15/01/05
 * Time: 17:44
 */

function yado( $in ) {
    $chara = login_chara_data( $in );
    $yado_gold = calc_yado_daikin( $chara );
    $script = read_config_option( "script" );
    
    if ( $chara["gold"] < $yado_gold ) {
        error_page( "お金が足りません" );
    }
    
    $chara["hp"] = $chara["maxhp"];

    show_header();
    
    ?>
    <h1>体力を回復しました</h1>
    <hr size="0" />
    <form action="<?php echo $script ?>" method="post">
        <input type="hidden" name="mode" value="log_in" />
        <input type="hidden" name="id" value="<?php echo $chara["id"] ?>" />
        <input type="hidden" name="pass" value="<?php echo $chara["pass"] ?>" />
        <input type="submit" value="ステータス画面へ" />
    </form>
    <?php
    
    show_footer();
}

function calc_yado_daikin( $data ) {
    $yado_dai = read_config_option( 'yado_dai' );
    $yado_gold = $yado_dai * $data["lv"];
    if ( $data["gold"] <= $yado_dai ) {
        $yado_gold = $data["gold"];
    }
    return $yado_gold;
}