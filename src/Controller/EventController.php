<?php

namespace Drupal\event\Controller;

use Drupal\Component\Utility\Xss;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Url;
use Drupal\event\Entity\EventInterface;

/**
 * Class EventController.
 *
 *  Returns responses for Event routes.
 */
class EventController extends ControllerBase implements ContainerInjectionInterface {

  /**
   * Displays a Event  revision.
   *
   * @param int $event_revision
   *   The Event  revision ID.
   *
   * @return array
   *   An array suitable for drupal_render().
   */
  public function revisionShow($event_revision) {
    $event = $this->entityManager()->getStorage('event')->loadRevision($event_revision);
    $view_builder = $this->entityManager()->getViewBuilder('event');

    return $view_builder->view($event);
  }

  /**
   * Page title callback for a Event  revision.
   *
   * @param int $event_revision
   *   The Event  revision ID.
   *
   * @return string
   *   The page title.
   */
  public function revisionPageTitle($event_revision) {
    $event = $this->entityManager()->getStorage('event')->loadRevision($event_revision);
    return $this->t('Revision of %title from %date', ['%title' => $event->label(), '%date' => format_date($event->getRevisionCreationTime())]);
  }

  /**
   * Generates an overview table of older revisions of a Event .
   *
   * @param \Drupal\event\Entity\EventInterface $event
   *   A Event  object.
   *
   * @return array
   *   An array as expected by drupal_render().
   */
  public function revisionOverview(EventInterface $event) {
    $account = $this->currentUser();
    $langcode = $event->language()->getId();
    $langname = $event->language()->getName();
    $languages = $event->getTranslationLanguages();
    $has_translations = (count($languages) > 1);
    $event_storage = $this->entityManager()->getStorage('event');

    $build['#title'] = $has_translations ? $this->t('@langname revisions for %title', ['@langname' => $langname, '%title' => $event->label()]) : $this->t('Revisions for %title', ['%title' => $event->label()]);
    $header = [$this->t('Revision'), $this->t('Operations')];

    $revert_permission = (($account->hasPermission("revert all event revisions") || $account->hasPermission('administer event entities')));
    $delete_permission = (($account->hasPermission("delete all event revisions") || $account->hasPermission('administer event entities')));

    $rows = [];

    $vids = $event_storage->revisionIds($event);

    $latest_revision = TRUE;

    foreach (array_reverse($vids) as $vid) {
      /** @var \Drupal\event\EventInterface $revision */
      $revision = $event_storage->loadRevision($vid);
      // Only show revisions that are affected by the language that is being
      // displayed.
      if ($revision->hasTranslation($langcode) && $revision->getTranslation($langcode)->isRevisionTranslationAffected()) {
        $username = [
          '#theme' => 'username',
          '#account' => $revision->getRevisionUser(),
        ];

        // Use revision link to link to revisions that are not active.
        $date = \Drupal::service('date.formatter')->format($revision->getRevisionCreationTime(), 'short');
        if ($vid != $event->getRevisionId()) {
          $link = $this->l($date, new Url('entity.event.revision', ['event' => $event->id(), 'event_revision' => $vid]));
        }
        else {
          $link = $event->link($date);
        }

        $row = [];
        $column = [
          'data' => [
            '#type' => 'inline_template',
            '#template' => '{% trans %}{{ date }} by {{ username }}{% endtrans %}{% if message %}<p class="revision-log">{{ message }}</p>{% endif %}',
            '#context' => [
              'date' => $link,
              'username' => \Drupal::service('renderer')->renderPlain($username),
              'message' => ['#markup' => $revision->getRevisionLogMessage(), '#allowed_tags' => Xss::getHtmlTagList()],
            ],
          ],
        ];
        $row[] = $column;

        if ($latest_revision) {
          $row[] = [
            'data' => [
              '#prefix' => '<em>',
              '#markup' => $this->t('Current revision'),
              '#suffix' => '</em>',
            ],
          ];
          foreach ($row as &$current) {
            $current['class'] = ['revision-current'];
          }
          $latest_revision = FALSE;
        }
        else {
          $links = [];
          if ($revert_permission) {
            $links['revert'] = [
              'title' => $this->t('Revert'),
              'url' => $has_translations ?
              Url::fromRoute('entity.event.translation_revert',
                [
                  'event' => $event->id(),
                  'event_revision' => $vid,
                  'langcode' => $langcode,
                ]
              ) :
              Url::fromRoute('entity.event.revision_revert',
                [
                  'event' => $event->id(),
                  'event_revision' => $vid,
                ]
              ),
            ];
          }

          if ($delete_permission) {
            $links['delete'] = [
              'title' => $this->t('Delete'),
              'url' => Url::fromRoute('entity.event.revision_delete',
                [
                  'event' => $event->id(),
                  'event_revision' => $vid,
                ]
              ),
            ];
          }

          $row[] = [
            'data' => [
              '#type' => 'operations',
              '#links' => $links,
            ],
          ];
        }

        $rows[] = $row;
      }
    }

    $build['event_revisions_table'] = [
      '#theme' => 'table',
      '#rows' => $rows,
      '#header' => $header,
    ];

    return $build;
  }

}
