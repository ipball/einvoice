<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<div class="row">
    <div class="col-md-12">
        <div class="ibox">
            <div class="ibox-head">
                <div class="ibox-title">ผู้ดูแลระบบ</div>
                <div>
                    <a class="btn btn-info btn-sm btn-modal" data-href="<?php echo base_url('user/create'); ?>" data-modal-name="largeModal" href="javascript:;">เพิ่มผู้ใช้งาน</a>
                </div>
            </div>
            <div class="ibox-body">
                <table id="userTable" class="table table-hover dataTable no-footer dtr-inline">
                    <thead class="thead-light thead-lg">
                        <tr>
                            <th>Username</th>
                            <th>ชื่อ-นามสกุล</th>
                            <th>อีเมล์</th>
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
