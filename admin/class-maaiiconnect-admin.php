<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @since      1.0.0
 *
 * @package    Maaiiconnect
 * @subpackage Maaiiconnect/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Maaiiconnect
 * @subpackage Maaiiconnect/admin
 * @author     M800 Ltd.
 */
class MaaiiconnectAdmin {

  /**
   * The ID of this plugin.
   *
   * @since    1.0.0
   * @access   private
   * @var      string    $plugin_name    The ID of this plugin.
   */
  private $plugin_name;

  /**
   * The version of this plugin.
   *
   * @since    1.0.0
   * @access   private
   * @var      string    $version    The current version of this plugin.
   */
  private $version;

  /**
   * Initialize the class and set its properties.
   *
   * @since    1.0.0
   * @param      string    $plugin_name       The name of this plugin.
   * @param      string    $version    The version of this plugin.
   */
  public function __construct( $plugin_name, $version ) {

    $this->plugin_name = $plugin_name;
    $this->version = $version;
    $this->admin_pages = [];

    require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/maaiiconnect-admin-display.php';
  }

  /**
   * Initialize the plugin.
   * It register the admin setting page.
   * 
   * @since 1.0.0
   */
  public function register_admin_settings() {

    $option_prefix = 'maaiiconnect';
    $option_group = 'maaiiconnect-options';
    $setting_page = 'maaiiconnect-settings';
    $setting_default_section = 'maaiiconnect_section';

    register_setting(
      $option_group,
      'maaiiconnect_service-account', // option name
      array(
        'type' => 'string',
        'description' => 'Service account is your service identifier to access maaiiconnect'
      )
    );

    add_settings_section(
      $setting_default_section,
      'General Settings',
      'maaiiconnect_render_section',
      $setting_page
    );

    add_settings_field(
      'maaiiconnect_service-account',
      'Service Account',
      'maaiiconnect_render_service_account',
      $setting_page,
      $setting_default_section
    );
  }

  public function register_admin_menu() {

    $general_setting_page = add_options_page(
      'maaiiconnect Setting',
      'maaiiconnect',
      'manage_options',
      'maaiiconnect-settings',
      'maaiiconnect_render_settings_page'
    );
    $this->admin_pages[] = $general_setting_page;

    add_filter('plugin_action_links', 'maaiiconnect_plugin_action_links', 10, 2);

  }

  /**
   * Register the stylesheets for the admin area.
   *
   * @since    1.0.0
   */
  public function enqueue_styles() {

    /**
     * An instance of this class should be passed to the run() function
     * defined in MaaiiconnectLoader as all of the hooks are defined
     * in that particular class.
     *
     * The MaaiiconnectLoader will then create the relationship
     * between the defined hooks and the functions defined in this
     * class.
     */

  }

  /**
   * Register the JavaScript for the admin area.
   *
   * @since    1.0.0
   */
  public function enqueue_scripts( $hook ) {

    /**
     * An instance of this class should be passed to the run() function
     * defined in MaaiiconnectLoader as all of the hooks are defined
     * in that particular class.
     *
     * The MaaiiconnectLoader will then create the relationship
     * between the defined hooks and the functions defined in this
     * class.
     */

    if ( !in_array( $hook, $this->admin_pages ) ) {
      return;
    }

    wp_enqueue_script( 'popper', plugin_dir_url( __DIR__ ) . '/resources/js/popper.min.js', array(), true );
    wp_enqueue_script( 'maaiiconnect-tooltip', plugin_dir_url( __FILE__ ) . '/js/tooltip.js', array(), true, true );

  }

}
