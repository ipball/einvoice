<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<div id="app" class="row">
    <div class="col-md-12">
        <div class="ibox">
            <div class="ibox-head">
                <div class="ibox-title">สร้างใบแจ้งหนี้ (Invoice)</div>
                <div class="ibox-tools">
                    <h5 class="font-extra-bold text-success">{{ document.doc_no ? document.doc_no : 'NEW INVOICE' }}</h5>
                </div>
            </div>
            <div class="ibox-body">
                <form>
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>ลูกค้า</label>
                                <select2 :options="contacts" v-model="document.contact_id"></select2>
                            </div>
                        </div>
                        <div class="col-sm-8">
                            <div class="float-right d-flex justify-content-between">
                                <div>
                                    <span class="badge badge-default m-r-5 m-b-5" style="font-size: 16px;">รอดำเนินการ</span>
                                </div>
                                <div class="border-left pl-2 ml-2">
                                    <span class="text-info font-bold" style="font-size: 18px;">THB {{ document.grand_total | numberFormat }}</span><br/>
                                    <span class="text-muted">จำนวนเงินรวม</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr />
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="row">
                                <div class="col-sm-6 form-group">
                                    <label>เลขที่ประจำตัวผู้เสียภาษี</label>
                                    <input class="form-control" v-model="document.contact_tax_no">
                                </div>
                                <div class="col-sm-6 form-group">
                                    <label>สาขา</label>
                                    <input class="form-control" v-model="document.contact_branch_name">
                                </div>
                                <div class="col-sm-12 form-group">
                                    <label>ที่อยู่ลูกค้า</label>
                                    <textarea class="form-control" v-model="document.contact_address"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="row">
                                <div class="col-sm-6 form-group">
                                    <label>ชื่อผู้ติดต่อ</label>
                                    <input class="form-control" v-model="document.contact_name">
                                </div>
                                <div class="col-sm-6 form-group">
                                    <label>อีเมล์ลูกค้า</label>
                                    <input class="form-control" v-model="document.contact_email">
                                </div>
                                <div class="col-sm-6 form-group">
                                    <label>เบอร์โทรศัพท์ลูกค้า</label>
                                    <input class="form-control" v-model="document.contact_tel">
                                </div>
                                <div class="col-sm-6 form-group">
                                    <label>เบอร์โทรสารลูกค้า</label>
                                    <input class="form-control" v-model="document.contact_fax">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4 border-left">
                            <div class="row">
                                <div class="col-sm-4 form-group">
                                    <label>วันที่เอกสาร</label>
                                    <vue-datepicker-local v-model="document.doc_date" :local="dateEn" clearable format="DD/MM/YYYY"></vue-datepicker-local>
                                </div>
                                <div class="col-sm-4 form-group">
                                    <label>วันที่ครบกำหนด</label>
                                    <vue-datepicker-local v-model="document.due_date" :local="dateEn" clearable format="DD/MM/YYYY"></vue-datepicker-local>
                                </div>
                                <div class="col-sm-4 form-group">
                                    <label>การชำระ</label>                                    
                                    <select2 :options="payment_types" v-model="document.payment_type"></select2>
                                </div>
                                <div class="col-sm-4 form-group">
                                    <label>เอกสารอ้างอิง</label>
                                    <input class="form-control" v-model="document.ref_doc">
                                </div>
                                <div class="col-sm-4 form-group">
                                    <label>เครดิต (วัน)</label>
                                    <input class="form-control" v-model="document.credit_day">
                                </div>
                                <div class="col-sm-4 form-group">
                                    <label>การคิดภาษี</label>                                    
                                    <select2 :options="vat_types" v-model="document.vat_type"></select2>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr />
                    <div class="row">
                        <div class="col-sm-4 mb-3">
                            <select2 :options="products" v-model="product"></select2>
                        </div>
                        <div class="col-sm-12">
                            <table class="table">
                                <thead>
                                    <tr class="table-secondary">
                                        <th scope="col" style="width: 60px;">#</th>
                                        <th scope="col" style="width: 300px;">รหัส (SKU)</th>
                                        <th scope="col">สินค้า</th>
                                        <th scope="col" class="text-center" style="width: 100px;">จำนวน</th>
                                        <th scope="col" style="width: 100px;" class="text-right">ราคา/หน่วย</th>
                                        <th scope="col" style="width: 100px;" class="text-right">รวมเป็นเงิน</th>
                                        <th scope="col" style="width: 60px;" class="text-center">&nbsp;</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <template v-if="document.products.length > 0">
                                        <tr v-for="(product, index) in document.products">
                                            <td>{{ index+1 }}</td>
                                            <td>{{ product.sku }}</td>
                                            <td>{{ product.name }}</td>
                                            <td><input class="form-control form-control-sm text-right" type="number" v-model="product.amount"></td>
                                            <td class="text-right">{{ product.sell_price | numberFormat }}</td>
                                            <td class="text-right">{{ (product.sell_price*product.amount) | numberFormat }}</td>
                                            <td><button type="button" class="btn btn-sm btn-danger btn-circle" @click="removeProduct(index)"><i class="fa fa-times"></i></button></td>
                                        </tr>
                                    </template>
                                    <template v-else>
                                        <tr>
                                            <td colspan="7" class="text-center text-danger">ไม่มีข้อมูล</td>
                                        </tr>
                                    </template>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-sm-12">
                            <div class="float-right d-flex justify-content-between">
                                <table class="table" style="width: 350px;">
                                    <tr>
                                        <th>รวม</th>
                                        <td class="text-right">{{ total | numberFormat }}</td>
                                    </tr>
                                    <tr>
                                        <th>ส่วนลด</th>
                                        <td><input class="form-control form-control-sm text-right" type="number" v-model="document.discount"></td>
                                    </tr>
                                    <tr v-if="document.discount > 0">
                                        <th>จำนวนเงินหลังหักส่วนลด</th>
                                        <td class="text-right">{{ totalAfterDiscount | numberFormat }}</td>
                                    </tr>
                                    <tr>
                                        <th>ภาษีมูลค่าเพิ่ม 7%</th>
                                        <td class="text-right">{{ vat | numberFormat }}</td>
                                    </tr>
                                    <tr v-if="document.vat_type == 2">
                                        <th>ราคาไม่รวมภาษี</th>
                                        <td class="text-right">{{ document.total_after_vat | numberFormat }}</td>
                                    </tr>
                                    <tr>
                                        <th>จำนวนเงินรวมทั้งหมด</th>
                                        <td class="text-right">{{ grandTotal | numberFormat }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>                    
                    <div class="form-group">
                        <button class="btn btn-primary" type="button" @click="onSave">บันทึก</button>
                        <a href="<?=base_url('invoice')?>" class="btn btn-danger" role="button">ยกเลิก</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<style>
 .select2-container{
    width: 100%!important;
}
.datepicker {
    z-index: auto;
}
</style>