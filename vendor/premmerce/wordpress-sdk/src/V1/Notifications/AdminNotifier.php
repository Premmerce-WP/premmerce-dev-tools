<?php namespace Premmerce\SDK\V1\Notifications;

class AdminNotifier{

	const ERROR = 'error';

	const WARNING = 'warning';

	const SUCCESS = 'success';

	const INFO = 'info';

	public function push($message, $type = self::SUCCESS, $isDismissible = false){
		$dismissible = $isDismissible? "is-dismissible" : '';
		add_action('admin_notices', function() use ($message, $type, $dismissible){
			echo "<div class='notice notice-{$type} {$dismissible}'><p>{$message}</p></div>";
		});
	}
}