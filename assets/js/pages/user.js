$(function () {
    var searchData = {};
    var table = $('#userTable').DataTable({
        language: {
            url: $url + 'assets/js/datatables-th.lang'
        },
        serverSide: true,
        processing: true,
        lengthChange: false,
        ajax: {
            url: $url + 'user/datatables_user',
            data: function (d) {
                return $.extend(d, searchData);
            }
        },
        columns: [{
                data: 'username'
            },
            {
                data: 'name'
            },
            {
                data: 'email'
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
                orderable: false,
                render: function (data, type, row) {
                    return data == 1 ? '<span class="badge badge-primary badge-pill m-r-5 m-b-5">Active</span>' : '<span class="badge badge-danger badge-pill m-b-5">Inactive</span>';
                },
            },
            {
                targets: 4,
                orderable: false,
                render: function (data, type, row) {
                    return '<div class="btn-group m-b-10">' +
                        '<button class="btn btn-outline-warning btn-sm btn-modal" data-href="' + $url + 'user/edit/' + data + '" data-modal-name="largeModal"><i class="ti-pencil-alt"></i> แก้ไข</button>' +
                        '<button class="btn btn-outline-danger btn-sm btn-delete" data-name="' + row.username + '" data-href="' + $url + 'user/delete/' + data + '"><i class="ti-trash"></i> ลบข้อมูล</button>' +
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
            $('#userForm').submit();
        });

        var saveCallback = function () {
            table.ajax.reload();
        };

        $('#userForm').validate({
            submitHandler: function () {
                saveForm($url + 'user/save', $('#userForm').serializeJSON(), saveCallback);
                return false;
            },
            rules: {
                username: {
                    required: true,
                    remote: {
                        url: $url + 'user/username_check',
                        type: 'post',
                        data: {
                            name: function () {
                                return $('input[name=username]').val();
                            },
                            id: $('input[name=id]').val()
                        }
                    }
                },
                email: {
                    required: true,
                    email: true,
                    remote: {
                        url: $url + 'user/email_check',
                        type: 'post',
                        data: {
                            name: function () {
                                return $('input[name=email]').val();
                            },
                            id: $('input[name=id]').val()
                        }
                    }
                },
                password: {
                    required: function () {
                        return ($('input[name=id]').val() == '0') ? true : false;
                    },
                    alphanumeric: true,
                    minlength: 6,
                    maxlength: 16
                },
                password_confirm: {
                    equalTo: $('input[name=password]')
                },
                name: {
                    required: true
                }
            },
            messages: {
                username: {
                    remote: 'username {0} มีใช้ไปแล้ว!',
                },
                email: {
                    remote: 'อีเมล์ {0} มีใช้ไปแล้ว!',
                }
            },
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
});