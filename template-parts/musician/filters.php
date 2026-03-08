<?php
/**
 * The template for displaying filters musician
 * @package rediez
 */
?>

<aside class="musician-catalog__filters filters">
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
			<input type="number" class="price-range__input" name="price_min" min="0" max="50000" value="0">
			<span class="price-range__currency" style="display: none;">BYN</span>
			</label>
			<span class="price-range__separator">–</span>
			<label class="price-range__label">
			<input type="number" class="price-range__input" name="price_max" min="0" max="50000" value="50000">
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
			</ul>
		</div>

		<!-- Тип исполнителя -->
		<div class="filter-group">
			<h3 class="filter-group__title">Тип исполнителя</h3>
			<ul class="filter-group__list">
				<li class="filter__item">
					<input type="checkbox" id="performer-band" name="performer[]" value="band" class="filter__checkbox">
					<label for="performer-band" class="filter__label">Группа</label>
				</li>
				<li class="filter__item">
					<input type="checkbox" id="performer-solo" name="performer[]" value="solo" class="filter__checkbox">
					<label for="performer-solo" class="filter__label">Сольный артист</label>
				</li>
				<li class="filter__item">
					<input type="checkbox" id="performer-duo" name="performer[]" value="duo" class="filter__checkbox">
					<label for="performer-duo" class="filter__label">Дуэт</label>
				</li>
				<li class="filter__item">
					<input type="checkbox" id="performer-dj" name="performer[]" value="dj" class="filter__checkbox">
					<label for="performer-dj" class="filter__label">DJ</label>
				</li>
				<li class="filter__item">
					<input type="checkbox" id="performer-instrumentalist" name="performer[]" value="instrumentalist" class="filter__checkbox">
					<label for="performer-instrumentalist" class="filter__label">Инструменталист</label>
				</li>
				<li class="filter__item">
					<input type="checkbox" id="performer-session" name="performer[]" value="session" class="filter__checkbox">
					<label for="performer-session" class="filter__label">Сессионный музыкант</label>
				</li>
			</ul>
		</div>

		<!-- Состав -->
		<div class="filter-group">
			<h3 class="filter-group__title">Состав</h3>
			<ul class="filter-group__list">
				<li class="filter__item">
					<input type="checkbox" id="lineup-vocal" name="lineup[]" value="vocal" class="filter__checkbox">
					<label for="lineup-vocal" class="filter__label">Вокал</label>
				</li>
				<li class="filter__item">
					<input type="checkbox" id="lineup-brass" name="lineup[]" value="brass" class="filter__checkbox">
					<label for="lineup-brass" class="filter__label">Духовые</label>
				</li>
				<li class="filter__item">
					<input type="checkbox" id="lineup-strings" name="lineup[]" value="strings" class="filter__checkbox">
					<label for="lineup-strings" class="filter__label">Струнные</label>
				</li>
				<li class="filter__item">
					<input type="checkbox" id="lineup-drums" name="lineup[]" value="drums" class="filter__checkbox">
					<label for="lineup-drums" class="filter__label">Ударные</label>
				</li>
				<li class="filter__item">
					<input type="checkbox" id="lineup-electronic" name="lineup[]" value="electronic" class="filter__checkbox">
					<label for="lineup-electronic" class="filter__label">Электронные</label>
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
					<input type="checkbox" id="travel-yes" name="travel" value="yes" class="filter__checkbox">
					<label for="travel-yes" class="filter__label">Готов к выездам</label>
				</li>
			</ul>
		</div>

		<button class="filters__reset title_link" type="button" onclick="resetFilters()">Сбросить фильтры</button>
</aside>