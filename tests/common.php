<?php

require_once __DIR__ . '/test_case.php';

class Common extends Test_Case {

	public function test_api_setters() {
		$api1 = new \Paddle\Api(1,1,1);
		$api2 = new \Paddle\Api();
		$api2->set_vendor_credentials(1, 1);
		$api2->set_timeout(1);
		$this->assertEquals($api1, $api2);
	}

}
