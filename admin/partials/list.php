<?php
/*
 * @link       http://www.girltm.com
 * @since      1.1.0
 * @package    Apoyl_Weixinshare
 * @subpackage Apoyl_Weixinshare/admin/partials
 * @author     凹凸曼 <jar-c@163.com>
 *
 */
$ishave=false;
$file=apoyl_weixinshare_file('list');
if($file)
    include $file;
if(!$ishave){
?>
<h1 class="wp-heading-inline"><?php _e('settings','apoyl-weixinshare'); ?></h1>
<ul class='subsubsub'>
	<li><a href="options-general.php?page=apoyl-weixinshare-settings"
		<?php if($do!='list') echo 'class="current"';?> aria-current="page">设置接口<span
			class="count"></span></a> |</li>
	<li><a href="options-general.php?page=apoyl-weixinshare-settings&do=list"
		<?php if($do=='list') echo 'class="current"';?>>分享记录<span
			class="count"></span></a></li>
</ul>
<br>
<br>
此功能需要付费版才能自动生效，点击购买：<a href="http://www.girltm.com" target="_blank">凹凸曼插件</a> 或 开发者QQ:3201361925
<?php 
}?>