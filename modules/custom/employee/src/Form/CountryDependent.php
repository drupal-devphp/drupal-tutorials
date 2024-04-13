<?php

namespace Drupal\employee\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Database\Database;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\HtmlCommand;

/**
 * Provides a country dependent form.
 */
class CountryDependent extends FormBase {

  public $connection;
	public function __construct(){
		$this->connection = \Drupal::database();
	}
  
  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'CountryDependent';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $countries = $this->getCountries();
    // Add a dropdown select field for Country.
    $form['country'] = [
      '#type' => 'select',
      '#validated' => TRUE,
      '#title' => $this->t('Country'),
      '#options' => $countries,
      '#ajax' => [
        'callback' => [$this, 'getStates'],
        'disable-refocus' => FALSE,
        'event' => 'change',
        'progress' => 'throbber',
      ],
    ];

    // Add a dropdown select field for State.
    $form['state'] = [
      '#type' => 'select',
      '#validated' => TRUE,
      '#title' => $this->t('State'),
      '#attributes' => [
        'class' => ['state_select']
      ],
      '#ajax' => [
				'callback' => [$this, 'getCities'],
				'disable-refocus' => FALSE,
				'event' => 'change',
				'progress' => 'throbber',
			],
      // You can populate this list dynamically based on the selected country.
      '#options' => [
        '' => 'Select State'
      ],
    ];

    // Add a dropdown select field for City.
    $form['city'] = [
      '#type' => 'select',
      '#validated' => TRUE,
      '#title' => $this->t('City'),
      '#attributes' => [
        'class' => ['city_select']
      ],
      // You can populate this list dynamically based on the selected state.
      '#options' => [
        '' => 'Select City'
      ],
    ];

    $form['actions'] = [
      '#type' => 'actions',
    ];

    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Save'),
      '#attributes' => [
        'class' => ['btn btn-primary mb-3']
      ],
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $formField = $form_state->getValues();
    echo '<pre>';
    print_r($formField);
    exit;
  }

  /**
	 * Get countries from DB
	 */
	public function getCountries(){
		$query = $this->connection->select('country', 'cn');
		$query->fields('cn', ['id', 'name']);
    $result = $query->execute()->fetchAll();
		$countryArray = [];
    $countryArray[''] = 'Select Country';
		foreach($result as $key=>$val){
			$countryArray[$val->id] = $val->name;
		}
		return $countryArray;
	}

  /**
	 * Get states from DB.
	 */
	public function getStates(array &$element, FormStateInterface $form_state){
		$response = new AjaxResponse();
		$countryValue = $form_state->getValue('country');
		if($countryValue!=null){
			$query = $this->connection->select('state', 'st');
      $query->fields('st', ['id', 'name']);
      $query->condition('st.country_id', $countryValue);
			$result = $query->execute()->fetchAll();
			$state_options = "<option value>-Select State-</option>";
			if(!empty($result)){
				foreach ($result as $key => $value) {
				   $state_options .= "<option value='".$value->id."'>" . $value->name . "</option>";
				}
			}
			$response->addCommand(new HtmlCommand('select.state_select', $state_options));
			$response->addCommand(new HtmlCommand('select.city_select', '<option value>-Select City-</option>'));
		}
		return $response;
	}

  /**
	 * Get cities from DB
	 */
	public function getCities(array &$element, FormStateInterface $form_state){
		$response = new AjaxResponse();
		$stateValue = $form_state->getValue('state');
		if($stateValue!=null){
			$query = $this->connection->select('city', 'ct');
      $query->fields('ct', ['id', 'city_name']);
      $query->condition('ct.state_id', $stateValue);
			$result = $query->execute()->fetchAll();
			$city_options = "<option value>-Select City-</option>";
			if(!empty($result)){
				foreach ($result as $key => $value) {
				   $city_options .= "<option value='".$value->id."'>" . $value->city_name . "</option>";
				}
			}
			$response->addCommand(new HtmlCommand('select.city_select', $city_options));
		}
		return $response;
	}

}
