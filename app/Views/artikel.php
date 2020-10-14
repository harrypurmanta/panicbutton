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
                                <h4 class="m-b-0 text-white d-inline">Tabel Data artikel</h4>
                                <button id="simpankat" type="button" class="btn btn-success d-inline-block float-right" onclick="tambahdata()"> <i class="fa fa-check"></i> Tambah Data</button>
                            </div>
                            <div class="card-body">
                               <div class="table-responsive">
                                    <table id="myTable" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th class="text-center">No</th>
                                                <th class="text-center">Nama artikel</th>
                                                <th class="text-center">Status</th>
                                                <th class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        	<?php 
                                        		$no=1;
                                        		foreach ($artikel->getResult() as $k) {
                                        	?>

                                            <tr id="accordian-3">
                                                <td class="text-center"><?= $no++ ?></td>
                                                <td><a onclick="showedit(<?= $k->artikel_id ?>)"><span style="text-decoration:underline;" class="btn btn-link"><?= $k->artikel_nm ?></span></a>
                                                </td>
                                                <td class="text-center"><?= $k->status_cd ?></td>
                                                <td class="text-center">
                                                    <a onclick="showedit(<?= $k->artikel_id ?>)"><span style="text-decoration:underline;" class="btn btn-link">Edit</span></a> |
                                                    <a onclick="hapus(<?= $k->artikel_id ?>,'artikel')"><span style="text-decoration:underline;" class="btn btn-link">Hapus</span></a>
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

    function tambahdata() {
    	$.ajax({
	     url : "<?= base_url('artikel/tambahdata') ?>",
	     type: "post",
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

    function simpan() {
        var artikel_nm = $('#artikel_nm').val();
		var category_id = $('#category_id').val();
		var description = $('#description').val();
     	var artikel_img = $('#artikel_img')[0].files[0];
        if (artikel_nm == "") {
        	Swal.fire({
            	title:"Judul artikel harus di isi!!",
            	text:"GAGAL!",
            	type:"warning",
            	showCancelButton:!0,
            	confirmButtonColor:"#556ee6",
            	cancelButtonColor:"#f46a6a"
            })
        } else if (artikel_img == "") {
         	Swal.fire({
            	title:"Gambar harus diisi!!",
            	text:"GAGAL!",
            	type:"warning",
            	showCancelButton:!0,
            	confirmButtonColor:"#556ee6",
            	cancelButtonColor:"#f46a6a"
            })
        } else {
            var ajaxData = new FormData();
            ajaxData.append('action','forms');
            ajaxData.append('artikel_nm',artikel_nm);
            ajaxData.append('category_id',category_id);
            ajaxData.append('artikel_img',artikel_img);
            ajaxData.append('description',description);
            $.ajax({
            url : "<?= base_url('artikel/save') ?>",
            type: "POST",
            data : ajaxData,
            contentType: false,
            processData: false,
            success:function(data){
            	if (data == "true") {
            		Swal.fire({
	                    title:"Berhasil!",
	                    text:"Data berhasil disimpan!",
	                    type:"success",
	                    showCancelButton:!0,
	                    confirmButtonColor:"#556ee6",
	                    cancelButtonColor:"#f46a6a"
	                })
	                $('#modaledit').modal('hide');
	                $( "#myTable" ).load("<?= base_url('artikel') ?> #myTable");
            	} else {
            		Swal.fire({
			            title:"Gagal!",
			            text:"Data gagal disimpan!",
			            type:"warning",
			            showCancelButton:!0,
			            confirmButtonColor:"#556ee6",
			            cancelButtonColor:"#f46a6a"
			        })
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
     url : "<?= base_url('artikel/formedit') ?>",
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
    Swal.fire({
    title: 'Are you sure?',
    text: "You won't be able to revert this!",
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes, order it!'
}).then((result) => {
    if (result.value == true) {
        $.ajax({
         url : "<?= base_url('artikel/hapus') ?>",
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
            $( "#myTable" ).load("<?= base_url('artikel') ?> #myTable");
        
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
	var artikel_nm = $('#artikel_nm').val();
	var category_id = $('#category_id').val();
	var description = $('#description').val();
    var artikel_img = $('#artikel_img')[0].files[0];
        if (artikel_nm=='') {
        	Swal.fire({
                    title:"Nama artikel harus di isi!!",
                    text:"GAGAL!",
                    type:"warning",
                    showCancelButton:!0,
                    confirmButtonColor:"#556ee6",
                    cancelButtonColor:"#f46a6a"
                })
        } else {
            var ajaxData = new FormData();
             ajaxData.append('action','update-file');
             ajaxData.append('action','forms');
            ajaxData.append('artikel_nm',artikel_nm);
            ajaxData.append('category_id',category_id);
            ajaxData.append('artikel_img',artikel_img);
            ajaxData.append('description',description);
             ajaxData.append('id',id);
            $.ajax({
            url : "<?= base_url('artikel/update') ?>",
            type: "POST",
            data : ajaxData,
            contentType: false,
            processData: false,
            success:function(data){
             	if (data == "true") {
            		Swal.fire({
	                    title:"Berhasil!",
	                    text:"Data berhasil disimpan!",
	                    type:"success",
	                    showCancelButton:!0,
	                    confirmButtonColor:"#556ee6",
	                    cancelButtonColor:"#f46a6a"
	                })
	                $('#modaledit').modal('hide');
	                $( "#myTable" ).load("<?= base_url('artikel') ?> #myTable");
            	} else {
            		Swal.fire({
			            title:"Gagal!",
			            text:"Data gagal disimpan!",
			            type:"warning",
			            showCancelButton:!0,
			            confirmButtonColor:"#556ee6",
			            cancelButtonColor:"#f46a6a"
			        })
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