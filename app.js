(() => {
    const app = document.getElementById("app");
    const view = document.body.dataset.view;
    const storageKey = "proyectophp.archivos.registros";

    function element(tag, text, className) {
        const node = document.createElement(tag);
        if (text !== undefined) node.textContent = text;
        if (className) node.className = className;
        return node;
    }

    function message(text, isError = false) {
        const node = element("p", text, isError ? "app-error" : "app-message");
        node.setAttribute("role", "status");
        app.append(node);
    }

    function getRecords() {
        try {
            const records = JSON.parse(localStorage.getItem(storageKey) || "[]");
            if (!Array.isArray(records)) throw new Error("Formato de datos incorrecto.");
            return records;
        } catch (error) {
            message("No se pudieron leer los registros guardados en este navegador.", true);
            return null;
        }
    }

    function saveRecords(records) {
        try {
            localStorage.setItem(storageKey, JSON.stringify(records));
            return true;
        } catch (error) {
            message("No se pudieron guardar los datos. Comprueba el espacio disponible del navegador.", true);
            return false;
        }
    }

    function makeForm(fields, submitLabel, onSubmit) {
        const form = element("form");
        fields.forEach(({ name, label, type = "text", value = "", required = true, min, max }) => {
            const wrapper = element("label", label);
            const input = document.createElement("input");
            input.name = name;
            input.type = type;
            input.value = value;
            input.required = required;
            if (min !== undefined) input.min = min;
            if (max !== undefined) input.max = max;
            wrapper.append(input);
            form.append(wrapper);
        });
        const submit = element("button", submitLabel);
        submit.type = "submit";
        form.append(submit);
        form.addEventListener("submit", (event) => {
            event.preventDefault();
            onSubmit(new FormData(form));
        });
        return form;
    }

    function renderTable(records) {
        const columns = ["id", "fecha", "nombre", "email", "edad", "dni", "telefono"];
        const labels = ["ID", "Fecha", "Nombre", "Correo", "Edad", "DNI", "Teléfono"];
        const table = element("table");
        const head = element("tr");
        labels.forEach((label) => head.append(element("th", label)));
        const thead = element("thead");
        thead.append(head);
        table.append(thead);
        const body = element("tbody");
        records.forEach((record) => {
            const row = element("tr");
            columns.forEach((column) => row.append(element("td", String(record[column] ?? ""))));
            body.append(row);
        });
        table.append(body);
        app.append(table);
        if (records.length === 0) message("Todavía no hay registros.");
    }

    function render() {
        if (!app) return;
        const records = getRecords();
        if (!records) return;

        if (view === "create") {
            app.append(element("h2", "Crear registro"));
            app.append(makeForm([
                { name: "nombre", label: "Nombre", max: "100" },
                { name: "email", label: "Correo", type: "email", max: "250" },
                { name: "edad", label: "Edad", type: "number", min: "1" },
                { name: "dni", label: "DNI", type: "number", min: "1" },
                { name: "telefono", label: "Teléfono", type: "tel", max: "30" }
            ], "Guardar", (data) => {
                const nextId = records.reduce((max, record) => Math.max(max, Number(record.id) || 0), 0) + 1;
                records.push({
                    id: nextId,
                    fecha: new Date().toLocaleString(),
                    nombre: String(data.get("nombre")).trim(),
                    email: String(data.get("email")).trim(),
                    edad: String(data.get("edad")),
                    dni: String(data.get("dni")),
                    telefono: String(data.get("telefono")).trim()
                });
                if (saveRecords(records)) {
                    app.replaceChildren(element("h2", "Registro guardado"), element("p", `ID: ${nextId}`));
                }
            }));
            return;
        }

        if (view === "list") {
            app.append(element("h2", "Registros guardados"));
            renderTable(records);
            return;
        }

        if (view === "search" || view === "edit") {
            const id = new URLSearchParams(location.search).get("id");
            if (!id) {
                app.append(element("h2", view === "search" ? "Buscar registro" : "Modificar registro"));
                app.append(makeForm([
                    { name: "id", label: "ID", type: "number", min: "1" }
                ], "Buscar", (data) => {
                    location.href = `${location.pathname}?id=${encodeURIComponent(String(data.get("id")))}`;
                }));
                return;
            }
            const record = records.find((item) => String(item.id) === id);
            if (!record) {
                app.append(element("h2", "No se encontró el registro."));
                return;
            }
            if (view === "search") {
                app.append(element("h2", "Resultado de la búsqueda"));
                renderTable([record]);
                return;
            }
            app.append(element("h2", `Modificar registro ${record.id}`));
            app.append(makeForm([
                { name: "nombre", label: "Nombre", value: record.nombre, max: "100" },
                { name: "email", label: "Correo", type: "email", value: record.email, max: "250" },
                { name: "edad", label: "Edad", type: "number", value: record.edad, min: "1" },
                { name: "dni", label: "DNI", type: "number", value: record.dni, min: "1" },
                { name: "telefono", label: "Teléfono", type: "tel", value: record.telefono, max: "30" }
            ], "Guardar cambios", (data) => {
                Object.assign(record, {
                    nombre: String(data.get("nombre")).trim(),
                    email: String(data.get("email")).trim(),
                    edad: String(data.get("edad")),
                    dni: String(data.get("dni")),
                    telefono: String(data.get("telefono")).trim()
                });
                if (saveRecords(records)) {
                    app.replaceChildren(element("h2", "Registro actualizado."));
                }
            }));
            return;
        }

        if (view === "delete") {
            app.append(element("h2", "Borrar registro"));
            app.append(makeForm([
                { name: "id", label: "ID", type: "number", min: "1" }
            ], "Borrar", (data) => {
                const id = String(data.get("id"));
                const next = records.filter((record) => String(record.id) !== id);
                if (next.length === records.length) {
                    message("No se encontró el registro.");
                } else if (saveRecords(next)) {
                    app.replaceChildren(element("h2", "Registro borrado."));
                }
            }));
            return;
        }

        if (view === "delete-all") {
            app.append(element("h2", "Borrar todos los registros"));
            app.append(element("p", "Esta acción solo afecta a los datos guardados en este navegador."));
            const button = element("button", "Borrar todos");
            button.addEventListener("click", () => {
                if (window.confirm("¿Seguro que quieres borrar todos los registros de este navegador?") &&
                    saveRecords([])) {
                    app.replaceChildren(element("h2", "Registros borrados."));
                }
            });
            app.append(button);
        }
    }

    render();
})();
