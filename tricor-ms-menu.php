<?php
/*
Plugin Name: Tricor Custom Menu
Plugin URI: http://www.2020compute.com/
Description: Add Custom Menu
Version: 1.0
Author: Gulshan Thakare
Author URI: http://www.2020compute.com/
*/
class subMenu extends Walker_Nav_Menu {
    function end_el(&$output, $item, $depth=0, $args=array()) {

    if( 'Item 3' == $item->title ){
        $output .= '<ul class="sub-menu">
        <li class="menu-item" id="menu-item-48"><a href="http://www.example.com/child1.com">child 1</a></li>
        <li class="menu-item" id="menu-item-49"><a href="http://www.example.com/child2.com">child 2</a></li>
        <li class="menu-item" id="menu-item-50"><a href="http://www.example.com/child3.com">child 3</a></li>
        </ul>';
    }
    $output .= "</li>\n";  
    }
}
function print_menu_shortcode($atts, $content = null) {
    extract(shortcode_atts(array( 'name' => null, ), $atts));
    //return wp_nav_menu( array( 'menu' => $name, 'echo' => false ) );

	 $output = wp_nav_menu( array( 
		'menu'            => 'micro-site', 
		'container'       => 'div', 
		'container_class' => 'tricor-navbar-content', 
		'container_id'    => '', 
		'menu_class'      => 'tricor-navbar', 
		'menu_id'         => '',
		'echo'            => false,
		'fallback_cb'     => '',
		'before'          => '',
		'after'           => '',
		'link_before'     => '',
		'link_after'      => '',
		'depth'           => 1,
		'walker'          => new subMenu,
		'theme_location'  => ''));
		
		return $output;
}
add_shortcode('menu', 'print_menu_shortcode');