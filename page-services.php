<?php get_header(); ?>

<main class="services-page">

    <section class="services">

        <div class="services__inner">

            <header class="services__header">

                <p class="services__label">
                    Services
                </p>

                <h1 class="services__title">
                    Two areas of expertise.<br>
                    One approach.
                </h1>

                <p class="services__intro">
                    I help turn ideas into concrete projects through
                    audiovisual production and custom WordPress development.
                </p>

            </header>


            <div class="services__grid">

                <article class="service">

                    <p class="service__number">
                        01
                    </p>

                    <h2 class="service__title">
                        Audiovisual Production
                    </h2>

                    <p class="service__text">
                        From early planning to final delivery, I help agencies,
                        brands and production companies turn creative ideas
                        into workable productions.
                    </p>

                    <p class="service__skills">
                        Production management · Executive production ·
                        Budgeting & cost control · Scheduling ·
                        Team coordination · Production consulting
                    </p>

                </article>


                <article class="service">

                    <p class="service__number">
                        02
                    </p>

                    <h2 class="service__title">
                        WordPress Development
                    </h2>

                    <p class="service__text">
                        I design and build custom WordPress websites with a
                        focus on clarity, performance and maintainability —
                        from project definition to deployment.
                    </p>

                    <p class="service__skills">
                        Custom WordPress development · Front-end integration ·
                        WooCommerce · Technical consulting ·
                        Project management · Maintenance
                    </p>

                </article>

            </div>


            <section class="services__philosophy">

                <p class="services__philosophy-label">
                    Development philosophy
                </p>

                <h2>
                    Built with purpose,<br>
                    not plugins.
                </h2>

                <p>
                    I favour custom themes and tailor-made functionality
                    whenever they make sense. My goal is to keep unnecessary
                    third-party dependencies to a minimum, creating websites
                    that are faster, easier to maintain and more secure.
                </p>

                <p>
                    When plugins are the right solution, I choose them
                    carefully — and only when they bring real value to
                    the project.
                </p>

            </section>


            <section class="services__between">

                <h2>
                    Need something in between?
                </h2>

                <p>
                    Some projects don't fit neatly into a category.
                    That's usually where my multidisciplinary background
                    becomes useful.
                </p>

                <a
                    class="services__contact"
                    href="<?php echo esc_url(home_url('/#contact')); ?>"
                >
                    Let's talk <span aria-hidden="true">→</span>
                </a>

            </section>

        </div>

    </section>

</main>

<?php get_footer(); ?>