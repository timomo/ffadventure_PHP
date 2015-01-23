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
    $chara_syoku = read_config_option( "chara_syoku" );
    $limit = read_config_option( "limit" );
    $ima = time();
    
    $ranking = usort( $ranking, "ranking_compare" );
    
    show_header();
    ?>
    <h1>英雄たちの記録</h1>
    <hr size="0" />
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
    $i = 0;
    foreach ( $ranking as $id => $data ) {
        if ( $i > $rank_top ) {
            break;
        }
        $date = $data["date"] + ( 60 * 60 * 24 * $limit );
        $niti = $date - $ima;
        $niti = (int)( $niti / ( 60 * 60 * 24 ) );
        ?>
        <tr>
            <td align="center"><?php echo $i ?></td>
            <td><?php echo $data["name"] ?></td>
            <td><?php echo $chara_syoku[ $data["syoku"] ] ?></td>
            <td><a href="<?php echo $data["url"] ?>" target="_blank"><?php echo $data["site"] ?></a></td>
            <td><?php echo $data["lv"] ?></td>
            <td><?php echo $data["ex"] ?></td>
            <td align="center"><?php echo $data["hp"] ?>/<?php echo $data["maxhp"] ?></td>
            <td align="center"><?php echo $data["n_0"] ?></td>
            <td align="center"><?php echo $niti ?></td>
        </tr>
        <?php
        $i++;
    }
    ?>
    </table>
    <?php
    show_footer();
}

function ranking_compare( $a, $b ) {
    if ( $b["total"] > $a["total"] ) {
        return 1;
    }
    if ( $b["kati"] > $a["kati"] ) {
        return 1;
    }
    if ( $b["total"] < $a["total"] ) {
        return -1;
    }
    if ( $b["kati"] < $a["kati"] ) {
        return -1;
    }
    return 0;
}