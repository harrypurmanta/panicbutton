<?= $this->extend('layout/template'); 
?>

    <?= $this->section('content'); ?>
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper" style="padding-top: 0px !important;">
            
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
            <!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-themecolor"><?= $subtitle ?></h3>
                </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item">Pengaturan</li>
                        <li class="breadcrumb-item active"><?= $subtitle ?></li>
                    </ol>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- End Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
          		
                <div class="row">
                    <div class="col-lg-12 col-md-12">
                        <div class="card">
                        	<div class="card-header bg-info">
                                <h4 class="m-b-0 text-white d-inline">Tabel Data Rekam Medis</h4>
                            </div>
                            <div class="card-body">
                               <div class="table-responsive">
                                    <table id="myTable" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th class="text-center">No</th>
                                                <th class="text-center">Nama</th>
                                                <th class="text-center">Hasil Pemeriksaan</th>
                                                <th class="text-center">DIAGNOSIS</th>
                                                <th class="text-center">TERAPI</th>
                                                <th class="text-center">SARAN</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        	<?php 
                                        		$no=1;
                                        		foreach ($admission as $k) {
                                        	?>

                                            <tr>
                                                <td class="text-center"><?= $no++ ?></td>
                                                <td><a onclick="showlistadmission(<?= $k->person_id ?>)"><span style="text-decoration:underline;" class="btn btn-link"><?= $k->pangkat_nm." ".$k->person_nm ?></span></a>
                                                </td>
                                                <td>
                                                  <div>
                                                      <span>Tensi : <?= $k->tensi ?></span>
                                                  </div>
                                                  <div>
                                                      <span>BB/TB : <?= $k->bbtb ?></span>
                                                  </div>
                                                  <div>
                                                      <span>LAB : <?= $k->lab ?></span>
                                                  </div>
                                                  <div>
                                                      <span>RADIOLOGI : <?= $k->radiologi ?></span>
                                                  </div>
                                                  <div>
                                                      <span>MRI : <?= $k->mri ?></span>
                                                  </div>
                                                  <div>
                                                      <span>EKG : <?= $k->ekg ?></span>
                                                  </div>
                                                </td>
                                                <td><?= $k->admission_diag ?></td>
                                                <td><?= $k->terapi ?></td>
                                                <td><?= $k->saran ?></td>
                                            </tr>
                                        <?php } ?>

                                     </tbody>
                                    </table>

                                </div>
                            </div>
                           
                        </div>
                    </div>
                </div>
            </div>
            <div id="modaledit" class="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                              
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->

              <script type="text/javascript">

function showlistadmission(id) {
window.location.href = "<?=base_url()?>/admission/listadmission/"+id;
}
</script>

<?= $this->endSection(); ?>