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
            vat_type: null

        },
        options: [
            'foo',
            'bar',
            'baz'
        ],
        payment_types: [
            {id: 1, name: 'เงินสด'},
            {id: 2, name: 'เช็ค'}
        ],
        vat_types: [
            {id: 1, name: 'None Vat'},
            {id: 2, name: 'Including Vat'},
            {id: 3, name: 'Excluding Vat'}
        ],
        dateEn: {
            dow: 0, // Sunday is the first day of the week
            hourTip: 'Select Hour', // tip of select hour
            minuteTip: 'Select Minute', // tip of select minute
            secondTip: 'Select Second', // tip of select second
            yearSuffix: '', // suffix of head year
            monthsHead: 'January_February_March_April_May_June_July_August_September_October_November_December'.split('_'), // months of head
            months: 'Jan_Feb_Mar_Apr_May_Jun_Jul_Aug_Sep_Oct_Nov_Dec'.split('_'), // months of panel
            weeks: 'Su_Mo_Tu_We_Th_Fr_Sa'.split('_'), // weeks
            cancelTip: 'cancel',
            submitTip: 'confirm'
          }
    }
});