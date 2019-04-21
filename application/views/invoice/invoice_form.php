<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<div id="app" class="row">
    <div class="col-md-12">
        <div class="ibox">
            <div class="ibox-head">
                <div class="ibox-title">สร้างใบแจ้งหนี้ (Invoice)</div>
                <div class="ibox-tools">
                    <h5 class="font-extra-bold text-success">{{ document.doc_no }}</h5>
                </div>
            </div>
            <div class="ibox-body">
                <form>
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>ลูกค้า</label>
                                <v-select :options="options" v-model="document.contact_id"></v-select>
                            </div>
                        </div>
                        <div class="col-sm-8">
                            <div class="float-right d-flex justify-content-between">
                                <div>
                                    <span class="badge badge-default m-r-5 m-b-5" style="font-size: 16px;">รอดำเนินการ</span>
                                </div>
                                <div class="border-left pl-2 ml-2">
                                    <span class="text-info font-bold" style="font-size: 18px;">THB 0.00</span><br/>
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
                        <div class="col-sm-4">
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
                                    <v-select :options="payment_types" v-model="document.payment_type" label="name"></v-select>
                                </div>
                                <div class="col-sm-3 form-group">
                                    <label>เอกสารอ้างอิง</label>
                                    <input class="form-control" v-model="document.ref_doc">
                                </div>
                                <div class="col-sm-3 form-group">
                                    <label>เครดิต (วัน)</label>
                                    <input class="form-control" v-model="document.credit_date">
                                </div>
                                <div class="col-sm-6 form-group">
                                    <label>การคิดภาษี</label>
                                    <v-select :options="vat_types" v-model="document.vat_type" label="name"></v-select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr />
                    <div class="row">
                        <div class="col-sm-4 mb-3">
                            <select2 :options="products" v-model="product">                                
                            </select2>
                        </div>
                        <div class="col-sm-8">
                            <button type="button" class="btn btn-warning" @click="addProduct"><i class="ti-plus"></i> เพิ่มสินค้า</button>
                        </div>
                        <div class="col-sm-12">
                            <table class="table">
                                <thead>
                                    <tr class="table-secondary">
                                        <th scope="col" style="width: 60px;">#</th>
                                        <th scope="col" style="width: 300px;">รหัส (SKU)</th>
                                        <th scope="col">สินค้า</th>
                                        <th scope="col" style="width: 100px;">จำนวน</th>
                                        <th scope="col" style="width: 100px;">ราคา/หน่วย</th>
                                        <th scope="col" style="width: 100px;">รวมเป็นเงิน</th>
                                        <th scope="col" style="width: 60px;" class="text-center">&nbsp;</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <template v-if="document.products.length > 0">
                                        <tr v-for="(product, index) in document.products">
                                            <td>{{ index+1 }}</td>
                                            <td>{{ product.sku }}</td>
                                            <td>{{ product.name }}</td>
                                            <td><input class="form-control form-control-sm" type="number" v-model="product.amount"></td>
                                            <td>{{ product.sell_price | numberFormat }}</td>
                                            <td>{{ (product.sell_price*product.amount) | numberFormat }}</td>
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
</style>