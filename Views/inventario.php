<?php 
headerCliente($data); 
$arrInventario = $data['kpi'];
?>

<div class="container-fluid py-4">

	<div class="row">

		<?php 
		for ($i=0; $i <count($arrInventario); $i++) {
			
			if($arrInventario[$i]['TIPO_DASHBOARD'] != 1){  ?>
			<div class="col-md-4 mb-4">
				<div class="card mb-2 link">
					<!-- Card body -->
					<a href="<?= base_url(); ?>/tabla/kpi/<?= $arrInventario[$i]['ID_KPI']; ?>">
						<div class="card-body p-3">
							<div class="row">
								<div class="col-9">
									<div class="numbers"> 
										<p class="text-sm mb-0 text-uppercase font-weight-bold"><?= $arrInventario[$i]['LABEL']; ?></p>
										<h6><?= $arrInventario[$i]['SQL_VALUE']; ?></h6>
										<p class="mb-0 text-sm">
											<span class="text-success font-weight-bolder d-block"><?= $arrInventario[$i]['DESCRIPTION']; ?></span>
											<span class="d-block fw-lighter text-upd"><?= $arrInventario[$i]['UPD'];?></span>
										</p>
									</div>
								</div>

								<div class="col-3 text-end">
									<div class="icon icon-shape bg-gradient-warning shadow-warning text-center rounded-circle">
										<?= $arrInventario[$i]['ICON'] == ''? '<i class="fas fa-box-open"></i>':$arrInventario[$i]['ICON'] ?>
									</div>
								</div>
							</div>

						</div>
					</a>


				</div>
			</div>

		<?php } } ?>

	</div>
</div>


<?php footerCliente($data); ?>

