document.addEventListener("DOMContentLoaded", function() {
    const botonVerificar = document.getElementById("verificacion");
    const inputEdad = document.getElementById("edad");
    const resultado = document.getElementById("resultado de edad");

    botonVerificar.addEventListener("click", function() {
        const edad = parseInt(inputEdad.value);

        if (isNaN(edad) || edad < 0) {
            resultado.innerHTML = "Debes ingresar una edad valida";
            resultado.style.color = "red";
        } else if (edad >= 18) {
            resultado.innerHTML = "Eres mayor de edad, mayor de 18";
            resultado.style.color = "green";
        } else {
            resultado.innerHTML = "Eres menor de edad, menor de 18";
            resultado.style.color = "red";
        }
    });
});
