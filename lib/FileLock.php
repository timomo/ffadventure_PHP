<?php
/**
 * Created by IntelliJ IDEA.
 * User: tomoyuki
 * Date: 15/01/03
 * Time: 15:53
 */

/**
 * Class FileLock
 *
 * @see http://www.programming-magic.com/20080211020413/
 */
class FileLock {
    /**
     * ロックファイル用ディレクトリ(最後に/はなし)
     * 
     * @var string
     */
    private $lockdir;
    /**
     * タイムアウト時間(秒、float)
     *
     * @var float
     */
    private $timeout;
    /**
     * スリープ時間(秒、float)
     *
     * @var float
     */
    private $sleeptime;

    /**
     * コンストラクタ
     * 
     * @param string $lockdir
     * @param float $timeout
     * @param float $sleeptime
     */
    public function __construct( $lockdir = '.', $timeout = 10.0, $sleeptime = 0.1 ) {
        if ( substr( $lockdir, -1 ) == '/' ) {
            /**
             * 末尾の/を削る
             */
            $lockdir = substr( $lockdir, 0, strlen( $lockdir ) -1 );
        }
        $this->lockdir = $lockdir;
        $this->timeout = $timeout;
        $this->sleeptime = $sleeptime;
    }

    /**
     * 引数のファイルにロックをかける
     * 
     * @param $filename
     * @return bool
     */
    public function lock( $filename ) {
        $lockfile = $this->lockdir. DIRECTORY_SEPARATOR. basename( $filename ). '.lock';
        
        /**
         * ロックファイルがタイムアウト時間を過ぎて存在し続けていたら削除
         */
        if ( file_exists( $lockfile ) ) {
            if ( microtime( true ) - filemtime( $lockfile ) > $this->timeout ) {
                $this->unlock( $filename );
            }
        }
        
        /**
         * ロックをかける
         */
        $start = microtime( true );
        while( ! @mkdir( $lockfile, 0755 ) ) {
            if( microtime( true ) - $start > $this->timeout ){
                /**
                 * タイムアウトを過ぎたのでロック失敗
                 */
                return false;
            }
            usleep( $this->timeout * 1000 * 1000 );
        }
        return true;
    }

    /**
     * 引数のファイルにロックを外す
     * 
     * @param $filename
     * @return bool
     */
    public function unlock( $filename ) {
        $lockfile = $this->lockdir. DIRECTORY_SEPARATOR. basename( $filename ). '.lock';
        @rmdir( $lockfile );
    }
}