<?php

// Placeholder заголовка
add_filter( 'enter_title_here', 'rediez_title_placeholder', 10, 2 );
function rediez_title_placeholder( $title, $post ) {
    if ( $post->post_type === 'rediez_musicians' ) {
        return 'Имя исполнителя / название группы';
    }
    if ( $post->post_type === 'rediez_events' ) {
        return 'Введите название мероприятия';
    }
    return $title;
}

// Стилизация и label заголовка
add_action( 'admin_head', 'rediez_title_styles_and_label' );
function rediez_title_styles_and_label() {
    if ( current_user_can( 'manage_options' ) ) return;

    $screen = get_current_screen();
    if ( ! $screen ) return;

    $post_type = $screen->post_type;
    if ( ! in_array( $post_type, array( 'rediez_musicians', 'rediez_events' ) ) ) return;

    $user  = wp_get_current_user();
    $roles = (array) $user->roles;

    $is_musician = in_array( 'um_musician', $roles ) && $post_type === 'rediez_musicians';
    $is_eventer  = in_array( 'um_eventer',  $roles ) && $post_type === 'rediez_events';

    if ( ! $is_musician && ! $is_eventer ) return;

    // Текст label зависит от типа записи
    $label = $is_musician
        ? 'Название группы или музыканта'
        : 'Название мероприятия';
    ?>
    <style>
        #titlediv #title {
            height: 1.3em !important;
            font-size: 1.3em !important;
            padding: 5px 10px !important;
            line-height: 1.5 !important;
        }
        #titlediv #title-prompt-text {
            padding: 5px 10px !important;
            font-size: 1.3em !important;
            color: #2c3338 !important;
        }
        .rediez-title-label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: #1d2327;
            margin: 10px 0 0 0;
            padding: 8px 12px;
        }
        @media screen and (max-width: 782px) {
            #titlediv #title-prompt-text {
                padding: 10px 10px !important;
            }
        }
    </style>
    <script>
    jQuery(document).ready(function($) {
        $('<label for="title" class="rediez-title-label"><?php echo esc_js( $label ); ?></label>')
            .insertBefore('#titlediv');
    });
    </script>
    <?php
}


// Удаление фильтров статусов (Все | Опубликованные | На утверждении)
function rediez_remove_post_status_views( $views ) {
    // Если пользователь - администратор, оставляем всё как есть
    if ( current_user_can( 'manage_options' ) ) {
        return $views;
    }
    // Проверяем, что мы находимся на нужных экранах (список музыкантов или ивентов)
    $screen = get_current_screen();
    if ( ! $screen ) return $views;

    $target_screens = array( 'edit-rediez_musicians', 'edit-rediez_events' );

    if ( in_array( $screen->id, $target_screens ) ) {
        // Возвращаем пустой массив, чтобы скрыть всю строку представлений
        return array();
    }

    return $views;
}
// Применяем фильтр динамически для каждого CPT
add_filter( 'views_edit-rediez_musicians', 'rediez_remove_post_status_views' );
add_filter( 'views_edit-rediez_events', 'rediez_remove_post_status_views' );


// СКРЫВАЕМ «НАСТРОЙКИ ЭКРАНА»
add_filter( 'screen_options_show_screen', function( $show ) {
    // Если пользователь - администратор, оставляем настройки
    if ( current_user_can( 'manage_options' ) ) {
        return $show;
    }

    // Для остальных (музыканты/ивентеры) возвращаем false
    return false;
} );
// СКРЫВАЕМ ВКЛАДКУ «ПОМОЩЬ» (Help)
add_action( 'admin_head', function() {
    if ( ! current_user_can( 'manage_options' ) ) {
        $screen = get_current_screen();
        if ( $screen ) {
            $screen->remove_help_tabs();
        }
    }
}, 20 );


// Единая стилизация кнопок действий для музыкантов и ивентеров.
function rediez_style_admin_action_buttons() {
    // Если админ — не вмешиваемся в стандартную схему WP
    if ( current_user_can( 'manage_options' ) ) {
        return;
    }
    $screen = get_current_screen();
    if ( ! $screen ) return;
    // Определяем целевые типы записей
    $target_post_types = array( 'rediez_musicians', 'rediez_events' );
    // Проверяем, находимся ли мы в списке (edit-...) или в редакторе (просто post type)
    if ( in_array( $screen->post_type, $target_post_types ) ) {
        ?>
        <style>
			<?php if ( $screen->post_type === 'rediez_musicians' ) : ?>
            /* Скрываем кнопку "Добавить" (Заполните портфолио) только для музыкантов */
            .wp-admin .page-title-action {
                display: none !important;
            }
            <?php endif; ?>
            .wp-admin .page-title-action,
            .wp-admin #publishing-action #publish {
				position: relative;
				display: inline-block;
				padding: 13px 40px;
				font-size: 12px;
				font-weight: 700;
				line-height: 1.6;
				color: #000;
				text-transform: uppercase;
				letter-spacing: 0.5px;
				background-color: #f3f901;
				border: 1px solid #f3f901;
				border-radius: 25px;
				transition: all 0.3s ease;
				cursor: pointer;
            }
            .wp-admin .page-title-action:hover,
            .wp-admin #publishing-action #publish:hover {
                background-color: #d0d500;
				border: 1px solid #d0d500;
            }
            .wp-admin #publishing-action #publish:focus {
                box-shadow: 0 0 0 2px #fff, 0 0 0 4px #2271b1 !important;
            }
			/* Один ряд для блока действий */
			#submitpost {
				display: flex !important;
				align-items: center !important;
				padding: 10px !important;
				clear: both !important;
			}
			#major-publishing-actions {
				display: flex !important;
				align-items: center !important;
    			justify-content: end !important;
				flex: 1 !important;
				border-top: none !important;
				background: #ffffff !important;
			}
			#minor-publishing-actions {
				padding: 0 10px 0;
			}
			#misc-publishing-actions {
				padding: 0 0 0 !important;
			}
			#delete-action a {
				color: #b32d2e !important;
				font-size: 12px !important;
				text-decoration: underline !important;
			}
			#publishing-action {
				margin: 0 !important;
			}
			/* Убираем clear который ломает flex */
			#major-publishing-actions .clear {
				display: none !important;
			}
			/* Фиксация внизу на мобиле */
			@media screen and (max-width: 992px) {
				#submitpost {
					position: fixed !important;
					bottom: 0 !important;
					left: 0 !important;
					right: 0 !important;
					z-index: 9999 !important;
					background: #fff !important;
					box-shadow: 0 -2px 8px rgba(0,0,0,0.15) !important;
					margin: 0 !important;
    				padding: 0 10px !important;
				}
				#submitpost .hndle {
					display: none !important;
				}
				/* Отступ снизу для контента чтобы не перекрывал */
				#poststuff {
					padding-bottom: 120px !important;
				}
			}
			@media screen and (max-width: 480px) {
				#major-publishing-actions {
					gap: 10px;
					padding: 5px 0 !important;
				}
				#major-publishing-actions .spinner {
					display: none !important;
				}
				.wp-admin .page-title-action, 
				.wp-admin #publishing-action #publish {
					margin: 0 !important;
					padding: 10px 18px !important;
					text-transform: none !important;
				}
				.wp-admin .submitbox #minor-publishing-actions #preview-action .preview.button {
					margin: 0 !important;
					padding: 10px 18px !important;
					text-transform: none !important;
				}
			}
        </style>
        <?php
    }
}
add_action( 'admin_head', 'rediez_style_admin_action_buttons' );


// Скрыть кнопку "Сохранить"
add_action( 'admin_head', 'rediez_hide_save_draft_button' );
function rediez_hide_save_draft_button() {
    if ( current_user_can( 'manage_options' ) ) return;

    $screen = get_current_screen();
    if ( ! $screen || ! in_array( $screen->post_type, array( 'rediez_musicians', 'rediez_events' ) ) ) return;
    ?>
    <style>
        #save-action { display: none !important; }
    </style>
    <?php
}

// Скрытие лишних настроек Опубликовать, Видимость и Дата публикации
add_action( 'admin_head', 'rediez_hide_publish_meta' );
function rediez_hide_publish_meta() {
    if ( current_user_can( 'manage_options' ) ) return;

    $screen = get_current_screen();
    if ( ! $screen || ! in_array( $screen->post_type, array( 'rediez_musicians', 'rediez_events' ) ) ) return;
    ?>
    <style>
        #post-status-select,
        .misc-pub-post-status { display: none !important; }

        .misc-pub-visibility { display: none !important; }

        .misc-pub-curtime { display: none !important; }
    </style>
    <?php
}


// Скрываем фильтры "Все даты" и "Фильтр" на странице списка записей
add_action( 'restrict_manage_posts', 'rediez_hide_list_filters', 1 );
function rediez_hide_list_filters( $post_type ) {
    if ( current_user_can( 'manage_options' ) ) return;

    $user  = wp_get_current_user();
    $roles = (array) $user->roles;

    $is_musician = in_array( 'um_musician', $roles ) && $post_type === 'rediez_musicians';
    $is_eventer  = in_array( 'um_eventer',  $roles ) && $post_type === 'rediez_events';

    if ( ! $is_musician && ! $is_eventer ) return;
    ?>
    <style>
        /* Скрываем dropdown "Все даты" */
        select#filter-by-date { display: none !important; }
        /* Скрываем кнопку "Фильтр" */
        #post-query-submit { display: none !important; }
        /* Скрываем поиск по категориям/таксономиям если есть */
        .alignleft.actions.bulkactions + .alignleft { display: none !important; }
    </style>
    <?php
}
// Убираем dropdown дат через PHP — чище чем CSS
add_filter( 'disable_months_dropdown', function( $disable, $post_type ) {
    if ( current_user_can( 'manage_options' ) ) return $disable;

    $user  = wp_get_current_user();
    $roles = (array) $user->roles;

    if ( in_array( 'um_musician', $roles ) && $post_type === 'rediez_musicians' ) return true;
    if ( in_array( 'um_eventer',  $roles ) && $post_type === 'rediez_events'    ) return true;

    return $disable;
}, 10, 2 );


// СКРЫВАЕМ УВЕДОМЛЕНИЕ О ВОССТАНОВЛЕНИИ ИЗ РЕЗЕРВНОЙ КОПИИ
function rediez_hide_autosave_notice() {
    if ( current_user_can( 'manage_options' ) ) {
        return;
    }
    $screen = get_current_screen();
    if ( ! $screen ) return;

    $target_post_types = array( 'rediez_musicians', 'rediez_events' );

    if ( in_array( $screen->post_type, $target_post_types ) ) {
        ?>
        <style>
            /* Скрываем уведомление о разнице версий в локальном хранилище браузера */
            #local-storage-notice {
                display: none !important;
            }
        </style>
        <?php
    }
}
add_action( 'admin_head', 'rediez_hide_autosave_notice' );


// СКРЫВАЕМ «МЕДИАФАЙЛЫ» В САЙДБАРЕ
add_action( 'admin_menu', 'rediez_remove_media_menu_item', 999 );
function rediez_remove_media_menu_item() {
    $user = wp_get_current_user();

    if ( current_user_can( 'manage_options' ) ) {
        return;
    }

    $is_musician = in_array( 'um_musician', (array) $user->roles );
    $is_eventer  = in_array( 'um_eventer',  (array) $user->roles );

    if ( $is_musician || $is_eventer ) {
        remove_menu_page( 'upload.php' );
    }
}


// ПРЯМАЯ ССЫЛКА МЕНЮ НА ПАРТФОЛИО
add_action( 'admin_menu', 'rediez_simplify_musician_sidebar_menu', 999 );

function rediez_simplify_musician_sidebar_menu() {
    $user = wp_get_current_user();
    // Работаем только для музыкантов
    if ( ! in_array( 'um_musician', (array) $user->roles ) ) {
        return;
    }
    // Ищем существующую запись этого музыканта
    $user_post = get_posts( array(
        'post_type'      => 'rediez_musicians',
        'post_status'    => array( 'publish', 'pending', 'draft', 'future' ),
        'author'         => $user->ID,
        'posts_per_page' => 1,
        'fields'         => 'ids',
    ) );
    // Формируем URL: если запись есть — на редактирование, если нет — на создание
    if ( ! empty( $user_post ) ) {
        $target_url = 'post.php?post=' . $user_post[0] . '&action=edit';
    } else {
        $target_url = 'post-new.php?post_type=rediez_musicians';
    }
    // Удаляем стандартное меню "Музыканты"
    remove_menu_page( 'edit.php?post_type=rediez_musicians' );
    // Добавляем новое меню, которое ведет сразу по ссылке
    add_menu_page(
        'Моя анкета',
        'Моё портфолио',
        'read',
        $target_url,
        '',
        'dashicons-microphone',
        6
    );
}


// СКРЫВАЕМ КНОПКУ «СВЕРНУТЬ МЕНЮ»
add_action( 'admin_head', function() {
    if ( current_user_can( 'manage_options' ) ) return;
    
    $user  = wp_get_current_user();
    $roles = (array) $user->roles;
    
    if ( ! array_intersect( $roles, [ 'um_musician', 'um_eventer' ] ) ) return;
    ?>
    <style>
        #collapse-menu { 
            display: none !important; 
        }
        #adminmenuwrap {
            margin-bottom: 0 !important;
        }
    </style>
    <?php
} );


// УДАЛЯЕМ КНОПКУ «+ ДОБАВИТЬ» ИЗ ВЕРХНЕГО АДМИН-БАРА
add_action( 'admin_bar_menu', 'rediez_remove_add_new_top_bar', 999 );
function rediez_remove_add_new_top_bar( $wp_admin_bar ) {
    // Если администратор — кнопка нужна для работы
    if ( current_user_can( 'manage_options' ) ) {
        return;
    }

    $user = wp_get_current_user();
    $target_roles = array( 'um_musician', 'um_eventer' );
    // Проверяем, есть ли у пользователя одна из целевых ролей
    if ( array_intersect( $target_roles, (array) $user->roles ) ) {
        // 'new-content' — это ID всей группы "Добавить" (Запись, Медиафайл, Страница и т.д.)
        $wp_admin_bar->remove_node( 'new-content' );
    }
}


// Подключаем стили и скрипты для сворачиваемых полей в админке
add_action( 'admin_footer', 'rediez_collapsible_fields_script' );
function rediez_collapsible_fields_script() {
    $screen = get_current_screen();
    if ( ! $screen || $screen->base !== 'post' ) return;
    ?>
    <style>
        .collapsible-field .cf-field__label {
            cursor: pointer;
            position: relative;
            padding-right: 40px !important;
            user-select: none;
            transition: background 0.15s ease;
        }
        .collapsible-field .cf-field__label:hover {
            background: rgba(0,0,0,0.03);
        }
        .collapsible-field .cf-field__label:after {
            content: "\f142";
            font-family: dashicons;
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 20px;
            transition: transform 0.2s ease;
        }
        .collapsible-field.is-closed .cf-field__body {
            display: none !important;
        }
        .collapsible-field.is-closed .cf-field__label:after {
            transform: translateY(-50%) rotate(180deg);
        }
        .collapsible-field {
            border: 1px solid #e2e4e7;
            margin-bottom: 5px !important;
            border-radius: 4px;
        }
    </style>
    <script>
    (function($) {
        var debounceTimer;

        function initCollapsibleFields() {
            $('.collapsible-field').each(function() {
                var $field = $(this);
                if ( $field.hasClass('is-initialized') ) return;
                $field.addClass('is-closed is-initialized');
            });
        }

        $(document).on('click', '.collapsible-field .cf-field__label', function() {
            var $current = $(this).closest('.collapsible-field');
            var wasClosed = $current.hasClass('is-closed');
            $('.collapsible-field').addClass('is-closed');
            if ( wasClosed ) {
                $current.removeClass('is-closed');
            }
        });

        $(document).ready(function() {
            initCollapsibleFields();

            var postbox = document.querySelector('#poststuff');
            if ( ! postbox ) return;

            var observer = new MutationObserver(function() {
                clearTimeout( debounceTimer );
                debounceTimer = setTimeout( initCollapsibleFields, 150 );
            });

            observer.observe( postbox, {
                childList: true,
                subtree:   true
            });
        });

    })(jQuery);
    </script>
    <?php
}


// Кастомизация табов галереи и видео музыкантов
add_action( 'admin_footer', 'rediez_media_tabs_style' );
function rediez_media_tabs_style() {
    $screen = get_current_screen();
    if ( ! $screen || $screen->base !== 'post' ) return;
    ?>
    <style>
        .rediez-media-switcher .cf-field__label {
            font-size: 14px !important;
            font-weight: 600 !important;
            color: #1d2327 !important;
            margin-bottom: 8px !important;
            display: block !important;
        }
        .rediez-media-switcher ul.cf-radio__list {
            display: flex !important;
            gap: 0 !important;
            margin: 0 !important;
            padding: 0 !important;
            list-style: none !important;
            border-bottom: 2px solid #8c8f94 !important;
        }
        .rediez-media-switcher li.cf-radio__list-item {
            margin: 0 !important;
            padding: 0 !important;
            list-style: none !important;
        }
        .rediez-media-switcher input.cf-radio__input {
            position: absolute !important;
            opacity: 0 !important;
            width: 0 !important;
            height: 0 !important;
            pointer-events: none !important;
        }
        .rediez-media-switcher label.cf-radio__label {
            display: inline-block !important;
            padding: 9px 26px !important;
            margin: 0 !important;
            background: #fff !important;
            color: #8c8f94 !important;
            font-weight: 600 !important;
            font-size: 13px !important;
            cursor: pointer !important;
            border: 1px solid #c3c4c7 !important;
            border-bottom: none !important;
            border-radius: 4px 4px 0 0 !important;
            transition: background 0.15s, color 0.15s !important;
            user-select: none !important;
            position: relative !important;
            bottom: -2px !important;
        }
        .rediez-media-switcher label.cf-radio__label:hover {
            background: #fff !important;
            color: #8c8f94 !important;
        }
        .rediez-media-switcher input.cf-radio__input:checked + label.cf-radio__label {
            background: #f0f0f1 !important;
            color: #3c434a !important;
            border-color: #8c8f94 !important;
            border-bottom: 2px solid #fff !important;
        }
        .rediez-gallery .cf-field__label,
        .rediez-video .cf-field__label {
            display: none !important;
        }
        .rediez-tab-content {
            margin-top: 0 !important;
        }
    </style>
    <?php
}


// Стилизация кнопки Просмотреть
add_action( 'admin_head', 'rediez_style_secondary_admin_buttons' );
function rediez_style_secondary_admin_buttons() {
    // Если админ — не трогаем стандартные стили
    if ( current_user_can( 'manage_options' ) ) {
        return;
    }
    $screen = get_current_screen();
    if ( ! $screen ) return;
    $target_post_types = array( 'rediez_musicians', 'rediez_events' );
    if ( in_array( $screen->post_type, $target_post_types ) ) {
        ?>
        <style>
            .wp-admin #minor-publishing-actions #preview-action .preview.button {
                background: #ffffff  !important;
                border: 1px solid #f3f901 !important;
                font-weight: 700 !important;
                color: #000000 !important;
                line-height: 1.5 !important;
				text-transform: uppercase !important;
                text-shadow: none !important;
                box-shadow: none !important;
                border-radius: 25px !important;
                padding: 13px 30px !important;
                height: auto !important;
                transition: all 0.2s ease-in-out !important;
            }
            .wp-admin #minor-publishing-actions #preview-action .preview.button:hover {
                background: #fff !important;
                color: #000000 !important;
                border: 1px solid #d0d500 !important;
            }
        </style>
        <?php
    }
}


// КАСТОМИЗАЦИЯ АДМИНКИ МУЗЫКАНТА И ИВЕНТЕРА
// Принудительно 1 колонка для музыканта
add_filter( 'get_user_option_screen_layout_rediez_musicians', function( $val ) {
    if ( current_user_can( 'manage_options' ) ) return $val;
    $user = wp_get_current_user();
    if ( ! in_array( 'um_musician', (array) $user->roles ) ) return $val;
    return 1;
} );
// Принудительно 1 колонка для ивентера
add_filter( 'get_user_option_screen_layout_rediez_events', function( $val ) {
    if ( current_user_can( 'manage_options' ) ) return $val;
    $user = wp_get_current_user();
    if ( ! in_array( 'um_eventer', (array) $user->roles ) ) return $val;
    return 1;
} );
// Перерегистрация метабоксов + удаление slug
add_action( 'do_meta_boxes', function( $post_type, $context, $post ) {
    if ( current_user_can( 'manage_options' ) ) return;
    $user = wp_get_current_user();
    // Музыкант
    if ( $post_type === 'rediez_musicians' && in_array( 'um_musician', (array) $user->roles ) ) {
        remove_meta_box( 'postimagediv', 'rediez_musicians', 'side' );
        add_meta_box(
            'postimagediv',
            __( 'Превью изображения музыканта' ),
            'post_thumbnail_meta_box',
            'rediez_musicians',
            'normal',
            'high'
        );
        remove_meta_box( 'submitdiv', 'rediez_musicians', 'side' );
        add_meta_box(
            'submitdiv',
            __( 'Опубликовать' ),
            'post_submit_meta_box',
            'rediez_musicians',
            'normal',
            'low'
        );
        remove_meta_box( 'slugdiv', 'rediez_musicians', 'normal' );
    }
    // Ивентер
    if ( $post_type === 'rediez_events' && in_array( 'um_eventer', (array) $user->roles ) ) {
        remove_meta_box( 'submitdiv', 'rediez_events', 'side' );
        add_meta_box(
            'submitdiv',
            __( 'Опубликовать' ),
            'post_submit_meta_box',
            'rediez_events',
            'normal',
            'low'
        );
        remove_meta_box( 'slugdiv', 'rediez_events', 'normal' );
    }

}, 10, 3 );
// Принудительный порядок блоков для музыканта
add_filter( 'get_user_option_meta-box-order_rediez_musicians', function( $val ) {
    if ( current_user_can( 'manage_options' ) ) return $val;
    $user = wp_get_current_user();
    if ( ! in_array( 'um_musician', (array) $user->roles ) ) return $val;
    return array(
        'normal'   => 'postimagediv,carbon_fields_container_e4d469bf,carbon_fields_container_eaf45349,submitdiv',
        'side'     => '',
        'advanced' => '',
    );
} );
// Принудительный порядок блоков для ивентера
add_filter( 'get_user_option_meta-box-order_rediez_events', function( $val ) {
    if ( current_user_can( 'manage_options' ) ) return $val;
    $user = wp_get_current_user();
    if ( ! in_array( 'um_eventer', (array) $user->roles ) ) return $val;
    return array(
        'normal'   => 'carbon_fields_container_e4d469bf,carbon_fields_container_242c7d68,submitdiv',
        'side'     => '',
        'advanced' => '',
    );
} );
// CSS — блокировка drag, стрелок, screen options, slug
add_action( 'admin_head', function() {
    if ( current_user_can( 'manage_options' ) ) return;

    $screen = get_current_screen();
    if ( ! $screen ) return;

    $user        = wp_get_current_user();
    $roles       = (array) $user->roles;
    $is_musician = in_array( 'um_musician', $roles ) && $screen->post_type === 'rediez_musicians';
    $is_eventer  = in_array( 'um_eventer',  $roles ) && $screen->post_type === 'rediez_events';

    if ( ! $is_musician && ! $is_eventer ) return;
    ?>
    <style>
        #screen-options-link-wrap,
        .screen-layout-screen-columns { 
			display: none !important; 
		}
        .postbox-header .handle-order-higher,
        .postbox-header .handle-order-lower,
		#submitdiv .toggle-indicator { 
			display: none !important; 
		}
        .postbox .hndle {
            cursor: default !important;
            pointer-events: none !important;
        }
        #edit-slug-box { display: none !important; }
    </style>
    <?php
} );


// Переводы кнопок и текста добавления фото или видео для музыкантов
add_action( 'admin_footer', function() {
    $screen = get_current_screen();
    if ( ! $screen || $screen->base !== 'post' ) return;
    if ( $screen->post_type !== 'rediez_musicians' ) return;
    ?>
    <script>
    jQuery(document).ready(function($) {
        function translateCFLabels() {
            $('.rediez-gallery').find('.cf-complex__placeholder-label').each(function() {
                if ($(this).text().trim() === 'There are no entries yet.') {
                    $(this).text('Фото ещё не добавлены.');
                }
            });

            $('.rediez-gallery').find('.cf-complex__inserter-button').each(function() {
                if ($(this).text().trim() === 'Add Entry') {
                    $(this).text('Добавить фото');
                }
            });

            $('.rediez-gallery').find('.cf-file__browse').each(function() {
                if ($(this).text().trim() === 'Select Image') {
                    $(this).text('Выбрать фото');
                }
            });

            $('.rediez-video').find('.cf-complex__placeholder-label').each(function() {
                if ($(this).text().trim() === 'There are no entries yet.') {
                    $(this).text('Видео ещё не добавлены.');
                }
            });

            $('.rediez-video').find('.cf-complex__inserter-button').each(function() {
                if ($(this).text().trim() === 'Add Entry') {
                    $(this).text('Добавить видео');
                }
            });
        }

        var observer = new MutationObserver(function() {
            translateCFLabels();
        });
        observer.observe(document.body, {
            childList: true,
            subtree:   true
        });

        translateCFLabels();
    });
    </script>
    <?php
} );


// Полностью удаляем узел с логотипом WordPress из админ-бара
add_action( 'admin_bar_menu', 'rediez_remove_wp_logo_completely', 999 );
function rediez_remove_wp_logo_completely( $wp_admin_bar ) {
    if ( current_user_can( 'manage_options' ) ) return;

    $user  = wp_get_current_user();
    $roles = (array) $user->roles;
    
    if ( in_array( 'um_musician', $roles ) || in_array( 'um_eventer', $roles ) ) {
        $wp_admin_bar->remove_node( 'wp-logo' );
    }
}

// Кастомизация логотипа вместо "домика"
add_action( 'admin_head', 'rediez_adminbar_mobile_logo' );
function rediez_adminbar_mobile_logo() {
    $logo_url = carbon_get_theme_option( 'crb_header_logo' );
    if ( ! $logo_url ) return;

    if ( current_user_can( 'manage_options' ) ) return;
    $user  = wp_get_current_user();
    $roles = (array) $user->roles;
    if ( ! in_array( 'um_musician', $roles ) && ! in_array( 'um_eventer', $roles ) ) return;

    ?>
    <style>
        #wpadminbar #wp-admin-bar-site-name > .ab-item:before {
            display: none !important;
        }
        #wpadminbar #wp-admin-bar-site-name > .ab-item {
            background-image: url('<?php echo esc_url( $logo_url ); ?>') !important;
            background-repeat: no-repeat !important;
            background-position: center !important;
            background-size: contain !important;
            width: 80px !important;
            height: 32px !important;
            font-size: 0 !important;
			margin: 0 5px !important;
            padding: 2px 0 !important;
        }
        #wpadminbar #wp-admin-bar-site-name:hover > .ab-item {
            background-color: transparent !important;
        }
		@media screen and (max-width: 992px) {
			#wpadminbar #wp-admin-bar-site-name > .ab-item {
				padding: 7px 0 !important;
			}
		}
    </style>
    <?php
}


// Переводы кнопок даты
add_action( 'admin_footer', 'rediez_translate_cf_datepicker' );
function rediez_translate_cf_datepicker() {
    $screen = get_current_screen();
    if ( ! $screen ) return;
    if ( ! in_array( $screen->post_type, array( 'rediez_musicians', 'rediez_events' ) ) ) return;
    ?>
    <script>
    jQuery(document).ready(function($) {
        function translateDatepicker() {
            $('button.cf-datetime__button[data-toggle="true"]').each(function() {
                if ( $(this).text().trim() === 'Select Date' ) {
                    $(this).text('Выбрать дату и время');
                }
            });
        }

        var observer = new MutationObserver(function() {
            translateDatepicker();
        });

        observer.observe(document.body, {
            childList: true,
            subtree:   true
        });

        translateDatepicker();
    });
    </script>
    <?php
}


// Переводы месяцев и дней в flatpickr
add_action( 'admin_print_footer_scripts', 'rediez_flatpickr_global_ru', 1 );
function rediez_flatpickr_global_ru() {
    ?>
    <script>
    (function() {
        const russianLocale = {
            firstDayOfWeek: 1,
            weekdays: {
                shorthand: ['Вс', 'Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб'],
                longhand: ['Воскресенье', 'Понедельник', 'Вторник', 'Среда', 'Четверг', 'Пятница', 'Суббота']
            },
            months: {
                shorthand: ['Янв', 'Фев', 'Мар', 'Апр', 'Май', 'Июн', 'Июл', 'Авг', 'Сен', 'Окт', 'Ноя', 'Дек'],
                longhand: ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь']
            },
            rangeSeparator: ' - ',
            scrollTitle: 'Прокрутите для изменения',
            toggleTitle: 'Нажмите для переключения',
            time_24hr: true
        };

        const localize = () => {
            if ( typeof window.flatpickr === 'undefined' ) return false;
            window.flatpickr.localize( russianLocale );
            window.flatpickr.l10ns.ru      = russianLocale;
            window.flatpickr.l10ns.default = Object.assign( {}, window.flatpickr.l10ns.default, russianLocale );
            return true;
        };

        const interval = setInterval(() => {
            if ( localize() ) clearInterval( interval );
        }, 50);

        setTimeout(() => clearInterval( interval ), 5000);
    })();
    </script>
    <?php
}


// Убираем массовые действия для музыкантов
add_filter( 'bulk_actions-edit-rediez_musicians', function( $actions ) {
    if ( current_user_can( 'manage_options' ) ) return $actions;
    $user = wp_get_current_user();
    if ( ! in_array( 'um_musician', (array) $user->roles ) ) return $actions;
    return array();
} );
// Убираем массовые действия для ивентеров
add_filter( 'bulk_actions-edit-rediez_events', function( $actions ) {
    if ( current_user_can( 'manage_options' ) ) return $actions;
    $user = wp_get_current_user();
    if ( ! in_array( 'um_eventer', (array) $user->roles ) ) return $actions;
    return array();
} );
// Скрываем чекбоксы через CSS
add_action( 'admin_head', function() {
    if ( current_user_can( 'manage_options' ) ) return;

    $screen = get_current_screen();
    if ( ! $screen ) return;

    $user  = wp_get_current_user();
    $roles = (array) $user->roles;

    $is_musician = in_array( 'um_musician', $roles ) && $screen->post_type === 'rediez_musicians';
    $is_eventer  = in_array( 'um_eventer',  $roles ) && $screen->post_type === 'rediez_events';

    if ( ! $is_musician && ! $is_eventer ) return;
    ?>
    <style>
        .manage-column.column-cb,
        .check-column { display: none !important; }
    </style>
    <?php
} );


add_filter( 'manage_edit-rediez_events_columns', function( $columns ) {
    if ( current_user_can( 'manage_options' ) ) return $columns;
    $user = wp_get_current_user();
    if ( ! in_array( 'um_eventer', (array) $user->roles ) ) return $columns;
    
    if ( isset( $columns['title'] ) ) {
        $columns['title'] = 'Название мероприятия';
    }
    return $columns;
} );


// Отключаем модалку "Запись уже редактируется" для всех пользователей и типов записей
add_filter( 'show_post_locked_dialog', '__return_false' );