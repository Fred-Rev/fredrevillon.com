<?php get_header(); ?>

<main class="film-single">

    <?php while (have_posts()) : the_post(); ?>

        <?php
$production = get_field('production');
$agency = get_field('agence');
$client = get_field('client');
$team = get_field('equipe');
$type = get_field('type');
$summary = get_field('resume');
$directors = get_field('realisateurs');
$vimeo_url = get_field('vimeo_url');

?>

        <article class="film">

    <header class="film__header">

        <?php if (!empty($type)) : ?>
            <p class="film__eyebrow">
                <?php echo esc_html($type); ?>
            </p>
        <?php endif; ?>

        <h1 class="film__title">
            <?php the_title(); ?>
        </h1>
        
        <?php if (!empty($directors)) : ?>
        <p class="film__director">
        Directed by <?php echo esc_html($directors); ?>
        </p>
        <?php endif; ?>
    </header>


    <?php if (!empty($vimeo_url)) : ?>

        <div class="film__video">
            <?php echo wp_oembed_get(esc_url($vimeo_url)); ?>
        </div>

    <?php endif; ?>


    <div class="film__details">

        <div class="film__meta">

            <?php if (!empty($production)) : ?>
                <div class="film__meta-item">
                    <span>Production:</span>
                    <p><?php echo esc_html($production); ?></p>
                </div>
            <?php endif; ?>


            <?php if (!empty($agency)) : ?>
                <div class="film__meta-item">
                    <span>Agency</span>
                    <p><?php echo esc_html($agency); ?></p>
                </div>
            <?php endif; ?>


            <?php if (!empty($client)) : ?>
                <div class="film__meta-item">
                    <span>Client</span>
                    <p><?php echo esc_html($client); ?></p>
                </div>
            <?php endif; ?>

            <?php if (!empty($team)) : ?>
                <div class="film__meta-item">
                    <span>Team</span>
                    <p><?php echo nl2br(esc_html($team)); ?></p>
                </div>
            <?php endif; ?>
    

        </div>


        <?php if (!empty($summary)) : ?>

            <div class="film__summary">
                <?php echo wp_kses_post($summary); ?>
            </div>

        <?php endif; ?>

    </div>

</article>

    <?php endwhile; ?>

</main>

<?php get_footer(); ?>