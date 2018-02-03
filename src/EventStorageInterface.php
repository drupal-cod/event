<?php

namespace Drupal\event;

use Drupal\Core\Entity\ContentEntityStorageInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Language\LanguageInterface;
use Drupal\event\Entity\EventInterface;

/**
 * Defines the storage handler class for Event entities.
 *
 * This extends the base storage class, adding required special handling for
 * Event entities.
 *
 * @ingroup event
 */
interface EventStorageInterface extends ContentEntityStorageInterface {

  /**
   * Gets a list of Event revision IDs for a specific Event.
   *
   * @param \Drupal\event\Entity\EventInterface $entity
   *   The Event entity.
   *
   * @return int[]
   *   Event revision IDs (in ascending order).
   */
  public function revisionIds(EventInterface $entity);

  /**
   * Gets a list of revision IDs having a given user as Event author.
   *
   * @param \Drupal\Core\Session\AccountInterface $account
   *   The user entity.
   *
   * @return int[]
   *   Event revision IDs (in ascending order).
   */
  public function userRevisionIds(AccountInterface $account);

  /**
   * Counts the number of revisions in the default language.
   *
   * @param \Drupal\event\Entity\EventInterface $entity
   *   The Event entity.
   *
   * @return int
   *   The number of revisions in the default language.
   */
  public function countDefaultLanguageRevisions(EventInterface $entity);

  /**
   * Unsets the language for all Event with the given language.
   *
   * @param \Drupal\Core\Language\LanguageInterface $language
   *   The language object.
   */
  public function clearRevisionsLanguage(LanguageInterface $language);

}
