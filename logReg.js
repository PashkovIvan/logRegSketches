$(() => {

	const DEFAULT_MESSAGES = {
		"regForm": {
			"SUCCESS": "Успешная регистрация",
			"ERROR": "Ошибка регистрации"
		},
		"logForm": {
			"SUCCESS": "Успешная авторизация",
			"ERROR": "Ошибка авторизации"
		}
	};

	const formSubmitHandler = function (event) {
		event.preventDefault();
		const $form = $(event.target);

		const $submit = $form.find('[type="submit"');
		const $formLoader = $('#formLoader');
		const $errorAlert = $("#errorAlert");

		$formLoader.show();
		$submit.hide();
		$errorAlert.hide();

		const formData = $form.serializeArray();
		let formattedData = {};
		formData.forEach((item) => {
			formattedData[item.name] = item.value;
		})

		$.ajax({
			url: $form.attr('action'),
			type: 'POST',
			data: formattedData,
			beforeSend: (jqXHR) => {
				jqXHR.setRequestHeader('X-CSRFToken', $('meta[name="csrf-token"]').attr('content'));
			},
			success: function (result) {
				if (result.success) {
					const modal = new bootstrap.Modal('#exampleModal', {});
					let message = result.messages && result.messages.length > 0
						? result.messages.join("<br>")
						: DEFAULT_MESSAGES[$form.attr('id')]["SUCCESS"];
					$(modal._element).find('div.modal-body').html(message);

					const closeModalHandler = function () {
						window.location.href = "/profile.php";
					};
					$(modal._element).find('.modal-footer button').on('click', closeModalHandler);
					$(modal._element).find('.btn-close').on('click', closeModalHandler);
					$(modal._element).on('keydown', (event) => {
						event.preventDefault();
						if(event.key === 'Escape') {
							closeModalHandler();
						}
					});

					modal.show();
				} else {
					$errorAlert.show();
					let message = result.messages && result.messages.length > 0
						? result.messages.join("<br>")
						: DEFAULT_MESSAGES[$form.attr('id')]["ERROR"];
					$errorAlert.html(message)
				}
			},
			complete: () => {
				$formLoader.hide();
				$submit.show();
			}
		})
	};

	$('#regForm').on('submit', formSubmitHandler);
	$('#logForm').on('submit', formSubmitHandler);

	let formIdList = [];
	$('#formToggleList button.nav-link').each((index, item) => {
		let formId = $(item).data("formId");
		formIdList.push(`#${formId}`);
		$(item).on('click', function (event) {
			let $button = $(event.target);
			if (!$button.hasClass("active")) {
				let formId = $button.data("formId");
				$('#formToggleList').find('button').each((i, item) => {
					$(item).removeClass('active');
				});
				$button.toggleClass("active");

				formIdList.forEach((formId) => {
					$(formId).hide();
				})
				$(`#${formId}`).show();
			}
		})
	})
})