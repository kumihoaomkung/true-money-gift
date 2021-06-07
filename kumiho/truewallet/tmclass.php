<?php
/**
 * Class by REDzTrue/REDzSEA
 * Original code by REDzTrue/REDzSEA
 * Response code by Kumihoaomkung
 * Truemoney wallet VoucherCode
 * 28/05/2021 Last Update
 * https://github.com/REDzTrue/TruemoneyWallet-VouncherCode/
 * https://github.com/kumihoaomkung/true-money-gift
 * 
 * ถ้านำไปพัฒนาต่ออย่าลืมให้เครดิตพวกเราด้วยน่ะ
 */

class TG
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

    public function VoucherCode($Mobile = null, $voucher_code = null, $array = false)
    {
        $this->Mobile = $Mobile;
        $this->VoucherCode = $voucher_code;

        if (isset($this->VoucherCode) === true && $this->VoucherCode === "") {
            return $this->data_array(309, "ไม่พบลิ้งซองของขวัญของคุณ", $array);
        } else if (isset($this->Mobile) === true && $this->Mobile === "") {
            return $this->data_array(308, "ไม่พบเบอร์โทรศัพน์ของผู้รับโปรดเเจ้งผู้ควบคุมเพื่อเเก้ไขปัญหานี้", $array);
        } else {
            $gift = str_replace("https://gift.truemoney.com/campaign/?v=", "", $this->VoucherCode);
            if (strlen($gift) <= 0) {
                return $this->data_array(307, "นี้ไม่ใช้ลื้งซองของขวัญ", $array);
            }
            $res = json_decode($this->fetch("POST", "https://gift.truemoney.com/campaign/vouchers/{$gift}/redeem", null, json_encode(array("mobile" => $this->Mobile, "voucher_hash" => $this->VoucherCode))), true);
            $code = $res["status"]["code"];
            switch ($code) {
                case "SUCCESS":
                    $bath = $res["data"]["voucher"]["redeemed_amount_baht"];
                    return $this->data_array(200, 'เติมเงินสำเร็จเเล้ว', $array, $bath);
                break;
                case "CANNOT_GET_OWN_VOUCHER":
                    return $this->data_array(301, 'คุณไม่สามารถใส่ซองของขวัญของตัวเองได้น่ะ', $array);
                break;
                case "TARGET_USER_NOT_FOUND":
                    return $this->data_array(302, 'ไม่พบเบอร์โทรศัพน์ของผู้รับโปรดเเจ้งผู้ควบคุมเพื่อเเก้ไขปัญหานี้', $array);
                break;
                case "VOUCHER_OUT_OF_STOCK":
                    return $this->data_array(304, 'ลิ้งนี้ถูกใช้งานครบจำนวนเเล้ว', $array);
                break;
                case "VOUCHER_NOT_FOUND":
                    return $this->data_array(305, 'ไม่พบซองของขวัญ', $array);
                break;
                case "VOUCHER_EXPIRED":
                    return $this->data_array(306, 'ซองขวัญหมดอายุเเล้ว', $array);
                break;
                case "INTERNAL_ERROR":
                    return $this->data_array(500, 'เซิฟเวอร์ error', $array);
                break;
                default:
                    return $this->data_array(404, "เกิดปัญหา 404", $array);
            }
        }
    }
        
    public function data_array($code, $message, $array = false, int $amount = 0){
        if($array){
            return [
                "code" => $code,
                "message" => $message,
                "amount" => $amount
            ];
        } else {
            return json_encode([
                "code"=>$code, 
                "message"=>$message, 
                "amount"=>$amount
            ]);
        }
    }

}


if(isset($_POST['link'])){
    $tm = new TG();
    //                                ใส่เบอร์โทร        รับค่าลิงค์
    $request = $tm->VoucherCode('0645091974', $_POST['link'], true);
    print_r($request);
}
