$(function(){
    var searchData={};    
    var table = $('#contactTable').DataTable({
        language: {
            url: $url+'assets/js/datatables-th.lang'
        },
        serverSide: true,
        processing: true,
        lengthChange: false,
        ajax: {
        url: $url + 'contact/datatables',
        data: function(d){
          return $.extend(d, searchData);
        }
      },
      columns: [
          {data: 'name'},
          {data: 'address'},          
          {data: 'status'},
          {data: 'id'}
      ],
      columnDefs: [
        {
            targets: 0,
            orderable: false,
            render: function (data, type, row) {
                var code = '<br/><span class="text-info small-text"><strong>รหัส</strong> ' + row.code + '</span>';
                var tax_no = (row.tax_no != '') ? '<br/><span class="text-info small-text"><strong>หมายเลขภาษี</strong> ' + row.tax_no + '</span>' : '';
                var branch = (row.branch_name != '') ? '<br/><span class="text-black-50 small-text"><strong>สาขา</strong> ' + row.branch_no + ' ' + row.branch_name + '</span>' : '';
                return data + code + tax_no + branch;
            },
        },
        {
            targets: 1,
            orderable: false,
            render: function (data, type, row) {
                var contact_name = (row.contact_name != '') ? '<span class="text-black-50 small-text"><strong>ผู้ติดต่อ</strong> ' + row.contact_name + '</span>' : '';
                var address = (row.address != '') ? '<br/><span class="text-black-50 small-text"><strong>ที่อยู่</strong> ' + row.address + '</span>' : '';
                var email = (row.email != '') ? '<br/><span class="text-black-50 small-text"><strong>อีเมล์</strong> ' + row.email + '</span>' : '';
                var tel = (row.tel != '') ? '<br/><span class="text-black-50 small-text"><strong>โทร</strong> ' + row.tel + '</span>' : '';
                return contact_name + address + email + tel;
            },
        },
        {
            targets: 2,
            orderable: false,
            render: function (data, type, row) {
                return data==1 ? '<span class="badge badge-primary badge-pill m-r-5 m-b-5">Active</span>' : '<span class="badge badge-danger badge-pill m-b-5">Inactive</span>';
            },
        },
        {
            targets: 3,
            orderable: false,
            render: function (data, type, row) {
                return '<div class="btn-group m-b-10">'+
                '<button class="btn btn-outline-warning btn-sm btn-modal" data-href="'+$url+'contact/edit/'+data+'" data-modal-name="largeModal"><i class="ti-pencil-alt"></i> แก้ไข</button>'+
                '<button class="btn btn-outline-danger btn-sm btn-delete" data-name="' + row.name + '" data-href="' + $url + 'contact/delete/' + data + '"><i class="ti-trash"></i> ลบข้อมูล</button>' +
            '</div>';
            },
        },
    ]
    });
    
    $('.modal-form').on('shown.bs.modal', function (e) {
        var saved = false;
        
        $('.btn-save').on('click', function(){            
            if(saved) return;
            saved = true;
            $('#contactForm').submit();
        });
        
        var saveCallback = function()
        {            
            table.ajax.reload();
        };

		$('#contactForm').validate({
			submitHandler: function () {                                
				saveForm($url + 'contact/save', $('#contactForm').serializeJSON(), saveCallback);
				return false;
			},
			rules: {
				code: {
                    required: true,
                    alphanumeric: true,
                    remote: {
                        url: $url + 'contact/code_check',
                        type: 'post',
                        data: {
                            name: function () {
                                return $('input[name=code]').val();
                            },
                            id: $('input[name=id]').val()
                        }
                    }
                },
                name: {
					required: true,
                },
                credit_day: {
                    required: true,
                    number: true
				}
			},
			messages: {
                code: {
                    remote: 'รหัส {0} มีใช้ไปแล้ว!',
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
    
    $('body').on('click', '.btn-delete', function(e){        
        e.preventDefault();
        var delCallback = function(){
            table.ajax.reload();
        };
        
        var url = $(this).attr('data-href');
        var name = $(this).attr('data-name');
        deleteConf(url, name, delCallback);
    });
});