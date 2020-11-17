<?php get_header('post'); ?>

<main id="primary" class="site-main">

		<?php
		while ( have_posts() ) : // запускаем цикл Wordpress, проверяем, есть ли посты
			the_post(); // если пост есть, выводим все его содержимое

            // находим шаблон для вывода поста в папке template-parts (ищет контент для определенного типа страницы)
            // ищет template-parts/content-{post_type},
            // например get_template_part( 'template-parts/content', 'post' ); ищет template-parts/content-post.php
            get_template_part( 'template-parts/content', get_post_type() );

			the_post_navigation( // выводим ссылки на предыдущий и следующий посты - навигация
				array(
					'prev_text' => '<span class="nav-subtitle">' . esc_html__( 'Назад', 'universal-theme' ) . '</span>',
					'next_text' => '<span class="nav-subtitle">' . esc_html__( 'Вперед', 'universal-theme' ) . '</span>',
				)
			);

			if ( comments_open() || get_comments_number() ) : // если комментарии к посту открыты или уже есть, выводим их
				comments_template(); // находим файл comments.php и выводим его
			endif;

		endwhile; // конец цикла Wordpress
		?>

	</main><!-- #main -->

<? get_footer();