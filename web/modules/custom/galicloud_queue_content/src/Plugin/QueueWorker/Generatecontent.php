<?php

namespace Drupal\galicloud_queue_content\Plugin\QueueWorker;

use Drupal;
use Drupal\Core\Queue\QueueWorkerBase;

/**
 * Defines 'galicloud_queue_content_generatecontent' queue worker.
 *
 * @QueueWorker(
 *   id = "galicloud_queue_content_generatecontent",
 *   title = @Translation("GenerateContent"),
 *   cron = {"time" = 60}
 * )
 */
class Generatecontent extends QueueWorkerBase {

  /**
   * {@inheritdoc}
   */
  public function processItem($data) {

    $data = [
      'type' => 'article',
      'title' => $data['title'],
      'uid' => 1
    ];
    $node = Drupal::entityTypeManager()
      ->getStorage('node')
      ->create($data);
    $node->save();
  }

}
