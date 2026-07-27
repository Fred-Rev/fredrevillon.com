<?php

if (!defined('ABSPATH')) {
    exit;
}

function fred_starter_setup()
{
    register_nav_menus([
        'main-menu' => __('Menu principal', 'fred-starter'),
    ]);
}

add_action('after_setup_theme', 'fred_starter_setup');

wp_enqueue_script(
    'gsap',
    'https://cdn.jsdelivr.net/npm/gsap@3.13.0/dist/gsap.min.js',
    [],
    '3.13.0',
    true
);

wp_enqueue_script(
    'gsap-scroll-trigger',
    'https://cdn.jsdelivr.net/npm/gsap@3.13.0/dist/ScrollTrigger.min.js',
    ['gsap'],
    '3.13.0',
    true
);

wp_enqueue_script(
    'gsap-motion-path',
    'https://cdn.jsdelivr.net/npm/gsap@3.13.0/dist/MotionPathPlugin.min.js',
    ['gsap'],
    '3.13.0',
    true
);

function fred_starter_scripts()
{
    wp_enqueue_style(
        'fred-style',
        get_template_directory_uri() . '/assets/css/main.css',
        [],
        wp_get_theme()->get('Version')
    );

    wp_enqueue_script(
        'gsap',
        'https://cdn.jsdelivr.net/npm/gsap@3.13.0/dist/gsap.min.js',
        [],
        '3.13.0',
        true
    );

    wp_enqueue_script(
        'gsap-scroll-trigger',
        'https://cdn.jsdelivr.net/npm/gsap@3.13.0/dist/ScrollTrigger.min.js',
        ['gsap'],
        '3.13.0',
        true
    );

    wp_enqueue_script(
        'gsap-motion-path',
        'https://cdn.jsdelivr.net/npm/gsap@3.13.0/dist/MotionPathPlugin.min.js',
        ['gsap'],
        '3.13.0',
        true
    );

    wp_enqueue_script(
        'fred-starter-scripts',
        get_template_directory_uri() . '/assets/js/scripts.js',
        [
            'gsap',
            'gsap-scroll-trigger',
            'gsap-motion-path'
        ],
        wp_get_theme()->get('Version'),
        true
    );
}

add_action('wp_enqueue_scripts', 'fred_starter_scripts');