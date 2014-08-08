<?php

/**
 * @file
 * Contains \Drupal\commerce\Entity\CommerceProduct.
 */

namespace Drupal\commerce_product\Entity;

use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Field\FieldDefinition;
use Drupal\Core\Entity\ContentEntityBase;
use Drupal\commerce_product\CommerceProductInterface;
use Drupal\Core\Entity\EntityTypeInterface;

/**
 * Defines the Commerce Product entity.
 *
 * @TODO add a data table to this definition
 *
 * @ContentEntityType(
 *   id = "commerce_product",
 *   label = @Translation("Product"),
 *   controllers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\commerce_product\CommerceProductListBuilder",
 *     "form" = {
 *       "add" = "Drupal\commerce_product\Form\CommerceProductForm",
 *       "edit" = "Drupal\commerce_product\Form\CommerceProductForm",
 *       "delete" = "Drupal\commerce_product\Form\CommerceProductDeleteForm"
 *     },
 *     "translation" = "Drupal\content_translation\ContentTranslationHandler"
 *   },
 *   admin_permission = "administer commerce_product entities",
 *   fieldable = TRUE,
 *   translatable = TRUE,
 *   base_table = "commerce_product",
 *   revision_table = "commerce_product_revision",
 *   revision_data_table = "commerce_product_field_revision",
 *   uri_callback = "commerce_product_uri",
 *   entity_keys = {
 *     "id" = "product_id",
 *     "label" = "title",
 *     "uuid" = "uuid",
 *     "revision" = "revision_id",
 *     "bundle" = "type"
 *   },
 *   links = {
 *     "edit-form" = "commerce_product.edit",
 *     "delete-form" = "commerce_product.delete",
 *     "admin-form" = "commerce_product.product_type_edit"
 *   },
 *   bundle_entity_type = "commerce_product_type"
 * )
 */
class CommerceProduct extends ContentEntityBase implements CommerceProductInterface {
  /**
   * {@inheritdoc}
   */
  public function getSku() {
    return $this->get('sku')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setSku($sku) {
    $this->set('sku', $sku);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getTitle() {
    return $this->get('title')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setTitle($title) {
    $this->set('title', $title);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getStatus() {
    return $this->get('status')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setStatus($status) {
    $this->set('status', $status);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getDescription() {
    return $this->get('description')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setDescription($description) {
    $this->set('description', $description);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getCreatedTime() {
    return $this->get('created')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setCreatedTime($timestamp) {
    $this->set('created', $timestamp);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getType() {
    return $this->get('type')->value;
  }
  /**
   * {@inheritdoc}
   */
  public function getData() {
    return $this->get('data')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function getUid() {
    $this->get('uid')->value;
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function setUid($uid) {
    return $this->set('uid', $uid);
  }

  /**
   * {@inheritdoc}
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {
    // Product ID
    $fields['product_id'] = FieldDefinition::create('integer')
      ->setLabel(t('Product ID'))
      ->setDescription(t('The ID of the product.'))
      ->setReadOnly(TRUE);

    // Revision ID
    $fields['revision_id'] = FieldDefinition::create('integer')
      ->setLabel(t('Revision ID'))
      ->setDescription(t('The product revision ID.'))
      ->setReadOnly(TRUE)
      ->setSetting('unsigned', TRUE);

    // uid
    $fields['uid'] = FieldDefinition::create('entity_reference')
      ->setLabel(t('Author'))
      ->setDescription(t('The user that created this product.'))
      ->setRevisionable(TRUE)
      ->setSetting('target_type', 'user')
      ->setTranslatable(TRUE);

    // UUID
    $fields['uuid'] = FieldDefinition::create('uuid')
      ->setLabel(t('UUID'))
      ->setDescription(t('The UUID of the product.'))
      ->setReadOnly(TRUE);

    // Language
    $fields['language'] = FieldDefinition::create('language')
      ->setLabel(t('Language code'))
      ->setDescription(t('The language code of product.'))
      ->setRevisionable(TRUE);

    // Title
    $fields['title'] = FieldDefinition::create('string')
      ->setLabel(t('Title'))
      ->setDescription(t('The title of this node, always treated as non-markup plain text.'))
      ->setRequired(TRUE)
      ->setTranslatable(TRUE)
      ->setRevisionable(TRUE)
      ->setSettings(array(
        'default_value' => '',
        'max_length' => 255,
        'text_processing' => 0,
      ))
      ->setDisplayOptions('view', array(
        'label' => 'hidden',
        'type' => 'string',
        'weight' => -5,
      ))
      ->setDisplayOptions('form', array(
        'type' => 'string',
        'weight' => -5,
      ))
      ->setDisplayConfigurable('form', TRUE);

    // Description
    $fields['description'] = FieldDefinition::create('text_long')
      ->setLabel(t('Description'))
      ->setDescription(t('The description of this product.'))
      ->setTranslatable(TRUE)
      ->setRevisionable(TRUE)
      ->setSettings(array(
        'default_value' => '',
      ))
      ->setDisplayOptions('view', array(
        'label' => 'hidden',
        'type' => 'string',
        'weight' => -3,
      ))
      ->setDisplayOptions('form', array(
        'type' => 'text_textarea',
        'weight' => -3,
      ))
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    // SKU
    $fields['sku'] = FieldDefinition::create('string')
      ->setLabel(t('SKU'))
      ->setDescription(t('The unique, human-readable identifier for a product.'))
      ->setRequired(TRUE)
      ->setTranslatable(TRUE)
      ->setRevisionable(TRUE)
      ->setDisplayOptions('view', array(
        'label' => 'hidden',
        'type' => 'string',
        'weight' => -4,
      ))
      ->setDisplayOptions('form', array(
        'type' => 'string',
        'weight' => -4,
      ))
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    // Type
    $fields['type'] = FieldDefinition::create('string')
      ->setLabel(t('Type'))
      ->setDescription(t('The type of the product.'))
      ->setRequired(TRUE);

    // Data
    $fields['data'] = FieldDefinition::create('map')
      ->setLabel(t('Data'))
      ->setDescription(t('A serialized array of additional data.'))
      ->setRevisionable(TRUE);

    // Status
    // @todo there should be a way to set the default value from here but I
    // haven't figured out how yet.
    $fields['status'] = FieldDefinition::create('boolean')
      ->setLabel(t('Active'))
      ->setDescription(t('Disabled products cannot be added to shopping carts and may be hidden in administrative product lists.'))
      ->setRevisionable(TRUE)
      ->setTranslatable(TRUE)
      ->setSettings(array(
        'default_value' => 1,
      ))
      ->setDisplayOptions('form', array(
        'type' => 'boolean_checkbox',
        'weight' => -5,
        'settings' => array(
          'display_label' => TRUE
        )
      ))
      ->setDisplayConfigurable('form', TRUE);

    // Created
    $fields['created'] = FieldDefinition::create('created')
      ->setLabel(t('Created'))
      ->setDescription(t('The time that the product was created.'))
      ->setRevisionable(TRUE)
      ->setTranslatable(TRUE);

    // Changed
    $fields['changed'] = FieldDefinition::create('changed')
      ->setLabel(t('Changed'))
      ->setDescription(t('The time that the product was last edited.'))
      ->setRevisionable(TRUE)
      ->setTranslatable(TRUE);

    // @todo add price field once price field type exists.

    return $fields;
  }
}
