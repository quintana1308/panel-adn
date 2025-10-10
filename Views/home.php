<?php headerCliente($data);?>

<div class="container-fluid py-4">

    <?php if (!empty($data['mainKpisLimit4'])) {?>
    <div class="row">

        <?php foreach ($data['mainKpisLimit4'] as $key => $value) {?>
        <div class="col-md-4 mb-4">
            <div class="card <?=$value['BACKGROUND']?>">
            <a href="<?= base_url(); ?>/home/<?= $value['URL']; ?>">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="mb-2 text-uppercase font-weight-bold text-white">
                                    <?=$value['NAME_MODULO']?></p>
                                <p class="fw-lighter text-upd text-white"><?=$value['UPD']?></p>
                            </div>
                        </div>
                        <div class="col-4 text-center">
                            <div
                                class="icon <?=$value['BACKGROUND']?> shadow-primary text-center rounded-circle icon-shape-dashboard fa-2x"
                                style="width: 70px; height: 70px; color: white; padding-top: 10px;">
                                <?=$value['ICON']?>
                            </div>
                        </div>
                    </div>
                </div>
                </a>
            </div>
        </div>
        <?php }?>

    </div>
    <?php }?>

    <div class="row mt-4">
        <div class="col-md-6 mb-4">
            
            <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
                <ol class="carousel-indicators">
                    <li data-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active"></li>
                    <li data-target="#carouselExampleIndicators" data-bs-slide-to="1"></li>
                </ol>
                <div class="carousel-inner rounded">
                    <div class="carousel-item active">
                    <img class="d-block" src="<?= base_url() ?>/Assets/img/carrusel-new-1.png" alt="First slide">
                    <div class="carousel-caption caption-2 d-none d-md-block bottom-0 text-start start-0 ms-5"
                                            bis_skin_checked="1">
                                            <h1 class="text-white mb-1 title-carousel-2">Cobranza: Abonos, multimoneda, bloqueos,
                                                recibos</h1>
                                        </div>
                    </div>
                    <div class="carousel-item">
                    <img class="d-block" src="<?= base_url() ?>/Assets/img/carrusel-new-2.png" alt="Second slide">
                    <div class="carousel-caption d-none d-md-block bottom-0 text-start start-0 ms-5"
                                            bis_skin_checked="1">
                                            <h1 class="text-white mb-1 title-carousel">ADN MOVIL</h1>
                                            <p class="description-carousel">Gestiona tus ventas y cobranzas desde tu celular fácil y
                                                rápido</p>
                                        </div>
                    </div>
                </div>
                <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>

        </div>

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
            if($value['OCULTO'] == 0){
                if(!empty($value)){?>
    <div class="col-md-<?= $value['ANCHO'] ?> mb-4" id='<?= $value['DESCRIPTIONKPI'] ?>'
        data-value="<?= htmlspecialchars(json_encode($value), ENT_QUOTES, 'UTF-8') ?>">
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
        }?>
</div>
</div>
<?php footerCliente($data);?>

<!-- Vincula el archivo JavaScript externo -->
<script type="text/javascript" src="<?= media();?>/js/graficas/grafico_line.js"></script>
<script type="text/javascript" src="<?= media();?>/js/graficas/grafico_line_2.js"></script>
<script type="text/javascript" src="<?= media();?>/js/graficas/grafico_column.js"></script>
<script type="text/javascript" src="<?= media();?>/js/graficas/grafico_column_2.js"></script>
<script type="text/javascript" src="<?= media();?>/js/graficas/grafico_pie.js"></script>
<script type="text/javascript" src="<?= media();?>/js/graficas/grafico_pie_2.js"></script>
<script type="text/javascript" src="<?= media();?>/js/graficas/grafico_donut.js"></script>
<script type="text/javascript" src="<?= media();?>/js/graficas/grafico_donut_2.js"></script>
<script type="text/javascript" src="<?= media();?>/js/graficas/grafico_line_pie.js"></script>
<script type="text/javascript" src="<?= media();?>/js/graficas/grafico_line_pie_2.js"></script>
<script type="text/javascript" src="<?= media();?>/js/graficas/grafico_heat.js"></script>
<script type="text/javascript" src="<?= media();?>/js/graficas/grafico_heat_2.js"></script>
