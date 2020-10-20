<?php
$uri = current_url(true);
?>
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
                                <h4 class="m-b-0 text-white d-inline"><?= $admission[0]->pangkat_nm." ".$admission[0]->person_nm." (".$admission[0]->employee_ext_id.")" ?></h4>
                                <button id="simpankat" type="button" class="btn btn-success d-inline-block float-right" onclick="tambahdata()"> <i class="fa fa-check"></i> Tambah Data</button>
                            </div>
                            <div class="card-body">
                               <div class="table-responsive">
                                    <table id="myTable" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th class="text-center">No</th>
                                                <th width="150" class="text-center">Tanggal</th>
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
                                                <td><a onclick="showeditadmisson(<?= $k->hospital_admission_id ?>)"><span style="text-decoration:underline;" class="btn btn-link"><?= $k->admission_dttm ?></span></a>
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

function tambahdata() {
    $.ajax({
     url : "<?= base_url('admission/tambahdata') ?>",
     type: "post",
     success:function(data){
     $('#modaledit').modal('show');
     $('#modaledit').html(data);
    },
    error:function(){
        Swal.fire({
            title:"Gagal!",
            text:"Data gagal disimpan!",
            type:"warning",
            showCancelButton:!0,
            confirmButtonColor:"#556ee6",
            cancelButtonColor:"#f46a6a"
        })
    }
    });
}

    function simpan() {
    	var table = $('#myTable').DataTable();
    	var person_id = <?= $uri->getSegment(3) ?>;
        var admission_dttm = $("#admission_dttm").val();
        if (admission_dttm == "") {
        	Swal.fire({
            title:"Tanggal admission harus di isi!!",
            text:"GAGAL!",
            type:"warning",
            showCancelButton:!0,
            confirmButtonColor:"#556ee6",
            cancelButtonColor:"#f46a6a"
                })
        } else {
             var ajaxData = new FormData();
             ajaxData.append('action','upload-file');
             ajaxData.append('person_id',person_id);
             ajaxData.append('admission_dttm',admission_dttm);
             ajaxData.append('tensi',$("#tensi").val());
             ajaxData.append('bbtb',$("#bbtb").val());
             ajaxData.append('lab',$("#lab").val());
             ajaxData.append('mri',$("#mri").val());
             ajaxData.append('ekg',$("#ekg").val());
             ajaxData.append('terapi',$("#terapi").val());
             ajaxData.append('diagnosa',$("#diagnosa").val());
             ajaxData.append('radiologi',$("#radiologi").val());
             ajaxData.append('saran',$("#saran").val());
            $.ajax({
            url : "<?= base_url('admission/save') ?>",
            type: "POST",
            data : ajaxData,
            contentType: false,
            processData: false,
            success:function(_data){
             Swal.fire({
                 title:"Berhasil!",
                 text:"Data berhasil disimpan!",
                 type:"success",
                 showCancelButton:!0,
                 confirmButtonColor:"#556ee6",
                 cancelButtonColor:"#f46a6a"
             })
                $('#modaledit').modal('hide');
                showlistadmission(person_id);
            },
            error:function(){
                Swal.fire({
                    title:"Gagal!",
                    text:"Data gagal disimpan!",
                    type:"warning",
                    showCancelButton:!0,
                    confirmButtonColor:"#556ee6",
                    cancelButtonColor:"#f46a6a"
                })
            }
            });
        }
}

function showeditadmisson(id) {
    $.ajax({
     url : "<?= base_url('admission/formedit') ?>",
     type: "post",
     data : {'id':id},
     success:function(data){
     $('#modaledit').modal('show');
     $('#modaledit').html(data);
    },
    error:function(){
        Swal.fire({
            title:"Gagal!",
            text:"Data gagal disimpan!",
            type:"warning",
            showCancelButton:!0,
            confirmButtonColor:"#556ee6",
            cancelButtonColor:"#f46a6a"
        })
    }
    });
}

function hapus(id,t) {
    $.ajax({
     url : "<?= base_url('admission/hapus') ?>",
     type: "post",
     data : {'id':id,'t':t},
     success:function(){
      
        Swal.fire({
            title:"Berhasil!",
            text:"Data berhasil disimpan!",
            type:"success",
            showCancelButton:!0,
            confirmButtonColor:"#556ee6",
            cancelButtonColor:"#f46a6a"
        })
        setTimeout(function(){ window.location.href = "<?=base_url()?>/admission"; }, 1000);
    
     },
     error:function(){
        Swal.fire({
            title:"Gagal!",
            text:"Data gagal disimpan!",
            type:"warning",
            showCancelButton:!0,
            confirmButtonColor:"#556ee6",
            cancelButtonColor:"#f46a6a"
        })
     }
    });

}

function update(id) {
	var person_id = $("#person_id").val();
    var ajaxData = new FormData();
            ajaxData.append('admission_dttm',$("#admission_dttm").val());
            ajaxData.append('old_admission_dttm',$("#old_admission_dttm").val());
            ajaxData.append('tensi',$("#tensi").val());
            ajaxData.append('bbtb',$("#bbtb").val());
            ajaxData.append('lab',$("#lab").val());
            ajaxData.append('mri',$("#mri").val());
            ajaxData.append('ekg',$("#ekg").val());
            ajaxData.append('terapi',$("#terapi").val());
            ajaxData.append('diagnosa',$("#diagnosa").val());
            ajaxData.append('radiologi',$("#radiologi").val());
            ajaxData.append('saran',$("#saran").val());
            ajaxData.append('id',id);
        $.ajax({
            url : "<?= base_url('admission/update') ?>",
            type: "POST",
            data : ajaxData,
            processData: false,
        	contentType: false,
            success:function(_data){
            	Swal.fire({
                    title:"Berhasil!",
                    text:"Data berhasil disimpan!",
                    type:"success",
                    showCancelButton:!0,
                    confirmButtonColor:"#556ee6",
                    cancelButtonColor:"#f46a6a"
                })
                $('#modaledit').modal('hide');
                showlistadmission(person_id);
            },
            error:function(){
                Swal.fire({
                    title:"Gagal!",
                    text:"Data gagal disimpan!",
                    type:"warning",
                    showCancelButton:!0,
                    confirmButtonColor:"#556ee6",
                    cancelButtonColor:"#f46a6a"
                })
            }
        });
}
</script>

<?= $this->endSection(); ?>