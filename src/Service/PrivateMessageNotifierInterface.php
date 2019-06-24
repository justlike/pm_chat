<?php

namespace Drupal\pm_chat\Service;

use Drupal\pm_chat\Entity\PrivateMessageInterface;
use Drupal\pm_chat\Entity\PrivateMessageThreadInterface;

/**
 * Interface for the Private Message notification service.
 */
interface PrivateMessageNotifierInterface {

  /**
   * Send a private message notification email.
   *
   * @param \Drupal\pm_chat\Entity\PrivateMessageInterface $message
   *   The message.
   * @param \Drupal\pm_chat\Entity\PrivateMessageThreadInterface $thread
   *   The message thread.
   * @param \Drupal\user\UserInterface[] $members
   *   The message members.
   */
  public function notify(PrivateMessageInterface $message, PrivateMessageThreadInterface $thread, array $members = []);

}
