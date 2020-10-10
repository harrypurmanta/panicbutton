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
                                                    <label class="control-label">Nama kesatuan Produk</label>
                                                    <input type="text" id="namakesatuan" name="kesatuan_nm" class="form-control" placeholder="Input disini" required="">
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
                                <h4 class="m-b-0 text-white d-inline">Tabel Data kesatuan</h4>
                            </div>
                            <div class="card-body">
                               <div class="table-responsive">
                                    <table id="myTable" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th class="text-center">No</th>
                                                <th class="text-center">Nama kesatuan</th>
                                                <th class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        	<?php 
                                        		$no=1;
                                        		foreach ($kesatuan->getResult() as $k) {
                                        	?>

                                            <tr id="accordian-3">
                                                <td class="text-center"><?= $no++ ?></td>
                                                <td><a onclick="showedit(<?= $k->kesatuan_id ?>)"><span style="text-decoration:underline;" class="btn btn-link"><?= $k->kesatuan_nm ?></span></a>
                                                </td>
                                                <td class="text-center">
                                                    <a onclick="showedit(<?= $k->kesatuan_id ?>)"><span style="text-decoration:underline;" class="btn btn-link">Edit</span></a> |
                                                    <a onclick="hapus(<?= $k->kesatuan_id ?>,'kesatuan')"><span style="text-decoration:underline;" class="btn btn-link">Hapus</span></a>
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

    var input = document.getElementById("namakesatuan");
    input.addEventListener("keyup", function(event) {
      // Number 13 is the "Enter" key on the keyboard
      if (event.keyCode === 13) {
        event.preventDefault();
        document.getElementById("simpangol").click();
      }
    });


    function simpan() {
        var kesatuan_nm = $("input[name^='kesatuan_nm']").val();
        if (kesatuan_nm=='') {
        	Swal.fire({
            title:"Nama kesatuan harus di isi!!",
            text:"GAGAL!",
            type:"warning",
            showCancelButton:!0,
            confirmButtonColor:"#556ee6",
            cancelButtonColor:"#f46a6a"
                })
        } else {
             var ajaxData = new FormData();
             ajaxData.append('action','upload-file');
             ajaxData.append('kesatuan_nm',kesatuan_nm);
            $.ajax({
            url : "<?= base_url('kesatuan/save') ?>",
            type: "POST",
            data : ajaxData,
            contentType: false,
            processData: false,
            success:function(_data){
             if (_data=='already') {
                Swal.fire({
                    title:"Nama kesatuan sudah ada!!",
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
                 $( "#myTable" ).load("<?= base_url('kesatuan') ?> #myTable");
               // setTimeout(function(){ window.location.href = "<?=base_url()?>/kesatuan"; }, 1000);
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
     url : "<?= base_url('kesatuan/formedit') ?>",
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
    Swal.fire({
    title: 'Are you sure?',
    text: "You won't be able to revert this!",
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes, delete it!'
}).then((result) => {
    if (result.value == true) {
        
        $.ajax({
         url : "<?= base_url('kesatuan/hapus') ?>",
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
                     $( "#myTable" ).load("<?= base_url('kesatuan') ?> #myTable");
        
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
 })


}

function update(id) {
	var kesatuan_nm = $('#kesatuan_nm').val();
    var kesatuan_id = $('#kesatuan_id').val();
        if (kesatuan_nm=='') {
        	Swal.fire({
                    title:"Nama kesatuan harus di isi!!",
                    text:"GAGAL!",
                    type:"warning",
                    showCancelButton:!0,
                    confirmButtonColor:"#556ee6",
                    cancelButtonColor:"#f46a6a"
                })
        } else {
            var ajaxData = new FormData();
             ajaxData.append('action','update-file');
             ajaxData.append('kesatuan_nm',kesatuan_nm);
             ajaxData.append('kesatuan_id',kesatuan_id);
             ajaxData.append('id',id);
            $.ajax({
            url : "<?= base_url('kesatuan/update') ?>",
            type: "POST",
            data : ajaxData,
            contentType: false,
            processData: false,
            success:function(_data){
             if (_data=='already') {
                Swal.fire({
                    title:"Nama kesatuan sudah ada!!",
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
                 $( "#myTable" ).load("<?= base_url('kesatuan') ?> #myTable");
                //setTimeout(function(){ window.location.href = "<?=base_url()?>/kesatuan"; }, 1000);
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