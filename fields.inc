<?php

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
      '',                 // Default value
      100,                // Field length
      255,                // Maximum input length
      t('Where this event is taking place.'),   // Help text
    ),
    // 'country' => array('textfield', t('Country'), false, false, false, '', 64, 64, t('Which country is hosting this event?')),
    // 'keynote' => array('textarea', t('Keynote topic'), false, false, false, '', 64, 4, ''),
  );
  return $fields;
}
?>