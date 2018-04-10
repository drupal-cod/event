<?php

namespace Drupal\event\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\RevisionLogInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Event entities.
 *
 * @ingroup event
 */
interface EventInterface extends ContentEntityInterface, RevisionLogInterface, EntityChangedInterface, EntityOwnerInterface {

  /**
   * Gets the Event name.
   *
   * @return string
   *   Name of the Event.
   */
  public function getName();

  /**
   * Sets the Event name.
   *
   * @param string $name
   *   The Event name.
   *
   * @return \Drupal\event\Entity\EventInterface
   *   The called Event entity.
   */
  public function setName($name);

  /**
   * Gets the Event creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Event.
   */
  public function getCreatedTime();

  /**
   * Sets the Event creation timestamp.
   *
   * @param int $timestamp
   *   The Event creation timestamp.
   *
   * @return \Drupal\event\Entity\EventInterface
   *   The called Event entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Returns the Event published status indicator.
   *
   * Unpublished Event are only visible to restricted users.
   *
   * @return bool
   *   TRUE if the Event is published.
   */
  public function isPublished();

  /**
   * Sets the published status of a Event.
   *
   * @param bool $published
   *   TRUE to set this Event to published, FALSE to set it to unpublished.
   *
   * @return \Drupal\event\Entity\EventInterface
   *   The called Event entity.
   */
  public function setPublished($published);

  /**
   * Gets the Event revision creation timestamp.
   *
   * @return int
   *   The UNIX timestamp of when this revision was created.
   */
  public function getRevisionCreationTime();

  /**
   * Sets the Event revision creation timestamp.
   *
   * @param int $timestamp
   *   The UNIX timestamp of when this revision was created.
   *
   * @return \Drupal\event\Entity\EventInterface
   *   The called Event entity.
   */
  public function setRevisionCreationTime($timestamp);

  /**
   * Gets the Event revision author.
   *
   * @return \Drupal\user\UserInterface
   *   The user entity for the revision author.
   */
  public function getRevisionUser();

  /**
   * Sets the Event revision author.
   *
   * @param int $uid
   *   The user ID of the revision author.
   *
   * @return \Drupal\event\Entity\EventInterface
   *   The called Event entity.
   */
  public function setRevisionUserId($uid);

}
