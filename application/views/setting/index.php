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
                        <input class="form-control" type="text" name="company_name" value="<?=$company_name?>">
                    </div>
                    <div class="form-group">
                        <label>ที่อยู่</label>
                        <textarea class="form-control" name="address" rows="3"><?=$address?></textarea>
                    </div>
                    <div class="form-group">
                        <label>หมายเลขประจำตัวผู้เสียภาษี</label>
                        <input class="form-control" type="text" name="tax_no" value="<?=$tax_no?>">
                    </div>
                    <div class="form-group">
                        <label>สาขา</label>
                        <input class="form-control" type="text" name="branch" value="<?=$branch?>">
                    </div>
                    <div class="form-group">
                        <label>เบอร์โทร</label>
                        <input class="form-control" type="text" name="tel" value="<?=$tel?>">
                    </div>
                    <div class="form-group">
                        <label>เบอร์แฟ็กซ์</label>
                        <input class="form-control" type="text" name="fax" value="<?=$fax?>">
                    </div>
                    <div class="form-group">
                        <label>เว็บไซต์</label>
                        <input class="form-control" type="text" name="website" value="<?=$website?>">
                    </div>
                    <div class="form-group">
                        <label>ภาษีมูลค่าเพิ่ม</label>
                        <input class="form-control" type="text" name="vat" value="<?=$vat?>">
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary" type="submit">บันทึก</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
