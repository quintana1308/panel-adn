<?php 
headerCliente($data);
$arrlabels= $data['labels'];
?>

<div class="container-fluid py-4">
<h3>Resumen</h3>
    <div id="url" data-value="<?= base_url() ?>"></div>
    
    <?php if(!empty($_SESSION['userDashboards'])) { ?>

    <div class="row p-3 justify-content-lg-center">
    <div class="form-group"  style="width:50%;">
        <select class="form-control" id="miSelect" onchange="redirigirEmpresa()">
        <?php foreach($_SESSION['userDashboards'] as $key => $value) { ?>
            <option value="<?= $value['DASHBOARD_ID'] ?>" <?= $_SESSION['userData']['ID_DASHBOARD'] == $value['DASHBOARD_ID'] ? 'selected' : '' ?> >
            <?= $value['DASHBOARD_NAME'] ?> 
            </option>
        <?php  } ?>
        </select>
    </div>
    </div>

    <?php  } ?>
    
    <?php
    function bgColor($modulo){
        $arrColors = [
            2  => 'bg-gradient-danger',
            3  => 'bg-gradient-success',
            4  => 'bg-gradient-info',
            5  => 'bg-gradient-dark',
            6  => 'bg-gradient-warning'
        ];

        if(array_key_exists($modulo, $arrColors)){
            return $arrColors[$modulo]; 
        }
        return 'bg-gradient-info';
        
    } 
    ?>      
    <div class="row">
        <?php 
		for ($i=0; $i <count($arrlabels); $i++) { ?>
    
        <div class="col-md-4 mb-4">
            <div class="card mb-2 link">
                <!-- Card body -->
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-10">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-uppercase font-weight-bold"><?= $arrlabels[$i]['LABEL']; ?>
                                </p>
                                <h6 class="font-weight-bolder"><?= $arrlabels[$i]['SQL_TABLA']; ?></h6>
                                <span class="d-block fw-lighter text-upd"><?= $arrlabels[$i]['UPD'];?></span>
                            </div>
                        </div>

                        <div class="col-2 text-end">
                            <div class="icon icon-shape <?= bgColor($arrlabels[$i]['MODULO']); ?> shadow-success text-center rounded-circle" bis_skin_checked="1">
                                <?= $arrlabels[$i]['ICON'] == ''? '<i class="fas fa-hand-holding-usd"></i>':$arrlabels[$i]['ICON'] ?>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <?php } ?>
    </div>
    
    <div class="row mt-4">
        <?php
        $grafArray = array_values($data['graf']);
        
        $filteredArray = array_filter($grafArray, function($element) {
            return !empty($element);
        });

        if (!empty($filteredArray)) {
        // Ordenar el array por 'POSICION'
        usort($grafArray, function($a, $b) {
            return $a['POSICION'] - $b['POSICION'];
        });
        foreach ($grafArray as $key => $value) {
            if($value['OCULTO'] == 0 && $value['DESCRIPTIONKPI'] !== 'graficaPricipalLine'){
                if(!empty($value)){?>
                <div class="col-md-<?= $value['ANCHO'] ?> mb-4" id='<?= $value['DESCRIPTIONKPI'] ?>' data-value="<?= htmlspecialchars(json_encode($value), ENT_QUOTES, 'UTF-8') ?>">
                    <div class="card z-index-2 h-100">
                        <div class="card-body p-3">
                            <div class="chart">
                                <div id="<?= $value['DESCRIPTIONKPI'] ?>_id" class="chart-canvas" height="300"></div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php }
            } 
        }
        }   
        ?>
    </div>
</div>
<?php footerCliente($data); ?>
    
    <script>
        const base_url = "<?= base_url(); ?>";
    </script>

    <!-- Vincula el archivo JavaScript externo -->
    <script type="text/javascript" src="<?= media();?>/js/functions_resumen.js"></script>
    <script type="text/javascript" src="<?= media();?>/js/graficas/grafico_resumen_line.js"></script>
    <script type="text/javascript" src="<?= media();?>/js/graficas/grafico_resumen_line_2.js"></script>
    <script type="text/javascript" src="<?= media();?>/js/graficas/grafico_resumen_column.js"></script>
    <script type="text/javascript" src="<?= media();?>/js/graficas/grafico_resumen_column_2.js"></script>
    <script type="text/javascript" src="<?= media();?>/js/graficas/grafico_resumen_pie.js"></script>
    <script type="text/javascript" src="<?= media();?>/js/graficas/grafico_resumen_pie_2.js"></script>
    <script type="text/javascript" src="<?= media();?>/js/graficas/grafico_resumen_donut.js"></script>
    <script type="text/javascript" src="<?= media();?>/js/graficas/grafico_resumen_donut_2.js"></script>