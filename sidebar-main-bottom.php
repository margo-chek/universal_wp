<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package universal-theme
 */

if ( ! is_active_sidebar( 'sidebar-main-bottom' ) ) {
	return;
}
?>

<aside class="sidebar-front-page sidebar-front-page-bottom">
	<?php dynamic_sidebar( 'sidebar-main-bottom' ); ?>
</aside>

