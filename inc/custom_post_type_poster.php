<?php

function custom_post_type_poster() {

    $labels = array(
        'name'                  => _x( 'Афиша', 'Post Type General Name', 'rediez' ),
        'singular_name'         => 'Событие афиши',
        'menu_name'             => 'Афиша',
        'archives'              => 'Архив афиши',
        'all_items'             => 'Все события',
        'add_new_item'          => 'Добавить событие',
        'add_new'               => 'Добавить',
        'new_item'              => 'Новое событие',
        'edit_item'             => 'Редактировать событие',
        'update_item'           => 'Обновить событие',
        'view_item'             => 'Просмотреть событие',
        'view_items'            => 'Посмотреть все события',
        'search_items'          => 'Поиск по афише',
        'not_found'             => 'События не найдены',
        'not_found_in_trash'    => 'В корзине не найдено',
        'featured_image'        => 'Изображение события',
        'set_featured_image'    => 'Загрузить изображение',
        'remove_featured_image' => 'Удалить изображение',
        'use_featured_image'    => 'Использовать изображение',
    );

    $rewrite = array(
        'slug'       => 'poster',
        'with_front' => true,
        'pages'      => false,
        'feeds'      => false,
    );

    $args = array(
        'label'               => 'Афиша',
        'labels'              => $labels,
        'supports'            => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'menu_position'       => 8,
        'menu_icon'           => 'dashicons-tickets-alt',
        'show_in_admin_bar'   => true,
        'show_in_nav_menus'   => true,
        'can_export'          => true,
        'has_archive'         => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'query_var'           => 'poster',
        'rewrite'             => $rewrite,
        'capability_type'     => 'post',
    );

    register_post_type( 'rediez_poster', $args );
}

add_action( 'init', 'custom_post_type_poster', 0 );
