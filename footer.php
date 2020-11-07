        <footer class="footer">
            <div class="container">
                <?php
                if ( ! is_active_sidebar( 'sidebar-footer' ) ) {
                    return;
                }
                ?>
                <div class="footer-menu-bar">
                    <?php dynamic_sidebar( 'sidebar-footer' ); ?>
                </div>
                <div class="footer-info">
                    <?php
                        wp_nav_menu( [
                            'theme_location'  => 'footer_menu', 
                            'container'       => 'nav',
                            'menu_class'      => 'footer-nav', 
                            'echo'            => true, // выводить ли меню
                        ] );
                        $instance = array(
                            'title_social_icons' => '',
                            'link_facebook' => 'https://fb.com/',
                            'link_twitter' => 'https://twitter.com/',
                            'link_youtube' => 'https://youtube.com/',
                            'link_instagram' => 'https://instagram.com/',
                        );
                        $argc = array(
                            'before_widget' => '<div class="footer-social">',
                            'after_widget' => '</div>',
                        );
                        the_widget( 'Social_Icons_Widget', $instance, $args );
                    ?>
                </div>
                <?php
                if ( ! is_active_sidebar( 'sidebar-footer-text' ) ) {
                    return;
                }
                ?>
                <div class="footer-text-wrapper">
                    <?php dynamic_sidebar( 'sidebar-footer-text' ); ?>
                    <span class="footer-copyright">
                        <?php echo date('Y') . '&copy;' . get_bloginfo( 'name' )?>
                    </span>
                </div>
            </div>
        </footer>
        <?php wp_footer(); ?>
    </body>
</html>