// AJAX ФИЛЬТРЫ МЕРОПРИЯТИЙ

document.addEventListener('DOMContentLoaded', function () {

    const filtersForm    = document.querySelector('.events-catalog__filters');
    const resultsGrid    = document.querySelector('.events-catalog__items');
    const controlsWrap   = document.querySelector('.events-catalog__controls');
    const paginationWrap = document.querySelector('.events-catalog__pagination');

    if (!filtersForm || !resultsGrid) return;

    let filterTimeout = null;

    // Собираем параметры фильтров
    function collectParams(paged) {
        const params = new FormData();

        params.append('action', 'filter_events');
        params.append('nonce',  rediez_events_filters.nonce);
        params.append('paged',  paged || 1);

        // Чекбоксы
        ['event', 'format', 'genre', 'location', 'duration', 'conditions'].forEach(function (group) {
            filtersForm.querySelectorAll('input[name="' + group + '[]"]:checked').forEach(function (cb) {
                params.append(group + '[]', cb.value);
            });
        });

        // Оплата дороги
        const paymentCb = filtersForm.querySelector('input[name="payment"]:checked');
        if (paymentCb) params.append('payment', paymentCb.value);

        // Цена
        const priceMin = filtersForm.querySelector('input[name="price_min"]');
        const priceMax = filtersForm.querySelector('input[name="price_max"]');
        if (priceMin) params.append('price_min', priceMin.value);
        if (priceMax) params.append('price_max', priceMax.value);

        // Сортировка и поиск
        if (controlsWrap) {
            const sortSelect  = controlsWrap.querySelector('#events-sort');
            const searchInput = controlsWrap.querySelector('#events-search-input');
            if (sortSelect)  params.append('sort',   sortSelect.value);
            if (searchInput) params.append('search', searchInput.value.trim());
        }

        return params;
    }

    // AJAX-запрос
    function doFilter(paged) {
        resultsGrid.classList.add('is-loading');

        fetch(rediez_events_filters.ajax_url, {
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
            console.error('Events filter error:', err);
        })
        .finally(function () {
            resultsGrid.classList.remove('is-loading');
        });
    }

    // Пагинация — та же структура что в pagination.php
    function renderPagination(maxPages, currentPage) {
        if (!paginationWrap) return;

        if (maxPages <= 1) {
            paginationWrap.innerHTML = '';
            return;
        }

        const arrowPrev = '<svg class="pagination__icon" width="16" height="16" viewBox="0 0 16 16" fill="none"><path d="M10 12L6 8L10 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>';
        const arrowNext = '<svg class="pagination__icon" width="16" height="16" viewBox="0 0 16 16" fill="none"><path d="M6 4L10 8L6 12" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>';

        const pages = getPageRange(currentPage, maxPages);

        let html = '<div class="pagination">';

        if (currentPage > 1) {
            html += '<button class="pagination__arrow pagination__arrow--prev" data-page="' + (currentPage - 1) + '" aria-label="Предыдущая страница">' + arrowPrev + '</button>';
        }

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

        if (currentPage < maxPages) {
            html += '<button class="pagination__arrow pagination__arrow--next" data-page="' + (currentPage + 1) + '" aria-label="Следующая страница">' + arrowNext + '</button>';
        }

        html += '</div>';
        paginationWrap.innerHTML = html;

        paginationWrap.querySelectorAll('button[data-page]').forEach(function (btn) {
            btn.addEventListener('click', function () {
                doFilter(parseInt(this.dataset.page));
                resultsGrid.scrollIntoView({ behavior: 'smooth', block: 'start' });
            });
        });
    }

    function getPageRange(current, total) {
        const pages  = [];
        const delta  = 1;
        const end    = 1;
        let ranges   = new Set();

        for (let i = 1; i <= Math.min(end, total); i++) ranges.add(i);
        for (let i = Math.max(1, total - end + 1); i <= total; i++) ranges.add(i);
        for (let i = Math.max(1, current - delta); i <= Math.min(total, current + delta); i++) ranges.add(i);

        const sorted = Array.from(ranges).sort(function (a, b) { return a - b; });
        sorted.forEach(function (page, idx) {
            if (idx > 0 && page - sorted[idx - 1] > 1) pages.push('...');
            pages.push(page);
        });

        return pages;
    }

    // Слушатели событий

    // Чекбоксы
    filtersForm.addEventListener('change', function (e) {
        if (e.target.matches('input[type="checkbox"]')) {
            clearTimeout(filterTimeout);
            filterTimeout = setTimeout(function () { doFilter(1); }, 300);
        }
    });

    // Ползунок цены
    filtersForm.addEventListener('input', function (e) {
        if (e.target.matches('input[name="price_min"]') || e.target.matches('input[name="price_max"]')) {
            clearTimeout(filterTimeout);
            filterTimeout = setTimeout(function () { doFilter(1); }, 600);
        }
    });

    // Сортировка
    if (controlsWrap) {
        const sortSelect = controlsWrap.querySelector('#events-sort');
        if (sortSelect) {
            sortSelect.addEventListener('change', function () { doFilter(1); });
        }

        // Поиск
        const searchBtn   = controlsWrap.querySelector('.search-section__btn');
        const searchInput = controlsWrap.querySelector('#events-search-input');
        if (searchBtn && searchInput) {
            searchBtn.addEventListener('click', function () { doFilter(1); });
            searchInput.addEventListener('keydown', function (e) {
                if (e.key === 'Enter') doFilter(1);
            });
        }
    }

    // Сброс фильтров
    const resetBtn = filtersForm.querySelector('.filters__reset');
    if (resetBtn) {
        resetBtn.addEventListener('click', function () {
            filtersForm.querySelectorAll('input[type="checkbox"]').forEach(function (cb) {
                cb.checked = false;
            });

            const priceMin = filtersForm.querySelector('input[name="price_min"]');
            const priceMax = filtersForm.querySelector('input[name="price_max"]');
            if (priceMin) { priceMin.value = priceMin.min || 0;       priceMin.dispatchEvent(new Event('input', { bubbles: true })); }
            if (priceMax) { priceMax.value = priceMax.max || 100000;  priceMax.dispatchEvent(new Event('input', { bubbles: true })); }

            doFilter(1);
        });
    }

    // Инициализация
    doFilter(1);

});