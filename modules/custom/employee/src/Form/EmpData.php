<?php
namespace Drupal\employee\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\hello_world\Controller\APIController;

class BatchForm extends FormBase {
 /**
     * {@inheritdoc}
     */
    public function getFormId() {
        return 'batch_form_id';
      }
    
      /**
       * {@inheritdoc}
       */
  public function buildForm(array $form, FormStateInterface $form_state) {
    // ... Your form build code ...
  

    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Submit'),
    ];

    return $form;
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {
    $res = new APIController();
    $resl = $res->getAPIData();
    $operations = [];
    $count = count($resl);
    foreach ($resl as $nodeData) {
      $operations[] = [
        '\Drupal\employee\CustomBatch::batchOperation',
        [
          $nodeData,
          $count
        ]
      ];
    }

    $batch = [
      'title' => t('Inserting...'),
      'operations' => $operations,
      'finished' => '\Drupal\employee\CustomBatch::batchFinished',
    ];
  
    batch_set($batch); 
  /*   $operations = [];
    for ($i = 0; $i < 300; $i++) {
      $operations[] = ['\Drupal\employee\CustomBatch::batchOperation', [$i]];
    }

    $batch = [
      'title' => t('Processing'),
      'operations' => $operations,
      'finished' => '\Drupal\employee\CustomBatch::batchFinished',
    ];
    batch_set($batch); */
    // ... Your form submit code ...
   /*  $res = new APIController();
    $resl = $res->getAPIData();
    $nids = \Drupal::entityQuery('node')
      ->condition('type', 'employee_data')
      ->sort('created', 'ASC')
      ->execute();

      $batch = array(
        'title' => t('Deleting Node...'),
        'operations' => array(
          array(
            '\Drupal\employee\CustomBatch::batchOperation',
            array($nids)
          ),
        ),
        'finished' => '\Drupal\employee\CustomBatch::batchFinished',
      );
  
      batch_set($batch); */
    //   echo "<pre>";
    //   foreach ($resl as $nodeData) {
    //    echo "<br />" . $id     = $nodeData['id'];
    //   }
     // print_r($resl);
    //   exit;

   /*  $operations = [
        ['\Drupal\employee\CustomBatch::batchOperation'],
        [$nids]
    ];

    $batch = [
      'title' => t('Processing'),
      'operations' => $operations,
      'finished' => '\Drupal\employee\CustomBatch::batchFinished',
    ];

    batch_set($batch); */

    //working
/* 
    $batch = array(
        'title' => t('Deleting Node...'),
        'operations' => array(
          array(
            '\Drupal\employee\CustomBatch::batchOperation',
            array($resl)
          ),
        ),
        'finished' => '\Drupal\employee\CustomBatch::batchFinished',
      );
  
      batch_set($batch); */
  }

}