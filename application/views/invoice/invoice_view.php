<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width='device-width', initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?=$title?></title>

    <!-- GLOBAL MAINLY STYLES-->
    <link href="<?=base_url()?>assets/node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="<?=base_url()?>assets/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet" />
    <link href="<?=base_url()?>assets/vendors/themify-icons/css/themify-icons.css" rel="stylesheet" />
    <!-- THEME STYLES-->
    <link href="<?=base_url()?>assets/css/main.min.css" rel="stylesheet" />
    <link href="<?=base_url()?>assets/css/style.css" rel="stylesheet" />
</head>
<body>
    <div class="container">
        <div class="page-heading">
            <h1 class="page-title">ใบกำกับภาษี/ใบเสร็จรับเงิน</h1>
        </div>
        <div class="page-content">
            <div class="ibox invoice">
                <div class="invoice-header">
                    <div class="row">
                        <div class="col-6">
                            <div class="invoice-documentno">
                                <h4><?=$document['doc_no']?></h4>
                            </div>
                            <div>
                                <div class="m-b-5 font-bold"><h5>ผู้ขาย</h5></div>
                                <div class="font-bold"><?=$company['company_name']?> (<?=$company['branch']?>)</div>
                                <ul class="list-unstyled m-t-10">
                                    <li class="m-b-5"><?=nl2br($company['address'])?></li>
                                    <li class="m-b-5"><span class="font-strong">เลขที่ประจำตัวผู้เสียภาษี</span> <?=$company['tax_no']?></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-6 text-right">
                            <div class="clf" style="margin-bottom:30px;">
                                <dl class="row pull-right" style="width:260px;">
                                <dt class="col-sm-6">วันที่เอกสาร</dt><dd class="col-sm-6"><?=str_date($document['doc_date'])?></dd>
                                <dt class="col-sm-6">วันที่ครบกำหนด</dt><dd class="col-sm-6"><?=str_date($document['due_date'])?></dd>
                                <dt class="col-sm-6">เอกสารอ้างอิง</dt><dd class="col-sm-6"><?=$document['ref_doc']?></dd>
                                <dt class="col-sm-6">ผู้ติดต่อ</dt><dd class="col-sm-6"><?=$document['contact_name']?></dd>
                                </dl>
                            </div>
                            <div>
                                <div class="m-b-5 font-bold"><h5>ลูกค้า</h5></div>
                                <div class="font-bold"><?=$document['company_name']?> <?=$document['contact_branch_name']?></div>
                                <ul class="list-unstyled m-t-10">
                                    <li class="m-b-5"><?=nl2br($document['contact_address'])?></li>
                                    <li class="m-b-5"><span class="font-strong">เบอร์โทร</span> <?=$document['contact_tel']?>, <span class="font-strong">แฟกซ์</span> <?=!empty($document['contact_fax'])?$document['contact_fax']:'-'?></li>                                    
                                    <li class="m-b-5"><span class="font-strong">เลขประจำตัวผู้เสียภาษี</span> <?=$document['contact_tax_no']?></li>                                    
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <table class="table table-striped no-margin table-invoice">
                    <thead>
                        <tr>
                            <th style="width: 120px;">#</th>
                            <th>รายละเอียด</th>
                            <th>จำนวน</th>
                            <th>ราคาขาย/หน่วย</th>
                            <th class="text-right">รวม</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($products as $product): ?>
                        <?php
                        $image_url = !empty($product['profile_picture']) ?
                        base_url('uploads/img/'.fullimage($product['profile_picture'], '_sm', 'show')) :
                        base_url('assets/img/image.jpg');
                        ?>
                        <tr>
                            <td><img src="<?=$image_url?>" alt="รูปภาพ" class="img-fluid rounded mx-auto d-block profile-picture-list"></td>
                            <td>
                                <div>
                                    <strong>
                                    <?=($product['type']==1)?$product['sku'].' - ' : ''?><?=$product['name']?>
                                    </strong>
                                </div>
                            </td>
                            <td><?php echo number_format($product['amount'],2) . ' ' . $product['unit']; ?></td>
                            <td><?php echo number_format($product['sell_price'],2); ?></td>
                            <td><?php echo number_format($product['amount'] * $product['sell_price'],2); ?></td>
                        </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>

                <table class="table no-border">
                    <thead>
                        <tr>
                            <th></th>
                            <th width="20%"></th>
                            <th width="15%"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="text-right">
                            <td>&nbsp;</td>
                            <td>รวมทั้งหมด:</td>
                            <td><?php echo number_format($document['total'],2); ?> บาท</td>
                        </tr>
                        <tr class="text-right">
                            <td>&nbsp;</td>
                            <td>ส่วนลด:</td>
                            <td><?php echo number_format($document['discount'],2); ?> บาท</td>
                        </tr>

                        <?php if($document['discount'] > 0) : ?>
                        <tr class="text-right">
                            <td>&nbsp;</td>
                            <td>ราคาหลังหักส่วนลด:</td>
                            <td><?php echo number_format(($document['total'] - $document['discount']),2); ?> บาท</td>
                        </tr>
                        <?php endif; ?>
                        
                        <tr class="text-right">
                            <td>&nbsp;</td>
                            <td>ภาษีมูลค่าเพิ่ม 7%:</td>
                            <td><?php echo number_format($document['vat'], 2); ?> บาท</td>
                        </tr>

                        <?php if($document['vat_type'] == 2): ?>
                        <tr class="text-right">
                            <td>&nbsp;</td>
                            <td>ราคาไม่รวมภาษี:</td>
                            <td><?php echo number_format(($document['total'] - $document['discount'] - $document['vat']),2); ?> บาท</td>
                        </tr>
                        <?php endif; ?>

                        <tr class="text-right">
                            <td style="text-align: center;" class="font-18">(<?=$grand_total_text?>)</td>
                            <td class="font-bold font-18">รวมสุทธิทั้งหมด:</td>
                            <td class="font-bold font-18"><?php echo number_format($document['grand_total'], 2); ?> บาท</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>