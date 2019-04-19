<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<div class="row">
    <div class="col-lg-3 col-md-6">
        <div class="ibox bg-info color-white widget-stat">
            <div class="ibox-body">
                <h2 class="m-b-5 font-strong"><?=$leave_year['balance']?></h2>
                <div class="m-b-5">วันลาคงเหลือ</div><i class="ti-folder widget-stat-icon"></i>
                <div><i class="fa fa-level-up m-r-5"></i><small>ประจำปี 2562</small></div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="ibox bg-warning color-white widget-stat">
            <div class="ibox-body">
                <h2 class="m-b-5 font-strong"><?=$leave_year['pending']?></h2>
                <div class="m-b-5">วันลาที่รออนุมัติ</div><i class="ti-time widget-stat-icon"></i>
                <div><i class="fa fa-level-up m-r-5"></i><small>ประจำปี 2562</small></div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="ibox bg-success color-white widget-stat">
            <div class="ibox-body">
                <h2 class="m-b-5 font-strong"><?=$leave_year['approved']?></h2>
                <div class="m-b-5">วันลาที่อนุมัตแล้ว</div><i class="ti-check-box widget-stat-icon"></i>
                <div><i class="fa fa-level-up m-r-5"></i><small>ประจำปี 2562</small></div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="ibox bg-danger color-white widget-stat">
            <div class="ibox-body">
                <h2 class="m-b-5 font-strong"><?=$leave_year['rejected']?></h2>
                <div class="m-b-5">จำนวนวันลาที่ไม่อนุมัติ</div><i class="ti-face-sad widget-stat-icon"></i>
                <div><i class="fa fa-level-up m-r-5"></i><small>ประจำปี 2562</small></div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-8 col-md-8">
        <div class="ibox">
            <div class="ibox-head">
                <div class="ibox-title">การลางานของฉัน ล่าสุด</div>
            </div>
            <div class="ibox-body">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>การลา</th>                            
                            <th>วันที่ลา</th>
                            <th>จำนวนวัน</th>
                            <th>สถานะ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($leaves as $leave): ?>
                        <tr>
                            <td>
                                <?=$leave['leave_type_name']?>
                                <p class="text-black-50 small-text"><?=get_type_text($leave['type'])?></p>
                            </td>                            
                            <td>
                                <?=str_date($leave['start_date'])?>
                                <?php echo (!empty($leave['end_date']) ? ' - '. str_date($leave['end_date']) : ''); ?>
                            </td>
                            <td><?=$leave['total']?></td>
                            <td><span class="badge <?=get_status_badge($leave['status'])?>"><?=get_status_text($leave['status'])?></span></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-4">
        <div class="ibox">
            <div class="ibox-head">
                <div class="ibox-title">รายงานการลาของเพื่อน</div>
            </div>
            <div class="ibox-body">
                <ul class="media-list media-list-divider m-0">
                    <?php foreach($recents as $recent): ?>
                    <li class="media">
                        <a class="media-img" href="javascript:;">
                            <img class="img-circle" src="<?=get_img($recent['profile_picture'], '_sm')?>" width="40">
                        </a>
                        <div class="media-body">
                            <div class="media-heading"><?=$recent['firstname']. ' ' .$recent['lastname']?> <small class="float-right text-muted"><?=str_date($recent['start_date'])?></small></div>
                            <div>
                                <span class="badge badge-pill <?=get_status_badge($recent['status'])?>"><?=get_status_text($recent['status'])?></span>
                                <span class="font-13"><?=$recent['leave_type_name']?> <?=$recent['total']?> วัน</span>                                
                            </div>                            
                        </div>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
</div>