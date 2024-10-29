<?php
/*
 * @link       http://www.girltm.com/
 * @since      1.0.0
 * @package    Apoyl_Weixinshare
 * @subpackage Apoyl_Weixinshare/includes
 * @author     凹凸曼 <jar-c@163.com>
 *
 */
class Apoyl_Weixinshare_Uninstall {

	
	public static function uninstall() {
        delete_option('apoyl-weixinshare-settings');
	}

}
