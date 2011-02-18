<?php
	$plugin_dir = '/wp-content/plugins/'.basename(dirname(__FILE__));
?>
<script type="text/javascript">

function resizeMe(){ 
	var docHeight;
	docHeight = fbcomcon_frame.document.body.scrollHeight;
	docHeight += 10;
	document.getElementById('fbcomcon_frame').style.height = docHeight + 'px';
 } 
</script>
 
<iframe id="fbcomcon_frame" name="fbcomcon_frame" onload="setTimeout('resizeMe()',2000)"
src="<?php echo $plugin_dir;?>/fbcomcon_db_iframe.php" scrolling="no" style="width:100%;height:265px;"></iframe>