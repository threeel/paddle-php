<?php

namespace Paddle\Method;

class Product_GeneratePayLink {

	/**
	 * Validate, and convert arguments to the format required by API
	 * @param int $product_id
	 * @param array $data
	 * @return array
	 * @throws \InvalidArgumentException
	 */
	public function generate_product_pay_link($product_id, array $data = array()) {
		/*
		 * Obligatory arguments
		 */

		// validate product_id (integer)
		if (
			!filter_var($product_id, FILTER_VALIDATE_INT, array('options' => array('min_range' => 1))) || !is_numeric($product_id)
		) {
			throw new \InvalidArgumentException(\Paddle\Api::ERR_300, 300);
		} else {
			$data['product_id'] = $product_id;
		}

		/*
		 * Optional arguments
		 */

		// validate title (optional, string)
		if (isset($data['title']) && !is_string($data['title'])) {
			throw new \InvalidArgumentException(\Paddle\Api::ERR_301, 301);
		}

		// validate image_url (optional, url)
		if (isset($data['image_url']) && !filter_var($data['image_url'], FILTER_VALIDATE_URL)) {
			throw new \InvalidArgumentException(\Paddle\Api::ERR_302, 302);
		}

		// validate price (optional, non negative number)
		if (isset($data['price'])) {
			if (!is_numeric($data['price'])) {
				throw new \InvalidArgumentException(\Paddle\Api::ERR_303, 303);
			}
			if ($data['price'] < 0) {
				throw new \InvalidArgumentException(\Paddle\Api::ERR_304, 304);
			}
		}

		// validate return_url (optional, url)
		if (isset($data['return_url']) && !filter_var($data['return_url'], FILTER_VALIDATE_URL)) {
			throw new \InvalidArgumentException(\Paddle\Api::ERR_305, 305);
		}

		// convert discountable (optional, boolean - transform bool to 0|1 if provided)
		if (isset($data['discountable'])) {
			if ($data['discountable']) {
				$data['discountable'] = 1;
			} else {
				$data['discountable'] = 0;
			}
		}

		// set discountable to 1 if coupon_code is provided (optional, set discountable to true if provided to avoid api error)
		if (isset($data['coupon_code'])) {
			$data['discountable'] = 1;
		}

		// convert locker_visible (optional, boolean - transform bool to 0|1 if provided)
		if (isset($data['locker_visible'])) {
			if ($data['locker_visible']) {
				$data['locker_visible'] = 1;
			} else {
				$data['locker_visible'] = 0;
			}
		}

		// convert quantity_variable (optional, boolean - transform bool to 0|1 if provided)
		if (isset($data['quantity_variable'])) {
			if ($data['quantity_variable']) {
				$data['quantity_variable'] = 1;
			} else {
				$data['quantity_variable'] = 0;
			}
		}

		// validate paypal_cancel_url (optional)
		if (isset($data['paypal_cancel_url']) && !filter_var($data['paypal_cancel_url'], FILTER_VALIDATE_URL)) {
			throw new \InvalidArgumentException(\Paddle\Api::ERR_306, 306);
		}

		// validate expires (optional, future timestamp)
		if (isset($data['expires'])) {
			if ((!filter_var($data['expires'], FILTER_VALIDATE_INT) || !is_numeric($data['expires']))) {
				throw new \InvalidArgumentException(\Paddle\Api::ERR_307, 307);
			} else if ($data['expires'] < time()) {
				throw new \InvalidArgumentException(\Paddle\Api::ERR_308, 308);
			} else {
				$data['expires'] = date('Y-m-d H:i:s', $data['expires']);
			}
		}

		// convert is_popup (optional - boolean - Must be passed as literal 'true' string. so convert if true)
		if (isset($data['is_popup'])) {
			if ($data['is_popup']) {
				$data['is_popup'] = 'true';
			} else {
				$data['is_popup'] = null;
			}
		}

		// validate parent_url (optional, valid url)
		if (isset($data['parent_url']) && !filter_var($data['parent_url'], FILTER_VALIDATE_URL)) {
			throw new \InvalidArgumentException(\Paddle\Api::ERR_309, 309);
		}

		/**
		 * affiliates - An array of checkout affiliates and their commissions.
		 * This parameter is optional. Must be an array containing at least 
		 * 1 set of affiliates. Every element should contain numeric keys, 
		 * and vendor_id:vendor_commission as value. Example commission is 
		 * '0.1', that equals 10% of checkout earnings.
		 */
		if (isset($data['affiliates'])) {
			if (!is_array($data['affiliates'])) {
				throw new \InvalidArgumentException(\Paddle\Api::ERR_310, 310);
			}

			$affiliates_tmp = array();

			foreach ($data['affiliates'] as $key => $value) {
				// validate affiliates array structure
				if (empty($key) || empty($value)) {
					throw new \InvalidArgumentException(\Paddle\Api::ERR_311, 311);
				}

				$affiliates_tmp[] = $key . ':' . $value;
			}

			$data['affiliates'] = $affiliates_tmp;
		}

		/**
		 * stylesheets - An array of custom stylesheets (CSS) that will be 
		 * used to style checkout page. Stylesheets can be defined and 
		 * managed via vendor web interface. This parameter is optional.
		 *  Must be an array containing at least 1 set of stylesheets. 
		 * Every element should contain stylesheet type as key, and code as value.
		 */
		if (isset($data['stylesheets'])) {
			if (!is_array($data['stylesheets'])) {
				throw new \InvalidArgumentException(\Paddle\Api::ERR_312, 312);
			}

			foreach ($data['stylesheets'] as $key => $value) {
				// validate stylesheets array structure
				if (empty($key) || empty($value)) {
					throw new \InvalidArgumentException(\Paddle\Api::ERR_313, 313);
				}
			}
		}

		/*
		 * Not allowed arguments
		 */

		// check if webhook_url is provided (forbidden)
		if (isset($data['webhook_url'])) {
			throw new \InvalidArgumentException(\Paddle\Api::ERR_314, 314);
		}

		return $data;
	}

	/**
	 * Validate, and convert arguments to the format required by API
	 * @param string $title
	 * @param type $price
	 * @param type $image_url
	 * @param type $webhook_url
	 * @param array $data
	 * @return string
	 * @throws \InvalidArgumentException
	 */
	public function generate_custom_product_pay_link($title, $price, $image_url, $webhook_url, array $data) {
		/*
		 * Obligatory arguments
		 */

		// validate title (string)
		if (!is_string($title)) {
			throw new \InvalidArgumentException(\Paddle\Api::ERR_301, 301);
		} else {
			$data['title'] = $title;
		}

		// validate price (non negative number)
		if (!is_numeric($price)) {
			throw new \InvalidArgumentException(\Paddle\Api::ERR_303, 303);
		} else if ($price < 0) {
			throw new \InvalidArgumentException(\Paddle\Api::ERR_304, 304);
		} else {
			$data['price'] = $price;
		}

		// validate image_url (url)
		if (!filter_var($image_url, FILTER_VALIDATE_URL)) {
			throw new \InvalidArgumentException(\Paddle\Api::ERR_302, 302);
		} else {
			$data['image_url'] = $image_url;
		}

		// validate webhook_url (url)
		if (!filter_var($webhook_url, FILTER_VALIDATE_URL)) {
			throw new \InvalidArgumentException(\Paddle\Api::ERR_315, 315);
		} else {
			$data['webhook_url'] = $webhook_url;
		}

		/*
		 * Optional arguments
		 */

		// validate return_url (optional, url)
		if (isset($data['return_url']) && !filter_var($data['return_url'], FILTER_VALIDATE_URL)) {
			throw new \InvalidArgumentException(\Paddle\Api::ERR_305, 305);
		}

		// convert locker_visible (optional, boolean - transform bool to 0|1 if provided)
		if (isset($data['locker_visible'])) {
			if ($data['locker_visible']) {
				$data['locker_visible'] = 1;
			} else {
				$data['locker_visible'] = 0;
			}
		}

		// convert quantity_variable (optional, boolean - transform bool to 0|1 if provided)
		if (isset($data['quantity_variable'])) {
			if ($data['quantity_variable']) {
				$data['quantity_variable'] = 1;
			} else {
				$data['quantity_variable'] = 0;
			}
		}

		// validate paypal_cancel_url (optional)
		if (isset($data['paypal_cancel_url']) && !filter_var($data['paypal_cancel_url'], FILTER_VALIDATE_URL)) {
			throw new \InvalidArgumentException(\Paddle\Api::ERR_306, 306);
		}

		// validate expires (optional, future timestamp)
		if (isset($data['expires'])) {
			if ((!filter_var($data['expires'], FILTER_VALIDATE_INT) || !is_numeric($data['expires']))) {
				throw new \InvalidArgumentException(\Paddle\Api::ERR_307, 307);
			} else if ($data['expires'] < time()) {
				throw new \InvalidArgumentException(\Paddle\Api::ERR_308, 308);
			} else {
				$data['expires'] = date('Y-m-d H:i:s', $data['expires']);
			}
		}

		// convert is_popup (optional - boolean - Must be passed as literal 'true' string. so convert if true)
		if (isset($data['is_popup'])) {
			if ($data['is_popup']) {
				$data['is_popup'] = 'true';
			} else {
				$data['is_popup'] = null;
			}
		}

		// validate parent_url (optional, valid url)
		if (isset($data['parent_url']) && !filter_var($data['parent_url'], FILTER_VALIDATE_URL)) {
			throw new \InvalidArgumentException(\Paddle\Api::ERR_309, 309);
		}

		/**
		 * affiliates - An array of checkout affiliates and their commissions.
		 * This parameter is optional. Must be an array containing at least 
		 * 1 set of affiliates. Every element should contain numeric keys, 
		 * and vendor_id:vendor_commission as value. Example commission is 
		 * '0.1', that equals 10% of checkout earnings.
		 */
		if (isset($data['affiliates'])) {
			if (!is_array($data['affiliates'])) {
				throw new \InvalidArgumentException(\Paddle\Api::ERR_310, 310);
			}

			$affiliates_tmp = array();

			foreach ($data['affiliates'] as $key => $value) {
				// validate affiliates array structure
				if (empty($key) || empty($value)) {
					throw new \InvalidArgumentException(\Paddle\Api::ERR_311, 311);
				}

				$affiliates_tmp[] = $key . ':' . $value;
			}

			$data['affiliates'] = $affiliates_tmp;
		}

		/**
		 * stylesheets - An array of custom stylesheets (CSS) that will be 
		 * used to style checkout page. Stylesheets can be defined and 
		 * managed via vendor web interface. This parameter is optional.
		 *  Must be an array containing at least 1 set of stylesheets. 
		 * Every element should contain stylesheet type as key, and code as value.
		 */
		if (isset($data['stylesheets'])) {
			if (!is_array($data['stylesheets'])) {
				throw new \InvalidArgumentException(\Paddle\Api::ERR_312, 312);
			}

			foreach ($data['stylesheets'] as $key => $value) {
				// validate stylesheets array structure
				if (empty($key) || empty($value)) {
					throw new \InvalidArgumentException(\Paddle\Api::ERR_313, 313);
				}
			}
		}

		/*
		 * Not allowed arguments
		 */

		// discountable (forbidden)
		if (isset($data['discountable'])) {
			throw new \InvalidArgumentException(\Paddle\Api::ERR_316, 316);
		}

		// coupon_code (forbidden)
		if (isset($data['coupon_code'])) {
			throw new \InvalidArgumentException(\Paddle\Api::ERR_317, 317);
		}

		// check product_id (forbidden)
		if (isset($data['product_id'])) {
			throw new \InvalidArgumentException(\Paddle\Api::ERR_318, 318);
		}

		return $data;
	}

}
