<?php

namespace Drupal\galicloud_custom\PathProcessor;

use Drupal\Core\PathProcessor\InboundPathProcessorInterface;
use Drupal\Core\PathProcessor\OutboundPathProcessorInterface;
use Drupal\Core\Render\BubbleableMetadata;
use Symfony\Component\HttpFoundation\Request;

/**
 * Path processor to replace 'node' with 'content' in URLs.
 */
class PathProcessorGalicloudCustom implements InboundPathProcessorInterface, OutboundPathProcessorInterface {

  /**
   * {@inheritdoc}
   */
  public function processInbound($path, Request $request) {
    return preg_replace('#^/galicloud/#', '/galicloud-custom-entity/', $path);
  }

  /**
   * {@inheritdoc}
   */
  public function processOutbound($path, &$options = [], Request $request = NULL, BubbleableMetadata $bubbleable_metadata = NULL) {
    return preg_replace('#^/galicloud-custom-entity/#', '/galicloud/', $path);
  }

}
