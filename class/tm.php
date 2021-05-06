<?php
class VoucherCode
{
    public function fetch($method = null, $url = null, $headers = array(), $data = null)
    {
        $this->url = $url;
        $this->headers = $headers;
        $this->data = $data;
        $this->method = $method;
        $fetch = curl_init();
        $headers = array("Content-Type" => "application/json");
        curl_setopt_array($fetch, [
            CURLOPT_URL => $this->url,
            CURLOPT_CUSTOMREQUEST => $this->method,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_PROXY => false,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_HTTPHEADER => $this->buildHeaders($headers),
            CURLOPT_POSTFIELDS => $data
        ]);
        $this->response = curl_exec($fetch);
        curl_close($fetch);
        return $this->response;
    }

    public function buildHeaders($array)
    {
        $headers = array();
        foreach ($array as $key => $value) {
            $headers[] = $key . ": " . $value;
        }
        return $headers;
    }

    public function VoucherCode($Mobile = null, $voucher_code = null)
    {
        $this->Mobile = $Mobile;
        $this->VoucherCode = $voucher_code;

        if (isset($this->VoucherCode) === true && $this->VoucherCode === "") {
            $res = [
                "code" => 309,
                "message" => "ไม่พบลิงค์ซองของขวัญของคุณ",
                "reason" => "NO_VOUCHER_FOUND",
            ];
            return $res;
        } else if (isset($this->Mobile) === true && $this->Mobile === "") {
            $res = [
                "code" => 307,
                "message" => "ไม่พบเบอร์โทรศัพน์ของผู้รับโปรดเเจ้งผู้ควบคุมเพื่อเเก้ไขปัญหานี้",
                "reason" => "NO_NUMBER_FOUND",
            ];
            return $res;
        } else {
            $gift = str_replace("https://gift.truemoney.com/campaign/?v=", "", $this->VoucherCode);
            if (strlen($gift) <= 0) {
                $res = [
                    "code" => 306,
                    "message" => "ลิงค์ของขวัญไม่มีอะไรเลยน่ะ",
                    "reason" => "NO_VOUNCHER_FOUND",
                ];
                return $res;
            }
            $res = json_decode($this->fetch("POST", "https://gift.truemoney.com/campaign/vouchers/{$gift}/redeem", null, json_encode(array("mobile" => $this->Mobile, "voucher_hash" => $this->VoucherCode))), true);
            if ($res["status"]["code"] == "SUCCESS") {
                $bath = $res["data"]["voucher"]["redeemed_amount_baht"];
                $res = [
                        "code" => 200,
                        "message" => "เติมเงินสำเร็จเเล้ว ".$bath." บาท",
                        "amount" => $bath
                ];
                return $res;
            } elseif ($res['status']['code'] === "CANNOT_GET_OWN_VOUCHER") {
                $res = [
                    "code" => 301,
                    "message" => "คุณไม่สามารถใส่ซองของขวัญของตัวเองได้น่ะ"
                ];
                return $res;
            } elseif ($res['status']['code'] === "TARGET_USER_NOT_FOUND") {
                $res = [
                    "code" => 302,
                    "message" => "ไม่พบชื่อผู้ใช้เบอร์ Wallet นี้"
                ];
                return $res;
            } elseif ($res['status']['code'] === "INTERNAL_ERROR") {
                $res = [
                    "code" => 500,
                    "message" => "ไม่พบลิงค์ ของขวัญของคุณ"
                ];
                return $res;
            } elseif($res['status']['code'] === "VOUCHER_OUT_OF_STOCK"){
                $res = [
                    "code" => 420,
                    "message" => "ลิงค์นี้ถูกใช้งานเรียบร้อยเเล้ว"
                ];
                return $res;
            } elseif ($res['status']['code'] === "VOUCHER_NOT_FOUND") { 
                $res = [
                    "code" => 700,
                    "message" => "ไม่ลิ้งของขวัญ"
                ];
                return $res;
            } elseif($res['status']['code'] === "VOUCHER_EXPIRED"){
                 $res = [
                    "code" => 705,
                    "message" => "ลิ้งของขวัญ หมดอายุเเล้ว",
                    "amount" => $res['status']['amount_baht']
                ];
                return $res;
            } else {
                return $res;
            }
        }
    }
}
