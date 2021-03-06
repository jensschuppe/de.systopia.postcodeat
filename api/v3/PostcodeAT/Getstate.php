<?php
/*-------------------------------------------------------+
| SYSTOPIA - Postcode Lookup for Austria                 |
| Copyright (C) 2017 SYSTOPIA                            |
| Author: M. Wire (mjw@mjwconsult.co.uk)                 |
|         B. Endres (endres@systopia.de)                 |
| http://www.systopia.de/                                |
+--------------------------------------------------------+
| This program is released as free software under the    |
| Affero GPL license. You can redistribute it and/or     |
| modify it under the terms of this license which you    |
| can read by viewing the included agpl.txt or online    |
| at www.gnu.org/licenses/agpl.html. Removal of this     |
| copyright header is strictly prohibited without        |
| written permission from the original author(s).        |
+--------------------------------------------------------*/

/**
 * PostcodeAT.Getstate API specification (optional)
 * This is used for documentation and validation.
 *
 * @param array $spec description of fields supported by this API call
 * @return void
 * @see http://wiki.civicrm.org/confluence/display/CRM/API+Architecture+Standards
 */
function _civicrm_api3_postcode_a_t_getstate_spec(&$spec) {
  $spec['postal_code'] = [
    'title' => 'Postal code',
    'api.required' => 1,
    ];
  $spec['country_id'] = [
    'title' => 'Country ID',
    'api.required' => 1,
    ];
}

/**
 * PostcodeAT.Getstate API
 *
 * Returns the state based on the postcode and country.
 * (Looks up gemnr from postcode and maps to state)
 *
 * @param array $params
 * @return array API result descriptor
 * @see civicrm_api3_create_success
 * @see civicrm_api3_create_error
 * @throws API_Exception
 */
function civicrm_api3_postcode_a_t_getstate($params) {

  switch ($params['country_id']) {
    case 1014: // Österreich
      $params['plznr'] = $params['postal_code'];
      $values = CRM_Postcodeat_Country_AT::getState($params);
      if ($values) {
        $returnValues[$values['id']] = array($values);
        return civicrm_api3_create_success($returnValues, $params, 'PostcodeAT', 'getstate');
      }
      break;
  }

  return civicrm_api3_create_error('State not found');
}

