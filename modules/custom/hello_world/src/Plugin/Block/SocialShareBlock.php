<?php

namespace Drupal\hello_world\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Custom block to display social share button.
 *
 * @Block(
 *   id = "social_share",
 *   admin_label = @Translation("Social Share Block"),
 *   category = @Translation("Custom"),
 * )
 */
class SocialShareBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $build = [
      '#markup' => 'https://www.facebook.com/sharer/sharer.php?u=https://www.example.com/'
    ];

    return $build;
  }

}
