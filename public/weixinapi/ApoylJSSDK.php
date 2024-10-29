<?php
/*
 * @link http://www.girltm.com/
 * @since 1.0.0
 * @package Apoyl_Weixinshare
 * @subpackage Apoyl_Weixinshare/public/weixinapi
 * @author 凹凸曼 <jar-c@163.com>
 *
 */
class ApoylJSSDK {
	private $appId;
	private $appSecret;
	private $openbs;
	public function __construct($appId, $appSecret,$debug) {
		$this->openbs = false;
		$this->appId = $appId;
		$this->appSecret = $appSecret;
        $this->debug=$debug;

	}
	public function getSignPackage() {
		$jsapiTicket = $this->getJsApiTicket ();
		
		// 注意 URL 一定要动态获取，不能 hardcode.
		$protocol = (! empty ( $_SERVER ['HTTPS'] ) && $_SERVER ['HTTPS'] !== 'off' || $_SERVER ['SERVER_PORT'] == 443) ? "https://" : "http://";
		$url = "$protocol$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		
		$timestamp = time ();
		$nonceStr = $this->createNonceStr ();
		
		// 这里参数的顺序要按照 key 值 ASCII 码升序排序
		$string = "jsapi_ticket=$jsapiTicket&noncestr=$nonceStr&timestamp=$timestamp&url=$url";
		
		$signature = sha1 ( $string );
		
		$signPackage = array (
				"appId" => $this->appId,
				"nonceStr" => $nonceStr,
				"timestamp" => $timestamp,
				"url" => $url,
				"signature" => $signature,
				"rawString" => $string 
		);
		return $signPackage;
	}
	private function createNonceStr($length = 16) {
		$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
		$str = "";
		for($i = 0; $i < $length; $i ++) {
			$str .= substr ( $chars, mt_rand ( 0, strlen ( $chars ) - 1 ), 1 );
		}
		return $str;
	}
	private function getJsApiTicket() {
		$data = json_decode ( $this->get_php_file ( "jsapi_ticket" ) );
		$ticket='';
		if (! isset ( $data->expire_time ) || $data->expire_time < time ()) {
			$accessToken = $this->getAccessToken ();
			// 如果是企业号用以下 URL 获取 ticket
			if ($this->openbs)
				$url = "https://qyapi.weixin.qq.com/cgi-bin/get_jsapi_ticket?access_token=$accessToken";
			else
				$url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?type=jsapi&access_token=$accessToken";
            if($this->debug){
                $this->set_log_file("debug", $this->httpGet($url));
            }

			$res = json_decode ( $this->httpGet ( $url ) );
			if(isset($res->ticket))
				$ticket = $res->ticket;
			if ($ticket) {
				$data = new stdClass ();
				$data->expire_time = time () + 7000;
				$data->jsapi_ticket = $ticket;
				$this->set_php_file ( "jsapi_ticket", json_encode ( $data ) );
			}
		} else {
			isset ( $data->jsapi_ticket ) ? $ticket = $data->jsapi_ticket : $ticket = null;
		}
		
		return $ticket;
	}
	private function getAccessToken() {
		$data = json_decode ( $this->get_php_file ( "access_token" ) );
		$access_token='';
		if (! isset ( $data->expire_time ) || $data->expire_time < time ()) {
			// 如果是企业号用以下URL获取access_token
			if ($this->openbs)
				$url = "https://qyapi.weixin.qq.com/cgi-bin/gettoken?corpid=$this->appId&corpsecret=$this->appSecret";
			else
				$url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$this->appId&secret=$this->appSecret";
			$res = json_decode ( $this->httpGet ( $url ) );
			if(isset($res->access_token))
				$access_token = $res->access_token;
			if ($access_token) {
				$data = new stdClass ();
				$data->expire_time = time () + 7000;
				$data->access_token = $access_token;
				$this->set_php_file ( "access_token", json_encode ( $data ) );
			}
		} else {
			$access_token = $data->access_token;
		}
		return $access_token;
	}
	private function httpGet($url) {
		$res = wp_remote_retrieve_body ( wp_remote_get ( $url, array (
				'timeout' => 120 
		) ) );
		return $res;
	}
	private function get_php_file($filename) {
		$filefull = APOYL_WEIXINSHARE_DIR . 'public/cache/' . $filename . '.php';
		if (! file_exists ( $filefull ))
			return '';
		$fp = fopen ( $filefull, 'r' );
		$re = fread ( $fp, filesize ( $filefull ) );
		return trim ( substr ( $re, 15 ) );
	}
	private function set_php_file($filename, $content) {
		$filefull = APOYL_WEIXINSHARE_DIR . 'public/cache/' . $filename . '.php';
		
		$fp = fopen ( $filefull, "w" );
		fwrite ( $fp, "<?php exit();?>" . $content );
		fclose ( $fp );
	}
    private function set_log_file($filename, $content) {
        $filefull = APOYL_WEIXINSHARE_DIR . 'public/cache/' . $filename . '.log';

        $fp = fopen ( $filefull, "a");
        fwrite ( $fp,  $content.chr(13).chr(10) );
        fclose ( $fp );
    }
}