<?php

namespace Paddle\Method;

class Report_Orders {

	/**
	 * Validate, and convert arguments to the format required by API
	 * @param int $product_id
	 * @return array
	 * @throws \InvalidArgumentException
	 */
	public function generate_orders_report($product_id = null, $start_timestamp = null, $end_timestamp = null) {
		$data = array();

		// validate product_id (integer)
		if (
			isset($product_id) &&
			(!filter_var($product_id, FILTER_VALIDATE_INT, array('options' => array('min_range' => 1))) || !is_numeric($product_id))
		) {
			throw new \InvalidArgumentException(\Paddle\Api::ERR_300, 300);
		} else {
			$data['product_id'] = $product_id;
		}

		// validate start_timestamp (timestamp)
		if (
			isset($start_timestamp) &&
			(!filter_var($start_timestamp, FILTER_VALIDATE_INT) || !is_numeric($start_timestamp))
		) {
			throw new \InvalidArgumentException(\Paddle\Api::ERR_321, 321);
		} else {
			$data['from_date'] = date('Y-m-d H:i:s', $start_timestamp);
		}

		// validate end_timestamp (timestamp)
		if (
			isset($end_timestamp) &&
			(!filter_var($end_timestamp, FILTER_VALIDATE_INT) || !is_numeric($end_timestamp))
		) {
			throw new \InvalidArgumentException(\Paddle\Api::ERR_322, 322);
		} else {
			$data['to_date'] = date('Y-m-d H:i:s', $end_timestamp);
		}

		return $data;
	}

}
