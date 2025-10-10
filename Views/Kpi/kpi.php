<?php 
headerAdmin($data); 
getModal('modalKpi',$data);
?>

<div class="row align-items-center py-2 bg-white">
	<div class="app-title">
		<div>
			<h1><i class="fas fa-user-tag ml-4"></i> <?= $data['page_title'] ?>
			<?php if($_SESSION['permisosMod']['w']){ ?>
				<button class="btn btn-primary" type="button" onclick="openModal();" ><i class="fas fa-plus-circle"></i> Nuevo</button>
			<?php } ?>
		</h1>
	</div>
</div>
</div>


<main class="app-content">    


	<div class="header  pb-6">
  <div class="container-fluid" style="margin-top: 15px;">
    <div class="header-body">

      <!-- Card stats -->
      <div class="row">
        <div class="col">
          <div class="card">
            <!-- Card header -->
            <div class="card-header border-0">
              <h3 class="mb-0"></h3>
            </div>
            <!-- Light table -->
            <div class="table-responsive">
              <table class="table table-hover table-sm table-striped" style="width:100%" id="tableKpi">
                
                      <thead>
                        <tr>
                          <th>ID_KPI</th>
                          <th>ID_KPI_DD</th>
                          <th>label</th>
                          <th>Descripción</th>
                          <th>Oculto</th>
                          <th>Posición</th>
                          <th>Acciones</th>
                        </tr>
                      </thead>
                      <tbody>
                      </tbody>
                    
                </table>
              </div>
              <!-- Card footer -->

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>


</main>

<?php footerAdmin($data); ?>
