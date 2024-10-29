<?php
/*
 * @link http://www.girltm.com
 * @since 1.2.0
 * @package Apoyl_Weixinshare
 * @subpackage Apoyl_Weixinshare/public/partials
 * @author 凹凸曼 <jar-c@163.com>
 *
 */
?>
<?php
$file = apoyl_weixinshare_file('scriptgetmeta');
if ($file){
    include $file;
}else{
?>
<script>
function apoyl_weixinshare_getMeta(){
	var obj=document.getElementsByTagName('meta');
	var desc='<?php echo $desc;?>';
	for(i in obj){
		if(typeof obj[i].name=='undefined')
			continue;
		if(obj[i].name.toLowerCase()=='description'&&obj[i].content.trim().length>6){		
			desc=obj[i].content;
			break;
		}
	}
	return desc;
}
</script>
<?php }?>
<script>
wx.config({
	 <?php if($arr['opendebug']){ ?>
    debug: true, 
    <?php }else{ ?>
    debug: false, 
    <?php }?>
	appId: '<?php echo $signPackage["appId"];?>',
	timestamp: '<?php echo $signPackage["timestamp"];?>',
	nonceStr: '<?php echo $signPackage["nonceStr"];?>',
	signature: '<?php echo $signPackage["signature"];?>',
	jsApiList: [
 <?php if($arr['openapifriends']){ ?>
  'updateTimelineShareData',
 <?php }?>
 <?php if($arr['openapifriend']){ ?>
     'updateAppMessageShareData'
    <?php }?>
]
});
</script>

<?php
$file = apoyl_weixinshare_file('scriptgo');
if ($file){
    include $file;
}else{
?>
<script>
wx.ready(function () {
	  var apoyl_weixinshare_title=document.title;
	  var apoyl_weixinshare_link=window.location.href;
	  var apoyl_weixinshare_desc=apoyl_weixinshare_getMeta();
	  
	<?php if($arr['openapifriends']){?>
	  wx.updateTimelineShareData({
		    title: apoyl_weixinshare_title, 
		    link: apoyl_weixinshare_link, 
		    imgUrl:'<?php echo $imgurl;?>', 
			success: function () {
				
			}
		});

    <?php } ?>

	<?php if($arr['openapifriend']){?>
	  wx.updateAppMessageShareData({
		    title: apoyl_weixinshare_title, 
		    desc: apoyl_weixinshare_desc, 
		    link: apoyl_weixinshare_link, 
		    imgUrl:'<?php echo $imgurl;?>', 
			success: function () {
	
			}
		});
    <?php } ?>
});
</script>
<?php }?>
