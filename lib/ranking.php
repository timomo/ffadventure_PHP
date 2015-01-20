<?php
/**
 * Created by IntelliJ IDEA.
 * User: timomo
 * Date: 15/01/20
 * Time: 11:41
 */
function ranking( $in ) {
    $charas = load_all_chara_data();
    $num_chara = count( $charas );
    $rank_top = read_config_option( "rank_top" );
    
    foreach( $charas as $id => $data ) {
        var_dump( $data );
        
    }
    
    show_header();
    ?>
    <h1>英雄たちの記録</h1><hr size=0>
    現在登録されているキャラクター<b><?php echo $num_chara ?></b>人中レベルTOP<b><?php echo $rank_top ?></b>を表示しています。
    <p>
    <table border="1">
        <tr>
            <th></th>
            <th>なまえ</th>
            <th>職業</th>
            <th>ホームページ</th>
            <th>レベル</th>
            <th>経験値</th>
            <th>HP</th>
            <th>力</th>
            <th>削除まで</th>
        </tr>
    <?php
    show_footer();
}