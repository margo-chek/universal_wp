<?php

// если ли уже зарегистрированная функция, которая настраивает нашу тему,
//т.е. если функция universal_theme_setup еще не существует, то
if ( ! function_exists( 'universal_theme_setup' ) ) :
    // давайте ее создадим и внутри будем создавать разные фичи - добавление расширений внутри темы
	function universal_theme_setup() {
        // добавим тега тайтл - title-tag
        add_theme_support( 'title-tag' );

        // возможность добавления миниатюр - разрешаем добавлять
        add_theme_support( 'post-thumbnails', array( 'post' ) ); // Только для post

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

/**
 * подключение сайдбара
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function universal_theme_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Сайдбар справа на главной', 'universal-theme' ),
			'id'            => 'sidebar-main',
			'description'   => esc_html__( 'Добавьте виджеты сюда', 'universal-theme' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'universal_theme_widgets_init' );


/**
 * Добавление нового виджета Downloader_Widget.
 */
class Downloader_Widget extends WP_Widget {

	// Регистрация виджета используя основной класс
	function __construct() {
		// вызов конструктора выглядит так:
		// __construct( $id_base, $name, $widget_options = array(), $control_options = array() )
		parent::__construct(
			'downloader_widget', // ID виджета, если не указать (оставить ''), то ID будет равен названию класса в нижнем регистре: downloader_widget
			'Полезные файлы',
			array( 'description' => 'Файлы для скачивания', 'classname' => 'widget-downloader', )
		);

		// скрипты/стили виджета, только если он активен
		if ( is_active_widget( false, false, $this->id_base ) || is_customize_preview() ) {
			add_action('wp_enqueue_scripts', array( $this, 'add_downloader_widget_scripts' ));
			add_action('wp_head', array( $this, 'add_downloader_widget_style' ) );
		}
	}

	/**
	 * Вывод виджета во Фронт-энде
	 *
	 * @param array $args     аргументы виджета.
	 * @param array $instance сохраненные данные из настроек
	 */
	function widget( $args, $instance ) {
        // $title = apply_filters( 'widget_title', $instance['title'] ); // упростим
        $title = $instance['title'];
        $description = $instance['description'];
        $link = $instance['link'];

		echo $args['before_widget'];
		if ( ! empty( $title ) ) {
			echo $args['before_title'] . $title . $args['after_title'];
        }
        if ( ! empty( $description ) ) {
			echo '<p class="description">' . $description . '</p>';
        }
        if ( ! empty( $link ) ) {
            echo '<a target="_blank" class="widget-link" href="' . $link . '">
            <img class="widget-link-icon" src="' . get_template_directory_uri() . '/assets/images/download.svg">
            Скачать</a>';
		}
		echo $args['after_widget'];
	}

	/**
	 * Админ-часть виджета
	 *
	 * @param array $instance сохраненные данные из настроек
	 */
	function form( $instance ) {
        $title = @ $instance['title'] ?: 'Полезные файлы'; // Заголовок по умолчанию
        $description = @ $instance['description'] ?: 'текст'; // добавляем по подобию вывод описания
        $link = @ $instance['link'] ?: 'http://yandex.ru/'; // добавляем вывод ссылки

		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
        <p>
			<label for="<?php echo $this->get_field_id( 'description' ); ?>"><?php _e( 'Описание:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'description' ); ?>" name="<?php echo $this->get_field_name( 'description' ); ?>" type="text" value="<?php echo esc_attr( $description ); ?>">
		</p>
        <p>
			<label for="<?php echo $this->get_field_id( 'link' ); ?>"><?php _e( 'Ссылка на файл:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'link' ); ?>" name="<?php echo $this->get_field_name( 'link' ); ?>" type="text" value="<?php echo esc_attr( $link ); ?>">
		</p>
		<?php 
	}

	/**
	 * Сохранение настроек виджета. Здесь данные должны быть очищены и возвращены для сохранения их в базу данных.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance новые настройки
	 * @param array $old_instance предыдущие настройки
	 *
	 * @return array данные которые будут сохранены
	 */
	function update( $new_instance, $old_instance ) {
		$instance = array();
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        $instance['description'] = ( ! empty( $new_instance['description'] ) ) ? strip_tags( $new_instance['description'] ) : '';
        $instance['link'] = ( ! empty( $new_instance['link'] ) ) ? strip_tags( $new_instance['link'] ) : '';

		return $instance;
	}

	// скрипт виджета
	function add_downloader_widget_scripts() {
		// фильтр чтобы можно было отключить скрипты
		if( ! apply_filters( 'show_downloader_widget_script', true, $this->id_base ) )
			return;

		$theme_url = get_stylesheet_directory_uri();

		wp_enqueue_script('downloader_widget_script', $theme_url .'/downloader_widget_script.js' );
	}

	// стили виджета
	function add_downloader_widget_style() {
		// фильтр чтобы можно было отключить стили
		if( ! apply_filters( 'show_downloader_widget_style', true, $this->id_base ) )
			return;
		?>
		<style type="text/css">
			.downloader_widget a{ display:inline; }
		</style>
		<?php
	}

} 
// конец класса Downloader_Widget

// регистрация Downloader_Widget в WordPress
function register_downloader_widget() {
	register_widget( 'Downloader_Widget' );
}
add_action( 'widgets_init', 'register_downloader_widget' );



// правильный способ подключить стили и скрипты
function enqueue_universal_style() {
	wp_enqueue_style('Roboto-Slab', '//fonts.googleapis.com/css2?family=Roboto+Slab:wght@700&display=swap');
    // подключаем шрифт из https://fonts.google.com
    wp_enqueue_style( 'style', get_stylesheet_uri() );
    wp_enqueue_style( 'universal-theme-style', get_template_directory_uri() . '/assets/css/universal-theme.css' , 'style', time());
    // выполнить universal-theme.css сразу ПОСЛЕ style.css
    // time() - чтобы не кешировались стили  
}
add_action( 'wp_enqueue_scripts', 'enqueue_universal_style' ); // хук

## отключаем создание миниатюр файлов для указанных размеров
add_filter( 'intermediate_image_sizes', 'delete_intermediate_image_sizes' );
function delete_intermediate_image_sizes( $sizes ){
	// размеры которые нужно удалить
	return array_diff( $sizes, [
		'medium_large',
		'large',
		'1536x1536',
		'2048x2048',
	] );
}

// изменяем настройки облака тегов
add_filter( 'widget_tag_cloud_args', 'edit_widget_tag_cloud_args' );
function edit_widget_tag_cloud_args($args) {
	$args['unit'] = 'px'; // единицы измерения
	$args['smallest'] = '14'; // минимальный размер
	$args['largest'] = '14'; // максимальный размер
	$args['number'] = '13'; // количество выводимых тегов
	return $args;
}

// обрезает заголовок на $count - символов, в конце подставляет $after
// в коде вместо <?php the_title();  нужно писать н-р, <?php trim_title_chars(30, '...');
function trim_title_chars($count, $after) {
	$title = get_the_title();
	if (mb_strlen($title) > $count) $title = mb_substr($title, 0, $count);
	else $after = '';
	echo $title . $after;
}

// обрезает заголовок на $count - слов, в конце подставляет $after
// в коде вместо <?php the_title();  нужно писать н-р, <?php trim_title_words(5, '...');
function trim_title_words($count, $after) {
	$title = get_the_title();
	$words = explode(' ', $title);
	if (count($words) > $count) {
		array_splice($words, $count);
		$title = implode(' ', $words);
	}
	else $after = '';
	echo $title . $after;
}

