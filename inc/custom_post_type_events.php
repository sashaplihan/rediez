<?php

function custom_post_type_events() {

    $labels = array(
        'name'                  => _x( 'Мероприятия', 'Post Type General Name', 'rediez' ),
        'singular_name'         => 'Мероприятие',
        'menu_name'             => 'Мероприятия',
        'archives'              => 'Архив мероприятий',
        'all_items'             => 'Все мероприятия',
        'add_new_item'          => 'Добавить мероприятие',
        'add_new'               => 'Добавить',
        'new_item'              => 'Новое мероприятие',
        'edit_item'             => 'Редактировать мероприятие',
        'update_item'           => 'Обновить мероприятие',
        'view_item'             => 'Просмотреть мероприятие',
        'view_items'            => 'Посмотреть все мероприятия',
        'search_items'          => 'Поиск мероприятий',
        'not_found'             => 'Мероприятия не найдены',
        'not_found_in_trash'    => 'В корзине не найдено',
        'featured_image'        => 'Изображение мероприятия',
        'set_featured_image'    => 'Загрузить изображение',
        'remove_featured_image' => 'Удалить изображение',
        'use_featured_image'    => 'Использовать изображение',
    );

    $rewrite = array(
        'slug'       => 'events',
        'with_front' => true,
        'pages'      => false,
        'feeds'      => false,
    );

    $args = array(
        'label'               => 'Мероприятия',
        'labels'              => $labels,
        'supports'            => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'menu_position'       => 7,
        'menu_icon'           => 'dashicons-calendar-alt',
        'show_in_admin_bar'   => true,
        'show_in_nav_menus'   => true,
        'can_export'          => true,
        'has_archive'         => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'query_var'           => 'events',
        'rewrite'             => $rewrite,
        'capability_type'     => 'post',
    );

    register_post_type( 'rediez_events', $args );
}

add_action( 'init', 'custom_post_type_events', 0 );