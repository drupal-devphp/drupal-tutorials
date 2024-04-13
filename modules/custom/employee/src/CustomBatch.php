<?php
namespace Drupal\employee;

use Drupal\node\Entity\Node;

class CustomBatch {
  public static function batchOperation($nodeData, &$context) {
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
  }

  public static function batchFinished($success, $results, $operations) {
    if($success) {
      $message = \Drupal::translation()->formatPlural(
      count($results),
      'One node created successfully',
      '@count nodes are created successfully',
    );
    }
    else {
      $message = t('Some error occured during batch process');
    }
    \Drupal::messenger()->addStatus($message);
  }
}