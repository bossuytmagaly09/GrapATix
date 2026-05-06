document.addEventListener('DOMContentLoaded', () => {
    // Hero Entrance
    if (typeof gsap !== 'undefined') {
        const tl = gsap.timeline({ defaults: { ease: "power4.out", duration: 1.2 }});

        tl.from('.hero-content h1', { y: 60, opacity: 0 })
          .from('.hero-content p', { y: 30, opacity: 0 }, "-=0.8")
          .from('.code-mockup', { x: 100, opacity: 0, rotation: 5 }, "-=1")
          .from('.event-card', { 
              y: 50, 
              opacity: 0, 
              stagger: 0.2, 
              duration: 0.8 
          }, "-=0.5");

        // Micro-interactie op buttons
        const buttons = document.querySelectorAll('button');
        buttons.forEach(btn => {
            btn.addEventListener('mouseenter', () => {
                gsap.to(btn, { scale: 1.02, duration: 0.2 });
            });
            btn.addEventListener('mouseleave', () => {
                gsap.to(btn, { scale: 1, duration: 0.2 });
            });
        });
    }
});
