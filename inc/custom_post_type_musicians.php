<?php

function custom_post_type_musicians() {

    $labels = array(
        'name'                  => 'Музыканты',
        'singular_name'         => 'Портфолио',
        'menu_name'             => 'Музыканты',
        'archives'              => 'Архив портфолио',
        'all_items'             => 'Портфолио музыканта',
        'add_new_item'          => 'Заполните портфолио',
        'add_new'               => 'Добавить нового',
        'new_item'              => 'Новый музыкант',
        'edit_item'             => 'Редактировать портфолио',
        'update_item'           => 'Обновить портфолио',
        'view_item'             => 'Просмотреть',
        'view_items'            => 'Посмотреть всех',
        'search_items'          => 'Поиск портфолио',
        'not_found'             => 'Портфолио не найдены',
        'not_found_in_trash'    => 'В корзине не найдено',
        'featured_image'        => 'Изображение портфолио',
        'set_featured_image'    => 'Загрузить изображение портфолио',
        'remove_featured_image' => 'Удалить изображение портфолио',
        'use_featured_image'    => 'Использовать изображение портфолио',
    );

    $args = array(
        'label'               => 'Музыканты',
        'labels'              => $labels,
        'supports'            => array( 'title', 'thumbnail' ),
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'menu_position'       => 6,
        'menu_icon'           => 'dashicons-microphone',
        'show_in_admin_bar'   => true,
        'show_in_nav_menus'   => true,
        'can_export'          => true,
        'has_archive'         => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'query_var'           => 'musicians',
        'rewrite'             => array(
            'slug'       => 'musicians',
            'with_front' => true,
            'pages'      => true,
        ),
        'capability_type'     => array( 'musician_post', 'musician_posts' ),
        'map_meta_cap'        => true,
    );

    register_post_type( 'rediez_musicians', $args );
}
add_action( 'init', 'custom_post_type_musicians', 0 );