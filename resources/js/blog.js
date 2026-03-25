window.readingProgress = function () {
    return {
        progress: 0,

        init() {
            this.update();
            window.addEventListener('scroll', () => this.update(), { passive: true });
        },

        update() {
            const scrollTop = window.scrollY;
            const docHeight = document.documentElement.scrollHeight;
            const windowHeight = window.innerHeight;
            const scrollable = docHeight - windowHeight;

            this.progress = scrollable > 0
                ? Math.min(100, Math.round((scrollTop / scrollable) * 100))
                : 0;
        },
    };
};

window.tocSidebar = function () {
    return {
        activeSlug: '',
        observer: null,

        init() {
            const headings = document.querySelectorAll(
                '#prose-body h1, #prose-body h2, #prose-body h3'
            );

            if (!headings.length) return;

            this.activeSlug = headings[0]?.id ?? '';

            this.observer = new IntersectionObserver(
                (entries) => {
                    entries.forEach((entry) => {
                        if (entry.isIntersecting) {
                            this.activeSlug = entry.target.id;
                        }
                    });
                },
                {
                    rootMargin: '-10% 0px -80% 0px',
                    threshold: 0,
                }
            );

            headings.forEach((h) => this.observer.observe(h));
        },

        scrollToHeading(slug) {
            const el = document.getElementById(slug);
            if (!el) return;
            const offset = 80;
            const top = el.getBoundingClientRect().top + window.scrollY - offset;
            window.scrollTo({ top, behavior: 'smooth' });
            this.activeSlug = slug;
        },

        destroy() {
            this.observer?.disconnect();
        },
    };
};
