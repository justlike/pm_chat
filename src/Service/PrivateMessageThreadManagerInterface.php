<?php

namespace Drupal\pm_chat\Service;

use Drupal\pm_chat\Entity\PrivateMessageInterface;
use Drupal\pm_chat\Entity\PrivateMessageThreadInterface;

/**
 * Handles the generation/update of private messages, threads, and metadata.
 *
 * @package Drupal\pm_chat\Service
 */
interface PrivateMessageThreadManagerInterface {

  /**
   * Saves a private message thread.
   *
   * A new thread will be created if one does not already exist.
   *
   * @param \Drupal\pm_chat\Entity\PrivateMessageInterface $message
   *   The new message object.
   * @param array $recipients
   *   (optional) An array of message recipients. Defaults to an empty array.
   * @param array $excludeFromMail
   *   (optional) An array of members to exclude from notification emails.
   *   Defaults to an empty array.
   * @param \Drupal\pm_chat\Entity\PrivateMessageThreadInterface|null $thread
   *   (optional) The private message thread. If NULL, one will be loaded
   *   using the recipients array.
   */
  public function saveThread(PrivateMessageInterface $message, array $recipients = [], array $excludeFromMail = [], PrivateMessageThreadInterface $thread = NULL);

}
