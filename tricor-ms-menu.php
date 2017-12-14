<?php
/*
Plugin Name: Tricor Custom Menu
Plugin URI: http://www.2020compute.com/
Description: Add Custom Menu
Version: 1.0
Author: Gulshan Thakare
Author URI: http://www.2020compute.com/
*/
class Wpse8170_Menu_Walker extends Walker_Nav_Menu {

    var $number = 1;

    function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
        $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

        $class_names = $value = '';

        $classes = empty( $item->classes ) ? array() : (array) $item->classes;
        $classes[] = 'menu-item-' . $item->ID;

        $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
        $class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

        $id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
        $id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

        $output .= $indent . '<li' . $id . $value . $class_names .'>';

        // add span with number here
        if ( $depth == 0 ) { // remove if statement if depth check is not required
            $output .= sprintf( '<span>%02s.</span>', $this->number++ );
        }

        $atts = array();
        $atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
        $atts['target'] = ! empty( $item->target )     ? $item->target     : '';
        $atts['rel']    = ! empty( $item->xfn )        ? $item->xfn        : '';
        $atts['href']   = ! empty( $item->url )        ? $item->url        : '';

        $atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args );

        $attributes = '';
        foreach ( $atts as $attr => $value ) {
            if ( ! empty( $value ) ) {
                $value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
                $attributes .= ' ' . $attr . '="' . $value . '"';
            }
        }

        $item_output = $args->before;
        $item_output .= '<a'. $attributes .'>';
        $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
        $item_output .= '</a>';
        $item_output .= $args->after;

        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    }

}
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
		'depth'           => 2,
		'walker'          => new Wpse8170_Menu_Walker,
		'theme_location'  => ''));
		
		return $output;
}
add_shortcode('menu', 'print_menu_shortcode');