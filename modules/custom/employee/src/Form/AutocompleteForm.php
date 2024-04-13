<?php

namespace Drupal\employee\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

class AutocompleteForm extends FormBase {
  
  public function getFormId() {
    return 'autocomplete_search';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['search_node'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Search Users'),
      '#autocomplete_route_name' => 'employee.autocomplete',
    ];
    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Submit'),
    ];
    return $form;
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {
    echo $form_data = $form_state->getValue('search_node');
    exit;
  }
}
