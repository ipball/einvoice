var app = new Vue({
    el: '#app',
    data: {
        document: {
            doc_no: 'INV19040001',
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
            grand_total: 0,
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
            { id: 1, text: 'None Vat' },
            { id: 2, text: 'Including Vat' },
            { id: 3, text: 'Excluding Vat' }
        ],
        product: '',
        products: [],
        contacts: [],
        dateEn: dateEn
    },
    methods: {
        onSave: function () {
            console.log(this.document);
        },
        removeProduct: function (index) {
            this.document.products.splice(index, 1);
        }
    },
    created() {
        var urlProducts = $url + 'product/get_all';
        var urlContacts = $url + 'contact/get_all';

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
                obj.text = item.code + ' - ' +item.name;
                return obj;
            });
            this.contacts.splice(0, 0, { id: '', text: 'เลือกลูกค้า' });
        });
    },
    watch: {
        product: function (val) {
            if (val == '') return false;
            index = this.products.findIndex(o => o.id === val);
            this.document.products.push(this.products[index]);
        },
        contactIdChange: function(val){
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
        totalAfterDiscount: function() {
            let result = this.document.total - this.document.discount;
            return result;
        },
        vat: function() {
            let result = 0;
            return result;
        },
        contactIdChange: function() {
            return this.document.contact_id;
        }
    }
});