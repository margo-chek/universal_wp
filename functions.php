<?php

// если ли уже зарегистрированная функция, которая настраивает нашу тему,
//т.е. если функция universal_theme_setup еще не существует, то
if ( ! function_exists( 'universal_theme_setup' ) ) :
    // давайте ее создадим и внутри будем создавать разные фичи - добавление расширений внутри темы
	function universal_theme_setup() {
        // добавим тега тайтл - title-tag
        add_theme_support( 'title-tag' );

        // добавление пользовательского логотипа
        add_theme_support( 'custom-logo', [
            // 'height'      => 190,
            'width'       => 163,
            // 'flex-width'  => false, // резиновая ширина
            'flex-height' => true, // резиновая высота
            'header-text' => 'Universal',
            'unlink-homepage-logo' => false, // WP 5.5 - убирает ссылку на главную страницу
        ] );

        // регистрация меню
        register_nav_menus( [ // создает дырки под меню на сайте
            'header_menu' => 'Меню в шапке',
            'footer_menu' => 'Меню в подвале'
        ] );
    }
endif; // проверка закончена
add_action( 'after_setup_theme', 'universal_theme_setup' ); //сразу при загрузке страницы / после инициализации темы - подключаемся к хук-событию after_setup_theme и как только оно сработает, запустится функция universal_theme_setup

// правильный способ подключить стили и скрипты
function enqueue_universal_style() {
    wp_enqueue_style( 'style', get_stylesheet_uri() );
    wp_enqueue_style( 'universal-theme-style', get_template_directory_uri() . '/assets/css/universal-theme.css' , 'style', time());
    // выполнить universal-theme.css сразу ПОСЛЕ style.css
    // time() - чтобы не кешировались стили
    wp_enqueue_style('Roboto-Slab', 'https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@700&display=swap');
    // подключаем шрифт из https://fonts.google.com
}
add_action( 'wp_enqueue_scripts', 'enqueue_universal_style' ); // хук
