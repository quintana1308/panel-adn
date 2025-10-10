<?php 
headerCliente($data); 
$arrCompras= $data['kpi'];
?>


	<div class="container-fluid py-4">
		
			<div class="row">

				<?php 
				for ($i=0; $i <count($arrCompras); $i++) { 

					if($arrCompras[$i]['TIPO_DASHBOARD'] != 1){  ?>
					<div class="col-md-4 mb-4">
						<div class="card mb-2 link">
							<!-- Card body -->
							<a href="<?= base_url(); ?>/tabla/kpi/<?= $arrCompras[$i]['ID_KPI']; ?>">
								<div class="card-body p-3">
									<div class="row">
										<div class="col-9">
											<div class="numbers"> 
												<p class="text-sm mb-0 text-uppercase font-weight-bold"><?= $arrCompras[$i]['LABEL']; ?></p>
												<h6><?= $arrCompras[$i]['SQL_VALUE']; ?></h6>
											<p class="mb-0 text-sm">
						                      <span class="text-success font-weight-bolder d-block"><?= $arrCompras[$i]['DESCRIPTION']; ?></span>
						                      <span class="d-block fw-lighter text-upd"><?= $arrCompras[$i]['UPD'];?></span>
						                    </p>
											</div>
										</div>

										<div class="col-3 text-end">
						                  <div class="icon icon-shape bg-gradient-danger shadow-warning text-center rounded-circle">
						                    <?= $arrCompras[$i]['ICON'] == ''? '<i class="fas fa-money-check-alt"></i>':$arrCompras[$i]['ICON'] ?>
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
