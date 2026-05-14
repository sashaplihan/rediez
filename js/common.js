// Menu burger
const navBtn = document.querySelector('.header__btn');
const burger = document.querySelector('.header__burger');
const nav = document.querySelector('.header__nav');
const body = document.body;

if (burger && nav) {
    const closeMenu = () => {
        navBtn.classList.remove('active');
        burger.classList.remove('active');
        nav.classList.remove('active');
        body.classList.remove('lock');
    };

    burger.addEventListener('click', (event) => {
        navBtn.classList.toggle('active');
        burger.classList.toggle('active');
        nav.classList.toggle('active');
        body.classList.toggle('lock');
    });

    nav.addEventListener('click', closeMenu);
}

if ( document.querySelector('.musicians__slider') ) {
    const swiperMusician = new Swiper('.musicians__slider', {
        loop: true,
        slidesPerView: 4,
        spaceBetween: 20,
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
        pagination: {
            el: '.musicians__pagination',
            clickable: true,
        },
        breakpoints: {
            0: {
                slidesPerView: 2,
                spaceBetween: 15
            },
            768: {
                slidesPerView: 3,
                spaceBetween: 20
            },
            1200: {
                slidesPerView: 4,
                spaceBetween: 20
            }
        }
    });
}

if ( document.querySelector('.poster__slider') ) {
    const swiperPoster = new Swiper('.poster__slider', {
        loop: true,
        slidesPerView: 4,
        spaceBetween: 20,
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
        pagination: {
            el: '.poster__pagination',
            clickable: true,
        },
        breakpoints: {
            0: {
                slidesPerView: 2,
                spaceBetween: 15
            },
            768: {
                slidesPerView: 3,
                spaceBetween: 20
            },
            1200: {
                slidesPerView: 4,
                spaceBetween: 20
            }
        }
    });
}

if ( document.querySelector('.slider-musician') ) {
    const swiperMusicianSimple = new Swiper('.slider-musician', {
        slidesPerView: 1,
        spaceBetween: 0,
        pagination: {
            el: '.musician__pagination',
            clickable: true,
        },
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        loop: true,
        effect: 'slide',
        speed: 500,
        observer: true,
        observeParents: true,
    });
}

const videoSliderEl = document.querySelector('.slider-video');

if ( videoSliderEl ) {
    const swiperVideo = new Swiper('.slider-video', {
        slidesPerView: 1,
        spaceBetween: 0,
        pagination: {
            el: '.video__pagination',
            clickable: true,
        },
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        loop: true,
        effect: 'slide',
        speed: 500,
        observer: true,
        observeParents: true,
    });

    // По клику активируем iframe — можно нажать play
    videoSliderEl.addEventListener('click', function(e) {
        if ( e.target.tagName === 'IFRAME' ) {
            e.target.classList.add('is-active');
        }
    });

    // При смене слайда сбрасываем is-active со всех iframe
    swiperVideo.on('slideChange', function() {
        document.querySelectorAll('.slider-video iframe').forEach(el => {
            el.classList.remove('is-active');
        });
    });
}

// Drag-to-Scroll tags
const slider = document.querySelector('.tags');
let isDown = false;
let startX;
let scrollLeft;

if (slider) {
    slider.addEventListener('mousedown', (e) => {
        isDown = true;
        slider.classList.add('active');
        startX = e.pageX - slider.offsetLeft;
        scrollLeft = slider.scrollLeft;
    });

    slider.addEventListener('mouseleave', () => {
        isDown = false;
    });

    slider.addEventListener('mouseup', () => {
        isDown = false;
    });

    slider.addEventListener('mousemove', (e) => {
        if (!isDown) return;
        e.preventDefault();
        const x = e.pageX - slider.offsetLeft;
        const walk = (x - startX) * 2;
        slider.scrollLeft = scrollLeft - walk;
    });
}

// Add class for filter
document.addEventListener('DOMContentLoaded', function() {
    const filterOpenBtns = document.querySelectorAll('.filter__btn');
    const filterCloseBtns = document.querySelectorAll('.filters__btn.return');
    const filtersAside = document.querySelector('.musician-catalog__filters, .events-catalog__filters');

    if (!filtersAside) return;

    // Открытие
    filterOpenBtns.forEach(function(btn) {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            filtersAside.classList.add('_active');
            document.body.style.overflow = 'hidden';
        });
    });

    // Закрытие
    filterCloseBtns.forEach(function(btn) {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            filtersAside.classList.remove('_active');
            document.body.style.overflow = '';
        });
    });
});

jQuery(document).ready(function ($) {
    // Musician single page tab
    document.querySelectorAll('.musician-tab__wrap').forEach(tabWrap => {
        const tabs = tabWrap.querySelectorAll('.content__tab');
        const buttons = tabWrap.querySelectorAll('.tabs__btn');

        // Hide all tabs except first
        tabs.forEach((tab, index) => {
            if (index !== 0) {
                tab.style.display = 'none';
            }
        });

        // Add click event to each button
        buttons.forEach((button, index) => {
            button.addEventListener('click', function() {
                // Remove active class from all buttons
                buttons.forEach(btn => btn.classList.remove('active'));

                // Add active class to clicked button
                this.classList.add('active');

                // Hide all tabs
                tabs.forEach(tab => {
                    tab.style.display = 'none';
                });

                // Show corresponding tab with fade effect
                const targetTab = tabs[index];
                targetTab.style.display = 'block';
                targetTab.style.opacity = '0';

                // Fade in animation
                let opacity = 0;
                const fadeIn = () => {
                    opacity += 0.1;
                    targetTab.style.opacity = opacity.toString();

                    if (opacity < 1) {
                        requestAnimationFrame(fadeIn);
                    }
                };

                fadeIn();
            });

            // Set first button as active initially
            if (index === 0) {
                button.classList.add('active');
            }
        });
    });

    // Добавить ссылку в форме регистрации для политики
    function replacePrivacyLabel() {
        const $span = $('input[name="privacy_agreement[]"]').closest('label').find('.um-field-checkbox-option');
        if ( $span.length && ! $span.data('privacy-replaced') ) {
            $span.data('privacy-replaced', true);
            $span.html(
                'Я согласен с <a href="/privacy-policy/" target="_blank" style="text-decoration: underline; color: #f3f901;">политикой конфиденциальности</a>'
            );
        }
    }


    // Форма в модалке грузится через AJAX — следим за появлением в DOM
    $(document).on('um_request_nonce_completed um:init um_after_form_is_loaded', function() {
        replacePrivacyLabel();
    });
    // На случай если форма уже есть в DOM при загрузке страницы
    replacePrivacyLabel();

    // Перехватываем ввод почты в формах Ultimate Member
    $(document).on('input change blur', '.um-form input[name^="user_email"]', function() {
        const email = $(this).val().toLowerCase().trim();

        if ( email && email.indexOf('@') !== -1 ) {
            const parts  = email.split('@');
            const domain = parts[parts.length - 1]; // берём последнюю часть — всегда домен

            if ( domain && domain.indexOf('.') !== -1 ) {
                try {
                    sessionStorage.setItem('rediez_mail_domain', domain);
                } catch(e) {
                    // sessionStorage недоступен — игнорируем
                }
            }
        }
    });

    // Страница успеха после регистрации — кнопка перехода в почту
    function initMailRedirect() {
        const btnContainer = document.getElementById('um-mail-redirect-container');
        if ( !btnContainer ) return; // Не страница успеха — выходим

        let domain = '';
        try {
            domain = sessionStorage.getItem('rediez_mail_domain') || '';
        } catch(e) {
            return;
        }

        if ( !domain ) return;

        const mailServices = {
            'gmail.com':   { name: 'Gmail',        url: 'https://mail.google.com/' },
            'yandex.ru':   { name: 'Яндекс.Почту', url: 'https://mail.yandex.ru/' },
            'yandex.by':   { name: 'Яндекс.Почту', url: 'https://mail.yandex.by/' },
            'ya.ru':       { name: 'Яндекс.Почту', url: 'https://mail.yandex.ru/' },
            'tut.by':      { name: 'Яндекс.Почту', url: 'https://mail.yandex.ru/' },
            'mail.ru':     { name: 'Mail.ru',       url: 'https://e.mail.ru/inbox/' },
            'bk.ru':       { name: 'Mail.ru',       url: 'https://e.mail.ru/inbox/' },
            'list.ru':     { name: 'Mail.ru',       url: 'https://e.mail.ru/inbox/' },
            'inbox.ru':    { name: 'Mail.ru',       url: 'https://e.mail.ru/inbox/' },
            'outlook.com': { name: 'Outlook',       url: 'https://outlook.live.com/' },
            'hotmail.com': { name: 'Outlook',       url: 'https://outlook.live.com/' },
            'yahoo.com':   { name: 'Yahoo Mail',    url: 'https://mail.yahoo.com/' },
            'rambler.ru':  { name: 'Рамблер.Почту', url: 'https://mail.rambler.ru/' }
        };

        const btn = document.getElementById('um-mail-redirect-btn');
        if ( !btn ) return;

        let btnText = '';
        let btnUrl  = '';

        if ( mailServices[domain] ) {
            btnText = 'Перейти в ' + mailServices[domain].name;
            btnUrl  = mailServices[domain].url;
        } else {
            btnText = 'Открыть почту (' + domain + ')';
            btnUrl  = 'https://' + domain;
        }

        // Защита от javascript: схемы
        if ( btnUrl.indexOf('http') !== 0 ) {
            btnUrl = 'https://' + domain;
        }

        btn.textContent            = btnText;
        btn.href                   = btnUrl;
        btnContainer.style.display = 'block';

        // Очищаем sessionStorage — кнопка не появится при обновлении страницы
        try {
            sessionStorage.removeItem('rediez_mail_domain');
        } catch(e) {
            // игнорируем
        }
    }

    initMailRedirect();
});