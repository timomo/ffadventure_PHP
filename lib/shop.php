<?php
/**
 * Created by IntelliJ IDEA.
 * User: timomo
 * Date: 15/01/07
 * Time: 13:02
 */

function weapon_shop( $in ) {
    $chara = load_chara_data( $_SESSION["id"] );
    $items = load_all_item_data();
    $script = read_config_option( "script" );
    
    show_header();
    
    ?>
    <h1>武器屋</h1>
    <hr size="0">
    <form action="<?php echo $script ?>>" method="post">
        買いたいアイテムをチェックしてください。
        <table border="1">
            <thead>
                <tr>
                    <th></th>
                    <th>No.</th>
                    <th>名前</th>
                    <th>威力</th>
                    <th>価格</th>
                </tr>
            </thead>
            <tbody>
            <?php
            foreach ( $items as $item ) {
                ?>
                <tr>
                    <td>
                        <input type="radio" name="item_no" value="<?php echo $item["no"] ?>" />
                    </td>
                    <td align="right">
                        <?php echo $item["no"] ?>
                    </td>
                    <td>
                        <?php echo $item["name"] ?>
                    </td>
                    <td align="center">
                        <?php echo $item["dmg"] ?>
                    </td>
                    <td align="center">
                        <?php echo $item["gold"] ?>
                    </td>
                </tr>
                <?php
            }
            ?>
            </tbody>
        </table>
        <div>
            <input type="hidden" name="id" value="<?php echo $chara["id"] ?>" />
            <input type="hidden" name="pass" value="<?php echo $chara["pass"] ?>" />
            <input type="hidden" name="mode" value="item_buy" />
            <input type="submit" value="アイテムを買う" />
        </div>
    </form>
    <?php
    
    show_footer();
}