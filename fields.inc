<?php

/**
 * Specifies any auxiliary fields that are applicable for events.  The only value returned by default is 'location'.
 *
 * @ingroup event_support
 * @return An array of event-specific fields.
 */
function event_extra_fields() {
  /*
  ** Add an entry below for any additional field you might need.
  ** If you want to use an extra database field, do not forget
  ** to add it to the event table.
  */
  $fields = array(
    'location' => array(
      'textfield',        // Field type
      t('Location'),      // Display name
      false,              // Required field
      true,               // Store in separate database field
      true,               // Show in calendar
      '',                 // the permission required to view this field (if any). edit event_perm() accordingly
      '',                 // Default value
      100,                // Field length
      255,                // Maximum input length
      t('Where this event is taking place.'),   // Help text
    ),
    // 'country' => array('textfield', t('Country'), false, false, false, '', '', 64, 64, t('Which country is hosting this event?')),
    // 'keynote' => array('textarea', t('Keynote topic'), false, false, false, '', '', 64, 4, ''),
    
    // include 'none' in your options array in order to have search form work as expected. this is true even for 'required' fields. array should also have uniquely named keys as shown below (for search).
    // 'etype'  => array('select', t('Event Type'), false, true, false, 'access private event fields', '', array('etype_0' => '<'. t('None'). '>', 'etype_1' => t('Job fair'),  'etype_2' => t('Human resources'), 'etype_3' => t('Diversity'), 'etype_4' => t('Hispanic Association')), '', NULL, 1),
  );
  
  // omit any fields which are not permitted for current user.
  foreach ($fields as $field => $def) {
    if ($def[5] && !user_access($def[5])) {
      unset($fields[$field]);
    }
  }
  return $fields;
}
?>
