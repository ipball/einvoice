<style>
    table.wrap-box {
        width: 100%;
        text-align: left;
        line-height: 97%;
    }

    table.wrap-top {
        width: 100%;        
        text-align: left;
        line-height: 97%;
    }

    table.wrap-content, table.wrap-total {
        width: 100%;        
        text-align: left;
        line-height: 97%;
    }
    table.wrap-content tr th{
        font-weight: bold;
        text-align: center;
        background-color: #eee;
    }

    table.wrap-content tr td{
        border-bottom-color: #ddd;
        border-bottom-style: solid;
        border-bottom-width: 0.5px;
    }

    table.wrap-total tr td{
        text-align: right;
    }

    .line-top{
        border-top: 1px solid #ccc;
    }
    .line-bottom{
        border-bottom: 1px solid #ccc;
    }
    .line-left{
        border-left: 1px solid #ccc;
    }
    .line-right{
        border-right: 1px solid #ccc;
    }

    .header-title {
        font-size: 22px;
        font-weight: bold;
    }    
</style>
<table class="wrap-box" cellpadding="0" cellspacing="0">
    <tr>
        <td style="width: 60%;"><span class="header-title"><?=$company['company_name']?></span>
            <br /> <?=nl2br($company['address'])?>
            <br /> เลขที่ประจำตัวผู้เสียภาษี <?=$company['tax_no']?>
        </td>
        <td style="text-align: right;width: 40%;"><span class="header-title">ใบกำกับภาษี/ใบเสร็จรับเงิน</span></td>
    </tr>
</table>
<div class="line"></div>
<table class="wrap-box line-top" cellpadding="0" cellspacing="0">
    <tr>
        <td style="width:70%;"><table class="wrap-top" cellpadding="3" cellspacing="0">
                <tr>
                    <td style="width:20%;"><b>รหัสลูกค้า</b></td>
                    <td style="width:80%;"><?=$document['contact_code']?></td>
                </tr>
                <tr>
                    <td><b>ชื่อลูกค้า</b></td>
                    <td><?=$document['company_name']?></td>
                </tr>
                <tr>
                    <td><b>ที่อยู่</b></td>
                    <td><?=nl2br($document['contact_address'])?></td>
                </tr>
                <tr>                    
                    <td colspan="2"><b>เบอร์โทร</b> <?=$document['contact_tel']?>, <b>แฟกซ์</b> <?=!empty($document['contact_fax'])?$document['contact_fax']:'-'?></td>
                </tr>
                <tr>
                    <td colspan="2"><b>เลขประจำตัวผู้เสียภาษี</b> <?=$document['contact_tax_no']?></td>
                </tr>
            </table>
        </td>
        <td><table class="wrap-top" cellpadding="3" cellspacing="0">
                <tr>
                    <td style="width:25%;"><b>เลขที่เอกสาร</b></td>
                    <td style="width:75%;"><?=$document['doc_no']?></td>
                </tr>
                <tr>
                    <td><b>วันที่เอกสาร</b></td>
                    <td><?=str_date($document['doc_date'])?></td>
                </tr>
                <tr>
                    <td><b>วันที่ครบกำหนด</b></td>
                    <td><?=str_date($document['due_date'])?></td>
                </tr>
                <tr>
                    <td><b>เอกสารอ้างอิง</b></td>
                    <td><?=$document['ref_doc']?></td>
                </tr>
                <tr>
                    <td><b>ผู้ติดต่อ</b></td>
                    <td><?=$document['contact_name']?></td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<div class="line"></div>
<table class="wrap-box" cellpadding="0" cellspacing="0">
    <tr>
        <td><table class="wrap-content" cellpadding="3" cellspacing="0">
            <tr>
                <th style="width:5%;">#</th>
                <th style="width:20%;">รหัสสินค้า</th>
                <th style="width:35%;">รายละเอียด</th>
                <th style="width:13%;">จำนวน</th>
                <th style="width:12%;">ราคา/หน่วย</th>
                <th style="width:15%;">รวม</th>
            </tr>
            <?php for($i = $start_page; $i < $last_page; $i++): ?>
                <tr>
                    <td style="text-align:center;"><?php echo ($i+1); ?></td>
                    <td><?=$document['products'][$i]['sku']?></td>
                    <td><?=$document['products'][$i]['name']?></td>
                    <td style="text-align:right;"><?php echo number_format($document['products'][$i]['amount'],2) . ' ' . $document['products'][$i]['unit']; ?></td>
                    <td style="text-align:right;"><?php echo number_format($document['products'][$i]['sell_price'],2); ?></td>
                    <td style="text-align:right;"><?php echo number_format($document['products'][$i]['amount'] * $document['products'][$i]['sell_price'],2); ?></td> 
                </tr>
            <?php endfor; ?>
        </table></td>
    </tr>
</table>

<?php if($count == $curr_page): ?>
    <table class="wrap-box" cellpadding="0" cellspacing="0">
        <tr>
            <td><table class="wrap-total" cellpadding="3" cellspacing="0">
                    <tr>
                        <td style="width: 60%">&nbsp;</td>
                        <td style="width: 20%; font-weight: bold;">รวมทั้งหมด</td>
                        <td style="width: 20%;"><?php echo number_format($document['total'],2); ?> บาท</td>
                    </tr>                    
                        <tr>
                            <td>&nbsp;</td>
                            <td style="font-weight: bold;">ส่วนลด</td>
                            <td><?php echo number_format($document['discount'],2); ?> บาท</td>
                        </tr>
                        <?php if($document['discount'] > 0) : ?>
                        <tr>
                            <td>&nbsp;</td>
                            <td style="font-weight: bold;">ราคาหลังหักส่วนลด</td>
                            <td><?php echo number_format(($document['total'] - $document['discount']),2); ?> บาท</td>
                        </tr>    
                    <?php endif; ?>                    
                    <tr>
                        <td>&nbsp;</td>
                        <td style="font-weight: bold;">ภาษีมูลค่าเพิ่ม 7%</td>
                        <td><?php echo number_format($document['vat'], 2); ?> บาท</td>
                    </tr>
                    <?php if($document['vat_type'] == 2): ?>
                        <tr>
                            <td>&nbsp;</td>
                            <td style="font-weight: bold;">ราคาไม่รวมภาษี</td>
                            <td><?php echo number_format(($document['total'] - $document['discount'] - $document['vat']),2); ?> บาท</td>
                        </tr>
                    <?php endif; ?>
                    <tr>
                        <td style="text-align: center;">(<?=$grand_total_text?>)</td>
                        <td style="font-weight: bold;"> รวมสุทธิทั้งหมด</td>
                        <td><?php echo number_format($document['grand_total'], 2); ?> บาท</td>
                    </tr>
                    <tr>
                        <td style="width: 50%">&nbsp;</td>
                        <td style="width: 10%"></td>
                        <td style="border-top: 0.5px solid #ccc; width: 40%;">&nbsp;</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <?php if(!empty($document['remark'])): ?>
        <table class="wrap-box" cellpadding="0" cellspacing="0">
            <tr>
                <td><b>หมายเหตุ</b><br />
                <?php echo nl2br($document['remark']); ?>
                </td>
            </tr>
        </table>
    <?php endif; ?>

<?php endif; ?>