<?php

namespace Paddle\Method;

class User_Auth {

	/**
	 * Validate, and convert arguments to the format required by API
	 * @param string $vendor_email
	 * @param string $vendor_password
	 * @throws \InvalidArgumentException
	 */
	public function generate_auth_code($vendor_email, $vendor_password) {
		$data = array();

		// validate email (valid email)
		if (!filter_var($vendor_email, FILTER_VALIDATE_EMAIL)) {
			throw new \InvalidArgumentException(\Paddle\Api::ERR_323, 323);
		} else {
			$data['email'] = $vendor_email;
		}

		$data['password'] = $vendor_password;

		return $data;
	}

}
