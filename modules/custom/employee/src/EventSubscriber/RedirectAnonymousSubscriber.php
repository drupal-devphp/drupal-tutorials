<?php

namespace Drupal\employee\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * Event subscriber that redirects all anonymous users to the FAQs page.
 */
class RedirectAnonymousSubscriber implements EventSubscriberInterface {

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents() {
    $events[KernelEvents::REQUEST][] = array('onRequest');
    return $events;
  }

  /**
   * Redirects anonymous users to the FAQs page.
   *
   * @param GetResponseEvent $event
   *   The event object.
   */
  public function onRequest(GetResponseEvent $event) {
    if (\Drupal::currentUser()->isAuthenticated()) {
      $response = new RedirectResponse('/faqs', 302);
      $event->setResponse($response);
    }
  }

}
