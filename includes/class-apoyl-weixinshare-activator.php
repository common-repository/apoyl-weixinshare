<?php
/*
 * @link       http://www.girltm.com/
 * @since      1.0.0
 * @package    Apoyl_Weixinshare
 * @subpackage Apoyl_Weixinshare/includes
 * @author     凹凸曼 <jar-c@163.com>
 *
 */
class Apoyl_Weixinshare_Activator{
    
    public static function activate(){
        $options_name='apoyl-weixinshare-settings';
        $arr_options=array(
            'openapifriends'=>1,
            'openapifriend'=>1,
            'appid'=>'',
            'appsecret'=>'',
            'opendicon'=>'',
            'description'=>'',
            'openforcelogo'=>'0',
            'opendebug'=>0,
        	'opencover'=>0,
            
        );
        add_option($options_name,$arr_options);
        
        Apoyl_Weixinshare_Activator::install_db();
        
    }
    protected  static function install_db()
    {
        global $wpdb;
            $apoyl_weixinshare_db_version = APOYL_WEIXINSHARE_VERSION;
            $tablename = $wpdb->prefix . 'apoyl_weixinshare';
            $ishave = $wpdb->get_var('show tables like \'' . $tablename . '\'');
            $sql='';
            if ($tablename != $ishave) {
                $sql = "CREATE TABLE " . $tablename . " (
                          `id`	bigint(20) NOT NULL AUTO_INCREMENT,
                          `subject` varchar(100) NOT NULL,
                          `url` varchar(200) NOT NULL,
                          `ip` varchar(100) NOT NULL,
                          `sharetype` tinyint(1) NOT NULL default '0',
                          `addtime` int(10) NOT NULL default '0',
                          PRIMARY KEY (`id`),
                          KEY `addtime` (`addtime`)
                        );";
            }

            include_once ABSPATH . 'wp-admin/includes/upgrade.php';
            dbDelta($sql);
            add_option('apoyl_weixinshare_db_version', $apoyl_weixinshare_db_version);

    }
}
?>