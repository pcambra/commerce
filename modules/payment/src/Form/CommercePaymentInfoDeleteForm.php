<?php

/**
 * @file
 * Contains \Drupal\commerce_payment\Form\CommercePaymentInfoDeleteForm.
 */

namespace Drupal\commerce_payment\Form;

use Drupal\Core\Entity\ContentEntityConfirmFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a form for deleting a payment information.
 */
class CommercePaymentInfoDeleteForm extends ContentEntityConfirmFormBase {

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('entity.manager')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getQuestion() {
    return t('Are you sure you want to delete the payment information %payment_info_label?', array('%payment_info_label' => $this->entity->label()));
  }

  /**
   * {@inheritdoc}
   */
  public function getCancelUrl() {
    return new Url('entity.commerce_payment_info.list');
  }

  /**
   * {@inheritdoc}
   */
  public function getConfirmText() {
    return t('Delete');
  }

  /**
   * {@inheritdoc}
   */
  public function submit(array $form, FormStateInterface $form_state) {
    try {
      $this->entity->delete();
      $payment_info_type_storage = $this->entityManager->getStorage('commerce_payment_info_type');
      $payment_info_type = $payment_info_type_storage->load($this->entity->bundle())->label();
      $form_state->setRedirectUrl($this->getCancelUrl());
      drupal_set_message($this->t('@type %payment_info_label has been deleted.', array('@type' => $payment_info_type, '%payment_info_label' => $this->entity->label())));
      watchdog('commerce_payment', '@type: deleted %payment_info_label.', array('@type' => $this->entity->bundle(), '%payment_info_label' => $this->entity->label()));
    }
    catch (\Exception $e) {
      drupal_set_message($this->t('The payment information %payment_info_label could not be deleted.', array('%payment_info_label' => $this->entity->label())), 'error');
      watchdog_exception('commerce_payment', $e);
    }
  }

}
