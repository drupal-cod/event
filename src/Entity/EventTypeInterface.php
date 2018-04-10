<?php

namespace Drupal\event\Entity;

use Drupal\Core\Config\Entity\ConfigEntityInterface;

/**
 * Provides an interface for defining Event type entities.
 */
interface EventTypeInterface extends ConfigEntityInterface {

  /**
   * Determines whether to enable timezone support for an entity.
   *
   * @return bool
   *   TRUE if the entity has custom timezones, or FALSE to use site timezone.
   */
  public function useTimezones();

}
