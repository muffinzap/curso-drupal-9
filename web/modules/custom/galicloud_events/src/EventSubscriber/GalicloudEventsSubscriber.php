<?php

namespace Drupal\galicloud_events\EventSubscriber;

use Drupal\Core\Config\ConfigCrudEvent;
use Drupal\Core\Config\ConfigEvents;
use Drupal\Core\Messenger\MessengerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * Galicloud events event subscriber.
 */
class GalicloudEventsSubscriber implements EventSubscriberInterface {

  protected MessengerInterface $messenger;

  public function __construct(MessengerInterface $messenger)
  {
    $this->messenger = $messenger;
  }






  public function onConfigSave(ConfigCrudEvent $event) {
    $this->messenger->addStatus("Event: " . __FUNCTION__);
    $config = $event->getConfig();
    $this->messenger->addStatus("Config: " . $config->getName());
  }
  public function onConfigDelete(ConfigCrudEvent $event) {
    $this->messenger->addStatus("Event: " . __FUNCTION__);
    $config = $event->getConfig();
    $this->messenger->addStatus("Config: " . $config->getName());
  }
  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents() {
    return [
      ConfigEvents::SAVE => ['onConfigSave'],
      ConfigEvents::DELETE => ['onConfigDelete'],
    ];
  }

//  /**
//   * {@inheritdoc}
//   */
//  public static function getSubscribedEvents() {
//    return [
//      KernelEvents::REQUEST => ['onKernelRequest'],
//      KernelEvents::RESPONSE => ['onKernelResponse'],
//    ];
//  }

}
