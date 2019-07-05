<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://coregenie.com
 * @since      1.0.0
 *
 * @package    Coregenie_Catalog
 * @subpackage Coregenie_Catalog/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Coregenie_Catalog
 * @subpackage Coregenie_Catalog/includes
 * @author     Hasanul Banna <banna@coregenie.com>
 */
class Coregenie_Catalog_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
public function load_plugin_coregenie_catalog() {
		load_plugin_textdomain(
			'coregenie-catalog',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);
	}

}
