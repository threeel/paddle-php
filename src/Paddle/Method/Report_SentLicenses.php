<?php

namespace Paddle\Method;

class Report_SentLicenses {

	/**
	 * Validate, and convert arguments to the format required by API
	 * @param int $product_id
	 * @return array
	 * @throws \InvalidArgumentException
	 */
	public function generate_sent_licenses_report($product_id = null) {
		$data = array();

		// validate product_id (positive integer)
		if (
			isset($product_id) && 
			(!filter_var($product_id, FILTER_VALIDATE_INT, array('options' => array('min_range' => 1))) || !is_numeric($product_id))
		) {
			throw new \InvalidArgumentException(\Paddle\Api::ERR_300, 300);
		} else {
			$data['product_id'] = $product_id;
		}

		return $data;
	}

}
