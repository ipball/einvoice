$(function () {
    var searchData = {};
    var table = $('#invoiceTable').DataTable({
        language: {
            url: $url + 'assets/js/datatables-th.lang'
        },
        serverSide: true,
        processing: true,
        lengthChange: false,
        searching: false,
        ajax: {
            url: $url + 'invoice/datatables',
            data: function (d) {
                searchData.status = $('select[name=status]').val();
                return $.extend(d, searchData);
            }
        },
        order: [
            [4, 'desc']
        ],
        columns: [{
                data: 'doc_no'
            },
            {
                data: 'name'
            },
            {
                data: 'doc_date'
            },
            {
                data: 'grand_total'
            },
            {
                data: 'due_date'
            },
            {
                data: 'pay_total'
            },            
            {
                data: 'status'
            },
            {
                data: 'id'
            }
        ],
        columnDefs: [
            {
                targets: [2, 4],
                render: function (data, type, row) {
                    return data ? moment(data, 'YYYY-MM-DD').format('DD/MM/YYYY') : '';
                },
            },
            {
                targets: [3, 5],                
                render: function(data, type, row) {
                    return numeral(data).format('0,0.00');
                }
            },            
            {
                targets: 6,
                orderable: false,
                render: function (data, type, row) {
                    var result;
                    if (data == 1) {
                        result = '<span class="badge badge-info badge-pill m-r-5 m-b-5">รออนุมัติ</span>';
                    } else if (data == 2) {
                        result = '<span class="badge badge-success badge-pill m-r-5 m-b-5">อนุมัติแล้ว</span>';
                    } else if (data == 3) {
                        result = '<span class="badge badge-danger badge-pill m-r-5 m-b-5">ไม่อนุมัติ</span>';
                    } else if (data == 4) {
                        result = '<span class="badge badge-default badge-pill m-r-5 m-b-5">ยกเลิก</span>';
                    }

                    return result;
                },
            },
            {
                targets: 7,
                orderable: false,
                render: function (data, type, row) {
                    return '<div class="btn-group m-b-10">' +
                        '<a class="btn btn-outline-info btn-sm" href="' + $url + 'invoice/pdf/' + data + '" target="_blank" role="button"><i class="ti-printer"></i> พิมพ์</a> ' +
                        '<button class="btn btn-outline-warning btn-sm btn-modal btn-edit" data-href="' + $url + 'invoice/edit/' + data + '" type="button"><i class="ti-pencil-alt"></i> แก้ไข</button>' +
                        '<button class="btn btn-outline-danger btn-sm btn-delete" data-name="' + row.doc_no + '" data-href="' + $url + 'invoice/delete/' + data + '" type="button"><i class="ti-trash"></i> ลบเอกสาร</button>' +
                        '</div>';                                        
                },
            },
        ]
    });

    $('.modal-form').on('shown.bs.modal', function (e) {
        var saved = false;

        $('.btn-save').on('click', function () {
            if (saved) return false;
            saved = true;
            $('#invoiceForm').submit();
        });

        var saveCallback = function () {
            table.ajax.reload();
        };

        $('#invoiceForm').validate({
            submitHandler: function () {
                saveForm($url + 'invoice/save', $('#invoiceForm').serializeJSON(), saveCallback);
                return false;
            },
            rules: {
                doc_date: {
                    required: true,
                },
                tel: {
                    required: true,
                },
                reason: {
                    required: true,
                },
                address: {
                    required: true,
                },
                temple_name: {
                    required: true,
                },
                temple_address: {
                    required: true
                },
                wife_name: {
                    required: true
                },
                spawn_date: {
                    required: true
                },
                summons: {
                    required: true
                },
                summons_address: {
                    required: true
                },
                summons_date: {
                    required: true
                },
                summons_place: {
                    required: true
                },
                summons_reason: {
                    required: true
                }
            },
            messages: {},
            errorElement: 'span',
            errorPlacement: function (error, element) {
                validErrorPlacement(error, element);
            },
            highlight: function (element, errorClass, validClass) {
                saved = false;
                validHighlight(element);
            },
            unhighlight: function (element, errorClass, validClass) {
                validUnhighlight(element);
            }
        });
    });

    $('body').on('click', '.btn-delete', function (e) {
        e.preventDefault();
        var delCallback = function () {
            table.ajax.reload();
        };

        var url = $(this).attr('data-href');
        var name = $(this).attr('data-name');
        deleteConf(url, name, delCallback);
    });

    $('body').on('click', '.btn-edit', function (e) {
        e.preventDefault();        

        var url = $(this).attr('data-href');
        window.location.href = url;
    });

    // trigger search event

    $('body').on('changed.bs.select', 'select[name=status]', function (e, clickedIndex, isSelected, previousValue) {
        searchData.status = $('select[name=status]').val();
        table.ajax.reload();
    });

    $('body').on('keyup', 'input[name=search]', function () {
        searchData.keyword = $('input[name=search]').val();
        table.ajax.reload();
    });

    $('.date-range').daterangepicker({
        ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        "startDate": moment().startOf('month'),
        "endDate": moment().endOf('month'),
        "opens": "left"
    }, function (start, end, label) {
        $('.date-range').find('.ca-label').html(label);
        searchData.start_doc_date = start.format('YYYY-MM-DD');
        searchData.end_doc_date = end.format('YYYY-MM-DD');
        table.ajax.reload();
    });
});