/*
Theme Name: Fincatch HTML5 Template
Theme URI: 
Design by: 
Developed by: Flash Coder Studio
Version: 1.0
License: 
Tags: 
*/

(($) => {
  ("use strict");

  menuBar();

  bgImg();

  venoBox();

  animeCounterUp();

  myProgressBar();

  keyBenefits();

  featuredSection();

  selecedSection();

  AccordionPClass();

  testimonialSlider();

  bannerSlider();

  partnersLogoSlider();

  commentSlider();

  mySelect();

  backToTop();

  wow();

  /*====== Active Plugins ======

        1 Menu Bar

        2 BG Img

        3 VenoBox

        4 Anime Counter Up

        5 My Progress Bar

        6 Key Benefits

        7 Featured Section

        8 Section Section

        9 Accordion P Class

        10 Testimonial Slider

        11 Banner Slider

        12 Partners Logo Slider

        13 Comment Slider

        14 My Select

        15 Back To Top

        16 Wow

    =============================*/

  /*=====================
      1 Menu Bar
  =======================*/

  $(".menu-bar .siderbar-menu .close-btn")
    .parents(".menu-right")
    .find(".siderbar-menu")
    .before(`<div class="siderbar-overlay"></div>`);

  $(".menu-bar .siderbar-btns").on("click", function () {
    $(this).parents(".menu-right").find(".siderbar-menu").addClass("active");
    $(this).parents(".menu-right").find(".siderbar-overlay").addClass("active");
  });

  $(".menu-bar .siderbar-menu .close-btn, .menu-bar .siderbar-overlay").on(
    "click",
    function () {
      $(this)
        .parents(".menu-right")
        .find(".siderbar-menu")
        .removeClass("active");
      $(this)
        .parents(".menu-right")
        .find(".siderbar-overlay")
        .removeClass("active");
    }
  );

  function menuBar() {
    let copyMenuLogo = $(".menu-bar .menu-logo").html();
    let copyMenuList = $(".menu-bar .main-menu ul").html();

    $(".menu-bar .menu-right").append(`<div class="search-overlay"></div>`);

    $(".menu-bar .mobile-menu-bar .mobile-content").before(`
        <div class="mobile-menu-header">
          <div class="mobile-logo">${copyMenuLogo}</div>
          <button class="close-mobile-btn"><i class="my-icon icon-close"></i></button>
        </div>
        <nav class="mobile-main-manu">
            <ul>${copyMenuList}</ul>
        </nav>
      </div>`);

    $(".menu-bar .mobile-btns").on("click", function () {
      $(this).addClass("active");
      $(this)
        .parents(".menu-right")
        .find(".mobile-menu-bar, .mobile-menu-overlay")
        .addClass("active");
    });

    $(".menu-bar .search-option-open").on("click", function () {
      $(this).parents(".menu-right").addClass("active");
    });

    $(".menu-bar .search-close").on("click", function () {
      $(this).parents(".menu-right").removeClass("active");
    });

    $(".menu-bar .mobile-menu-bar")
      .parent()
      .append(`<div class="mobile-menu-overlay"></div>`);

    $(".menu-bar .close-mobile-btn, .menu-bar .mobile-menu-overlay").on(
      "click",
      function () {
        $(this)
          .parents(".menu-right")
          .find(".mobile-menu-bar, .mobile-menu-btn, .mobile-menu-overlay")
          .removeClass("active");
      }
    );

    $(".menu-bar .mobile-main-manu li:has(ul) > a").on("click", function (e) {
      e.preventDefault();
      const $parent = $(this).parent("li");
      const $siblings = $parent.siblings("li");
      const isActive = $parent.hasClass("active");
      if (isActive) {
        $parent.removeClass("active");
        $parent.find("ul").slideUp();
      } else {
        $parent.addClass("active");
        $siblings.removeClass("active");
        $siblings.find("ul:visible").slideUp();
        $parent.find("ul").slideDown();
      }
    });

    $(".menu-bar .mobile-main-manu .has-dropdown")
      .find(".active")
      .parent()
      .slideDown();

    let topHeight = $(".top-bar").outerHeight();
    $(window).scroll(() => {
      let menuHeight = $(".menu-bar").outerHeight();
      let menuBar = $(".menu-bar");
      if (
        menuBar.hasClass("v3") ||
        menuBar.hasClass("v5") ||
        menuBar.hasClass("v6")
      ) {
        handleStickyHeader(topHeight);
      } else if (
        menuBar.hasClass("v1") ||
        menuBar.hasClass("v2") ||
        menuBar.hasClass("v4")
      ) {
        stikyHeader2();
      } else {
        stikyHeader1();
      }
      function handleStickyHeader(topHeight) {
        if ($(window).scrollTop() > topHeight) {
          menuBar.addClass("sticky-header");
        } else {
          menuBar.removeClass("sticky-header");
        }
      }
      function stikyHeader1() {
        if ($(window).scrollTop() > 0) {
          menuBar.addClass("sticky-header");
          $("main").css({ "margin-top": menuHeight });
        } else {
          menuBar.removeClass("sticky-header");
          $("main").css({ "margin-top": 0 });
        }
      }
      function stikyHeader2() {
        if ($(window).scrollTop() > 0) {
          menuBar.addClass("sticky-header");
        } else {
          menuBar.removeClass("sticky-header");
        }
      }
    });
  }

  /*=====================
      2 BG Img
  =======================*/
  function bgImg() {
    document.addEventListener("DOMContentLoaded", () => {
      const imgElements = document.querySelectorAll("img");
      imgElements.forEach(function (imgElement) {
        const srcValue = imgElement.getAttribute("src");
        imgElement.removeAttribute("src");
        imgElement.setAttribute("data-src", srcValue);
      });
      const lazyLoadElements = document.querySelectorAll(
        "[data-background], img[data-src]"
      );
      const lazyLoadCallback = (entries, observer) => {
        entries.forEach((entry) => {
          const element = entry.target;
          if (entry.isIntersecting) {
            if (element.hasAttribute("data-background")) {
              element.style.backgroundImage = `url(${element.getAttribute(
                "data-background"
              )})`;
              element.removeAttribute("data-background");
            } else if (element.hasAttribute("data-src")) {
              element.src = element.getAttribute("data-src");
              element.removeAttribute("data-src");
            }
            observer.unobserve(element);
          }
        });
      };
      const observer = new IntersectionObserver(lazyLoadCallback, {
        root: null,
        rootMargin: "0px",
        threshold: 0.1,
      });
      lazyLoadElements.forEach((element) => {
        observer.observe(element);
      });
    });
  }

  /*========================
      3 VenoBox
  =======================*/
  function venoBox() {
    new VenoBox();
  }

  /*========================
      4 Anime Counter Up
  =======================*/
  function animeCounterUp() {
    const $counterElements = $(".counter");

    function animateElement(element) {
      if (!element.dataset.animated) {
        const originalText = element.textContent; // Capture the original text before animation
        anime({
          targets: element,
          innerHTML: [
            parseInt(element.dataset.countMin) || 0,
            parseInt(element.dataset.countMax),
          ],
          round: 1,
          easing: "linear",
          duration: parseInt(element.dataset.countDuration) || 1000,
          delay: parseInt(element.dataset.countDelay) || 500,
          complete: function (anim) {
            // Animation is complete, restore the original text
            element.textContent = originalText;
          },
        });

        element.dataset.animated = true; // Set the animated flag to prevent re-animating
      }
    }

    const isElementInViewport = (el) => {
      const rect = el.getBoundingClientRect();
      return (
        rect.top >= 0 &&
        rect.left >= 0 &&
        rect.bottom <=
          (window.innerHeight || document.documentElement.clientHeight) &&
        rect.right <=
          (window.innerWidth || document.documentElement.clientWidth)
      );
    };

    const handleScroll = () => {
      $counterElements.each(function () {
        if (isElementInViewport(this)) {
          animateElement(this); // Animate the current counter element if not already animated
        }
      });
    };

    $counterElements.each(function () {
      if (isElementInViewport(this)) {
        animateElement(this); // Animate initially visible counter elements
      }
    });

    $(window).on("scroll", handleScroll);
  }

  /*========================
        5 My Progress Bar
    =======================*/

  function myProgressBar() {
    document.addEventListener("DOMContentLoaded", function () {
      const percentDivs = document.querySelectorAll(".percent");
      const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
          if (entry.isIntersecting) {
            animateCircle(entry.target);
            observer.unobserve(entry.target);
          }
        });
      });
      percentDivs.forEach((percentDiv) => {
        observer.observe(percentDiv);
      });

      function animateCircle(percentDiv) {
        const percent = parseInt(percentDiv.getAttribute("data-percent"), 10);
        const duration =
          parseInt(percentDiv.getAttribute("data-duration")) || 1500;
        const delay = parseInt(percentDiv.getAttribute("data-delay")) || 0;

        const svg = document.createElementNS(
          "http://www.w3.org/2000/svg",
          "svg"
        );
        const bgCircle = document.createElementNS(
          "http://www.w3.org/2000/svg",
          "circle"
        );
        const circle = document.createElementNS(
          "http://www.w3.org/2000/svg",
          "circle"
        );

        svg.setAttribute("viewBox", "0 0 215 215");
        svg.setAttribute("width", "100%");

        bgCircle.setAttribute("cx", "108");
        bgCircle.setAttribute("cy", "108");
        bgCircle.setAttribute("r", "100");

        circle.setAttribute("cx", "108");
        circle.setAttribute("cy", "108");
        circle.setAttribute("r", "100");

        svg.appendChild(bgCircle);
        svg.appendChild(circle);
        percentDiv.appendChild(svg);

        anime({
          targets: circle,
          strokeDashoffset: [
            anime.setDashoffset,
            2 * Math.PI * 100 - (2 * Math.PI * 100 * percent) / 100,
          ],
          easing: "easeInOutSine",
          duration: duration,
          delay: delay,
        });

        const numberDiv = document.createElement("div");
        numberDiv.classList.add("number");
        percentDiv.appendChild(numberDiv);

        // Counting animation for numberDiv
        anime({
          targets: numberDiv,
          innerHTML: [0, percent],
          round: 1, // Round the numbers to whole integers
          easing: "easeInOutQuad",
          duration: duration,
          delay: delay, // Adjust the delay to start the numberDiv animation after the circle animation
        });
      }
    });

    const $progressElements = $(".my-progress-bar .progress-vale");

    function animateElement() {
      $progressElements.each(function () {
        anime({
          targets: this,
          width: [
            `${parseInt(this.dataset.progressMinWidth)}%`,
            `${parseInt(this.dataset.progressMaxWidth)}%`,
          ],
          round: 1,
          easing: "linear",
          duration: parseInt(this.dataset.progressDuration) || 1000,
          delay: parseInt(this.dataset.progressDelay) || 500,
        });
      });
    }

    const isElementInViewport = (el) => {
      const rect = el.getBoundingClientRect();
      return (
        rect.top >= 0 &&
        rect.left >= 0 &&
        rect.bottom <=
          (window.innerHeight || document.documentElement.clientHeight) &&
        rect.right <=
          (window.innerWidth || document.documentElement.clientWidth)
      );
    };

    const handleScroll = () => {
      $progressElements.each(function () {
        if (isElementInViewport(this)) {
          animateElement();
          $(window).off("scroll", handleScroll);
        }
      });
    };

    $(window).on("scroll", handleScroll);
  }

  /*========================
        6 Key Benefits
    =======================*/

  function keyBenefits() {
    let keyBenefitsSlider = new Swiper(".key-benefits.v1 .slider", {
      slidesPerView: 5,
      spaceBetween: 0,
      loop: true,
      speed: 1000,
      autoplay: {
        delay: 1000,
        disableOnInteraction: false,
        pauseOnMouseEnter: true,
      },
      breakpoints: {
        300: {
          slidesPerView: 1,
        },
        575: {
          slidesPerView: 2,
        },
        767: {
          slidesPerView: 3,
        },
        992: {
          slidesPerView: 5,
        },
      },
    });
  }

  /*========================
      7 Featured Section
  =======================*/

  function featuredSection() {
    let featuredSection = new Swiper(".featured-section.v1 .slider", {
      slidesPerView: 3,
      spaceBetween: 92,
      loop: true,
      speed: 1000,
      autoplay: {
        delay: 1000,
        disableOnInteraction: false,
        pauseOnMouseEnter: true,
      },
      navigation: {
        nextEl: ".featured-section.v1 .prev-btn",
        prevEl: ".featured-section.v1 .next-btn",
      },
      breakpoints: {
        300: {
          slidesPerView: 1,
        },
        767: {
          slidesPerView: 2,
          spaceBetween: 30,
        },
        1200: {
          slidesPerView: 3,
          spaceBetween: 92,
        },
      },
    });
  }

  /*========================
      8 Section Section
  =======================*/
  function selecedSection() {
    let selecedSection = new Swiper(".seleced-section.v1 .slider", {
      slidesPerView: 3,
      spaceBetween: 30,
      loop: true,
      speed: 1000,
      autoplay: {
        delay: 1000,
        disableOnInteraction: false,
        pauseOnMouseEnter: true,
      },
      navigation: {
        nextEl: ".seleced-section.v1 .prev-btn",
        prevEl: ".seleced-section.v1 .next-btn",
      },
      breakpoints: {
        300: {
          slidesPerView: 1,
        },
        767: {
          slidesPerView: 2,
          spaceBetween: 30,
        },
        1200: {
          slidesPerView: "auto",
        },
      },
    });
  }

  /*========================
      9 Accordion P Class
  =======================*/
  function AccordionPClass() {
    $(".features-accordion button").on("click", function () {
      $("li").removeClass("active");
      $(this).parents("li").toggleClass("active");
    });
  }

  /*============================
      10 Testimonial Slider
  ===========================*/

  function testimonialSlider() {
    let testimonialSlider = new Swiper(".client-testimonial.v2 .slider", {
      spaceBetween: 30,
      loop: true,
      speed: 1000,
      centeredSlides: true,
      autoplay: {
        delay: 1000,
        disableOnInteraction: false,
        pauseOnMouseEnter: true,
      },
      navigation: {
        nextEl: ".client-testimonial.v2 .prev-btn",
        prevEl: ".client-testimonial.v2 .next-btn",
      },
      breakpoints: {
        300: {
          slidesPerView: 1,
          spaceBetween: 30,
        },
        1400: {
          spaceBetween: -400,
        },
      },
    });
  }

  /*============================
    11 Banner Slider
  ===========================*/
  function bannerSlider() {
    let bannerSlider = new Swiper(".banner.v6 .slider", {
      spaceBetween: 30,
      loop: true,
      speed: 2000,
      centeredSlides: true,
      autoplay: {
        delay: 2500,
        disableOnInteraction: false,
      },
      pagination: {
        el: ".banner.v6 .banner-pagination",
        clickable: true,
      },
      breakpoints: {
        300: {
          slidesPerView: 1,
        },
      },
    });
  }
  /*============================
    12 Partners Logo Slider
  ===========================*/
  function partnersLogoSlider() {
    let partnersLogoSlider = new Swiper(".partners-logo.v1 .slider", {
      spaceBetween: -83,
      loop: true,
      speed: 1000,
      autoplay: {
        delay: 1000,
        disableOnInteraction: false,
      },
      breakpoints: {
        300: {
          slidesPerView: 1,
        },
        575: {
          slidesPerView: 2,
        },
        767: {
          slidesPerView: 2,
        },
        1200: {
          slidesPerView: 4,
        },
      },
    });

    let partnersLogoSlider2 = new Swiper(".partners-logo.v2 .slider", {
      spaceBetween: -155,
      loop: true,
      speed: 1000,
      autoplay: {
        delay: 1000,
        disableOnInteraction: false,
      },
      breakpoints: {
        300: {
          slidesPerView: 1,
        },
        575: {
          slidesPerView: 2,
        },
        767: {
          slidesPerView: 2,
        },
        1200: {
          slidesPerView: 4,
        },
      },
    });

    let partnersLogoSlider3 = new Swiper(".partners-logo.v3 .slider", {
      spaceBetween: 30,
      loop: true,
      speed: 1000,
      autoplay: {
        delay: 1000,
        disableOnInteraction: false,
      },
      breakpoints: {
        300: {
          slidesPerView: 2,
          spaceBetween: 30,
        },
        575: {
          slidesPerView: 3,
        },
        767: {
          slidesPerView: 4,
        },
        992: {
          slidesPerView: 5,
        },
        1200: {
          slidesPerView: 7,
        },
      },
    });

    let partnersLogoSlider4 = new Swiper(".partners-logo.v4 .slider", {
      spaceBetween: 30,
      loop: true,
      speed: 1000,
      autoplay: {
        delay: 1000,
        disableOnInteraction: false,
      },
      breakpoints: {
        300: {
          slidesPerView: 1,
        },
        380: {
          slidesPerView: 2,
        },
        992: {
          slidesPerView: 4,
        },
        1200: {
          slidesPerView: 6,
        },
      },
    });
  }

  /*============================
      13 Comment Slider
  ===========================*/
  function commentSlider() {
    let commentSlider = new Swiper(".your-voice-area .slider", {
      spaceBetween: 30,
      loop: true,
      speed: 1000,
      centeredSlides: true,
      autoplay: {
        delay: 1000,
        disableOnInteraction: false,
        pauseOnMouseEnter: true,
      },
      navigation: {
        nextEl: ".your-voice-area .prev-btn",
        prevEl: ".your-voice-area .next-btn",
      },
      breakpoints: {
        300: {
          slidesPerView: 1,
        },
      },
    });
  }

  /*=====================
        14 My Select
    =======================*/
  function mySelect() {
    const $mySelectElements = $("select");

    $mySelectElements.each((index, selectElement) => {
      const $mySelectContainer = $("<div>").addClass("my-select");

      const $selectedOption = $("<button>")
        .addClass("current")
        .attr("type", "button")
        .html(selectElement.options[selectElement.selectedIndex].innerHTML);

      const $optionsList = $("<ul>").addClass("list");

      for (const option of selectElement.options) {
        const $myOption = $("<li>").html(option.innerHTML);
        $myOption.on("click", () => {
          $selectedOption.html(option.innerHTML);
          $optionsList.removeClass("open");
          $selectedOption.removeClass("open");
        });
        $optionsList.append($myOption);
      }

      $selectedOption.on("click", () => {
        $optionsList.toggleClass("open");
        $selectedOption.toggleClass("open");
      });

      $mySelectContainer.append($selectedOption);
      $mySelectContainer.append($optionsList);
      $(selectElement).before($mySelectContainer).hide();

      // Hide options when user clicks outside of select
      $(document).on("click", (event) => {
        if (
          !$mySelectContainer.is(event.target) &&
          $mySelectContainer.has(event.target).length === 0
        ) {
          $optionsList.removeClass("open");
          $selectedOption.removeClass("open");
        }
      });
    });
  }

  /*============================
      15 Back To Top
  =============================*/

  function backToTop() {
    let scrollTop = $(".back-to-top");

    let sectionScrollHight = $("main")
      .find(".banner,.breadcum")
      .first()
      .outerHeight();

    $(window).scroll(function () {
      if ($(window).scrollTop() > sectionScrollHight / 2) {
        scrollTop.addClass("show");
      } else {
        scrollTop.removeClass("show");
      }
    });

    scrollTop.on("click", function (e) {
      e.preventDefault();
      $("html, body").animate({ scrollTop: 0 }, "300");
    });
  }

  /*============================
      16 Wow
  =============================*/

  function wow() {
    wow = new WOW({
      animateClass: "animate__animated",
      offset: 0,
    });
    wow.init();
  }


})(jQuery);
