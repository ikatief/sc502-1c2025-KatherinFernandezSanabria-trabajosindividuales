document.addEventListener("DOMContentLoaded", function() {
    const boton = document.getElementById("botonCambiar");
    const parrafo = document.getElementById("parrafo");

    const textoOriginal = parrafo.innerHTML;
    const textoNuevo = "BTS está integrado por RM, Jin, Suga, J-Hope, Jimin, V y Jungkook. BTS ha conquistado corazones en todo el mundo con su música y su mensaje de autoaceptación y empoderamiento juvenil. Tienen más de 10 álbumes con millones de récords y reproducciones.";

    boton.addEventListener("click", function() {
        if (parrafo.innerHTML === textoOriginal) {
            parrafo.innerHTML = textoNuevo;
            boton.textContent = "Leer menos";  
        } else {
            parrafo.innerHTML = textoOriginal;
            boton.textContent = "Leer más";  
        }
    });
});
