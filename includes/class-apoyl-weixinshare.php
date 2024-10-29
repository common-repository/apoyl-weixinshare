<?php
/*
 * @link       http://www.girltm.com/
 * @since      1.0.0
 * @package    Apoyl_Weixinshare
 * @subpackage Apoyl_Weixinshare/includes
 * @author     凹凸曼 <jar-c@163.com>
 *
 */
class Apoyl_Weixinshare {
	
	protected $loader;
	
	protected $plugin_name;
	
	protected $version;
	
	public function __construct() {
	    
		if ( defined( 'APOYL_WEIXINSHARE_VERSION' ) ) {
			$this->version = APOYL_WEIXINSHARE_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'apoyl-weixinshare';
		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();
	}
	
	private function load_dependencies() {
		
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-apoyl-weixinshare-loader.php';
	
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-apoyl-weixinshare-i18n.php';
	
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-apoyl-weixinshare-admin.php';
	
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-apoyl-weixinshare-public.php';
		$this->loader = new Apoyl_Weixinshare_Loader();
	}
	
	private function set_locale() {
		$plugin_i18n = new Apoyl_Weixinshare_i18n();
		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );
	}
	
	private function define_admin_hooks() {
		$plugin_admin = new Apoyl_Weixinshare_Admin( $this->get_plugin_name(), $this->get_version() );
		$this->loader->add_action('admin_menu', $plugin_admin, 'menu');
		$this->loader->add_filter('plugin_action_links_'.APOYL_WEIXINSHARE_PLUGIN_FILE, $plugin_admin, 'links',10, 2);
	}
	
	private function define_public_hooks() {
	    $arr=get_option('apoyl-weixinshare-settings');
	    if(isset($arr['appid'])&&isset($arr['appsecret'])){
    		$plugin_public = new Apoyl_Weixinshare_Public( $this->get_plugin_name(), $this->get_version() );
    		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
    		$this->loader->add_action( 'wp_footer', $plugin_public, 'footer' );
    		$file = apoyl_weixinshare_file('forcelogo');
    		if ($file)
    		  $this->loader->add_action('wp_ajax_nopriv_ajaxshare', $plugin_public,'ajaxshare');
	    }
	}

	public function run() {
		$this->loader->run();
	}
	
	public function get_plugin_name() {
		return $this->plugin_name;
	}
	public function get_loader() {
		return $this->loader;
	}

	public function get_version() {
		return $this->version;
	}
}
?>