<?php
/**
 * @file
 * Demo - List of locations.
 */

namespace Drupal\nadim_core\Controller;

/**
 * Class LocationsDemo.
 */

class LocationsDemo {
    
    public function page() {
        $is_gdpr = is_smart_ip_method_exist();
        // Default Values.
        $name = 'Following countries does not come under GDPR.';
        $locations = [
            'Australia',
            'New Zealand',
            'Bangladesh',
            'Dubai',
            'England',
        ];
        // If user's country comes under GDPR.
        if ($is_gdpr) {
          $name = 'List of GDPR countries.';
          $locations = [
            'Belgium',
            'Bulgaria',
            'Croatia',
            'Cyprus',
          ];       
        }

        return [
            '#theme' => 'event_locations',
            '#name' => $name,
            '#locations' => $locations,
        ];
    }

}

/**
 * Checks if the smart_ip session is set.
 *
 * If set then returns the value.
 *
 * @return string
 *   The current user country code.
 */
function get_current_user_country_code() {
    $country = '';
  if (isset($_SESSION['_sf2_attributes']['smart_ip']['location']['countryCode'])) {
    $country = $_SESSION['_sf2_attributes']['smart_ip']['location']['countryCode'];
  }
  return $country;
}


/**
 * Check if the smart_ip method exist.
 */
function is_smart_ip_method_exist() {
    $country = get_current_user_country_code();
  if (function_exists('smart_ip_is_eu_gdpr_country') && !empty($country)) {
    return smart_ip_is_eu_gdpr_country($country, TRUE);
  }
  return FALSE;
}