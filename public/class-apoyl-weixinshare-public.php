<?php

/*
 * @link http://www.girltm.com/
 * @since 1.0.0
 * @package Apoyl_Weixinshare
 * @subpackage Apoyl_Weixinshare/public
 * @author 凹凸曼 <jar-c@163.com>
 *
 */
class Apoyl_Weixinshare_Public
{

    private $plugin_name;

    private $version;

    public function __construct($plugin_name, $version)
    {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    public function enqueue_styles()
    {
        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/Apoyl_Weixinshare_public.css', array(), $this->version, 'all');
    }

    public function enqueue_scripts()
    {
        $file = apoyl_weixinshare_file('forcelogo');
        if ($file)
            wp_enqueue_script('jquery');
        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/jweixin-1.6.0.js', array(
            'jquery'
        ), $this->version, false);
    }

    private function getImgurl($defaultimg = '')
    {
    	$file = apoyl_weixinshare_file('aotuimg');
    	if ($file){
    		include $file;
            if (empty($imgurl))
                $imgurl = $defaultimg;
    	}else{
	    	isset($_GET['p'])?$p = (int) sanitize_key($_GET['p']):$p=0;
	        $content = get_the_content($p);
	        if (empty($content) && $p) {
	            $post = get_post($p);
	            $content = isset($post->post_content) ? $post->post_content : '';
	        }
            $imgurl=APOYL_WEIXINSHARE_URL.'public/img/logo.png';
    	}

        return $imgurl;
    }

    public function footer()
    {
        $arr = get_option('apoyl-weixinshare-settings');
        if (isset($arr['appid']) && isset($arr['appsecret'])) {
            require_once plugin_dir_path(dirname(__FILE__)) . 'public/weixinapi/ApoylJSSDK.php';
            $apoyljssdk = new ApoylJSSDK($arr['appid'], $arr['appsecret'], $arr['opendebug']);
            $signPackage = $apoyljssdk->getSignPackage();
            if (isset($arr['opendicon']))
                $defaultimg = $arr['opendicon'];
            $imgurl = $this->getImgurl($defaultimg);
            $file = apoyl_weixinshare_file('forcelogo');
            if ($file)
                include $file;
            isset($_GET['p'])?$p = (int) sanitize_key($_GET['p']):$p=0;
            $desc = trim(htmlspecialchars(preg_replace('/\s+/', '', get_the_excerpt($p))));
            if (empty($desc) && isset($arr['description']))
                $desc = $arr['description'];
            require_once plugin_dir_path(dirname(__FILE__)) . 'public/partials/display.php';
        }
    }

    public function ajaxshare()
    {
        global $wpdb;
        $file = apoyl_weixinshare_file('addshare');
        if ($file)
            include $file;
    }
}