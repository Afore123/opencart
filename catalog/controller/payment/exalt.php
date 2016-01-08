<?php
class ControllerPaymentExalt extends Controller {
  public function index() {
    $this->language->load('payment/exalt');
    $data['button_confirm'] = $this->language->get('button_confirm');
    $data['text_wait'] = $this->language->get('text_wait');
    $data['text_credit_card'] = $this->language->get('text_credit_card');
   
    $data['entry_cc_owner'] = $this->language->get('entry_cc_owner');
    $data['entry_cc_number'] = $this->language->get('entry_cc_number');
    $data['entry_cc_expire_date'] = $this->language->get('entry_cc_expire_date');
    $data['entry_cc_cvv'] = $this->language->get('entry_cc_cvv');

      $data['months'] = array();
    for ($i = 1; $i <= 12; $i++) {
      $data['months'][] = array(
        'text'  => strftime('%B', mktime(0, 0, 0, $i, 1, 2000)),
        'value' => sprintf('%02d', $i)
      );
    }

    $today = getdate();
    $data['year_expire'] = array();
    for ($i = $today['year']; $i < $today['year'] + 11; $i++) {
      $data['year_expire'][] = array(
        'text'  => strftime('%Y', mktime(0, 0, 0, 1, 1, $i)),
        'value' => strftime('%Y', mktime(0, 0, 0, 1, 1, $i))
      );
    }
    if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/exalt.tpl')) {
      return $this->load->view($this->config->get('config_template') . '/template/payment/exalt.tpl', $data);
    } else {
      return $this->load->view('default/template/payment/exalt.tpl', $data);
    }
  }
  
public function send() {
    if ($this->config->get('exalt_server') == 'live') {
      $url = 'http://223.30.137.210:82/api/ApiEnvoicePayment/CreatePaymentToMerchent/';
    } elseif ($this->config->get('exalt_server') == 'test') {
      $url = 'http://223.30.137.210:82/api/ApiEnvoicePayment/CreatePaymentToMerchent/';
    }

    //$url = 'https://secure.networkmerchants.com/gateway/transact.dll';

    $this->load->model('checkout/order');

    $order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);

   $data = array();

     //$data['exalt_login'] = $this->config->get('exalt_login');
    $data['API_Key'] = $this->config->get('exalt_key');
    $data['User_Agent'] = html_entity_decode($order_info['payment_firstname'], ENT_QUOTES, 'UTF-8');
    //$data['last_name'] = html_entity_decode($order_info['payment_lastname'], ENT_QUOTES, 'UTF-8');
    //$data['company'] = html_entity_decode($order_info['payment_company'], ENT_QUOTES, 'UTF-8');
    //$data['address'] = html_entity_decode($order_info['payment_address_1'], ENT_QUOTES, 'UTF-8');
    //$data['city'] = html_entity_decode($order_info['payment_city'], ENT_QUOTES, 'UTF-8');
    //$data['state'] = html_entity_decode($order_info['payment_zone'], ENT_QUOTES, 'UTF-8');
    //$data['zip'] = html_entity_decode($order_info['payment_postcode'], ENT_QUOTES, 'UTF-8');
   // $data['country'] = html_entity_decode($order_info['payment_country'], ENT_QUOTES, 'UTF-8');
    //$data['phone'] = $order_info['telephone'];
    $data['IP_Address'] = $this->request->server['REMOTE_ADDR'];
   // $data['email'] = $order_info['email'];
    $data['description'] =  html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8');
    $data['NetAmount'] = $this->currency->format($order_info['total'], $order_info['currency_code'], 1.00000, false);
    //$data['currency_code'] = $this->currency->getCode();
  //  $data['method'] = 'CC';
    $data['card_number'] = $this->request->post['cc_number'];
    $data['expmonth'] = $this->request->post['expmonth'];
   $data['expyear'] = $this->request->post['expyear'];
   $data['card_holder_name'] = $this->request->post['card_holder_name'];
   $data['cvv'] = $this->request->post['cc_cvv']; 
   //$data['invoice_num'] = $this->session->data['order_id'];
    
    /*if ($order_info['shipping_method']) {
            $data['ship_to_first_name'] = html_entity_decode($order_info['shipping_firstname'], ENT_QUOTES, 'UTF-8');
            $data['ship_to_last_name'] = html_entity_decode($order_info['shipping_lastname'], ENT_QUOTES, 'UTF-8');
            $data['ship_to_company'] = html_entity_decode($order_info['shipping_company'], ENT_QUOTES, 'UTF-8');
            $data['ship_to_address'] = html_entity_decode($order_info['shipping_address_1'], ENT_QUOTES, 'UTF-8') . ' ' . html_entity_decode($order_info['shipping_address_2'], ENT_QUOTES, 'UTF-8');
            $data['ship_to_city'] = html_entity_decode($order_info['shipping_city'], ENT_QUOTES, 'UTF-8');
            $data['ship_to_state'] = html_entity_decode($order_info['shipping_zone'], ENT_QUOTES, 'UTF-8');
            $data['ship_to_zip'] = html_entity_decode($order_info['shipping_postcode'], ENT_QUOTES, 'UTF-8');
            $data['ship_to_country'] = html_entity_decode($order_info['shipping_country'], ENT_QUOTES, 'UTF-8');
        } else {
            $data['ship_to_first_name'] = html_entity_decode($order_info['payment_firstname'], ENT_QUOTES, 'UTF-8');
            $data['ship_to_last_name'] = html_entity_decode($order_info['payment_lastname'], ENT_QUOTES, 'UTF-8');
            $data['ship_to_company'] = html_entity_decode($order_info['payment_company'], ENT_QUOTES, 'UTF-8');
            $data['ship_to_address'] = html_entity_decode($order_info['payment_address_1'], ENT_QUOTES, 'UTF-8') . ' ' . html_entity_decode($order_info['payment_address_2'], ENT_QUOTES, 'UTF-8');
            $data['ship_to_city'] = html_entity_decode($order_info['payment_city'], ENT_QUOTES, 'UTF-8');
            $data['ship_to_state'] = html_entity_decode($order_info['payment_zone'], ENT_QUOTES, 'UTF-8');
            $data['ship_to_zip'] = html_entity_decode($order_info['payment_postcode'], ENT_QUOTES, 'UTF-8');
            $data['ship_to_country'] = html_entity_decode($order_info['payment_country'], ENT_QUOTES, 'UTF-8');
        }*//*
$fields = array(
                        'APIKey' => urlencode($data['APIKey']),
                        'IP_Address' => urlencode($data['IP_Address']),
                        'description' => urlencode($data['description']),
                        'NetAmount' => urlencode($data['NetAmount']),
                        'method' => urlencode($data['method']),
                        'card_number' => urlencode($data['card_number']),
                        'expmonth' => urlencode($data['expmonth']),
                        'expyear' => urlencode($data['expyear']),
                        'card_holder_name' => urlencode($data['card_holder_name']),
                        'CVV' => urlencode($data['CVV'])
                        
                );
*/
            // foreach($data as $key=>$value) { $data_string .= $key.'='.$value.'&'; }
            // rtrim($data_string, '&');
       /* if ($this->config->get('exalt_mode') == 'test') {
            $data['test_request'] = 'true';
        }*/

    
             
     
         $curl = curl_init($url);

         curl_setopt($curl, CURLOPT_PORT, 80);
         curl_setopt($curl, CURLOPT_HTTPHEADER, array('Authorization-Token:sk_test_d0da2d00-d7e9-456b-bb50-cba2e2d05107','CurrentUserID:1'));
                 
        curl_setopt($curl, CURLOPT_HEADER,0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_FORBID_REUSE, 1);
        curl_setopt($curl, CURLOPT_FRESH_CONNECT, 1);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 120);
        curl_setopt($curl, CURLOPT_TIMEOUT, 120);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data, '', '&'));

      $response = curl_exec($curl);

       $json = array();

        if (curl_error($curl)) {
            $json['error'] = 'CURL ERROR: ' . curl_errno($curl) . '::' . curl_error($curl);

            $this->log->write('EXALT CURL ERROR: ' . curl_errno($curl) . '::' . curl_error($curl));
        } elseif ($response) {
            $i = 1;

            $response_info = array();

            $results = explode('|', $response);

            foreach ($results as $result) {
                $response_info[$i] = trim($result, '"');

                $i++;
            }

            if ($response_info[1] == '1') {
                $message = '';

                if (isset($response_info['5'])) {
                    $message .= 'Authorization Code: ' . $response_info['5'] . "\n";
                }

                if (isset($response_info['6'])) {
                    $message .= 'AVS Response: ' . $response_info['6'] . "\n";
                }

                if (isset($response_info['7'])) {
                    $message .= 'Transaction ID: ' . $response_info['7'] . "\n";
                }

                if (isset($response_info['39'])) {
                    $message .= 'Card Code Response: ' . $response_info['39'] . "\n";
                }

                if (isset($response_info['40'])) {
                    $message .= 'Cardholder Authentication Verification Response: ' . $response_info['40'] . "\n";
                }

                     $this->model_checkout_order->addOrderHistory($this->session->data['order_id'], $this->config->get('config_order_status_id'));
                    $json['redirect'] = $this->url->link('checkout/success');
          
        } 
       } curl_close($curl);   

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }
}
