<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<nav class="page-sidebar" id="sidebar">
    <div id="sidebar-collapse">
        <div class="admin-block d-flex">
            <div>
                <img src="<?=$profile_picture?>" width="45px" />
            </div>
            <div class="admin-info">
                <div class="font-strong"><?=$name?></div><small><?=$role?></small>
            </div>
        </div>
        <ul class="side-menu metismenu">
            <li>
                <a href="<?=base_url('invoice')?>"><i class="sidebar-item-icon ti-files"></i>
                    <span class="nav-label">ใบแจ้งหนี้ (Invoice)</span>
                </a>
            </li>            
            <li class="heading">ข้อมูลหลัก</li>
            <li>            
                <a href="<?=base_url('product')?>"><i class="sidebar-item-icon ti-layers-alt"></i>
                    <span class="nav-label">สินค้า</span>
                </a>
            </li>
            <li>
                <a href="<?=base_url('employee')?>"><i class="sidebar-item-icon ti-id-badge"></i>
                    <span class="nav-label">ลูกค้า</span>
                </a>
            </li>
            <li>
                <a href="<?=base_url('setting')?>"><i class="sidebar-item-icon ti-settings"></i>
                    <span class="nav-label">ตั้งค่าระบบ</span>
                </a>
            </li>   
        </ul>
    </div>
</nav>