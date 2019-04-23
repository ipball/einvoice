<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<div class="row">
    <div class="col-md-12">
        <div class="ibox">
            <div class="ibox-head">
                <div class="ibox-title">รายการใบแจ้งหนี้ (Invoice)</div>
                <div>                    
                    <a class="btn btn-info btn-sm" href="<?=base_url('invoice/create')?>" role="button">สร้างใบแจ้งหนี้</a>
                </div>
            </div>
            <div class="ibox-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-inline float-right">
                            <?php echo form_dropdown('status', $status, null, array('class' => 'form-control selectpicker form-control-sm mr-3', 'data-width' => 'auto', 'data-style' => 'btn-default')); ?>
                            <label class="mr-2">วันที่ใบแจ้งหนี้:</label>
                            <!-- <input type="text" name="date_range" class="form-control date-range form-control-sm mr-3">       -->
                            <button class="btn btn-default btn-sm date-range mr-3"><i class="ti-calendar"></i> <span class="ca-label">This Month</span> <i class="fa fa-caret-down"></i></button>

                            <label class="mr-2">ค้นหา:</label>
                            <input type="text" name="search" class="form-control form-control-sm ">                            
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <table id="invoiceTable" class="table table-hover dataTable no-footer dtr-inline">
                            <thead class="thead-light thead-lg">
                                <tr>
                                    <th>เลขที่ใบแจ้งหนี้</th>
                                    <th>ชื่อลูกค้า</th>
                                    <th>วันที่</th>  
                                    <th>ยอดรวม</th>
                                    <th>ครบกำหนด</th>
                                    <th>ยอดชำระ</th>
                                    <th>สถานะ</th>                                    
                                    <th>จัดการ</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>    
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
