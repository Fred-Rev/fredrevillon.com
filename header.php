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

        <div class="site-branding">

            <a class="site-logo" href="<?php echo esc_url(home_url('/')); ?>">
                FRED REVILLON
            </a>

            <span class="site-tagline">
                DIGITAL PROJECT MANAGER | AUDIOVISUAL PRODUCER
            </span>

        </div>

        <button
    class="menu-toggle"
    type="button"
    aria-expanded="false"
    aria-controls="main-navigation"
>
    <span></span>
    <span></span>
</button>

<nav
    class="main-navigation"
    id="main-navigation"
>
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