<?php

namespace alikdex\devicedetect;

use Yii;
use Detection\MobileDetect;

class DeviceDetect extends \yii\base\Component
{

	private $_mobileDetect;

	// Automatically set view parameters based on device type
	public $setParams = false;

	public function __call($name, $parameters) {
		return call_user_func_array(
			array($this->_mobileDetect, $name),
			$parameters
		);
	}

	public function __construct($config = array()) {
		parent::__construct($config);
	}

	public function init() {
		$this->_mobileDetect = new MobileDetect();
		parent::init();

		if ($this->setParams) {
			\Yii::$app->params['devicedetect'] = [
				'isMobile' => $this->_mobileDetect->isMobile(),
				'isTablet' => $this->_mobileDetect->isTablet()
			];

			\Yii::$app->params['devicedetect']['isDesktop'] =
				!\Yii::$app->params['devicedetect']['isMobile'] &&
				!\Yii::$app->params['devicedetect']['isTablet'];
		}
	}

}
