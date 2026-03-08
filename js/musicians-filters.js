// AJAX ФИЛЬТРЫ МУЗЫКАНТОВ

document.addEventListener('DOMContentLoaded', function () {

    const filtersForm  = document.querySelector('.musician-catalog__filters');
    const resultsGrid  = document.querySelector('.musicians-catalog__items');
    const controlsForm = document.getElementById('musician-controls-form');
    const paginationWrap = document.querySelector('.musicians-catalog__pagination');

    if (!filtersForm || !resultsGrid) return;

    let filterTimeout = null;

    // ----------------------------------------
    // Собираем все параметры фильтров
    // ----------------------------------------
    function collectParams(paged) {
        const params = new FormData();

        params.append('action', 'filter_musicians');
        params.append('nonce',  rediez_filters.nonce);
        params.append('paged',  paged || 1);

        // Чекбоксы
        ['event', 'format', 'genre', 'performer', 'lineup', 'location'].forEach(function (group) {
            filtersForm.querySelectorAll('input[name="' + group + '[]"]:checked').forEach(function (cb) {
                params.append(group + '[]', cb.value);
            });
        });

        // Готовность к выездам
        const travelCb = filtersForm.querySelector('input[name="travel"]:checked');
        if (travelCb) params.append('travel', travelCb.value);

        // Цена
        const priceMin = filtersForm.querySelector('input[name="price_min"]');
        const priceMax = filtersForm.querySelector('input[name="price_max"]');
        if (priceMin) params.append('price_min', priceMin.value);
        if (priceMax) params.append('price_max', priceMax.value);

        // Сортировка и поиск из controls
        if (controlsForm) {
            const sortSelect  = controlsForm.querySelector('#sort');
            const searchInput = controlsForm.querySelector('#search-input');
            if (sortSelect)  params.append('sort',   sortSelect.value);
            if (searchInput) params.append('search', searchInput.value.trim());
        }

        return params;
    }

    // ----------------------------------------
    // AJAX-запрос
    // ----------------------------------------
    function doFilter(paged) {
        resultsGrid.classList.add('is-loading');

        fetch(rediez_filters.ajax_url, {
            method: 'POST',
            body: collectParams(paged),
        })
        .then(function (res) { return res.json(); })
        .then(function (data) {
            if (!data.success) return;

            resultsGrid.innerHTML = data.data.html;
            renderPagination(data.data.max_pages, parseInt(data.data.paged));
        })
        .catch(function (err) {
            console.error('Filter error:', err);
        })
        .finally(function () {
            resultsGrid.classList.remove('is-loading');
        });
    }

    // ----------------------------------------
    // Пагинация — повторяем структуру pagination.php
    // .pagination
    //   .pagination__arrow--prev
    //   .pagination__pages
    //     .pagination__page / .pagination__page--active / .pagination__dots
    //   .pagination__arrow--next
    // ----------------------------------------
    function renderPagination(maxPages, currentPage) {
        if (!paginationWrap) return;

        if (maxPages <= 1) {
            paginationWrap.innerHTML = '';
            return;
        }

        const arrowPrev = '<svg class="pagination__icon" width="16" height="16" viewBox="0 0 16 16" fill="none"><path d="M10 12L6 8L10 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>';
        const arrowNext = '<svg class="pagination__icon" width="16" height="16" viewBox="0 0 16 16" fill="none"><path d="M6 4L10 8L6 12" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>';

        // Считаем какие страницы показывать (mid_size=1, end_size=1 — как в PHP)
        const pages = getPageRange(currentPage, maxPages);

        let html = '<div class="pagination">';

        // Стрелка назад
        if (currentPage > 1) {
            html += '<button class="pagination__arrow pagination__arrow--prev" data-page="' + (currentPage - 1) + '" aria-label="Предыдущая страница">' + arrowPrev + '</button>';
        }

        // Страницы
        html += '<div class="pagination__pages">';
        pages.forEach(function (page) {
            if (page === '...') {
                html += '<span class="pagination__dots">...</span>';
            } else if (page === currentPage) {
                html += '<span class="pagination__page pagination__page--active">' + page + '</span>';
            } else {
                html += '<button class="pagination__page" data-page="' + page + '">' + page + '</button>';
            }
        });
        html += '</div>';

        // Стрелка вперёд
        if (currentPage < maxPages) {
            html += '<button class="pagination__arrow pagination__arrow--next" data-page="' + (currentPage + 1) + '" aria-label="Следующая страница">' + arrowNext + '</button>';
        }

        html += '</div>';

        paginationWrap.innerHTML = html;

        // Клики по страницам
        paginationWrap.querySelectorAll('button[data-page]').forEach(function (btn) {
            btn.addEventListener('click', function () {
                doFilter(parseInt(this.dataset.page));
                resultsGrid.scrollIntoView({ behavior: 'smooth', block: 'start' });
            });
        });
    }

    // Алгоритм диапазона страниц (end_size=1, mid_size=1 — как paginate_links в PHP)
    function getPageRange(current, total) {
        const pages = [];
        const delta = 1; // mid_size
        const end   = 1; // end_size

        let ranges = new Set();

        // Первые страницы (end_size)
        for (let i = 1; i <= Math.min(end, total); i++) ranges.add(i);
        // Последние страницы (end_size)
        for (let i = Math.max(1, total - end + 1); i <= total; i++) ranges.add(i);
        // Страницы вокруг текущей (mid_size)
        for (let i = Math.max(1, current - delta); i <= Math.min(total, current + delta); i++) ranges.add(i);

        const sorted = Array.from(ranges).sort(function (a, b) { return a - b; });

        sorted.forEach(function (page, idx) {
            if (idx > 0 && page - sorted[idx - 1] > 1) pages.push('...');
            pages.push(page);
        });

        return pages;
    }

    // ----------------------------------------
    // Слушатели событий
    // ----------------------------------------

    // Чекбоксы фильтров
    filtersForm.addEventListener('change', function (e) {
        if (e.target.matches('input[type="checkbox"]')) {
            clearTimeout(filterTimeout);
            filterTimeout = setTimeout(function () { doFilter(1); }, 300);
        }
    });

    // Ползунок цены (price-range.js меняет input[name="price_min/max"])
    filtersForm.addEventListener('input', function (e) {
        if (e.target.matches('input[name="price_min"]') || e.target.matches('input[name="price_max"]')) {
            clearTimeout(filterTimeout);
            filterTimeout = setTimeout(function () { doFilter(1); }, 600);
        }
    });

    // Сортировка
    if (controlsForm) {
        const sortSelect = controlsForm.querySelector('#sort');
        if (sortSelect) {
            sortSelect.addEventListener('change', function () { doFilter(1); });
        }

        // Поиск — перехватываем submit формы
        controlsForm.addEventListener('submit', function (e) {
            e.preventDefault();
            doFilter(1);
        });
    }

    // Сброс фильтров
    const resetBtn = filtersForm.querySelector('.filters__reset');
    if (resetBtn) {
        resetBtn.addEventListener('click', function () {
            // Снимаем чекбоксы
            filtersForm.querySelectorAll('input[type="checkbox"]').forEach(function (cb) {
                cb.checked = false;
            });

            // Сбрасываем цену — диспатчим событие, чтобы price-range.js обновил ползунок
            const priceMin = filtersForm.querySelector('input[name="price_min"]');
            const priceMax = filtersForm.querySelector('input[name="price_max"]');
            if (priceMin) { priceMin.value = priceMin.min || 0;         priceMin.dispatchEvent(new Event('input', { bubbles: true })); }
            if (priceMax) { priceMax.value = priceMax.max || 50000;    priceMax.dispatchEvent(new Event('input', { bubbles: true })); }

            doFilter(1);
        });
    }
	
	doFilter(1);
});