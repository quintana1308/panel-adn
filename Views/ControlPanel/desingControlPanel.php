<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Designer</title>
    <link id="pagestyle" href="<?= media(); ?>/css/argon-dashboard.css?v=2.0.4" rel="stylesheet" /> 
    <script src="<?= media() ?>/StimulsoftDashboards/Scripts/stimulsoft.reports.js"></script>
    <script src="<?= media() ?>/StimulsoftDashboards/Scripts/stimulsoft.viewer.js"></script>
    <script src="<?= media() ?>/StimulsoftDashboards/Scripts/stimulsoft.designer.js"></script>
    <script src="<?= media() ?>/StimulsoftDashboards/Scripts/stimulsoft.dashboards.js"></script>
    <script src="<?= media() ?>/js/sweetalert2@11.js"></script>
</head>
<body>
    <div id="designer" style="width:100%; height:100vh;"></div>

    <script type="text/javascript">
        var options = new Stimulsoft.Designer.StiDesignerOptions();
        var designer = new Stimulsoft.Designer.StiDesigner(options, "StiDesigner", false);
        var report = new Stimulsoft.Report.StiReport();
        designer.report = report;

        designer.showSaveDialog = false;

        // Configurar el evento de guardado
        designer.onSaveReport = function (event) {
            var jsonString = event.report.saveToJsonString(); 
            // Mostrar un formulario usando SweetAlert2
            Swal.fire({
                title: '<h2>Guardar Reporte</h2>', // Cambié el título usando una clase Bootstrap
                html: `
                    <div class="mb-3">
                        <label for="Name" class="form-label">Nombre del Reporte</label>
                        <input type="text" id="Name" class="form-control" placeholder="Nombre">
                    </div>
                    <div class="mb-3">
                        <label for="reportName" class="form-label">Nombre del Archivo</label>
                        <div class="input-group">
                            <input type="text" id="reportName" class="form-control" placeholder="Nombre del Reporte">
                            <div class="input-group-append">
                                <span class="input-group-text">.mrt</span>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="reportDescription" class="form-label">Descripción del Reporte</label>
                        <textarea id="reportDescription" class="form-control" placeholder="Descripción del Reporte"></textarea>
                    </div>
                `,
                showCancelButton: true,
                confirmButtonText: 'Actualizar',
                customClass: {
                    confirmButton: 'btn btn-primary me-2', // Agrega estilo al botón de confirmación
                    cancelButton: 'btn btn-secondary'  // Agrega estilo al botón de cancelación
                },
                buttonsStyling: false,
                preConfirm: () => {
                    const Name = document.getElementById('Name').value;
                    const reportName = document.getElementById('reportName').value;
                    const reportDescription = document.getElementById('reportDescription').value;

                    if (!Name || !reportName || !reportDescription) {
                        Swal.showValidationMessage(`Por favor, complete todos los campos`);
                    }

                    return { Name, reportName, reportDescription};
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Enviar el informe al servidor para guardarlo
                    fetch("<?= base_url() ?>/ControlPanel/controlPanelSave", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        },
                        body: JSON.stringify({
                            report: jsonString,
                            Name: result.value.Name,
                            reportName: result.value.reportName,
                            reportDescription: result.value.reportDescription
                        })
                    })
                    .then(response => {
                        if (!response.ok) {
                            return response.json().then(error => { throw new Error(error.message); });
                        }
                        return response.json();
                    })
                    .then(data => {
                        Swal.fire('Guardado', data.message, 'success').then(() => {
                            // Redirigir a la nueva ruta después de que el usuario cierre el mensaje
                            window.location.href = "<?= base_url() ?>/home"; // Cambia 'reportList' por tu ruta deseada
                        });
                    })
                    .catch(error => {
                        if (error.errors) {
                            let errorMessage = '';
                            for (let key in error.errors) {
                                errorMessage += error.errors[key].join('<br>') + '<br>';
                            }
                            Swal.fire('Error', errorMessage, 'error');
                        } else {
                            Swal.fire('Error', 'Hubo un error al guardar el reporte', 'error');
                        }
                        console.error('Error:', error);
                    });
                }
            });
        };
        // Renderizar el diseñador
        designer.renderHtml("designer");
    </script>
</body>
</html>
