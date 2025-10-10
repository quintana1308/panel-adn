<?php 
    headerCliente($data); 
    getModal('modalDashboard',$data);
?>
<div id="url" data-value="<?= base_url() ?>"></div>
<main class="app-content">
    <div class="header  pb-6">
        <div class="container-fluid" style="margin-top: 15px;">
            <div class="header-body">
                <!-- Card stats -->
                <div class="row">
                    <div class="col">
                        <div class="card">
                            <!-- Card header -->
                            <div class="card-header border-0 pb-0 text-end">
                              <button class="btn btn-success mb-0" type="button" onclick="openModal();" ><i class="fas fa-plus-circle"></i> Nuevo Dashboard</button>
                            </div>
                            <!-- Light table -->
                            <div class="table-responsive">
                                <table class="display table table-hover table-sm table-striped" style="width:100%"
                                    id="tableDashboard">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Descripción</th>
                                            <th>Base de datos</th>
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

<?php footerCliente($data); ?>
