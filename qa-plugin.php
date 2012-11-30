<?php

/*
	Plugin Name: Q2AM New Members Widget
	Plugin URI: https://github.com/q2amarket/new-members-widget
	Plugin Update Check URI: https://github.com/q2amarket/new-members-widget/raw/master/qa-plugin.php
	Plugin Description: Display newly registered members widget
	Plugin Version: 1.0
	Plugin Date: 2012-11-29
	Plugin Author: Q2A Market
	Plugin Author URI: http://www.q2amarket.com
	Plugin License: GPLv2
	Plugin Minimum Question2Answer Version: 1.4
*/


if (!defined('QA_VERSION')){header('Location: ../../'); exit;}

qa_register_plugin_layer('qa-new-members-output.php', 'New Members Output');
qa_register_plugin_module('widget', 'qa-new-members-widget.php', 'qa_new_members_widget', 'Q2AM New Members Widget');
	
?>