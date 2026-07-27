document.addEventListener("DOMContentLoaded", () => {
    document.body.classList.add("is-ready");

    gsap.registerPlugin(ScrollTrigger);

    const journey = document.querySelector(".journey");
    const path = document.querySelector(".journey__path");
    const steps = document.querySelectorAll(".journey-step");
    const origin = document.querySelector(".journey-origin");

    const prefersReducedMotion = window.matchMedia(
        "(prefers-reduced-motion: reduce)"
    ).matches;

    let heartbeat;
    let journeyHasStarted = false;
    let autoStartTimer;

    /* ==========================
       HERO + HEARTBEAT
    ========================== */

    if (origin && !prefersReducedMotion) {
        heartbeat = gsap.timeline({
            paused: true
        });

        const addHeartbeat = () => {
            heartbeat
                .to(origin, {
                    scale: 2.8,
                    x: 3,
                    y: 1,
                    duration: 0.3,
                    ease: "power2.out"
                })
                .to(origin, {
                    scale: 1,
                    x: 0,
                    y: 0,
                    duration: 0.28,
                    ease: "power2.in"
                })
                .to(
                    origin,
                    {
                        scale: 2.1,
                        x: 2,
                        y: 1,
                        duration: 0.24,
                        ease: "power2.out"
                    },
                    "+=0.12"
                )
                .to(origin, {
                    scale: 1,
                    x: 0,
                    y: 0,
                    duration: 0.34,
                    ease: "power2.in"
                })
                .to({}, {
                    duration: 1.2
                });
        };

        for (let i = 0; i < 7; i += 1) {
            addHeartbeat();
        }

        const startJourney = () => {
            if (journeyHasStarted) {
                return;
            }

            journeyHasStarted = true;

            window.clearTimeout(autoStartTimer);
            heartbeat.pause();

            gsap.set(origin, {
                scale: 1,
                x: 0,
                y: 0
            });
        };

        window.addEventListener("scroll", startJourney, {
            once: true,
            passive: true
        });

        const heroTimeline = gsap.timeline();

        heroTimeline
            .to(".hero__title", {
                opacity: 1,
                y: 0,
                duration: 2,
                ease: "power2.out"
            })
            .to(
                ".hero__intro",
                {
                    opacity: 1,
                    y: 0,
                    duration: 1.2,
                    ease: "power2.out"
                },
                "-=0.75"
            )
            .add(() => {
                heartbeat.play();

                autoStartTimer = window.setTimeout(
                    startJourney,
                    9000
                );
            }, "+=0.5");
    } else {
        gsap.set(
            [".hero__title", ".hero__intro"],
            {
                opacity: 1,
                y: 0
            }
        );
    }

    /* ==========================
       TRACÉ DU JOURNEY
    ========================== */

    if (journey && path) {
        if (prefersReducedMotion) {
            gsap.set(path, {
                strokeDasharray: "none",
                strokeDashoffset: 0,
                autoAlpha: 1
            });
        } else {
            const pathLength = path.getTotalLength();

            gsap.set(path, {
                strokeDasharray: `${pathLength} ${pathLength}`,
                strokeDashoffset: pathLength,
                autoAlpha: 1
            });

            gsap.to(path, {
                strokeDashoffset: 0,
                ease: "none",

                scrollTrigger: {
                    trigger: journey,
                    start: "top 70%",
                    end: "bottom 55%",
                    scrub: true,
                    invalidateOnRefresh: true
                }
            });
        }
    }

    /* ==========================
       APPARITION DES ÉTAPES
    ========================== */

    if (steps.length > 0) {
        if (
            prefersReducedMotion ||
            !("IntersectionObserver" in window)
        ) {
            steps.forEach((step) => {
                step.classList.add("is-visible");
            });
        } else {
            const stepObserver = new IntersectionObserver(
                (entries, observer) => {
                    entries.forEach((entry) => {
                        if (entry.isIntersecting) {
                            entry.target.classList.add("is-visible");
                            observer.unobserve(entry.target);
                        }
                    });
                },
                {
                    threshold: 0.90,
                    rootMargin: "0px 0px -30% 0px"
                }
            );

            steps.forEach((step) => {
                stepObserver.observe(step);
            });
        }
    }

    window.addEventListener("load", () => {
        ScrollTrigger.refresh();
    });
});