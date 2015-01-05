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
 * http://timothy305.hatenablog.com/
 * tyomo88@gmail.com
 */

/**
 * 現在のバージョン(変更)
 *
 * @ver string
 */
$ver = 'FF ADVENTURE PHP v0.01';

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
$script_url = "http://ffadv.special-thanks.me/index.php";

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
$chara_ext = "ini";

/**
 * レコード(連勝記録用データファイル)
 * 
 * @var string
 */
$recode_file= '../data/recode.ini';

/**
 * 勝利者データ
 * 
 * @var string
 */
$winner_file= "winner.cgi";

/**
 * メッセージログファイル
 * 
 * @var string
 */
$message_file = "message.cgi";

/**
 * 職業データファイル
 * 
 * @var string
 */
$syoku_file= "../data/syoku.ini";

/**
 * モンスターデータファイル
 * monster.iniにデータを追加することでモンスターをいくらでも増やすことができます
 * 名前<>経験値<>ランダム値<>基本HP<>ダメージ(ランダム)<>改行
 * 
 * @var string
 */
$monster_file= "../data/monster.ini";

/**
 * アイテムデータファイル
 * 
 * @var string
 */
$item_file = "../data/item.ini";

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
$homepage = "http://ffadv.special-thanks.me/";

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
$chara_name[0] = 'チョコボ';
$chara_name[1] = 'エーコ';
$chara_name[2] = 'フライヤ';
$chara_name[3] = 'ガーネット';
$chara_name[4] = 'モーグリ';
$chara_name[5] = 'クイナ';
$chara_name[6] = 'サラマンダー';
$chara_name[7] = 'スタイナー';
$chara_name[8] = 'ビビ';
$chara_name[9] = 'ジタン';

/**
 * キャラクター画像ファイル名
 * 
 * @var array
 */
$chara_img = array();
$chara_img[0] = 'ikon_m_c.gif';
$chara_img[1] = 'ikon_m_e.gif';
$chara_img[2] = 'ikon_m_f.gif';
$chara_img[3] = 'ikon_m_g.gif';
$chara_img[4] = 'ikon_m_m.gif';
$chara_img[5] = 'ikon_m_q.gif';
$chara_img[6] = 'ikon_m_sa.gif';
$chara_img[7] = 'ikon_m_st.gif';
$chara_img[8] = 'ikon_m_v.gif';
$chara_img[9] = 'ikon_m_z.gif';

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
$chara_syoku[7] = '超能\力者';
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

/**
 * [設定はここまで]------------------------------------------------------------
 */
