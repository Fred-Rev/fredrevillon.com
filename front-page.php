<?php get_header(); ?>

<main class="site-main">
<div class="journey-stage">

    <svg
        class="journey-stage__svg"
        preserveAspectRatio="none"
        aria-hidden="true"
    >
        <path class="journey__path" d="" />
    </svg>
    <!-- HERO -->
    <section class="hero">

        <div class="hero__inner">

            <h1 class="hero__title">
                <span class="hero__title-strong">From Thought</span>
                <span class="hero__title-light">to Experience</span>
            </h1>

            <p class="hero__intro">
                 I design, build and tell stories<br>
                 through different mediums
                    <span class="journey-origin-wrap">
                        <span class="journey-origin-dot">.</span>
                        <span class="journey-origin" aria-hidden="true"></span>
                    </span>
            </p>

        </div>

    </section>


    <!-- JOURNEY -->
    <section class="journey" id="journey" aria-labelledby="journey-title">

        <h2 id="journey-title" class="screen-reader-text">
            From thought to experience
        </h2>

        <div class="journey__track">
            
            <article class="journey-step journey-step--right journey-step--understand">

                <span
                    class="journey-step__point"
                    aria-hidden="true"
                ></span>

                <div class="journey-step__content">

                    <h3>Understand</h3>

                    <p>
                        Explore. Observe.<br>
                        Identify what matters.
                    </p>

                </div>

            </article>


            <article class="journey-step journey-step--left journey-step--organize">

                <span
                    class="journey-step__point"
                    aria-hidden="true"
                ></span>

                <div class="journey-step__content">

                    <h3>Organize</h3>

                    <p>
                        Structure. Connect.<br>
                        Give meaning.
                    </p>

                </div>

            </article>


            <article class="journey-step journey-step--right journey-step--conceive">

                <span
                    class="journey-step__point"
                    aria-hidden="true"
                ></span>

                <div class="journey-step__content">

                    <h3>Conceive</h3>

                    <p>
                        Imagine. Design.<br>
                        Give form to the idea.
                    </p>

                </div>

            </article>


            <article class="journey-step journey-step--left journey-step--build">

                <span
                    class="journey-step__point"
                    aria-hidden="true"
                ></span>

                <div class="journey-step__content">

                    <h3>Build</h3>

                    <p>
                        Develop. Assemble.<br>
                        Bring it to life.
                    </p>

                </div>

            </article>


            <article class="journey-step journey-step--right journey-step--tell">

                <span
                    class="journey-step__point"
                    aria-hidden="true"
                ></span>

                <div class="journey-step__content">

                    <h3>Tell</h3>

                    <p>
                        Share. Transmit.<br>
                        Create the experience.
                    </p>

                </div>

            </article>

        </div>

    </section>


    <!-- WORK -->
    <section class="work" id="work">

        <div class="work__inner">

            <header class="work__header">

                <p class="work__eyebrow">
                    SELECTED WORK
                </p>

                <h2 class="work__title">
    Pro<span class="journey-destination-letter">j<span
        class="journey-destination"
        aria-hidden="true"
    ></span></span>ects designed<br>
    from thought to<br>
    experience.
</h2>

                <p class="work__intro">
                    A selection of projects combining
                    strategy, design and development.
                </p>

            </header>


            <?php
            $projects_query = new WP_Query([
                'post_type'      => 'project',
                'post_status'    => 'publish',
                'posts_per_page' => -1,
                'orderby'        => [
                    'menu_order' => 'ASC',
                    'date'       => 'DESC',
                ],
            ]);
            ?>


            <?php if ($projects_query->have_posts()) : ?>

                <div class="work__grid">

                    <?php while ($projects_query->have_posts()) : ?>

                        <?php
                        $projects_query->the_post();

                        $project_context = get_field('project_context');
                        $project_description = get_field('project_description');
                        $project_link = get_field('project_link');
                        $project_film = get_field('project_film');
                        $project_link_label = get_field('project_link_label');
                        $project_technologies = get_field('project_technologies');
                        $project_role = get_field('mon_role');
                        $technologies = [];

                        if (!empty($project_film)) {
                            $project_url = get_permalink($project_film->ID);
                                } else {
                                $project_url = $project_link;
}


                        if (!empty($project_technologies)) {
                            $technologies = array_filter(
                                array_map(
                                    'trim',
                                    explode(',', $project_technologies)
                                )
                            );
                        }
                        ?>

                        <article class="project-card">

                            <div class="project-card__image">

                                <?php if (has_post_thumbnail()) : ?>

                                    <?php
                                    the_post_thumbnail(
                                        'large',
                                        [
                                            'loading' => 'lazy',
                                            'alt'     => esc_attr(
                                                get_the_title()
                                            ),
                                        ]
                                    );
                                    ?>

                                <?php else : ?>

                                    <div class="project-card__placeholder">
                                        Preview
                                    </div>

                                <?php endif; ?>

                            </div>


                            <div class="project-card__content">

                                <h3>
                                    <?php the_title(); ?>
                                </h3>


                                <?php if (!empty($project_context)) : ?>

                                    <p class="project-card__context">
                                        <?php
                                        echo nl2br(
                                            esc_html($project_context)
                                        );
                                        ?>
                                    </p>

                                <?php endif; ?>


                                <div class="project-card__description">
                                    <?php echo esc_html($project_description); ?>
                                </div>

                                <?php if (!empty($project_role)) : ?>

                                <p class="project-card__role">
                                <strong>Role</strong><br>
                                <?php echo esc_html($project_role); ?>
                                </p>

                                <?php endif; ?>

                                <?php if (!empty($technologies)) : ?>

                                    <ul class="project-card__tags">

                                        <?php foreach ($technologies as $technology) : ?>

                                            <li>
                                                <?php
                                                echo esc_html($technology);
                                                ?>
                                            </li>

                                        <?php endforeach; ?>

                                    </ul>

                                <?php endif; ?>


                                <?php if (!empty($project_url)) : ?>

    <a
        class="button project-card__link"
        href="<?php echo esc_url($project_url); ?>"
    >
        <?php
        echo esc_html(
            !empty($project_link_label)
                ? $project_link_label
                : 'View project'
        );
        ?>
    </a>

                    <?php endif; ?>

                            </div>

                        </article>

                    <?php endwhile; ?>

                </div>

                    

        <a class="work__more-films" href="<?php echo esc_url(get_post_type_archive_link('film')); ?>">
            I want more <span aria-hidden="true">→</span>
        </a>

    <?php else : ?>

        <p class="work__empty">
            No projects have been published yet.
        </p>

    <?php endif; ?>

    <?php wp_reset_postdata(); ?>

        </div>

    </section>


    <!-- ABOUT -->
    <section class="about" id="about">

    <div class="about__inner">

        <header class="about__header">

            <p class="about__label">
                About
            </p>

            <h2 class="about__title">
                A multidisciplinary profile,<br>
                driven by curiosity.
            </h2>

            <p class="about__intro">
                From audiovisual production to digital communication
                and web development, my path has crossed different
                mediums — always with the same desire to understand,
                create and make things happen.
            </p>


            </header>

                <div class="about__triptych">

            <figure class="about__photo about__photo--bass">
                <img src="wp-content/themes/fred_starter/assets/images/fred_basses.jpg" alt="Playing bass guitar">
            </figure>

            <figure class="about__photo about__photo--portrait">
                <img src="wp-content/themes/fred_starter/assets/images/fred_about.jpg" alt="Portrait of Fred Révillon">
            </figure>

            <figure class="about__photo about__photo--hoggar">
                <img src="wp-content/themes/fred_starter/assets/images/fred Hoggar.jpg" alt="In the Hoggar mountains">
            </figure>

        </div>

<section class="about__facts">

    <p class="about__facts-label">
        Selected Facts
    </p>

        <div class="about__facts-grid">

            <div class="about__fact">
                <strong>25+ years</strong>
                <span>Audiovisual production, digital and creative projects</span>
            </div>

            <div class="about__fact">
                <strong>€500k</strong>
                <span>Budgets managed</span>
            </div>

            <div class="about__fact">
                <strong>40 people</strong>
                <span>Teams coordinated</span>
            </div>

            <div class="about__fact">
                <strong>M6 · TF1 · Canal+</strong>
                <span>Broadcast and production experience</span>
            </div>

            <div class="about__fact">
                <strong>Remy Cointreau · Evian · Bel · Danone</strong>
            <span>Selected brands</span>
        </div>

        <div class="about__fact">
            <strong>WordPress · PHP · JavaScript</strong>
            <span>Current development stack</span>
        </div>
        </div>
    
                
    <a href="<?php echo get_template_directory_uri(); ?>/assets/images/CV_FR_2026.pdf" class="button about__cv-link">
        View CV
    </a>

</section>
            </div>
    </section>
</div>

   <section class="contact" id="contact">

    <div class="contact__inner">

        <header class="contact__header">

            <p class="contact__eyebrow">
                CONTACT
            </p>

            <h2 class="contact__title">
                Let's work together.
            </h2>

            <p class="contact__intro">
                Have a project in mind or simply want to say hello?
                I'd be happy to hear from you.
            </p>

        </header>

        <?php
        echo do_shortcode(
            '[contact-form-7 id="9715966" title="Formulaire de contact"]'
        );
        ?>

    </div>

</section>

</main>

<?php get_footer(); ?>