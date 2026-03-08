<?php

if(!defined('ABSPATH')) {
    exit;
}

use Carbon_Fields\Container;
use Carbon_Fields\Field;

Container::make( 'post_meta', 'Настройки Главной страницы' )
    ->where( 'post_template', '=', 'page-home.php' )
    ->add_tab( __( 'Главный экран' ), array(

		Field::make( 'image', 'hero_bg', 'Фоновое изображение секции' )->set_value_type( 'url' ),

        Field::make( 'html', 'hero_left_title_label' )
            ->set_html( '<h3>← Левый блок (Для клиентов)</h3><hr>' ),
        Field::make( 'text', 'hero_left_title', 'Заголовок' ),
        Field::make( 'textarea', 'hero_left_text', 'Подзаголовок' )
            ->set_rows( 2 ),
        Field::make( 'complex', 'hero_left_list', 'Список преимуществ' )
            ->add_fields( array(
                Field::make( 'text', 'item', 'Пункт списка' ),
            ) )
            ->set_layout( 'tabbed-horizontal' ),
        Field::make( 'text', 'hero_left_btn_text', 'Текст кнопки' )
		->set_width( 50 ),
        Field::make( 'text', 'hero_left_btn_url', 'Ссылка кнопки' )
		->set_width( 50 ),

        Field::make( 'html', 'hero_right_title_label' )
            ->set_html( '<br><h3>→ Правый блок (Для музыкантов)</h3><hr>' ),
        Field::make( 'text', 'hero_right_title', 'Заголовок' ),
        Field::make( 'textarea', 'hero_right_text', 'Подзаголовок' )
            ->set_rows( 2 ),
        Field::make( 'complex', 'hero_right_list', 'Список преимуществ' )
            ->add_fields( array(
                Field::make( 'text', 'item', 'Пункт списка' ),
            ) )
            ->set_layout( 'tabbed-horizontal' ),
        Field::make( 'text', 'hero_right_btn_text', 'Текст кнопки' ),
    ) )

	->add_tab( 'Музыканты', array(
		Field::make( 'checkbox', 'show_musicians_section', 'Показать секцию "Музыканты"' )
			->set_help_text( 'Если галочка стоит — секция отображается на главной' ),

		Field::make( 'association', 'home_selected_musicians', 'Выбрать музыкантов для слайдера' )
			->set_types( array(
				array(
					'type'      => 'post',
					'post_type' => 'rediez_musicians',
				)
			) )
			->set_conditional_logic( array(
				array(
					'field' => 'show_musicians_section',
					'value' => true,
				)
			) )
	) )

	->add_tab( 'CTA Блок', array(
		Field::make( 'checkbox', 'show_cta_section', 'Показать секцию "CTA"' )
			->set_default_value( true ),

		Field::make( 'image', 'cta_icon', 'Иконка в заголовке' )
			->set_value_type( 'url' )
			->set_conditional_logic( array( array( 'field' => 'show_cta_section', 'value' => true ) ) ),

		Field::make( 'text', 'cta_title', 'Заголовок' )
			->set_conditional_logic( array( array( 'field' => 'show_cta_section', 'value' => true ) ) ),

		Field::make( 'rich_text', 'cta_text', 'Текст секции' )
			->set_conditional_logic( array( array( 'field' => 'show_cta_section', 'value' => true ) ) ),

		Field::make( 'text', 'cta_btn_text', 'Текст кнопки' )
			->set_width( 50 )
			->set_conditional_logic( array( array( 'field' => 'show_cta_section', 'value' => true ) ) ),

		Field::make( 'text', 'cta_btn_url', 'Ссылка кнопки' )
			->set_width( 50 )
			->set_conditional_logic( array( array( 'field' => 'show_cta_section', 'value' => true ) ) ),
	) )

	->add_tab( 'Ивенты', array(
		Field::make( 'checkbox', 'show_events_section', 'Показать секцию "Ивенты"' )
			->set_help_text( 'Если галочка стоит — секция отображается на главной' ),

		Field::make( 'association', 'home_selected_events', 'Выбрать мероприятия для блока' )
			->set_types( array(
				array(
					'type'      => 'post',
					'post_type' => 'rediez_events',
				)
			) )
			->set_conditional_logic( array(
				array(
					'field' => 'show_events_section',
					'value' => true,
				)
			) )
	) )

	->add_tab( 'Преимущества', array(
		Field::make( 'checkbox', 'show_advantages_section', 'Показать секцию "Преимущества"' )
			->set_default_value( true ),

		Field::make( 'html', 'adv_musicians_label' )
			->set_html( '<h3>Блок: Музыканты (Слева)</h3><hr>' )
			->set_conditional_logic( array( array( 'field' => 'show_advantages_section', 'value' => true ) ) ),

		Field::make( 'text', 'adv_mus_title', 'Заголовок блока' )
			->set_conditional_logic( array( array( 'field' => 'show_advantages_section', 'value' => true ) ) ),

		Field::make( 'complex', 'adv_mus_list', 'Список преимуществ' )
			->add_fields( array(
				Field::make( 'image', 'icon', 'Иконка' )
					->set_value_type( 'url' ),
				Field::make( 'text', 'title', 'Заголовок' )
					->set_width( 50 ),
				Field::make( 'textarea', 'text', 'Описание' )
					->set_rows(3)
					->set_width( 50 ),
			) )
			->set_layout( 'tabbed-horizontal' )
			->set_conditional_logic( array( array( 'field' => 'show_advantages_section', 'value' => true ) ) ),

		Field::make( 'text', 'adv_mus_btn_text', 'Текст кнопки' )
			->set_width( 50 )
			->set_conditional_logic( array( array( 'field' => 'show_advantages_section', 'value' => true ) ) ),

		Field::make( 'text', 'adv_mus_btn_url', 'Ссылка кнопки' )
			->set_width( 50 )
			->set_conditional_logic( array( array( 'field' => 'show_advantages_section', 'value' => true ) ) ),

		Field::make( 'html', 'adv_customers_label' )
			->set_html( '<br><h3>Блок: Заказчики (Справа)</h3><hr>' )
			->set_conditional_logic( array( array( 'field' => 'show_advantages_section', 'value' => true ) ) ),

		Field::make( 'text', 'adv_cust_title', 'Заголовок блока' )
			->set_conditional_logic( array( array( 'field' => 'show_advantages_section', 'value' => true ) ) ),

		Field::make( 'complex', 'adv_cust_list', 'Список преимуществ' )
			->add_fields( array(
				Field::make( 'image', 'icon', 'Иконка' )
					->set_value_type( 'url' ),
				Field::make( 'text', 'title', 'Заголовок' )
					->set_width( 50 ),
				Field::make( 'textarea', 'text', 'Описание' )
					->set_rows(3)
					->set_width( 50 ),
			) )
			->set_layout( 'tabbed-horizontal' )
			->set_conditional_logic( array( array( 'field' => 'show_advantages_section', 'value' => true ) ) ),

		Field::make( 'text', 'adv_cust_btn_text', 'Текст кнопки' )
			->set_width( 50 )
			->set_conditional_logic( array( array( 'field' => 'show_advantages_section', 'value' => true ) ) ),

		Field::make( 'text', 'adv_cust_btn_url', 'Ссылка кнопки' )
			->set_width( 50 )
			->set_conditional_logic( array( array( 'field' => 'show_advantages_section', 'value' => true ) ) ),
	) )

	->add_tab( 'Афиша', array(
		Field::make( 'checkbox', 'show_poster_section', 'Показать секцию "Афиша"' )
			->set_help_text( 'Если галочка стоит — секция отображается на главной' ),

		Field::make( 'association', 'home_selected_posters', 'Выбрать афиши для слайдера' )
			->set_types( array(
				array(
					'type'      => 'post',
					'post_type' => 'rediez_poster',
				)
			) )
			->set_conditional_logic( array(
				array(
					'field' => 'show_poster_section',
					'value' => true,
				)
			) )
	) )
	
	->add_tab( 'Новости', array(
    Field::make( 'checkbox', 'show_news_section', 'Показать секцию "Новости"' )
        ->set_help_text( 'Если галочка стоит — секция отображается на главной' )
        ->set_default_value( true ),

    Field::make( 'text', 'news_section_count', 'Количество новостей' )
        ->set_attribute( 'type', 'number' )
        ->set_attribute( 'min', '1' )
        ->set_attribute( 'max', '8' )
        ->set_default_value( '4' )
        ->set_help_text( 'Сколько новостей показывать на главной (от 1 до 8)' )
        ->set_conditional_logic( array(
            array(
                'field' => 'show_news_section',
                'value' => true,
            )
        ) )
	) );
	
Container::make( 'post_meta', 'Настройки афишы' )
    ->where( 'post_type', '=', 'rediez_poster' )
    ->add_fields( array(
        Field::make( 'text', 'poster_external_url', 'Ссылка на сторонний ресурс' )
            ->set_help_text( 'Если заполнено, кнопка или заголовок будут вести на этот сайт' ),
    ) );

Container::make( 'post_meta', __( 'Информация о музыканте' ) )
    ->where( 'post_type', '=', 'rediez_musicians' )
    ->add_tab( __('Основное'), array(
        Field::make( 'text', 'crb_musician_price', 'Цена за час (BYN)' )
            ->set_attribute( 'type', 'number' )
            ->set_attribute( 'placeholder', '700' )
            ->set_attribute( 'min', '0' )
            ->set_help_text( 'Укажите стоимость выступления в белорусских рублях за час' ),
        
        Field::make( 'separator', 'crb_musician_tags_sep', 'Теги и категории' ),
        Field::make( 'set', 'crb_musician_event_types', 'Тип события' )
            ->set_options( array(
                'wedding' => 'Свадьба',
                'corporate' => 'Корпоратив',
                'anniversary' => 'Юбилей',
                'kids' => 'Детский праздник',
                'restaurant' => 'Ресторан',
                'club' => 'Клуб',
                'festival' => 'Фестиваль',
                'Official' => 'Официальные мероприятия',
                'studio' => 'Студийная запись',
            ) )
            ->set_help_text( 'Выберите типы событий, на которых выступает музыкант' ),

        Field::make( 'set', 'crb_musician_performance_format', 'Формат выступления' )
            ->set_options( array(
                'covers' => 'Каверы',
                'original' => 'Авторские песни',
                'instrumental' => 'Инструментал',
                'dj_set' => 'DJ-сет',
                'background' => 'Фон (background)',
                'live' => 'Живой звук',
            ) )
            ->set_help_text( 'Укажите форматы, в которых работает музыкант' ),

        Field::make( 'set', 'crb_musician_genre', 'Жанр' )
            ->set_options( array(
                'pop' => 'Поп',
                'rock' => 'Рок',
                'jazz' => 'Джаз',
                'rap' => 'Рэп',
                'electronic' => 'Электронная',
                'classical' => 'Классика',
                'folk' => 'Народная',
                'lounge' => 'Лаунж',
                'retro' => 'Ретро, диско',
                'author' => 'Авторская песня',
            ) )
            ->set_help_text( 'Выберите музыкальные жанры' ),
        
        Field::make( 'set', 'crb_musician_performer_type', 'Тип исполнителя' )
            ->set_options( array(
                'band' => 'Группа',
                'solo' => 'Сольный артист',
                'duo' => 'Дуэт',
                'dj' => 'DJ',
                'instrumentalist' => 'Инструменталист',
                'session' => 'Сессионный музыкант',
            ) )
            ->set_help_text( 'Укажите тип исполнителя' ),

        Field::make( 'set', 'crb_musician_lineup', 'Состав' )
            ->set_options( array(
                'vocal' => 'Вокал',
                'brass' => 'Духовые',
                'strings' => 'Струнные',
                'drums' => 'Ударные',
                'electronic' => 'Электронные',
            ) )
            ->set_help_text( 'Выберите инструменты в составе' ),

        Field::make( 'set', 'crb_musician_location', 'Локация' )
            ->set_options( array(
                'minsk' => 'Минск',
                'brest' => 'Брест',
                'vitebsk' => 'Витебск',
                'gomel' => 'Гомель',
                'grodno' => 'Гродно',
                'mogilev' => 'Могилёв',
            ) )
            ->set_help_text( 'Выберите города, в которых работает музыкант' ),
        Field::make( 'checkbox', 'crb_musician_travel', 'Готов к выездам' )
            ->set_option_value( 'yes' )
            ->set_help_text( 'Отметьте, если музыкант готов выезжать в другие города' ), 
    ))
    
    ->add_tab( __('Контакты'), array(
        Field::make( 'text', 'crb_musician_phone', 'Телефон' )
            ->set_attribute( 'placeholder', '+375 (29) 777-11-22' )
            ->set_width( 50 ),
        Field::make( 'text', 'crb_musician_email', 'Email' )
            ->set_attribute( 'type', 'email' )
            ->set_attribute( 'placeholder', 'musician@example.com' )
            ->set_width( 50 ),
        
        Field::make( 'separator', 'crb_musician_social_sep', 'Социальные сети и мессенджеры' ),
        Field::make( 'text', 'crb_musician_telegram', 'Telegram' )
            ->set_attribute( 'placeholder', 'https://t.me/username' )
            ->set_help_text( 'Полная ссылка на Telegram или username' )
            ->set_width( 50 ),
        Field::make( 'text', 'crb_musician_whatsapp', 'WhatsApp' )
            ->set_attribute( 'placeholder', '+375291234567' )
            ->set_help_text( 'Номер телефона для WhatsApp' )
            ->set_width( 50 ),
        Field::make( 'text', 'crb_musician_viber', 'Viber' )
            ->set_attribute( 'placeholder', '+375291234567' )
            ->set_help_text( 'Номер телефона для Viber' )
            ->set_width( 50 ),
        Field::make( 'text', 'crb_musician_tiktok', 'TikTok' )
            ->set_attribute( 'placeholder', 'https://tiktok.com/@username' )
            ->set_help_text( 'Ссылка на профиль TikTok' )
            ->set_width( 50 ),
        Field::make( 'text', 'crb_musician_vk', 'ВКонтакте' )
            ->set_attribute( 'placeholder', 'https://vk.com/username' )
            ->set_help_text( 'Ссылка на профиль ВКонтакте' )
            ->set_width( 50 ),
        Field::make( 'text', 'crb_musician_ok', 'Одноклассники' )
            ->set_attribute( 'placeholder', 'https://ok.ru/username' )
            ->set_help_text( 'Ссылка на профиль в Одноклассниках' )
            ->set_width( 50 ),
    ))
    
    ->add_tab( __('Медиа'), array(
		Field::make( 'complex', 'crb_musician_gallery', 'Галерея фотографий' )
			->set_layout( 'tabbed-horizontal' )
			->add_fields( array(
				Field::make( 'image', 'crb_gallery_image', 'Изображение' )
					->set_value_type( 'id' ),
			) )
			->set_header_template( 'Фото #<%- $_index + 1 %>' )
			->set_help_text( 'Нажмите "Добавить" для каждого нового фото. Порядок можно изменить перетаскиванием.' ),
        
        Field::make( 'separator', 'crb_musician_video_sep', 'Видео' ),
		Field::make( 'complex', 'crb_musician_videos', 'Видео YouTube' )
			->set_layout( 'tabbed-horizontal' )
			->add_fields( array(
				Field::make( 'text', 'crb_video_url', 'Ссылка на YouTube' )
					->set_attribute( 'placeholder', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ' )
					->set_help_text( 'Вставьте любую ссылку на YouTube (watch, share, embed - все форматы поддерживаются)' ),
			) )
			->set_header_template( 'Видео #<%- $_index + 1 %>' )
			->set_help_text( 'Добавьте ссылки на видео. Поддерживаются форматы: youtube.com/watch?v=..., youtu.be/..., youtube.com/embed/...' ),
				
));


Container::make( 'post_meta', __( 'Информация о мероприятии' ) )
    ->where( 'post_type', '=', 'rediez_events' )

    ->add_tab( __('Основное'), array(
        Field::make( 'text', 'crb_event_price', 'Бюджет (BYN)' )
            ->set_attribute( 'type', 'number' )
            ->set_attribute( 'placeholder', '1000' )
            ->set_attribute( 'min', '0' )
            ->set_help_text( 'Укажите бюджет мероприятия в белорусских рублях' ),

		Field::make( 'date_time', 'crb_event_date', 'Дата и время события' )
			->set_storage_format( 'Y-m-d H:i:s' )
			->set_picker_options( array(
				'time_24hr' => true,
			) )
			->set_help_text( 'Когда состоится мероприятие' )
            ->set_width( 50 ),

		Field::make( 'date_time', 'crb_event_accept_until', 'Приём откликов до' )
			->set_storage_format( 'Y-m-d H:i:s' )
			->set_picker_options( array(
				'time_24hr' => true,
			) )
			->set_help_text( 'Крайний срок подачи заявок от исполнителей' )
            ->set_width( 50 ),

        Field::make( 'text', 'crb_event_venue', 'Место проведения' )
            ->set_attribute( 'placeholder', 'г. Минск, ресторан "Ренессанс"' )
            ->set_help_text( 'Город и название площадки' ),

        Field::make( 'separator', 'crb_event_tags_sep', 'Теги и категории' ),

        Field::make( 'set', 'crb_event_types', 'Тип события' )
            ->set_options( array(
                'wedding'   => 'Свадьба',
                'corporate' => 'Корпоратив',
                'anniversary' => 'Юбилей',
                'kids'      => 'Детский праздник',
                'restaurant' => 'Ресторан',
                'club'      => 'Клуб',
                'festival'  => 'Фестиваль',
                'official'  => 'Официальные мероприятия',
                'studio'    => 'Студийная запись',
            ) )
            ->set_help_text( 'Выберите тип мероприятия' ),

        Field::make( 'set', 'crb_event_performance_format', 'Формат выступления' )
            ->set_options( array(
                'covers'       => 'Каверы',
                'original'     => 'Авторские песни',
                'instrumental' => 'Инструментал',
                'dj_set'       => 'DJ-сет',
                'background'   => 'Фон (background)',
                'live'         => 'Живой звук',
                'recording'    => 'Запись в студии',
            ) )
            ->set_help_text( 'Укажите желаемый формат выступления' ),

        Field::make( 'set', 'crb_event_genre', 'Жанр' )
            ->set_options( array(
                'pop'        => 'Поп',
                'rock'       => 'Рок',
                'jazz'       => 'Джаз',
                'rap'        => 'Рэп',
                'electronic' => 'Электронная',
                'classical'  => 'Классика',
                'folk'       => 'Народная',
                'lounge'     => 'Лаунж',
                'retro'      => 'Ретро',
            ) )
            ->set_help_text( 'Выберите музыкальные жанры' ),

        Field::make( 'set', 'crb_event_location', 'Локация' )
            ->set_options( array(
                'minsk'   => 'Минск',
                'brest'   => 'Брест',
                'vitebsk' => 'Витебск',
                'gomel'   => 'Гомель',
                'grodno'  => 'Гродно',
                'mogilev' => 'Могилёв',
            ) )
            ->set_help_text( 'Выберите город проведения' ),

        Field::make( 'set', 'crb_event_duration', 'Продолжительность выступления' )
            ->set_options( array(
                'half-hour'  => 'До 30 минут',
                'hour'       => '1 час',
                'two-hours'  => '2 часа',
                'many-hours' => 'Более 2 часов',
            ) )
            ->set_help_text( 'Укажите желаемую продолжительность' ),

        Field::make( 'set', 'crb_event_conditions', 'Условия' )
            ->set_options( array(
                'payment'     => 'Оплата по договорённости',
                'equipment'   => 'Нужна своя аппаратура',
                'organizer'   => 'Аппаратура организатора',
                'cashless'    => 'Контракт / безналичный расчёт',
                'interaction' => 'Нужен интерактив с публикой',
            ) )
            ->set_help_text( 'Укажите условия для исполнителя' ),

        Field::make( 'checkbox', 'crb_event_payment', 'Оплата дороги / готовы оплачивать выезд' )
            ->set_option_value( 'yes' )
            ->set_help_text( 'Отметьте, если организатор готов оплатить дорогу исполнителю' ),
    ) )

    ->add_tab( __('Контакты'), array(

        Field::make( 'text', 'crb_event_phone', 'Телефон' )
            ->set_attribute( 'placeholder', '+375 (29) 777-11-22' )
            ->set_width( 50 ),

        Field::make( 'text', 'crb_event_email', 'Email' )
            ->set_attribute( 'type', 'email' )
            ->set_attribute( 'placeholder', 'event@example.com' )
            ->set_width( 50 ),

        Field::make( 'separator', 'crb_event_social_sep', 'Социальные сети и мессенджеры' ),

        Field::make( 'text', 'crb_event_telegram', 'Telegram' )
            ->set_attribute( 'placeholder', 'https://t.me/username' )
            ->set_width( 50 ),

        Field::make( 'text', 'crb_event_whatsapp', 'WhatsApp' )
            ->set_attribute( 'placeholder', '+375291234567' )
            ->set_width( 50 ),

        Field::make( 'text', 'crb_event_viber', 'Viber' )
            ->set_attribute( 'placeholder', '+375291234567' )
            ->set_width( 50 ),

        Field::make( 'text', 'crb_event_tiktok', 'TikTok' )
            ->set_attribute( 'placeholder', 'https://tiktok.com/@username' )
            ->set_width( 50 ),

        Field::make( 'text', 'crb_event_vk', 'ВКонтакте' )
            ->set_attribute( 'placeholder', 'https://vk.com/username' )
            ->set_width( 50 ),

        Field::make( 'text', 'crb_event_ok', 'Одноклассники' )
            ->set_attribute( 'placeholder', 'https://ok.ru/username' )
            ->set_width( 50 ),
) );