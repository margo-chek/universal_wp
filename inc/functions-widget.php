<?php

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
	 * @param array $args аргументы виджета.
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



/**
 * Добавление нового виджета Social_Icons_Widget.
 */
class Social_Icons_Widget extends WP_Widget {

	// Регистрация виджета используя основной класс
	function __construct() {
		// вызов конструктора выглядит так:
		// __construct( $id_base, $name, $widget_options = array(), $control_options = array() )
		parent::__construct(
			'social_icons_widget', // ID виджета, если не указать (оставить ''), то ID будет равен названию класса в нижнем регистре: social_icons_widget
			'Социальные сети',
			array( 'description' => 'название соц.сети', 'classname' => 'widget-social-icons', )
		);

		// скрипты/стили виджета, только если он активен
		if ( is_active_widget( false, false, $this->id_base ) || is_customize_preview() ) {
			add_action('wp_enqueue_scripts', array( $this, 'add_social_icons_widget_scripts' ));
			add_action('wp_head', array( $this, 'add_social_icons_widget_style' ) );
		}
	}

	/**
	 * Вывод виджета во Фронт-энде
	 *
	 * @param array $args аргументы виджета.
	 * @param array $instance сохраненные данные из настроек
	 */
	function widget( $args, $instance ) {
		$title_social_icons = $instance['title_social_icons'];
        // $social_network_name = $instance['social_network_name'];
		$link_facebook = $instance['link_facebook'];
		$link_twitter = $instance['link_twitter'];
		$link_youtube = $instance['link_youtube'];
		$link_instagram = $instance['link_instagram'];

		echo $args['before_widget'];
		if ( ! empty( $title_social_icons ) ) {
			echo $args['before_title'] . $title_social_icons . $args['after_title'];
		}
		echo '<div class="widget-icons">';
		if ( ! empty ( $link_facebook )) {
			echo '<a href=' . $link_facebook . ' class="social-network-button facebook"></a>';
        }
        if ( ! empty ( $link_twitter )) {
			echo '<a href=' . $link_twitter . ' class="social-network-button twitter"></a>';
        }
        if ( ! empty ( $link_youtube )) {
			echo '<a href=' . $link_youtube . ' class="social-network-button youtube"></a>';
		}
		 if ( ! empty ( $link_instagram )) {
			echo '<a href=' . $link_instagram . ' class="social-network-button instagram"></a>';
		}
		// echo '</div>';
        echo $args['after_widget'];
	}

	/**
	 * Админ-часть виджета
	 *
	 * @param array $instance сохраненные данные из настроек
	 */
	function form( $instance ) {
		$title_social_icons = @ $instance['title_social_icons'] ?: 'Наши соцсети'; // Заголовок по умолчанию
        // $social_network_name = @ $instance['social_network_name'] ?: 'social_network_name'; // название соцсети
		$link_facebook = @ $instance['link_facebook'] ?: 'https://www.facebook.com/'; // добавляем вывод ссылки
		$link_twitter = @ $instance['link_twitter'] ?: 'https://www.twitter.com/';
		$link_youtube = @ $instance['link_youtube'] ?: 'https://www.youtube.com/';
		$link_instagram = @ $instance['link_instagram'] ?: 'https://www.instagram.com/';

		?>
        <p>
			<label for="<?php echo $this->get_field_id( 'title_social_icons' ); ?>"><?php _e( 'Title:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'title_social_icons' ); ?>" name="<?php echo $this->get_field_name( 'title_social_icons' ); ?>" type="text" value="<?php echo esc_attr( $title_social_icons ); ?>">
		</p>
		<p>
			<?php _e( 'facebook' ); ?>
			<!-- <label for="<?php echo $this->get_field_id( 'social_network_name' ); ?>"><?php _e( 'Название соцсети:' ); ?></label>  -->
			<!-- <input class="widefat" id="<?php echo $this->get_field_id( 'social_network_name' ); ?>" name="<?php echo $this->get_field_name( 'social_network_name' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>"> -->
		</p>
        <p>
			<label for="<?php echo $this->get_field_id( 'link_facebook' ); ?>"><?php _e( 'Ссылка на страницу:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'link_facebook' ); ?>" name="<?php echo $this->get_field_name( 'link_facebook' ); ?>" type="text" value="<?php echo esc_attr( $link_facebook ); ?>">
		</p>
        <p>
			<?php _e( 'twitter' ); ?>
			<!-- <label for="<?php echo $this->get_field_id( 'social_network_name' ); ?>"><?php _e( 'Название соцсети:' ); ?></label>  -->
			<!-- <input class="widefat" id="<?php echo $this->get_field_id( 'social_network_name' ); ?>" name="<?php echo $this->get_field_name( 'social_network_name' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>"> -->
		</p>
        <p>
			<label for="<?php echo $this->get_field_id( 'link_twitter' ); ?>"><?php _e( 'Ссылка на страницу:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'link_twitter' ); ?>" name="<?php echo $this->get_field_name( 'link_twitter' ); ?>" type="text" value="<?php echo esc_attr( $link_twitter ); ?>">
		</p>
        <p>
			<?php _e( 'youtube' ); ?>
			<!-- <label for="<?php echo $this->get_field_id( 'social_network_name' ); ?>"><?php _e( 'Название соцсети:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'social_network_name' ); ?>" name="<?php echo $this->get_field_name( 'social_network_name' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>"> -->
		</p>
        <p>
			<label for="<?php echo $this->get_field_id( 'link_youtube' ); ?>"><?php _e( 'Ссылка на страницу:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'link_youtube' ); ?>" name="<?php echo $this->get_field_name( 'link_youtube' ); ?>" type="text" value="<?php echo esc_attr( $link_youtube ); ?>">
		</p>
		<p>
			<?php _e( 'instagram' ); ?>
			<!-- <label for="<?php echo $this->get_field_id( 'social_network_name' ); ?>"><?php _e( 'Название соцсети:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'social_network_name' ); ?>" name="<?php echo $this->get_field_name( 'social_network_name' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>"> -->
		</p>
        <p>
			<label for="<?php echo $this->get_field_id( 'link_instagram' ); ?>"><?php _e( 'Ссылка на страницу:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'link_instagram' ); ?>" name="<?php echo $this->get_field_name( 'link_instagram' ); ?>" type="text" value="<?php echo esc_attr( $link_instagram ); ?>">
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
		$instance['title_social_icons'] = ( ! empty( $new_instance['title_social_icons'] ) ) ? strip_tags( $new_instance['title_social_icons'] ) : '';
        // $instance['social_network'] = ( ! empty( $new_instance['social_network'] ) ) ? strip_tags( $new_instance['social_network'] ) : '';
		$instance['link_facebook'] = ( ! empty( $new_instance['link_facebook'] ) ) ? strip_tags( $new_instance['link_facebook'] ) : '';
		$instance['link_twitter'] = ( ! empty( $new_instance['link_twitter'] ) ) ? strip_tags( $new_instance['link_twitter'] ) : '';
		$instance['link_youtube'] = ( ! empty( $new_instance['link_youtube'] ) ) ? strip_tags( $new_instance['link_youtube'] ) : '';
		$instance['link_instagram'] = ( ! empty( $new_instance['link_instagram'] ) ) ? strip_tags( $new_instance['link_instagram'] ) : '';

		return $instance;
	}

	// скрипт виджета
	function add_social_icons_widget_scripts() {
		// фильтр чтобы можно было отключить скрипты
		if( ! apply_filters( 'show_social_icons_widget_script', true, $this->id_base ) )
			return;

		$theme_url = get_stylesheet_directory_uri();

		wp_enqueue_script('social_icons_widget_script', $theme_url .'/social_icons_widget_script.js' );
	}

	// стили виджета
	function add_social_icons_widget_style() {
		// фильтр чтобы можно было отключить стили
		if( ! apply_filters( 'show_social_icons_widget_style', true, $this->id_base ) )
			return;
		?>
		<style type="text/css">
			.social_icons_widget a{ display:inline; }
		</style>
		<?php
	}

} 
// конец класса Social_Icons_Widget

// регистрация Social_Icons_Widget в WordPress
function register_social_icons_widget() {
	register_widget( 'Social_Icons_Widget' );
}
add_action( 'widgets_init', 'register_social_icons_widget' ); 



/**
 * Добавление нового виджета Recent_Post_Widget.
 */
class Recent_Post_Widget extends WP_Widget {

	// Регистрация виджета используя основной класс
	function __construct() {
		// вызов конструктора выглядит так:
		// __construct( $id_base, $name, $widget_options = array(), $control_options = array() )
		parent::__construct(
			'recent_post_widget', // ID виджета, если не указать (оставить ''), то ID будет равен названию класса в нижнем регистре: recent_post_widget
			'Последние посты',
			array( 'description' => 'Недавно опубликовано', 'classname' => 'widget-recent-post', )
		);

		// скрипты/стили виджета, только если он активен
		if ( is_active_widget( false, false, $this->id_base ) || is_customize_preview() ) {
			add_action('wp_enqueue_scripts', array( $this, 'add_recent_post_widget_scripts' ));
			add_action('wp_head', array( $this, 'add_recent_post_widget_style' ) );
		}
	}

	/**
	 * Вывод виджета во Фронт-энде
	 *
	 * @param array $args аргументы виджета.
	 * @param array $instance сохраненные данные из настроек
	 */
	function widget( $args, $instance ) {
        // $title = apply_filters( 'widget_title', $instance['title'] ); // упростим
        $title = $instance['title'];
        $count = $instance['count'];

		echo $args['before_widget'];

		if ( ! empty( $count ) ) {
			if ( ! empty( $title ) ) {
				echo $args['before_title'] . $title . $args['after_title'];
			}
			echo '<div class="widget-recent-post-wrapper">';
			global $post;
			$postslist = get_posts( array( 'posts_per_page' => $count, 'order'=> 'ASC', 'orderby' => 'title' ) );
			foreach ( $postslist as $post ){
				setup_postdata($post);
				?>
				<a href="<?php the_permalink() ?>" class="recent-post-link">
					<img class="recent-post-thumb" src="<?php echo get_the_post_thumbnail_url( null, 'thumbnail' ); ?>" alt="">
					<div class="widget-recent-post-info">
						<h4 class="recent-post-title"><?php echo mb_strimwidth(get_the_title(), 0, 30, '...'); ?></h4>
						<span class="recent-post-time">
							<?php $time_diff = human_time_diff( get_post_time('U'), current_time('timestamp') );
								echo "$time_diff назад"; // Опубликовано > 5 лет назад ?>
						</span>
					</div>
				</a>
				<?php
			}
			wp_reset_postdata();
			echo '</div>';
		}
		
		echo $args['after_widget'];
	}

	/**
	 * Админ-часть виджета
	 *
	 * @param array $instance сохраненные данные из настроек
	 */
	function form( $instance ) {
        $title = @ $instance['title'] ?: 'Недавно опубликовано'; // Заголовок по умолчанию
        $count = @ $instance['count'] ?: '7'; // количество постов

		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
        <p>
			<label for="<?php echo $this->get_field_id( 'count' ); ?>"><?php _e( 'Количество постов:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'count' ); ?>" name="<?php echo $this->get_field_name( 'count' ); ?>" type="text" value="<?php echo esc_attr( $count ); ?>">
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
        $instance['count'] = ( ! empty( $new_instance['count'] ) ) ? strip_tags( $new_instance['count'] ) : '';

		return $instance;
	}

	// скрипт виджета
	function add_recent_post_widget_scripts() {
		// фильтр чтобы можно было отключить скрипты
		if( ! apply_filters( 'show_recent_post_widget_script', true, $this->id_base ) )
			return;

		$theme_url = get_stylesheet_directory_uri();

		wp_enqueue_script('recent_post_widget_script', $theme_url .'/recent_post_widget_script.js' );
	}

	// стили виджета
	function add_recent_post_widget_style() {
		// фильтр чтобы можно было отключить стили
		if( ! apply_filters( 'show_recent_post_widget_style', true, $this->id_base ) )
			return;
		?>
		<style type="text/css">
			.recent_post_widget a{ display:inline; }
		</style>
		<?php
	}

} 
// конец класса Recent_Post_Widget

// регистрация Recent_Post_Widget в WordPress
function register_recent_post_widget() {
	register_widget( 'Recent_Post_Widget' );
}
add_action( 'widgets_init', 'register_recent_post_widget' );