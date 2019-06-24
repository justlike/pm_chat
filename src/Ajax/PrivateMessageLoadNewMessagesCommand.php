<?php

namespace Drupal\pm_chat\Ajax;

use Drupal\Core\Ajax\CommandInterface;

/**
 * Ajax Command to trigger a load of new private messages into a thread.
 */
class PrivateMessageLoadNewMessagesCommand implements CommandInterface {

  /**
   * {@inheritdoc}
   */
  public function render() {
    return [
      'command' => 'loadNewPrivateMessages',
    ];
  }

}
