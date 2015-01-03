<?php
/**
 * Created by IntelliJ IDEA.
 * User: timomo
 * Date: 15/01/03
 * Time: 18:20
 */

/**
 * @return void
 */
function html_top() {
    $c_id = 'test1';
    $c_pass = 'test2';
    $script = read_config_option( 'script' );
    $homepage = read_config_option( 'homepage' );
    $title_img = read_config_option( 'title_img' );
    $home_title = read_config_option( 'home_title' );
    $kanri_message = read_config_option( 'kanri_message' );
    $syoku_html = read_config_option( 'syoku_html' );
    $record = read_file( read_config_option( 'recode_file' ) );
    $img_path = read_config_option( 'img_path' );
    $chara_img = read_config_option( 'chara_img' );
    $mark = read_config_option( 'mark' );
    $limit = read_config_option( '$limit' );
    $b_time = read_config_option( '$b_time' );
    $wchara = 0;
    
    if ( isset( $record[0] ) ) {
        list( $rcount, $rname, $rsite, $rurl ) = @explode( '<>', $record[0] );
    } else {
        list( $rcount, $rname, $rsite, $rurl ) = array( null, null, null, null );
    }
    ?>
<form action="<?php echo $script ?>" method="post">
<input type="hidden" name="mode" value="log_in" />
<table border="0" width="100%">
<tr>
<td><img src="<?php echo $img_path ?>/<?php echo $title_img ?>"></td>
<td align="right" valign="top">
	<table border=1>
	<tr>
	<td align=center colspan=5 class=b2>キャラクターを作成済みの方はこちらから</td>
	</tr>
	<tr>
	<td class=b1>I D</td>
	<td><input type="text" size="10" name="id" value="<?php echo $c_id ?>"></td>
	<td class=b1>パスワード</td>
	<td><input type="password" size="10" name="pass" value="<?php echo $c_pass ?>"></td>
	<td><input type="submit" value="ログイン"></td>
	</tr>
	</table>
</td>
</tr>
</table>
<hr size=0>
<small>
/ <a href="<?php echo $homepage ?>"><?php echo $home_title ?></a> / <a href="<?php echo $script ?>?mode=item_shop">武器屋</a> / <a href="<?php echo $script ?>?mode=ranking">英雄たちの記録</a> / <a href="<?php echo $syoku_html ?>">各職業に必要な特性値</a> / <a href="https://github.com/timomo/ffadventure_PHP/issues">アイデア募集</a> /
</form>
    <?php echo $kanri_message ?>
<p>
    現在の連勝記録は、<?php echo $rname ?>さんの「<a href="<?php echo $rurl ?>" target="_blan"><span style="color:#6666BB; font-size: 3"><?php echo $rsite ?></span></a>」、<?php echo $rcount ?>連勝です。新記録を出したサイト名の横には、<img src="<?php echo $img_path ?>/<?php echo $mark ?>" />マークがつきます。
<table border=0 width='100%'>
<tr>
<td width="500" valign="top">
	<table border=1 width="100%">
	<tr>
	<td colspan=5 align="center" class="b2"><span color="#FFFFFF">$wcount連勝中</span></td>
    </tr>
	<tr>
	<td align="center" class="b1">ホームページ</td>
	<td colspan="4"><a href="http://$wurl"><b>$wsite</b></a>
    EOM
	if($rurl eq "$wurl") {
        print "<IMG SRC="$mark" border=0>\n";
    }
	print <<"EOM";
	</td>
	</tr>
	<tr>
	<td align="center" rowspan="8"><img src="<?php echo $img_path ?>/<?php echo $chara_img[ $wchara ] ?>"><p>勝率：$ritu\%<br>武器：$wi_name</td>
	<td align="center" class="b1">なまえ</td><td><b>$wname</b></td>
	<td align="center" class="b1">性別</td><td><b>$esex</b></td>
	</tr>
	<tr>
	<td align="center" class="b1">職業</td><td><b>$chara_syoku[$wsyoku]</b></td>
	<td align="center" class="b1">クラス</td><td><b>$class</b></td>
	</tr>
	<tr>
	<td align="center" class="b1">レベル</td><td><b>$wlv</b></td>
	<td align="center" class="b1">経験値</td><td><b>$wex/$next_ex</b></td>
	</tr>
	<tr>
	<td align="center" class="b1">お金</td><td><b>$wgold</b></td>
	<td align="center" class="b1">HP</td><td><b>$whp\/$wmaxhp</b></td>
	</tr>
	<tr>
	<td align="center" class="b1">力</td><td><b>$wn_0</b></td>
	<td align="center" class="b1">知能\</td><td><b>$wn_1</b></td>
	</tr>
	<tr>
	<td align="center" class="b1">信仰心</td><td><b>$wn_2</b></td>
	<td align="center" class="b1">生命力</td><td><b>$wn_3</b></td>
	</tr>
	<tr>
	<td align="center" class="b1">器用さ</td><td><b>$wn_4</b></td>
	<td align="center" class="b1">速さ</td><td><b>$wn_5</b></td>
	</tr>
	<tr>
	<td align="center" class="b1">魅力</td><td><b>$wn_6</b></td>
	<td align="center" class="b1">カルマ</td><td><b>$wlp</b></td>
	</tr>
	<tr>
	<td colspan=5 align="center">$lname の <A HREF=\"http\:\/\/$lurl\" TARGET=\"_blank\">$lsite</A> に勝利！！</td>
	</tr>
	</table>
</td>
<td valign="top" class="small">
[<B><span style="color: #FF9933;"><?php echo $main_title ?> の遊び方</span></B>]
    <ol>
<li>まず、「新規キャラクター登録」ボタンを押して、キャラクターを作成します。
<li>キャラクターの作成が完了したら、このページの右上にあるところからログインして、あなた専用のステータス画面に入ります。
<li>そこであなたの行動を選択することができます。
<li>一度キャラクターを作成したら、右上のところからログインして遊びます。新規にキャラクターを作れるのは、一人に一つのキャラクターのみです。
<li>これは、HPバトラーではなく、キャラバトラーです。キャラクターを育てていくゲームです。
<li>能\力を振り分けることができキャラクターの能\力をご自分で決めることができます。(ここで決めた能\力はごくまれにしか上昇しないので、慎重に)
<lik
><b><?php echo $limit ?>日</b>以上闘わなければ、キャラクターのデータが削除されます。
<LI>一度戦闘すると<b><?php echo $b_time ?></b>秒経過しないと再び戦闘できません。
</ol>
    [<B><span style="color: #FF9933;">新規キャラクタ作成</span></B>]<BR>
    下のボタンを押して、あなたのキャラクターを作成します。
<form action="<?php echo $script ?>" method="post">
<input type="hidden" name="mode" value="chara_make" />
<input type="submit" value="新規キャラクター作成" />
</FORM>
</td>
</tr>
</table>
</small>
    <?php
    
    
}