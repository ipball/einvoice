var app = new Vue({
    el: '#app',
    data: {
        document: {
            id: null,
            doc_no: null,
            contact_id: null,
            contact_address: null,
            contact_tax_no: null,
            contact_branch_name: null,
            contact_name: null,
            contact_email: null,
            contact_tel: null,
            contact_fax: null,
            doc_date: null,
            due_date: null,
            payment_type: 1,
            ref_doc: null,
            credit_day: 0,
            vat_type: 1,
            vat: 0,
            products: [],
            discount: 0,
            total: 0,
            total_after_vat: 0,
            grand_total: 0,
            pay_total: 0,
            type: 1,
            status: 1,
            remark: null
        },
        payment_types: [
            { id: 1, text: 'เงินสด' },
            { id: 2, text: 'เงินเชื่อ' },
            { id: 3, text: 'เงินโอน' },
            { id: 4, text: 'เช็ค' },
            { id: 5, text: 'บัตรเครดิต' },
        ],
        vat_types: [
            { id: 1, text: 'Excluding Vat' },
            { id: 2, text: 'Including Vat' },
            { id: 3, text: 'None Vat' }
        ],
        product: '',
        products: [],
        contacts: [],
        allstatus: [
            { id: 1, text: 'รอดำเนินการ' },
            { id: 2, text: 'รอเก็บเงิน' },
            { id: 3, text: 'เก็บเงินยังไม่ครบ' },
            { id: 4, text: 'เก็บเงินครบแล้ว' },
            { id: 5, text: 'เอกสารถูกยกเลิก' }
        ],
        statusText: null,
        dateEn: dateEn
    },
    methods: {
        onSave: function () {
            if (this.document.products.length == 0) {
                showBox('ไม่มีรายการสินค้า กรุณาระบุ!', 'error');
                return false;
            } else if (this.document.contact_id == '' || this.document.contact_id == null) {
                showBox('ยังไม่ได้เลือกลูกค้า กรุณาระบุ!', 'error');
                return false;
            } else if (this.document.doc_date == '' || this.document.doc_date == null) {
                showBox('ยังไม่ได้ระบุวันที่เอกสาร กรุณาระบุ!', 'error');
                return false;
            } else if (this.document.due_date == '' || this.document.due_date == null) {
                showBox('ยังไม่ได้ระบุวันที่ครบกำหนด กรุณาระบุ!', 'error');
                return false;
            }

            axios.post($url + 'invoice/save', this.document)
                .then((response) => {
                    if (response.status === 200) {
                        showBox('บันทึกข้อมูลสำเร็จ', 'success');
                        this.document.id = response.data.id
                        this.document.doc_no = response.data.doc_no;
                    } else {
                        showBox('Status not 200', 'error');
                    }
                }).catch((error) => {
                    showBox('เกิดข้อผิดพลาด', 'error');
                });
        },
        removeProduct: function (index) {
            this.document.products.splice(index, 1);
        }
    },
    created() {
        let urlProducts = $url + 'product/get_all';
        let urlContacts = $url + 'contact/get_all';
        let documentId = parseInt(getValFromUrl());

        axios.get(urlProducts).then((res) => {
            this.products = res.data.map(function (item) {
                let obj = Object.assign({}, item);
                obj.text = item.sku + ' - ' + item.name;
                obj.amount = 1;
                return obj;
            });
            this.products.splice(0, 0, { id: '', text: 'เลือกสินค้าไว้ในรายการ' });
        });

        axios.get(urlContacts).then((res) => {
            this.contacts = res.data.map(function (item) {
                let obj = Object.assign({}, item);
                obj.text = item.code + ' - ' + item.name;
                return obj;
            });
            this.contacts.splice(0, 0, { id: '', text: 'เลือกลูกค้า' });
        }).then(() => {
            if (Number.isInteger(documentId)) {
                axios.get($url + 'invoice/get_by_id/' + documentId).then((res) => {
                    this.document = res.data;
                });
            }
        });
    },
    watch: {
        product: function (val) {
            if (val == '') return false;
            index = this.products.findIndex(o => o.id === val);
            let product = JSON.parse(JSON.stringify(this.products[index]));
            this.document.products.push(product);
        },
        contactIdChange: function (val) {
            if (val == '') return false;
            index = this.contacts.findIndex(o => o.id === val);
            this.document.contact_tax_no = this.contacts[index].tax_no;
            this.document.contact_branch_name = this.contacts[index].branch_name;
            this.document.contact_address = this.contacts[index].address;
            this.document.contact_name = this.contacts[index].contact_name;
            this.document.contact_email = this.contacts[index].email;
            this.document.contact_tel = this.contacts[index].tel;
            this.document.contact_fax = this.contacts[index].fax;
            this.document.credit_day = this.contacts[index].credit_day;
        },
        statusChange: function(val) {            
            if (val == '') return false;
            index = this.allstatus.findIndex(o => o.id == val);            
            this.statusText = this.allstatus[index].text;
        }
    },
    computed: {
        total: function () {
            let result = 0;
            if (this.document.products.length > 0) {
                result = this.document.products.reduce((prev, cur) => prev + (cur.amount * cur.sell_price), 0);
            }
            this.document.total = result;
            return result;
        },
        totalAfterDiscount: function () {
            let result = this.document.total - this.document.discount;
            return result;
        },
        vat: function () {
            let result = 0;
            let vatCal = 7; // #hardcode  - change here
            let total = this.document.total - this.document.discount;

            if (this.document.vat_type == 1) {
                result = total * (vatCal / 100);
            } else if (this.document.vat_type == 2) {
                let vat = 100 / (100 + vatCal);
                this.document.total_after_vat = (total * vat).toFixed(2);
                result = total - this.document.total_after_vat;
            }

            this.document.vat = result;

            return result;
        },
        grandTotal: function () {
            total = this.document.total - this.document.discount;
            let result = total;

            if (this.document.vat_type == 1) {
                result = total + this.document.vat;
            }

            this.document.grand_total = result;

            return result;
        },
        contactIdChange: function () {
            return this.document.contact_id;
        },
        statusChange: function () {
            return this.document.status;
        }
    }
});