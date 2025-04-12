/*const formularios_ajax=document.querySelectorAll(".FormularioAjax");

function enviar_formulario_ajax(e){
    e.preventDefault();

    let enviar=confirm("Quieres enviar el formulario");

    
    if(enviar==true){
        
        let data= new FormData(this);
        let method=this.getAttribute("method");
        let action=this.getAttribute("action");

        let encabezados= new Headers();

        let config={
            method: method,
            headers: encabezados,
            mode: 'cors',
            cache: 'no-cache',
            body: data
        };

        fetch(action,config)
        .then(respuesta => respuesta.text())
        .then(respuesta =>{ 
            let contenedor=document.querySelector(".form-rest");
            contenedor.innerHTML = respuesta;
        });
    }

}

formularios_ajax.forEach(formularios => {
    formularios.addEventListener("submit",enviar_formulario_ajax);
}); 

*/
// Función para mostrar la alerta de confirmación
function confirmSubmit(e) {
    e.preventDefault();
    const confirmRequired = this.getAttribute('data-confirm') === 'true';
    if (confirmRequired) {
        let elementos = document.getElementsByClassName('modal-content'); 
        document.getElementById('myModal').style.display = "block";
        for (let i = 0; i < elementos.length; i++) { 
            elementos[i].classList.add('animate-bounce');
        }
        return false; // Evitar el envío del formulario hasta la confirmación
    } else {
        submitForm(this);
    }
}

// Función para cerrar el modal
function closeModal() {
    document.getElementById('myModal').style.display = "none";
}

// Función para enviar el formulario con AJAX
function submitForm(form = null) {
    closeModal();
    if (!form) form = document.querySelector(".FormularioAjax");

    let data = new FormData(form);
    let method = form.getAttribute("method");
    let action = form.getAttribute("action");

    let encabezados = new Headers();

    let config = {
        method: method,
        headers: encabezados,
        mode: 'cors',
        cache: 'no-cache',
        body: data
    };

    
    fetch(action, config)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            
            const contentType = response.headers.get("content-type");
            if (contentType && contentType.indexOf("application/json") !== -1) {
                return response.json(); // Maneja la respuesta JSON
            } else {
                return response.text(); // Maneja la respuesta HTML
            }
        })
        .then(data => {
            if (typeof data === 'object' && data.redirect) {
                window.location.href = data.redirect;
            } else {
                document.getElementById('resultado').innerHTML = data;
                let elementos = document.getElementsByClassName('notification'); 
                for (let i = 0; i < elementos.length; i++) { 
                    elementos[i].classList.add('animate-bounce');
                }
                setTimeout(() => { 
                    let newElement = document.getElementById('newElement'); 
                    if (newElement) { 
                        newElement.scrollIntoView({ behavior: 'smooth' }); 
                    }
                }, 100);
            }
        })
        .catch(error => console.error('Error:', error));
    
    return true; // Enviar el formulario
}

// Asociar la función de confirmación al evento submit de los formularios
const formularios_ajax = document.querySelectorAll(".FormularioAjax");
formularios_ajax.forEach(formulario => {
    formulario.addEventListener("submit", confirmSubmit);
});

// Cerrar el modal al hacer clic fuera de él
window.onclick = function(event) {
    var modal = document.getElementById('myModal');
    if (event.target == modal) {
        modal.style.display = "none";
    }
}

        