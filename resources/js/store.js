export default {
  isDarkModeEnabled: false,
  isMonochromeModeEnabled: false,
  isSearchbarActive: false,
  isSidebarExpanded: false,
  isRightSidebarExpanded: false,

  init() {
    
    this.isSidebarExpanded =
      document.querySelector(".sidebar") &&
      document.body.classList.contains("is-sidebar-open") &&
      Alpine.store("breakpoints").xlAndUp;
    
    Alpine.store('darkMode', {
        on: Alpine.$persist(true).as('darkMode_on'),
        toggle() {
          this.on = ! this.on
        },
        dark(){
          this.on = true
        },
        bright(){
          this.on = false
        }
    });
    Alpine.store('monochrome', {
        on: Alpine.$persist(true).as('monochrome_on'),
        toggle() {
          this.on = ! this.on
        },
        dark(){
          this.on = true
        },
        bright(){
          this.on = false
        }
    });

    this.isDarkModeEnabled = Alpine.store('darkMode').on;
    this.isMonochromeModeEnabled = Alpine.store('monochrome').on;

    document.addEventListener('livewire:navigated', () => {
        // Triggered as the final step of any page navigation...
    
        // Also triggered on page-load instead of "DOMContentLoaded"...
        const _dm = Alpine.store('darkMode');
        const _origDark = _dm.dark;
        _dm.dark = function (...args) {
          // restore immediately so future calls aren't delayed
          _dm.dark = _origDark;
        };
        const _mm = Alpine.store('monochrome');
        const _origMono = _mm.dark;
        _mm.dark = function (...args) {
          // restore immediately so future calls aren't delayed
          _mm.dark = _origMono;
        };

        this.isSidebarExpanded =
          document.querySelector(".sidebar") &&
          document.body.classList.contains("is-sidebar-open") &&
          Alpine.store("breakpoints").xlAndUp;

        const preloader = document.querySelector(".app-preloader");
        if (preloader) {
          setTimeout(() => {
            preloader.classList.add("animate-[cubic-bezier(0.4,0,0.2,1)_fade-out_500ms_forwards]");
            setTimeout(() => preloader.remove(), 1000);
          }, 150);
        }
    })

    Alpine.effect(() => {
      if(this.isDarkModeEnabled){
        document.body.classList.add("dark");
        Alpine.store('darkMode').dark();
      } else {
        document.body.classList.remove("dark");
        Alpine.store('darkMode').bright();
      }
    });

    Alpine.effect(() => {
      if(this.isMonochromeModeEnabled){
        document.body.classList.add("is-monochrome");
        Alpine.store('monochrome').dark();
      } else {
        document.body.classList.remove("is-monochrome");
        Alpine.store('monochrome').bright();
      }
    });

    Alpine.effect(() => {
      if(this.isSidebarExpanded){
        document.body.classList.add("is-sidebar-open");
      } else {
        document.body.classList.remove("is-sidebar-open");
      }
    });

    Alpine.effect(() => {
      if (Alpine.store("breakpoints").smAndUp) this.isSearchbarActive = false;
    });

    window.addEventListener('changed:breakpoint', () => {
      if (this.isSidebarExpanded) this.isSidebarExpanded = false;
      if (this.isRightSidebarExpanded) this.isRightSidebarExpanded = false;
    })
  },

  documentBody: {
    ["@load.window"]() {
      const preloader = document.querySelector(".app-preloader");
      if (!preloader) return;
      setTimeout(() => {
        preloader.classList.add(
          "animate-[cubic-bezier(0.4,0,0.2,1)_fade-out_500ms_forwards]"
        );
        setTimeout(() => preloader.remove(), 1000);
      }, 150);
    },
  },
};
