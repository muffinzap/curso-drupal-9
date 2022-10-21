<?php

namespace Drupal\galicloud_events\EventSubscriber;

use Drupal\Core\Messenger\MessengerInterface;

use Drupal\galicloud_events\Event\UserLoginEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Galicloud Events event subscriber.
 */
class GalicloudEventsUserSubscriber implements EventSubscriberInterface {

  /**
   * The messenger.
   *
   * @var \Drupal\Core\Messenger\MessengerInterface
   */
  protected $messenger;

  /**
   * Constructs a GalicloudEventsUserSubscriber object.
   *
   * @param \Drupal\Core\Messenger\MessengerInterface $messenger
   *   The messenger.
   */
  public function __construct(MessengerInterface $messenger) {
    $this->messenger = $messenger;
  }

  public function onUserLogin(UserLoginEvent $event) {
    $this->messenger->addStatus(__FUNCTION__);
    $this->messenger->addStatus(t("Welcome back, %username", ['%username' =>  $event->account->getAccountName()]));
  }

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents() {
    return [
      UserLoginEvent::USER_LOGIN => ['onUserLogin'],
//      UserLoginEvent::USER_LOGIN => ['onUserLogin']
    ];
  }

}
