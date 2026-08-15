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
    let journeyTween;
    let journeyHasStarted = false;
    let autoStartTimer;

    /* ==========================
   HERO + HEARTBEAT
========================== */

const createHeartbeat = () => {
    const originPoint = document.querySelector(
        ".journey__point--origin"
    );

    if (!originPoint || prefersReducedMotion) {
        return;
    }

    if (heartbeat) {
        heartbeat.kill();
    }

    heartbeat = gsap.timeline({
        paused: true
    });

    const addHeartbeat = () => {
        heartbeat
            .to(originPoint, {
                scale: 3.5,//gros battement
                transformOrigin: "center center",
                duration: 0.3,
                ease: "power2.out"
            })
            .to(originPoint, {
                scale: 0.85,//retour à la normale
                duration: 0.28,
                ease: "power2.in"
            })
            .to(
                originPoint,
                {
                    scale: 1.12,//petit battement
                    transformOrigin: "center center",
                    duration: 0.24,
                    ease: "power2.out"
                },
                "+=0.12"
            )
            .to(originPoint, {
                scale: 1,
                duration: 0.18,
                ease: "power2.in"
            })
            .to({}, {
                duration: 1.2
            });
    };

    for (let i = 0; i < 7; i += 1) {
        addHeartbeat();
    }
};

const startJourney = () => {
    if (journeyHasStarted) {
        return;
    }

    journeyHasStarted = true;

    window.clearTimeout(autoStartTimer);

    if (heartbeat) {
        heartbeat.pause();
    }

    gsap.set(".journey__point--origin", {
        scale: 1
    });
};

window.addEventListener("scroll", startJourney, {
    once: true,
    passive: true
});

if (!prefersReducedMotion) {
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
            document.body.classList.add(
                "journey-origin-visible"
            );

            createHeartbeat();

            if (heartbeat) {
                heartbeat.play();
            }

            const autoDrawJourney = () => {
    if (journeyHasStarted || !journeyTween) {
        return;
    }

    journeyHasStarted = true;

    if (heartbeat) {
        heartbeat.pause();
    }

    gsap.set(".journey__point--origin", {
        scale: 1
    });

    journeyTween.scrollTrigger?.disable();

    gsap.to(path, {
        strokeDashoffset: 0,
        duration: 5,
        ease: "power1.inOut"
    });
};

            autoStartTimer = window.setTimeout(
                autoDrawJourney,
                7000
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

    document.body.classList.add(
        "journey-origin-visible"
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
        tension = 1
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
        coords.forEach(({ x, y }, index) => {
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
            circle.dataset.pointIndex = index;

            if (index === 0) {
        circle.classList.add("journey__point--origin");
    }

            svg.appendChild(circle);
        });
    };

    const createJourneyAnimation = () => {
        if (journeyTween) {
            journeyTween.scrollTrigger?.kill();
            journeyTween.kill();
        }

        drawJourneyPath();

        const pathLength = path.getTotalLength();

gsap.set(path, {
    strokeDasharray: `${pathLength} ${pathLength}`,
    strokeDashoffset: pathLength,
    autoAlpha: 1
});

journeyTween = gsap.to(path, {
    strokeDashoffset: 0,
    ease: "none",

    scrollTrigger: {
        trigger: stage,
        start: "top top",

        endTrigger: destination,
        end: "center 70%",

        scrub: true,
        invalidateOnRefresh: true
    }
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

        steps.forEach((step, index) => {

            step.classList.add("is-visible");

            const svgPoint = svg?.querySelector(
                `.journey__point[data-point-index="${index + 1}"]`
            );

            if (svgPoint) {
                svgPoint.classList.add("is-visible");
            }
        });

    } else {

        const stepObserver = new IntersectionObserver(
            (entries, observer) => {

               entries.forEach((entry) => {

    const stepIndex =
        Array.from(steps).indexOf(entry.target) + 1;

    const svgPoint = svg?.querySelector(
        `.journey__point[data-point-index="${stepIndex}"]`
    );

    if (entry.isIntersecting) {

        entry.target.classList.add("is-visible");

        if (svgPoint) {
            svgPoint.classList.add("is-visible");
        }

    } else {

        entry.target.classList.remove("is-visible");

        if (svgPoint) {
            svgPoint.classList.remove("is-visible");
        }
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