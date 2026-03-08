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
    effect: 'fade',
    speed: 500,
	observer: true,
    observeParents: true,
});

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
    effect: 'fade',
    speed: 500,
	observer: true,
    observeParents: true,
});


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
	
    
    // ============================================
    // КРИТИЧЕСКИ ВАЖНО: Отключаем стандартный обработчик UM
    // ============================================
    $(document).off('submit', '.um form'); // Убираем UM handler
    $(document).off('click', '.um input[type="submit"]'); // Убираем UM handler
    
    // ============================================
    // 1. Инициализация MicroModal
    // ============================================
    MicroModal.init({
        openTrigger: 'data-micromodal-trigger',
        closeTrigger: 'data-micromodal-close',
        disableScroll: true,
        awaitOpenAnimation: true,
        awaitCloseAnimation: true,
        onShow: modal => {
            console.log('🔓 Modal opened');
            
            if (typeof um_init_fields === 'function') {
                um_init_fields();
            }
            
            resetModalState();
            
            // Критически важно: навешиваем обработчики ПОСЛЕ инициализации UM
            setTimeout(function() {
                blockUMHandlers();
                attachOurHandlers();
            }, 500);
        }
    });

    // ============================================
    // 2. Функция сброса состояния
    // ============================================
    function resetModalState() {
        $('.tab-trigger').removeClass('active').first().addClass('active');
        $('.tab-content').hide().first().show();
        
        $('.tab-content').each(function() {
            $(this).find('.login-box').show();
            $(this).find('.reg-box').hide();
        });
        
        $('.um-field-error').remove();
        $('.um-field').removeClass('um-error');
        $('.um-form-field').removeClass('um-error').attr('aria-invalid', 'false');
    }

    // ============================================
    // 3. Переключение табов
    // ============================================
    $('.tab-trigger').on('click', function (e) {
        e.preventDefault();
        
        const targetRole = $(this).data('tab');
        
        $('.tab-trigger').removeClass('active');
        $(this).addClass('active');
        
        $('.tab-content').hide();
        $(`#${targetRole}-content`).show();
        
        $(`#${targetRole}-content .login-box`).show();
        $(`#${targetRole}-content .reg-box`).hide();
    });

    // ============================================
    // 4. Переключение Логин ↔ Регистрация
    // ============================================
    $(document).on('click', '.show-reg', function (e) {
        e.preventDefault();
        const $tab = $(this).closest('.tab-content');
        $tab.find('.login-box').hide();
        $tab.find('.reg-box').show();
        
        setTimeout(function() {
            blockUMHandlers();
            attachOurHandlers();
        }, 100);
    });

    $(document).on('click', '.show-login', function (e) {
        e.preventDefault();
        const $tab = $(this).closest('.tab-content');
        $tab.find('.reg-box').hide();
        $tab.find('.login-box').show();
        
        setTimeout(function() {
            blockUMHandlers();
            attachOurHandlers();
        }, 100);
    });

    // ============================================
    // 5. БЛОКИРУЕМ обработчики UM
    // ============================================
    function blockUMHandlers() {
        
        console.log('🚫 Blocking UM handlers...');
        
        // Убираем ВСЕ обработчики с форм внутри модалки
        $('#modal-auth .um form').each(function() {
            
            const $form = $(this);
            
            // Клонируем форму (это удаляет ВСЕ обработчики событий)
            const $clone = $form.clone(false); // false = БЕЗ обработчиков
            
            // Заменяем оригинал клоном
            $form.replaceWith($clone);
        });
        
        console.log('✅ UM handlers removed');
    }

    // ============================================
    // 6. Навешиваем НАШИ обработчики
    // ============================================
    function attachOurHandlers() {
        
        console.log('🔧 Attaching our handlers...');
        
        // Навешиваем на кнопки submit
        $('#modal-auth input[type="submit"]').on('click', function(e) {
            
            console.log('🖱️ SUBMIT CLICKED!');
            
            e.preventDefault();
            e.stopImmediatePropagation();
            e.stopPropagation();
            
            const $form = $(this).closest('form');
            handleFormSubmit($form);
            
            return false;
        });
        
        // Навешиваем на саму форму (на случай Enter)
        $('#modal-auth form').on('submit', function(e) {
            
            console.log('🚨 FORM SUBMIT!');
            
            e.preventDefault();
            e.stopImmediatePropagation();
            e.stopPropagation();
            
            handleFormSubmit($(this));
            
            return false;
        });
        
        console.log('✅ Our handlers attached');
    }
    
    // ============================================
    // 7. Обработка формы
    // ============================================
function handleFormSubmit($form) {
    const $submitBtn = $form.find('input[type="submit"]');
    const originalValue = $submitBtn.val();
    const formData = new FormData($form[0]);
    const isRegisterForm = $form.closest('.um-register').length > 0;
    const isLoginForm = $form.closest('.um-login').length > 0;
    
    console.log('📋 Form type - Register:', isRegisterForm, 'Login:', isLoginForm);
    
    // Блокируем кнопку
    $submitBtn.prop('disabled', true).val('Отправка...');
    
    // Убираем старые ошибки
    $form.find('.um-field-error').remove();
    $form.find('.um-field').removeClass('um-error');
    $form.find('.um-form-field').removeClass('um-error').attr('aria-invalid', 'false');
    
    // AJAX запрос
    $.ajax({
        url: window.location.href,
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (html) {
            
            console.log('✅ Response received');
            
            $submitBtn.prop('disabled', false).val(originalValue);
            
            const $response = $('<div>').html(html);
            const $errorFields = $response.find('.um-field.um-error, .um-field .um-field-error');
            
            console.log('🔍 Errors found:', $errorFields.length);
            
            if ($errorFields.length > 0) {
                
                console.log('⚠️ Showing validation errors');
                
                // Показываем ошибки
                $response.find('.um-field').each(function() {
                    const dataKey = $(this).attr('data-key');
                    const $errorMsg = $(this).find('.um-field-error');
                    
                    if (dataKey && $errorMsg.length) {
                        const $ourField = $form.find(`[data-key="${dataKey}"]`);
                        const $ourInput = $ourField.find('.um-form-field');
                        
                        if ($ourField.length) {
                            $ourField.addClass('um-error');
                            $ourInput.addClass('um-error').attr('aria-invalid', 'true');
                            $ourField.find('.um-field-area').append($errorMsg.clone());
                        }
                    }
                });
                
            } else {
                
                console.log('🎉 No errors - success!');
                
                // Закрываем модалку
                MicroModal.close('modal-auth');
                
                // Редирект в зависимости от типа формы
                setTimeout(function() {
                    
                    if (isRegisterForm) {
                        
                        console.log('📍 Registration success - redirecting to profile');
                        
                        // Используем URL из PHP (добавленный в functions.php)
                        if (typeof umProfileUrl !== 'undefined' && umProfileUrl) {
                            console.log('Redirect URL:', umProfileUrl);
                            window.location.href = umProfileUrl;
                        } 
                        // Запасной вариант - /account/
                        else if (typeof umAccountUrl !== 'undefined' && umAccountUrl) {
                            console.log('Redirect URL (account):', umAccountUrl);
                            window.location.href = umAccountUrl;
                        }
                        // Последний запасной вариант
                        else {
                            console.log('No UM URL found, trying /account/');
                            window.location.href = '/account/';
                        }
                        
                    } else if (isLoginForm) {
                        
                        console.log('📍 Login success - redirecting to profile');
                        
                        if (typeof umProfileUrl !== 'undefined' && umProfileUrl) {
                            window.location.href = umProfileUrl;
                        } else if (typeof umAccountUrl !== 'undefined' && umAccountUrl) {
                            window.location.href = umAccountUrl;
                        } else {
                            location.reload();
                        }
                        
                    } else {
                        
                        console.log('📍 Unknown form type - reloading');
                        location.reload();
                    }
                    
                }, 300);
            }
        },
        error: function (xhr, status, error) {
            console.error('❌ AJAX Error:', error);
            $submitBtn.prop('disabled', false).val(originalValue);
            alert('Произошла ошибка. Попробуйте ещё раз.');
        }
    });
}
    
    // ============================================
    // 8. Запуск при загрузке
    // ============================================
    setTimeout(function() {
        blockUMHandlers();
        attachOurHandlers();
    }, 1000);
    
    // После AJAX UM
    $(document).on('um_ajax_complete', function() {
        console.log('🔄 UM AJAX Complete - re-attaching');
        setTimeout(function() {
            blockUMHandlers();
            attachOurHandlers();
        }, 100);
    });
});