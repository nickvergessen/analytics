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
use OCP\AppFramework\Bootstrap\IBootContext;
use OCP\AppFramework\Bootstrap\IBootstrap;
use OCP\AppFramework\Bootstrap\IRegistrationContext;
use OCP\AppFramework\QueryException;
use OCP\EventDispatcher\IEventDispatcher;
use OCP\Notification\IManager;

class Application20 extends App implements IBootstrap
{

    public function __construct(array $urlParams = [])
    {
        parent::__construct('analytics', $urlParams);
    }

	public function register(IRegistrationContext $context): void {
		$context->registerDashboardWidget(Widget::class);
	}

	public function boot(IBootContext $context): void {
		$context->getServerContainer()->get(IManager::class)->registerNotifierService(Notifier::class);
		$this->registerNotificationNotifier();

		$server = $this->getContainer()->getServer();
		/** @var IEventDispatcher $dispatcher */
		try {
			$dispatcher = $server->query(IEventDispatcher::class);
		} catch (QueryException $e) {
		}

		Operation::register($dispatcher);
	}
}
