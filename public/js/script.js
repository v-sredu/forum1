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
	if (modal && buttons) {
		for (let button of buttons) {
			button.addEventListener('click', () => {
				for (let style of styles_toggle_array) {
					modal.classList.toggle(style);
				}
			});
		}
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

function submitUserData(form) {
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

//кнопки лайка, добавить в избранное, подписаться
let buttons_select = document.querySelectorAll('#select');
if (buttons_select) {
	buttons_select.forEach(button => {
		button.addEventListener('click', function () {
			selectButton(button);
		});
	});
}

// формы авторизации и регистрации
let form = document.querySelector('#formUserData');
if (form) {
	form.addEventListener('submit', (e) => {
		e.preventDefault();
		submitUserData(form);
	})
}

let button_exit_account = document.querySelector('#exitAccount');
if (button_exit_account) {
	button_exit_account.addEventListener('click', () => {
		document.cookie.split(';').forEach(cookie => {
			let eqPos = cookie.indexOf('=');
			let name = eqPos > -1 ? cookie.substring(0, eqPos) : cookie;
			document.cookie = name + '=;expires=Thu, 01 Jan 1970 00:00:00 GMT';
		});
		let currentUrl = window.location.href.split('/');
		window.location.href = currentUrl[0] + '//' + currentUrl[2];
	});
}

function replyComment() {
	let buttons_reply_comment = document.querySelectorAll('.comment-reply.main');
	if (buttons_reply_comment) {
		buttons_reply_comment.forEach(button => {
			let id = button.getAttribute('data-comment');
			toggleModal(`.comment-reply[data-comment='${id}']`, `.reply[data-comment='${id}']`, ['d-none']);
		});
	}
	let buttons_delete_comment = document.querySelectorAll('.comment-delete');
	if (buttons_delete_comment) {
		buttons_delete_comment.forEach(button => {
			button.addEventListener('click', () => {
				deleteComment(button);
			})
		});
	}
	let forms_comment = document.querySelectorAll('#commentForm');
	if (forms_comment) {
		forms_comment.forEach(form => {
			form.addEventListener('submit', (e) => {
				e.preventDefault();
				if (getCookie('user[auth]')) {
					sendComment(form);
				} else {
					let modal = document.querySelector('#modalAuthWarning');
					modal.classList.toggle('invisible');
				}
			})
		})
	}
}

function sendComment(form) {
	let xhr = new XMLHttpRequest();
	let formData = new FormData(form);
	formData.append('typePost', 'sendComment');
	xhr.open('POST', '/', true);
	xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
	xhr.onreadystatechange = function () {
		if (xhr.status === 200) {
			let body_comments = document.querySelector('.comments');
			body_comments.innerHTML = xhr.responseText;
			replyComment();
		} else {
			console.error('Ошибка:', xhr.statusText);
		}
	};
	xhr.send(formData);
}

function deleteComment(button) {
	let xhr = new XMLHttpRequest();
	let formData = new FormData();
	formData.append('typePost', 'deleteComment');
	formData.append('comment_id', button.getAttribute('data-comment'));
	formData.append('post_id', button.getAttribute('data-post-id'));
	xhr.open('POST', '/', true);
	xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
	xhr.onreadystatechange = function () {
		if (xhr.status === 200) {
			let body_comments = document.querySelector('.comments');
			body_comments.innerHTML = xhr.responseText;
			replyComment();
		} else {
			console.error('Ошибка:', xhr.statusText);
		}
	};
	xhr.send(formData);
}

let button_delete_post = document.querySelector('#deletePost');
if (button_delete_post) {
	button_delete_post.addEventListener('click', () => {
		let xhr = new XMLHttpRequest();
		let formData = new FormData();
		formData.append('typePost', 'deletePost');
		formData.append('post_id', button_delete_post.getAttribute('data-post-id'));
		xhr.open('POST', '/', true);
		xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
		xhr.onreadystatechange = function () {
			if (xhr.status === 200) {
				let currentUrl = window.location.href.split('/');
				window.location.href = currentUrl[0] + '//' + currentUrl[2];
			} else {
				console.error('Ошибка:', xhr.statusText);
			}
		};
		xhr.send(formData);
	});
}

replyComment();
