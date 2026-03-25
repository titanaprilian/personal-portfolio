window.iconPicker = function (name, initialSlug = '') {
    return {
        name,
        open: false,
        loading: false,
        search: '',
        allIcons: [],
        selectedSlug: initialSlug,
        selectedTitle: '',

        async loadIcons() {
            if (this.allIcons.length > 0) return;
            this.loading = true;
            try {
                const res = await fetch(
                    'https://cdn.jsdelivr.net/npm/simple-icons@latest/data/simple-icons.json'
                );
                const data = await res.json();
                this.allIcons = data.map(i => ({
                    title: i.title,
                    slug: i.slug,
                }));
                this.applyInitialValue();
            } catch (e) {
                console.error('Failed to load Simple Icons index', e);
            } finally {
                this.loading = false;
            }
        },

initFromDataAttribute() {
            setTimeout(() => {
                const wrapper = this.$el.closest('[data-icon]');
                if (wrapper && wrapper.dataset.icon) {
                    this.selectedSlug = wrapper.dataset.icon;
                }
                this.loadIcons().then(() => {
                    if (this.selectedSlug) {
                        this.applyInitialValue();
                    }
                });
            }, 100);
        },

        checkForExternalUpdate() {
            const wrapper = this.$el.closest('[data-icon]');
            if (wrapper && wrapper.dataset.icon && wrapper.dataset.icon !== this.selectedSlug) {
                this.selectedSlug = wrapper.dataset.icon;
                this.applyInitialValue();
            }
        },

        updateFromParent() {
            const wrapper = this.$el.closest('[data-icon]');
            if (wrapper && wrapper.dataset.icon && !this.selectedSlug) {
                this.selectedSlug = wrapper.dataset.icon;
                this.applyInitialValue();
            }
        },

        applyInitialValue() {
            if (this.selectedSlug) {
                const match = this.allIcons.find(i => i.slug === this.selectedSlug);
                if (match) this.selectedTitle = match.title;
            }
        },

        get filteredIcons() {
            if (!this.search.trim()) return this.allIcons.slice(0, 200);
            const q = this.search.toLowerCase();
            return this.allIcons.filter(i =>
                i.title.toLowerCase().includes(q) ||
                i.slug.toLowerCase().includes(q)
            );
        },

        selectIcon(icon) {
            this.selectedSlug = icon.slug;
            this.selectedTitle = icon.title;
            this.open = false;
        },
    };
};
