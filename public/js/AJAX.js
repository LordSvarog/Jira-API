$(document).ready(function(){
	/**
	 * токен для AJAX
	 */
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});

	/**
	 * Отслеживание изменений ставки
	 */
	$('.btn-icon-md').off().on('click', function () {
			var name = $(this).closest(".col-xl-6").attr("id");
			var key = $(this).attr('id');
			$('#rate-sav').off().on('click', function () {

				var rate = $('#rate-new').val();
				sendAjaxForm("setrate",
					{

						PARAMS:{
							key:key,
							rate:rate,
							name:name
						}
					},

					function(data){

					if (data.data.status){
						$('#'+name).find(".flaticon2-plus").closest('a').fadeOut(1);
						$('#'+name).find(".flaticon2-settings").closest('a').fadeIn(1);
						$('#'+name).find(".fa-ruble-sign").text(rate);
						$('#kt_modal_5').click();
					}else{

						alert("Ставка не сохранилась")
					}

					});

			});



		}

	);




});


/**
 * метод Ajax формы
 * @param url
 * @param data
 * @param success
 * @param error
 */
function sendAjaxForm(url, data, success, error) {
	jQuery.ajax({
		url:     url, //url страницы (action_ajax_form.php)
		type:     "POST", //метод отправки
		dataType: "html", //формат данных
		data: data,  // Сеарилизуем объект
		success: function(response) {
			var data = response ? JSON.parse(response) : null
			success && success(data);
		},
		error: function(response) { // Данные не отправлены
			var data = response ? JSON.parse(response) : null
			error && error(data)
		}
	});
}
