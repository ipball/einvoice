<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<div class="modal-header">
    <h5 class="modal-title"><?=$title?></h5>
</div>
<div class="modal-body">
    <form id="productForm" action="<?php echo base_url('product/save'); ?>">
        <?php echo form_hidden('id', $result['id']); ?>
        <?php echo form_hidden('profile_picture', $result['profile_picture']); ?>
        <div class="row">
            <div class="col-sm-8 col-12">
                <div class="row">
                    <div class="col-sm-6 col-12 form-group">
                        <label>หมวดหมู่ <span class="text-danger">*</span></label>
                        <?php echo form_dropdown('categorie_id', $categories, $result['categorie_id'], array('class' => 'form-control selectpicker')); ?>
                    </div>
                    <div class="col-sm-6 col-12 form-group">
                        <label>ประเภท <span class="text-danger">*</span></label>
                        <?php echo form_dropdown('type', $types, $result['type'], array('class' => 'form-control selectpicker')); ?>
                    </div>
                    <div class="col-sm-6 col-12 form-group">
                        <label>รหัสสินค้า <span class="text-danger">*</span></label>
                        <?php echo form_input(array('name' => 'sku', 'value' => $result['sku'], 'class' => 'form-control', 'autocomplete' => 'off')); ?>
                    </div>
                    <div class="col-sm-6 col-12 form-group">
                        <label>รหัสบาร์โค๊ด</label>
                        <?php echo form_input(array('name' => 'barcode', 'value' => $result['barcode'], 'class' => 'form-control', 'autocomplete' => 'off')); ?>
                    </div>
                    <div class="col-sm-12 col-12 form-group">
                        <label>ชื่อสินค้า <span class="text-danger">*</span></label>
                        <?php echo form_input(array('name' => 'name', 'value' => $result['name'], 'class' => 'form-control', 'autocomplete' => 'off')); ?>
                    </div>
                    <div class="col-sm-6 col-12 form-group">
                        <label>จำนวน <span class="text-danger">*</span></label>
                        <?php echo form_number(array('name' => 'quantity', 'value' => $result['quantity'], 'class' => 'form-control', 'autocomplete' => 'off')); ?>
                    </div>
                    <div class="col-sm-6 col-12 form-group">
                        <label>หน่วยนับ</label>
                        <?php echo form_input(array('name' => 'unit', 'value' => $result['unit'], 'class' => 'form-control', 'autocomplete' => 'off')); ?>
                    </div>
                    <div class="col-sm-6 col-12 form-group">
                        <label>ราคาซื้อ <span class="text-danger">*</span></label>
                        <?php echo form_number(array('name' => 'buy_price', 'value' => $result['buy_price'], 'class' => 'form-control', 'autocomplete' => 'off')); ?>
                    </div>
                    <div class="col-sm-6 col-12 form-group">
                        <label>ราคาขาย <span class="text-danger">*</span></label>
                        <?php echo form_number(array('name' => 'sell_price', 'value' => $result['sell_price'], 'class' => 'form-control', 'autocomplete' => 'off')); ?>
                    </div>
                    <div class="col-sm-12 col-12 form-group">
                        <label>รายละเอียด</label>                
                        <?php echo form_textarea(array('name' => 'detail', 'value' => $result['detail'], 'class' => 'form-control', 'rows' => '2')); ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-4 col-12">
                <div class="row">
                    <div class="col-sm-12 col-12 form-group">
                        <label>รูปภาพประจำตัว</label>
                        <input type="file" name="file_upload" class="filestyle" data-dragdrop="false">
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 col-12 form-group">
                        <img src="<?=$result['image_url']?>" alt="รูปภาพประจำตัว"
                            class="img-fluid rounded mx-auto d-block profile-picture" id="showPicture">
                    </div>
                </div>
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