<?php

namespace Drupal\galicloud_crud\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a Galicloud Crud form.
 */
class PeopleForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'galicloud_crud_people';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    $form['name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Name'),
      '#required' => TRUE,
    ];

    $form['age'] = [
      '#type' => 'number',
      '#title' => $this->t('Age'),
      '#required' => TRUE,
    ];


    $form['actions'] = [
      '#type' => 'actions',
    ];
    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Send'),
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    if (empty($form_state->getValue('name'))) {
      $form_state->setErrorByName('name', $this->t('Write name'));
    }
    if (empty($form_state->getValue('age'))) {
      $form_state->setErrorByName('age', $this->t('Write age'));
    }
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    \Drupal::database()->insert('galicloud_people')->fields(['uid','name', 'age'])->values([
      \Drupal::currentUser()->id(),
      $form_state->getValue('name'),
      $form_state->getValue('age')
    ])->execute();


    $this->messenger()->addStatus($this->t('Created people.'));
//    $form_state->setRedirect('<front>');
  }

}
