<?php

namespace Paddle\Method;

class User_Getcode {

	/**
	 * Validate, and convert arguments to the format required by API
	 * @param string $application_name
	 * @param string $application_description
	 * @param string $application_icon_url
	 * @return array
	 * @throws \InvalidArgumentException
	 */
	public function register_external_application($application_name, $application_description, $application_icon_url) {
		$data = array();
		$data['name'] = $application_name;
		$data['description'] = $application_description;

		// validate icon (url)
		if (!filter_var($application_icon_url, FILTER_VALIDATE_URL)) {
			throw new \InvalidArgumentException(\Paddle\Api::ERR_324, 324);
		} else {
			$data['icon'] = $application_icon_url;
		}

		return $data;
	}

}
