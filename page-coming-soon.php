<?php
/*
Template Name: Coming Soon
*/

get_header();
?>

<main class="coming-soon">

    <section class="coming-soon__section">

        <div class="coming-soon__inner">

            <p class="coming-soon__label">
                Coming soon
            </p>

            <h1 class="coming-soon__title">
                <?php the_title(); ?>
            </h1>

            <p class="coming-soon__intro">
                <?php
                if (have_posts()) :
                    while (have_posts()) :
                        the_post();
                        the_content();
                    endwhile;
                endif;
                ?>
            </p>

            <a
                class="coming-soon__back"
                href="<?php echo esc_url(home_url('/')); ?>"
            >
                Back home <span aria-hidden="true">→</span>
            </a>

        </div>

    </section>

</main>

<?php get_footer(); ?>