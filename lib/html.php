<?php
/**
 * Created by IntelliJ IDEA.
 * User: tomoyuki
 * Date: 15/01/03
 * Time: 20:33
 */

function show_footer() {
    $ver = read_config_option( 'ver' );
    $ltime = read_config_option( 'ltime' );
    $b_time = read_config_option( 'b_time' );
    $script = read_config_option( 'script' );
    // TODO: $ktotal
    // TODO: $refresh
    // TODO: $kid
    // TODO: $kpass
    
    if( $refresh and !$win and $mode == 'battle' ) {
        ?>
        【<b><a href="<?php echo $wurl ?>">チャンプのホームページへ</a></b>】
        <?php
    } else {
        if( $mode != "" ) {
            ?>
            <a href="<?php echo $script ?>">TOPページへ</a>
            <?php
        }
		if( $kid and $mode != 'log_in' and $mode != 'tensyoku' and $mode != 'yado' ) {
            ?>
             / <a href="<?php echo $script ?>?mode=log_in&id=<?php echo $kid ?>&pass=<?php echo $kpass ?>">ステータス画面へ</a>
            <?php
        }
	}
    ?>
	<hr size=0 width="100%" />
	<div align="right" class="small">
	<?php echo $ver ?> by <a href="https://github.com/timomo/ffadventure_PHP">timomo</a><br />
	FF Adventure v0.45 by <a href="http://www.interq.or.jp/sun/cumro/">D.Takamiya(CUMRO)</a><br />
	Character Image by <a href="http://www.aas.mtci.ne.jp/~hiji/9ff/9ff.html">9-FFいっしょにTALK</a><br />
	cooperation site by <a href="http://webooo.csidenet.com/asvyweb/">FFADV推奨委員会</a>
	</div>
    <?php
	if( $mode == 'log_in' and $ltime < $b_time and $ktotal ) {
        ?>
<script>
<!--
    window.setTimeout( 'CountDown()' ,100 );
//-->
</script>
    <?php
	}
    ?>
</body>
</html>
    <?php
}

function show_header() {
    $ltime = read_config_option( 'ltime' );
    $b_time = read_config_option( 'b_time' );
    $script = read_config_option( 'script' );
    $backgif = read_config_option( 'backgif' );
    $bgcolor = read_config_option( 'bgcolor' );
    $text = read_config_option( 'text' );
    $link = read_config_option( 'link' );
    $vlink = read_config_option( 'vlink' );
    $alink = read_config_option( 'alink' );
    $main_title = read_config_option( 'main_title' );
    $b_size = read_config_option( 'b_size' );
    // TODO: $mode
    // TODO: $ktotal
    // TODO: $vtime
    // TODO: $kid
    // TODO: $kpass
    ?>
    <html>
    <head>
    <meta http-equiv="Content-type" content="text/html; charset=UTF-8">
    <?php
    if( $mode == 'log_in' and $ltime < $b_time and $ktotal ) {
    ?>
    <meta http-equiv="refresh" content="<?php echo $vtime ?>">
    <script>
    <!--
    var start = new Date();
    start = Date.parse( start ) / 1000;
    var counts=$vtime;
    function CountDown() {
        var now = new Date();
        now = Date.parse( now ) / 1000;
        var x = parseInt( counts - ( now - start ), 10 );
        if( document.form1 ) {
            document.form1.clock.value = x;
        }
        if( x > 0 ) {
            timerID = setTimeout( "CountDown()", 100 );
        } else {
            location.href = "<?php echo $script ?>?mode=log_in&id=<?php echo $kid ?>&pass=<?php echo $kpass ?>"
        }
    }
    //-->
    </script>
    <?php
    }
    ?>
    <style type="text/css">
    <!--
    body,tr,td,th {
        font-size: <?php echo $b_size ?>;
    }
    a:hover {
        color: <?php echo $alink ?>;
    }
    .small {
        font-size: 10pt;
    }
    .b1 {
        background: #9ac;
        border-color: #ccf #669 #669 #ccf;
        color:#fff;
        border-style: solid;
        border-width: 1px;
    }
    .b2 {
        background: #669;
        border-color: #99c #336 #336 #99c;
        color:#fff;
        border-style: solid;
        border-width: 1px;
        text-align: center;
    }
    .b3 {
        background: #fff;
        border-color: #ccf #669 #669 #ccf;
    }
    .dmg {
        color: #FF0000;
        font-size: 18pt;
    }
    .clit {
        color: #0000FF;
        font-size: 18pt;
    }
    -->
    </style>
	<title><?php echo $main_title ?></title></head>
	<body background="<?php echo $backgif ?>" bgcolor="<?php echo $bgcolor ?>" text="<?php echo $text ?>" link="<?php echo $link ?>" vlink="<?php echo $vlink ?>" alink="<?php echo $alink ?>">
    <?php
}