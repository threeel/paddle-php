<?php

namespace Paddle\Method;

class Product_GetProducts {

	/**
	 * Validate, and convert arguments to the format required by API
	 * @param int $limit
	 * @param int $offset
	 * @return array
	 * @throws \InvalidArgumentException
	 */
	public function get_products($limit = 1, $offset = 0) {
		if (!is_int($limit) || $limit < 1) {
			throw new \InvalidArgumentException(\Paddle\Api::ERR_319, 319);
		} else {
			$data['limit'] = $limit;
		}

		if (!is_int($offset) || $offset < 0) {
			throw new \InvalidArgumentException(\Paddle\Api::ERR_320, 320);
		} else {
			$data['offset'] = $offset;
		}

		return $data;
	}

}
