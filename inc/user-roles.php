<?php
/**
 * Роли пользователей: музыкант и ивентер
 *
 * @package rediez
 */

// 1. ПРАВА РОЛЕЙ
function rediez_add_role_capabilities() {
    
    // Версия прав. Если добавили новые права — просто увеличьте число (например, на 1.0.5), чтобы изменения принудительно записались в базу данных.
    $ver = '1.0.5'; 
    if ( get_option( 'rediez_roles_version' ) !== $ver ) {
        update_option( 'rediez_roles_version', $ver );
    }

    // --- Музыкант ---
    $musician = get_role( 'um_musician' );
    if ( $musician ) {
        $musician->add_cap( 'read' );
        $musician->add_cap( 'upload_files' );
        $musician->add_cap( 'edit_musician_post' );      
        $musician->add_cap( 'edit_musician_posts' );
        
        // ИСПРАВЛЕНИЕ: Добавляем права, без которых WP скрывает интерфейс редактирования
        $musician->add_cap( 'edit_published_musician_posts' ); // Чтобы не терять доступ после одобрения
        $musician->add_cap( 'publish_musician_posts' );        // Техническое право для отображения кнопок
        
        $musician->add_cap( 'edit_others_musician_posts', false );   
        $musician->add_cap( 'read_private_musician_posts', false );  
        $musician->add_cap( 'delete_musician_post', false );         
        $musician->add_cap( 'delete_musician_posts', false );
    }

    // --- Ивентер ---
    $eventer = get_role( 'um_eventer' );
    if ( $eventer ) {
        $eventer->add_cap( 'read' );
        $eventer->add_cap( 'upload_files' );
        $eventer->add_cap( 'edit_eventer_post' );      
        $eventer->add_cap( 'edit_eventer_posts' );
        
        // ИСПРАВЛЕНИЕ: Аналогично для ивентера
        $eventer->add_cap( 'edit_published_eventer_posts' );
        $eventer->add_cap( 'publish_eventer_posts' );
        
        $eventer->add_cap( 'edit_others_eventer_posts', false );   
        $eventer->add_cap( 'read_private_eventer_posts', false );  
        $eventer->add_cap( 'delete_eventer_post' );                
        $eventer->add_cap( 'delete_eventer_posts' );
        $eventer->add_cap( 'delete_others_eventer_posts', false ); 
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
        
        $admin->add_cap( 'edit_published_musician_posts' ); 
        $admin->add_cap( 'edit_private_musician_posts' );
        $admin->add_cap( 'delete_private_musician_posts' );

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

        $admin->add_cap( 'edit_published_eventer_posts' ); 
        $admin->add_cap( 'edit_private_eventer_posts' );
        $admin->add_cap( 'delete_private_eventer_posts' );
	}
}
add_action( 'init', 'rediez_add_role_capabilities' );


// ИСПРАВЛЕНИЕ: Разрешаем авторам редактировать свои записи в статусе 'pending'
function rediez_fix_pending_editing_capabilities( $caps, $cap, $user_id, $args ) {
    if ( ! is_user_logged_in() ) return $caps;

    if ( in_array( $cap, array( 'edit_post', 'delete_post' ) ) && ! empty( $args[0] ) ) {
        $post = get_post( $args[0] );
        if ( ! $post ) return $caps;

        $our_types = array( 'rediez_musicians', 'rediez_events' );
        if ( in_array( $post->post_type, $our_types ) && (int) $post->post_author === (int) $user_id ) {
            if ( $post->post_status === 'pending' ) {
                $base_cap = ( $post->post_type === 'rediez_musicians' ) ? 'edit_musician_posts' : 'edit_eventer_posts';
                return array( $base_cap );
            }
        }
    }
    return $caps;
}
add_filter( 'map_meta_cap', 'rediez_fix_pending_editing_capabilities', 10, 4 );


// 2. ЧИСТИМ АДМИНКУ ДЛЯ КАСТОМНЫХ РОЛЕЙ
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

// 3. ОГРАНИЧЕНИЕ: МУЗЫКАНТ — ТОЛЬКО 1 ЗАПИСЬ
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

// 4. ПРИНУДИТЕЛЬНЫЙ СТАТУС PENDING
function rediez_force_pending_status( $data, $postarr ) {

    $user        = wp_get_current_user();
    
    // Администратор может публиковать сразу
    if ( current_user_can( 'manage_options' ) ) return $data;

    $is_musician = in_array( 'um_musician', (array) $user->roles );
    $is_eventer  = in_array( 'um_eventer',  (array) $user->roles );

    if ( ! $is_musician && ! $is_eventer ) return $data;

    $allowed_types = array();
    if ( $is_musician ) $allowed_types[] = 'rediez_musicians';
    if ( $is_eventer )  $allowed_types[] = 'rediez_events';

    if ( ! in_array( $data['post_type'], $allowed_types ) ) return $data;

    // Даже если пользователь пытается опубликовать (благодаря праву publish_posts), мы принудительно ставим на модерацию.
    if ( in_array( $data['post_status'], array( 'publish', 'draft' ) ) ) {
        $data['post_status'] = 'pending';
    }

    return $data;
}
add_filter( 'wp_insert_post_data', 'rediez_force_pending_status', 10, 2 );

// 5. УВЕДОМЛЕНИЕ АДМИНУ О НОВОЙ ЗАПИСИ
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

// 6. СКРЫВАЕМ ЗАПИСИ ДРУГИХ ПОЛЬЗОВАТЕЛЕЙ
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

// 7. МЕДИАБИБЛИОТЕКА — ТОЛЬКО СВОИ ФАЙЛЫ
function rediez_filter_media_by_author( $query ) {

    $user        = wp_get_current_user();
    $is_musician = in_array( 'um_musician', (array) $user->roles );
    $is_eventer  = in_array( 'um_eventer',  (array) $user->roles );

    if ( ! $is_musician && ! $is_eventer ) return $query;

    $query['author'] = get_current_user_id();
    return $query;
}
add_filter( 'ajax_query_attachments_args', 'rediez_filter_media_by_author' );

// 8. РАЗРЕШАЕМ ДОСТУП В WP-ADMIN (Ultimate Member)
add_filter( 'um_access_protected_wpadmin', function( $protected ) {
    $user          = wp_get_current_user();
    $allowed_roles = array( 'um_musician', 'um_eventer' );
    
    if ( ! is_user_logged_in() ) return $protected;

    foreach ( $allowed_roles as $role ) {
        if ( in_array( $role, (array) $user->roles ) ) {
            return false;
        }
    }
    return $protected;
} );

// 9. AJAX: ДИНАМИЧЕСКИЙ РЕДИРЕКТ ПОСЛЕ ЛОГИНА МУЗЫКАНТА
// Вызывается из JS после успешного логина — возвращает нужный URL в зависимости от наличия профиля.
add_action( 'wp_ajax_rediez_get_musician_redirect', 'rediez_get_musician_redirect' );
function rediez_get_musician_redirect() {

    // Эндпоинт доступен только залогиненным
    if ( ! is_user_logged_in() ) {
        wp_send_json_error( array( 'message' => 'Not logged in' ), 401 );
    }

    $user = wp_get_current_user();

    // Для не-музыкантов возвращаем ошибку — JS уйдёт в fallback
    if ( ! in_array( 'um_musician', (array) $user->roles ) ) {
        wp_send_json_error( array( 'message' => 'Not a musician' ) );
    }

    $existing = get_posts( array(
        'post_type'      => 'rediez_musicians',
        'author'         => $user->ID,
        'post_status'    => array( 'publish', 'pending', 'draft' ),
        'posts_per_page' => 1,
        'fields'         => 'ids',
    ) );

    if ( ! empty( $existing ) ) {
        // Профиль уже есть — ведём на редактирование
        $url = admin_url( 'post.php?post=' . $existing[0] . '&action=edit' );
    } else {
        // Профиля нет — ведём на создание
        $url = admin_url( 'post-new.php?post_type=rediez_musicians' );
    }

    wp_send_json_success( array( 'redirect_url' => $url ) );
}

// 10. РЕДИРЕКТ ПОСЛЕ ВЫХОДА — НА ГЛАВНУЮ
add_filter( 'logout_redirect', 'rediez_logout_redirect', 5, 3 );
function rediez_logout_redirect( $redirect_to, $requested_redirect_to, $user ) {

    if ( ! ( $user instanceof WP_User ) ) {
        return $redirect_to;
    }

    $roles         = (array) $user->roles;
    $custom_roles  = array( 'um_musician', 'um_eventer' );

    foreach ( $custom_roles as $role ) {
        if ( in_array( $role, $roles ) ) {
            return home_url( '/' );
        }
    }

    return $redirect_to;
}