<?php
/*
 * @link       http://www.girltm.com/
 * @since      1.0.0
 * @package    Apoyl_Weixinshare
 * @subpackage Apoyl_Weixinshare/includes
 * @author     凹凸曼 <jar-c@163.com>
 *
 */
class Apoyl_Weixinshare_i18n {


	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'apoyl-weixinshare',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
