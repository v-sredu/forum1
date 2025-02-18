function getCookie(name) {
	const value = `; ${document.cookie}`;
	const parts = value.split(`; ${name}=`);
	if (parts.length === 2) {
		return parts.pop().split(';').shift();
	}
	return false;
}

function toggleModal(button_link, modal_link, styles_toggle_array) {
	let buttons = document.querySelectorAll(button_link);
	let modal = document.querySelector(modal_link);
	for (let button of buttons) {
		button.addEventListener('click', () => {
			for (let style of styles_toggle_array) {
				modal.classList.toggle(style);
			}
		});
	}
}

function selectButton(button) {
	if (getCookie('user[auth]')) {
		let xhr = new XMLHttpRequest();
		let formData = new FormData();
		let data = button.dataset;
		let type_post = data['typePost'];
		let select = button.classList.contains('select');
		Object.entries(data).forEach(([key, value]) => {
			formData.append(key, value);
		});
		formData.append('userId', getCookie('user[id]'));
		xhr.open('POST', '/', true);
		xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
		xhr.onreadystatechange = function () {
			if (xhr.status === 200) {
				if (type_post === 'post_like') {
					let span = button.querySelector('span');
					span.innerHTML = xhr.responseText;
				} else if (type_post === 'subscribe') {
					button.innerHTML = xhr.responseText;
				}
				if (select) {
					button.classList.remove('select');
				} else {
					button.classList.add('select');
				}
			}
		};
		xhr.send(formData);
	} else {
		let modal = document.querySelector('#modalAuthWarning');
		modal.classList.toggle('invisible');
	}
}

function registration(form) {
	let xhr = new XMLHttpRequest();
	let formData = new FormData(form);
	let file = form.querySelector("[name='file']");
	if (file) {
		formData.append('file', file.files['0']);
	}
	xhr.open('POST', '/', true);
	xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
	xhr.onreadystatechange = function () {
		if (xhr.status === 200) {
			if (xhr.responseText === 'abort') {
				let currentUrl = window.location.href.split('/');
				window.location.href = currentUrl[0] + '//' + currentUrl[2];
			}
			let alert = document.querySelector("[role='alert']");
			alert.innerHTML = 'Внимание! ' + xhr.responseText;
			alert.classList.remove('d-none');
		} else {
			console.error('Ошибка:', xhr.statusText);
		}
	};
	xhr.send(formData);
}

toggleModal('#buttonNav', '#modalNav', ['show']);
toggleModal('#buttonAuthWarning', '#modalAuthWarning', ['invisible']);
toggleModal('#buttonSort', '#modalSort', ['show'])

//кнопки лайка и добавить в избранное
let buttons_select = document.querySelectorAll('#select');

buttons_select.forEach(button => {
	button.addEventListener('click', function () {
		selectButton(button);
	});
});

let form = document.querySelector('#form');

form.addEventListener('submit', (e) => {
	e.preventDefault();
	registration(form);
})
