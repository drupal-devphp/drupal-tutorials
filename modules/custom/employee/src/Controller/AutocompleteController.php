<?php

namespace Drupal\employee\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class AutocompleteController extends ControllerBase {

  public function handleAutocomplete(Request $request) {
    $matches = [];
    $string = $request->query->get('q');

    if(strlen($string) >= 3) {
      $query = \Drupal::entityQuery('node')
        ->condition('status', 1)
        ->condition('type', 'employee_data')
        ->condition('title', '%' . $string .'%', 'LIKE')
        ->range(0,10);
      $nids = $query->execute();

      if(!empty($nids)) {
        $nodes = \Drupal::entityTypeManager()->getStorage('node')->loadMultiple($nids);
        foreach($nodes as $node) {
          $matches[] = [
            'value' => $node->getTitle(),
            'label' => $node->getTitle()
          ];
        }
      }
      else {
        $matches[] = [
          'value' => '',
          'label' => $this->t('No node found!')
        ];
      }
    }
    return new JsonResponse($matches);
  }
}
