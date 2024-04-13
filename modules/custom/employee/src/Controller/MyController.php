<?php
namespace Drupal\employee\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Form\FormBuilderInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\OpenModalDialogCommand;


class MyController extends ControllerBase {

  protected $formBuilder;

  public function __construct(FormBuilderInterface $form_builder) {
    $this->formBuilder = $form_builder;
  }

  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('form_builder')
    );
  }

  public function displayFormPopup() {
    $response = new AjaxResponse();

    $form = \Drupal::formBuilder()->getForm('Drupal\employee\Form\EmployeeForm');
    $response->addCommand(new openModalDialogCommand('my form',$form,[
      'width' => '800'
    ]));
    return $response;
  }
}