window.skillBar = function (target) {
    return {
        target,
        displayed: 0,
        animated: false,
        observer: null,

        observe(el) {
            this.observer = new IntersectionObserver(
                (entries) => {
                    entries.forEach((entry) => {
                        if (entry.isIntersecting && !this.animated) {
                            this.animated = true;
                            this.animate();
                            this.observer.disconnect();
                        }
                    });
                },
                { threshold: 0.3 }
            );
            this.observer.observe(el);
        },

        animate() {
            const duration = 900;
            const steps = 60;
            const interval = duration / steps;
            const increment = this.target / steps;
            let current = 0;

            const timer = setInterval(() => {
                current += increment;
                if (current >= this.target) {
                    this.displayed = this.target;
                    clearInterval(timer);
                } else {
                    this.displayed = Math.round(current);
                }
            }, interval);
        },
    };
};
