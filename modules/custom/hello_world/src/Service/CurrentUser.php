<?php

namespace Drupal\hello_world\Service;

use Drupal\Core\Session\AccountProxy;

/**
 * Provides a service to fetch the current logged-in user.
 */
class CurrentUser {

  /**
   * The current user service.
   *
   * @var \Drupal\Core\Session\AccountProxyInterface
   */
  protected $currentUser;

  /**
   * Constructs a CurrentUser object.
   *
   * @param \Drupal\Core\Session\AccountProxyInterface $current_user
   *   The current user service.
   */
  public function __construct(AccountProxy $current_user) {
    $this->currentUser = $current_user;
  }

  /**
   * Get the current user's name.
   *
   * @return string
   *   The current user's name.
   */
  public function getCurrentUserName() {
    return $this->currentUser->getDisplayName();
  }

}
