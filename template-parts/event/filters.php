<?php
/**
 * The template for displaying filters event
 * @package rediez
 */
?>

<aside class="events-catalog__filters filters">
	<div class="filters__close">
		<button class="filters__btn return">
			<span class="return__icon">
				<img src="img/Icon/arrrow-left.svg" alt="">
			</span>
			<span class="return__title">Назад</span>
		</button>
	</div>
	<h2 class="filters__title">Фильтры</h2>

		<!-- Цена -->
	<div class="filter-group filter-group--price">
		<h3 class="filter-group__title">Цена в BYN</h3>
		<div class="price-range">
		<div class="price-range__inputs">
			<label class="price-range__label">
			<input type="number" class="price-range__input" name="price_min" min="0" max="100000" value="0">
			<span class="price-range__currency" style="display: none;">BYN</span>
			</label>
			<span class="price-range__separator">–</span>
			<label class="price-range__label">
			<input type="number" class="price-range__input" name="price_max" min="0" max="100000" value="100000">
			<span class="price-range__currency" style="display: none;">BYN</span>
			</label>
		</div>
		<div class="price-range__slider" id="price-slider"></div>
		</div>
	</div>

	<!-- Тип события -->
	<div class="filter-group">
		<h3 class="filter-group__title">Тип события</h3>
		<ul class="filter-group__list">
			<li class="filter__item">
				<input type="checkbox" id="event-wedding" name="event[]" value="wedding" class="filter__checkbox">
				<label for="event-wedding" class="filter__label">Свадьба</label>
			</li>
			<li class="filter__item">
				<input type="checkbox" id="event-corporate" name="event[]" value="corporate" class="filter__checkbox">
				<label for="event-corporate" class="filter__label">Корпоратив</label>
			</li>
			<li class="filter__item">
				<input type="checkbox" id="event-anniversary" name="event[]" value="anniversary" class="filter__checkbox">
				<label for="event-anniversary" class="filter__label">Юбилей</label>
			</li>
			<li class="filter__item">
				<input type="checkbox" id="event-kids" name="event[]" value="kids" class="filter__checkbox">
				<label for="event-kids" class="filter__label">Детский праздник</label>
			</li>
			<li class="filter__item">
				<input type="checkbox" id="event-restaurant" name="event[]" value="restaurant" class="filter__checkbox">
				<label for="event-restaurant" class="filter__label">Ресторан</label>
			</li>
			<li class="filter__item">
				<input type="checkbox" id="event-club" name="event[]" value="club" class="filter__checkbox">
				<label for="event-club" class="filter__label">Клуб</label>
			</li>
			<li class="filter__item">
				<input type="checkbox" id="event-festival" name="event[]" value="festival" class="filter__checkbox">
				<label for="event-festival" class="filter__label">Фестиваль</label>
			</li>
			<li class="filter__item">
				<input type="checkbox" id="event-official" name="event[]" value="official" class="filter__checkbox">
				<label for="event-official" class="filter__label">Официальные мероприятия</label>
			</li>
			<li class="filter__item">
				<input type="checkbox" id="event-studio" name="event[]" value="studio" class="filter__checkbox">
				<label for="event-studio" class="filter__label">Студийная запись</label>
			</li>
		</ul>
	</div>

	<!-- Формат выступления -->
	<div class="filter-group">
		<h3 class="filter-group__title">Формат выступления</h3>
		<ul class="filter-group__list">
			<li class="filter__item">
				<input type="checkbox" id="format-covers" name="format[]" value="covers" class="filter__checkbox">
				<label for="format-covers" class="filter__label">Каверы</label>
			</li>
			<li class="filter__item">
				<input type="checkbox" id="format-original" name="format[]" value="original" class="filter__checkbox">
				<label for="format-original" class="filter__label">Авторские песни</label>
			</li>
			<li class="filter__item">
				<input type="checkbox" id="format-instrumental" name="format[]" value="instrumental" class="filter__checkbox">
				<label for="format-instrumental" class="filter__label">Инструментал</label>
			</li>
			<li class="filter__item">
				<input type="checkbox" id="format-dj" name="format[]" value="dj_set" class="filter__checkbox">
				<label for="format-dj" class="filter__label">DJ-сет</label>
			</li>
			<li class="filter__item">
				<input type="checkbox" id="format-background" name="format[]" value="background" class="filter__checkbox">
				<label for="format-background" class="filter__label">Фон (background)</label>
			</li>
			<li class="filter__item">
				<input type="checkbox" id="format-live" name="format[]" value="live" class="filter__checkbox">
				<label for="format-live" class="filter__label">Живой звук</label>
			</li>
			<li class="filter__item">
				<input type="checkbox" id="format-recording" name="format[]" value="recording" class="filter__checkbox">
				<label for="format-recording" class="filter__label">Запись в студии</label>
			</li>
		</ul>
	</div>

	<!-- Жанр -->
	<div class="filter-group">
		<h3 class="filter-group__title">Жанр</h3>
		<ul class="filter-group__list">
			<li class="filter__item">
				<input type="checkbox" id="genre-pop" name="genre[]" value="pop" class="filter__checkbox">
				<label for="genre-pop" class="filter__label">Поп</label>
			</li>
			<li class="filter__item">
				<input type="checkbox" id="genre-rock" name="genre[]" value="rock" class="filter__checkbox">
				<label for="genre-rock" class="filter__label">Рок</label>
			</li>
			<li class="filter__item">
				<input type="checkbox" id="genre-jazz" name="genre[]" value="jazz" class="filter__checkbox">
				<label for="genre-jazz" class="filter__label">Джаз</label>
			</li>
			<li class="filter__item">
				<input type="checkbox" id="genre-rap" name="genre[]" value="rap" class="filter__checkbox">
				<label for="genre-rap" class="filter__label">Рэп</label>
			</li>
			<li class="filter__item">
				<input type="checkbox" id="genre-electronic" name="genre[]" value="electronic" class="filter__checkbox">
				<label for="genre-electronic" class="filter__label">Электронная</label>
			</li>
			<li class="filter__item">
				<input type="checkbox" id="genre-classical" name="genre[]" value="classical" class="filter__checkbox">
				<label for="genre-classical" class="filter__label">Классика</label>
			</li>
			<li class="filter__item">
				<input type="checkbox" id="genre-folk" name="genre[]" value="folk" class="filter__checkbox">
				<label for="genre-folk" class="filter__label">Народная</label>
			</li>
			<li class="filter__item">
				<input type="checkbox" id="genre-lounge" name="genre[]" value="lounge" class="filter__checkbox">
				<label for="genre-lounge" class="filter__label">Лаунж</label>
			</li>
			<li class="filter__item">
				<input type="checkbox" id="genre-retro" name="genre[]" value="retro" class="filter__checkbox">
				<label for="genre-retro" class="filter__label">Ретро</label>
			</li>
		</ul>
	</div>

	<!-- Локация -->
	<div class="filter-group">
		<h3 class="filter-group__title">Локация</h3>
		<ul class="filter-group__list">
			<li class="filter__item">
				<input type="checkbox" id="location-minsk" name="location[]" value="minsk" class="filter__checkbox">
				<label for="location-minsk" class="filter__label">Минск</label>
			</li>
			<li class="filter__item">
				<input type="checkbox" id="location-brest" name="location[]" value="brest" class="filter__checkbox">
				<label for="location-brest" class="filter__label">Брест</label>
			</li>
			<li class="filter__item">
				<input type="checkbox" id="location-vitebsk" name="location[]" value="vitebsk" class="filter__checkbox">
				<label for="location-vitebsk" class="filter__label">Витебск</label>
			</li>
			<li class="filter__item">
				<input type="checkbox" id="location-gomel" name="location[]" value="gomel" class="filter__checkbox">
				<label for="location-gomel" class="filter__label">Гомель</label>
			</li>
			<li class="filter__item">
				<input type="checkbox" id="location-grodno" name="location[]" value="grodno" class="filter__checkbox">
				<label for="location-grodno" class="filter__label">Гродно</label>
			</li>
			<li class="filter__item">
				<input type="checkbox" id="location-mogilev" name="location[]" value="mogilev" class="filter__checkbox">
				<label for="location-mogilev" class="filter__label">Могилёв</label>
			</li>
			<li class="filter__item filter__item--separator">
				<input type="checkbox" id="payment-yes" name="payment" value="yes" class="filter__checkbox">
				<label for="payment-yes" class="filter__label">Оплата дороги / готовы оплачивать выезд</label>
			</li>
		</ul>
	</div>

	<!-- Продолжительность выступления -->
	<div class="filter-group">
		<h3 class="filter-group__title">Продолжительность выступления</h3>
		<ul class="filter-group__list">
			<li class="filter__item">
				<input type="checkbox" id="duration-halfhour" name="duration[]" value="half-hour" class="filter__checkbox">
				<label for="duration-halfhour" class="filter__label">До 30 минут</label>
			</li>
			<li class="filter__item">
				<input type="checkbox" id="duration-hour" name="duration[]" value="hour" class="filter__checkbox">
				<label for="duration-hour" class="filter__label">1 час</label>
			</li>
			<li class="filter__item">
				<input type="checkbox" id="duration-twohours" name="duration[]" value="two-hours" class="filter__checkbox">
				<label for="duration-twohours" class="filter__label">2 часа</label>
			</li>
			<li class="filter__item">
				<input type="checkbox" id="duration-manyhours" name="duration[]" value="many-hours" class="filter__checkbox">
				<label for="duration-manyhours" class="filter__label">Более 2 часов</label>
			</li>
		</ul>
	</div>

	<!-- Условия -->
	<div class="filter-group">
		<h3 class="filter-group__title">Условия</h3>
		<ul class="filter-group__list">
			<li class="filter__item">
				<input type="checkbox" id="conditions-payment" name="conditions[]" value="payment" class="filter__checkbox">
				<label for="conditions-payment" class="filter__label">Оплата по договоренности</label>
			</li>
			<li class="filter__item">
				<input type="checkbox" id="conditions-equipment" name="conditions[]" value="equipment" class="filter__checkbox">
				<label for="conditions-equipment" class="filter__label">Нужна своя аппаратура</label>
			</li>
			<li class="filter__item">
				<input type="checkbox" id="conditions-organizer" name="conditions[]" value="organizer" class="filter__checkbox">
				<label for="conditions-organizer" class="filter__label">Аппаратура организатора</label>
			</li>
			<li class="filter__item">
				<input type="checkbox" id="conditions-cashless" name="conditions[]" value="cashless" class="filter__checkbox">
				<label for="conditions-cashless" class="filter__label">Контракт / безналичный расчёт</label>
			</li>
			<li class="filter__item">
				<input type="checkbox" id="conditions-interaction" name="conditions[]" value="interaction" class="filter__checkbox">
				<label for="conditions-interaction" class="filter__label">Нужен интерактив с публикой</label>
			</li>
		</ul>
	</div>

	<button class="filters__reset title_link" type="button" onclick="resetFilters()">Сбросить фильтры</button>
</aside>