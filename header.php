<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <title>Universal_Magro</title> -->
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<header class="header">
    <div class="container">
        <div class="header-wrapper">
            <!-- <img src="<?php /*echo get_template_directory_uri() . '/assets/images/logo.png'*/ ?>" alt=""> -->
            <?php /* проверяем, есть ли логотип кастомный */
                if( has_custom_logo() ){
                	the_custom_logo(); // логотип есть - выводим его
                } else {
                    echo "Universal";
                }
            ?>
            <?php
                wp_nav_menu( [
                    'theme_location'  => 'header_menu', 
                    'container'       => 'nav', 
                    'container_class' => 'header-nav', 
                    'menu_class'      => 'header-menu', 
                    'echo'            => true, // выводить ли меню
                ] );

            get_search_form(); ?>
            <a href="#" class="header-menu-toggle">
                <span></span>
                <span></span>
                <span></span>
            </a>
        </div>
    </div>
</header>
    