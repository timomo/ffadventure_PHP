<?php
/**
 * Created by IntelliJ IDEA.
 * User: timomo
 * Date: 14/12/30
 * Time: 17:50
 */

/**
 * 初期設定用ファイル config.php
 * programed by timomo
 *
 * http://www.thanks.click/
 * tyomo88@gmail.com
 */

/**
 * 現在のバージョン(変更)
 *
 * @ver string
 */
$ver = 'FF ADVENTURE PHP v0.40';

/**
 * --- [注意事項] ------------------------------------------------
 *  1. このスクリプトはフリーソフトです。このスクリプトを使用した
 *     いかなる損害に対して作者は一切の責任を負いません。
 *  2. 設置に関する質問はサポート掲示板にお願いいたします。
 *     直接メールによる質問は一切お受けいたしておりません。
 *  3. 設置したら皆さんに楽しんでもらう為にも、Webリングへぜひ参加
 *     してくださいm(__)m
 *     http://cgi.members.interq.or.jp/sun/cumro/ff_adventure/
 *  4. もしよろしければ、当サイトへのリンクを張ってくださいm(__)m
 *    「ASVY WEB -総合アクセス支援-」
 *     http://cgi.members.interq.or.jp/sun/cumro/
 * ---------------------------------------------------------------
*/

/**
 * メンテナンス用(メインプログラムUP時：1)
 * CGIファイルアップ時にアクセスしている人がいる場合ログファイルが
 * 初期化される場合がありますのでご注意ください。
 * 
 * @var int
 */
$mente = 0;

/**
 * ┏━━━━━━━━━━┓
 * ┃1. ファイル名の設定 ┃
 * ┗━━━━━━━━━━┛
 */

/**
 * メインスクリプト名
 * 
 * @var string
 */
$script = "index.php";

/**
 * CGIスクリプトまでの絶対パス（http://から）
 * 
 * @var string
 */
$script_url = "http://www.ffa.red/index.php";

/**
 * キャラクターデータパス
 * 
 * @var string
 */
$chara_path = "../data/chara";

/**
 * キャラクターデータファイルの拡張子
 * 
 * @var string
 */
$chara_ext = "dat";

/**
 * レコード(連勝記録用データファイル)
 * 
 * @var string
 */
$recode_file= '../data/recode.dat';

/**
 * 勝利者データ
 * 
 * @var string
 */
$winner_file= "../data/winner.dat";

/**
 * メッセージログファイル
 * 
 * @var string
 */
$message_file = "../data/message.dat";

/**
 * 職業データファイル
 * 
 * @var string
 */
$syoku_file= "../data/syoku.dat";

/**
 * モンスターデータファイル
 * monster.datにデータを追加することでモンスターをいくらでも増やすことができます
 * 名前<>経験値<>ランダム値<>基本HP<>ダメージ(ランダム)<>改行
 * 
 * @var string
 */
$monster_file= "../data/monster.dat";

/**
 * アイテムデータファイル
 * 
 * @var string
 */
$item_file = "../data/item.dat";

/**
 * 各職業に必要なパラメータ説明ページ
 * 
 * @var string
 */
$syoku_html = "index.html";

/**
 * タイトル画像
 * 
 * @var string
 */
$title_img = "title.gif";

/**
 * 連勝記録サイトの横に表示するマーク画像
 * 
 * @var string
 */
$mark = "pochi5.gif";

/**
 * モンスターイメージデータパス
 * 
 * @var string
 */
$img_path   ="images";

/**
 * ファイルロック形式(KENT WEBさんのスクリプトより抜粋させて頂きました)
 * --> 0=no 1=symlink関数 2=open関数 3=rename関数（推奨）
 * --> 1 or 2 を設定する場合は、ロックファイルを生成するディレクトリ
 * のパーミッションは 777 に設定する。
 * 
 * @var int
 */
$lockkey = 3;

/**
 * ロックファイル
 * 
 * @var string
 */
$lockfile = "file.lock";

/**
 * ┏━━━━━━━━━━┓
 * ┃2. 管理人関連の設定 ┃
 * ┗━━━━━━━━━━┛
 */

/**
 * ホームページのタイトル(又はホームページに戻る時の名前)
 * 
 * @var string
 */
$home_title = "HOMEへ";

/**
 * ホームページのURL(http://から)
 * 
 * @var string
 */
$homepage = "http://www.ffa.red/";

/**
 * 管理者からのメッセージ
 *
 * @var string
 */
$kanri_message = <<<EOM
<!-- ここから -->
ここへメッセージを書くと、TOPページの上部に表示されます。
<!-- ここまで -->
EOM;

/**
 * ヘッダーメッセージ
 * 
 * @var string
 */
$header_message = <<<EOM
<!-- ここから -->
ここへメッセージを書くと、各ページの上部に表示されます。
<!-- ここまで -->
EOM;

/**
 * フッターメッセージ
 *
 * @var string
 */
$footer_message = <<<EOM
<!-- ここから -->
ここへメッセージを書くと、各ページの下部に表示されます。
<!-- ここまで -->
EOM;

/**
 * キャラクター登録制御
 * 1にするとキャラクターの作成ができなくなります。
 * 
 * @var int
 */
$chara_stop = 0;

/**
 * 連続投稿までの制限時間（秒数で指定）
 * 一度戦闘するとここで指定した秒数以上経過しないと戦えません
 * 
 * @var int
 */
$b_time = 600;

/**
 * モンスターとの連続戦闘制限（秒数で指定）
 * 一度戦闘するとここで指定した秒数以上経過しないと戦えません
 * 
 * @var int
 */
$m_time = 600;

/**
 * ┏━━━━━━━━━━━┓
 * ┃3. キャラクターの設定 ┃
 * ┗━━━━━━━━━━━┛
 */

/**
 * キャラクター名
 * 
 * @var array
 */
$chara_name = array();
$chara_name[0] = 'たまねぎ剣士';
$chara_name[1] = '戦士';
$chara_name[2] = 'モンク';
$chara_name[3] = '白魔道師';
$chara_name[4] = '黒魔道師';
$chara_name[5] = '赤魔道師';
$chara_name[6] = '狩人';
$chara_name[7] = 'ナイト';
$chara_name[8] = 'シーフ';
$chara_name[9] = '学者';
$chara_name[10] = '風水師';
$chara_name[11] = '竜騎士';
$chara_name[12] = 'バイキング';
$chara_name[13] = '空手家';
$chara_name[14] = '魔剣士';
$chara_name[15] = '幻術師';
$chara_name[16] = '吟遊詩人';
$chara_name[17] = '魔人';
$chara_name[18] = '導師';
$chara_name[19] = '魔界幻士';
$chara_name[20] = '賢者';
$chara_name[21] = '忍者';

/**
 * キャラクター画像ファイル名
 * 
 * @var array
 */
$chara_img = array();
$chara_img[0] = 'ff3onion.gif';
$chara_img[1] = 'ff3war.gif';
$chara_img[2] = 'ff3monk.gif';
$chara_img[3] = 'ff3wht.gif';
$chara_img[4] = 'ff3blk.gif';
$chara_img[5] = 'ff3red.gif';
$chara_img[6] = 'ff3rng.gif';
$chara_img[7] = 'ff3pld.gif';
$chara_img[8] = 'ff3shf.gif';
$chara_img[9] = 'ff3gks.gif';
$chara_img[10] = 'ff3fsi.gif';
$chara_img[11] = 'ff3drg.gif';
$chara_img[12] = 'ff3bkg.gif';
$chara_img[13] = 'ff3krt.gif';
$chara_img[14] = 'ff3drk.gif';
$chara_img[15] = 'ff3gjt.gif';
$chara_img[16] = 'ff3brd.gif';
$chara_img[17] = 'ff3mjn.gif';
$chara_img[18] = 'ff3dsi.gif';
$chara_img[19] = 'ff3mkg.gif';
$chara_img[20] = 'ff3ken.gif';
$chara_img[21] = 'ff3nin.gif';

/**
 * キャラクターの職業
 * 
 * @var array
 */
$chara_syoku = array();
$chara_syoku[0] = '戦士';
$chara_syoku[1] = '魔法使い';
$chara_syoku[2] = '僧侶';
$chara_syoku[3] = '盗賊';
$chara_syoku[4] = 'レンジャー';
$chara_syoku[5] = '錬金術師';
$chara_syoku[6] = 'バード';
$chara_syoku[7] = '超能力者';
$chara_syoku[8] = 'ヴァルキリー';
$chara_syoku[9] = 'ビショップ';
$chara_syoku[10] = 'ロード';
$chara_syoku[11] = '侍';
$chara_syoku[12] = '修道僧';
$chara_syoku[13] = '忍者';

/**
 * 基礎能力値(変更不可)
 * 
 * @var array
 */
$kiso_nouryoku = array( 9, 8, 8, 9, 9, 8, 8 );

/**
 * 職業別のクラス
 * 左からレベルが低い順
 */

/**
 * 戦士
 * 
 * @var array
 */
$FIGHTER = array( "JOURNEYMAN", "WARRIOR", "WARAUDER", "GLADIATOR", "SWORDMAN", "WARLORD", "CONQUERER" );

/**
 * 魔法使い
 * 
 * @var array
 */
$MAGE = array( "MAGICIAN", "CONJURER", "WARLOCK", " SORCERER", "NECROMANCER", "WIZARD", "MAGUS" );

/**
 * 僧侶
 * 
 * @var array
 */
$PRIEST = array( "ACOLYTE", "HEALER", "CURATE", "DRUID", "HIGHPRIEST", "PATRIACH", "SAINT" );

/**
 * 盗賊
 * 
 * @var array
 */
$THIEF = array( "ROGUE", "TRICKSTER", "HIWAYMAN", "BUSHWACKER", "PIRATE", "MS.SHADOWS", "GUILDMASTER" );

/**
 * レンジャー
 * 
 * @var array
 */
$RANGER = array( "WOODSMAN", "SCOUT", "ARCHER", "PATHFINDER", "WEAPONEER", "OUTRIDER", "RANGERLORD" );

/**
 * 錬金術師
 * 
 * @var array
 */
$ALCHEMIST = array( "HERBALIST", "PHYSICIAN", "ADEPT", "SHAMAN", "EVOCATUR", "MS.ELIXERS", "ENCHANTER" );

/**
 * バード
 * 
 * @var array
 */
$BARD = array( "MINSTERL", "CANTOR", "SONNETEER", "TROUBADOR", "POET", "MS.LUTES", "MUSE" );

/**
 * 超能力者
 * 
 * @var array
 */
$PSIONIC = array( "PSYCHIC", "SOOTHSAYER", "VISIONIST", "ILLUSIONIST", "MYSTIC", "ORACLE", "PROPHET" );

/**
 * ヴァルキリー
 * 
 * @var array
 */
$VALKYRIE = array( "LANCER", "WARRIOR", "CAVALER", "CHEVALIER", "CHAMPION", "HEROINE", "OLYMPIAN" );

/**
 * ビショップ
 * 
 * @var array
 */
$BISHOP = array( "FRIAR", "VICAR", "CANON", "MAGISTRATER", "DIOCESAN", "CARDINAL", "PONTIFF" );

/**
 * ロード
 * 
 * @var array
 */
$LORD = array( "SQUIRE", "GALLANT", "KNIGHT", "CHEVALIER", "PALADIN", "CRUSADER", "MONARCH" );

/**
 * 侍
 * 
 * @var array
 */
$SAMURAI = array( "BLADESMAN", "SHUGENJA", "HATAMOTO", "DAISHOMASTER", "DAIMYO", "WARLORD", "SHOGUN" );

/**
 * 修道僧
 * 
 * @var array
 */
$MONK = array( "INITIATE", "BROTHER", "DISCIPLE", "APOSTLE", "MASTER", "IMMACULATE", "GRANDMASTER" );

/**
 * 忍者
 * 
 * @var array
 */
$NINJA = array( "GENIN", "EXECUTIONER", "ASSASSIN", "CHUNIN", "MASTER", "JONIN", "GRANDFATHER" );

/**
 * 必殺技名
 * 
 * @var array
 */
$hissatu = array( "真空裂破斬", "ファイアーボール", "神のいかずち", "シャドウエッジ", "ファイアーアロー", "アシッド・スプラッシュ", "呪いの歌", "サイオニックファイアー", "ヴァルキリージャベリン", "聖魔爆裂陣", "サザンクロス", "阿修羅天舞殺", "爆裂旋風鋼拳", "炎獄魔掌" );

/**
 * ┏━━━━━━━━━━━┓
 * ┃4. デザイン関連の設定 ┃
 * ┗━━━━━━━━━━━┛
 */

/**
 * タイトル
 * 
 * @var string
 */
$main_title = 'FF ADVENTURE';

/**
 * 本文の文字大きさ（ポイント数:スタイルシートで有効）
 * 
 * @var string
 */
$b_size = '12pt';

/**
 * 壁紙を指定する場合（http://から指定）
 * 
 * @var string
 */
$backgif = "./bg.gif";

/**
 * 背景色を指定
 * 
 * @var string
 */
$bgcolor = "#FFFFFF";

/**
 * 文字色を指定
 * 
 * @var string
 */
$text = "#333333";

/**
 * リンク色を指定
 */
/**
 * 未訪問
 * 
 * @var string
 */
$link  = "#0000FF";

/**
 * 訪問済
 * 
 * @var string
 */
$vlink = "#800080";

/**
 * 訪問中
 * 
 * @var string
 */
$alink = "#FF0000";

/**
 * ┏━━━━━━━━━━┓
 * ┃5. データ関連の設定 ┃
 * ┗━━━━━━━━━━┛
 */

/**
 * レベルアップまでの経験値の設定
 * レベル×値($lv_up)＝次のレベルまでの経験値
 * 
 * @var int
 */
$lv_up = 1000;

/**
 * 戦闘ターンの設定
 * 
 * @var int
 */
$turn = 10;

/**
 * キャラクターを削除するまでの期間(日)
 * ここで設定した日にち以上、戦闘をしていないキャラクターを自動で削除します。
 * 
 * @var int
 */
$limit = 7;

/**
 * 連闘制限(チャンプ)
 * チャンピョンと戦う際に連闘制限を利用するかしないかの選択
 * 制限する：1 制限しない：0
 * 
 * @var int
 */
$chanp_milit = 0;

/**
 * 連闘制限(モンスターと闘える回数)
 * 
 * @var int
 */
$sentou_limit = 50;

/**
 * ランキング表示数
 * 
 * @var int
 */
$rank_top = 30;

/**
 * 宿の代金
 * 
 * @var int
 */
$yado_dai = 10;

/**
 * 強制送還(使用する場合秒数を設定。使用しないばあい、0)
 * 
 * @var int
 */
$refresh = 0;

/**
 * 逆転技設定(チャンプとのレベルさを設定します。ここで設定した数字よりも
 * レベル差が多いきいと発動します)
 * 
 * @var int
 */
$level_sa = 4;

/**
 * 必殺技の出る確立
 * ここで指定した 1/X の確立になります。
 * 
 * @var int
 */
$waza_ritu = 5;

/**
 * 基礎HP
 * 
 * @var int
 */
$kiso_hp = 20;

/**
 * 基礎経験値(ここで設定した数×相手のレベル)
 * 
 * @var int
 */
$kiso_exp = 18;

/**
 * メッセージ保存数(全員分の合計)
 * 
 * @var int
 */
$max = 100;

/**
 * ステータス画面でのメッセージ表示行数
 * 相手からのメッセージ数
 * 
 * @var int
 */
$max_gyo = 5;

$stamina_path = "../data/stamina";
$stamina_ext = "dat";
$stamina_max = 10;
$stamina_time = 60 * 3;

$battlepoint_path = "../data/battlepoint";
$battlepoint_ext = "dat";
$battlepoint_max = 3;
$battlepoint_time = 60 * 20;

/**
 * [設定はここまで]------------------------------------------------------------
 */
