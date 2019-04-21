<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<div class="row">
    <div class="col-md-12">
        <div class="ibox">
            <div class="ibox-head">
                <div class="ibox-title">ลูกค้า</div>
                <div>
                    <a class="btn btn-info btn-sm btn-modal" data-href="<?php echo base_url('contact/create'); ?>" data-modal-name="largeModal" href="javascript:;">เพิ่มลูกค้า</a>
                </div>
            </div>
            <div class="ibox-body">
                <table id="contactTable" class="table table-hover dataTable no-footer dtr-inline">
                    <thead class="thead-light thead-lg">
                        <tr>
                            <th width="300">ชื่อ</th>                            
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
