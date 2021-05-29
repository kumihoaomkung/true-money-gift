# เติมเงินด้วยซองของขวัญ PHP

[Facebook](https://www.facebook.com/MASURU.PAGE) | [Website](https://masuru.pw) | [Discord](http://ftune.app/invite/masurudiscord) | [Credit](https://github.com/REDzTrue/TruemoneyWallet-VouncherCode)

ของฟรีห้ามขายนะครับผม เเจกต่ออย่าลืมให้เครดิตด้วยนะครับ

## สำหรับโค้ดเเก้ใขข้อความ

CODE | MESSAGE | AMOUNT
--- | --- | ---
200 | `เติมเงินสำเร็จเเล้ว` | number
301 | `คุณไม่สามารถใส่ซองของขวัญของตัวเองได้น่ะ` | null
302 | `ไม่พบเบอร์โทรศัพน์ของผู้รับโปรดเเจ้งผู้ควบคุมเพื่อเเก้ไขปัญหานี้` | null
304 | `ลิ้งนี้ถูกใช้งานครบจำนวนเเล้ว` | null
305 | `ไม่พบซองของขวัญ` | null
306 | `ซองขวัญหมดอายุเเล้ว` | null
307 | `นี้ไม่ใช้ลื้งซองของขวัญ` | null
308 | `ไม่พบเบอร์โทรศัพน์ของผู้รับโปรดเเจ้งผู้ควบคุมเพื่อเเก้ไขปัญหานี้` | null
309 | `ไม่พบลิ้งซองของขวัญของคุณ` | null
404 | `เกิดปัญหา 404` | null
500 | `เซิฟเวอร์ error` | null
---
## ตัวอย่าง สำหรับเปรียนข้อความ & รับค่า URL
```php
if(isset($_POST['link'])){
        include (__DIR__. '/kumiho/truewallet/tmclass.php');
        $tmgift = new TG();
        $request = $tmgift->VoucherCode('06XXXXXXXX', $_POST['link'], true);
        if($request['code'] === 200){
            echo "เติมเงินสำเร็จเเล้ว ".$request['amount']." บาท";
        }else{
            echo $request['message'];
        }
    }
```
## ตัวอย่าง HTML
```html
<!-- ตัวอย่างฟรอมใส่ลิงค์ True Money Gift -->
<form action="" method="post">
    <input type="text" name="link" id="link" placeholder="ใส่ลิงค์" require>
    <button type="submit">เติม</button>
</form>
```
# PocketMine PMMP API 3.0.0 Wait
