let opCounter = 0;

function agregarOperador() {
    opCounter++;
    const currentId = opCounter;
    const headerRow = document.getElementById('headerRow');
    const th = document.createElement('th');
    th.className = 'text-center op-col';
    th.setAttribute('data-op-id', currentId);
    th.innerHTML = `<div class="op-header-wrapper">
                <button type="button" class="btn btn-danger btn-sm btn-delete-op shadow-sm" onclick="borrarOperador(${currentId})">×</button>
                <input type="text" name="operadores[${currentId}][nombre]" class="op-name-input" value="OPERADOR ${currentId + 1}">
                <small class="text-muted d-block mt-1" style="font-size: 0.6rem;">Nombre Persona</small>
            </div>`;
    headerRow.appendChild(th);

    const rows = document.querySelectorAll('#tablaCumplimiento tbody tr');
    rows.forEach((row) => {
        const itemIdx = row.getAttribute('data-item-idx');
        const td = document.createElement('td');
        td.className = 'text-center op-col';
        td.setAttribute('data-op-id', currentId);
        td.innerHTML = `<select name="operadores[${currentId}][items][${itemIdx}]" class="form-select form-select-sm status-select status-1" onchange="actualizarColor(this)">
                    <option value="1" selected>✔ SI</option>
                    <option value="0">✖ NO</option>
                </select>`;
        row.appendChild(td);
    });
}

function borrarOperador(id) {
    if(confirm('¿Eliminar operador?')) {
        document.querySelectorAll(`[data-op-id="${id}"]`).forEach(el => el.remove());
    }
}

function actualizarColor(select) {
    select.className = `form-select form-select-sm status-select status-${select.value}`;
}

function previewImage(event) {
    const reader = new FileReader();
    reader.onload = function(){
        const output = document.getElementById('preview-firma');
        output.src = reader.result;
        output.style.display = 'block';
    };
    reader.readAsDataURL(event.target.files[0]);
}