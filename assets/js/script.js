function validHighlight(element) {
    $(element).parents('.form-group').addClass('has-error').removeClass('has-success');
}

function validUnhighlight(element) {    
    $(element).parents('.form-group').addClass('has-success').removeClass('has-error');
}

function invalidHandler(e, validator) {
    if(validator.errorList.length)
    $('#tabs a[href="#' + jQuery(validator.errorList[0].element).closest(".tab-pane").attr('id') + '"]').tab('show');
}

function validErrorPlacement(error, element) {            
    error.addClass('error-block');    
    if (element.prop('type') === 'checkbox') {
        error.insertAfter(element.parent('label'));
    } else if(element.prop('type') === 'radio') {
        error.insertAfter(element.closest('div'));
    } else if (element.parent('.input-group').length) {
        error.insertAfter(element.parent()); /* radio checkbox? */
    } else if (element.hasClass('select2') || element.hasClass('select2-not-search')) {
        error.insertAfter(element.next('span')); /* select2 */
    } else if (element.next('.bootstrap-filestyle').length) {
        error.insertAfter(element.next('.bootstrap-filestyle'));
    } else if(element.parent('.bootstrap-select').length) {
        error.insertAfter(element.parent('div'));
    } else {
        error.insertAfter(element);
    }
}

function showBox(title, type, text = '') {
    swal({
        position: 'top-right',
        type: type,
        title: title,
        html: text,
        showConfirmButton: false,
        timer: 1500
    });
}

function deleteConf(url, name, callback = '') {
    swal({
        title: 'ยืนยันการลบข้อมูล?',
        text: name,
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#5c6bc0',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes'
    }).then((result) => {
        if (result.value) {
            axios.get(url).then((response) => {
                callback();
            });
        }
    }).catch(swal.noop);
}

function saveForm(url, data, callback) {
    axios.post(url, data)
        .then(function (response) {
            if (response.status === 200) {
                showBox('บันทึกข้อมูลสำเร็จ', 'success');
                callback();
            } else {
                showBox('Status not 200', 'error');
            }
        })
        .catch(function (error) {
            console.log(error);
            showBox('เกิดข้อผิดพลาด', 'error');
        });

    $('.modal-form').modal('hide');
}

function fullimage(val, prefix) {
    var str = val.split('.');
    return str[0] + prefix + '.' + str[1];
};

/* valid alpha */
jQuery.validator.addMethod('alphanumeric', function (value, element) {
    return this.optional(element) || /^[\w.]+$/i.test(value);
}, 'ระบุเฉพาะตัวอักษร a-z, 0-9 และ _ เท่านั้น');

$(function () {
    // Modal Section
    $('.modal-form').on('hidden.bs.modal', function (e) {
        $('.modal-content').empty();
        $(this).removeData('bs.modal');
    });

    var modalShow = function (e, link, modalName) {
        e.preventDefault();
        $.get(link, function (data) {
            $('#' + modalName).find('.modal-content').html(data);
            $('#' + modalName).modal('show');
        });
    }

    $('body').on('click', '.btn-modal', function (e) {
        link = $(this).data('href');
        modalName = $(this).data('modal-name');
        modalShow(e, link, modalName);
    });

    // side menu
    var url = window.location;
    var suburl = url.href.replace(/\/(creat(\S+)|edit(\S+)|me(\S+))/g, '');
    $('ul.side-menu a').filter(function () {
        return this.href == suburl;
    }).parent().addClass('active');

    // plugin init++++++++++++++++++++++++++++++++++++++++++++
    $('.input-group.date').datepicker({
        autoclose: true,
        format: 'dd/mm/yyyy',
        todayHighlight: true
    });
    if($(":file").length) $(":file").filestyle();
    if($('.select2').length) $('.select2').select2();
    if($('.selectpicker').length) $('.selectpicker').selectpicker();
    if($('.date-range').length) $('.date-range').daterangepicker();
    $('.alert-message').fadeIn(1000).delay(2000).fadeOut(2000);
    
    $('.selectpicker').on('loaded.bs.select	', function(e){
        if($('.bootstrap-select').length){
            $('.bootstrap-select').find('.bs-caret').remove();
            $('.bootstrap-select').find('.dropdown-toggle').append('<span class="bs-caret"><span class="caret"></span></span>');
        }
    });

    // plugin init on modal show+++++++++++++++++++++++++++++++++++++++
    $('.modal-form').on('shown.bs.modal', function (e) {
        if($(":file").length) $(":file").filestyle();
        if($('.select2').length) $('.select2').select2();
        if($('.selectpicker').length) $('.selectpicker').selectpicker();
        
        $('.input-group.date').datepicker({
            autoclose: true,
            format: 'dd/mm/yyyy',
            todayHighlight: true
        });

        $('.selectpicker').on('loaded.bs.select	', function(e){
            if($('.bootstrap-select').length){
                $('.bootstrap-select').find('.bs-caret').remove();
                $('.bootstrap-select').find('.dropdown-toggle').append('<span class="bs-caret"><span class="caret"></span></span>');
            }
        });
    });
});