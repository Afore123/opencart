<?php
class ControllerPaymentExalt extends Controller {
  private $error = array();
 
  public function index() {
    
	$this->load->language('payment/exalt');
	$this->document->setTitle('Exalt Payment Method Configuration');
    $this->load->model('setting/setting');
 
    if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
      $this->model_setting_setting->editSetting('exalt', $this->request->post);

      $this->session->data['success'] = $this->language->get('text_success');

      $this->response->redirect($this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL'));
 }
   $data['heading_title'] = $this->language->get('heading_title');
   $data['text_edit'] = $this->language->get('text_edit');
    $data['text_enabled'] = $this->language->get('text_enabled');
    $data['text_disabled'] = $this->language->get('text_disabled');
    $data['text_all_zones'] = $this->language->get('text_all_zones');
    $data['text_test'] = $this->language->get('text_test');
    $data['text_live'] = $this->language->get('text_live');
    $data['entry_login'] = $this->language->get('entry_login');
    $data['entry_key'] = $this->language->get('entry_key');
    $data['entry_server'] = $this->language->get('entry_server');
    $data['entry_mode'] = $this->language->get('entry_mode');
    $data['entry_method'] = $this->language->get('entry_method');
    $data['entry_total'] = $this->language->get('entry_total');
    $data['entry_order_status'] = $this->language->get('entry_order_status');
    $data['entry_geo_zone'] = $this->language->get('entry_geo_zone');
    $data['entry_status'] = $this->language->get('entry_status');
    $data['entry_sort_order'] = $this->language->get('entry_sort_order');
    $data['button_save'] = $this->language->get('button_save');
    $data['button_cancel'] = $this->language->get('button_cancel');

    $data['breadcrumbs'] = array();

    $data['breadcrumbs'][] = array(
      'text' => $this->language->get('text_home'),
      'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
    );

    $data['breadcrumbs'][] = array(
      'text' => $this->language->get('text_payment'),
      'href' => $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL')
    );

    $data['breadcrumbs'][] = array(
      'text' => $this->language->get('heading_title'),
      'href' => $this->url->link('payment/exalt', 'token=' . $this->session->data['token'], 'SSL')
    );

    $data['action'] = $this->url->link('payment/exalt', 'token=' . $this->session->data['token'], 'SSL');
    $data['cancel'] = $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL');

    if (isset($this->request->post['exalt_login'])) {
      $data['exalt_login'] = $this->request->post['exalt_login'];
    } else {
      $data['exalt_login'] = $this->config->get('exalt_login');
    }

    if (isset($this->request->post['exalt_key'])) {
      $data['exalt_key'] = $this->request->post['exalt_key'];
    } else {
      $data['exalt_key'] = $this->config->get('exalt_key');
    }
   
      if (isset($this->request->post['exalt_method'])) {
      $data['exalt_method'] = $this->request->post['exalt_method'];
    } else {
      $data['exalt_method'] = $this->config->get('exalt_method');
    }

    if (isset($this->request->post['exalt_order_status_id'])) {
      $data['exalt_status_id'] = $this->request->post['exalt_order_status_id'];
    } else {
      $data['exalt_order_status_id'] = $this->config->get('exalt_order_status_id');
    }

    $this->load->model('localisation/order_status');

    $data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

    if (isset($this->request->post['exalt_geo_zone_id'])) {
      $data['exalt_geo_zone_id'] = $this->request->post['exalt_geo_zone_id'];
    } else {
      $data['exalt_geo_zone_id'] = $this->config->get('exalt_geo_zone_id');
    }

    $this->load->model('localisation/geo_zone');

    $data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();

    if (isset($this->request->post['exalt_status'])) {
      $data['exalt_status'] = $this->request->post['exalt_status'];
    } else {
      $data['exalt_status'] = $this->config->get('exalt_status');
    }
if (isset($this->request->post['exalt_server'])) {
      $data['exalt_server'] = $this->request->post['exalt_server'];
    } else {
      $data['exalt_server'] = $this->config->get('exalt_server');
    }
    if (isset($this->request->post['exalt_sort_order'])) {
      $data['exalt_order'] = $this->request->post['exalt_sort_order'];
    } else {
      $data['exalt_sort_order'] = $this->config->get('exalt_sort_order');
    }

    $data['header'] = $this->load->controller('common/header');
    $data['column_left'] = $this->load->controller('common/column_left');
    $data['footer'] = $this->load->controller('common/footer');

    $this->response->setOutput($this->load->view('payment/exalt.tpl', $data));
  }
    }
