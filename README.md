# เติมเงินด้วยซองของขวัญ PHP

[Facebook](https://www.facebook.com/MASURU.PAGE) | [Website](https://www.miho-anime.site/) | [Discord](https://www.masuru-discord.miho-anime.site/) | [Credit](https://github.com/REDzTrue/TruemoneyWallet-VouncherCode)

ของฟรีอย่าเอาไปขายไอ้สัส


## ตัวอย่าง
```html
<!-- ตัวอย่างฟรอมใส่ลิงค์ True Money Gift -->
<form action="" method="post">
    <input type="text" name="link" id="link" placeholder="ใส่ลิงค์" require>
    <button type="submit">เติม</button>
</form>
```
```php
// ตัวอย่างรับค่าลิงค์
    if(isset($_POST['link'])){
        include (__DIR__. '/class/tm.php');
        $tmgift = new VoucherCode();
        //                                ใส่เบอร์โทร        รับค่าลิงค์
        $request = $tmgift->VoucherCode('06XXXXXXXX', $_POST['link']);
        echo $request['message'];
    }
```


### สำหรับโค้ดเเก้ใขข้อความ
code | message | amount
--- | --- | ---
200 | `เติมเงินสำเร็จเเล้ว 10.00 บาท` | number
301 | `คุณไม่สามารถใส่ซองของขวัญของตัวเองได้น่ะ` | null
302 | `ไม่พบชื่อผู้ใช้เบอร์ Wallet นี้` | null
306 | `ลิงค์ของขวัญไม่มีอะไรเลนน่ะ` | nulll
307 | `ไม่พบเบอร์โทรศัพน์ของผู้รับโปรดเเจ้งผู้ควบคุมเพื่อเเก้ไขปัญหานี้` | null
309 | `ไม่พบลิงค์ซองของขวัญของคุณ` | null
500 | `ไม่พบลิงค์ ของขวัญของคุณ` | null
420 | `ลิงค์นี้ถูกใช้งานเรียบร้อยเเล้ว` | null
700 | `ไม่พบลิ้งของขวัญ` | null
705 | `ลิ้งของขวัญหมดอายุเเล้ว` | null




### ตัวอย่าง 
```php
if(isset($_POST['link'])){
        include (__DIR__. '/class/tm.php');
        $tmgift = new VoucherCode();
        $request = $tmgift->VoucherCode('06XXXXXXXX', $_POST['link']);
        if($request['code'] === 200){
            echo "เติมเงินสำเร็จเเล้ว ".$request['amount']." บาท";
        }elseif($request['code'] === 301){
            echo "คุณไม่สามารถใส่ซองของขวัญของตัวเองได้น่ะ";
        }elseif($request['code'] === 302){
            echo "ไม่พบชื่อผู้ใช้เบอร์ Wallet นี้";
        }elseif($request['code'] === 306){
            echo "ลิงค์ของขวัญไม่มีอะไรเลนน่ะ";
        }elseif($request['code'] === 307){
            echo "ไม่พบเบอร์โทรศัพน์ของผู้รับโปรดเเจ้งผู้ควบคุมเพื่อเเก้ไขปัญหานี้";
        }elseif($request['code'] === 309){
            echo "ไม่พบลิงค์ซองของขวัญของคุณ";
        }elseif($request['code'] === 500){
            echo "ไม่พบลิงค์ ของขวัญของคุณ";
        }elseif($request['code'] === 420){
            echo "ลิงค์นี้ถูกใช้งานเรียบร้อยเเล้ว";
        }else{
            echo $request['code'];
        }
    }
```
