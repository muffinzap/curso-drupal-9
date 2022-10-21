<?php

namespace Drupal\galicloud_ajax\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a Galicloud ajax form.
 */
class AjaxForm extends FormBase
{

  //TODO grenerate voccabulary
  private $colors = [
    'warm' => [
      'red' => 'Red',
      'orange' => 'Orange',
      'yellow' => 'Yellow',
    ],
    'cool' => [
      'blue' => 'Blue',
      'purple' => 'Purple',
      'green' => 'Green',
    ],
  ];

  /**
   * {@inheritdoc}
   */
  public function getFormId()
  {
    return 'galicloud_ajax_ajax';
  }

  /**
   * {@inheritdoc}
   *
   * @see https://api.drupal.org/api/drupal/core!core.api.php/group/ajax/9.3.x#sub_callback
   */
  public function buildForm(array $form, FormStateInterface $form_state)
  {

    $form['temperature'] = [
      '#title' => $this->t('Temperature'),
      '#type' => 'select',
      '#options' => ['warm' => 'Warm', 'cool' => 'Cool'],
      '#empty_option' => $this->t('-select'),
      '#ajax' => [
        'callback' => '::colorCallback',
        'wrapper' => 'color-wrapper',
      ],
    ];
    // Desactivar la caché de formulario
    $form_state->setCached(FALSE);
    $form['color_wrapper'] = [
      '#type' => 'container',
      '#attributes' => ['id' => 'color-wrapper'],
    ];
    $form['actions'] = [
      '#type' => 'actions',
    ];
    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Submit'),
    ];
    return $form;
  }

  public function colorCallback(array &$form, FormStateInterface $form_state) {
    $temperature = $form_state->getValue('temperature');
    $form['color_wrapper']['color'] = [
      '#type' => 'select',
      '#title' => $this->t('Color'),
      '#options' => $this->colors[$temperature],
    ];
    return $form['color_wrapper'];
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state)
  {
//    if (mb_strlen($form_state->getValue('message')) < 10) {
//      $form_state->setErrorByName('message', $this->t('Message should be at least 10 characters.'));
//    }
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state)
  {
    $this->messenger()->addStatus($this->t('The message has been sent.'));
    $form_state->setRedirect('<front>');
  }

}
