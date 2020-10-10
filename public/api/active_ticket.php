	<?php
 	defined('BASEPATH') OR exit('No direct script access allowed');
 	?>
	<?php
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=Laporan helpdesk tiket Aktif.xls");
	header("Pragma:no-cache");
	header("Expires: 0");
	?>
 
	<center>
		<h1>LAPORAN BULANAN</h1>
	</center>
 
	<table border="1">
		<tr>
			<th>No</th>
			<th>Ticket Id </th>
			<th>Track Id</th>
			<th>Kategori</th>
			<th>User Pelapor</th>
			<th>Unit Pelapor</th>
			<th>Waktu Pelaporan</th>
			<th>Waktu Penugasan</th>
			<th>Respon Time</th>
			<th>Judul Tiket</th>
			<th>Isi Tiket</th>
			<th>Prioritas</th>
			<th>Petugas</th>
			<th>Hasil Tindakan</th>
			<th>Diskusi Terakhir</th>
			<th>Waktu Tindak Lanjut</th>
			<th>Status</th>
			<th>Note</th>
		</tr>
		<?php
			$no=1;
			foreach ($data as $row) {
				$awal  = strtotime($row->waktu_penugasan); //waktu awal
				$akhir = strtotime($row->waktu_pelaporan); //waktu akhir
				$diff  = $awal - $akhir;
				$jam   = floor($diff / (60 * 60));
				$menit = $diff - $jam * (60 * 60);
		?>
		<tr>
			<td><?= $no;$no++?></td>
			<td><?= $row->id ?></td>
			<td><?= $row->track_id ?></td>
			<td><?= $row->kategori ?></td>
			<td><?= $row->nama_depan ?> <?= $row->nama_Belakang ?></td>
			<td><?= $row->unit ?></td>
			<td><?= $row->waktu_pelaporan ?></td>
			<td><?= $row->waktu_penugasan ?></td>
			<?php 
				if($jam < 0){

					echo "<td> 0 Jam  ".floor( $menit / 60 )." Menit</td>";
				}else{
					
					echo "<td> $jam Jam ".floor( $menit / 60 )." Menit</td>";
				}

			?>
			<td><?= $row->judul_tiket ?></td>
			<td><?= $row->isi_tiket ?></td>
			<?php
				if($row->priotitas == L){
				echo "<td>Low</td>";
					}else if($row->priotitas == M){
					echo "<td>Low</td>";
					}else if($row->priotitas == H){
					echo "<td>High</td>";
					}else{
						echo "<td>Urgent</td>";
					}
			?>
			<td><?= $row->ditugaskan ?></td>
			<td><?= $row->hasil_tindakan ?></td>
			<td><?= $row->diskusi_terakhir ?></td>
			<td><?= $row->waktu_tindak_lanjut ?></td>
			<?php
				if($row->status == N){
				echo "<td>New</td>";
					}else if($row->status == C){
					echo "<td>Closed</td>";
					}else if($row->status == P){
					echo "<td>In- Progress</td>";
					}else{
						echo "<td>Re-open</td>";
					}
			?>
			<td>
				<?php
					$get_note = $this->M_Report->get_note($row->id);
					foreach ($get_note as $hasil) {
				?>
					<ul>(*) <?= $hasil->catatan ?> <i>(<?= $hasil->nama ?>)</i>
						<br> <b><?= $hasil->waktu ?> Menit</b> <i><?= $hasil->tanggal ?></i>
					</ul>		

				<?php }?>		
			</td>
		</tr>

		<?php } ?>
	</table>
