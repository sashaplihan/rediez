<?php
/*
 * Вывод кастомных модальных окон в админке для музыкантов и ивентеров.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Защита от прямого вызова
}

// Подключение встроенного jQuery на страницах редактирования
add_action( 'admin_enqueue_scripts', 'rediez_enqueue_admin_modal_assets' );
function rediez_enqueue_admin_modal_assets( $hook ) {
    // Работает на страницах создания и редактирования записей
    if ( ! in_array( $hook, array( 'post.php', 'post-new.php' ), true ) ) {
        return;
    }

    $screen = get_current_screen();
    if ( ! $screen || ! in_array( $screen->post_type, array( 'rediez_musicians', 'rediez_events' ), true ) ) {
        return;
    }
    // Встроенный в WP jQuery
    wp_enqueue_script( 'jquery' );
}

// Рендерим модалку в подвале админки
add_action( 'admin_footer', 'rediez_render_success_modal' );
function rediez_render_success_modal() {
    // Пропускаем AJAX-запросы — там нет screen-контекста
    if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
        return;
    }

    $screen = get_current_screen();
    if ( ! $screen || ! in_array( $screen->post_type, array( 'rediez_musicians', 'rediez_events' ), true ) ) {
        return;
    }
    /**
     * Фильтруем коды сообщений WordPress:
     * 1 - Запись обновлена (обычное сохранение изменений)
     * 6 - Запись опубликована (если у роли есть права на автопубликацию)
     * 8 - Запись отправлена на модерацию (самый важный код для новых записей!)
     */
    $allowed_messages = array( '1', '6', '8' );
    if ( ! isset( $_GET['message'] ) || ! in_array( $_GET['message'], $allowed_messages ) ) {
        return;
    }

    $user       = wp_get_current_user();
    $roles      = (array) $user->roles;
    $message_id = (string) $_GET['message'];
    // Дефолтные тексты на случай форс-мажора
    $modal_title = 'Успешно сохранено!';
    $modal_text  = 'Ваши изменения успешно записаны.';
    // Разделяет логику текстов
    if ( in_array( 'um_musician', $roles, true ) ) {
        if ( $message_id === '8' ) {
            $modal_title = 'Портфолио отправлено на модерацию';
            $modal_text  = 'Ваш профиль успешно сохранен и передан на проверку. После подтверждения администратором информация будет опубликована на сайте.';
        } else {
            $modal_title = 'Изменения сохранены!';
            $modal_text  = 'Портфолио музыканта успешно обновлен.';
        }
    } elseif ( in_array( 'um_eventer', $roles, true ) ) {
        if ( $message_id === '8' ) {
            $modal_title = 'Мероприятие отправлено на модерацию';
            $modal_text  = 'Мероприятие успешно сохранено и передано на проверку. После подтверждения администратором информация появится на сайте';
        } else {
            $modal_title = 'Мероприятие обновлено!';
            $modal_text  = 'Изменения в описании мероприятия успешно сохранены.';
        }
    }

    ?>
    <div id="rediez-success-modal" style="display:none;" role="dialog" aria-modal="true" aria-labelledby="rediez-modal-title">
        <div class="rediez-modal__overlay">
            <div class="rediez-modal__container">
                <header class="rediez-modal__header">
                    <h2 class="rediez-modal__title" id="rediez-modal-title">
                        <?php echo esc_html( $modal_title ); ?>
                    </h2>
                    <button type="button" class="rediez-modal__close" id="rediez-modal-close-icon" aria-label="Закрыть">&times;</button>
                </header>
                <div class="rediez-modal__content">
                    <p><?php echo esc_html( $modal_text ); ?></p>
                </div>
                <footer class="rediez-modal__footer">
                    <button type="button" class="rediez-modal__btn" id="rediez-modal-close-btn">Отлично, понятно!</button>
                </footer>
            </div>
        </div>
    </div>

    <style>
        .rediez-modal__overlay {
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(0, 0, 0, 0.85);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 999999;
        }
        .rediez-modal__container {
            background-color: #1e1e1e;
            padding: 30px;
            max-width: 450px;
            width: 90%;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.5);
            box-sizing: border-box;
            border: 1px solid #333;
            position: relative;
            animation: rediez-slide-in .3s cubic-bezier(0, 0, .2, 1);
        }
        .rediez-modal__header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #333;
            padding-bottom: 15px;
            margin-bottom: 15px;
        }
        .rediez-modal__title {
            margin: 0;
            color: #fff;
            font-size: 20px;
            font-weight: 700;
        }
        .rediez-modal__close {
            background: transparent;
            border: none;
            color: #888;
            font-size: 24px;
            cursor: pointer;
            line-height: 1;
            padding: 0;
            transition: color 0.2s ease;
        }
        .rediez-modal__close:hover {
            color: #fff;
        }
        .rediez-modal__content {
            color: #ccc;
            font-size: 14px;
            line-height: 1.6;
            margin-bottom: 25px;
        }
        .rediez-modal__footer {
            display: flex;
            justify-content: flex-end;
        }
        .rediez-modal__btn {
            background-color: #f3f901;
            color: #000;
            font-weight: 700;
            text-transform: uppercase;
            font-size: 11px;
            letter-spacing: 0.5px;
            padding: 12px 25px;
            border: none;
            border-radius: 25px;
            cursor: pointer;
            transition: background .2s ease;
        }
        .rediez-modal__btn:hover {
            background-color: #d0d500;
        }
        @keyframes rediez-slide-in {
            from { opacity: 0; transform: translateY(15%); }
            to   { opacity: 1; transform: translateY(0); }
        }
    </style>

    <script>
        jQuery(document).ready(function($) {
            // Прячем стандартный WP-нотис только если показываем модалку
            $('#message.notice-success').hide();
            // Блокируем скролл body админки при открытой модалке
            $('body').css('overflow', 'hidden');
            // Плавно показываем модалку
            $('#rediez-success-modal').fadeIn(200);
            // Функция закрытия с восстановлением скролла
            function closeRediezModal() {
                $('#rediez-success-modal').fadeOut(200, function() {
                    $('body').css('overflow', '');
                });
            }
            // Закрытие по клику на кнопки и оверлей
            $('#rediez-modal-close-btn, #rediez-modal-close-icon, .rediez-modal__overlay').on('click', function(e) {
                if (
                    $(e.target).is('.rediez-modal__overlay') ||
                    $(e.target).is('#rediez-modal-close-btn') ||
                    $(e.target).is('#rediez-modal-close-icon')
                ) {
                    closeRediezModal();
                }
            });
            // Закрытие по клавише Escape
            $(document).on('keydown', function(e) {
                if ( e.key === 'Escape' ) {
                    closeRediezModal();
                }
            });
        });
    </script>
    <?php
}