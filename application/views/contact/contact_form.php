<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<div class="modal-header">
    <h5 class="modal-title"><?=$title?></h5>
</div>
<div class="modal-body">
    <form id="contactForm" action="<?php echo base_url('contact/save'); ?>">
        <?php echo form_hidden('id', $result['id']); ?>        
        <div class="row">
            <div class="col-sm-6 col-12 form-group">
                <label>รหัสลูกค้า <span class="text-danger">*</span></label>                
                <?php echo form_input(array('name' => 'code', 'value' => $result['code'], 'class' => 'form-control', 'autocomplete' => 'off')); ?>
            </div>
            <div class="col-sm-6 col-12 form-group">
                <label>หมายเลขผู้เสียภาษี</label>                
                <?php echo form_input(array('name' => 'tax_no', 'value' => $result['tax_no'], 'class' => 'form-control', 'autocomplete' => 'off')); ?>
            </div>
            <div class="col-sm-6 col-12 form-group">
                <label>ชื่อลูกค้า <span class="text-danger">*</span></label>                
                <?php echo form_input(array('name' => 'name', 'value' => $result['name'], 'class' => 'form-control', 'autocomplete' => 'off')); ?>
            </div>
            <div class="col-sm-3 col-12 form-group">
                <label>รหัสสาขา</label>                
                <?php echo form_input(array('name' => 'branch_no', 'value' => $result['branch_no'], 'class' => 'form-control', 'autocomplete' => 'off')); ?>
            </div>
            <div class="col-sm-3 col-12 form-group">
                <label>ชื่อสาขา</label>                
                <?php echo form_input(array('name' => 'branch_name', 'value' => $result['branch_name'], 'class' => 'form-control', 'autocomplete' => 'off')); ?>
            </div>
            <div class="col-sm-6 col-12 form-group">
                <label>ชื่อผู้ติดต่อ</label>                
                <?php echo form_input(array('name' => 'contact_name', 'value' => $result['contact_name'], 'class' => 'form-control', 'autocomplete' => 'off')); ?>
            </div>
            <div class="col-sm-6 col-12 form-group">
                <label>อีเมล์</label>                
                <?php echo form_input(array('name' => 'email', 'value' => $result['email'], 'class' => 'form-control', 'autocomplete' => 'off')); ?>
            </div>
            <div class="col-sm-6 col-12 form-group">
                <label>เบอร์โทรศัพท์</label>                
                <?php echo form_input(array('name' => 'tel', 'value' => $result['tel'], 'class' => 'form-control', 'autocomplete' => 'off')); ?>
            </div>
            <div class="col-sm-6 col-12 form-group">
                <label>เบอร์โทรสาร</label>                
                <?php echo form_input(array('name' => 'fax', 'value' => $result['fax'], 'class' => 'form-control', 'autocomplete' => 'off')); ?>
            </div>
            <div class="col-sm-6 col-12 form-group">
                <label>เว็บไซต์</label>                
                <?php echo form_input(array('name' => 'website', 'value' => $result['website'], 'class' => 'form-control', 'autocomplete' => 'off')); ?>
            </div>
            <div class="col-sm-3 col-12 form-group">
                <label>เครดิต (วัน) <span class="text-danger">*</span></label>                
                <?php echo form_number(array('name' => 'credit_day', 'value' => $result['credit_day'], 'class' => 'form-control', 'autocomplete' => 'off')); ?>
            </div>
            <div class="col-sm-12 col-12 form-group">
                <label>ที่อยู่</label>                
                <?php echo form_textarea(array('name' => 'address', 'value' => $result['address'], 'class' => 'form-control', 'rows' => '3')); ?>
            </div>
            <div class="col-sm-12 col-12 form-group">
                <label>หมายเหตุ</label>                
                <?php echo form_textarea(array('name' => 'note', 'value' => $result['note'], 'class' => 'form-control', 'rows' => '3')); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6 form-group">
                <label>สถานะ</label>
                <div>
                    <label class="ui-radio ui-radio-primary ui-radio-inline">                        
                        <?php echo form_radio(array('name' => 'status', 'value' => '1', 'checked' => $result['status'])); ?>
                        <span class="input-span"></span>Active
                    </label>
                    <label class="ui-radio ui-radio-primary ui-radio-inline">
                        <?php echo form_radio(array('name' => 'status', 'value' => '0', 'checked' => !$result['status'])); ?>
                        <span class="input-span"></span>Inactive
                    </label>
                </div>
            </div>
        </div>
    </form>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">ปิดหน้าจอ</button>
    <button type="button" class="btn btn-primary btn-save">บันทึก</button>
</div>