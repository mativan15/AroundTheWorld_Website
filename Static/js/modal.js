function mostrarModalContacto() {
	var modal = document.getElementById('modal-contacto');
	modal.style.display = 'block';
}

function ocultarModalContacto() {
	var modal = document.getElementById('modal-contacto');
	modal.style.display = 'none';
}

document.getElementById('enlace-contacto').addEventListener('click', function(event) {
	event.preventDefault(); 
	mostrarModalContacto();
});

document.getElementById('cerrar-modal').addEventListener('click', function() {
	ocultarModalContacto();
});

window.addEventListener('click', function(event) {
	var modal = document.getElementById('modal-contacto');
	if (event.target == modal) {
		ocultarModalContacto();
	}
});
