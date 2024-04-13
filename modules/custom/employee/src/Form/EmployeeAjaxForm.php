<?php

namespace Drupal\Employee\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\HtmlCommand;
use Drupal\Core\Ajax\InvokeCommand;
use Drupal\Core\Database\Database;
use Drupal\Core\Entity\Element\EntityAutocomplete;

/**
 * Provides a employee form.
 */
class EmployeeAjaxForm extends FormBase {

    /**
     * {@inheritdoc}
     */
    public function getFormId() {
      return 'employee_ajax';
    }
  
    /**
     * {@inheritdoc}
     */
    public function buildForm(array $form, FormStateInterface $form_state) {

      $tempstore = \Drupal::service('tempstore.private')->get('employee');
      $data = $tempstore->get('my_key');
      $form['element'] = [
        '#type' => 'markup',
        '#markup' => "<div class='success'></div>",
      ];

      $form['emp_firstname'] = [
        '#type' => 'textfield',
        '#title' => $this->t('First Name'),
        '#maxlength' => 30,
        '#default_value' => $data,
        '#suffix' => '<div class = "error" id = "emp_firstname"></div>',
        
      ];      
  
      $form['emp_lastname'] = [
        '#type' => 'textfield',
        '#title' => $this->t('Last Name'),
        '#maxlength' => 30,
        '#suffix' => '<div class = "error" id = "emp_lastname"></div>',
      ];
  
      $form['emp_email'] = [
        '#type' => 'textfield',
        '#title' => $this->t('Employee Email'),
        '#maxlength' => 100,
        '#suffix' => '<div class = "error" id = "emp_email"></div>',
      ];
      
      $form['emp_zipcode'] = [
        '#type' => 'textfield',
        '#title' => $this->t('Employee ZIP code'),
        '#maxlength' => 6,
        '#suffix' => '<div class = "error" id = "emp_zip"></div>',
      ];
  
      $form['actions'] = [
        '#type' => 'actions',
      ];
  
      $form['actions'] = [
        '#type' => 'button',
        '#value' => $this->t('Save'),
        '#ajax' => [
            'callback' => '::submitData',
        ],
      ];
      $form['#attached']['library'][] = 'employee/employee_js_css';
      return $form;
    }

    public function submitData(array &$form, FormStateInterface $form_state) {
        $ajax_response = new AjaxResponse();
        $conn = Database::getConnection();

        $formField = $form_state->getValues();

        $flag = TRUE;
        if(trim($formField['emp_firstname']) == '') {
          return $ajax_response->addCommand(new HtmlCommand('#emp_firstname', 'Please enter the first name'));
          $flag = FALSE;
        }

        if(trim($formField['emp_lastname']) == '') {
          return $ajax_response->addCommand(new HtmlCommand('#emp_lastname', 'Please enter the last name'));
          $flag = FALSE;
        }

        if(trim($formField['emp_email']) == '') {
          return $ajax_response->addCommand(new HtmlCommand('#emp_email', 'Please enter the email'));
          $flag = FALSE;
        }

        if(trim($formField['emp_zipcode']) == '') {
          return $ajax_response->addCommand(new HtmlCommand('#emp_zip', 'Please enter the zipcode'));
          $flag = FALSE;
        }
        
        if($flag) {
          $formData['emp_firstname'] = $formField['emp_firstname'];
          $formData['emp_lastname'] = $formField['emp_lastname'];
          $formData['emp_email'] = $formField['emp_email'];
          $formData['emp_zipcode'] = $formField['emp_zipcode'];

          $conn->insert('employee')
            ->fields($formData)
            ->execute();
          $ajax_response->addCommand(new InvokeCommand('#edit-emp-firstname', 'val', ['']));
          $ajax_response->addCommand(new InvokeCommand('#edit-emp-lastname', 'val', ['']));
          $ajax_response->addCommand(new InvokeCommand('#edit-emp-email', 'val', ['']));
          $ajax_response->addCommand(new InvokeCommand('#edit-emp-zipcode', 'val', ['']));
          $ajax_response->addCommand(new HtmlCommand('.success', 'Form submitted successfully'));
          return $ajax_response;
        }

    }
  
    /**
     * {@inheritdoc}
     */
    public function submitForm(array &$form, FormStateInterface $form_state) {
    }
  
  }
  