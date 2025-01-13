<?php

class Api {
    public $endpoint_domain = 'http://domain.test';
    public $api_id = '20112';
    public $api_key = 'psxq0a-0vyxlg-fgednk-r5drpn-bocb5b';

    // Cek saldo
    public function balance() {
        return json_decode($this->connect($this->endpoint_domain . "/api/balance", [
            'api_id' => $this->api_id,
            'api_key' => $this->api_key,
        ]), 1);
    }

    // Daftar layanan
    public function services() {
        return json_decode($this->connect($this->endpoint_domain . "/api/services", [
            'api_id' => $this->api_id,
            'api_key' => $this->api_key,
        ]), 1);
    }

    // Membuat pesanan
    public function order($data) {
        $post = array_merge([
            'api_id' => $this->api_id,
            'api_key' => $this->api_key,
        ], $data);
        return json_decode($this->connect($this->endpoint_domain . "/api/order", $post), 1);
    }

    // Cek status pesanan
    public function status($order_id) {
        return json_decode($this->connect($this->endpoint_domain . "/api/status", [
            'api_id' => $this->api_id,
            'api_key' => $this->api_key,
            'id' => $order_id,
        ]), 1);
    }

    // Membuat refill pesanan
    public function refill($order_id) {
        return json_decode($this->connect($this->endpoint_domain . "/api/refill", [
            'api_id' => $this->api_id,
            'api_key' => $this->api_key,
            'id' => $order_id,
        ]), 1);
    }

    // Cek status refill pesanan
    public function refill_status($refill_id) {
        return json_decode($this->connect($this->endpoint_domain . "/api/refill/status", [
            'api_id' => $this->api_id,
            'api_key' => $this->api_key,
            'id' => $refill_id,
        ]), 1);
    }

    private function connect($endpoint, $post) {
        $_post = [];
        if (is_array($post)) {
            foreach ($post as $name => $value) {
                $_post[] = $name . '=' . urlencode($value);
            }
        }
        $ch = curl_init($endpoint);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        if (is_array($post)) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, join('&', $_post));
        }
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)');
        $result = curl_exec($ch);
        if (curl_errno($ch) != 0 && empty($result)) {
            $result = false;
        }
        curl_close($ch);
        return $result;
    }
}
