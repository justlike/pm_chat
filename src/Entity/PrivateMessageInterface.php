<?php

namespace Drupal\pm_chat\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface defining a Private Message entity.
 *
 * @ingroup private_message
 */
interface PrivateMessageInterface extends ContentEntityInterface, EntityOwnerInterface {

  /**
   * Get the time at which the private message was created.
   *
   * @return int
   *   A Unix timestamp indicating the time at which the private message was
   *   created.
   */
  public function getCreatedTime();

}
