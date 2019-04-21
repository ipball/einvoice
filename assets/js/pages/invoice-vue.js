Vue.component('v-select', VueSelect.VueSelect);

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
            payment_type: null,
            ref_doc: null,
            credit_date: 0,
            vat_type: null,
            products: []
        },
        options: [
            'foo',
            'bar',
            'baz'
        ],
        payment_types: [
            { id: 1, name: 'เงินสด' },
            { id: 2, name: 'เงินเชื่อ' },
            { id: 3, name: 'เงินโอน' },
            { id: 4, name: 'เช็ค' },
            { id: 5, name: 'บัตรเครดิต' },
        ],
        vat_types: [
            { id: 1, name: 'None Vat' },
            { id: 2, name: 'Including Vat' },
            { id: 3, name: 'Excluding Vat' }
        ],
        product: '',
        products: [],
        dateEn: dateEn
    },
    methods: {
        onSave: function () {
            console.log(this.document);
        },
        addProduct: function() {
            if(this.product === '') return false;
            index = this.products.findIndex(o => o.id === this.product);                     
            this.document.products.push(this.products[index]);
            this.product = '';
        },
        removeProduct: function(index) {
            this.document.products.splice(index, 1);
        }
    },
    created() {
        var urlProducts = $url + 'product/get_all';
        axios.get(urlProducts).then((res) => {
            this.products = res.data.map(function(item){
                let obj = Object.assign({}, item);
                obj.text = item.name;
                obj.amount = 1;
                return obj;
            });
            this.products.splice(0, 0, {id: '', text: 'เลือกสินค้าไว้ในรายการ'});
        });
    }
});