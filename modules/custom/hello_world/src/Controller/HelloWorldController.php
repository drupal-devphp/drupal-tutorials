<?php

namespace Drupal\hello_world\Controller;

use Symfony\Component\HttpFoundation\Request;

class HelloWorldController {
  public function message() {
    return [
      '#markup' => 'Hello World message from custom module'  
    ];
  }

  public function demoData() {
    $arr = [
      'name' => 'Dummy',
      'age' => 25
    ];
    return [
      '#variable1' => 2,
      '#arr' => $arr,
      '#theme' => 'pass_variable_template'
    ];
  }

  public function getUrlParams($param1, $param2){
    $output = 'Parameter 1: ' . $param1 . '<br>';
    $output .= 'Parameter 2: ' . $param2 ;
    echo $output;
    exit;
  }

  public function getParams(Request $request) {
    $name = $request->request->get('name');
    echo $name;
    exit;
    echo "<pre>";
    print_r($id);
    exit;
  }
}
