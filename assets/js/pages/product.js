$(function () {
    var searchData = {};
    var table = $('#productTable').DataTable({
        language: {
            url: $url + 'assets/js/datatables-th.lang'
        },
        serverSide: true,
        processing: true,
        lengthChange: false,
        searching: false,
        ajax: {
            url: $url + 'product/datatables',
            data: function (d) {
                return $.extend(d, searchData);
            }
        },
        order: [
            [1, 'asc']
        ],
        columns: [{
                data: 'image_url'
            },
            {
                data: 'name'
            },
            {
                data: 'sell_price'
            },
            {
                data: 'type'
            },
            {
                data: 'categorie_name'
            },
            {
                data: 'quantity'
            },
            {
                data: 'status'
            },
            {
                data: 'id'
            }
        ],
        columnDefs: [{
                targets: 0,
                orderable: false,
                render: function (data, type, row) {
                    return '<img src="' + data + '" alt="รูปภาพ" class="img-fluid rounded mx-auto d-block profile-picture-list">';
                },
            },
            {
                targets: 1,                
                render: function (data, type, row) {
                    var sku = '<br/><span class="text-info small-text"><strong>รหัสสินค้า</strong> ' + row.sku + '</span>';
                    var barcode = (row.sex != '') ? '<br/><span class="text-info small-text"><strong>บาร์โค๊ด</strong> ' + row.barcode + '</span>' : '';
                    return data + sku + barcode;
                },
            },
            {
                targets: 2,                
                render: function (data, type, row) {
                    var buy_price = '<span class="text-black-50 small-text"><strong>ราคาซื้อ</strong> ' + row.buy_price + '</span>';
                    var sell_price = '<br/><span class="text-black-50 small-text"><strong>ราคาขาย</strong> ' + row.sell_price + '</span>';
                    return buy_price + sell_price;
                },
            },
            {
                targets: 3,                
                render: function (data, type, row) {
                    var result = '';

                    if(data == 1){
                        result = 'สินค้านับสต็อก';
                    } else if (data == 2) {
                        result = 'สินค้าไม่นับสต็อก';
                    } else if (data == 3) {
                        result = 'สินค้าบริการ';
                    }

                    return result;
                },
            },
            {
                targets: 6,
                orderable: false,
                render: function (data, type, row) {
                    return data == 1 ? '<span class="badge badge-primary badge-pill m-r-5 m-b-5">Active</span>' : '<span class="badge badge-danger badge-pill m-b-5">Inactive</span>';
                },
            },
            {
                targets: 7,
                orderable: false,
                render: function (data, type, row) {
                    return '<div class="btn-group m-b-10">' +
                        '<button class="btn btn-outline-warning btn-sm btn-modal" data-href="' + $url + 'product/edit/' + data + '" data-modal-name="largeModal"><i class="ti-pencil-alt"></i> แก้ไข</button>' +
                        '<button class="btn btn-outline-danger btn-sm btn-delete" data-name="' + row.name + '" data-href="' + $url + 'product/delete/' + data + '"><i class="ti-trash"></i> ลบข้อมูล</button>' +
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
            $('#productForm').submit();
        });

        var saveCallback = function () {
            table.ajax.reload();
        };

        $('#productForm').validate({
            submitHandler: function () {
                saveForm($url + 'product/save', $('#productForm').serializeJSON(), saveCallback);
                return false;
            },
            rules: {
                sku: {
                    required: true,
                    alphanumeric: true,
                    remote: {
                        url: $url + 'product/sku_check',
                        type: 'post',
                        data: {
                            name: function () {
                                return $('input[name=sku]').val();
                            },
                            id: $('input[name=id]').val()
                        }
                    }
                },
                name: {
                    required: true                                     
                },
                type: {
                    required: true
                },
                quantity: {
                    required: true,
                    number: true
                },
                buy_price: {
                    required: true,
                    number: true
                },
                sell_price: {
                    required: true,
                    number: true
                },
                categorie_id: {
                    required: true
                }
            },
            messages: {
                sku: {
                    remote: 'รหัสสินค้า {0} มีใช้ไปแล้ว!',
                }
            },
            errorElement: 'span',
            errorPlacement: function (error, element) {                
                validErrorPlacement(error, element);
            },
            highlight: function (element, errorClass, validClass) {
                saved = false;
                validHighlight(element, errorClass);
            },
            unhighlight: function (element, errorClass, validClass) {
                validUnhighlight(element);
            },
            ignore: ".ignore",
            invalidHandler: function (e, validator) {
                saved = false;
                invalidHandler(e, validator);
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

    /* init upload image */
    $('body').on('change', 'input[name= "file_upload"]', function () {
        if ($('input[name ="file_upload"]').val() != '') {
            var file_data = $('input[name= "file_upload"]').prop('files')[0];
            var form_data = new FormData();
            form_data.append('file_upload', file_data);
            $.ajax({
                url: $url + 'product/uploadpic',
                dataType: 'json',
                type: 'POST',
                data: form_data,
                cache: false,
                contentType: false,
                processData: false,
                success: function (data) {
                    $('input[name=profile_picture]').val(data);

                    $('#showPicture').attr("src", $url + 'uploads/img/' + fullimage(data, '_sm'));
                }
            });
        }
    });

    $('body').on('changed.bs.select', 'select[name=department_id]', function (e, clickedIndex, isSelected, previousValue) {
        searchData.department_id = $('select[name=department_id]').val();
        table.ajax.reload();
    });

    $('body').on('keyup', 'input[name=search]', function () {
        searchData.keyword = $('input[name=search]').val();
        table.ajax.reload();
    });
});