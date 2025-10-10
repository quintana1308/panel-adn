<?php
headerCliente($data);
?>
<div class="header pb-6">
    <div class="container-fluid" style="margin-top: 30px;">
        <div id="viewer"></div>
    </div>
</div>

<?php footerCliente($data); ?>

<script type="text/javascript">

    var report = new Stimulsoft.Report.StiReport();
    
    report.loadFile("<?= base_url() ?>/Views/ControlPanel/Plantillas/<?= $data['nameArchive'] ?>.mrt"); // Carga el archivo .mrt

    // Renderizar el reporte
    var options = new Stimulsoft.Viewer.StiViewerOptions();
    options.appearance.fullScreenMode = false;

    var viewer = new Stimulsoft.Viewer.StiViewer(options, "StiViewer", false);
    viewer.report = report;
    viewer.renderHtml("viewer");
</script>