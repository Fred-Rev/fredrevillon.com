<?php get_header(); ?>

<main class="films-archive">

    <section class="films">

        <div class="films__inner">

            <header class="films__header">

    <p class="films__label">
        Films
    </p>

    <h1 class="films__title">
        More films<br>
        & productions.
    </h1>

    <p class="films__intro">
        A broader selection of films produced, directed or developed
        across different formats and contexts.
    </p>

</header>


            <?php

// 1. Récupérer les Projects affichés dans Selected Work
$showcase_projects = get_posts([
    'post_type'      => 'project',
    'post_status'    => 'publish',
    'posts_per_page' => -1,
    'fields'         => 'ids',
    'meta_query'     => [
        [
            'key'     => 'projet_vitrine',
            'value'   => '1',
            'compare' => '=',
        ],
    ],
]);


// 2. Récupérer les Films liés à ces Projects
$selected_film_ids = [];

foreach ($showcase_projects as $project_id) {

    $linked_film = get_field('project_film', $project_id);

    if (!empty($linked_film)) {

        // Fonctionne que le champ ACF retourne un objet ou un ID
        $selected_film_ids[] = is_object($linked_film)
            ? (int) $linked_film->ID
            : (int) $linked_film;
    }
}

$selected_film_ids = array_unique($selected_film_ids);


// 3. Requête Films en excluant ceux de Selected Work
$films_query = new WP_Query([
    'post_type'      => 'film',
    'post_status'    => 'publish',
    'posts_per_page' => -1,
    'post__not_in'   => $selected_film_ids,
    'orderby'        => [
        'menu_order' => 'ASC',
        'date'       => 'DESC',
    ],
]);

?>


<?php if ($films_query->have_posts()) : ?>

    <div class="films__grid">

        <?php while ($films_query->have_posts()) : $films_query->the_post(); ?>

            <?php
            $type = get_field('type');
            ?>

            <article class="film-card">

                <a href="<?php the_permalink(); ?>">

                    <div class="film-card__image">

                        <?php if (has_post_thumbnail()) : ?>

                            <?php
                            the_post_thumbnail(
                                'large',
                                [
                                    'loading' => 'lazy',
                                    'alt'     => esc_attr(get_the_title()),
                                ]
                            );
                            ?>

                        <?php else : ?>

                            <div class="film-card__placeholder">
                                Preview
                            </div>

                        <?php endif; ?>

                    </div>


                    <div class="film-card__content">

                        <h2 class="film-card__title">
                            <?php the_title(); ?>
                        </h2>

                        <?php if (!empty($type)) : ?>
                            <p class="film-card__type">
                                <?php echo esc_html($type); ?>
                            </p>
                        <?php endif; ?>

                    </div>

                </a>

            </article>

        <?php endwhile; ?>

    </div>

<?php else : ?>

    <p>No additional films have been published yet.</p>

<?php endif; ?>

<?php wp_reset_postdata(); ?>


            <a
                class="films__back"
                href="<?php echo esc_url(home_url('/#work')); ?>"
            >
                ← Back to selected work
            </a>

        </div>

    </section>

</main>

<?php get_footer(); ?>