<?php

namespace Drupal\employee;
use Drupal\node\Entity\Node;

class CustomBatch {

public static function batchOperation($nodeData, $count, &$context) {
  // if (!isset($context['results'])) {
  //   $context['results'] = [];
  // }
  $id     = $nodeData['id'];
  $name   = $nodeData['name'];
  $email  = $nodeData['email'];
  $gender = $nodeData['gender'];
  $status = $nodeData['status'];
  $node = Node::create([
    'type'     => 'employee_data',
    'title'    => $name,
    'field_id' => $id,
    'field_name' => $name,
    'field_email' => $email,
    'field_gender' => $gender,
    'field_status' => $status
  ]);
  $node->save();
  $context['results'][] = $nodeData;
  $context['message'] = t('Processed @count of @data', ['@count' => count($context['results']), '@data' => $count]);
  //---------------
 /*  if (!isset($context['results'])) {
    $context['results'] = [];
  }

  $context['results'][] = $i;
  $context['message'] = t('Processed @count of 5', ['@count' => count($context['results'])]); */
   /*  $message = 'Deleting Node...';
    $results = array();
    foreach ($resl as $nid) {
      $node = Node::load($nid);
      $results[] = $node->delete();
    }
    $context['message'] = $message;
    $context['results'] = $results; */
    /* $message = 'Inserting Node...';
    $results = [];
    $i = 1;
    foreach ($resl as $nodeData) {
        $id     = $nodeData['id'];
        $name   = $nodeData['name'];
        $email  = $nodeData['email'];
        $gender = $nodeData['gender'];
        $status = $nodeData['status'];
        $node = Node::create([
            'type'     => 'employee_data',
            'title'    => $name,
            'field_id' => $id,
            'field_name' => $name,
            'field_email' => $email,
            'field_gender' => $gender,
            'field_status' => $status
        ]);
    
        $node->save();
        $results[] = $i;
        $i++;
    }
    $context['results'] = $results;
    $context['message'] = t('Processed @count of @data', ['@count' => count($context['results']), '@data' => count($resl)]); */
    
}

public static function batchFinished($success, $results, $operations) {
  if ($success) {
   $message = \Drupal::translation()->formatPlural(
    count($results),
    'One node created successfully.', '@count nodes created successfully.'
  );
  }
  else {
    $message = t('Finished with an error.');
  }
  \Drupal::messenger()->addStatus($message);
}

}