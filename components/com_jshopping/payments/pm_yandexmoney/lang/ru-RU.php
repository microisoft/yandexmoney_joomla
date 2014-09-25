<?php
/*
* @package JoomShopping for Joomla!
* @subpackage payment
* @author YandexMoney
* @copyright Copyright (C) 2012-2014 YandexMoney. All rights reserved.
* @license GNU General Public License version 2 or later
*/

//защита от прямого доступа
defined('_JEXEC') or die();

//определяем константы для русского языка
define('_JSHOP_YM_TESTMODE_DESCRIPTION', 'Использовать в тестовом режиме?');
define('_JSHOP_YM_MODE_DESCRIPTION', 'Выберите способы оплаты:');
define('_JSHOP_YM_MODE1_DESCRIPTION', 'На счет физического лица в электронной валюте Яндекс.Денег');
define('_JSHOP_YM_MODE2_DESCRIPTION', 'На расчетный счет организации с заключением договора с Яндекс.Деньгами');
define('_JSHOP_YM_METHODS_DESCRIPTION', 'Укажите необходимые способы оплаты:');
define('_JSHOP_YM_METHOD_YM_DESCRIPTION', 'электронная валюта Яндекс.Деньги');
define('_JSHOP_YM_METHOD_CARDS_DESCRIPTION', 'банковские карты VISA, MasterCard, Maestro');
define('_JSHOP_YM_METHOD_CASH_DESCRIPTION', 'наличными в кассах и терминалах партнеров');
define('_JSHOP_YM_METHOD_PHONE_DESCRIPTION', 'оплата со счета мобильного телефона');
define('_JSHOP_YM_METHOD_WM_DESCRIPTION', 'электронная валюта WebMoney');
define('_JSHOP_YM_METHOD_AB_DESCRIPTION', 'АльфаКлиk');
define('_JSHOP_YM_ACCOUNT_DESCRIPTION', 'Номер кошелька Яндекс:');

define('_JSHOP_YM_REG_IND', 'Если у вас нет аккаунта в Яндекс-Деньги, то следует зарегистрироваться тут - <a href="https://money.yandex.ru/" target="_blank">https://money.yandex.ru/</a><br/><b>ВАЖНО!</b> Вам нужно будет указать ссылку для приема HTTP уведомлений здесь - <a href="https://sp-money.yandex.ru/myservices/online.xml">https://sp-money.yandex.ru/myservices/online.xml</a>');

define('_JSHOP_YM_REG_ORG', 'Если у вас нет аккаунта в Яндекс-Деньги, то следует зарегистрироваться тут - <a href="https://money.yandex.ru/joinups/" target="_blank">https://money.yandex.ru/joinups/</a>');
define('_JSHOP_YM_METHODS_DESCRIPTION', 'Укажите необходимые способы оплаты');
define('_JSHOP_YM_PASSWORD', 'Секретное слово (shopPassword) для обмена сообщениями:');
define('_JSHOP_YM_SHOPID', 'Идентификатор вашего магазина в Яндекс.Деньгах (ShopID):');
define('_JSHOP_YM_SCID', 'Идентификатор витрины вашего магазина в Яндекс.Деньгах (scid):');
define('_JSHOP_YM_PARAM', 'Название параметра');
define('_JSHOP_YM_VALUE', 'Значение');
define('_JSHOP_YM_AVISO1', 'Адрес приема HTTP уведомлений');
define('_JSHOP_YM_AVISO2', 'Адрес приема HTTP уведомлений (paymentAvisoURL)');


define('_JSHOP_YM_PAY', 'Оплатить!');
define('_JSHOP_YM_TRANSACTION_END', 'Статус заказа для успешных транзакций');




