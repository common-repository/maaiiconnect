<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @since      1.0.0
 *
 * @package    Maaiiconnect
 * @subpackage Maaiiconnect/admin/partials
 */

function maaiiconnect_plugin_action_links( $links, $file ) {
  static $this_plugin_regex;
  
  if ( !$this_plugin_regex) {
    $this_plugin_regex = '/^maaiiconnect/';
  }

  if ( preg_match( $this_plugin_regex, $file ) ) {
    // The "page" query string value must be equal to the slug
    // of the Settings admin page we defined earlier, which in
    // this case equals "maaiiconnect-settings".
    $settings_link = '<a href="' . get_bloginfo('wpurl') . '/wp-admin/admin.php?page=maaiiconnect-settings">Settings</a>';
    array_unshift( $links, $settings_link );
  }

  return $links;
}


function maaiiconnect_render_service_account() {
  $option_name = 'maaiiconnect_service-account';
  $service_account = get_option( $option_name );

?>
  <input
    name="<?= $option_name ?>"
    placeholder="example.maaiiconnect.com"
    size="50"
    value="<?= $service_account ?>"
  />
<?php
}


function maaiiconnect_render_admin_styles() {
?>

  <style>
    .tooltip {
      background: rgba(35, 40, 45, 0.97);
      color: white;
      padding: 0.5rem 0.6rem;
      font-size: 0.7rem;
      border-radius: 7px;
      max-width: 12rem;
      display: none;
    }
    .tooltip[data-show] {
      display: block;
    }
    .tooltip[data-popper-placement^='top'] > .tooltip-arrow {
      bottom: -4px;
    }

    .tooltip[data-popper-placement^='bottom'] > .tooltip-arrow {
      top: -4px;
    }

    .tooltip[data-popper-placement^='left'] > .tooltip-arrow {
      right: -4px;
    }

    .tooltip[data-popper-placement^='right'] > .tooltip-arrow {
      left: -4px;
    }

    .tooltip-arrow,
    .tooltip-arrow::before {
      position: absolute;
      width: 8px;
      height: 8px;
      z-index: -1;
    }

    .tooltip-arrow::before {
      content: '';
      transform: rotate(45deg);
      background: rgba(35, 40, 45, 0.97);
    }
  </style>

<?php
}


function maaiiconnect_render_settings_page() {
  $service_account = get_option( 'maaiiconnect_service-account' );
  $should_disable_launch_button = !is_string( $service_account )
    || !preg_match( M800_MC_SERVICE_REGEX, $service_account );

  static $tooltip_icon;
  if ( !isset($tooltip_icon) ) {
    $tooltip_icon = '<svg width="17px" height="16px" class="tooltip-icon" viewBox="0 0 17 16" version="1.1" xmlns="http://www.w3.org/2000/svg">
      <g id="Mockup" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
        <g id="06-system/info/fill" transform="translate(-1.500000, -2.000000)" fill="#23282d">
          <path d="M4.34314575,4.34314575 C7.46734008,1.21895142 12.5326599,1.21895142 15.6568542,4.34314575 C18.7810486,7.46734008 18.7810486,12.5326599 15.6568542,15.6568542 C12.5326599,18.7810486 7.46734008,18.7810486 4.34314575,15.6568542 C1.21895142,12.5326599 1.21895142,7.46734008 4.34314575,4.34314575 Z M10.9370253,7.72101052 L8.125,7.72101052 L8.125,9.07555569 L9.06221519,9.07555569 L9.06221519,13.6460498 L8.125,13.6460498 L8.125,15 L11.875,15 L11.875,13.6460498 L10.9370253,13.6460498 L10.9370253,7.72101052 Z M9.86858112,5 C9.54107065,5 9.26143373,5.10309678 9.05291948,5.31287932 C8.8433368,5.52597248 8.74322785,5.81183355 8.74322785,6.15108385 C8.74322785,6.45862251 8.84668903,6.7267214 9.05152457,6.9349952 C9.25947242,7.14532259 9.53363609,7.25 9.85091744,7.25 C10.1763978,7.25 10.4572296,7.14786316 10.6702365,6.94116959 C10.8867435,6.72997002 10.9932278,6.44721849 10.9932278,6.11606717 C10.9932278,5.79566894 10.8854597,5.51806306 10.6709455,5.3088055 C10.4576707,5.10293976 10.1827676,5 9.86858112,5 Z" id="Combined-Shape"></path>
        </g>
      </g>
    </svg>';
  }

  $disabled = '';
  $href = '';
  if ( $should_disable_launch_button ) {
    $disabled = 'disabled';
    $launch_button_title = 'Your service account is not valid';
  } else {
    $href = "href='https://${service_account}'";
    $launch_button_title = 'Launch maaiiconnect Dashboard';
  }
?>

  <div class="wrap">
    <?php maaiiconnect_render_admin_styles() ?>

    <h1>maaiiconnect plugin Settings</h1>
    <h2>General Settings</h2>

    <p>
      If you didn't subscribe maaiiconnect service, please
      <a href="https://signup.maaiiconnect.com" alt="Subscribe maaiiconnect" title="Subscribe maaiiconnect" target="_blank">
        click here to subscribe maaiiconnect for free</a>!
    </p>

    <form action="options.php" method="post">

    <?php
      settings_fields( 'maaiiconnect-options' );
    ?>

    <table class="form-table" role="presentation">
      <tbody>
        <tr>
          <th scope="row">
            <div style="display: flex; align-items: center;">
              <span style="margin-right: 0.5rem;">Service Account</span>
              <?= $tooltip_icon ?>
            </div>
          </th>
          <td><?php maaiiconnect_render_service_account() ?></td>
        </tr>
      </tbody>
    </table>

    <p>
      <strong>Remark:</strong>
      this plugin is not compatible with Headless CMS.
    </p>

    <p class="submit">
      <input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes" />
      <a class="button button-secondary" <?= $href ?> <?= $disabled ?> title="<?= $launch_button_title ?>" alt="Launch maaiiconnect Dashboard" target="_blank">Launch maaiiconnect Dashboard</a>
    </p>

    </form>

    <div id="serviceAccountTip" class="tooltip" role="tooltip">
      Service Account is an unique string (e.g. <span style="text-decoration: underline">example.maaiiconnect.com</span>) that represents your service in maaiiconnect.
      It is also the url that you login to your dashboard.
      You can locate it in the Installation section of the Dashboard.
      <div class="tooltip-arrow" data-popper-arrow></div>
    </div>
  </div>

<?php 
}

function maaiiconnect_render_section() {
?>

<p>
  If you didn't subscribe maaiiconnect service, please
  <a href="https://signup.maaiiconnect.com" alt="Subscribe maaiiconnect" title="Subscribe maaiiconnect" target="_blank">
    click here to subscribe maaiiconnect for free</a>!
</p>

<?php
}
