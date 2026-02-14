document.addEventListener("DOMContentLoaded", function () {
  initHeaderHeight();
  stickyHeader();
  burgerMenu();
  megaMenu();
  initBannerSlider();
  initExploreSlider();
  initGallerySlider();
  initAwardSlider();
  initAccordion();
  initBannerGallerySliderMobile();
  initItinaryAccordion();
  initSidebarwithAccordion();
  scrollToTop();
  smoothScroll();

  document.querySelectorAll("[data-fancybox]").forEach(el => {
    const galleryName = el.getAttribute("data-fancybox");

    Fancybox.bind(`[data-fancybox='${galleryName}']`, {
      Thumbs: {
        autoStart: true
      }
    });
  });
});

//Header height
function initHeaderHeight() {
  const header = document.querySelector('#header'); // change your header selector here
  if (!header) return;

  const height = header.offsetHeight;
  document.body.style.setProperty('--header-height', height + 'px');
  // return height;
}

window.addEventListener('resize', function() {
  initHeaderHeight();

  if (window.innerWidth > 1023) {
    document.body.classList.remove('nav-active');
    document.querySelectorAll('.has-megamenu').forEach(el => {
      el.classList.remove('submenu-active');
    });

    document.querySelectorAll('.menu-dropdown').forEach(el => {
      el.removeAttribute('style');
    });
  }
});

window.addEventListener("scroll", function () {
  // stickyHeader();
  initHeaderHeight();
});

//Sticky Header
function stickyHeader() {
  let lastScroll = 0;
  const header = document.querySelector('#header');

  window.addEventListener('scroll', () => {
    const currentScroll = window.scrollY;
    if (currentScroll >= 100) {
      document.body.classList.add('sticky');
    } else {
      document.body.classList.remove('sticky');
    }

    // If at top → always show
    if (currentScroll === 0) {
      header.classList.remove('hidden');
      lastScroll = 0;
      return;
    }

     // Ignore micro changes
    if (currentScroll === lastScroll) return;

    if (currentScroll > lastScroll) {
      // scroll down → show
      header.classList.add('hidden');
    } else {
      // scroll up → hide
      header.classList.remove('hidden');
    }

    lastScroll = currentScroll;
  }, { passive: true });
}

//Hamburger Menu
function burgerMenu() {
  // Open/Close Nav
  const navOpener = document.querySelector('.nav-opener');
  const navClose = document.querySelector('.nav-close');
  const dropArea = document.querySelector('.drop');

  if (navOpener) {
    navOpener.addEventListener("click", function (e) {
      e.preventDefault();
      document.body.classList.toggle("nav-active");
    });
  }

  if (navClose) {
    navClose.addEventListener("click", function (e) {
      e.preventDefault();
      document.body.classList.remove("nav-active");

      document.querySelectorAll('.has-megamenu').forEach(el => {
        el.classList.remove('submenu-active');
      });

      document.querySelectorAll('.menu-dropdown').forEach(el => {
        el.removeAttribute('style');
      });
    });
  }

  // Add arrow before submenu
  document.querySelectorAll('#nav .menu-item-has-children .sub-menu, #nav .has-megamenu .menu-dropdown ')
    .forEach((subMenu) => {
      const arrow = document.createElement("span");
      arrow.className = "arrow";
      arrow.textContent = "arrow";
      subMenu.parentNode.insertBefore(arrow, subMenu);
    });

  // Toggle submenus
  document.querySelectorAll('.arrow').forEach((arrow) => {
    arrow.addEventListener("click", function () {
      const submenu = this.nextElementSibling;

      // Slide toggle alternative (simple toggle)
      if (submenu.style.display === "block") {
        submenu.style.display = "none";
      } else {
        submenu.style.display = "block";
      }

      this.parentElement.classList.toggle("submenu-active");
    });
  });

  document.addEventListener("click", function (e) {
    const isClickInside =
      dropArea && dropArea.contains(e.target);

    const isOpener = navOpener && navOpener.contains(e.target);

    if (!isClickInside && !isOpener) {
      document.body.classList.remove("nav-active");
      document.querySelectorAll('.has-megamenu').forEach(el => {
        el.classList.remove('submenu-active');
      });

      document.querySelectorAll('.menu-dropdown').forEach(el => {
        el.removeAttribute('style');
      });
    }
  });
}

function megaMenu() {
  document.querySelectorAll(".has-megamenu").forEach(function (parentMenu) {
    const buttons = parentMenu.querySelectorAll(".tab-lists button");
    const contents = parentMenu.querySelectorAll(".tab-content");

    if (buttons.length === 0 || contents.length === 0) return;

    // Hide all content first
    // contents.forEach(c => c.style.display = "none");

    // Activate the FIRST tab by default
    const firstBtn = buttons[0];
    const firstTarget = firstBtn.getAttribute("data-target");
    // parentMenu.querySelector("#" + firstTarget).style.display = "block";
    parentMenu.querySelector("#" + firstTarget).classList.add('tab-active');
    firstBtn.classList.add("active");

    // Add event click for each tab button
    buttons.forEach(btn => {
      btn.addEventListener("click", function () {

        // Remove active from all buttons inside this parent only
        buttons.forEach(b => b.classList.remove("active"));

        // Hide all tab contents inside this parent only
        contents.forEach(c => {
          // c.style.display = "none";
          c.classList.remove('tab-active');
        });

        // Show the selected tab content
        const targetId = this.getAttribute("data-target");
        const targetContent = parentMenu.querySelector("#" + targetId);
        if (targetContent) {
          // targetContent.style.display = "block";
          targetContent.classList.add("tab-active");

          // Scroll to content on mobile/tablet
          const tabListsContainer = parentMenu.querySelector(".tab-lists");
          if (tabListsContainer) {
            setTimeout(() => {
              this.scrollIntoView({
                behavior: "smooth",
                block: "nearest",
                inline: "center" // Centers the clicked button horizontally
              });
            }, 100);
          }
        }

        // Mark tab active
        this.classList.add("active");
      });
    });

  });
}

//Banner Slider
function initBannerSlider() {
  document.querySelectorAll('.banner-slider').forEach((swiperEl) => {
    new Swiper(swiperEl, {
      loop: true,
      speed: 800,
      autoplay: {
        delay: 8000,
        disableOnInteraction: false
      },

      pagination: {
        el: swiperEl.querySelector('.swiper-pagination'),
        clickable: true,
      },

      navigation: {
        nextEl: swiperEl.querySelector('.swiper-button-next'),
        prevEl: swiperEl.querySelector('.swiper-button-prev'),
      },
    });
  });
}

//Explore Slider
function initExploreSlider() {
  document.querySelectorAll('.explore-slider').forEach((swiperEl) => {
    new Swiper(swiperEl, {
      loop: true,
      speed: 800,
      autoplay: {
        delay: 8000,
        disableOnInteraction: false
      },

      breakpoints: {
        0: { slidesPerView: 1 },
        768: { slidesPerView: 2 },
        1024: { slidesPerView: 3 },
        1200: { slidesPerView: 4 },
      },

      navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
      },
    });
  });
}

//Image Gallery Slider
function initGallerySlider() {
  document.querySelectorAll('.gallery-slider').forEach((swiperEl) => {
    new Swiper(swiperEl, {
      loop: true,
      speed: 800,
      autoplay: {
        delay: 8000,
        disableOnInteraction: false
      },
      spaceBetween: 30,

      breakpoints: {
        0: { slidesPerView: 1 },
        768: { slidesPerView: 2 },
        1024: { slidesPerView: 3 },
        1200: { slidesPerView: 4 },
      },

      navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
      },
    });
  });
}

//Awards Slider
function initAwardSlider() {
  document.querySelectorAll('.award-slider').forEach((swiperEl) => {
    new Swiper(swiperEl, {
      loop: true,
      speed: 800,
      autoplay: {
        delay: 8000,
        disableOnInteraction: false
      },

      breakpoints: {
        0: { slidesPerView: 1 },
        768: { slidesPerView: 2 },
      },
      navigation: {
        nextEl: '.award-next',
        prevEl: '.award-prev',
      },
    });
  });
}

//Accordion
function initAccordion() {
  const items = document.querySelectorAll(".accordion .accordion-list");
  const headers = document.querySelectorAll(".accordion .accordion-list .title");
  const imgWraps = document.querySelectorAll('.col-image .img-wrap');
  const MOBILE_BREAK = 1024;

  // 🔒 If the page has no accordion, STOP here (prevents errors)
  if (!items.length || !headers.length) return;

  let isMobileView = window.innerWidth <= MOBILE_BREAK;

  function isMobile() {
    return window.innerWidth <= MOBILE_BREAK;
  }

  function openSlide(slide) {
    if (!slide) return; // prevent error
    slide.style.maxHeight = slide.scrollHeight + "px";
  }

  function closeSlide(slide) {
    if (!slide) return; // prevent error
    slide.style.maxHeight = "0px";
  }

  function openDesktopImage(dataIndex) {
    if (!imgWraps.length) return; // no images → skip
    imgWraps.forEach(w =>
      w.classList.toggle("active", w.getAttribute('data-index') === dataIndex)
    );
  }

  // Initialize slides
  items.forEach(item => {
    const slide = item.querySelector('.slide');
    if (item.classList.contains('active')) openSlide(slide);
    else closeSlide(slide);
  });

  headers.forEach(header => {
    header.addEventListener("click", () => {
      const parent = header.parentElement;
      const slide = parent.querySelector(".slide");
      const dataIndex = header.getAttribute("data-index");

      if (isMobile()) {
        if (parent.classList.contains("active")) {
          parent.classList.remove("active");
          closeSlide(slide);
        } else {
          items.forEach(item => {
            item.classList.remove("active");
            closeSlide(item.querySelector('.slide'));
          });
          parent.classList.add("active");
          openSlide(slide);
        }
      } else {
        items.forEach(item => {
          item.classList.remove("active");
          closeSlide(item.querySelector(".slide"));
        });
        parent.classList.add("active");
        openSlide(slide);
      }

      openDesktopImage(dataIndex);
    });
  });

  window.addEventListener("resize", () => {
    const wasMobile = isMobileView;
    isMobileView = isMobile();

    items.forEach(item => {
      const slide = item.querySelector(".slide");
      if (item.classList.contains('active')) openSlide(slide);
      else closeSlide(slide);
    });

    if (!isMobileView && wasMobile) {
      const anyActive = [...items].some(item => item.classList.contains("active"));
      if (!anyActive && items.length) {
        const firstItem = items[0];
        firstItem.classList.add("active");
        openSlide(firstItem.querySelector(".slide"));
        openDesktopImage(firstItem.querySelector(".title").getAttribute("data-index"));
      }
    }
  });
}

//Banner Gallery Slider Mobile
function initBannerGallerySliderMobile() {
  document.querySelectorAll('.banner-gallery-slider-mobile').forEach((swiperEl) => {
    new Swiper(swiperEl, {
      loop: true,
      speed: 800,
      autoplay: {
        delay: 8000,
        disableOnInteraction: false
      },

      navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
      },
    });
  });
}

function setMaxHeight(content, expand) {
  if (!content) return;
  content.style.setProperty(
    '--max-height',
    expand ? content.scrollHeight + 'px' : '0px'
    );
}

//Itinary Accordion
function initItinaryAccordion() {
  const container = document.querySelector('.itinary-accordion');
  if (!container) return;

  const accordionItems = container.querySelectorAll('.accordion-list');
  const toggleAllBtn = document.querySelector('.toggle-all-accordion');



  function updateToggleBtn() {
    if (!toggleAllBtn) return;
    const allActive = [...accordionItems].every(item => item.classList.contains('active'));
    toggleAllBtn.textContent = allActive ? 'Hide All' : 'Show All';
  }

  accordionItems.forEach(item => {
    const header = item.querySelector('.accordion-heading');
    const content = item.querySelector('.accordion-slide');

    header.addEventListener('click', () => {
      const isActive = item.classList.contains('active');

      // Close other items
      accordionItems.forEach(other => {
        if (other !== item) {
          other.classList.remove('active');
          const otherHeader = other.querySelector('.accordion-heading');
          const otherContent = other.querySelector('.accordion-slide');

          if (otherHeader) otherHeader.classList.remove('active');
          if (otherContent) setMaxHeight(otherContent, false);
        }
      });

      // Toggle this item
      item.classList.toggle('active', !isActive);
      header.classList.toggle('active', !isActive);
      setMaxHeight(content, !isActive);

      updateToggleBtn();
    });
  });

  // Toggle all button
  if (toggleAllBtn) {
    toggleAllBtn.addEventListener('click', e => {
      e.preventDefault();

      const allActive = [...accordionItems].every(item => item.classList.contains('active'));

      accordionItems.forEach(item => {
        const header = item.querySelector('.accordion-heading');
        const content = item.querySelector('.accordion-slide');

        item.classList.toggle('active', !allActive);
        header.classList.toggle('active', !allActive);
        setMaxHeight(content, !allActive);
      });

      updateToggleBtn();
    });
  }

  updateToggleBtn();
}

// Smooth Scrolling + Accordion + Sidebar Sync
function initSidebarwithAccordion() {
  const sidebarLinks = document.querySelectorAll(".sidebar-link");
  const sections = document.querySelectorAll(".accordion-list");
  const headerOffset = parseInt(getComputedStyle(document.body).getPropertyValue('--header-height')) || 0;

  // ---------------------------
  // Helper: Scroll sidebar link into view (mobile)
  // ---------------------------
  function scrollSidebarToActive(link) {
    if (link && link.scrollIntoView) {
      link.scrollIntoView({
        behavior: "smooth",
        block: "nearest",
        inline: "center" // horizontally center on mobile
      });
    }
  }

  // ---------------------------
  // Accordion Toggle per Item
  // ---------------------------
  function initAccordionItems() {
    const accordionItems = document.querySelectorAll(".accordion-item");

    accordionItems.forEach(item => {
      const header = item.querySelector(".title");
      const content = item.querySelector(".slide");

      header.addEventListener("click", () => {
        const isActive = item.classList.contains("active");

        // Close all items in the same accordion
        const parentAccordion = item.closest(".accordion");
        parentAccordion.querySelectorAll(".accordion-item").forEach(i => {
          i.classList.remove("active");
          const c = i.querySelector(".slide");
          c.style.maxHeight = "0"; // smoothly collapse
        });

        // Toggle clicked one
        if (!isActive) {
          item.classList.add("active");
          // Force reflow before setting maxHeight
          content.style.maxHeight = content.scrollHeight + "px";
        }

        // Update the Expand/Collapse All button text
        const parentList = item.closest(".accordion-list");
        const toggleBtn = parentList.querySelector(".btn-toggle");
        const items = parentList.querySelectorAll(".accordion-item");
        const allOpen = [...items].every(i => i.classList.contains("active"));
        toggleBtn.textContent = allOpen ? "Collapse All" : "Expand All";
      });
    });
  }


  // ---------------------------
  // Expand / Collapse All
  // ---------------------------
  function initExpandCollapseAll() {
    const toggleButtons = document.querySelectorAll(".btn-toggle");

    toggleButtons.forEach(btn => {
      btn.addEventListener("click", e => {
        e.preventDefault();
        const parentAccordion = btn.closest(".accordion-list");
        const slides = parentAccordion.querySelectorAll(".accordion-item .slide");
        const expandAll = btn.textContent.toLowerCase().includes("expand");

        slides.forEach(slide => {
          slide.style.maxHeight = expandAll ? slide.scrollHeight + "px" : null;
        });

        btn.textContent = expandAll ? "Collapse All" : "Expand All";
      });
    });
  }

  // ---------------------------
  // Smooth Scroll on Click
  // ---------------------------
  sidebarLinks.forEach(link => {
    link.addEventListener("click", e => {
      e.preventDefault();

      const id = link.getAttribute("href").replace("#", "");
      const target = document.getElementById(id);
      if (!target) return;

      // Remove previous active class
      sidebarLinks.forEach(l => l.classList.remove("active"));
      link.classList.add("active");

      // Scroll sidebar (mobile)
      scrollSidebarToActive(link);

      const offsetTop = target.getBoundingClientRect().top + window.scrollY - headerOffset;

      window.scrollTo({
        top: offsetTop,
        behavior: "smooth"
      });
    });
  });

  // ---------------------------
  // Scroll Spy – change active link while scrolling
  // ---------------------------
  function onScroll() {
    const scrollPos = window.scrollY + headerOffset + 2;

    sections.forEach(section => {
      const top = section.offsetTop;
      const height = section.offsetHeight;

      if (scrollPos >= top && scrollPos < top + height) {
        const id = section.getAttribute("id");

        sidebarLinks.forEach(link => link.classList.remove("active"));

        const activeLink = Array.from(sidebarLinks).find(link => link.getAttribute("href") === `#${id}`);

        if (activeLink) {
          activeLink.classList.add("active");

          // Auto-scroll sidebar on mobile
          if (window.innerWidth <= 768) {
            setTimeout(() => scrollSidebarToActive(activeLink), 50);
          }
        }
      }
    });
  }

  window.addEventListener("scroll", onScroll);
  onScroll(); // run initially

  // ---------------------------
  // Initialize Accordions
  // ---------------------------
  initAccordionItems();
  initExpandCollapseAll();
}

//scroll to top
function scrollToTop() {
  const scrollTopBtn = document.querySelector('.scroll-top-btn');

  if(!scrollTopBtn) return;

  window.addEventListener('scroll', () => {
    const scrollTop = window.scrollY || document.documentElement.scrollTop;
    const docHeight = document.documentElement.scrollHeight - window.innerHeight;
    const scrollPercent = (scrollTop / docHeight) * 100;

    if (scrollPercent > 10) {
      scrollTopBtn.classList.add('show');
    } else {
      scrollTopBtn.classList.remove('show');
    }
  }, { passive: true });

  scrollTopBtn.addEventListener('click', () => {
    window.scrollTo({
      top: 0,
      behavior: 'smooth'
    });
  });
}

//Smooth Scroll
function smoothScroll() {
  document.querySelectorAll('.scroll-down').forEach(arrow => {
  arrow.addEventListener('click', e => {
    e.preventDefault();
    const target = document.querySelector(arrow.getAttribute('href'));
    if (!target) return;


    const offset = parseInt(getComputedStyle(document.body).getPropertyValue('--header-height')) || 0;
    const offsetTop = target.getBoundingClientRect().top + window.scrollY - offset + 8;

    window.scrollTo({ top: offsetTop, behavior: 'smooth' });
  });
});
}
