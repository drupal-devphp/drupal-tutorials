<?php

namespace Drupal\hello_world\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\hello_world\Controller\APIController;

/**
 * Provides "hello world" block
 * 
 * @Block(
 *   id = "hello_world_block",
 *   admin_label = @Translation("Hello World Block"),
 *   category = @Translation("Custom block for hello world")
 * )
 */

 class HelloWorldBlock extends BlockBase {
    /**
     * {@inheritdoc}
     */
    public function build() {
      $catFactObj = new APIController;
      $fetchDataArr = [];
      for($i=0; $i<5; $i++) {
        $factData =  $catFactObj->getFact();
        $fetchDataArr[$i] = [
          'catFact' => $factData['fact'],
        ];
      } 
      return [
        '#theme' => 'hello_world_block',
        '#heading' => [
          '#markup' => 'Cat Facts',
        ],
        '#fact' => $fetchDataArr,
      ];  
    }

    /**
     * {@inheritdoc}
     */
    public function getCacheMaxAge() {
      return 0;
    }

 }
