document.addEventListener("DOMContentLoaded", () => {
    document.body.classList.add("is-ready");

    gsap.registerPlugin(ScrollTrigger);

    const journey = document.querySelector(".journey");
    const path = document.querySelector(".journey__path");
    const steps = document.querySelectorAll(".journey-step");
    const origin = document.querySelector(".journey-origin");
    const stage = document.querySelector(".journey-stage");
    const svg = document.querySelector(".journey-stage__svg");
    const destination = document.querySelector(".journey-destination");

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

if (
    journey &&
    path &&
    origin &&
    stage &&
    svg &&
    destination
) {
    const points = [
        origin,
        ...journey.querySelectorAll(".journey-step__point"),
        destination
    ];

    let journeyTween;

    const getPointPosition = (element, stageRect) => {
        const rect = element.getBoundingClientRect();

        return {
            x:
                rect.left +
                rect.width / 2 -
                stageRect.left,

            y:
                rect.top +
                rect.height / 2 -
                stageRect.top
        };
    };

    const buildSmoothPath = (
        coords,
        tension = 0.8
    ) => {
        if (coords.length < 2) {
            return "";
        }

        let d = `M ${coords[0].x} ${coords[0].y}`;

        for (
            let i = 0;
            i < coords.length - 1;
            i += 1
        ) {
            const p0 =
                coords[i - 1] || coords[i];

            const p1 = coords[i];
            const p2 = coords[i + 1];

            const p3 =
                coords[i + 2] || p2;

            const cp1 = {
                x:
                    p1.x +
                    ((p2.x - p0.x) / 6) *
                        tension,

                y:
                    p1.y +
                    ((p2.y - p0.y) / 6) *
                        tension
            };

            const cp2 = {
                x:
                    p2.x -
                    ((p3.x - p1.x) / 6) *
                        tension,

                y:
                    p2.y -
                    ((p3.y - p1.y) / 6) *
                        tension
            };

            d += `
                C ${cp1.x} ${cp1.y},
                  ${cp2.x} ${cp2.y},
                  ${p2.x} ${p2.y}
            `;
        }

        return d;
    };

    const drawJourneyPath = () => {
        const stageRect =
            stage.getBoundingClientRect();

        svg.setAttribute(
            "viewBox",
            `0 0 ${stageRect.width} ${stageRect.height}`
        );

        const coords = points.map((point) =>
            getPointPosition(
                point,
                stageRect
            )
        );

        path.setAttribute(
            "d",
            buildSmoothPath(coords)
        );

        /*
         * Supprime les points SVG
         * précédemment générés.
         */
        svg
            .querySelectorAll(
                ".journey__point"
            )
            .forEach((point) => {
                point.remove();
            });

        /*
         * Crée les vrais points
         * dans le même repère SVG
         * que la courbe.
         */
        coords.forEach(({ x, y }) => {
            const circle =
                document.createElementNS(
                    "http://www.w3.org/2000/svg",
                    "circle"
                );

            circle.setAttribute("cx", x);
            circle.setAttribute("cy", y);
            circle.setAttribute("r", "5");

            circle.classList.add(
                "journey__point"
            );

            svg.appendChild(circle);
        });
    };

    const createJourneyAnimation = () => {
        if (journeyTween) {
            journeyTween.scrollTrigger?.kill();
            journeyTween.kill();
        }

        drawJourneyPath();

        /*
         * TEMPORAIRE :
         * ligne toujours visible.
         * On remettra l'animation
         * ScrollTrigger à la fin.
         */
        gsap.set(path, {
            strokeDasharray: "none",
            strokeDashoffset: 0,
            autoAlpha: 1
        });
    };

    createJourneyAnimation();

    if (document.fonts?.ready) {
        document.fonts.ready.then(() => {
            createJourneyAnimation();
            ScrollTrigger.refresh();
        });
    }

    let resizeTimer;

    window.addEventListener(
        "resize",
        () => {
            window.clearTimeout(
                resizeTimer
            );

            resizeTimer =
                window.setTimeout(() => {
                    createJourneyAnimation();
                    ScrollTrigger.refresh();
                }, 150);
        }
    );

    window.addEventListener(
        "load",
        () => {
            createJourneyAnimation();
            ScrollTrigger.refresh();
        }
    );
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
});