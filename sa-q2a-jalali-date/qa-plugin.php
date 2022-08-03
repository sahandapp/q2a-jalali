<?php

/*
	Plugin Name: افزونه تاریخ شمسی 
	Plugin URI: https://sevlin.com/item/sa-q2a-jalali-date
	Plugin Description: این افزونه تمام تاریخ های میلادی را به شمسی تبدیل می کند
	Plugin Version: 1.0
	Plugin Date: 2020-09-19
	Plugin Author: Sevlin
	Plugin Author URI: https://sevlin.com/
	Plugin License: GPLv2
	Plugin Minimum Question2Answer Version: 1.5
	Plugin Update Check URI: 
*/

if (!defined('QA_VERSION')) { // don't allow this page to be requested directly from browser
	header('Location: ../../');
	exit;
}

qa_register_plugin_overrides('sa-jalali-date-overrides.php');

/*
* Sa Jalali Date Q2A Plugin
* 
* @author    https://sevlin.com/
* @copyright Copyright Ⓒ 2020 sevlin.com <@email:support@sevlin.com>
* @license   You only can use module, nothing more!
*/

?>
