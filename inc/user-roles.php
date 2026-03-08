<?php
/**
 * Роли пользователей: музыкант и ивентер
 *
 * @package rediez
 */

// 1. РЕГИСТРАЦИЯ РОЛЕЙ
function rediez_register_user_roles() {

    // Роль: Музыкант
    if ( ! get_role( 'um_musician' ) ) {
        add_role( 'um_musician', 'Музыкант', array(
            'read'                          => true,
            'upload_files'                  => true,

            // Права на свои записи rediez_musicians
            'edit_rediez_musicians'         => true,
            'read_rediez_musicians'         => true,
            'delete_rediez_musicians'       => false,

            // Публиковать нельзя — только pending
            'publish_rediez_musicians'      => false,
        ) );
    }

    // Роль: Ивентер
    if ( ! get_role( 'um_eventer' ) ) {
        add_role( 'um_eventer', 'Ивентер', array(
            'read'                       => true,
            'upload_files'               => true,

            // Права на свои записи rediez_events
            'edit_rediez_events'         => true,
            'read_rediez_events'         => true,
            'delete_rediez_events'       => true,

            // Публиковать нельзя — только pending
            'publish_rediez_events'      => false,
        ) );
    }
}
add_action( 'after_setup_theme', 'rediez_register_user_roles' );


// ========================================
// 2. ПРАВА CPT ДЛЯ КАСТОМНЫХ РОЛЕЙ
// WordPress использует capability_type для проверки прав
// Нужно явно разрешить роли редактировать свои записи
// ========================================
function rediez_map_custom_caps( $caps, $cap, $user_id, $args ) {

    $user = get_userdata( $user_id );
    if ( ! $user ) return $caps;

    // --- Музыкант ---
    if ( in_array( 'um_musician', (array) $user->roles ) ) {

        // Разрешаем создавать/редактировать свои записи музыканта
        if ( in_array( $cap, array( 'edit_post', 'edit_posts', 'edit_rediez_musicians' ) ) ) {

            // Если редактирует конкретную запись — проверяем что она его
            if ( ! empty( $args[0] ) ) {
                $post = get_post( $args[0] );
                if ( $post && $post->post_author == $user_id && $post->post_type === 'rediez_musicians' ) {
                    $caps = array( 'exist' );
                }
            } else {
                $caps = array( 'exist' );
            }
        }
    }

    // --- Ивентер ---
    if ( in_array( 'um_eventer', (array) $user->roles ) ) {

        if ( in_array( $cap, array( 'edit_post', 'edit_posts', 'edit_rediez_events' ) ) ) {

            if ( ! empty( $args[0] ) ) {
                $post = get_post( $args[0] );
                if ( $post && $post->post_author == $user_id && $post->post_type === 'rediez_events' ) {
                    $caps = array( 'exist' );
                }
            } else {
                $caps = array( 'exist' );
            }
        }
    }

    return $caps;
}
add_filter( 'map_meta_cap', 'rediez_map_custom_caps', 10, 4 );

// Убираем лишние пункты меню
function rediez_clean_admin_menu() {

    $user = wp_get_current_user();

    if ( in_array( 'um_musician', (array) $user->roles ) ) {

        // Оставляем только: Музыканты + Медиафайлы + Профиль
        remove_menu_page( 'index.php' );                // Консоль
        remove_menu_page( 'edit.php' );                 // Записи
        remove_menu_page( 'edit.php?post_type=page' );  // Страницы
        remove_menu_page( 'edit-comments.php' );        // Комментарии
        remove_menu_page( 'themes.php' );               // Внешний вид
        remove_menu_page( 'plugins.php' );              // Плагины
        remove_menu_page( 'users.php' );                // Пользователи
        remove_menu_page( 'tools.php' );                // Инструменты
        remove_menu_page( 'options-general.php' );      // Настройки

        // Убираем все CPT кроме музыкантов
        remove_menu_page( 'edit.php?post_type=rediez_events' );
        remove_menu_page( 'edit.php?post_type=rediez_poster' );

        // Редирект на список своих записей при входе в админку
        global $pagenow;
        if ( $pagenow === 'index.php' ) {
            wp_redirect( admin_url( 'edit.php?post_type=rediez_musicians' ) );
            exit;
        }
    }

    if ( in_array( 'um_eventer', (array) $user->roles ) ) {

        remove_menu_page( 'index.php' );
        remove_menu_page( 'edit.php' );
        remove_menu_page( 'edit.php?post_type=page' );
        remove_menu_page( 'edit-comments.php' );
        remove_menu_page( 'themes.php' );
        remove_menu_page( 'plugins.php' );
        remove_menu_page( 'users.php' );
        remove_menu_page( 'tools.php' );
        remove_menu_page( 'options-general.php' );

        // Убираем все CPT кроме событий
        remove_menu_page( 'edit.php?post_type=rediez_musicians' );
        remove_menu_page( 'edit.php?post_type=rediez_poster' );

        global $pagenow;
        if ( $pagenow === 'index.php' ) {
            wp_redirect( admin_url( 'edit.php?post_type=rediez_events' ) );
            exit;
        }
    }
}
add_action( 'admin_menu', 'rediez_clean_admin_menu', 999 );


// ========================================
// 4. ОГРАНИЧЕНИЕ: МУЗЫКАНТ МОЖЕТ СОЗДАТЬ
// ТОЛЬКО 1 ЗАПИСЬ
// ========================================
function rediez_limit_musician_posts( $data, $postarr ) {

    // Только для новых записей музыкантов
    if ( $data['post_type'] !== 'rediez_musicians' ) return $data;
    if ( ! empty( $postarr['ID'] ) ) return $data; // это обновление, не создание

    $user = wp_get_current_user();
    if ( ! in_array( 'um_musician', (array) $user->roles ) ) return $data;

    // Считаем существующие записи этого пользователя
    $existing = get_posts( array(
        'post_type'      => 'rediez_musicians',
        'author'         => $user->ID,
        'post_status'    => array( 'publish', 'pending', 'draft' ),
        'posts_per_page' => 1,
        'fields'         => 'ids',
    ) );

    if ( ! empty( $existing ) ) {
        // Блокируем создание — перенаправляем на существующую запись
        wp_die(
            '<p>У вас уже есть профиль музыканта. Вы можете <a href="' . get_edit_post_link( $existing[0] ) . '">редактировать его</a>.</p>',
            'Ограничение',
            array( 'back_link' => true )
        );
    }

    return $data;
}
add_filter( 'wp_insert_post_data', 'rediez_limit_musician_posts', 10, 2 );


// ========================================
// 5. ПРИНУДИТЕЛЬНЫЙ СТАТУС PENDING
// Музыкант и ивентер не могут публиковать сами
// ========================================
function rediez_force_pending_status( $data, $postarr ) {

    $user = wp_get_current_user();

    $is_musician = in_array( 'um_musician', (array) $user->roles );
    $is_eventer  = in_array( 'um_eventer',  (array) $user->roles );

    if ( ! $is_musician && ! $is_eventer ) return $data;

    // Разрешённые типы записей для каждой роли
    $allowed_types = array();
    if ( $is_musician ) $allowed_types[] = 'rediez_musicians';
    if ( $is_eventer )  $allowed_types[] = 'rediez_events';

    if ( ! in_array( $data['post_type'], $allowed_types ) ) return $data;

    // Если пытаются опубликовать — ставим pending
    if ( $data['post_status'] === 'publish' ) {
        $data['post_status'] = 'pending';
    }

    return $data;
}
add_filter( 'wp_insert_post_data', 'rediez_force_pending_status', 10, 2 );


// 6. УВЕДОМЛЕНИЕ АДМИНУ О НОВОЙ ЗАПИСИ
function rediez_notify_admin_on_pending( $new_status, $old_status, $post ) {

    // Только при переходе в статус pending
    if ( $new_status !== 'pending' || $old_status === 'pending' ) return;

    $allowed_types = array( 'rediez_musicians', 'rediez_events' );
    if ( ! in_array( $post->post_type, $allowed_types ) ) return;

    $admin_email = get_option( 'admin_email' );
    $author      = get_userdata( $post->post_author );

    $type_label = $post->post_type === 'rediez_musicians' ? 'музыканта' : 'мероприятия';

    $subject = sprintf( '[%s] Новая запись %s ожидает модерации', get_bloginfo( 'name' ), $type_label );

    $message = sprintf(
        "Новая запись \"%s\" от пользователя %s (%s) ожидает модерации.\n\nПросмотреть и опубликовать: %s",
        $post->post_title,
        $author ? $author->display_name : 'неизвестный',
        $author ? $author->user_email   : '',
        admin_url( 'post.php?post=' . $post->ID . '&action=edit' )
    );

    wp_mail( $admin_email, $subject, $message );
}
add_action( 'transition_post_status', 'rediez_notify_admin_on_pending', 10, 3 );

// 7. СКРЫВАЕМ ЗАПИСИ ДРУГИХ ПОЛЬЗОВАТЕЛЕЙ
function rediez_filter_posts_by_author( $query ) {

    if ( ! is_admin() || ! $query->is_main_query() ) return;

    $user = wp_get_current_user();

    $is_musician = in_array( 'um_musician', (array) $user->roles );
    $is_eventer  = in_array( 'um_eventer',  (array) $user->roles );

    if ( ! $is_musician && ! $is_eventer ) return;

    $post_type = $query->get( 'post_type' );

    if ( ( $is_musician && $post_type === 'rediez_musicians' ) ||
         ( $is_eventer  && $post_type === 'rediez_events' ) ) {
        $query->set( 'author', get_current_user_id() );
    }
}
add_action( 'pre_get_posts', 'rediez_filter_posts_by_author' );