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
                            <h2 class="post-title"><?php trim_title_words(5, '...'); ?></h2>
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
    <ul class="article-grid">
        <?php		
        global $post;
        // формируем запрос в БД с помощью переменной $query
        $query = new WP_Query( [
            'posts_per_page' => 5, // получаем 5 постов
            // 'orderby'        => 'comment_count',
        ] );

        if ( $query->have_posts() ) { // проверяем, есть ли посты
            $cnt = 0; // создаем переменную-счетчик постов
            while ( $query->have_posts() ) { // пока посты есть, выводим их
                $query->the_post(); // получаем контент из этих постов
                $cnt ++; // увеличиваем счетчик постов
                switch ($cnt) {
                    case '1': // выводим первый пост
                        ?>
                        <li class="article-grid-item article-grid-item-1">
                            <a href="<?php the_permalink(); ?>" class="article-grid-permalink">
                                <img class="article-grid-thumbnail" src="<?php echo get_the_post_thumbnail_url() ?>" alt="">
                                <span class="category-name"><?php echo get_the_category()[0]->name; ?></span>
                                <h4 class="article-grid-title"><?php trim_title_chars(56, '...'); ?></h4>
                                <p class="article-grid-excerpt"><?php echo mb_strimwidth (get_the_excerpt(), 0, 120, '...'); ?></p>
                                <div class="article-grid-info">
                                    <div class="author">
                                        <?php $author_id = get_the_author_meta('ID'); ?>  <!-- получаем данные автора -->
                                        <img src="<?php echo get_avatar_url($author_id); ?>" alt="" class="author-avatar">
                                        <span class="author-name"><strong><?php the_author(); ?></strong> : <?php the_author_meta( 'description' ) ?></span>
                                    </div>
                                    <div class="comments">
                                        <img src="<?php echo get_template_directory_url() . './assets/images/comment.svg' ?>"
                                            alt="icon: comment" class="comments-icon">
                                        <span class="comments-counter"><?php comments_number('0', '1', '%'); ?></span>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <?php 
                        break;
                    case '2': // выводим второй пост
                        ?>
                        <li class="article-grid-item article-grid-item-2">
                            <!-- <img src="<?php //echo get_the_post_thumbnail_url(); ?>" alt="" class="article-grid-thumb"> -->
                            <a href="<?php the_permalink(); ?>" class="article-grid-permalink">
                                <span class="tag">
                                    <?php $posttags = get_the_tags(); // получаем все теги
                                    if ( $posttags ) { // проверка на пустоту - если хоть один тег существует, то
                                        echo $posttags[0]->name . ' '; // выводим только первый тег
                                    } ?>
                                </span>
                                <span class="category-name"><?php echo get_the_category()[0]->name; ?></span>
                                <h4 class="article-grid-title"><?php echo mb_strimwidth(get_the_title(), 0, 56, '...'); ?></h4>
                                <div class="article-grid-info">
                                    <div class="author">
                                        <?php $author_id = get_the_author_meta('ID'); ?>  <!-- получаем данные автора -->
                                        <img src="<?php echo get_avatar_url($author_id); ?>" alt="" class="author-avatar">
                                        <div class="author-info">
                                            <span class="author-name"><strong><?php the_author(); ?></strong></span>
                                            <span class="date"><?php the_time( 'j F' ); ?></span>
                                            <div class="comments">
                                                <img src="<?php echo get_template_directory_url() . './assets/images/comment-white.svg' ?>"
                                                    alt="icon: comment" class="comments-icon">
                                                <span class="comments-counter"><?php comments_number('0', '1', '%'); ?></span>
                                            </div>
                                            <div class="likes">
                                                <img src="<?php echo get_template_directory_url() . './assets/images/heart.svg' ?>"
                                                    alt="icon: like" class="likes-icon">
                                                <span class="likes-counter"><?php comments_number('0', '1', '%'); ?></span>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                            </a>
                        </li>
                        <?php 
                        break;
                    case '3': // выводим третий пост
                        ?>
                        <li class="article-grid-item article-grid-item-3">
                            <a href="<?php the_permalink(); ?>" class="article-grid-permalink">
                                <img src="<?php echo get_the_post_thumbnail_url(); ?>" alt="" class="article-thumb">       
                                <h4 class="article-grid-title"><?php echo mb_strimwidth(get_the_title(), 0, 56, '...'); ?></h4>
                            </a>
                        </li>
                        <?php 
                        break;
                    
                    default: // выводим остальные посты
                        ?>
                        <li class="article-grid-item article-grid-item-default">
                            <a href="<?php the_permalink(); ?>" class="article-grid-permalink">
                                <img src="<?php echo get_the_post_thumbnail_url(); ?>" alt="" class="article-thumb">       
                                <h4 class="article-grid-title"><?php echo mb_strimwidth(get_the_title(), 0, 56, '...'); ?></h4>
                                <p class="article-grid-excerpt"><?php echo get_the_excerpt()?></p>
                                <span class="article-date"><?php the_time( 'j F' ); ?></span> 
                                <!-- для вывода даты всех постов лучше использовать the_time( 'j F Y' );
                                для вывода даты только у первого поста the_date( 'j F Y' ); -->
                            </a>
                        </li>
                        <?php 
                        break;
                }
            }
        } else {
            // Постов не найдено
        }

        wp_reset_postdata(); // сбрасываем $post
        ?>
    </ul>               
</div>

<?php get_footer(); ?>