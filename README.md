# einvoice
## Requiment Server
- PHP 7.0 หรือมากกว่า
- MySQL หรือ MariaDB
- Apache2

## การติดตั้ง
- ตรวจสอบต้องมี Requiment Server ตามที่ต้องการ
- โคลน Git หรือ ดาวน์โหลดโปรเจคแล้วแตกไฟล์ไว้ในที่ต้องการ
- import file sql "einvoice.sql" โดยใช้ phpmyadmin หรืออื่นๆตามที่ถนัด
- แก้ไขไฟล์ Database ที่ application/config/database.php
> เปลี่ยน username, password, database
- แก้ไขไฟล์ Config ที่ application/config/config.php
> เปลี่ยน url ที่ $config['base_url'] = 'http://localhost/einvoice/'; เป็น url ของเรา เช่น $config['base_url'] = 'http://www.myproject.com/';
- กรณีเอาโปรเจคขึ้น SERVER ให้กำหนดสิทธิ์โฟล์เดอร์ให้เขียนได้ หรือ CHMOD 777 ที่โฟล์เดอร์ application/logs
- เข้าระบบโดยเปิด Chrome หรือ Firefox แล้วเข้า url http://localhost/einvoice หรือ url ที่เราตั้งค่าไว้
- ใส่รหัส *username:* admin | *password:* 1234
