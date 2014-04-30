<?php

/**
 * OpenCart Ukrainian Community
 *
 * LICENSE
 *
 * This source file is subject to the GNU General Public License, Version 3
 * It is also available through the world-wide-web at this URL:
 * http://www.gnu.org/copyleft/gpl.html
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email

 *
 * @category   OpenCart
 * @package    OCU Free Shipping
 * @copyright  Copyright (c) 2011 Eugene Lifescale by OpenCart Ukrainian Community (http://opencart-ukraine.tumblr.com)
 * @license    http://www.gnu.org/copyleft/gpl.html     GNU General Public License, Version 3
 */



/**
 * @category   OpenCart
 * @package    OCU Free Shipping
 * @copyright  Copyright (c) 2011 Eugene Lifescale by OpenCart Ukrainian Community (http://opencart-ukraine.tumblr.com)
 * @license    http://www.gnu.org/copyleft/gpl.html     GNU General Public License, Version 3
 */

class ModelTotalOcuFreeShipping extends Model {

	public function getTotal(&$total_data, &$total, &$taxes) {

		if ($this->cart->hasShipping() && isset($this->session->data['shipping_method']) && isset($this->session->data['shipping_zone_id'])) {

            $ocu_free_shipping_rates = $this->config->get('ocufreeshipping_rate');
            $total_products = $this->cart->countProducts();

            $query = $this->db->query("SELECT geo_zone_id FROM " . DB_PREFIX . "zone_to_geo_zone WHERE zone_id = " . (int)$this->session->data['shipping_zone_id']);

            if ($query->num_rows) {
                foreach ($query->rows as $row) {

                    foreach ($ocu_free_shipping_rates as $ocu_free_shipping_rate) {

                        if ($row['geo_zone_id'] == $ocu_free_shipping_rate['geo_zone_id']) {

                            if ($ocu_free_shipping_rate['min_product_qty'] > 0 && $total_products >= $ocu_free_shipping_rate['min_product_qty']) {
                                $this->session->data['shipping_method']['cost'] = 0;
                                break;
                            }

                            if ($ocu_free_shipping_rate['min_order_cost'] > 0 && $total >= $ocu_free_shipping_rate['min_order_cost']) {
                                $this->session->data['shipping_method']['cost'] = 0;
                                break;
                            }

                            if ($ocu_free_shipping_rate['min_order_cost'] == 0 && $ocu_free_shipping_rate['min_product_qty'] == 0) {
                                $this->session->data['shipping_method']['cost'] = 0;
                                break;
                            }
                       }
                    }
                }
            }


			$total_data[] = array(
				'code'       => 'ocufreeshipping',
        		'title'      => $this->session->data['shipping_method']['title'],
        		'text'       => $this->currency->format($this->session->data['shipping_method']['cost']),
        		'value'      => $this->session->data['shipping_method']['cost'],
				'sort_order' => $this->config->get('ocu_shipping_sort_order')
			);

			if ($this->session->data['shipping_method']['tax_class_id']) {
				$tax_rates = $this->tax->getRates($this->session->data['shipping_method']['cost'], $this->session->data['shipping_method']['tax_class_id']);

				foreach ($tax_rates as $tax_rate) {
					if (!isset($taxes[$tax_rate['tax_rate_id']])) {
						$taxes[$tax_rate['tax_rate_id']] = $tax_rate['amount'];
					} else {
						$taxes[$tax_rate['tax_rate_id']] += $tax_rate['amount'];
					}
				}
			}

			$total += $this->session->data['shipping_method']['cost'];
		}
	}
}
