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
                            <div class="card-body">
                              	<?= csrf_field(); ?>
                                <form id="upload-file" method="post" enctype="multipart/form-data">
                                    <div class="form-body">
                                        <div class="row p-t-20">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="control-label">Nama golongan Produk</label>
                                                    <input type="text" id="namagolongan" name="golongan_nm" class="form-control" placeholder="Input disini" required="">
                                                    <small class="form-control-feedback"> Contoh : starter, pizza, pasta dll </small> </div>
                                            </div>
                                        </div>
                                       
                                    </div>
                                    <div class="form-actions">
                                        <button id="simpangol" type="button" class="btn btn-success" onclick="simpan()"> <i class="fa fa-check"></i> Save</button>
                                        <button type="button" class="btn btn-inverse">Cancel</button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                   
                </div>
                <div class="row">
                    <div class="col-lg-12 col-md-12">
                        <div class="card">
                        	<div class="card-header bg-info">
                                <h4 class="m-b-0 text-white d-inline">Tabel Data golongan</h4>
                            </div>
                            <div class="card-body">
                               <div class="table-responsive">
                                    <table id="myTable" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th class="text-center">No</th>
                                                <th class="text-center">Nama golongan</th>
                                                <th class="text-center">Status</th>
                                                <th class="text-center">Tanggal Entri</th>
                                                <th class="text-center">Pegawai</th>
                                                <th class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        	<?php 
                                        		$no=1;
                                        		foreach ($golongan->getResult() as $k) {
                                        	?>

                                            <tr id="accordian-3">
                                                <td class="text-center"><?= $no++ ?></td>
                                                <td><a onclick="showedit(<?= $k->golongan_id ?>)"><span style="text-decoration:underline;" class="btn btn-link"><?= $k->golongan_nm ?></span></a>
                                                </td>
                                                <td class="text-center"><?= $k->status_cd ?></td>
                                                <td class="text-center"><?= $k->created_dttm ?></td>
                                                <td><?= $k->created_user ?></td>
                                                <td class="text-center">
                                                    <a onclick="showedit(<?= $k->golongan_id ?>)"><span style="text-decoration:underline;" class="btn btn-link">Edit</span></a> |
                                                    <a onclick="hapus(<?= $k->golongan_id ?>,'golongan')"><span style="text-decoration:underline;">Hapus</span></a>
                                                </td>
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

    var input = document.getElementById("namagolongan");
    input.addEventListener("keyup", function(event) {
      // Number 13 is the "Enter" key on the keyboard
      if (event.keyCode === 13) {
        event.preventDefault();
        document.getElementById("simpangol").click();
      }
    });


    function simpan() {
        var golongan_nm = $("input[name^='golongan_nm']").val();
        if (golongan_nm=='') {
        	Swal.fire({
            title:"Nama golongan harus di isi!!",
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
             ajaxData.append('golongan_nm',golongan_nm);
            $.ajax({
            url : "<?= base_url('golongan/save') ?>",
            type: "POST",
            data : ajaxData,
            contentType: false,
            processData: false,
            success:function(_data){
             if (_data=='already') {
                Swal.fire({
                    title:"Nama golongan sudah ada!!",
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
                 $( "#myTable" ).load("<?= base_url('golongan') ?> #myTable");
               // setTimeout(function(){ window.location.href = "<?=base_url()?>/golongan"; }, 1000);
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
     url : "<?= base_url('golongan/formedit') ?>",
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
     url : "<?= base_url('golongan/hapus') ?>",
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
        setTimeout(function(){ window.location.href = "<?=base_url()?>/golongan"; }, 1000);
    
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
	var golongan_nm = $('#golongan_nm').val();
    var golongan_id = $('#golongan_id').val();
        if (golongan_nm=='') {
        	Swal.fire({
                    title:"Nama golongan harus di isi!!",
                    text:"GAGAL!",
                    type:"warning",
                    showCancelButton:!0,
                    confirmButtonColor:"#556ee6",
                    cancelButtonColor:"#f46a6a"
                })
        } else {
            var ajaxData = new FormData();
             ajaxData.append('action','update-file');
             ajaxData.append('golongan_nm',golongan_nm);
             ajaxData.append('golongan_id',golongan_id);
            $.ajax({
            url : "<?= base_url('golongan/update') ?>",
            type: "POST",
            data : ajaxData,
            contentType: false,
            processData: false,
            success:function(_data){
             if (_data=='already') {
                Swal.fire({
                    title:"Nama golongan sudah ada!!",
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
                //setTimeout(function(){ window.location.href = "<?=base_url()?>/golongan"; }, 1000);
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