<?php

namespace Drupal\event\Form;

use Drupal\Core\Entity\EntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class EventTypeForm.
 */
class EventTypeForm extends EntityForm {

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state) {
    $form = parent::form($form, $form_state);

    /** @var \Drupal\event\Entity\EventTypeInterface $event_type */
    $event_type = $this->entity;
    $form['label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Label'),
      '#maxlength' => 255,
      '#default_value' => $event_type->label(),
      '#description' => $this->t("Label for the Event type."),
      '#required' => TRUE,
    ];

    $form['id'] = [
      '#type' => 'machine_name',
      '#default_value' => $event_type->id(),
      '#machine_name' => [
        'exists' => '\Drupal\event\Entity\EventType::load',
      ],
      '#disabled' => !$event_type->isNew(),
    ];

    $form['timezone'] = [
      '#title' => $this->t('Allow content to use custom timezones'),
      '#type' => 'checkbox',
      '#default_value' => $event_type->useTimezones(),
      '#description' => $this->t('Enable timezones on a per event basis.'),
    ];

    /* You will need additional form elements for your custom properties. */

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $event_type = $this->entity;
    $event_type->set('timezone', $form_state->getValue('timezone'));
    $status = $event_type->save();

    switch ($status) {
      case SAVED_NEW:
        drupal_set_message($this->t('Created the %label Event type.', [
          '%label' => $event_type->label(),
        ]));
        break;

      default:
        drupal_set_message($this->t('Saved the %label Event type.', [
          '%label' => $event_type->label(),
        ]));
    }
    $form_state->setRedirectUrl($event_type->toUrl('collection'));
  }

}
