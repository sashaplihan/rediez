// ДВОЙНОЙ ПОЛЗУНОК ЦЕНЫ
// ========================================

document.addEventListener('DOMContentLoaded', function() {
  
  // Получаем элементы
  const priceSlider = document.getElementById('price-slider');
  const priceInputMin = document.querySelector('input[name="price_min"]');
  const priceInputMax = document.querySelector('input[name="price_max"]');
  
  if (!priceSlider || !priceInputMin || !priceInputMax) {
    console.warn('Элементы ползунка цены не найдены');
    return;
  }

  const MIN = parseInt(priceInputMin.min) || 0;
  const MAX = parseInt(priceInputMax.max) || 100000;
  const STEP = 100; // Шаг изменения
  const GAP = 500; // Минимальный разрыв между значениями

  // Создаем элементы ползунка
  const progressBar = document.createElement('div');
  progressBar.className = 'price-range__progress';
  
  const rangeMin = document.createElement('input');
  rangeMin.type = 'range';
  rangeMin.min = MIN;
  rangeMin.max = MAX;
  rangeMin.step = STEP;
  rangeMin.value = priceInputMin.value;
  
  const rangeMax = document.createElement('input');
  rangeMax.type = 'range';
  rangeMax.min = MIN;
  rangeMax.max = MAX;
  rangeMax.step = STEP;
  rangeMax.value = priceInputMax.value;

  // Добавляем в DOM
  priceSlider.appendChild(progressBar);
  priceSlider.appendChild(rangeMin);
  priceSlider.appendChild(rangeMax);

  // Функция обновления прогресс-бара
  function updateProgress() {
    const minVal = parseInt(rangeMin.value);
    const maxVal = parseInt(rangeMax.value);
    
    const percentMin = ((minVal - MIN) / (MAX - MIN)) * 100;
    const percentMax = ((maxVal - MIN) / (MAX - MIN)) * 100;
    
    progressBar.style.left = percentMin + '%';
    progressBar.style.width = (percentMax - percentMin) + '%';
  }

  // Форматирование числа с пробелами
  function formatNumber(num) {
    return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ' ');
  }

  // Обработчик минимального ползунка
  rangeMin.addEventListener('input', function() {
    let minVal = parseInt(this.value);
    let maxVal = parseInt(rangeMax.value);
    
    // Проверяем минимальный разрыв
    if (maxVal - minVal < GAP) {
      minVal = maxVal - GAP;
      this.value = minVal;
    }
    
    priceInputMin.value = minVal;
	priceInputMin.dispatchEvent(new Event('input', { bubbles: true }));
    updateProgress();
  });

  // Обработчик максимального ползунка
  rangeMax.addEventListener('input', function() {
    let maxVal = parseInt(this.value);
    let minVal = parseInt(rangeMin.value);
    
    // Проверяем минимальный разрыв
    if (maxVal - minVal < GAP) {
      maxVal = minVal + GAP;
      this.value = maxVal;
    }
    
    priceInputMax.value = maxVal;
	priceInputMax.dispatchEvent(new Event('input', { bubbles: true }));
    updateProgress();
  });

  // Обработчик инпута минимальной цены
  priceInputMin.addEventListener('input', function() {
    let minVal = parseInt(this.value) || MIN;
    let maxVal = parseInt(priceInputMax.value);
    
    // Валидация
    if (minVal < MIN) minVal = MIN;
    if (minVal > MAX - GAP) minVal = MAX - GAP;
    if (maxVal - minVal < GAP) minVal = maxVal - GAP;
    
    this.value = minVal;
    rangeMin.value = minVal;
    updateProgress();
  });

  // Обработчик инпута максимальной цены
  priceInputMax.addEventListener('input', function() {
    let maxVal = parseInt(this.value) || MAX;
    let minVal = parseInt(priceInputMin.value);
    
    // Валидация
    if (maxVal > MAX) maxVal = MAX;
    if (maxVal < MIN + GAP) maxVal = MIN + GAP;
    if (maxVal - minVal < GAP) maxVal = minVal + GAP;
    
    this.value = maxVal;
    rangeMax.value = maxVal;
    updateProgress();
  });

  // Форматирование при потере фокуса
  priceInputMin.addEventListener('blur', function() {
    let val = parseInt(this.value) || MIN;
    if (val < MIN) val = MIN;
    if (val > MAX) val = MAX;
    this.value = val;
    rangeMin.value = val;
    updateProgress();
  });

  priceInputMax.addEventListener('blur', function() {
    let val = parseInt(this.value) || MAX;
    if (val < MIN) val = MIN;
    if (val > MAX) val = MAX;
    this.value = val;
    rangeMax.value = val;
    updateProgress();
  });

  // Инициализация
  updateProgress();

});