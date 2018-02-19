<?php
ini_set('display_errors', '1');
error_reporting(E_ALL);
//DB
$DB_HOST = 'forcecrm.ftp.ukraine.com.ua';
$DB_NAME = 'forcecrm_t8';
$DB_USER = 'forcecrm_t8'; 
$DB_PASSWORD = 'el5g2gtl'; 
/* $DB_HOST = 'srv-pleskdb18.ps.kz:3306';
$DB_NAME = 'vagonkak_main';
$DB_USER = 'vagon_main_u'; 
$DB_PASSWORD = 'b#An6w28hSk@t672';  */
           
//Admin
$ALANG = 'ru';
$PROJECT_NAME = "Франчайзинг";
$ADMIN_SESSION_AUTH = 1;
$YANDEX_TRANSLATE_API_KEY = 'trnsl.1.1.20170103T150641Z.f693759668b9d203.03fc0b872fcc7aa74056236f043bf5a3b0b2be80';

$LANGS = array('1'=>'Рус','2'=>'Укр','3'=>'Eng');
$LANGS_MARKS = array('1' => 'ru', '2' => 'uk','3'=> 'en');

//Tables
$TABLE_ITEMS="catalog_products";

$TABLE_DOCS_RUBS="docs_rubs";
$TABLE_DOCS="docs";
$TABLE_NEWS_RUBS="news_rubs";
$TABLE_NEWS="news";

$TABLE_USERS_RUBS="utypes";
$TABLE_USERS="users";
$TABLE_MAIL="emails";
$TABLE_TAGS = "tags";

$TABLE_ADMINS_GROUPS="admins_groups";
$TABLE_ADMINS="admins";
$TABLE_ADMINS_MENU="admins_menu";
$TABLE_ADMINS_MENU_ASSOC="admins_menu_assoc";
$TABLE_ADMINS_LOG="admins_log";
