<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<div class="row">
    <div class="col-md-12">
        <div class="ibox">
            <div class="ibox-head">
                <div class="ibox-title">สินค้า</div>
                <div>
                    <a class="btn btn-info btn-sm btn-modal" data-href="<?php echo base_url('product/create'); ?>" data-modal-name="largeModal" href="javascript:;">เพิ่มสินค้า</a>
                </div>
            </div>
            <div class="ibox-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-inline float-right">
                            <label class="mr-2">ค้นหา:</label>
                            <input type="text" name="search" class="form-control form-control-sm mr-3">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <table id="productTable" class="table table-hover dataTable no-footer dtr-inline">
                            <thead class="thead-light thead-lg">
                                <tr>
                                    <th>&nbsp;</th>  
                                    <th>สินค้า</th>  
                                    <th>ราคา</th>
                                    <th>ประเภท</th>
                                    <th>หมวดหมู่</th>
                                    <th>จำนวนคงเหลือ</th>
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
