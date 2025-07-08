// Validación de formularios mejorada
document.addEventListener('DOMContentLoaded', function() {
    // Validación básica de formularios
    const forms = document.querySelectorAll('form');
    
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            let isValid = true;
            const inputs = form.querySelectorAll('input[required], select[required], textarea[required]');
            
            inputs.forEach(input => {
                if (!input.value.trim()) {
                    isValid = false;
                    input.style.borderColor = 'red';
                    
                    // Mostrar mensaje de error
                    const errorMsg = document.createElement('span');
                    errorMsg.className = 'error-msg';
                    errorMsg.textContent = 'Este campo es requerido';
                    errorMsg.style.color = 'red';
                    errorMsg.style.fontSize = '0.8em';
                    
                    if (!input.nextElementSibling || !input.nextElementSibling.classList.contains('error-msg')) {
                        input.parentNode.insertBefore(errorMsg, input.nextSibling);
                    }
                } else {
                    input.style.borderColor = '';
                    const errorMsg = input.nextElementSibling;
                    if (errorMsg && errorMsg.classList.contains('error-msg')) {
                        errorMsg.remove();
                    }
                }
            });
            
            if (!isValid) {
                e.preventDefault();
                alert('Por favor complete todos los campos requeridos');
            }
        });
    });
    
    // Validación de números en campos de notas
    const notaInputs = document.querySelectorAll('input[type="number"][name="teoria"], input[type="number"][name="practica"]');
    notaInputs.forEach(input => {
        input.addEventListener('change', function() {
            const value = parseFloat(this.value);
            if (isNaN(value) ){
                this.value = '';
            } else if (value < 0) {
                this.value = 0;
            } else if (value > 10) {
                this.value = 10;
            }
        });
    });
    
    // Eliminar mensajes después de 5 segundos
    const messages = document.querySelectorAll('.error, .success');
    if (messages.length > 0) {
        setTimeout(() => {
            messages.forEach(msg => {
                msg.style.display = 'none';
            });
        }, 5000);
    }
});