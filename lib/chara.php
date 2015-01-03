<?php
/**
 * Created by IntelliJ IDEA.
 * User: timomo
 * Date: 15/01/03
 * Time: 21:44
 */

function chara_make() {
    $script = read_config_option( 'script' );
    show_header();
    ?>
    <h1>キャラクタ作成画面</h1>
    <hr size=0 />
    <form action="<?php echo $script ?>" method="post">
        <input type="hidden" name="mode" value="make_end">
        <table border=1>
            <tr>
                <td class="b1">ID</td>
                <td><input type="text" name="id" size="10"><br><small>△お好きな半角英数字を4〜8文字以内でご記入ください。</small></td>
            </tr>
            <tr>
                <td class="b1">パスワード</td>
                <td><input type="password" name="pass" size="10"><br><small>△お好きな半角英数字を4〜8文字以内でご記入ください。</small></td>
            </tr>
            <tr>
                <td class="b1">ホームページ名</td>
                <td><input type="text" name="site" size="40"><br><small>△あなたのホームページの名前を入力してください。</small></td>
            </tr>
            <tr>
                <td class="b1">URL</td>
                <td><input type="text" name="url" size="50" value="http://"><br><small>△あなたのホームページのアドレスを記入してください。</small></td>
            </tr>
            <tr>
                <td class="b1">キャラクターの名前</td>
                <td><input type="text" name="c_name" size="30"><br><small>△作成するキャラクターの名前を入力してください。</small></td>
            </tr>
            <tr>
                <td class="b1">キャラクターの性別</td>
                <td><input type="radio" name="sex" value="0">女　<input type="radio" name="sex" value="1">男<br><small>△作成するキャラクターの性別を選択してください。</small></td>
            </tr>
            <tr>
                <td class="b1">キャラクターのイメージ</td>
                <td><select name="chara">
                        EOM

                        $i=0;
                        foreach(@chara_name){
                        print "<option value=\"$i\">$chara_name[$i]\n";
                            $i++;
                            }

                            print <<"EOM";
                    </select><br><small>△作成するキャラクターの性別を選択してください。</small></td>
            </tr>
            <tr>
                <td class="b1">キャラクターの能\力</td>
                <td>
                    <table border=1>
                        <tr>
                            <td class="b2" width="70">力</td><td class="b2" width="70">知能\</td><td class="b2" width="70">信仰心</td><td class="b2" width="70">生命力</td><td class="b2" width="70">器用さ</td><td class="b2" width="70">速さ</td><td class="b2" width="70">魅力</td>
                        </tr>
                        <tr>
                            EOM

                            $point = int(rand(10));
                            $point+=4;

                            $i=0;$j=0;
                            foreach(0..6){
                            print "<td>$kiso_nouryoku[$i] + <select name=n_$i>\n";
                                    foreach(0..$point){
                                    print "<option value=\"$j\">$j\n";
                                        $j++;
                                        }
                                        print "</select>\n";
                                print "</td>\n";
                            $i++;$j=0;
                            }

                            print <<"EOM";
                        </tr>
                    </table>
                    <small>△ボーナスポイント「<b>$point</b>」をそれぞれに振り分けてください。(振り分けた合計が、$point以下になるように。<br>又どれかが最低12以上になるように。最高は18までです)</small>
                </td>
            </tr>
            <tr>
                <td colspan="2" align="center"><input type="submit" value="これで登録"></td>
            </tr>
        </table>
        <input type="hidden" name=point value="$point">
    </form>
<?php
    show_footer();
}

function make_end() {
    
    
}