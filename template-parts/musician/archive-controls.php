<?php
/**
 * Контролы архива музыкантов (сортировка и поиск)
 *
 * @package rediez
 */

// Получаем текущие значения из URL
$current_sort = isset( $_GET['sort'] ) ? sanitize_text_field( $_GET['sort'] ) : '';
$current_search = get_search_query();

// Путь к иконкам
$icon_path = get_template_directory_uri() . '/assets/images/icons/';
?>

<section class="musician-catalog__controls controls">
    <div class="musician-catalog__controls-inner controls__inner">
        
        <form method="get" action="<?php echo esc_url( get_post_type_archive_link( 'rediez_musicians' ) ); ?>" class="controls__form" id="musician-controls-form">
            
            <!-- Сортировка -->
            <div class="controls__sort">
                <span class="controls__sort-icon">
                    <img src="<?php echo esc_url( $icon_path . 'sort.svg' ); ?>" alt="">
                </span>
                <span class="controls__sort-label"><?php esc_html_e( 'Сортировать:', 'rediez' ); ?></span>
                
                <div class="controls__sort-select">
                    <select name="sort" id="sort" class="controls__sort-input">
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
            
            <!-- Поиск -->
            <div class="search-section">
                <input 
                    type="text" 
                    class="search-section__input" 
                    id="search-input"
                    placeholder="<?php esc_attr_e( 'Поиск по названию', 'rediez' ); ?>"
                    name="s"
                    value="<?php echo esc_attr( $current_search ); ?>"
                >
                <button type="submit" class="search-section__btn" aria-label="<?php esc_attr_e( 'Найти', 'rediez' ); ?>">
                    <img src="<?php echo esc_url( $icon_path . 'search.svg' ); ?>" alt="">
                </button>
            </div>
            
            <!-- Кнопка фильтров (мобильная) - пока неактивна -->
            <div class="musician-catalog__filter filter">
                <button type="button" class="filter__btn">
                    <div class="filter__wrap">
                        <span class="filter__btn-icon">
                            <img src="<?php echo esc_url( $icon_path . 'filter.svg' ); ?>" alt="">
                        </span>
                        <span class="filter__btn-text"><?php esc_html_e( 'Фильтры', 'rediez' ); ?></span>
                    </div>
                </button>
            </div>
            
        </form>
        
    </div>
</section>

<script>
(function() {
    const form = document.getElementById('musician-controls-form');
    const sortSelect = document.getElementById('sort');
    const searchInput = document.getElementById('search-input');
    
    if (form && sortSelect && searchInput) {
        
        // При изменении сортировки
        sortSelect.addEventListener('change', function() {
            
            // Если поле поиска пустое - убираем атрибут name
            if (searchInput.value.trim() === '') {
                searchInput.removeAttribute('name');
            }
            
        });
        
        // При отправке формы через кнопку поиска
        form.addEventListener('submit', function(e) {
            
            // Если поле поиска пустое - предотвращаем отправку
            if (searchInput.value.trim() === '') {
                searchInput.removeAttribute('name');
                
                // Если также не выбрана сортировка - не отправляем форму вообще
                if (!sortSelect.value) {
                    e.preventDefault();
                    return false;
                }
            }
        });
    }
})();
</script>