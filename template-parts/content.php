<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <!-- шапка поста -->    
    <header class="entry-header <?php echo get_post_type(); ?>-header" style="background: linear-gradient(0deg, rgba(38, 45, 51, 0.75), rgba(38, 45, 51, 0.75)), url(
        <?php //должно находится внутри цикла
        if( has_post_thumbnail() ) {
            echo get_the_post_thumbnail_url();
        }
        else {
            echo get_template_directory_uri().'/assets/images/img-default.png';
        }
        ?>
    );">
        <div class="container"> 
            <div class="post-header-nav">
                <?php
                foreach (get_the_category() as $category) { // вместо the_category(); 
                    printf(
                        '<a href="%s" class="category-link %s">%s</a>',
                        esc_url( get_category_link( $category ) ), // esc_url() обезопасывет ссылку
                        esc_html( $category -> slug ), // безопасность названий
                        esc_html( $category -> name )
                    );
                }
                ?>
                <a class="home-link" href="<?php echo get_home_url(); ?>"> <!-- ссылка на Главную страницу -->
                    <svg width="18" height="17" fill="#ffffff" class="icon home-icon">
                        <use xlink:href="<?php echo get_template_directory_uri()?>/assets/images/sprite.svg#Home"></use>
                    </svg>
                    На главную
                </a>
                <?php
                the_post_navigation( // выводим ссылки на предыдущий и следующий посты - навигация
                    array(
                        'prev_text' => '<span class="post-nav-pref">
                        <svg width="15" height="7" fill="white" class="icon pref-icon">
                            <use xlink:href="' . get_template_directory_uri() . '/assets/images/sprite.svg#backArrow"></use>
                        </svg>
                        ' . esc_html__( 'Назад', 'universal-theme' ) . '</span>',
                        'next_text' => '<span class="post-nav-next">' . esc_html__( 'Вперед', 'universal-theme' ) . '
                        <svg width="15" height="7" fill="white" class="icon next-icon">
                            <use xlink:href="' . get_template_directory_uri() . '/assets/images/sprite.svg#arrow"></use>
                        </svg>
                        </span>',
                    )
                );
                ?>
            </div>
            <?php
            if ( is_singular() ) : // проверяем, точно ли мы на странице поста
                the_title( '<h1 class="post-title">', '</h1>' );
            else : // если мы на любой другой странице, кроме поста
                the_title( '<h2 class="post-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
            endif;
            ?>
            <svg width="21" height="27" fill="#939699" class="bookmark-icon">
                <use xlink:href="<?php echo get_template_directory_uri()?>/assets/images/sprite.svg#bookmark"></use>
            </svg>
            <?php
            the_excerpt();
            ?>
            <div class="post-header-info">
                <svg width="13.5" height="13.5" fill="#939699" class="clock-icon">
                    <use xlink:href="<?php echo get_template_directory_uri()?>/assets/images/sprite.svg#Clock"></use>
                </svg>
                <span class="date"><?php the_time( 'j F, G:i' ); ?></span>
                <div class="comments">
                    <!-- <img src="<?php //echo get_template_directory_uri() . './assets/images/comment-white.svg' ?>"
                        alt="icon: comment" class="comments-icon"> -->
                    <svg width="13.5" height="13.5" fill="#939699" class="comments-icon">
                        <use xlink:href="<?php echo get_template_directory_uri()?>/assets/images/sprite.svg#comment"></use>
                    </svg>
                    <span class="comments-counter"><?php comments_number('0', '1', '%'); ?></span>
                </div>
                <div class="likes">
                    <!-- <img src="<?php //echo get_template_directory_uri() . './assets/images/heart.svg' ?>" alt="icon: like" class="likes-icon"> -->
                    <svg width="12.75" height="11.7" fill="#939699" class="likes-icon">
                        <use xlink:href="<?php echo get_template_directory_uri()?>/assets/images/sprite.svg#heart"></use>
                    </svg>
                    <span class="likes-counter"><?php comments_number('0', '1', '%'); ?></span>
                </div>
            </div>
        </div>
	</header><!-- .entry-header -->
    <div class="container"> 
        <div class="post-content"> <!-- содержимое поста -->
            <?php
            the_content(
                sprintf( // с помощью sprintf выводим это на экране
                    wp_kses( // проверка, wp_kses очищает от лишнего
                        /* translators: %s: Name of current post. Only visible to screen readers */
                        __( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'universal-theme' ),
                        array(
                            'span' => array(
                                'class' => array(),
                            ),
                        )
                    ),
                    wp_kses_post( get_the_title() )
                )
            );

            wp_link_pages( // обертка для постраничной навигации - если пост на нескольких страницах
                array(
                    'before' => '<div class="page-links">' . esc_html__( 'Страницы:', 'universal-theme' ),
                    'after'  => '</div>',
                )
            );
            ?>
        </div><!-- .post-content -->
        <footer class="post-footer">
            <?php
            /* translators: used between list items, there is a space after the comma */
                $tags_list = get_the_tag_list( '', esc_html_x( '', 'list item separator', 'universal-theme' ) );
                if ( $tags_list ) {
                    /* translators: 1: list of tags. */
                    printf( '<span class="tags-links">' . esc_html__( '%1$s', 'universal-theme' ) . '</span>', $tags_list ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                }
            ?>
        </footer><!-- .post-footer -->
    </div>

</article><!-- #post-<?php the_ID(); ?> -->
