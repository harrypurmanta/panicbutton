 
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
           
            <!-- ============================================================== -->
            <!-- End Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
 <!-- Row -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                
                                <!-- Nav tabs -->
                                <ul class="nav nav-tabs customtab2" role="tablist">
                                    <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#profile" role="tab" onclick="profile(<?= $id ?>)"><span class="hidden-sm-up"><i class="ti-home"></i></span> <span class="hidden-xs-down">Profile</span></a> </li>
                                    <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#account" role="tab" onclick="account(<?= $id ?>)"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Account</span></a> </li>
                                    <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#setting" role="tab"><span class="hidden-sm-up"><i class="ti-email"></i></span> <span class="hidden-xs-down">Setting</span></a> </li>
                                </ul>
                                <!-- Tab panes -->
                                <div class="tab-content tabcontent-border">
                                    <div class="tab-pane active" id="profile" role="tabpanel">
                                        
                                    </div>
                                    <div class="tab-pane p-20" id="account" role="tabpanel"></div>
                                    <div class="tab-pane p-20" id="setting" role="tabpanel">comming soon</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Row -->

			</div>
		</div>
<script src="../../assets/plugins/jquery/jquery.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {

	var id = <?php
	if ($id == "") {
		echo 'null';
	} else {
		echo $id;
	}
	 ?>;
	profile(id);        
});

function simpanuser(id){
        var user_nm = $('#user_nm').val();
        var pwd0 = $('#pwd0').val();
        var user_group = $('#user_group').val();
        if (user_nm==''||pwd0=='') {
        	Swal.fire({
                    title:"username & Password harus di isi!!",
                    text:"GAGAL!",
                    type:"warning",
                    showCancelButton:!0,
                    confirmButtonColor:"#556ee6",
                    cancelButtonColor:"#f46a6a"
                })
        } else {
            $.ajax({
            url : "<?= base_url('employee/simpanuser') ?>",
            type: "post",
            data : {'user_nm':user_nm,'pwd0':pwd0,'id':id,'user_group':user_group},
            success:function(_data){
             if (_data=='already') {
                Swal.fire({
                    title:"Nomor Identitas sudah ada!!",
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
                account(id);
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

function updateuser(id,uid) {
    var user_nm = $('#user_nm').val();
        var pwd0 = $('#pwd0').val();
        var user_group = $('#user_group').val();
        if (user_nm==''||pwd0=='') {
            Swal.fire({
                    title:"username & Password harus di isi!!",
                    text:"GAGAL!",
                    type:"warning",
                    showCancelButton:!0,
                    confirmButtonColor:"#556ee6",
                    cancelButtonColor:"#f46a6a"
                })
        } else {
            $.ajax({
            url : "<?= base_url('employee/updateuser') ?>",
            type: "post",
            data : {'user_nm':user_nm,'pwd0':pwd0,'id':id,'uid':uid,'user_group':user_group},
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
                    account(id);
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

function formtambahuser(id){
	$.ajax({
        url : "<?= base_url();?>/employee/formtambahuser",
        type: "post",
        data : {'id':id},
        success:function(data){
                    $('#account').html(data);
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

function profile(id){
	 $.ajax({
        url : "<?= base_url();?>/employee/profiletab",
        type: "post",
        data : {'id':id},
        success:function(data){
          $('#profile').html(data);
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

function account(id){
	 $.ajax({
                url : "<?= base_url();?>/employee/accounttab",
                type: "post",
                data : {'id':id},
                success:function(data){
                    $('#account').html(data);
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
	    var person_id = $('#person_id').val();
        var person_nm = $('#person_nm').val();
        var ext_id = $('#ext_id').val();
        var gender_cd = $('#gender_cd').val();
        var birth_dttm = $('#birth_dttm').val();
        var birth_dttm_old = $('#birth_dttm_old').val();
        var birth_place = $('#birth_place').val();
        var cellphone = $('#cellphone').val();
        var addr_txt = $('#addr_txt').val();
        var employee_ext_id = $('#employee_ext_id').val();
        var pangkat = $('#pangkat').val();
        var kesatuan = $('#kesatuan').val();
        var image_nm = $('#image_nm')[0].files[0];
        if (person_nm == "") {
        	Swal.fire({
                    title:"Nama harus di isi!!",
                    text:"GAGAL!",
                    type:"warning",
                    showCancelButton:!0,
                    confirmButtonColor:"#556ee6",
                    cancelButtonColor:"#f46a6a"
                })
        } else if (employee_ext_id == "") {
            Swal.fire({
                title:"NRP/NIP harus di isi!!",
                text:"GAGAL!",
                type:"warning",
                showCancelButton:!0,
                confirmButtonColor:"#556ee6",
                cancelButtonColor:"#f46a6a"
            })
        } else {
            var ajaxData = new FormData();
            ajaxData.append('person_id',person_id);
            ajaxData.append('person_nm',person_nm);
            ajaxData.append('ext_id',ext_id);
            ajaxData.append('gender_cd',gender_cd);
            ajaxData.append('birth_dttm',birth_dttm);
            ajaxData.append('birth_dttm_old',birth_dttm_old);
            ajaxData.append('birth_place',birth_place);
            ajaxData.append('cellphone',cellphone);
            ajaxData.append('addr_txt',addr_txt);
            ajaxData.append('employee_ext_id',employee_ext_id);
            ajaxData.append('pangkat',pangkat);
            ajaxData.append('kesatuan',kesatuan);
            ajaxData.append('image_nm',image_nm);
            $.ajax({
            url : "<?= base_url('employee/save') ?>",
            type: "post",
            data : ajaxData,
            contentType: false,
            processData: false,
            success:function(data){
                Swal.fire({
                    title:"Berhasil!",
                    text:"Data berhasil disimpan!",
                    type:"success",
                    showCancelButton:!0,
                    confirmButtonColor:"#556ee6",
                    cancelButtonColor:"#f46a6a"
                })
                setTimeout(function(){ window.location.href = "<?=base_url()?>/employee/formdaftaremployee/"+data; }, 1000);
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