<?php


/*  Copyright 2009  Waseem Senjer  (email : waseem.senjer@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/



/*
Plugin Name: WP-Quotes
Plugin URI: http://www.shamekh.ws
Description: simple widget shows live qoutes from some websites
Author: Waseem Senjer 
Version: 1.0 
Author URI: http://www.shamekh.ws
*/




function wp_quotes()
{
$items=@get_feed2();


$options = (array) get_option('widget_wp_quotes');


  
  
  
   if (empty($items)) {
   // when items is NULL or fail to fetch the rss
   echo '<li>"We know what we are, but know not what we may be."</li>';}
else{
	// echo the results
foreach ( $items as $item ) : 
echo "<ul>";
echo "<li>".$item['description']."</li>";
echo "</ul>"; 

 endforeach; 
}
}





////the widget function

function widget_wp_quotes($args) {
  extract($args);
  $defaults = array('title'=>'Quotes' , 'site'=>'unchecked');
  $options = (array) get_option('widget_wp_quotes');
  
  
  echo $before_widget;
  echo $before_title;
 
  if ($options['title']!="") {
  echo $options['title'];
  } else { echo $defaults['title']; }
  
  echo $after_title;
  wp_quotes();
  echo $after_widget;
}
/////////////////////////////////////////////////



//////////////////////////////////////////////////
function wp_quotes_init()
{
  register_sidebar_widget(__('Quotes'), 'widget_wp_quotes'); 
  register_widget_control('Quotes', 'wp_quotes_control');  
}
add_action("plugins_loaded", "wp_quotes_init");

////////////////////////////////////////////////////
function get_feed2(){
		
 // Get RSS Feed(s)
include_once(ABSPATH . WPINC . '/rss.php');
$x=rand(0,1);

if ($x==0) {
$rss = @fetch_rss('http://feeds.feedburner.com/brainyquote/QUOTEBR');
} else {
$rss = @fetch_rss('http://feeds2.feedburner.com/quotationspage/CaEl');
}
$maxitems = 1;
$items = array_slice($rss->items, 0, $maxitems,false);
return $items;

}
//////////////////////////////////////////////////////
// CONTROL
function wp_quotes_control () {
		$options = $newoptions = get_option('widget_wp_quotes');
		if ( $_POST['wp_quotes-submit'] ) {
			$newoptions['title'] = strip_tags(stripslashes($_POST['wp_quotes-title']));
			
			
			
			
		}
		// if the options are new , swap between the old and the new options .
		if ( $options != $newoptions ) {
			$options = $newoptions;
			update_option('widget_wp_quotes', $options);
		}
?>
				<p style="text-align: right">
					<label for="wp_quotes-title" ><?php _e('Widget Name:', 'widgets'); ?> <input type="text" id="wp_quotes-title" name="wp_quotes-title" value="<?php echo $options['title']; ?>" /></label>
				</p>
				
				<p style="text-align: right">
					
					<input type="hidden" name="wp_quotes-submit" id="feeds-submit" value="1" />
				</p>				
<?php
	}

?>