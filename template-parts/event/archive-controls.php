<?php
/**
 * Контролы архива мероприятий (сортировка и поиск)
 *
 * @package rediez
 */

$current_sort   = isset( $_GET['sort'] ) ? sanitize_text_field( $_GET['sort'] ) : '';
$current_search = get_search_query();
$icon_path      = get_template_directory_uri() . '/assets/images/icons/';
?>

<section class="events-catalog__controls controls">
    <div class="events-catalog__controls-inner controls__inner">

        <div class="events-catalog__sort controls__sort">
            <span class="controls__sort-icon">
                <img src="<?php echo esc_url( $icon_path . 'sort.svg' ); ?>" alt="">
            </span>
            <span class="controls__sort-label"><?php esc_html_e( 'Сортировать:', 'rediez' ); ?></span>

            <div class="controls__sort-select">
                <select name="sort" id="events-sort" class="controls__sort-input">
                    <option value="" <?php selected( $current_sort, '' ); ?>>
                        <?php esc_html_e( 'Сначала новые', 'rediez' ); ?>
                    </option>
                    <option value="oldest" <?php selected( $current_sort, 'oldest' ); ?>>
                        <?php esc_html_e( 'Сначала старые', 'rediez' ); ?>
                    </option>
                    <option value="price_asc" <?php selected( $current_sort, 'price_asc' ); ?>>
                        <?php esc_html_e( 'Цена: по возрастанию', 'rediez' ); ?>
                    </option>
                    <option value="price_desc" <?php selected( $current_sort, 'price_desc' ); ?>>
                        <?php esc_html_e( 'Цена: по убыванию', 'rediez' ); ?>
                    </option>
                </select>
            </div>
        </div>

        <div class="search-section">
            <input
                type="text"
                class="search-section__input"
                id="events-search-input"
                placeholder="<?php esc_attr_e( 'Поиск по названию', 'rediez' ); ?>"
                value="<?php echo esc_attr( $current_search ); ?>"
            >
            <button type="button" class="search-section__btn" aria-label="<?php esc_attr_e( 'Найти', 'rediez' ); ?>">
                <img src="<?php echo esc_url( $icon_path . 'search.svg' ); ?>" alt="">
            </button>
        </div>

        <div class="events-catalog__filter filter">
            <button type="button" class="filter__btn">
                <div class="filter__wrap">
                    <span class="filter__btn-icon">
                        <img src="<?php echo esc_url( $icon_path . 'filter.svg' ); ?>" alt="">
                    </span>
                    <span class="filter__btn-text"><?php esc_html_e( 'Фильтры', 'rediez' ); ?></span>
                </div>
            </button>
        </div>

    </div>
</section>