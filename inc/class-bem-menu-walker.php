<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Rediez_Bem_Menu_Walker extends Walker_Nav_Menu {

    // 1. Начало элемента <li>
    public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
        
        // Проверяем, активен ли пункт (для добавления класса active ссылке)
        $is_active = in_array( 'current-menu-item', $item->classes ) || in_array( 'current-menu-parent', $item->classes );

        // Формируем <li>. Никаких лишних ID и классов WP, только твой BEM.
        $output .= '<li class="nav-menu__item">';

        // Собираем атрибуты для ссылки <a>
        $atts = array();
        $atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
        $atts['target'] = ! empty( $item->target )     ? $item->target     : '';
        $atts['rel']    = ! empty( $item->xfn )        ? $item->xfn        : '';
        $atts['href']   = ! empty( $item->url )        ? $item->url        : '';
        
        // Добавляем active, если это текущая страница
        $atts['class'] = 'nav-menu__link';
        if ( $is_active ) {
            $atts['class'] .= ' active';
        }

        // Превращаем массив атрибутов в строку HTML
        $attributes = '';
        foreach ( $atts as $attr => $value ) {
            if ( ! empty( $value ) ) {
                $attributes .= ' ' . $attr . '="' . $value . '"';
            }
        }

        // Формируем сам тег <a> и текст внутри
        $title = apply_filters( 'the_title', $item->title, $item->ID );

        $item_output = '<a' . $attributes . '>';
        $item_output .= $title;
        $item_output .= '</a>';

        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    }

    // 2. Конец элемента </li>
    public function end_el( &$output, $item, $depth = 0, $args = null ) {
        $output .= '</li>';
    }
}