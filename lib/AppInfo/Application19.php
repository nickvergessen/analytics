<?php
/**
 * Analytics
 *
 * This file is licensed under the Affero General Public License version 3 or
 * later. See the LICENSE.md file.
 *
 * @author Marcel Scherello <audioplayer@scherello.de>
 * @copyright 2020 Marcel Scherello
 */

namespace OCA\Analytics\AppInfo;

use OCA\Analytics\Dashboard\Widget;
use OCA\Analytics\Flow\Operation;
use OCA\Analytics\Notification\Notifier;
use OCP\AppFramework\App;
use OCP\AppFramework\QueryException;
use OCP\Dashboard\RegisterPanelEvent;
use OCP\EventDispatcher\IEventDispatcher;
use OCP\Util;

class Application19 extends App
{

    public function __construct(array $urlParams = [])
    {
        parent::__construct('analytics', $urlParams);
    }

    public function register()
    {
        $this->registerNotificationNotifier();

        $server = $this->getContainer()->getServer();
        /** @var IEventDispatcher $dispatcher */
        try {
            $dispatcher = $server->query(IEventDispatcher::class);
        } catch (QueryException $e) {
            // no action
        }

        Operation::register($dispatcher);
    }

    protected function registerNotificationNotifier()
    {
        $notificationManager = \OC::$server->getNotificationManager();
        // as of NC17
        if (method_exists($notificationManager, 'registerNotifierService')) {
            \OC::$server->getNotificationManager()->registerNotifierService(Notifier::class);
        }
    }
}
