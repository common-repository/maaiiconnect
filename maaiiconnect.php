<?php
/**
 * Plugin Name: maaiiconnect plugin
 * Description: Use the maaiiconnect plugin to instantly add live call and chat functions on your Wordpress website and answer your online customers’ inquiries promptly. 
 * Version: 1.0.2
 * Requires at least: 5.2
 * Requires PHP: 5.6
 * Author: maaiiconnect
 * Author URI: https://www.maaiiconnect.com
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 *
 * maaiiconnect plugin is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * any later version.
 *
 * maaiiconnect plugin is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with maaiiconnect plugin.
 * If not, see https://www.gnu.org/licenses/gpl-2.0.html.
 */

// Forbid direct access to this file, must load from WP core
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

define( 'M800_MC_PLUGIN_NAME', 'maaiiconnect' );
define( 'M800_MC_PLUGIN_DIR', str_replace('\\','/', dirname(__FILE__)) );
define( 'M800_MC_VERSION', '1.0.0' );

// Include both internal and external service
define( 'M800_MC_SERVICE_REGEX', '/^[a-zA-Z0-9][a-zA-Z0-9-]*[a-zA-Z0-9](\.[a-zA-Z0-9][a-zA-Z0-9-]*[a-zA-Z0-9])*\.(maaiiconnect|m800)\.(com|cn)$/' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-maaiiconnect-activator.php
 */
function activate_maaiiconnect() {
  require_once plugin_dir_path( __FILE__ ) . 'includes/class-maaiiconnect-activator.php';
  MaaiiconnectActivator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-maaiiconnect-deactivator.php
 */
function deactivate_maaiiconnect() {
  require_once plugin_dir_path( __FILE__ ) . 'includes/class-maaiiconnect-deactivator.php';
  MaaiiconnectDeactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_maaiiconnect' );
register_deactivation_hook( __FILE__, 'deactivate_maaiiconnect' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-maaiiconnect.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since 1.0.0
 */
function run_maaiiconnect() {
  $plugin = new Maaiiconnect();
  $plugin->run();
}
run_maaiiconnect();
