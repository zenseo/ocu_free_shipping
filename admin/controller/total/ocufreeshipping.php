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

class ControllerTotalOcuFreeShipping extends Controller {

	private $error = array();

	public function index() {

		$this->load->language('total/ocufreeshipping');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');
        $this->load->model('localisation/geo_zone');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && ($this->validate())) {
			$this->model_setting_setting->editSetting('ocufreeshipping', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->redirect($this->url->link('extension/total', 'token=' . $this->session->data['token'], 'SSL'));
		}



		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_min_product_qty'] = $this->language->get('text_min_product_qty');
		$this->data['text_min_order_cost'] = $this->language->get('text_min_order_cost');
		$this->data['text_geo_zone'] = $this->language->get('text_geo_zone');
		$this->data['text_shipping_text_rate_not_found'] = $this->language->get('text_shipping_text_rate_not_found');

		$this->data['entry_estimator'] = $this->language->get('entry_estimator');
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');

		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');
        $this->data['button_shipping_add_rate'] = $this->language->get('button_shipping_add_rate');
        $this->data['button_shipping_remove'] = $this->language->get('button_shipping_remove');

		$this->data['tab_shipping_general'] = $this->language->get('tab_shipping_general');
		$this->data['tab_shipping_rate'] = $this->language->get('tab_shipping_rate');

		$this->data['button_shipping_add_rate'] = $this->language->get('button_shipping_add_rate');


        $this->data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();

        if (isset($this->request->post['ocufreeshipping_rate'])) {
            $this->data['shipping_rate'] = $this->request->post['ocufreeshipping_rate'];
        } elseif ($this->config->get('ocufreeshipping_rate')) {
            $this->data['shipping_rate'] = $this->config->get('ocufreeshipping_rate');
        } else {
            $this->data['shipping_rate'] = array();
        }


 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

   		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_total'),
			'href'      => $this->url->link('extension/total', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('total/ocufreeshipping', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);

		$this->data['action'] = $this->url->link('total/ocufreeshipping', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['cancel'] = $this->url->link('extension/total', 'token=' . $this->session->data['token'], 'SSL');

		if (isset($this->request->post['ocufreeshipping_estimator'])) {
			$this->data['ocufreeshipping_estimator'] = $this->request->post['ocufreeshipping_estimator'];
		} else {
			$this->data['ocufreeshipping_estimator'] = $this->config->get('ocufreeshipping_estimator');
		}

		if (isset($this->request->post['ocufreeshipping_status'])) {
			$this->data['ocufreeshipping_status'] = $this->request->post['ocufreeshipping_status'];
		} else {
			$this->data['ocufreeshipping_status'] = $this->config->get('ocufreeshipping_status');
		}

		if (isset($this->request->post['ocufreeshipping_sort_order'])) {
			$this->data['ocufreeshipping_sort_order'] = $this->request->post['ocufreeshipping_sort_order'];
		} else {
			$this->data['ocufreeshipping_sort_order'] = $this->config->get('ocufreeshipping_sort_order');
		}

		$this->template = 'total/ocufreeshipping.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	private function validate() {
		if (!$this->user->hasPermission('modify', 'total/ocufreeshipping')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}
}
