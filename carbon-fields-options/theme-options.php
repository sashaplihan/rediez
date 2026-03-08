<?php

use Carbon_Fields\Container;
use Carbon_Fields\Field;

Container::make( 'theme_options', 'Настройки сайта' )

	->add_tab( 'Шапка', array(
        Field::make( 'separator', 'crb_header_sep', 'Шапка сайта' ),
        Field::make( 'image', 'crb_header_logo', 'Логотип' )
            ->set_value_type( 'url' ),
        Field::make( 'text', 'crb_auth_login_text', 'Текст кнопки входа/регистрации' )
            ->set_default_value( 'Вход | Регистрация' )
            ->set_help_text( 'Отображается для неавторизованных пользователей' )
            ->set_width( 50 ),
        Field::make( 'text', 'crb_auth_account_text', 'Текст кнопки аккаунта' )
            ->set_default_value( 'Личный кабинет' )
            ->set_help_text( 'Отображается для авторизованных пользователей' )
            ->set_width( 50 ),
	) )
	
	 ->add_tab( __('Футер'), array(
        Field::make( 'separator', 'crb_footer_info_sep', 'Логотип и описание' ),
        Field::make( 'image', 'crb_footer_logo', 'Логотип в футере' )
            ->set_help_text( 'Загрузите картинку для логотипа.' )
            ->set_value_type( 'url' ),
        Field::make( 'textarea', 'crb_footer_description', 'Информация о компании' )
            ->set_help_text( 'Введите текст.' )
            ->set_rows( 3 ),
        Field::make( 'textarea', 'crb_footer_stats', 'Краткое описание' )
            ->set_help_text( 'Введите текст.' )
            ->set_rows( 2 ),
        
        Field::make( 'separator', 'crb_footer_menu_sep', 'Меню навигации' ),
        Field::make( 'text', 'crb_footer_menu_title', 'Заголовок меню' )
            ->set_default_value( 'Навигация' )
            ->set_width( 50 ),
        Field::make( 'html', 'crb_footer_menu_hint' )
            ->set_html( '<p style="margin-top:10px;">Меню настраивается в разделе <strong>Внешний вид → Меню</strong>.</p>' ),
        
        Field::make( 'separator', 'crb_footer_contacts_sep', 'Контакты' ),
        Field::make( 'text', 'crb_footer_contacts_title', 'Заголовок раздела' )
            ->set_help_text( 'Введите текст.' )
            ->set_width( 50 ),
        Field::make( 'text', 'crb_footer_phone', 'Телефон' )
            ->set_attribute( 'placeholder', '+7 (495) 123-45-67' )
            ->set_width( 33 ),
        Field::make( 'text', 'crb_footer_email', 'Email' )
            ->set_attribute( 'type', 'email' )
            ->set_attribute( 'placeholder', 'info@example.ru' )
            ->set_width( 33 ),
        Field::make( 'text', 'crb_footer_support_email', 'Email поддержки' )
            ->set_attribute( 'type', 'email' )
            ->set_attribute( 'placeholder', 'support@example.ru' )
            ->set_width( 34 ),
        
        Field::make( 'separator', 'crb_footer_social_sep', 'Социальные сети' ),
        Field::make( 'text', 'crb_footer_social_title', 'Заголовок раздела' )
            ->set_help_text( 'Введите текст.' )
            ->set_width( 50 ),
        Field::make( 'complex', 'crb_footer_social', 'Социальные сети' )
            ->set_layout( 'tabbed-horizontal' )
            ->add_fields( array(
                Field::make( 'select', 'crb_social_network', 'Соцсеть' )
                    ->set_options( array(
                        'vk' => 'ВКонтакте',
                        'telegram' => 'Telegram',
                        'youtube' => 'YouTube',
                        'instagram' => 'Instagram',
                        'facebook' => 'Facebook',
                    ) )
                    ->set_width( 30 ),
                Field::make( 'text', 'crb_social_url', 'Ссылка' )
                    ->set_attribute( 'type', 'url' )
                    ->set_attribute( 'placeholder', 'https://vk.com/yourpage' )
                    ->set_width( 70 ),
            ) )
            ->set_header_template( '<%- crb_social_network %>' ),

        Field::make( 'separator', 'crb_footer_payments_sep', 'Способы оплаты' ),
        Field::make( 'complex', 'crb_footer_payments', 'Иконки способов оплаты' )
            ->set_layout( 'tabbed-horizontal' )
            ->add_fields( array(
                Field::make( 'image', 'crb_payment_image', 'Изображение' )
                    ->set_value_type( 'id' )
                    ->set_help_text( 'Загрузите логотип платёжной системы' ),
            ) )
            ->set_header_template( 'Способ оплаты #<%- $_index + 1 %>' ),

        Field::make( 'separator', 'crb_footer_docs_sep', 'Юридические документы' ),       
        Field::make( 'complex', 'crb_footer_documents', 'Ссылки на документы' )
            ->set_layout( 'tabbed-horizontal' )
            ->add_fields( array(
                Field::make( 'text', 'crb_doc_title', 'Название' )
            		->set_help_text( 'Введите текст.' )
                    ->set_width( 50 ),
				Field::make( 'file', 'crb_doc_link', 'Документ' )
            		->set_help_text( 'Загрузите документ.' )
                    ->set_width( 50 ),
            ) ),
        
        Field::make( 'separator', 'crb_footer_copyright_sep', 'Копирайт' ),
        Field::make( 'text', 'crb_footer_copyright', 'Текст копирайта' )
            ->set_attribute( 'placeholder', '© 2024 Название сайта. Все права защищены.' )
            ->set_help_text( 'Введите текст.' ),
        
    ) );