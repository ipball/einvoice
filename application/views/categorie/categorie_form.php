<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<div class="modal-header">
    <h5 class="modal-title"><?=$title?></h5>
</div>
<div class="modal-body">
    <form id="categorieForm" action="<?php echo base_url('categorie/save'); ?>">
        <?php echo form_hidden('id', $result['id']); ?>        
        <div class="row">
            <div class="col-sm-12 col-12 form-group">
                <label>ชื่อ <span class="text-danger">*</span></label>                
                <?php echo form_input(array('name' => 'name', 'value' => $result['name'], 'class' => 'form-control', 'autocomplete' => 'off')); ?>
            </div>
            <div class="col-sm-12 col-12 form-group">
                <label>รายละเอียด</label>                
                <?php echo form_textarea(array('name' => 'detail', 'value' => $result['detail'], 'class' => 'form-control', 'rows' => '3')); ?>
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