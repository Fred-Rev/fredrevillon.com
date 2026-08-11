<?php get_header(); ?>

<main class="site-main">

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
                <span class="journey-origin" aria-hidden="true"></span>
            </p>

        </div>

    </section>


    <!-- JOURNEY -->
    <section class="journey" id="journey" aria-labelledby="journey-title">

        <h2 id="journey-title" class="screen-reader-text">
            From thought to experience
        </h2>

        <div class="journey__track">

            <svg
                class="journey__line"
                viewBox="0 0 1400 1250"
                preserveAspectRatio="xMidYMid meet"
                aria-hidden="true"
            >

                <path
                    class="journey__path"
                    d="
                        M 790 0
                        C 770 70, 650 130, 560 190
                        C 470 280, 430 370, 500 470
                        C 590 590, 690 690, 610 820
                        C 530 950, 390 1020, 470 1090
                        C 520 1140, 570 1180, 570 1240
                    "
                />

            </svg>


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
                    Projects designed<br>
                    from thought to experience.
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
                        $project_link_label = get_field('project_link_label');
                        $project_technologies = get_field('project_technologies');

                        $technologies = [];

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


                                <?php if (!empty($project_link)) : ?>

                                    <a
                                        class="button project-card__link"
                                        href="<?php echo esc_url($project_link); ?>"
                                        target="_blank"
                                        rel="noopener noreferrer"
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

                <p class="about__eyebrow">
                    ABOUT
                </p>

                <h2 class="about__title">
                    A multidisciplinary profile<br>
                    driven by curiosity.
                </h2>

                <p class="about__intro">
                    My career has taken me through audiovisual production,
                    digital communication and web development.
                    Today, I combine creativity, project management and
                    technical expertise to build meaningful digital experiences.
                </p>

            </header>


            <div class="about__grid">

                <article class="about__card">

                    <h3>Experience</h3>

                    <ul>
                        <li>Audiovisual Production</li>
                        <li>Digital Communication</li>
                        <li>Web Development</li>
                    </ul>

                </article>


                <article class="about__card">

                    <h3>Skills</h3>

                    <ul>
                        <li>WordPress</li>
                        <li>PHP</li>
                        <li>JavaScript</li>
                        <li>CSS</li>
                        <li>Project Management</li>
                        <li>UI / UX</li>
                    </ul>

                </article>


                <article class="about__card">

                    <h3>Education</h3>

                    <ul>
                        <li>OpenClassrooms</li>
                        <li>Front-End Development</li>
                        <li>Continuous Learning</li>
                    </ul>

                </article>

            </div>
            <a href="<?php echo get_template_directory_uri(); ?>/assets/images/CV_2026_wip.png"
                class="button"
                download>
                Download CV
            </a>

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