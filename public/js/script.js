// const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
// const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));

function selectButton(button) {
	let url = '/';
	let xhr = new XMLHttpRequest();
	let dataAttributes = button.dataset;
	let data = {};
	let  is_select = button.hasAttribute('data-is-select');
	for (let key in dataAttributes) {
		data[key] = dataAttributes[key];
	}
	let type_post = data['typePost'];
	data['isSelect'] = !is_select;
	data = JSON.stringify(data);
	xhr.open('POST', url, true);
	xhr.setRequestHeader('Content-Type', 'application/json');
	xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
	xhr.onreadystatechange = function () {
		if (xhr.status === 200) {
			if (type_post === 'like_select') {
				let span = button.querySelector('span');
				span.innerHTML = xhr.responseText;
			}
			let svg = button.querySelector('svg');
			if (is_select) {
				button.removeAttribute('data-is-select');
				svg.classList.remove('select')
			} else  {
				button.setAttribute('data-is-select', '');
				svg.classList.add('select');
			}
		} else {
			console.error('Ошибка:', xhr.statusText);
		}
	};
	xhr.send(data);
}

//кнопки лайка и добавить в избранное
let buttons_select = document.querySelectorAll("button.like, button.favorite");

buttons_select.forEach(button => {
	button.addEventListener('click', function () {
		selectButton(button);
	});
});
