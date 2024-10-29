<?php
/**
 * Plugin Name: [凹凸曼]微信分享有图
 * Plugin URI:  http://www.girltm.com/
 * Description: 实现文章在微信里分享朋友圈和分享朋友有图标
 * Version:     2.7.0
 * Author:      凹凸曼
 * Author URI:  http://www.girltm.com/
 * License:     GPL-2.0+
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: apoyl-weixinshare
 * Domain Path: /languages
 */
if ( ! defined( 'WPINC' ) ) {
    die;
}
define('APOYL_WEIXINSHARE_VERSION','2.7.0');
define('APOYL_WEIXINSHARE_PLUGIN_FILE',plugin_basename(__FILE__));
define('APOYL_WEIXINSHARE_URL',plugin_dir_url( __FILE__ ));
define('APOYL_WEIXINSHARE_DIR',plugin_dir_path( __FILE__ ));

function activate_apoyl_weixinshare(){
    require plugin_dir_path(__FILE__).'includes/class-apoyl-weixinshare-activator.php';
    Apoyl_Weixinshare_Activator::activate();
}
register_activation_hook(__FILE__, 'activate_apoyl_weixinshare');

function uninstall_apoyl_weixinshare(){
    require plugin_dir_path(__FILE__).'includes/class-apoyl-weixinshare-uninstall.php';
    Apoyl_Weixinshare_Uninstall::uninstall();
}

register_uninstall_hook(__FILE__,'uninstall_apoyl_weixinshare');

require plugin_dir_path(__FILE__).'includes/class-apoyl-weixinshare.php';

function run_apoyl_weixinshare(){
    $plugin=new Apoyl_Weixinshare();
    $plugin->run();
}
function apoyl_weixinshare_file($filename)
{
    $file = WP_PLUGIN_DIR . '/apoyl-common/v1/apoyl-weixinshare/components/' . $filename . '.php';
    if (file_exists($file))
        return $file;
    return '';
}
run_apoyl_weixinshare();
?>
