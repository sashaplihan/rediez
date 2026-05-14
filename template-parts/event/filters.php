<?php
/**
 * The template for displaying filters event
 * @package rediez
 */

$icon_path = get_template_directory_uri() . '/assets/images/icons/';
?>

<aside class="events-catalog__filters filters">
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

	<!-- Формат события -->
	<div class="filter-group">
		<h3 class="filter-group__title">Формат события</h3>
		<ul class="filter-group__list">
			<li class="filter__item">
				<input type="checkbox" id="event-corporate" name="event[]" value="corporate" class="filter__checkbox">
				<label for="event-corporate" class="filter__label">Корпоративное мероприятие</label>
			</li>
			<li class="filter__item">
				<input type="checkbox" id="event-wedding" name="event[]" value="wedding" class="filter__checkbox">
				<label for="event-wedding" class="filter__label">Свадьба, банкет, юбилей</label>
			</li>
			<li class="filter__item">
				<input type="checkbox" id="event-kids" name="event[]" value="kids" class="filter__checkbox">
				<label for="event-kids" class="filter__label">Детский праздник</label>
			</li>
			<li class="filter__item">
				<input type="checkbox" id="event-registration" name="event[]" value="registration" class="filter__checkbox">
				<label for="event-registration" class="filter__label">Выездная регистрация/поздравление</label>
			</li>
			<li class="filter__item">
				<input type="checkbox" id="event-concert" name="event[]" value="concert" class="filter__checkbox">
				<label for="event-concert" class="filter__label">Концерт/трибьют</label>
			</li>
			<li class="filter__item">
				<input type="checkbox" id="event-music" name="event[]" value="music" class="filter__checkbox">
				<label for="event-music" class="filter__label">Музыкальное сопровождение</label>
			</li>
			<li class="filter__item">
				<input type="checkbox" id="event-dj" name="event[]" value="dj_set" class="filter__checkbox">
				<label for="event-dj" class="filter__label">DJ-сет</label>
			</li>
			<li class="filter__item">
				<input type="checkbox" id="event-other" name="event[]" value="other" class="filter__checkbox">
				<label for="event-other" class="filter__label">Другое</label>
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
				<label for="genre-pop" class="filter__label">Поп <span>(популярная музыка, данс-поп, синти-поп, евро-поп)</span></label>
			</li>
			<li class="filter__item">
				<input type="checkbox" id="genre-rock" name="genre[]" value="rock" class="filter__checkbox">
				<label for="genre-rock" class="filter__label">Рок <span>(рок-н-ролл, хард-рок, панк-рок, альтернативный рок, метал)</span></label>
			</li>
			<li class="filter__item">
				<input type="checkbox" id="genre-blues" name="genre[]" value="blues" class="filter__checkbox">
				<label for="genre-blues" class="filter__label">Блюз <span>(кантри-блюз, дельта-блюз, чикагский блюз)</span></label>
			</li>
			<li class="filter__item">
				<input type="checkbox" id="genre-jazz" name="genre[]" value="jazz" class="filter__checkbox">
				<label for="genre-jazz" class="filter__label">Джаз <span>(свинг, бибоп, лаунж, фьюжн, регтайм)</span></label>
			</li>
			<li class="filter__item">
				<input type="checkbox" id="genre-rnb" name="genre[]" value="rnb" class="filter__checkbox">
				<label for="genre-rnb" class="filter__label">R&amp;B <span>(ритм-энд-блюз, соул, фанк, contemporary R&amp;B)</span></label>
			</li>
			<li class="filter__item">
				<input type="checkbox" id="genre-country" name="genre[]" value="country" class="filter__checkbox">
				<label for="genre-country" class="filter__label">Кантри <span>(вестерн, блюграсс, аутло-кантри)</span></label>
			</li>
			<li class="filter__item">
				<input type="checkbox" id="genre-reggae" name="genre[]" value="reggae" class="filter__checkbox">
				<label for="genre-reggae" class="filter__label">Регги <span>(ска, рокстеди, даб)</span></label>
			</li>
			<li class="filter__item">
				<input type="checkbox" id="genre-hiphop" name="genre[]" value="hiphop" class="filter__checkbox">
				<label for="genre-hiphop" class="filter__label">Хип-хоп <span>(рэп, трэп, осознанный хип-хоп, old school)</span></label>
			</li>
			<li class="filter__item">
				<input type="checkbox" id="genre-electronic" name="genre[]" value="electronic" class="filter__checkbox">
				<label for="genre-electronic" class="filter__label">Электронная музыка <span>(хаус, техно, дабстеп, транс, drum and bass, эмбиент, чилаут, нью-эйдж)</span></label>
			</li>
			<li class="filter__item">
				<input type="checkbox" id="genre-classical" name="genre[]" value="classical" class="filter__checkbox">
				<label for="genre-classical" class="filter__label">Классическая музыка <span>(симфония, опера, камерная, соната)</span></label>
			</li>
			<li class="filter__item">
				<input type="checkbox" id="genre-folk" name="genre[]" value="folk" class="filter__checkbox">
				<label for="genre-folk" class="filter__label">Фолк <span>(народная музыка, акустический фолк, инди-фолк)</span></label>
			</li>
			<li class="filter__item">
				<input type="checkbox" id="genre-latin" name="genre[]" value="latin" class="filter__checkbox">
				<label for="genre-latin" class="filter__label">Латиноамериканская <span>(сальса, самба, реггетон, бачата, танго)</span></label>
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
				<label for="lineup-brass" class="filter__label">Духовые <span>(флейта, саксофон, труба, кларнет)</span></label>
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

	<!-- Длительность -->
	<div class="filter-group">
		<h3 class="filter-group__title">Длительность</h3>
		<ul class="filter-group__list">
			<li class="filter__item">
				<input type="checkbox" id="duration-halfhour" name="duration[]" value="half-hour" class="filter__checkbox">
				<label for="duration-halfhour" class="filter__label">До 30 минут</label>
			</li>
			<li class="filter__item">
				<input type="checkbox" id="duration-hour" name="duration[]" value="30-60" class="filter__checkbox">
				<label for="duration-hour" class="filter__label">От 30 до 60 минут</label>
			</li>
			<li class="filter__item">
				<input type="checkbox" id="duration-twohours" name="duration[]" value="60-120" class="filter__checkbox">
				<label for="duration-twohours" class="filter__label">От 60 до 120 минут</label>
			</li>
			<li class="filter__item">
				<input type="checkbox" id="duration-manyhours" name="duration[]" value="many-hours" class="filter__checkbox">
				<label for="duration-manyhours" class="filter__label">Более 120 минут</label>
			</li>
		</ul>
	</div>

	<!-- Дополнительные условия -->
	<div class="filter-group">
		<h3 class="filter-group__title">Дополнительные условия</h3>
		<ul class="filter-group__list">
			<li class="filter__item">
				<input type="checkbox" id="conditions-organizer" name="conditions[]" value="organizer" class="filter__checkbox">
				<label for="conditions-organizer" class="filter__label">Аппаратура организатора/площадки</label>
			</li>
			<li class="filter__item">
				<input type="checkbox" id="conditions-equipment" name="conditions[]" value="equipment" class="filter__checkbox">
				<label for="conditions-equipment" class="filter__label">Нужна своя аппаратура</label>
			</li>
			<li class="filter__item">
				<input type="checkbox" id="conditions-touring" name="conditions[]" value="touring" class="filter__checkbox">
				<label for="conditions-touring" class="filter__label">Наличие гастрольного удостоверения</label>
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
				<input type="checkbox" id="payment-yes" name="payment" value="yes" class="filter__checkbox">
				<label for="payment-yes" class="filter__label">Оплата трансфера заказчиком</label>
			</li>
		</ul>
	</div>

	<div class="filters__actions">
		<button class="filters__reset" type="button">Сбросить фильтры</button>
		<button class="filters__show" type="button">Показать</button>
	</div>
</aside>