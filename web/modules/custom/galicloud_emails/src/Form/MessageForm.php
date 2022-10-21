<?php

namespace Drupal\galicloud_emails\Form;

use Drupal\Component\Utility\EmailValidator;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Language\LanguageManagerInterface;
use Drupal\Core\Mail\MailManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a Galicloud Emails form.
 */
class MessageForm extends FormBase
{


  protected MailManagerInterface $mailManager;
  protected LanguageManagerInterface $languageManager;
  protected EmailValidator $emailValidator;

  public function __construct(MailManagerInterface $mailManager, LanguageManagerInterface $languageManager, EmailValidator $emailValidator)
  {
    $this->mailManager = $mailManager;
    $this->languageManager = $languageManager;
    $this->emailValidator = $emailValidator;
  }

  public static function create(ContainerInterface $container)
  {
    return new static(
      $container->get('plugin.manager.mail'),
      $container->get('language_manager'),
      $container->get('email.validator'),
    );

  }

  /**
   * {@inheritdoc}
   */
  public function getFormId()
  {
    return 'galicloud_emails_message';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state)
  {

    $form['intro'] = [
      '#markup' => t('Use this form to send a message to an e-mail address'),
    ];

    $form['message_to'] = [
      '#type' => 'email',
      '#title' => $this->t('E-mail address'),
      '#required' => TRUE,
    ];

    $form['message'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Message'),
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
  public function validateForm(array &$form, FormStateInterface $form_state)
  {
    $email = $form_state->getValue('message_to');
    if (!$this->emailValidator->isValid($email)) {
      $form_state->setErrorByName('message_to', $this->t('%email is not a valid email address.', ['%email' => $email]));
    }
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state)
  {
//    $this->messenger()->addStatus($this->t('The message has been sent.'));
//    $form_state->setRedirect('<front>');
    $form_values = $form_state->cleanValues()->getValues();
    $module = 'galicloud_emails';
    $key = 'contact_message';
    $to = $form_values['message_to'];
    $params = $form_values;
    $language_code = $this->languageManager->getDefaultLanguage()->getId();
    $send_now = TRUE;
    $result = $this->mailManager->mail($module, $key, $to, $language_code, $params, NULL, $send_now);
    if ($result['result'] == TRUE) {
      $this->messenger()->addMessage($this->t('Your message has been sent.'));
    } else {
      $this->messenger()->addMessage($this->t('There was a problem sending your message and it was not sent.'), 'error');
    }
  }

}
