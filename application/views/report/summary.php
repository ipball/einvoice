<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<div class="row">
    <div class="col-md-12">
        <div class="ibox">
            <div class="ibox-head">
                <div class="ibox-title">รายงานสรุปการลาประจำปี <?=date('Y')?></div>
            </div>
            <div class="ibox-body">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>ชื่อ-นามสกุล</th>                            
                            <th>ม.ค.</th>
                            <th>ก.พ.</th>
                            <th>มี.ค.</th>
                            <th>เม.ย.</th>
                            <th>พ.ค.</th>
                            <th>มิ.ย.</th>
                            <th>ก.ค.</th>
                            <th>ส.ค.</th>
                            <th>ก.ย.</th>
                            <th>ต.ค.</th>
                            <th>พ.ย.</th>
                            <th>ธ.ค.</th>
                            <th>รวม</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($leaves as $leave): ?>
                        <tr>
                            <td><?=$leave['name']?></td>
                            <?php                 
                            $line_total = 0;           
                            for($i=0; $i<12;$i++):
                            $total = !empty($leave['total_months'][$i]) ? number_format($leave['total_months'][$i], 2) : '-';
                            $line_total += is_numeric($total) ? $total : 0;
                            ?>
                            <td><?=$total?></td>
                            <?php endfor; ?>
                            <td><?=number_format($line_total,2)?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>