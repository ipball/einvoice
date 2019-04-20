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
            { id: 2, name: 'เช็ค' }
        ],
        vat_types: [
            { id: 1, name: 'None Vat' },
            { id: 2, name: 'Including Vat' },
            { id: 3, name: 'Excluding Vat' }
        ],
        product: 0,
        products: [
            { id: 1, text: 'Hello' },
            { id: 2, text: 'World' }
        ],
        dateEn: dateEn
    },
    methods: {
        onSave: function () {
            console.log(this.document);
        }
    },
    created() {
        var urlProducts = $url + 'product/get_all';        
        axios.get(urlProducts).then((res) => {
            
        });
    }
});