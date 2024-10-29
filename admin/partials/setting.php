<?php
/*
 * @link       http://www.girltm.com
 * @since      1.0.0
 * @package    Apoyl_Weixinshare
 * @subpackage Apoyl_Weixinshare/admin/partials
 * @author     凹凸曼 <jar-c@163.com>
 *
 */
$options_name='apoyl-weixinshare-settings';
if(!empty($_POST['submit'])&&check_admin_referer('apoyl-weixinshare-settings','_wpnonce')){

	
    $arr_options=array(
    	'openapifriends'=>	isset ( $_POST ['openapifriends'] ) ? ( int ) sanitize_key ( $_POST ['openapifriends'] ) :  0,
    	'openapifriend'=> isset ( $_POST ['openapifriend'] ) ? ( int ) sanitize_key ( $_POST ['openapifriend'] ) :  0,
        'appid'=>sanitize_text_field($_POST['appid']),
        'appsecret'=>sanitize_text_field($_POST['appsecret']),
        'opendicon'=>esc_url_raw(trim($_POST['opendicon'])),
        'description'=>sanitize_text_field($_POST['description']),
    	'openforcelogo'=> isset ( $_POST ['openforcelogo'] ) ? ( int ) sanitize_key ( $_POST ['openforcelogo'] ) :  0,
    	'opendebug'=> isset ( $_POST ['opendebug'] ) ? ( int ) sanitize_key ( $_POST ['opendebug'] ) :  0,
    	'opencover'=> isset ( $_POST ['opencover'] ) ? ( int ) sanitize_key ( $_POST ['opencover'] ) :  0,
    );

    $updateflag=update_option($options_name, $arr_options);
    $updateflag=true;
}
$arr=get_option($options_name);

?>
<?php if( !empty( $updateflag ) ) { echo '<div id="message" class="updated fade"><p>' . __('updatesuccess','apoyl-weixinshare') . '</p></div>'; } ?>

<h1 class="wp-heading-inline"><?php _e('settings','apoyl-weixinshare'); ?></h1>
<ul class='subsubsub'>
	<li><a href="options-general.php?page=apoyl-weixinshare-settings"
		<?php if($do!='list') echo 'class="current"';?> aria-current="page">设置接口<span
			class="count"></span></a> |</li>
	<li><a href="options-general.php?page=apoyl-weixinshare-settings&do=list"
		<?php if($do=='list') echo 'class="current"';?>>分享记录<span
			class="count"></span></a></li>
</ul>
<br><br>
<p>
解决在微信里首页、文章、页面等（如post, page, attachment, revision, menu）分享到朋友或朋友圈，图标无法显示，描述更改为部分文章内容或者文章摘要;需已认证的订阅号或者服务号,<a href="https://mp.weixin.qq.com/" target="_blank">点击微信官方申请</a>;<p><strong>开发者QQ:3201361925  官方平台：<a href="http://www.girltm.com" target="_blank">凹凸曼插件</a></strong></p>
</p>
<div class="wrap">

<form action="<?php echo admin_url('options-general.php?page=apoyl-weixinshare-settings');?>" name="settings-apoyl-weixinshare" method="post">
<table class="form-table">
                <tbody>
                <tr>
                    <th><label><?php _e('openapi','apoyl-weixinshare'); ?></label></th>
                    <td>
                    <fieldset>
                    <label><input name="openapifriends" type="checkbox" value="1" <?php if($arr['openapifriends']) _e('checked="checked"');?>><?php _e('openapifriends','apoyl-weixinshare'); ?> </label>
                    <br>
                    <label><input name="openapifriend" type="checkbox" value="1" <?php if($arr['openapifriend']) _e('checked="checked"');?>><?php _e('openapifriend','apoyl-weixinshare'); ?> </label>
        			</fieldset>
        			 <p class="description"><?php _e('openapidesc','apoyl-weixinshare'); ?></p>
                    </td>
                    
                </tr>
                <tr>
                    <th><label><?php _e('appid','apoyl-weixinshare'); ?></label></th>
                    <td><input type="text" class="regular-text" value="<?php _e($arr['appid']); ?>" id="appid" name="appid">
                    <p class="description"><?php _e('appiddesc','apoyl-weixinshare'); ?></p>
                    </td>
                    
                </tr>
               <tr>
                    <th><label><?php _e('appsecret','apoyl-weixinshare'); ?></label></th>
                    <td><input type="text" class="regular-text" value="<?php _e($arr['appsecret']); ?>" id="appsecret" name="appsecret">
                    <p class="description"><?php _e('appsecretdesc','apoyl-weixinshare'); ?></p>
                    </td>
                    
                </tr>
                 <tr>
                    <th><label><?php _e('opendicon','apoyl-weixinshare'); ?></label></th>
                    <td><input type="text" class="regular-text" value="<?php _e($arr['opendicon']); ?>" id="opendicon" name="opendicon">
                    <p class="description"><?php _e('opendicondesc','apoyl-weixinshare'); ?></p>
                    </td>
                    
                </tr>
       			<tr>
                    <th><label><?php _e('description','apoyl-weixinshare'); ?></label></th>
                    <td><input type="text" class="regular-text" value="<?php _e($arr['description']); ?>" id="description" name="description">
                    <p class="description"><?php _e('descriptiondesc','apoyl-weixinshare'); ?></p>
                    </td>
                    
                </tr>
                <tr>
                    <th><label>品牌LOGO推广</label></th>
                    <td><input name="openforcelogo" type="checkbox" value="1" <?php if($arr['openforcelogo']) _e('checked="checked"');?>>
        			 <p class="description">强制品牌LOGO推广，此功能需要付费版才能自动生效，点击购买：<a href="http://www.girltm.com" target="_blank">凹凸曼插件</a> 或 开发者QQ:3201361925</p>
                    </td>
                    
                </tr>
                <tr>
                    <th><label>分享WooCommerce产品图片</label></th>
                    <td><input name="opencover" type="checkbox" value="1" <?php if(isset($arr['opencover'])&&$arr['opencover']>0) _e('checked="checked"');?>>
        			 <p class="description">分享WooCommerce产品，在微信自动分享产品图片 此功能需要付费版才能自动生效，点击购买：<a href="http://www.girltm.com" target="_blank">凹凸曼插件</a> 或 开发者QQ:3201361925</p>
                    </td>
                    
                </tr>
                 <tr>
                    <th><label>DEBUG</label></th>
                    <td><input name="opendebug" type="checkbox" value="1" <?php if(isset($arr['opendebug'])&&$arr['opendebug']>0) _e('checked="checked"');?>>
        			 <p class="description">此功能需要付费版才能自动生效，点击购买：<a href="http://www.girltm.com" target="_blank">凹凸曼插件</a> 或 开发者QQ:3201361925</p>
                    </td>
                    
                </tr>
                </tbody>
            </table>
            <?php 
            wp_nonce_field("apoyl-weixinshare-settings");
            submit_button(); 
            ?>
           
</form>
</div>