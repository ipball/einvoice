<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<div class="row">
    <div class="col-md-12">
        <div class="ibox">
            <div class="ibox-head">
                <div class="ibox-title">ตั้งค่าข้อมูล</div>
            </div>
            <div class="ibox-body">
                <form method="post" action="<?=base_url('setting/save')?>">
                    <div class="form-group">
                        <label>ชื่อบริษัท</label>
                        <input class="form-control" type="text" name="company_name" value="<?=$company_name['value']?>">
                    </div>
                    <div class="form-group">
                        <label>ที่อยู่</label>
                        <textarea class="form-control" name="address" rows="3"><?=$address['value']?></textarea>
                    </div>
                    <div class="form-group">
                        <label>ข่าวสาร สาระสำคัญ</label>
                        <textarea class="form-control" name="news" rows="3"><?=$news['value']?></textarea>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary" type="submit">บันทึก</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
