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
    $c_id = 'test';
    $c_pass = 'test';
    $script = read_config_option( 'script' );
    $homepage = read_config_option( 'homepage' );
    $title_img = read_config_option( 'title_img' );
    $home_title = read_config_option( 'home_title' );
    $main_title = read_config_option( 'main_title' );
    $kanri_message = read_config_option( 'kanri_message' );
    $syoku_html = read_config_option( 'syoku_html' );
    $record = read_file( read_config_option( 'recode_file' ) );
    $img_path = read_config_option( 'img_path' );
    $chara_img = read_config_option( 'chara_img' );
    $mark = read_config_option( 'mark' );
    $limit = read_config_option( 'limit' );
    $b_time = read_config_option( 'b_time' );
	$winner  = load_winner_data();
	$chara_syoku = read_config_option( "chara_syoku" );
	$witem = load_item_data( $winner["item"] );
	$winner_class = get_class_name( $winner );
	$esex = get_sex_name( $winner );
	$next_ex = get_next_ex( $winner );
	$stamina_time = read_config_option( "stamina_time" );
	$stamina_max = read_config_option( "stamina_max" );
	$battlepoint_time = read_config_option( "battlepoint_time" );
	$battlepoint_max = read_config_option( "battlepoint_max" );
	
	if ( $winner["kati"] ) {
		$ritu = ( $winner["kati"] / $winner["total"] ) * 100;
	} else {
		$ritu = 0;
	}
	
    if ( isset( $record[0] ) ) {
        list( $rcount, $rname, $rsite, $rurl ) = @explode( '<>', $record[0] );
    } else {
        list( $rcount, $rname, $rsite, $rurl ) = array( null, null, null, null );
    }
    
    show_header();

    ?>
<form action="<?php echo $script ?>" method="post">
	<input type="hidden" name="mode" value="log_in" />
	<table border="0" width="100%">
		<tr>
			<td>
				<img src="<?php echo $img_path ?>/<?php echo $title_img ?>" />
			</td>
			<td align="right" valign="top">
				<table border="1">
					<tr>
						<td align="center" colspan="5" class="b2">
							キャラクターを作成済みの方はこちらから
						</td>
					</tr>
					<tr>
						<td class="b1">
							I D
						</td>
						<td>
							<input type="text" size="10" name="id" value="<?php echo $c_id ?>" />
						</td>
						<td class="b1">
							パスワード
						</td>
						<td>
							<input type="password" size="10" name="pass" value="<?php echo $c_pass ?>" />
						</td>
						<td>
							<input type="hidden" name="login" value="1" />
							<input type="submit" value="ログイン" />
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
	<hr size="0">
	<small>
	/ <a href="<?php echo $homepage ?>"><?php echo $home_title ?></a> / <a href="<?php echo $script ?>?mode=ranking">英雄たちの記録</a> / <a href="<?php echo $syoku_html ?>">各職業に必要な特性値</a> / <a href="https://github.com/timomo/ffadventure_PHP/issues">アイデア募集</a> /
	</small>
	</form>
    <br />
    <?php echo $kanri_message ?>
<p>
    現在の連勝記録は、<?php echo $rname ?>さんの「<a href="<?php echo $rurl ?>" target="_blan"><span style="color:#6666BB; font-size: 10pt"><?php echo $rsite ?></span></a>」、<?php echo $rcount ?>連勝です。新記録を出したサイト名の横には、<img src="<?php echo $img_path ?>/<?php echo $mark ?>" />マークがつきます。
<table border="0" width="100%">
    <tr>
        <td width="500" valign="top">
	        <table border=1 width="100%">
	            <tr>
	                <td colspan=5 align="center" class="b2"><span color="#FFFFFF"><?php echo $winner["count"] ?>連勝中</span></td>
                </tr>
	            <tr>
	                <td align="center" class="b1">ホームページ</td>
	                <td colspan="4"><a href="<?php echo $winner["url"] ?>"><b><?php echo $winner["site"] ?></b></a>
    <?php
	if( $rurl == $winner["url"] ) {
    ?>
                    <img src="<?php echo $img_path ?>/<?php echo $mark ?>" border="0">
    <?php
    }
    ?>
	</td>
	</tr>
	<tr>
	<td align="center" rowspan="8"><img src="<?php echo $img_path ?>/<?php echo $chara_img[ $winner["chara"] ] ?>"><p>勝率：<?php echo $ritu ?>%<br />武器：<?php echo $witem["name"] ?></td>
	<td align="center" class="b1">なまえ</td><td><b><?php echo $winner["name"] ?></b></td>
	<td align="center" class="b1">性別</td><td><b><?php echo $esex ?></b></td>
	</tr>
	<tr>
	<td align="center" class="b1">職業</td><td><b><?php echo $chara_syoku[ $winner["syoku"] ] ?></b></td>
	<td align="center" class="b1">クラス</td><td><b><?php echo $winner_class ?></b></td>
	</tr>
	<tr>
	<td align="center" class="b1">レベル</td><td><b><?php echo $winner["lv"] ?></b></td>
	<td align="center" class="b1">経験値</td><td><b><?php echo $winner["ex"] ?>/<?php echo $next_ex ?></b></td>
	</tr>
	<tr>
	<td align="center" class="b1">お金</td><td><b><?php echo $winner["gold"] ?></b></td>
	<td align="center" class="b1">HP</td><td><b><?php echo $winner["hp"] ?>/<?php echo $winner["maxhp"] ?></b></td>
	</tr>
	<tr>
	<td align="center" class="b1">力</td><td><b><?php echo $winner["n_0"] ?></b></td>
	<td align="center" class="b1">知能</td><td><b><?php echo $winner["n_1"] ?></b></td>
	</tr>
	<tr>
	<td align="center" class="b1">信仰心</td><td><b><?php echo $winner["n_2"] ?></b></td>
	<td align="center" class="b1">生命力</td><td><b><?php echo $winner["n_3"] ?></b></td>
	</tr>
	<tr>
	<td align="center" class="b1">器用さ</td><td><b><?php echo $winner["n_4"] ?></b></td>
	<td align="center" class="b1">速さ</td><td><b><?php echo $winner["n_5"] ?></b></td>
	</tr>
	<tr>
	<td align="center" class="b1">魅力</td><td><b><?php echo $winner["n_6"] ?></b></td>
	<td align="center" class="b1">カルマ</td><td><b><?php echo $winner["lp"] ?></b></td>
	</tr>
	<tr>
	<td colspan=5 align="center"><?php echo $winner["l_name"] ?> の <a href="<?php echo $winner["l_url"] ?>" target="_blank"><?php echo $winner["l_site"] ?></a> に勝利！！</td>
	</tr>
	</table>
</td>
<td valign="top" class="small">
    [<B><span style="color: #FF9933;"><?php echo $main_title ?> の遊び方</span></B>]
    <ol>
        <li>まず、「新規キャラクター登録」ボタンを押して、キャラクターを作成します。</li>
        <li>キャラクターの作成が完了したら、このページの右上にあるところからログインして、あなた専用のステータス画面に入ります。</li>
        <li>そこであなたの行動を選択することができます。</li>
        <li>一度キャラクターを作成したら、右上のところからログインして遊びます。新規にキャラクターを作れるのは、一人に一つのキャラクターのみです。</li>
        <li>これは、HPバトラーではなく、キャラバトラーです。キャラクターを育てていくゲームです。</li>
        <li>能力を振り分けることができキャラクターの能力をご自分で決めることができます。(ここで決めた能力はごくまれにしか上昇しないので、慎重に)</li>
        <li><b><?php echo $limit ?>日</b>以上闘わなければ、キャラクターのデータが削除されます。</li>
        <li>当ページでは、戦闘は時間制限ではなく、ポイント制限です。</li>
        <li>チャンプと戦えるバトルポイントは<?php echo $battlepoint_time ?>秒につき、1回復し、最大<?php echo $battlepoint_max ?>ポイントです。</li>
		<li>モンスターと戦えるスタミナポイントは<?php echo $stamina_time ?>秒につき、1回復し、最大<?php echo $stamina_max ?>ポイントです。</li>
    </ol>
    [<B><span style="color: #FF9933;">新規キャラクタ作成</span></B>]<BR>
    下のボタンを押して、あなたのキャラクターを作成します。
    <form action="<?php echo $script ?>" method="post">
    <input type="hidden" name="mode" value="chara_make" />
    <input type="submit" value="新規キャラクター作成" />
    </form>
</td>
</tr>
</table>
</small>
    <?php
    show_footer();
}

function log_in( $in ) {
	$chara_flag = 1;
	
	$b_time = read_config_option( 'b_time' );
	$m_time = read_config_option( 'm_time' );
	$lv_up = read_config_option( 'lv_up' );
	$script = read_config_option( "script" );
	$img_path = read_config_option( 'img_path' );
	$chara_img = read_config_option( 'chara_img' );
	$chara_syoku = read_config_option( 'chara_syoku' );
	$max_gyo = read_config_option( 'max_gyo' );
	$syoku_file = read_config_option( 'syoku_file' );
	$message_file = read_config_option( 'message_file' );
	$charas = load_all_chara_data();
	$winner = load_winner_data();
	$citem = load_item_data( $chara["item"] );

    // TODO: ファイルロック
	$chara = login_chara_data( $in );
	$ltime = time();
	$ltime = $ltime - $chara["date"];
	$vtime = $b_time - $ltime;
	$mtime = $m_time - $ltime;
	
	$esex = get_sex_name( $chara );
	$next_ex = get_next_ex( $chara );
	$class_name = get_class_name( $chara );

	/**

	&class;

	open(IN,"$item_file");
	@log_item = <IN>;
	close(IN);

	$hit=0;
	foreach(@log_item){
		($i_no,$i_name,$i_dmg,$i_gold) = split(/<>/);
		if($kitem eq "$i_no"){ $hit=1;last; }
	}
	if(!$hit) { $i_name=""; }

	 * 
	 */
	
	$i_name = "";
	$class = "";
	
	show_header();

	?>
	<h1><?php echo $chara["name"] ?>さん用ステータス画面</h1>
	<hr size="0" />
	<?php
	if ( $ltime < $b_time or !$chara["total"] ) {
	?>
	<form name="form1">
	チャンプと闘えるまで残り<input type="text" name="clock" size="3" value="<?php echo $vtime ?>" />秒です。0になると、自動的に更新しますのでブラウザの更新は押さないで下さい。
	</form>
	<?php
	}
	?>
	<form action="<?php echo $script ?>" method="post">
	<table border="0">
	<tr>
	<td valign="top" width="50%">
	<table border="1">
	<tr>
	<td colspan="5" class="b2" align="center">ホームページデータ</td>
	</tr>
	<tr>
	<td class="b1">ホームページ名</td>
	<td colspan="4"><input type="text" name="site" value="<?php echo $chara["site"] ?>" size="50" /></td>
	</tr>
	<tr>
	<td class="b1">ホームページのURL</td>
	<td colspan="4"><input type="text" name="url" value="<?php echo $chara["url"] ?>" size="60" /></td>
	</tr>
	<tr>
	<td colspan="5" class="b2" align="center">キャラクターデータ</td>
	</tr>
	<tr>
	<td rowspan="9" align="center"><img src="<?php echo $img_path ?>/<?php echo $chara_img[ $chara["chara"] ] ?>"><br>武器：<?php echo $citem["name"] ?></td>
	<td class="b1">なまえ</td>
	<td><input type="text" name="c_name" value="<?php echo $chara["name"] ?>" size="10" /></td>
	<td class="b1">性別</td>
	<td><?php echo $esex ?></td>
	</tr>
	<tr>
	<td class="b1">職業</td>
	<td><?php echo $chara_syoku[ $chara["syoku"] ] ?></td>
	<td class="b1">クラス</td>
	<td><?php echo $class_name ?></td>
	</tr>
	<tr>
	<td class="b1">レベル</td>
	<td><?php echo $chara["lv"] ?></td>
	<td class="b1">経験値</td>
	<td><?php echo $chara["ex"] ?>/<?php echo $next_ex ?></td>
	</tr>
	<tr>
	<td class="b1">お金</td>
	<td><?php echo $chara["gold"] ?></td>
	<td class="b1">HP</td>
	<td><?php echo $chara["hp"] ?>/<?php echo $chara["maxhp"] ?></td>
	</tr>
	<tr>
	<td class="b1">力</td>
	<td><?php echo $chara["n_0"] ?></td>
	<td class="b1">知能</td>
	<td><?php echo $chara["n_1"] ?></td>
	</tr>
	<tr>
	<td class="b1">信仰心</td>
	<td><?php echo $chara["n_2"] ?></td>
	<td class="b1">生命力</td>
	<td><?php echo $chara["n_3"] ?></td>
	</tr>
	<tr>
	<td class="b1">器用さ</td>
	<td><?php echo $chara["n_4"] ?></td>
	<td class="b1">速さ</td>
	<td><?php echo $chara["n_5"] ?></td>
	</tr>
	<tr>
	<td class="b1">魅力</td>
	<td><?php echo $chara["n_6"] ?></td>
	<td class="b1">カルマ</td>
	<td><?php echo $chara["lp"] ?></td>
	</tr>
	<tr>
	<td class="b1">スタミナ</td>
	<td><?php echo $chara["stamina"] ?></td>
	<td class="b1">バトルポイント</td>
	<td><?php echo $chara["battlepoint"] ?></td>
	</tr>
	<tr>
	<td class="b1">技発動時コメント</td>
	<td colspan="4"><input type="text" name="waza" value="<?php echo $chara["waza"] ?>" size="50" /></td>
	</tr>
	</table>
	</form>
	</td>
	<td valign="top">
	<form action="<?php echo $script ?>" method="post">
	【現在転職できる職業一覧】<br />
	<select name="syoku">
	<option value="no">選択してください。</option>
	<?php
	$syoku = file( $syoku_file );
	$hit = 0;
	foreach( $syoku as $i => $line ) {
		list( $a, $b, $c, $d, $e, $f, $g ) = implode( "<>", $line );
		if ( $chara["n_0"] >= $a && $chara["n_1"] >= $b && $chara["n_2"] >= $c && $chara["n_3"] >= $d && $chara["n_4"] >= $e && $chara["n_5"] >= $f && $chara["n_6"] >= $g && $chara["syoku"] != $i ) {
			?>
			<option value="<?php echo $i ?>"><?php echo $chara_syoku[$i] ?></option>
			<?php
			$hit = 1;
		}
	}
	?>
	</select>
	<input type="hidden" name="id" value="<?php echo $chara["id"] ?>" />
	<input type="hidden" name="pass" value="<?php echo $chara["pass"] ?>" />
	<input type="hidden" name="mode" value="tensyoku" />
	<?php
	if ( $hit == 0 ) {
		?>
		現在転職できる職業はありません
		<?php
	} else {
		?>
		<input type="submit" value="転職する" />
		<?php
	}
	?>
	<br>
	　<small>※ 転職すると、全ての能力値が転職した職業の初期値になります。また、LVも1になります。</small>
	</form>
	<form action="<?php echo $script ?>" method="post">
	【魔物と戦い修行できます】<br />
	<input type="hidden" name="id" value="<?php echo $chara["id"] ?>" />
	<input type="hidden" name="pass" value="<?php echo $chara["pass"] ?>" />
	<input type="hidden" name="mode" value="monster" />
	<?php
	if( $ltime >= $m_time or !$chara["total"] ) {
		?>
		<input type="submit" value="モンスターと闘う"><br />
		<?php
	}else{
		?>
		<?php echo $mtime ?>秒後闘えるようになります。<br />
		<?php
	}
	$yado_gold = calc_yado_daikin( $chara );
	?>
	　<small>※修行の旅にいけます。</small>
	</form>
	<form action="<?php echo $script ?>" method="post">
	【旅の宿】<br>
	<input type="hidden" name="id" value="<?php echo $chara["id"] ?>" />
	<input type="hidden" name="pass" value="<?php echo $chara["pass"] ?>" />
	<input type="hidden" name="mode" value="yado" />
	<input type="submit" value="体力を回復" /><br />
	　<small>※体力を回復することができます。<b><?php echo $yado_gold ?></b>G必要です。現在チャンプの方も回復できます。こまめに回復すれば連勝記録も・・・。</small>
	</form>
	
	<form action="<?php echo $script ?>" method="post">
	【武器屋】<br>
	<input type="hidden" name="id" value="<?php echo $chara["id"] ?>" />
	<input type="hidden" name="pass" value="<?php echo $chara["pass"] ?>" />
	<input type="hidden" name="mode" value="weapon_shop" />
	<input type="submit" value="武器屋へ行く" /><br />
	　<small>※武器を購入する事が出来ます。</small>
	</form>
	
	<form action="<?php echo $script ?>" method="post">
	【チャンプに挑戦】<br />
	<input type="hidden" name="id" value="<?php echo $chara["id"] ?>" />
	<input type="hidden" name="pass" value="<?php echo $chara["pass"] ?>" />
	<input type="hidden" name="mode" value="battle" />
	<?php
	if ( $winner["id"] != $chara["id"] ) {
		?>
		<input type="submit" value="チャンプに挑戦" /><br />
		<?php
	} else {
		?>
		現在チャンプの為、戦えません。
		<?php
	}
	?>
	　<small>※チャンプに挑戦することができます。</small>
	</form>
	
	<form action="<?php echo $script ?>" method="post">
	【他のキャラクターへメッセージを送る】<br />
	<input type="text" name="mes" size="50"><br />
	<select name="mesid">
	<option value="">送る相手を選択</option>
	<?php

	foreach ( $charas as $id => $data ) {
		if ( $chara["id"] == $id ) {
			continue;
		}
		?>
		<option value="<?php echo $id ?>"><?php echo $chara["name"] ?>さんへ</option>
		<?php
	}

	?>
	</select>
	<input type="hidden" name="id" value="<?php echo $chara["id"] ?>" />
	<input type="hidden" name="name" value="<?php echo $chara["name"] ?>" />
	<input type="hidden" name="pass" value="<?php echo $chara["pass"] ?>" />
	<input type="hidden" name="mode" value="message" />
	<input type="submit" value="メッセージを送る"><br>
	　<small>※他のキャラクターへメッセージを送ることができます。</small>
	</form>
	</td>
	</tr>
	</table>
	【届いているメッセージ】表示数<b><?php echo $max_gyo ?></b>件まで<br>
	<?php
	$MESSAGE_LOG = file( $message_file );
	$hit = 0;
	$j = 0;
	foreach ( $MESSAGE_LOG as $i => $line ){
		list( $pid, $hid, $hname, $hmessage, $hhname, $htime) = implode( "<>", "" );
		if ( $chara["id"] == $pid ) {
			if( $max_gyo < $j ) {
				break;
			}
			?>
			<hr size="0" /><small><b><?php echo $hname ?>さん</b>　＞ 「<b><?php echo $hmessage ?></b>」(<?php echo $htime ?>)</small><br />
			<?php
			$hit = 1;
			$j++;
		} elseif ( $chara["id"] == $hid ) {
			?>
			<hr size="0" /><small><?php echo $chara["name"] ?>さんから<?php echo $hhname ?>さんへ　＞ 「<?php echo $hmessage ?>」(<?php echo $htime ?>)</small><br />
			<?php
			$j++;
		}
	}
	if( $hit == 0 ){
		?>
		<hr size="0" /><?php echo $chara["name"] ?>さん宛てのメッセージはありません
		<?php
	}
	?>
	<hr size="0" />
	<?php
	show_footer();

	/**
	# ロック解除
	if ($lockkey == 3) { &file'unlock; }
	else { if(-e $lockfile) { unlink($lockfile); } }
	 */
	
	$chara_flag = 0;
}

/**
 * セッションＩＤを発行または更新
 *
 * @link http://doremi.s206.xrea.com/php/tips/session.html
 * @return bool
 */
function session_on() {
	$sid = req( session_name() );
	ini_set( 'session.use_trans_sid', '0' );
	
	var_dump( "here-" );
	var_dump( $sid );
	var_dump( $_REQUEST );
	var_dump( "here-" );
	
	session_start();	// セッション開始
	if ( empty( $sid ) ) {	// login時なら
		$_SESSION['id'] = $GLOBALS['id'] = req('id');
	} else {	// セッション継続
		if (req('logout')) session_off();	// ログアウト処理
		if (empty($_SESSION['id'])) return false;
		$GLOBALS['id'] = $_SESSION['id'];

		// セッションＩＤを更新
		$tmp = $_SESSION; $_SESSION = array();
		session_destroy();
		session_id(md5(uniqid(rand(), 1)));
		session_start();
		$_SESSION = $tmp;
	}

	return true;
}

/**
 * ログアウト処理
 *
 * @link http://doremi.s206.xrea.com/php/tips/session.html
 */
function session_off() {
	setcookie(session_name(), "", time()-42000);	// クッキーを消す
	$_SESSION = array();	// セッション変数を消す
	session_destroy();	// セッションファイルを消す
	header("Location: " . read_config_option("script"));
	exit;
}

/**
 * リクエストデータ取得
 *
 * @link http://doremi.s206.xrea.com/php/tips/session.html
 */
function req($key) {
	return(isset($_REQUEST[$key]) ? $_REQUEST[$key] : '');
}

/**
 * 正当なセッションＩＤが送られてきたか判断
 *
 * @link http://doremi.s206.xrea.com/php/tips/session.html
 * @return bool
 */
function exist_sid() {
	$sid = req(session_name());
	var_dump( $sid );
	return(!empty($sid) && file_exists(session_save_path()
		. DIRECTORY_SEPARATOR . 'sess_' . $sid) ? true : false);
}

/**
 * 認証を行う
 *
 * @link http://doremi.s206.xrea.com/php/tips/session.html
 * @return bool
 */
function login() {
	$login = req('login');
	if (!empty($login)) {
		$_REQUEST[session_name()] = '';
		$id = req('id'); $pass = req('pass');
		$chara = load_chara_data( $id );
		if (!empty($id) && $id === $chara["id"]
			&& !empty($pass) && md5($pass) === $chara["pass"]) return true;
	}
	return false;
}