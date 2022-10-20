<?php

namespace Drupal\galicloud_entities\Form;

use Drupal\Core\Entity\EntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Galicloud Entities Section form.
 *
 * @property \Drupal\galicloud_entities\GalicloudEntitiesSectionInterface $entity
 */
class GalicloudEntitiesSectionForm extends EntityForm
{

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state)
  {

    $form = parent::form($form, $form_state);

    $form['label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Label'),
      '#maxlength' => 255,
      '#default_value' => $this->entity->label(),
      '#description' => $this->t('Label for the galicloud entities section.'),
      '#required' => TRUE,
    ];

    $form['id'] = [
      '#type' => 'machine_name',
      '#default_value' => $this->entity->id(),
      '#machine_name' => [
        'exists' => '\Drupal\galicloud_entities\Entity\GalicloudEntitiesSection::load',
      ],
      '#disabled' => !$this->entity->isNew(),
    ];

//    $form['status'] = [
//      '#type' => 'checkbox',
//      '#title' => $this->t('Enabled'),
//      '#default_value' => $this->entity->status(),
//    ];
//
//    $form['description'] = [
//      '#type' => 'textarea',
//      '#title' => $this->t('Description'),
//      '#default_value' => $this->entity->get('description'),
//      '#description' => $this->t('Description of the galicloud entities section.'),
//    ];
    $form['urlPattern'] = [
      '#type' => 'textfield',
      '#title' => $this->t('URL pattern'),
      '#maxlength' => 255,
      '#default_value' => $this->entity->getUrlPattern(),
      '#description' => $this->t("URL pattern for the Section."),
      '#required' => TRUE,
    ];
    $form['color'] = [
      '#type' => 'color',
      '#title' => $this->t('Color'),
      '#default_value' => $this->entity->getColor(),
      '#description' => $this->t("Color for the Section."),
      '#required' => TRUE,
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state)
  {
//    $result = parent::save($form, $form_state);
//    $message_args = ['%label' => $this->entity->label()];
//    $message = $result == SAVED_NEW
//      ? $this->t('Created new galicloud entities section %label.', $message_args)
//      : $this->t('Updated galicloud entities section %label.', $message_args);
//    $this->messenger()->addStatus($message);
//    $form_state->setRedirectUrl($this->entity->toUrl('collection'));
//    return $result;
    $galicloud_entities_section = $this->entity;
    $status = $galicloud_entities_section->save();
    switch ($status) {
      case SAVED_NEW:
        $this->messenger()->addMessage($this->t('Created the %label Section.', [
          '%label' => $galicloud_entities_section->label(),
        ]));
        break;
      default:
        $this->messenger()->addMessage($this->t('Saved the %label Section.', [
          '%label' => $galicloud_entities_section->label(),
        ]));
    }
    $form_state->setRedirectUrl($galicloud_entities_section->toUrl('collection'));

  }

}
