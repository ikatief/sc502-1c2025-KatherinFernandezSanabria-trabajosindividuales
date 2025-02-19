document.getElementById('formularioSalario').addEventListener('submit', function(evento) {
    evento.preventDefault();
    
    const salariobruto = parseFloat(document.getElementById('salariobruto').value);
    
    if (isNaN(salariobruto) || salariobruto <= 0) {
        alert('Ingresa un salario bruto valido');
        return;
    }

    const deduccionesCargasSociales = 0.1067; 
    const cargasSociales = Math.round(salariobruto * deduccionesCargasSociales);

    let impuestoRenta = 0;
    
    if (salariobruto > 4745000) {
        impuestoRenta += (salariobruto - 4745000) * 0.25;
        impuestoRenta += (4745000 - 2373000) * 0.20;
        impuestoRenta += (2373000 - 1352000) * 0.15;
        impuestoRenta += (1352000 - 922000) * 0.10;
    } else if (salariobruto > 2373000) {
        impuestoRenta += (salariobruto - 2373000) * 0.20;
        impuestoRenta += (2373000 - 1352000) * 0.15;
        impuestoRenta += (1352000 - 922000) * 0.10;
    } else if (salariobruto > 1352000) {
        impuestoRenta += (salariobruto - 1352000) * 0.15;
        impuestoRenta += (1352000 - 922000) * 0.10;
    } else if (salariobruto > 922000) {
        impuestoRenta += (salariobruto - 922000) * 0.10;
    }

    const salarioNeto = salariobruto - cargasSociales - impuestoRenta;

    document.getElementById('cargasSociales').textContent = cargasSociales.toFixed(2);
    document.getElementById('impuestoRenta').textContent = impuestoRenta.toFixed(2);
    document.getElementById('salarioNeto').textContent = salarioNeto.toFixed(2);
    document.getElementById('results').classList.remove('hidden');
});

