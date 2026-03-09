<?php
/**
 * Роли пользователей: музыкант и ивентер
 * Подключить в functions.php:
 * require_once get_template_directory() . '/inc/user-roles.php';
 *
 * @package rediez
 */

// ========================================
// 1. ПРАВА РОЛЕЙ
// Добавляем капабилити под наш кастомный capability_type
// Запускается при каждой загрузке — проверяет наличие прав
// ========================================
function rediez_add_role_capabilities() {

    // --- Музыкант ---
    $musician = get_role( 'um_musician' );
    if ( $musician ) {
        // Права для rediez_musicians (capability_type: musician_post / musician_posts)
        $musician->add_cap( 'read' );
        $musician->add_cap( 'upload_files' );
        $musician->add_cap( 'edit_musician_post' );      // редактировать свою запись
        $musician->add_cap( 'edit_musician_posts' );     // видеть список
        $musician->add_cap( 'edit_others_musician_posts', false );   // чужие — нет
        $musician->add_cap( 'publish_musician_posts', false );       // публиковать — нет
        $musician->add_cap( 'read_private_musician_posts', false );  // приватные — нет
        $musician->add_cap( 'delete_musician_post', false );         // удалять — нет
        $musician->add_cap( 'delete_musician_posts', false );
    }

    // --- Ивентер ---
    $eventer = get_role( 'um_eventer' );
    if ( $eventer ) {
        // Права для rediez_events (capability_type: eventer_post / eventer_posts)
        $eventer->add_cap( 'read' );
        $eventer->add_cap( 'upload_files' );
        $eventer->add_cap( 'edit_eventer_post' );      // редактировать свою запись
        $eventer->add_cap( 'edit_eventer_posts' );     // видеть список
        $eventer->add_cap( 'edit_others_eventer_posts', false );   // чужие — нет
        $eventer->add_cap( 'publish_eventer_posts', false );       // публиковать — нет
        $eventer->add_cap( 'read_private_eventer_posts', false );  // приватные — нет
        $eventer->add_cap( 'delete_eventer_post' );                // удалять свои — да
        $eventer->add_cap( 'delete_eventer_posts' );
        $eventer->add_cap( 'delete_others_eventer_posts', false ); // чужие — нет
    }

	// --- Администратор ---
	$admin = get_role( 'administrator' );
	if ( $admin ) {
		// Права для rediez_musicians
		$admin->add_cap( 'edit_musician_post' );
		$admin->add_cap( 'edit_musician_posts' );
		$admin->add_cap( 'edit_others_musician_posts' );
		$admin->add_cap( 'publish_musician_posts' );
		$admin->add_cap( 'read_private_musician_posts' );
		$admin->add_cap( 'delete_musician_post' );
		$admin->add_cap( 'delete_musician_posts' );
		$admin->add_cap( 'delete_others_musician_posts' );
		$admin->add_cap( 'delete_published_musician_posts' );

		// Права для rediez_events
		$admin->add_cap( 'edit_eventer_post' );
		$admin->add_cap( 'edit_eventer_posts' );
		$admin->add_cap( 'edit_others_eventer_posts' );
		$admin->add_cap( 'publish_eventer_posts' );
		$admin->add_cap( 'read_private_eventer_posts' );
		$admin->add_cap( 'delete_eventer_post' );
		$admin->add_cap( 'delete_eventer_posts' );
		$admin->add_cap( 'delete_others_eventer_posts' );
		$admin->add_cap( 'delete_published_eventer_posts' );
	}
}
add_action( 'init', 'rediez_add_role_capabilities' );


// ========================================
// 2. ЧИСТИМ АДМИНКУ ДЛЯ КАСТОМНЫХ РОЛЕЙ
// ========================================
function rediez_clean_admin_menu() {

    $user = wp_get_current_user();

    // Администратор — не трогаем меню
    if ( current_user_can( 'manage_options' ) ) return;

    if ( in_array( 'um_musician', (array) $user->roles ) ) {

        remove_menu_page( 'index.php' );
        remove_menu_page( 'edit.php' );
        remove_menu_page( 'edit.php?post_type=page' );
        remove_menu_page( 'edit-comments.php' );
        remove_menu_page( 'themes.php' );
        remove_menu_page( 'plugins.php' );
        remove_menu_page( 'users.php' );
        remove_menu_page( 'tools.php' );
        remove_menu_page( 'options-general.php' );
        remove_menu_page( 'edit.php?post_type=rediez_events' );
        remove_menu_page( 'edit.php?post_type=rediez_poster' );

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
// 3. ОГРАНИЧЕНИЕ: МУЗЫКАНТ — ТОЛЬКО 1 ЗАПИСЬ
// ========================================
function rediez_limit_musician_posts( $data, $postarr ) {

    if ( $data['post_type'] !== 'rediez_musicians' ) return $data;
    if ( ! empty( $postarr['ID'] ) ) return $data;

    $user = wp_get_current_user();
    if ( ! in_array( 'um_musician', (array) $user->roles ) ) return $data;

    $existing = get_posts( array(
        'post_type'      => 'rediez_musicians',
        'author'         => $user->ID,
        'post_status'    => array( 'publish', 'pending', 'draft' ),
        'posts_per_page' => 1,
        'fields'         => 'ids',
    ) );

    if ( ! empty( $existing ) ) {
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
// 4. ПРИНУДИТЕЛЬНЫЙ СТАТУС PENDING
// ========================================
function rediez_force_pending_status( $data, $postarr ) {

    $user        = wp_get_current_user();
    $is_musician = in_array( 'um_musician', (array) $user->roles );
    $is_eventer  = in_array( 'um_eventer',  (array) $user->roles );

    if ( ! $is_musician && ! $is_eventer ) return $data;

    $allowed_types = array();
    if ( $is_musician ) $allowed_types[] = 'rediez_musicians';
    if ( $is_eventer )  $allowed_types[] = 'rediez_events';

    if ( ! in_array( $data['post_type'], $allowed_types ) ) return $data;

    if ( in_array( $data['post_status'], array( 'publish', 'draft' ) ) ) {
        $data['post_status'] = 'pending';
    }

    return $data;
}
add_filter( 'wp_insert_post_data', 'rediez_force_pending_status', 10, 2 );


// ========================================
// 5. УВЕДОМЛЕНИЕ АДМИНУ О НОВОЙ ЗАПИСИ
// ========================================
function rediez_notify_admin_on_pending( $new_status, $old_status, $post ) {

    if ( $new_status !== 'pending' || $old_status === 'pending' ) return;

    $allowed_types = array( 'rediez_musicians', 'rediez_events' );
    if ( ! in_array( $post->post_type, $allowed_types ) ) return;

    $admin_email = get_option( 'admin_email' );
    $author      = get_userdata( $post->post_author );
    $type_label  = $post->post_type === 'rediez_musicians' ? 'музыканта' : 'мероприятия';

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


// ========================================
// 6. СКРЫВАЕМ ЗАПИСИ ДРУГИХ ПОЛЬЗОВАТЕЛЕЙ
// ========================================
function rediez_filter_posts_by_author( $query ) {

    if ( ! is_admin() || ! $query->is_main_query() ) return;

    $user        = wp_get_current_user();
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


// ========================================
// 7. МЕДИАБИБЛИОТЕКА — ТОЛЬКО СВОИ ФАЙЛЫ
// ========================================
function rediez_filter_media_by_author( $query ) {

    $user        = wp_get_current_user();
    $is_musician = in_array( 'um_musician', (array) $user->roles );
    $is_eventer  = in_array( 'um_eventer',  (array) $user->roles );

    if ( ! $is_musician && ! $is_eventer ) return $query;

    $query['author'] = get_current_user_id();
    return $query;
}
add_filter( 'ajax_query_attachments_args', 'rediez_filter_media_by_author' );


// ========================================
// 8. РАЗРЕШАЕМ ДОСТУП В WP-ADMIN (Ultimate Member)
// ========================================
add_filter( 'um_access_protected_wpadmin', function( $protected ) {
    $user          = wp_get_current_user();
    $allowed_roles = array( 'um_musician', 'um_eventer' );
    foreach ( $allowed_roles as $role ) {
        if ( in_array( $role, (array) $user->roles ) ) {
            return false;
        }
    }
    return $protected;
} );