$(function(){
    var searchData={};    
    var table = $('#categorieTable').DataTable({
        language: {
            url: $url+'assets/js/datatables-th.lang'
        },
        serverSide: true,
        processing: true,
        lengthChange: false,
        ajax: {
        url: $url + 'categorie/datatables',
        data: function(d){
          return $.extend(d, searchData);
        }
      },
      columns: [
          {data: 'name'},
          {data: 'detail'},          
          {data: 'status'},
          {data: 'id'}
      ],
      columnDefs: [
        {
            targets: 1,
            orderable: false,
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
                '<button class="btn btn-outline-warning btn-sm btn-modal" data-href="'+$url+'categorie/edit/'+data+'" data-modal-name="normalModal"><i class="ti-pencil-alt"></i> แก้ไข</button>'+
                '<button class="btn btn-outline-danger btn-sm btn-delete" data-name="' + row.name + '" data-href="' + $url + 'categorie/delete/' + data + '"><i class="ti-trash"></i> ลบข้อมูล</button>' +
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
            $('#categorieForm').submit();
        });
        
        var saveCallback = function()
        {            
            table.ajax.reload();
        };

		$('#categorieForm').validate({
			submitHandler: function () {                                
				saveForm($url + 'categorie/save', $('#categorieForm').serializeJSON(), saveCallback);
				return false;
			},
			rules: {
				name: {
					required: true,
				}
			},
			messages: {
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