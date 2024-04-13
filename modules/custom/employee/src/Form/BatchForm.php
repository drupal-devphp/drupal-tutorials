<?php

namespace Drupal\employee\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\hello_world\Controller\APIController;

/**
 * Provides a employee form.
 */
class BatchForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'batch_process_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Submit'),
    ];
    return $form;                                                           
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $resultObj = new APIController();
    $result = $resultObj->getAPIData();
    
    // Batch process
    $operation = [];
    foreach ($result as $nodeData) {
      $operation[] = [
        '\Drupal\employee\CustomBatch::batchOperation',
        [$nodeData] 
      ];
    }

    $batch = [
      'title' => t('Inserting..'),
      'operations' => $operation,
      'finished' => '\Drupal\employee\CustomBatch::batchFinished',
    ];

    batch_set($batch);

  }
  
}
