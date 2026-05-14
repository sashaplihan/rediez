jQuery(document).ready(function ($) {
    // КРИТИЧЕСКИ ВАЖНО: Отключаем стандартный обработчик UM
    $(document).off('submit', '.um form'); // Убираем UM handler
    $(document).off('click', '.um input[type="submit"]'); // Убираем UM handler
    
    // Инициализация MicroModal
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

    // 2. Функция сброса состояния
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

    // 3. Переключение табов
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

    // 4. Переключение Логин ↔ Регистрация
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

    // 5. БЛОКИРУЕМ обработчики UM
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

    // 6. Навешиваем НАШИ обработчики
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
    
    // 7а. FALLBACK-редирект после логина (для не-музыкантов / ошибка сети)
    // Сохраняет старую логику UM: мета-редирект → umProfileUrl → reload.
    function rediezFallbackLoginRedirect($response) {
        var $metaRefresh = $response.find('meta[http-equiv="refresh"]');
        if ($metaRefresh.length) {
            var content = $metaRefresh.attr('content');
            var urlMatch = content.match(/url=(.+)/i);
            if (urlMatch) {
                window.location.href = urlMatch[1];
                return;
            }
        }
        if (typeof umProfileUrl !== 'undefined' && umProfileUrl) {
            window.location.href = umProfileUrl;
        } else {
            location.reload();
        }
    }

    // 7. Обработка формы
	function handleFormSubmit($form) {
		const $submitBtn = $form.find('input[type="submit"]');
		const originalValue = $submitBtn.val();
		const formData = new FormData($form[0]);
		const isRegisterForm = $form.closest('.um-register').length > 0;
		const isLoginForm = $form.closest('.um-login').length > 0;
		console.log('📋 Form type - Register:', isRegisterForm, 'Login:', isLoginForm);
		$submitBtn.prop('disabled', true).val('Отправка...');
		$form.find('.um-field-error').remove();
		$form.find('.um-field').removeClass('um-error');
		$form.find('.um-form-field').removeClass('um-error').attr('aria-invalid', 'false');
		// Берём action формы — UM сам знает куда отправлять
		const formAction = $form.attr('action') || window.location.href;
		$.ajax({
			url: formAction,
			type: 'POST',
			data: formData,
			processData: false,
			contentType: false,
			xhrFields: {
				// Это даст нам финальный URL после редиректов
			},
			success: function(html, status, xhr) {
				console.log('✅ Response received');
				console.log('📍 Final URL:', xhr.responseURL);
				$submitBtn.prop('disabled', false).val(originalValue);
				const $response = $('<div>').html(html);
				const $errorFields = $response.find('.um-field.um-error, .um-field .um-field-error');
				console.log('🔍 Errors found:', $errorFields.length);
				if ($errorFields.length > 0) {
					console.log('⚠️ Showing validation errors');
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
					console.log('🎉 No errors - checking redirect URL');

					MicroModal.close('modal-auth');

					setTimeout(function() {
						if (isRegisterForm) {
							console.log('📍 Registration success - redirecting');

							// Определяем form_id из скрытого поля формы
							const formId = $form.find('input[name="form_id"]').val();
							console.log('Form ID:', formId);

							let redirectUrl = '';

							if (formId == '16') {
								redirectUrl = (typeof umRedirectUrls !== 'undefined') ? umRedirectUrls.musician_register : '';
							} else if (formId == '18') {
								redirectUrl = (typeof umRedirectUrls !== 'undefined') ? umRedirectUrls.eventer_register : '';
							}

							console.log('Redirect URL:', redirectUrl);

							if (redirectUrl) {
								window.location.href = redirectUrl;
							} else {
								location.reload();
							}
							return;
						}

						if (isLoginForm) {
							console.log('📍 Login success - getting dynamic redirect...');

							// Один запрос — PHP определяет роль и наличие профиля по сессии.
							// Для не-музыкантов сервер вернёт success:false → fallback.
							$.post(umRedirectUrls.ajax_url, {
								action: 'rediez_get_musician_redirect'
							})
							.done(function(response) {
								if (response.success && response.data.redirect_url) {
									// Музыкант: есть профиль → edit, нет → post-new
									console.log('📍 Musician redirect:', response.data.redirect_url);
									window.location.href = response.data.redirect_url;
								} else {
									// Другая роль — fallback на мета-редирект UM или reload
									console.log('📍 Non-musician: fallback redirect');
									rediezFallbackLoginRedirect($response);
								}
							})
							.fail(function() {
								// Сеть/сервер упали — безопасный fallback
								console.warn('⚠️ Redirect AJAX failed - fallback');
								rediezFallbackLoginRedirect($response);
							});

							return;
						}

						// Неизвестный тип формы
						console.log('📍 Unknown form type - reloading');
						location.reload();

					}, 300);
				}
			},
			error: function(xhr, status, error) {
				console.error('❌ AJAX Error:', error);
				$submitBtn.prop('disabled', false).val(originalValue);
				alert('Произошла ошибка. Попробуйте ещё раз.');
			}
		});
	}
    
    // 8. Запуск при загрузке
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