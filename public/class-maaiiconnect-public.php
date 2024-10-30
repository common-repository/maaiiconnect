<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @since      1.0.0
 *
 * @package    Maaiiconnect
 * @subpackage Maaiiconnect/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Maaiiconnect
 * @subpackage Maaiiconnect/public
 * @author     M800 Ltd.
 */
class MaaiiconnectPublic {

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
   * @param      string    $plugin_name       The name of the plugin.
   * @param      string    $version    The version of this plugin.
   */
  public function __construct( $plugin_name, $version ) {

    $this->plugin_name = $plugin_name;
    $this->version = $version;

  }

  /**
   * Register the stylesheets for the public-facing side of the site.
   *
   * Note that we do not have any style for this plugin, this function is kept
   * to maintain extensibility only.
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
   * Register the JavaScript for the public-facing side of the site.
   *
   * @since    1.0.0
   */
  public function enqueue_scripts() {

    /**
     * An instance of this class should be passed to the run() function
     * defined in MaaiiconnectLoader as all of the hooks are defined
     * in that particular class.
     *
     * The loader will then create the relationship
     * between the defined hooks and the functions defined in this
     * class.
     */

    $service_account = get_option( 'maaiiconnect_service-account' );

    if ( !isset( $service_account ) || empty( $service_account ) ) {
      return;
    }

    // service name ends with ".cn" then get mcwc script from cn
    $src = sprintf(
      'https://mcwc.mc.maaiiconnect.%s/mcwc/mcwc.js',
      preg_match( '/\.cn$/', $service_account) ? 'cn': 'com'
    );

    $settings = "window.mcwcSettings = { serviceName: '$service_account' };";

    wp_enqueue_script( 'maaiiconnect-mcwc-script', $src, array(), null );
    wp_add_inline_script( 'maaiiconnect-mcwc-script', $settings, 'before' );

    add_filter( 'script_loader_tag', array( $this, 'add_script_id' ), 10, 3 );

  }

  /**
   * Replace the script tag of mcwc to include id attribute.
   *
   * @since 1.0.0
   */
  public function add_script_id( $tag, $handle, $src ) {
    if ( 'maaiiconnect-mcwc-script' === $handle ) {
      // The settings tag will be included in $tag as well,
      // simply replacing '<script' will causing the settings be defer as well,
      // and that will break mcwc.
      // Using more complicated script to match the exact script tag for accurate overwriting.
      $tag = preg_replace( '/(<script[^>]*) (src=[^>]*>)/i', '$1 id="mcwc-sdk" defer $2', $tag );
    }
 
    return $tag;
  }

}
