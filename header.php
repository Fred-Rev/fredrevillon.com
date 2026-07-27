<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<?php wp_body_open(); ?>

<header class="site-header">

    <div class="site-header__inner">

        <a class="site-logo" href="<?php echo esc_url(home_url('/')); ?>">
            FRED REVILLON
        </a>

        <nav class="main-navigation">

            <?php
            wp_nav_menu([
                'theme_location' => 'main-menu',
                'container'      => false,
                'menu_class'     => 'main-menu',
                'fallback_cb'    => false,
            ]);
            ?>

        </nav>

    </div>

</header>