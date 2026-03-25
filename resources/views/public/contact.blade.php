<x-layouts.app title="Contact — {{ config('app.name') }}">

  <div class="max-w-2xl mx-auto px-6 pt-20 pb-24">

    <div class="mb-10" style="animation: fadeSlideUp 0.5s ease both">
      <p class="font-display text-[--color-neon] text-xs tracking-widest uppercase mb-3">
        // get in touch
      </p>
      <h1 class="font-display text-4xl md:text-5xl font-bold
                 text-[--color-text] leading-tight mb-4">
        Contact
      </h1>
      <p class="text-[--color-muted] leading-relaxed">
        Have a project in mind, a question, or just want to say hi?
        Fill out the form and I'll get back to you as soon as possible.
      </p>
    </div>

    <div style="animation: fadeSlideUp 0.5s ease 0.1s both"
         x-data="contactForm('{{ old('message', '') }}')">

      <form method="POST" action="{{ route('contact.store') }}"
            @submit="submitting = true"
            class="space-y-5">
        @csrf

        <div style="display:none" aria-hidden="true">
          <input type="text" name="website" tabindex="-1" autocomplete="off" />
        </div>

        <div>
          <label for="name"
                 class="block text-xs font-display text-[--color-muted]
                        tracking-widest uppercase mb-2">
            Name <span style="color:var(--color-neon)">*</span>
          </label>
          <input
            type="text"
            id="name"
            name="name"
            value="{{ old('name') }}"
            required
            autocomplete="name"
            placeholder="Your full name"
            class="w-full px-4 py-3 rounded-xl border text-sm font-display
                   text-[--color-text] placeholder-[--color-muted]/50
                   focus:outline-none transition-all duration-200
                   {{ $errors->has('name')
                       ? 'border-red-500 bg-red-500/5'
                       : 'border-[--color-border] bg-[--color-surface] focus:border-[--color-neon]/50' }}"
            style="caret-color: var(--color-neon)"
          />
          @error('name')
            <p class="mt-1.5 text-xs font-display flex items-center gap-1"
               style="color: #f87171">
              <span>⚠</span> {{ $message }}
            </p>
          @enderror
        </div>

        <div>
          <label for="email"
                 class="block text-xs font-display text-[--color-muted]
                        tracking-widest uppercase mb-2">
            Email <span style="color:var(--color-neon)">*</span>
          </label>
          <input
            type="email"
            id="email"
            name="email"
            value="{{ old('email') }}"
            required
            autocomplete="email"
            placeholder="your@email.com"
            class="w-full px-4 py-3 rounded-xl border text-sm font-display
                   text-[--color-text] placeholder-[--color-muted]/50
                   focus:outline-none transition-all duration-200
                   {{ $errors->has('email')
                       ? 'border-red-500 bg-red-500/5'
                       : 'border-[--color-border] bg-[--color-surface] focus:border-[--color-neon]/50' }}"
            style="caret-color: var(--color-neon)"
          />
          @error('email')
            <p class="mt-1.5 text-xs font-display flex items-center gap-1"
               style="color: #f87171">
              <span>⚠</span> {{ $message }}
            </p>
          @enderror
        </div>

        <div>
          <label for="message"
                 class="block text-xs font-display text-[--color-muted]
                        tracking-widest uppercase mb-2">
            Message <span style="color:var(--color-neon)">*</span>
          </label>
          <textarea
            id="message"
            name="message"
            required
            rows="6"
            maxlength="2000"
            placeholder="Tell me about your project or question..."
            x-model="message"
            class="w-full px-4 py-3 rounded-xl border text-sm font-display
                   text-[--color-text] placeholder-[--color-muted]/50
                   focus:outline-none transition-all duration-200 resize-none
                   {{ $errors->has('message')
                       ? 'border-red-500 bg-red-500/5'
                       : 'border-[--color-border] bg-[--color-surface] focus:border-[--color-neon]/50' }}"
            style="caret-color: var(--color-neon)"
          >{{ old('message') }}</textarea>

          <div class="flex items-start justify-between mt-1.5">
            @error('message')
              <p class="text-xs font-display flex items-center gap-1"
                 style="color: #f87171">
                <span>⚠</span> {{ $message }}
              </p>
            @else
              <span></span>
            @enderror
            <span class="text-xs font-display ml-auto"
                  :style="message.length > 1800
                    ? 'color: #f87171'
                    : 'color: var(--color-muted)'"
                  x-text="message.length + ' / 2000'">
              0 / 2000
            </span>
          </div>
        </div>

        <div class="pt-2">
          <button
            type="submit"
            :disabled="submitting"
            class="w-full py-3.5 rounded-xl font-display text-sm font-bold
                   tracking-widest uppercase transition-all duration-200
                   disabled:opacity-60 disabled:cursor-not-allowed"
            :style="submitting ? '' : 'box-shadow: 0 0 20px var(--color-neon-dim)'"
            onmouseover="if(!this.disabled) this.style.boxShadow='0 0 35px var(--color-neon-dim)'"
            onmouseout="this.style.boxShadow='0 0 20px var(--color-neon-dim)'"
            style="background: var(--color-neon); color: var(--color-bg);">
            <span x-show="!submitting">Send Message</span>
            <span x-show="submitting" class="flex items-center justify-center gap-2">
              <svg class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10"
                        stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor"
                  d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
              </svg>
              Sending...
            </span>
          </button>
        </div>

      </form>

      <div class="mt-12 pt-8 border-t"
           style="border-color: var(--color-border)">
        <p class="text-xs font-display text-[--color-muted] tracking-widest
                  uppercase mb-4">
          // or reach me directly
        </p>
        <div class="space-y-3">
          <a href="mailto:titanaprilian73@gmail.com"
             class="flex items-center gap-3 text-sm transition-colors duration-200 group"
             style="color: var(--color-muted)">
            <svg class="w-4 h-4 flex-shrink-0 group-hover:text-[--color-neon] transition-colors"
                 fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0
                   002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
            </svg>
            <span class="group-hover:text-[--color-neon] transition-colors font-display">
              titanaprilian73@gmail.com
            </span>
          </a>
        </div>
      </div>

    </div>
  </div>

</x-layouts.app>
