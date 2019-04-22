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
                searchData.is_employee = $('input[name=is_employee]').val();
                return $.extend(d, searchData);
            }
        },
        order: [
            [4, 'desc']
        ],
        columns: [{
                data: 'firstname'
            },
            {
                data: 'department_name'
            },
            {
                data: 'invoice_type_name'
            },
            {
                data: 'type'
            },
            {
                data: 'start_date'
            },
            {
                data: 'total'
            },
            {
                data: 'reference_file'
            },
            {
                data: 'status'
            },
            {
                data: 'id'
            }
        ],
        columnDefs: [{
                targets: 3,
                render: function (data, type, row) {
                    var result;
                    if (data == 1) {
                        result = '<span class="badge badge-success badge-pill m-r-5 m-b-5">ลาเต็มวัน</span>';
                    } else if (data == 2) {
                        result = '<span class="badge badge-default badge-pill m-r-5 m-b-5">ลาครึ่งวัน เช้า</span>';
                    } else if (data == 3) {
                        result = '<span class="badge badge-default badge-pill m-r-5 m-b-5">ลาครึ่งวัน บ่าย</span>';
                    }

                    return result;
                },
            },
            {
                targets: 4,
                render: function (data, type, row) {
                    return data ? moment(data, 'YYYY-MM-DD').format('DD/MM/YYYY') : '';
                },
            },
            {
                targets: [5, 6],
                orderable: false
            },
            {
                targets: 6,
                render: function (data, type, row) {
                    var result = null;
                    if (data) {
                        result = '<a href="' + $url + 'uploads/file/' + data + '" target="_blank" class="btn btn-xs btn-rounded btn-outline-info"><i class="ti-write"></i> เปิดดู</a>';
                    }
                    return result;
                },
            },
            {
                targets: 7,
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
                targets: 8,
                orderable: false,
                render: function (data, type, row) {
                    var result;
                    if(row.role == 'ADMINISTRATOR') {
                        result = (row.status==1) ? '<button class="btn btn-outline-warning btn-sm btn-modal" data-href="' + $url + 'invoice/approval/' + data + '" data-modal-name="largeModal"><i class="ti-pencil-alt"></i> การอนุมัติ</button>' : '';
                    } else {
                        result = (row.own_action && row.status==1) ? '<div class="btn-group m-b-10">' +
                        '<a class="btn btn-outline-info btn-sm" href="' + $url + 'invoice/pdf/' + data + '" target="_blank"><i class="ti-printer"></i> พิมพ์</a> ' +
                        '<button class="btn btn-outline-warning btn-sm btn-modal" data-href="' + $url + 'invoice/edit/' + data + '" data-modal-name="largeModal"><i class="ti-pencil-alt"></i> แก้ไข</button>' +
                        '<button class="btn btn-outline-danger btn-sm btn-delete" data-name="' + row.firstname + '" data-href="' + $url + 'invoice/delete/' + data + '"><i class="ti-trash"></i> ยกเลิกการลา</button>' +
                        '</div>'
                        : '<a class="btn btn-outline-info btn-sm" href="' + $url + 'invoice/pdf/' + data + '" target="_blank"><i class="ti-printer"></i> พิมพ์</a>';
                    }                    
                    return result;
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
                start_date: {
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
    
    // approve or reject function status
    var setStatus = function(title,status) {
        swal({
            title: title,            
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#5c6bc0',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes'
        }).then(function(result){
            if (result.value) {
                var id = $('input[name=id]').val();
                axios.post($url+'invoice/set_status', {id:id, status: status}).then(function(){
                    $('.modal-form').modal('hide');
                    table.ajax.reload();
                });
            }
        }).catch(swal.noop);
    };

    // trigger search event
    $('body').on('changed.bs.select', 'select[name=department_id]', function (e, clickedIndex, isSelected, previousValue) {
        searchData.department_id = $('select[name=department_id]').val();
        table.ajax.reload();
    });

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
        searchData.start_date = start.format('YYYY-MM-DD');
        searchData.end_date = end.format('YYYY-MM-DD');
        table.ajax.reload();
    });
});