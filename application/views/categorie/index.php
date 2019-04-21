<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<div class="row">
    <div class="col-md-12">
        <div class="ibox">
            <div class="ibox-head">
                <div class="ibox-title">หมวดหมู่สินค้า</div>
                <div>
                    <a class="btn btn-info btn-sm btn-modal" data-href="<?php echo base_url('categorie/create'); ?>" data-modal-name="normalModal" href="javascript:;">เพิ่มหมวดหมู่สินค้า</a>
                </div>
            </div>
            <div class="ibox-body">
                <table id="categorieTable" class="table table-hover dataTable no-footer dtr-inline">
                    <thead class="thead-light thead-lg">
                        <tr>
                            <th width="300">ชื่อหมวดหมู่สินค้า</th>                            
                            <th>รายละเอียด</th>
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
