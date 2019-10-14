(function ($) {
    //Отображение кнопки в зависимости от того, сохранен ли сотрудник в базу
    $('.table tbody').find('tr').each(function (key, el) {
        const i = $(el).children('td.developer-action')
                    .find('i');

        if ($(el).find('td.developer-rate').text() === ' р/ч') {
            i.addClass('flaticon-plus');
            i.parent().addClass('btn-success');
        } else {
            i.addClass("flaticon-cogwheel");
            i.parent().addClass('btn-info');
        }
    });
    //Работа с нажатием на кнопку действия и при существующем сотруднике в базе подгрузка данных
    $('table').on('click', 'button.btn-icon', function () {
        const label = $('#modalLabel'),
            params = $(this).parent().siblings();
        $('#name').val(params.find('a.kt-user-card-v2__name').text());
        $('#dev-code').val(params.find('b').text());
        if ($(this).children('i').attr('class') === 'flaticon-plus') {
            label.text('Сохранение данных нового сотрудника');
            $('#dev-id').val('');
            $('#title option').prop('selected', false);
            $('#rate').val('');
            $('#hours').val('');
        } else {
            label.text('Изменение данных сотрудника');

            const titleId = params.find('span.kt-user-card-v2__desc').data('id');

            $('#title option[value=' + titleId + ']').prop('selected', true);
            $('#rate').val($(this).parent().siblings('.developer-rate').text());
            $('#hours').val($(this).parent().siblings('.developer-hours').text());
            $('#dev-id').val(params.find('a.kt-user-card-v2__name').data('id'));
        }
    });
    //Выбор должности
    $('#title').change(function(){
        if ($(this).find('option:selected').val() === '')
            return;

        $.ajax({
            url: '/getrate',
            type: 'POST',
            dataType: 'json',
            data: {
                id: $(this).val(),
            }
        }).done(function (response) {
            // console.log(response, response.data.title);
            $('#rate').val(response.data.rate + ' р/ч');
            $('#hours').val(response.data.hours + ' ч/мес.');
        });
    });
    //Сохранение данных
    $('.modal-footer').on('click', '.save-data', function () {
        const form = $('#developer-settings');
        form.validate({
            rules: {
                name: {
                    required: true
                },
                title: {
                    required: true,
                },
                rate: {
                    required: true
                },
                hours: {
                    required: true
                },
            }
        });

        if (!form.valid()) {
            return;
        }

        form.ajaxSubmit({
            url: '/saveparams',
            type: 'POST',
            success: function(response, status, xhr){
                // console.log(response.data);
                const tr = $('.table tbody').find('tr#' + $('#dev-code').val() + ''),
                    a = tr.find('a.kt-user-card-v2__name');
                if (response.data) {
                    a.attr('data-id', response.data);
                    a.after('<span class="kt-user-card-v2__desc" data-id="' + $('#title').val() + '">' + $('#title option:selected').text() + '</span>');
                } else {
                    tr.find('span.kt-user-card-v2__desc').data('id', $('#title').val());
                    tr.find('span.kt-user-card-v2__desc').text($('#title option:selected').text());
                }
                a.text($('#name').val());
                tr.children('td.developer-rate').text($('#rate').val());
                tr.children('td.developer-hours').text($('#hours').val());
                tr.children('td.developer-action').find('i').removeClass('flaticon-plus').addClass("flaticon-cogwheel").parent().removeClass('btn-success').addClass('btn-info');
                $('#kt_modal_6').modal('hide');
            },
            error: function(response, status, xhr){
                alert('Сохранение не произошло, попробуйте снова');
            }
        });
    })
})(jQuery)