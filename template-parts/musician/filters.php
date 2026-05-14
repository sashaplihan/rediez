<?php
/**
 * The template for displaying filters musician
 * @package rediez
 */

$icon_path = get_template_directory_uri() . '/assets/images/icons/';
?>

<aside class="musician-catalog__filters filters">
	<div class="filters__close">
		<button class="filters__btn return">
			<span class="return__icon">
				<img src="<?php echo esc_url( $icon_path . 'arrrow-left.svg' ); ?>" alt="arrrow left">
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
					<input type="number" class="price-range__input" name="price_min" min="0" max="10000" value="0">
					<span class="price-range__currency" style="display: none;">BYN</span>
				</label>
				<span class="price-range__separator">–</span>
				<label class="price-range__label">
					<input type="number" class="price-range__input" name="price_max" min="0" max="10000" value="10000">
					<span class="price-range__currency" style="display: none;">BYN</span>
				</label>
			</div>
			<div class="price-range__slider" id="price-slider"></div>
		</div>
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
				<input type="checkbox" id="performer-session" name="performer[]" value="session" class="filter__checkbox">
				<label for="performer-session" class="filter__label">Сессионный музыкант</label>
			</li>
			<li class="filter__item">
				<input type="checkbox" id="performer-vocalist" name="performer[]" value="vocalist" class="filter__checkbox">
				<label for="performer-vocalist" class="filter__label">Вокалист</label>
			</li>
			<li class="filter__item">
				<input type="checkbox" id="performer-instrumentalist" name="performer[]" value="instrumentalist" class="filter__checkbox">
				<label for="performer-instrumentalist" class="filter__label">Инструменталист</label>
			</li>
			<li class="filter__item">
				<input type="checkbox" id="performer-duo" name="performer[]" value="duo" class="filter__checkbox">
				<label for="performer-duo" class="filter__label">Дуэт</label>
			</li>
			<li class="filter__item">
				<input type="checkbox" id="performer-trio" name="performer[]" value="trio" class="filter__checkbox">
				<label for="performer-trio" class="filter__label">Трио</label>
			</li>
			<li class="filter__item">
				<input type="checkbox" id="performer-quartet" name="performer[]" value="quartet" class="filter__checkbox">
				<label for="performer-quartet" class="filter__label">Квартет</label>
			</li>
			<li class="filter__item">
				<input type="checkbox" id="performer-dj" name="performer[]" value="dj" class="filter__checkbox">
				<label for="performer-dj" class="filter__label">DJ</label>
			</li>
			<li class="filter__item">
				<input type="checkbox" id="performer-event-dj" name="performer[]" value="event_dj" class="filter__checkbox">
				<label for="performer-event-dj" class="filter__label">Event-DJ</label>
			</li>
			<li class="filter__item">
				<input type="checkbox" id="performer-other" name="performer[]" value="other" class="filter__checkbox">
				<label for="performer-other" class="filter__label">Другое</label>
			</li>
		</ul>
	</div>

	<!-- Формат исполнения -->
	<div class="filter-group">
		<h3 class="filter-group__title">Формат исполнения</h3>
		<ul class="filter-group__list">
			<li class="filter__item">
				<input type="checkbox" id="format-original" name="format[]" value="original" class="filter__checkbox">
				<label for="format-original" class="filter__label">Авторский репертуар</label>
			</li>
			<li class="filter__item">
				<input type="checkbox" id="format-covers" name="format[]" value="covers" class="filter__checkbox">
				<label for="format-covers" class="filter__label">Кавер</label>
			</li>
		</ul>
	</div>

	<!-- Жанр -->
	<div class="filter-group">
		<h3 class="filter-group__title">Жанр</h3>
		<ul class="filter-group__list">
			<li class="filter__item">
				<input type="checkbox" id="genre-pop" name="genre[]" value="pop" class="filter__checkbox">
				<label for="genre-pop" class="filter__label">Поп <span>(популярная, данс-, евро-поп…)</span></label>
			</li>
			<li class="filter__item">
				<input type="checkbox" id="genre-rock" name="genre[]" value="rock" class="filter__checkbox">
				<label for="genre-rock" class="filter__label">Рок <span>(рок-н-ролл, хард-рок, альтернатива, панк, метал…)</span></label>
			</li>
			<li class="filter__item">
				<input type="checkbox" id="genre-blues" name="genre[]" value="blues" class="filter__checkbox">
				<label for="genre-blues" class="filter__label">Блюз <span>(кантри-, дельта-, чикагский блюз…)</span></label>
			</li>
			<li class="filter__item">
				<input type="checkbox" id="genre-jazz" name="genre[]" value="jazz" class="filter__checkbox">
				<label for="genre-jazz" class="filter__label">Джаз <span>(свинг, лаунж…)</span></label>
			</li>
			<li class="filter__item">
				<input type="checkbox" id="genre-rnb" name="genre[]" value="rnb" class="filter__checkbox">
				<label for="genre-rnb" class="filter__label">R&B <span>(ритм-энд-блюз, соул, фанк…)</span></label>
			</li>
			<li class="filter__item">
				<input type="checkbox" id="genre-country" name="genre[]" value="country" class="filter__checkbox">
				<label for="genre-country" class="filter__label">Кантри <span>(вестерн, блюграсс…)</span></label>
			</li>
			<li class="filter__item">
				<input type="checkbox" id="genre-reggae" name="genre[]" value="reggae" class="filter__checkbox">
				<label for="genre-reggae" class="filter__label">Регги <span>(ска, рокстеди, даб)</span></label>
			</li>
			<li class="filter__item">
				<input type="checkbox" id="genre-hiphop" name="genre[]" value="hiphop" class="filter__checkbox">
				<label for="genre-hiphop" class="filter__label">Хип-хоп <span>(рэп, трэп, old school)</span></label>
			</li>
			<li class="filter__item">
				<input type="checkbox" id="genre-electronic" name="genre[]" value="electronic" class="filter__checkbox">
				<label for="genre-electronic" class="filter__label">Электронная музыка <span>(хаус, техно, транс, drum and bass, чилаут…)</span></label>
			</li>
			<li class="filter__item">
				<input type="checkbox" id="genre-classical" name="genre[]" value="classical" class="filter__checkbox">
				<label for="genre-classical" class="filter__label">Классическая музыка <span>(симфония, опера, соната…)</span></label>
			</li>
			<li class="filter__item">
				<input type="checkbox" id="genre-folk" name="genre[]" value="folk" class="filter__checkbox">
				<label for="genre-folk" class="filter__label">Фолк <span>(народная музыка, акустический фолк…)</span></label>
			</li>
			<li class="filter__item">
				<input type="checkbox" id="genre-latin" name="genre[]" value="latin" class="filter__checkbox">
				<label for="genre-latin" class="filter__label">Латиноамериканская <span>(сальса, самба, бачата, танго)</span></label>
			</li>
			<li class="filter__item">
				<input type="checkbox" id="genre-chanson" name="genre[]" value="chanson" class="filter__checkbox">
				<label for="genre-chanson" class="filter__label">Шансон / авторская песня <span>(французский шансон, русский шансон, бардовская песня)</span></label>
			</li>
			<li class="filter__item">
				<input type="checkbox" id="genre-other" name="genre[]" value="other" class="filter__checkbox">
				<label for="genre-other" class="filter__label">Другое</label>
			</li>
		</ul>
	</div>

	<!-- Состав -->
	<div class="filter-group">
		<h3 class="filter-group__title">Состав</h3>
		<ul class="filter-group__list">
			<li class="filter__item">
				<input type="checkbox" id="lineup-keys" name="lineup[]" value="keys" class="filter__checkbox">
				<label for="lineup-keys" class="filter__label">Клавишные <span>(рояль, пианино, синтезатор, орган, аккордеон)</span></label>
			</li>
			<li class="filter__item">
				<input type="checkbox" id="lineup-strings" name="lineup[]" value="strings" class="filter__checkbox">
				<label for="lineup-strings" class="filter__label">Струнные <span>(гитара, бас-гитара, скрипка, виолончель, арфа)</span></label>
			</li>
			<li class="filter__item">
				<input type="checkbox" id="lineup-brass" name="lineup[]" value="brass" class="filter__checkbox">
				<label for="lineup-brass" class="filter__label">Духовые <span>(флейта, саксофон, труба, кларнет, гобой, тромбон)</span></label>
			</li>
			<li class="filter__item">
				<input type="checkbox" id="lineup-drums" name="lineup[]" value="drums" class="filter__checkbox">
				<label for="lineup-drums" class="filter__label">Ударные <span>(установка, перкуссия, малый барабан, ханг)</span></label>
			</li>
			<li class="filter__item">
				<input type="checkbox" id="lineup-folk" name="lineup[]" value="folk" class="filter__checkbox">
				<label for="lineup-folk" class="filter__label">Народные <span>(баян, балалайка, домра, цимбалы)</span></label>
			</li>
			<li class="filter__item">
				<input type="checkbox" id="lineup-electronic" name="lineup[]" value="electronic" class="filter__checkbox">
				<label for="lineup-electronic" class="filter__label">Электроника <span>(семплер, драм-машина, midi-клавиши)</span></label>
			</li>
			<li class="filter__item">
				<input type="checkbox" id="lineup-vocal" name="lineup[]" value="vocal" class="filter__checkbox">
				<label for="lineup-vocal" class="filter__label">Вокал <span>(солист, бэк-вокалист)</span></label>
			</li>
		</ul>
	</div>

	<!-- Локация -->
	<div class="filter-group">
		<h3 class="filter-group__title">Где выступаем</h3>
		<ul class="filter-group__list">
			<li class="filter__item">
				<input type="checkbox" id="location-minsk" name="location[]" value="minsk" class="filter__checkbox">
				<label for="location-minsk" class="filter__label">Минск и Минская область</label>
			</li>
			<li class="filter__item">
				<input type="checkbox" id="location-brest" name="location[]" value="brest" class="filter__checkbox">
				<label for="location-brest" class="filter__label">Брест и Брестская область</label>
			</li>
			<li class="filter__item">
				<input type="checkbox" id="location-vitebsk" name="location[]" value="vitebsk" class="filter__checkbox">
				<label for="location-vitebsk" class="filter__label">Витебск и Витебская область</label>
			</li>
			<li class="filter__item">
				<input type="checkbox" id="location-gomel" name="location[]" value="gomel" class="filter__checkbox">
				<label for="location-gomel" class="filter__label">Гомель и Гомельская область</label>
			</li>
			<li class="filter__item">
				<input type="checkbox" id="location-grodno" name="location[]" value="grodno" class="filter__checkbox">
				<label for="location-grodno" class="filter__label">Гродно и Гродненская область</label>
			</li>
			<li class="filter__item">
				<input type="checkbox" id="location-mogilev" name="location[]" value="mogilev" class="filter__checkbox">
				<label for="location-mogilev" class="filter__label">Могилёв и Могилёвская область</label>
			</li>
			<li class="filter__item filter__item--separator">
				<input type="checkbox" id="travel-yes" name="travel" value="yes" class="filter__checkbox">
				<label for="travel-yes" class="filter__label">Готовность к выезду</label>
			</li>
		</ul>
	</div>

	<div class="filters__actions">
		<button class="filters__reset" type="button">Сбросить фильтры</button>
		<button class="filters__show" type="button">Показать</button>
	</div>
</aside>