<?php

headerCliente($data);

$arrKpi = $data['kpi']; // obtenemos los datos del kpi 

$filter_status = $arrKpi['FILTER'];

?>

<style>
.dataTables_filter {
    display: inline-block !important;
    float: right !important;
    padding-right: 1.5rem !important;
}
.tem-variables{
	cursor: pointer;
}
.tem-variables:hover{
	background-color: black;
}
</style>
<div class="container-fluid">

    <nav aria-label="breadcrumb" class="mt-3 mr-3 ml-3">
        <ol class="breadcrumb card" style="flex-direction: initial !important;">
            <li class="breadcrumb-item"><a href="<?= base_url() ?>"><i class="fas fa-home"></i></a></li>
            <li class="breadcrumb-item">Centro de datos financiero</li>
        </ol>
    </nav>

</div>

<div class="header pb-6">
    <div class="container-fluid" style="margin-top: 30px;">
        <?php if (!empty($data['filtros'])) { ?>
        <div class="col-md-12">
            <div class="card d-flex">
                <div class="card-header">
                    <h3>Filtros</h3>
                </div>
                <div class="card-body ">
                    <form action="#" method="get" id="form-filter">
                        <div class="row">
                            <div class="col-md-3">
                                <label class="form-control-label">TIPO : </label>
                                <select class="form-control class-kpi" id="KPI" name="KPI">
                                    <option selected disabled data-atributo='hola'>--- Seleccione ---</option>

                                    <?php foreach ($data['filtros'][0]['SQL_SINCE'] as $key => $condic) { ?>
                                    <option value="<?= $condic['INDICE'] ?>" data-atributo="<?= $condic['FILTER'] ?>"
                                        data-atributo-access="<?= $condic['FILTER_ACCESS'] ?>">
                                        <?= $condic['VALOR'] ?></option>
                                    <?php } ?>
                                </select>


                            </div>
                            <?php foreach ($data['filtros'] as $key => $filtro) { ?>

                            <?php if ($key != 0) { ?>
                            <div class="col-md-3">

                                <?php if ($filtro['TYPE_PARAM'] == 'SELECT') { ?>
                                <label class="form-control-label"><?= $filtro['LABEL'] ?> : </label>
                                <select
                                    class="form-control js-example-basic-multiple js-example-basic-multiple filter-<?= $filtro['ORDER_PARAM'] ?>"
                                    id="<?= $filtro['NAME_COLUMN'] ?>" name="<?= $filtro['NAME_COLUMN'] ?>"
                                    multiple="multiple">
                                    <option selected disabled>--- Seleccione ---</option>
                                    <?php foreach ($filtro['SQL_SINCE'] as $key => $condic) { ?>
                                    <option value="^<?= $condic['INDICE'] ?>"><?= $condic['VALOR'] ?> </option>
                                    <?php } ?>
                                </select>

                                <?php } else if ($filtro['TYPE_PARAM'] == 'DATE') { ?>
                                <label class="form-control-label"><?= $filtro['LABEL'] ?> :</label>
								<select
                                    class="form-control p-2 form-filter-date filter-<?= $filtro['ORDER_PARAM'] ?>" name="<?= $filtro['NAME_COLUMN'] ?>">
                                    <option selected disabled>--- Seleccione ---</option>
									<option value="2023">2023</option>
									<option value="2024">2024</option>
									<option value="2025">2025</option>
									<option value="2026">2026</option>
									<option value="2027">2027</option>
									<option value="2028">2028</option>
									<option value="2029">2029</option>
									<option value="2030">2030</option>
                                </select>
                                <?php } ?>

                            </div>
                            <?php } ?>
                            <?php } ?>
                            <div class="col-md-3 mt-4">
                                <a href="#" class="btn btn-success" id="btn-filter"><i
                                        class="fa fa-fw fa-lg fa-filter"></i> Filtrar</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <?php } ?>

        <div class="row mt-2">
            <div class="col-md-3 mt-4">
                <table class="w-100" id="table-new">
                </table>
            </div>
            <div class="col-md-9">
                <div id="container-info">
                    <div class="row mt-4">
                        <div class="col-md-2 grid-margin stretch-card gx-3 mb-2 px-1">
                            <div class="card shadow-sm card-transp mb-0">
                                <div class="card-body p-2">
                                    <h6 class="card-title fs-6 mb-1">Enero</h6>
                                    <div class="media">
                                        <div class="media-body">
                                            <div class="d-flex align-items-center mb-0">
                                                <p class=" text-sm mb-0"><small id="valor1-1">0 </small> vs</p>
                                                <p class="card-text ms-2"><small
                                                        class="align-items-center text-info text-gradient text-sm font-weight-bold"
                                                        id="valor1-2">0%</small></p>
                                            </div>
                                            <div class="d-flex align-items-center mb-0">
                                                <p class=" text-sm mb-0"><small id="valor1-3">0 </small> vs</p>
                                                <p class="card-text ms-2"><small
                                                        class="align-items-center text-info text-gradient text-sm font-weight-bold"
                                                        id="valor1-4">0%</small></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 grid-margin stretch-card gx-3 mb-2 px-1">
                            <div class="card shadow-sm card-transp mb-0">
                                <div class="card-body p-2">
                                    <h6 class="card-title fs-6 mb-1">Febrero</h6>
                                    <div class="media">
                                        <div class="media-body">
                                            <div class="d-flex align-items-center mb-0">
                                                <p class=" text-sm mb-0"><small id="valor2-1">0 </small> vs</p>
                                                <p class="card-text ms-2"><small
                                                        class="align-items-center text-info text-gradient text-sm font-weight-bold"
                                                        id="valor2-2">0%</small></p>
                                            </div>
                                            <div class="d-flex align-items-center mb-0">
                                                <p class=" text-sm mb-0"><small id="valor2-3">0 </small> vs</p>
                                                <p class="card-text ms-2"><small
                                                        class="align-items-center text-info text-gradient text-sm font-weight-bold"
                                                        id="valor2-4">0%</small></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 grid-margin stretch-card gx-3 mb-2 px-1">
                            <div class="card shadow-sm card-transp mb-0">
                                <div class="card-body p-2">
                                    <h6 class="card-title fs-6 mb-1">Marzo</h6>
                                    <div class="media">
                                        <div class="media-body">
                                            <div class="d-flex align-items-center mb-0">
                                                <p class=" text-sm mb-0"><small id="valor3-1">0 </small> vs</p>
                                                <p class="card-text ms-2"><small
                                                        class="align-items-center text-info text-gradient text-sm font-weight-bold"
                                                        id="valor3-2">0%</small></p>
                                            </div>
                                            <div class="d-flex align-items-center mb-0">
                                                <p class=" text-sm mb-0"><small id="valor3-3">0 </small> vs</p>
                                                <p class="card-text ms-2"><small
                                                        class="align-items-center text-info text-gradient text-sm font-weight-bold"
                                                        id="valor3-4">0%</small></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 grid-margin stretch-card gx-3 mb-2 px-1">
                            <div class="card shadow-sm card-transp mb-0">
                                <div class="card-body p-2">
                                    <h6 class="card-title fs-6 mb-1">Abril</h6>
                                    <div class="media">
                                        <div class="media-body">
                                            <div class="d-flex align-items-center mb-0">
                                                <p class=" text-sm mb-0"><small id="valor3-1">0 </small> vs</p>
                                                <p class="card-text ms-2"><small
                                                        class="align-items-center text-info text-gradient text-sm font-weight-bold"
                                                        id="valor4-2">0%</small></p>
                                            </div>
                                            <div class="d-flex align-items-center mb-0">
                                                <p class=" text-sm mb-0"><small id="valor4-3">0 </small> vs</p>
                                                <p class="card-text ms-2"><small
                                                        class="align-items-center text-info text-gradient text-sm font-weight-bold"
                                                        id="valor4-4">0%</small></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 grid-margin stretch-card gx-3 mb-2 px-1">
                            <div class="card shadow-sm card-transp mb-0">
                                <div class="card-body p-2">
                                    <h6 class="card-title fs-6 mb-1">Mayo</h6>
                                    <div class="media">
                                        <div class="media-body">
                                            <div class="d-flex align-items-center mb-0">
                                                <p class=" text-sm mb-0"><small id="valor5-1">0 </small> vs</p>
                                                <p class="card-text ms-2"><small
                                                        class="align-items-center text-info text-gradient text-sm font-weight-bold"
                                                        id="valor5-2">0%</small></p>
                                            </div>
                                            <div class="d-flex align-items-center mb-0">
                                                <p class=" text-sm mb-0"><small id="valor5-3">0 </small> vs</p>
                                                <p class="card-text ms-2"><small
                                                        class="align-items-center text-info text-gradient text-sm font-weight-bold"
                                                        id="valor5-4">0%</small></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 grid-margin stretch-card gx-3 mb-2 px-1">
                            <div class="card shadow-sm card-transp mb-0">
                                <div class="card-body p-2">
                                    <h6 class="card-title fs-6 mb-1">Junio</h6>
                                    <div class="media">
                                        <div class="media-body">
                                            <div class="d-flex align-items-center mb-0">
                                                <p class=" text-sm mb-0"><small id="valor6-1">0 </small> vs</p>
                                                <p class="card-text ms-2"><small
                                                        class="align-items-center text-info text-gradient text-sm font-weight-bold"
                                                        id="valor6-2">0%</small></p>
                                            </div>
                                            <div class="d-flex align-items-center mb-0">
                                                <p class=" text-sm mb-0"><small id="valor6-3">0 </small> vs</p>
                                                <p class="card-text ms-2"><small
                                                        class="align-items-center text-info text-gradient text-sm font-weight-bold"
                                                        id="valor6-4">0%</small></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-2 px-0">
                            <div class="col-md-12 grid-margin stretch-card px-1 ">
                                <div class="card shadow-sm card-transp mb-0">
                                    <div class="card-body p-2">
                                        <h4 class="card-title fs-6">Total Periodo</h4>
                                        <div class="media">
                                            <div class="media-body">
                                                <div class="d-flex align-items-center mb-0">
                                                    <p class=" text-sm mb-0"><small id="valor-total">0</small></p>
                                                    <p class="card-text ms-2"><small
                                                            class="align-items-center text-info text-gradient text-sm font-weight-bold"
                                                            id="valor-totalp">0%</small></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8 grid-margin stretch-card gx-3 mb-2 px-1">
                            <div class="card shadow-sm card-transp">
                                <div class="card-body p-2">
                                    <canvas id="miGrafico" width="400"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 px-0">
                            <div class="col-md-12 grid-margin stretch-card px-1 mb-2">
                                <div class="card shadow-sm card-transp">
                                    <div class="card-body p-2">
                                        <h4 class="card-title fs-6">Comparación Periodo</h4>
                                        <div class="media">
                                            <div class="media-body">
                                                <div class="d-flex align-items-center mb-0">
                                                    <p class=" text-sm mb-0"><small id="valor-comparacion">0</small>
                                                    </p>
                                                    <p class="card-text ms-2"><small
                                                            class="align-items-center text-info text-gradient text-sm font-weight-bold"
                                                            id="valor-comparacionp">0%</small></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-2 grid-margin stretch-card gx-3 mb-2 px-1">
                            <div class="card shadow-sm card-transp mb-0">
                                <div class="card-body p-2">
                                    <h6 class="card-title fs-6 mb-1">Julio</h6>
                                    <div class="media">
                                        <div class="media-body">
                                            <div class="d-flex align-items-center mb-0">
                                                <p class=" text-sm mb-0"><small id="valor7-1">0 </small> vs</p>
                                                <p class="card-text ms-2"><small
                                                        class="align-items-center text-info text-gradient text-sm font-weight-bold"
                                                        id="valor7-2">0%</small></p>
                                            </div>
                                            <div class="d-flex align-items-center mb-0">
                                                <p class=" text-sm mb-0"><small id="valor7-3">0 </small> vs</p>
                                                <p class="card-text ms-2"><small
                                                        class="align-items-center text-info text-gradient text-sm font-weight-bold"
                                                        id="valor7-4">0%</small></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 grid-margin stretch-card gx-3 mb-2 px-1">
                            <div class="card shadow-sm card-transp mb-0">
                                <div class="card-body p-2">
                                    <h6 class="card-title fs-6 mb-1">Agosto</h6>
                                    <div class="media">
                                        <div class="media-body">
                                            <div class="d-flex align-items-center mb-0">
                                                <p class=" text-sm mb-0"><small id="valor8-1">0 </small> vs</p>
                                                <p class="card-text ms-2"><small
                                                        class="align-items-center text-info text-gradient text-sm font-weight-bold"
                                                        id="valor8-2">0%</small></p>
                                            </div>
                                            <div class="d-flex align-items-center mb-0">
                                                <p class=" text-sm mb-0"><small id="valor8-3">0 </small> vs</p>
                                                <p class="card-text ms-2"><small
                                                        class="align-items-center text-info text-gradient text-sm font-weight-bold"
                                                        id="valor8-4">0%</small></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 grid-margin stretch-card gx-3 mb-2 px-1">
                            <div class="card shadow-sm card-transp mb-0">
                                <div class="card-body p-2">
                                    <h6 class="card-title fs-6 mb-1">Septiembre</h6>
                                    <div class="media">
                                        <div class="media-body">
                                            <div class="d-flex align-items-center mb-0">
                                                <p class=" text-sm mb-0"><small id="valor9-1">0 </small> vs</p>
                                                <p class="card-text ms-2"><small
                                                        class="align-items-center text-info text-gradient text-sm font-weight-bold"
                                                        id="valor9-2">0%</small></p>
                                            </div>
                                            <div class="d-flex align-items-center mb-0">
                                                <p class=" text-sm mb-0"><small id="valor9-3">0 </small> vs</p>
                                                <p class="card-text ms-2"><small
                                                        class="align-items-center text-info text-gradient text-sm font-weight-bold"
                                                        id="valor9-4">0%</small></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 grid-margin stretch-card gx-3 mb-2 px-1">
                            <div class="card shadow-sm card-transp mb-0">
                                <div class="card-body p-2">
                                    <h6 class="card-title fs-6 mb-1">Octubre</h6>
                                    <div class="media">
                                        <div class="media-body">
                                            <div class="d-flex align-items-center mb-0">
                                                <p class=" text-sm mb-0"><small id="valor10-1">0 </small> vs</p>
                                                <p class="card-text ms-2"><small
                                                        class="align-items-center text-info text-gradient text-sm font-weight-bold"
                                                        id="valor10-2">0%</small></p>
                                            </div>
                                            <div class="d-flex align-items-center mb-0">
                                                <p class=" text-sm mb-0"><small id="valor10-3">0 </small> vs</p>
                                                <p class="card-text ms-2"><small
                                                        class="align-items-center text-info text-gradient text-sm font-weight-bold"
                                                        id="valor10-4">0%</small></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 grid-margin stretch-card gx-3 mb-2 px-1">
                            <div class="card shadow-sm card-transp mb-0">
                                <div class="card-body p-2">
                                    <h6 class="card-title fs-6 mb-1">Noviembre</h6>
                                    <div class="media">
                                        <div class="media-body">
                                            <div class="d-flex align-items-center mb-0">
                                                <p class=" text-sm mb-0"><small id="valor11-1">0 </small> vs</p>
                                                <p class="card-text ms-2"><small
                                                        class="align-items-center text-info text-gradient text-sm font-weight-bold"
                                                        id="valor11-2">0%</small></p>
                                            </div>
                                            <div class="d-flex align-items-center mb-0">
                                                <p class=" text-sm mb-0"><small id="valor11-3">0 </small> vs</p>
                                                <p class="card-text ms-2"><small
                                                        class="align-items-center text-info text-gradient text-sm font-weight-bold"
                                                        id="valor11-4">0%</small></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 grid-margin stretch-card gx-3 mb-4 px-1">
                            <div class="card shadow-sm card-transp mb-0">
                                <div class="card-body p-2">
                                    <h6 class="card-title fs-6 mb-1">Diciembre</h6>
                                    <div class="media">
                                        <div class="media-body">
                                            <div class="d-flex align-items-center mb-0">
                                                <p class=" text-sm mb-0"><small id="valor12-1">0 </small> vs</p>
                                                <p class="card-text ms-2"><small
                                                        class="align-items-center text-info text-gradient text-sm font-weight-bold"
                                                        id="valor12-2">0%</small></p>
                                            </div>
                                            <div class="d-flex align-items-center mb-0">
                                                <p class=" text-sm mb-0"><small id="valor12-3">0 </small> vs</p>
                                                <p class="card-text ms-2"><small
                                                        class="align-items-center text-info text-gradient text-sm font-weight-bold"
                                                        id="valor12-4">0%</small></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="container-compare" style="display: none;">
                    <div class="row mt-4">
                        <div class="col-md-12 grid-margin stretch-card gx-3 mb-2 px-1">
                            <div class="card shadow-sm card-transp">
                                <div class="card-body p-2">
                                    <div class="row">
                                        <div class="col-6">

                                            <canvas id="miGraficoCompareBar" width="50%"></canvas>
                                        </div>
                                        <div class="col-6">
                                            <canvas id="miGraficoCompareLine" width="50%"></canvas>

                                        </div>

                                        <div class="col-12">
                                            <canvas id="totalComparative1" width="100%"></canvas>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<div id='rutaUrl' data-value="<?= base_url() ?>"></div>

<?php footerCliente($data); ?>

<script src="//cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js"></script>
<script src="<?= media(); ?>/js/plugins/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script src="<?= media(); ?>/js/functions_center.js"></script>