<?php

namespace Drupal\employee\Service;

use Drupal\Core\Session\AccountProxy;

class CurrentUserName {

  /**
   * The current user service
   * 
   * @var Drupal\Core\Session\AccountProxy
   */
  protected $current_user;

  public function __construct(AccountProxy $currentUser){
    $this->current_user = $currentUser;
  }

  // This function will return current logged in username.
  public function getCurrentUserName(){
    return $this->current_user->getDisplayName();
  }
  
}