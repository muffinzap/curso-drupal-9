<?php

namespace Drupal\galicloud_queues\Plugin\QueueWorker;

use Drupal\Core\Queue\QueueWorkerBase;

/**
 * Defines 'galicloud_queues_nodereversetitles' queue worker.
 *
 * @QueueWorker(
 *   id = "galicloud_queues_nodereversetitles",
 *   title = @Translation("NodeReverseTitles"),
 *   cron = {"time" = 60}
 * )
 */
class Nodereversetitles extends QueueWorkerBase {

  /**
   * {@inheritdoc}
   */
  public function processItem($data)
  {
    $id = $data['id'];
    $title = $data['title'];
    // Invierte los caracteres del título
    $new_title = strrev($title);
    $storage = \Drupal::entityTypeManager()->getStorage('node');
    $node = $storage->load($id);
    $node->setTitle($new_title);
    $node->save();
    \Drupal::logger('galicloud_queues')->notice('Node @id has been processed.', ['@id' => $id]);
    sleep(1);//retraso en la ejecución
  }

}
