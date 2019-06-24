<?php

namespace Drupal\pm_chat\Service;

use Drupal\Core\Session\AccountInterface;
use Drupal\pm_chat\Entity\PrivateMessageInterface;
use Drupal\pm_chat\Entity\PrivateMessageThreadInterface;

/**
 * The Private Message generator class.
 *
 * @package Drupal\pm_chat\Service
 */
class PrivateMessageThreadManager implements PrivateMessageThreadManagerInterface {

  /**
   * The private message service.
   *
   * @var \Drupal\pm_chat\Service\PrivateMessageServiceInterface
   */
  private $privateMessageService;

  /**
   * The private message notifier service.
   *
   * @var \Drupal\pm_chat\Service\PrivateMessageNotifierInterface
   */
  private $privateMessageNotifier;

  /**
   * The private message.
   *
   * @var \Drupal\pm_chat\Entity\PrivateMessageInterface
   */
  private $message;

  /**
   * The message recipients.
   *
   * @var \Drupal\Core\Session\AccountInterface[]
   */
  private $recipients = [];

  /**
   * An array of members to exclude from notifications.
   *
   * @var \Drupal\Core\Session\AccountInterface[]
   */
  private $excludeFromNotification = [];

  /**
   * The private message thread.
   *
   * @var \Drupal\pm_chat\Entity\PrivateMessageThreadInterface|null
   */
  private $thread;

  /**
   * PrivateMessageThreadManager constructor.
   *
   * @param \Drupal\pm_chat\Service\PrivateMessageServiceInterface $privateMessageService
   *   The private message service.
   * @param \Drupal\pm_chat\Service\PrivateMessageNotifierInterface $privateMessageNotifier
   *   The private message notifier service.
   */
  public function __construct(
    PrivateMessageServiceInterface $privateMessageService,
    PrivateMessageNotifierInterface $privateMessageNotifier
  ) {
    $this->privateMessageService = $privateMessageService;
    $this->privateMessageNotifier = $privateMessageNotifier;
  }

  /**
   * {@inheritdoc}
   */
  public function saveThread(PrivateMessageInterface $message, array $recipients = [], array $excludeFromNotification = [], PrivateMessageThreadInterface $thread = NULL) {
    $this->message = $message;
    $this->thread = $thread;
    $this->recipients = $recipients;
    $this->excludeFromNotification = $excludeFromNotification;

    $this->getThread()
      ->addMessage()
      ->sendNotification();
  }

  /**
   * If no thread is defined, load one from the thread members.
   *
   * @return $this
   */
  private function getThread() {
    if (is_null($this->thread)) {
      $this->thread = $this->privateMessageService->getThreadForMembers($this->recipients);
    }

    return $this;
  }

  /**
   * Add the new message to the thread.
   *
   * @return $this
   */
  private function addMessage() {
    $this->thread->addMessage($this->message);
    $this->thread->save();

    return $this;
  }

  /**
   * Send the notification.
   *
   * @return $this
   */
  private function sendNotification() {
    $this->privateMessageNotifier->notify($this->message, $this->thread, $this->getNotificationRecipients());

    return $this;
  }

  /**
   * The users to receive notifications.
   *
   * @return \Drupal\Core\Session\AccountInterface[]
   *   An array of  Account objects of the thread memebers who are to receive
   *   the notification.
   */
  private function getNotificationRecipients() {
    if (empty($this->excludeFromNotification)) {
      return $this->recipients;
    }

    return array_filter($this->recipients, function (AccountInterface $account) {
      // If this user is in the excluded list, filter them from the recipients
      // list so they do not receive the notification.
      return !in_array($account, $this->excludeFromNotification);
    });
  }

}
