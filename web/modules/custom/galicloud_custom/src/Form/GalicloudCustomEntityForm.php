<?php

namespace Drupal\galicloud_custom\Form;

use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Form controller for the galicloud custom entity entity edit forms.
 */
class GalicloudCustomEntityForm extends ContentEntityForm {

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $result = parent::save($form, $form_state);

    $entity = $this->getEntity();

    $message_arguments = ['%label' => $entity->toLink()->toString()];
    $logger_arguments = [
      '%label' => $entity->label(),
      'link' => $entity->toLink($this->t('View'))->toString(),
    ];

    switch ($result) {
      case SAVED_NEW:
        $this->messenger()->addStatus($this->t('New galicloud custom entity %label has been created.', $message_arguments));
        $this->logger('galicloud_custom')->notice('Created new galicloud custom entity %label', $logger_arguments);
        break;

      case SAVED_UPDATED:
        $this->messenger()->addStatus($this->t('The galicloud custom entity %label has been updated.', $message_arguments));
        $this->logger('galicloud_custom')->notice('Updated galicloud custom entity %label.', $logger_arguments);
        break;
    }

    $form_state->setRedirect('entity.galicloud_custom_entity.canonical', ['galicloud_custom_entity' => $entity->id()]);

    return $result;
  }

}
