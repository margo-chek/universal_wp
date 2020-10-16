<?php get_header(); ?>
<main class="front-page-header">
    <div class="container">
        <div class="hero">
            <div class="left">

                <!-- <img src="<?php echo get_template_directory_uri() . '/assets/images/backgroundFontPage.jpg' ?>" alt="" class="post-thumb">
                <a href="#" class="author">
                    <img src="<?php echo get_template_directory_uri() . '/assets/images/avatar.png' ?>" alt="" class="avatar">
                    <div class="author-bio">
                        <span class="author-name">имя автора</span>
                        <span class="author-rank">должность</span>
                    </div>
                </a>
                <div class="post-text">
                    <a href="#" class="category-name">Рубрики</a>
                    <h2 class="post-title">Название поста</h2>
                    <a href="#" class="more">Читать далее</a>
                </div> -->

                <?php
                // объявляем глобальную переменную
                global $post;

                $myposts = get_posts([ 
                    'numberposts'   => 1, // берем из бд максимум 5 (1) последних постов
                    // 'offset'        => 1, // отступ от 1-го поста - например, публикуем начиная со 2-го
                    // 'category'      => 1, // ID категории, из которой получаем посты
                    'category_name' => 'html', // строка - имя или слаг (ярлык) категории
                    // 'orderby' => 'date', // сортировать по к-либо параметрам, н-р, по дате
                    // 'order' => 'DESC', // в каком направлении сортировать orderby: ASC - по порядку (а,б,в), DESC - в обратном порядке
                ]);

                // проверяем, есть ли вообще посты
                if( $myposts ){
                    // если есть - запускаем цикл
                    foreach( $myposts as $post ){
                        setup_postdata( $post ); // устанавливаем данные, если невозможно использовать, н-р, the_content() или the_date()
                        // данные можно получить через обращение к свойству объекта (объект->свойство_объекта)
                        // н-р: $post->ID будет равно ID поста, $post->post_content будет содержать контент записи
                        ?>
                        <!-- место для вывода постов, функции цикла: the_title() и т.д. -->
                        <!-- н-р, вернем заголовки всех постов -->
                        <!-- функция the_title(); - выводит заголовок текущей записи -->

                        <!-- выводим записи -->
                        <img src="<?php the_post_thumbnail_url(); ?>" alt="" class="post-thumb">
                        <?php $author_id = get_the_author_meta('ID'); ?>  <!-- получаем данные автора -->
                        <a href="<?php echo get_author_posts_url($author_id); ?>" class="author">
                            <img src="<?php echo get_avatar_url($author_id); ?>" alt="" class="avatar">
                            <div class="author-bio">
                                <span class="author-name"><?php the_author(); ?></span>
                                <span class="author-rank">должность</span>
                            </div>
                        </a>
                        <div class="post-text">
                            <?php the_category(); ?>
                            <h2 class="post-title"><?php the_title(); ?></h2>
                            <a href="<?php echo get_the_permalink()?>" class="more">Читать далее</a>
                        </div>

                        <?php 
                    }
                } else {
                ?> <p>Постов нет</p> <?php // Постов не найдено
                }

                wp_reset_postdata(); // Сбрасываем $post
                ?>

            </div>
            <div class="right">
                <h3 class="recommend">Рекомендуем</h3>
                <ul class="posts-list">

                    <?php
                    global $post; // объявляем глобальную переменную
                    $myposts = get_posts([ 
                        'numberposts'   => 5, // берем из бд максимум 5 последних постов
                        'offset'        => 1, // пропускаем последний пост, начинаем выводить с предпоследнего
                        'category_name' => 'javascript, css, js, chrome, html, web-design', // строка - имя или слаг (ярлык) категории
                    ]);              
                    if( $myposts ){ // проверяем, есть ли вообще посты
                        foreach( $myposts as $post ){ // если есть - запускаем цикл
                            setup_postdata( $post ); // устанавливаем данные
                            ?>
                            <!-- выводим записи -->
                            <li class="post">
                                <?php the_category(); ?>
                                <a class="post-permalink" href="<?php echo get_the_permalink(); ?>">
                                    <h4 class="recommend-post-title"><?php echo mb_strimwidth(get_the_title(), 0, 56, '...'); ?></h4>
                                </a>
                            </li>
                        <?php 
                        }
                    } else {
                    ?> <p>Постов нет</p> <?php
                    }
                    wp_reset_postdata(); // сбрасываем $post
                    ?>

                </ul>
            </div>
        </div>

    </div>
</main>
<div class="container">
    <ul class="article-list">

        <?php
        global $post; // объявляем глобальную переменную
        $myposts = get_posts([ 
            'numberposts'   => 4, // берем из бд максимум 4 последних постов
            'category_name' => 'work, article', // строка - имя или слаг (ярлык) категории
        ]);              
        if( $myposts ){ // проверяем, есть ли вообще посты
            foreach( $myposts as $post ){ // если есть - запускаем цикл
                setup_postdata( $post ); // устанавливаем данные
                ?>
                <!-- выводим записи -->
                <li class="article-item">
                    <a class="article-permalink" href="<?php echo get_the_permalink(); ?>">
                        <h4 class="article-title"><?php trim_title_chars(68, '...'); ?></h4>
                    </a>
                    <img width="65" height="65" src="<?php echo get_the_post_thumbnail_url( null, 'thumbnail' ); ?>" alt="">
                </li>
            <?php 
            }
        } else {
        ?> <p>Постов нет</p> <?php
        }
        wp_reset_postdata(); // сбрасываем $post
        ?>

    </ul>                 
</div>

<?php get_footer(); ?>