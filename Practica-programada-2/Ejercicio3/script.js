document.addEventListener("DOMContentLoaded", function() {
    const boton = document.getElementById("botonCambiar");
    const parrafo = document.getElementById("parrafo");

    boton.addEventListener("click", function() {
        parrafo.innerHTML = "BTS está integrado por RM, Jin, Suga, J-Hope, Jimin, V y Jungkook, BTS ha conquistado corazones en todo el mundo con su música y su mensaje de autoaceptación y empoderamiento juvenil. Tienen más de 10 álbumes con millones de records y reproducciones.";
    });
});
