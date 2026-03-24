document.addEventListener('DOMContentLoaded', function () {
    const revealItems = document.querySelectorAll('.use-card, .product-card, .category-spotlight, .testimonial-slab, .ribbon-card');

    if (!('IntersectionObserver' in window) || revealItems.length === 0) {
        return;
    }

    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                entry.target.animate(
                    [
                        { opacity: 0, transform: 'translateY(18px)' },
                        { opacity: 1, transform: 'translateY(0)' }
                    ],
                    {
                        duration: 450,
                        easing: 'ease-out',
                        fill: 'forwards'
                    }
                );
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.12 });

    revealItems.forEach((item) => {
        item.style.opacity = '0';
        observer.observe(item);
    });
});
