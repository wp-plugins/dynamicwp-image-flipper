<?php
/*
Plugin Name: Dynamicwp Image Flipper
Plugin URI: http://www.dynamicwp.net/plugins/
Description: The Plugin will build your image gallery as a book pages that can be flipped to next or previous page. Click or drag the animated corners shown when hovering on the gallery area to make flipping effect. The plugin is based on: <a href="http://www.jquery.info/spip.php?article78/">jquery.info</a>
Author: Reza Erauansyah
Version: 1.0
Author URI: http://www.dynamicwp.net
*/

// =============================== flipper widget ======================================
function DWFlipperWidget($args)
{
  $linkss = WP_PLUGIN_URL.'/'.str_replace(basename( __FILE__),"",plugin_basename(__FILE__)); 
  echo "<!--[if IE]><script type=\"text/javascript\" charset=\"utf-8\" src=\"".$linkss."excanvasX.js\"></script><![endif]-->";
  echo "<script type=\"text/javascript\" charset=\"utf-8\" src=\"".$linkss."flip.js\"></script>";
  echo "<script type=\"text/javascript\" charset=\"utf-8\">
  jQuery(document).ready(function() {
	jQuery(\"#DW_flipper\").jFlip(200, 200,{\"path\":\"\",\"background\":\"#DFDFDF\",\"cornersTop\":1,\"width\":200,\"height\":200,\"scale\":\"noresize\"});
	});
 </script>";
  extract($args);
  $settings2 = get_option("DW_flipper_title");
  echo $before_widget;
  echo $before_title;?><?php echo $settings2; ?><?php echo $after_title;
  echo '<center>';
  echo "<div ID='DW_flipper'>";
	 $option = get_option("DW_flipper_image");
     if($option) {
         $values = explode(",", $option);
    	 if(is_array($values)) {
    	 	foreach ($values as $item) {
    		 	if(!empty($item)) {
    		 		echo "<img src=\"$item\" alt=\"\" title=\"\" /> \n";
    		 	}
    		 }
    	 }
     }
  echo "</div><span style='font-size: 9px;'>widget by <a href='http://www.dynamicwp.net' target='_blank'>Dynamicwp.net</a></span>";
  echo '</center>';
  echo $after_widget;
}

function DWFlipperWidgetAdmin() {

	$settings = get_option("DW_flipper_image");
	$settings2 = get_option("DW_flipper_title");

	// check if anything's been sent
	if (isset($_POST['update_DW_flipper'])) {
		$settings = strip_tags(stripslashes($_POST['DW_flipper_image']));
		$settings2 = strip_tags(stripslashes($_POST['DW_flipper_title']));

		update_option("DW_flipper_image",$settings);
		update_option("DW_flipper_title",$settings2);
	}
	
	echo '<p>
			Title:
			<input id="DW_flipper_title" name="DW_flipper_title" type="text" class="widefat" value="'.$settings2.'" /></p>';	

	echo '<p>
			Images link (separate between links with comma. use full path!, ie http://):
			<textarea id="DW_flipper_image" name="DW_flipper_image" type="textarea" rows="10"class="widefat">'.$settings.'</textarea></p>';

	echo '<input type="hidden" id="update_DW_flipper" name="update_DW_flipper" value="1" />';

}

function mypuncflip(){
	wp_enqueue_script('jquery');
	
	}


if(!is_admin()){
   add_action('wp_head', 'mypuncflip', 1);
}
register_sidebar_widget('Dynamicwp Image Flipper', 'DWFlipperWidget');
register_widget_control('Dynamicwp Image Flipper', 'DWFlipperWidgetAdmin', 400, 600);
?>