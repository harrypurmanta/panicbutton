<?= $this->extend('layout/template'); 
?>

    <?= $this->section('content'); ?>
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
            
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
                                <h4 class="m-b-0 text-white d-inline">Tabel Data admission</h4>
                                <button id="simpankat" type="button" class="btn btn-success d-inline-block float-right" onclick="tambahdata()"> <i class="fa fa-check"></i> Tambah Data</button>
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
                                                <td><a onclick="showedit(<?= $k->hospital_admission_id ?>)"><span style="text-decoration:underline;" class="btn btn-link"><?= $k->person_nm ?></span></a>
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
        var admission_nm = $("input[name^='admission_nm']").val();
        if (admission_nm=='') {
        	Swal.fire({
            title:"Nama admission harus di isi!!",
            text:"GAGAL!",
            type:"warning",
            showCancelButton:!0,
            confirmButtonColor:"#556ee6",
            cancelButtonColor:"#f46a6a"
                })
        } else {
             var ajaxData = new FormData();
             ajaxData.append('action','upload-file');
             jQuery.each($("input[name^='photo']")[0].files, function(i, file) {
                ajaxData.append('photo['+i+']', file);
              });
             ajaxData.append('admission_nm',admission_nm);
            $.ajax({
            url : "<?= base_url('admission/save') ?>",
            type: "POST",
            data : ajaxData,
            contentType: false,
            processData: false,
            success:function(_data){
             if (_data=='already') {
                Swal.fire({
                    title:"Nama admission sudah ada!!",
                    text:"GAGAL!",
                    type:"warning",
                    showCancelButton:!0,
                    confirmButtonColor:"#556ee6",
                    cancelButtonColor:"#f46a6a"
                })
             } else {
                Swal.fire({
                    title:"Berhasil!",
                    text:"Data berhasil disimpan!",
                    type:"success",
                    showCancelButton:!0,
                    confirmButtonColor:"#556ee6",
                    cancelButtonColor:"#f46a6a"
                })
                $('#modaledit').modal('hide');
                 $( "#myTable" ).load("<?= base_url('admission') ?> #myTable");
               // setTimeout(function(){ window.location.href = "<?=base_url()?>/admission"; }, 1000);
                }
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

function showedit(id) {
    $.ajax({
     url : "<?= base_url('admission/formedit') ?>",
     type: "post",
     data : {'id':id},
     success:function(data){
      //_data = JSON.parse(data);
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
	var admission_nm = $('#admission_nm').val();
    var admission_id = $('#admission_id').val();
        if (admission_nm=='') {
        	Swal.fire({
                    title:"Nama admission harus di isi!!",
                    text:"GAGAL!",
                    type:"warning",
                    showCancelButton:!0,
                    confirmButtonColor:"#556ee6",
                    cancelButtonColor:"#f46a6a"
                })
        } else {
            var ajaxData = new FormData();
             ajaxData.append('action','update-file');
             ajaxData.append('admission_nm',admission_nm);
             ajaxData.append('admission_id',admission_id);
            $.ajax({
            url : "<?= base_url('admission/update') ?>",
            type: "POST",
            data : ajaxData,
            contentType: false,
            processData: false,
            success:function(_data){
             if (_data=='already') {
                Swal.fire({
                    title:"Nama admission sudah ada!!",
                    text:"GAGAL!",
                    type:"warning",
                    showCancelButton:!0,
                    confirmButtonColor:"#556ee6",
                    cancelButtonColor:"#f46a6a"
                })
             } else if (_data=='true'){
                Swal.fire({
                    title:"Berhasil!",
                    text:"Data berhasil disimpan!",
                    type:"success",
                    showCancelButton:!0,
                    confirmButtonColor:"#556ee6",
                    cancelButtonColor:"#f46a6a"
                })
                $('#modaledit').modal('hide');
                //setTimeout(function(){ window.location.href = "<?=base_url()?>/admission"; }, 1000);
                }
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
</script>

<?= $this->endSection(); ?>