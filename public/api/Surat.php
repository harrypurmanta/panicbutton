<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Surat extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_Suratmasuk');
		$this->load->model('M_pushnotif');
	}

	function pendek($date)
	{
		$BulanIndo = array("Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Ags", "Sep", "Okt", "Nov", "Des");

		$tahun = substr($date, 0, 4);
		$bulan = substr($date, 5, 2);
		$tgl   = substr($date, 8, 2);

		$result = $tgl . " " . $BulanIndo[(int) $bulan - 1] . " " . $tahun;
		return ($result);
	}
	function panjang($date)
	{
		$BulanIndo = array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");

		$tahun = substr($date, 0, 4);
		$bulan = substr($date, 5, 2);
		$tgl   = substr($date, 8, 2);

		$result = $tgl . " " . $BulanIndo[(int) $bulan - 1] . " " . $tahun;
		return ($result);
	}


	public function getSuratSort()
	{
		$idUser = $this->uri->segment(3);
		$date = $this->uri->segment(4);
		$tipeSurat = $this->uri->segment(5);

		$dateStart = $date . '-01 00:00:00';
		$dateEnd = $date . '-31 23:59:59';

		$res = $this->M_Suratmasuk->getSuratSort($tipeSurat, $idUser, $dateStart, $dateEnd);
		if ($res == true) {
			foreach ($res as $data) {
				$tanggalSuratTxt = $data->tglSurat;
				if ($tanggalSuratTxt == '0000-00-00') {
					$tglSurat = 'Tidak ada tanggal surat';
				} else {
					$tglSurat = $this->panjang($tanggalSuratTxt);
				}

				$tanggalTempoTxt = $data->tglTempo;
				if ($tanggalTempoTxt == '0000-00-00') {
					$tglTempo = 'Tidak ada jatuh tempo';
				} else {
					$tglTempo = $this->panjang($tanggalTempoTxt);
				}

				$created_date = $data->created_date;
				$tglEntri = $this->pendek($created_date);


				$read = $data->read_status;
				$status_surat = $data->status_surat;
				$resaction = $this->M_Suratmasuk->getaction2($data->idSurat, $idUser);
				if ($resaction[0]->receive_user_id != $idUser) {
					$action = $data->action;
					if ($data->status_surat == 'finish') {
						$actionTxt = 'Selesai';
					} else {
						if ($action == 'belum' && $status_surat == 'normal') {
							$actionTxt = 'Belum Ditindaklanjuti';
						} else if (($action == 'sudah' && $status_surat == 'normal') || ($action == 'setuju')) {
							$actionTxt = 'Proses di';
						} else if (($action == 'batal' || $action == 'dibatalkan') && $status_surat == 'normal') {
							$actionTxt = 'Dibatalkan';
						} else if (($action == 'revisi' && $status_surat == 'normal')) {
							$actionTxt = 'Proses Revisi di';
						} else if ($action == 'proses_revisi' && $status_surat == 'normal') {
							$actionTxt = 'Revisi';
						} else if ($action == 'belum' && $status_surat == 'rejected') {
							$actionTxt = 'Ditolak';
						}
					}
				} else {
					$action = $resaction[0]->action;
					if ($data->status_surat == 'finish') {
						$actionTxt = 'Selesai';
					} else {
						if ($action == 'belum' && $status_surat == 'normal') {
							$actionTxt = 'Belum Ditindaklanjuti';
						} else if (($action == 'sudah' && $status_surat == 'normal') || ($action == 'setuju')) {
							$actionTxt = 'Proses di';
						} else if (($action == 'batal' || $action == 'dibatalkan') && $status_surat == 'normal') {
							$actionTxt = 'Dibatalkan';
						} else if (($action == 'revisi' && $status_surat == 'normal')) {
							$actionTxt = 'Proses Revisi di';
						} else if ($action == 'proses_revisi' && $status_surat == 'normal') {
							$actionTxt = 'Revisi';
						} else if ($action == 'belum' && $status_surat == 'rejected') {
							$actionTxt = 'Ditolak';
						}
					}
				}

				$readStatus = $resaction[0]->read_status;

				$created_dttm = $resaction[0]->created_dttm;
				$tglRespon = $this->pendek($created_dttm);

				$judul = $data->koresponden;
				$title = substr($judul, 0, 1);

				$koresponden = $data->koresponden;
				$jmlKores = strlen($koresponden);
				if ($jmlKores >= 35) {
					$subkores = substr($koresponden, 0, 30);
					$koresTxt = strtoupper($subkores . '...');
				} else {
					$koresTxt = strtoupper($koresponden);
				}

				$perihal = $data->perihal;
				$jmlPerihal = strlen($perihal);
				if ($jmlPerihal >= 35) {
					$subperihal = substr($perihal, 0, 35);
					$perihalTxt = $subperihal . '...';
				} else {
					$perihalTxt = $perihal;
				}

				$nmSifat = $data->nmSifat;
				$resLastUser = $this->M_Suratmasuk->getLastUser($data->idSurat);
				$lastUser = $resLastUser[0]->jabLastUser;
				$resLastDate = $this->M_Suratmasuk->getaction($data->idSurat, $idUser);
				$tglResponsLast = $this->pendek($resLastDate[0]->created_dttm);
				$ret[] = array(
					'message' => 'Sukses',
					'idResponse' => $data->idResponse,
					'idSurat' => $data->idSurat,
					'tipe' => $data->tipe,
					'trackID' => $data->trackID,
					'koresponden' => $koresTxt,
					'perihal' => $perihalTxt,
					'tglEntri' => $tglEntri,
					'tglSurat' => $tglSurat,
					'tglTempo' => $tglTempo,
					'tglRespon' => $tglResponsLast,
					'status_surat' => $status_surat,
					'nmSifat' => $nmSifat,
					'read_status' => $readStatus,
					'title' => $title,
					'action' => $actionTxt,
					'jumlah_huruf' => $jmlKores,
					'lastUser' => $lastUser,
				);
			}
		} else {
			$ret[] = array(
				'message' => 'Gagal',
			);
		}

		echo json_encode($ret);
	}

	public function getSuratAll()
	{
		$idUser = $this->uri->segment(3);
		$tipeSurat = $this->uri->segment(4);
		$limit = $this->uri->segment(5);
		$start = $this->uri->segment(6);

		$res1 = $this->M_Suratmasuk->getSuratAllTemp($tipeSurat, $idUser);
		$Jumlah_data =	count($res1);
		$res = $this->M_Suratmasuk->getSuratAll($tipeSurat, $idUser, $limit, $start);

		if ($res == true) {
			foreach ($res as $data) {
				$tanggalSuratTxt = $data->tglSurat;
				if ($tanggalSuratTxt == '0000-00-00') {
					$tglSurat = 'Tidak ada tanggal surat';
				} else {
					$tglSurat = $this->panjang($tanggalSuratTxt);
				}

				$tanggalTempoTxt = $data->tglTempo;
				if ($tanggalTempoTxt == '0000-00-00') {
					$tglTempo = 'Tidak ada jatuh tempo';
				} else {
					$tglTempo = $this->panjang($tanggalTempoTxt);
				}

				$created_date = $data->created_date;
				$tglEntri = $this->pendek($created_date);


				$read = $data->read_status;
				$status_surat = $data->status_surat;
				$resaction = $this->M_Suratmasuk->getaction2($data->idSurat, $idUser);
				if ($resaction[0]->receive_user_id != $idUser) {
					$action = $data->action;
					if ($data->status_surat == 'finish') {
						$actionTxt = 'Selesai';
					} else {
						if ($action == 'belum' && $status_surat == 'normal') {
							$actionTxt = 'Belum Ditindaklanjuti';
						} else if (($action == 'sudah' && $status_surat == 'normal') || ($action == 'setuju')) {
							$actionTxt = 'Proses di';
						} else if (($action == 'batal' || $action == 'dibatalkan') && $status_surat == 'normal') {
							$actionTxt = 'Dibatalkan';
						} else if (($action == 'revisi' && $status_surat == 'normal')) {
							$actionTxt = 'Proses Revisi di';
						} else if ($action == 'proses_revisi' && $status_surat == 'normal') {
							$actionTxt = 'Revisi';
						} else if ($action == 'belum' && $status_surat == 'rejected') {
							$actionTxt = 'Ditolak';
						}
					}
				} else {
					$action = $resaction[0]->action;
					if ($data->status_surat == 'finish') {
						$actionTxt = 'Selesai';
					} else {
						if ($action == 'belum' && $status_surat == 'normal') {
							$actionTxt = 'Belum Ditindaklanjuti';
						} else if (($action == 'sudah' && $status_surat == 'normal') || ($action == 'setuju')) {
							$actionTxt = 'Proses di';
						} else if (($action == 'batal' || $action == 'dibatalkan') && $status_surat == 'normal') {
							$actionTxt = 'Dibatalkan';
						} else if (($action == 'revisi' && $status_surat == 'normal')) {
							$actionTxt = 'Proses Revisi di';
						} else if ($action == 'proses_revisi' && $status_surat == 'normal') {
							$actionTxt = 'Revisi';
						} else if ($action == 'belum' && $status_surat == 'rejected') {
							$actionTxt = 'Ditolak';
						}
					}
				}

				$readStatus = $resaction[0]->read_status;

				$created_dttm = $resaction[0]->created_dttm;
				$tglRespon = $this->pendek($created_dttm);

				$judul = $data->koresponden;
				$title = substr($judul, 0, 1);

				$koresponden = $data->koresponden;
				$jmlKores = strlen($koresponden);
				if ($jmlKores >= 35) {
					$subkores = substr($koresponden, 0, 30);
					$koresTxt = strtoupper($subkores . '...');
				} else {
					$koresTxt = strtoupper($koresponden);
				}

				$perihal = $data->perihal;
				$jmlPerihal = strlen($perihal);
				if ($jmlPerihal >= 35) {
					$subperihal = substr($perihal, 0, 35);
					$perihalTxt = $subperihal . '...';
				} else {
					$perihalTxt = $perihal;
				}

				$nmSifat = $data->nmSifat;
				$resLastUser = $this->M_Suratmasuk->getLastUser($data->idSurat);
				$lastUser = $resLastUser[0]->jabLastUser;

				$ret[] = array(
					'message' => 'Sukses',
					'idResponse' => $data->idResponse,
					'idSurat' => $data->idSurat,
					'tipe' => $data->tipe,
					'trackID' => $data->trackID,
					'koresponden' => $koresTxt,
					'perihal' => $perihalTxt,
					'tglEntri' => $tglEntri,
					'tglSurat' => $tglSurat,
					'tglTempo' => $tglTempo,
					'tglRespon' => $tglRespon,
					'status_surat' => $status_surat,
					'nmSifat' => $nmSifat,
					'read_status' => $readStatus,
					'title' => $title,
					'action' => $actionTxt,
					'jumlah_huruf' => $jmlKores,
					'Jumlah_data' => $Jumlah_data,
					'lastUser' => $lastUser,
				);
			}
		} else {
			$ret[] = array(
				'message' => 'Gagal',
			);
		}

		echo json_encode($ret);
	}


	public function getSuratBelumTL()
	{
		$idUser = $this->uri->segment(3);
		$tipeSurat = $this->uri->segment(4);
		$limit = $this->uri->segment(5);
		$start = $this->uri->segment(6);

		$res1 = $this->M_Suratmasuk->getSuratBelumTLTemp($tipeSurat, $idUser);
		$Jumlah_data =	count($res1);
		$res = $this->M_Suratmasuk->getSuratBelumTL($tipeSurat, $idUser, $limit, $start);

		if ($res == true) {
			foreach ($res as $data) {
				$tanggalSuratTxt = $data->tglSurat;
				if ($tanggalSuratTxt == '0000-00-00') {
					$tglSurat = 'Tidak ada tanggal surat';
				} else {
					$tglSurat = $this->panjang($tanggalSuratTxt);
				}

				$tanggalTempoTxt = $data->tglTempo;
				if ($tanggalTempoTxt == '0000-00-00') {
					$tglTempo = 'Tidak ada jatuh tempo';
				} else {
					$tglTempo = $this->panjang($tanggalTempoTxt);
				}

				$created_date = $data->created_date;
				$tglEntri = $this->pendek($created_date);

				$created_dttm = $data->created_dttm;
				$tglRespon = $this->pendek($created_dttm);

				$status_surat = $data->status_surat;
				$resaction = $this->M_Suratmasuk->getaction($data->idSurat, $idUser);
				$action = $resaction[0]->action;
				if ($action == 'belum' && $status_surat == 'normal') {
					$actionTxt = 'Belum Ditindaklanjuti';
				}

				$judul = $data->koresponden;
				$title = substr($judul, 0, 1);

				$koresponden = $data->koresponden;
				$jmlKores = strlen($koresponden);
				if ($jmlKores >= 35) {
					$subkores = substr($koresponden, 0, 30);
					$koresTxt = strtoupper($subkores . '...');
				} else {
					$koresTxt = strtoupper($koresponden);
				}

				$perihal = $data->perihal;
				$jmlPerihal = strlen($perihal);
				if ($jmlPerihal >= 35) {
					$subperihal = substr($perihal, 0, 35);
					$perihalTxt = $subperihal . '...';
				} else {
					$perihalTxt = $perihal;
				}

				$nmSifat = $data->nmSifat;

				$ret[] = array(
					'message' => 'Sukses',
					'idResponse' => $data->idResponse,
					'idSurat' => $data->idSurat,
					'tipe' => $data->tipe,
					'trackID' => $data->trackID,
					'koresponden' => $koresTxt,
					'perihal' => $perihalTxt,
					'tglEntri' => $tglEntri,
					'tglSurat' => $tglSurat,
					'tglTempo' => $tglTempo,
					'tglRespon' => $tglRespon,
					'status_surat' => $status_surat,
					'nmSifat' => $nmSifat,
					'read_status' => $data->read_status,
					'title' => $title,
					'action' => $actionTxt,
					'jumlah_huruf' => $jmlKores,
					'Jumlah_data' => $Jumlah_data,
				);
			}
		} else {
			$ret[] = array(
				'message' => 'Gagal',
			);
		}

		echo json_encode($ret);
	}

	public function getRevisi()
	{
		$idUser = $this->uri->segment(3);
		$tipeSurat = $this->uri->segment(4);
		$limit = $this->uri->segment(5);
		$start = $this->uri->segment(6);

		$res1 = $this->M_Suratmasuk->getSuratRevisiTemp($tipeSurat, $idUser);
		$Jumlah_data =	count($res1);
		$res = $this->M_Suratmasuk->getSuratRevisi($tipeSurat, $idUser, $limit, $start);

		if ($res == true) {
			foreach ($res as $data) {
				$tanggalSuratTxt = $data->tglSurat;
				if ($tanggalSuratTxt == '0000-00-00') {
					$tglSurat = 'Tidak ada tanggal surat';
				} else {
					$tglSurat = $this->panjang($tanggalSuratTxt);
				}

				$tanggalTempoTxt = $data->tglTempo;
				if ($tanggalTempoTxt == '0000-00-00') {
					$tglTempo = 'Tidak ada jatuh tempo';
				} else {
					$tglTempo = $this->panjang($tanggalTempoTxt);
				}

				$created_date = $data->created_date;
				$tglEntri = $this->pendek($created_date);

				$created_dttm = $data->created_dttm;
				$tglRespon = $this->pendek($created_dttm);

				$status_surat = $data->status_surat;
				$resaction = $this->M_Suratmasuk->getaction($data->idSurat, $idUser);
				$action = $resaction[0]->action;
				if ($action == 'proses_revisi' && $status_surat == 'normal') {
					$actionTxt = 'Revisi';
				}

				$judul = $data->koresponden;
				$title = substr($judul, 0, 1);

				$koresponden = $data->koresponden;
				$jmlKores = strlen($koresponden);
				if ($jmlKores >= 35) {
					$subkores = substr($koresponden, 0, 30);
					$koresTxt = strtoupper($subkores . '...');
				} else {
					$koresTxt = strtoupper($koresponden);
				}

				$perihal = $data->perihal;
				$jmlPerihal = strlen($perihal);
				if ($jmlPerihal >= 35) {
					$subperihal = substr($perihal, 0, 35);
					$perihalTxt = $subperihal . '...';
				} else {
					$perihalTxt = $perihal;
				}

				$nmSifat = $data->nmSifat;

				$ret[] = array(
					'message' => 'Sukses',
					'idResponse' => $data->idResponse,
					'idSurat' => $data->idSurat,
					'tipe' => $data->tipe,
					'trackID' => $data->trackID,
					'koresponden' => $koresTxt,
					'perihal' => $perihalTxt,
					'tglEntri' => $tglEntri,
					'tglSurat' => $tglSurat,
					'tglTempo' => $tglTempo,
					'tglRespon' => $tglRespon,
					'status_surat' => $status_surat,
					'nmSifat' => $nmSifat,
					'read_status' => $data->read_status,
					'title' => $title,
					'action' => $actionTxt,
					'jumlah_huruf' => $jmlKores,
					'Jumlah_data' => $Jumlah_data,
				);
			}
		} else {
			$ret[] = array(
				'message' => 'Gagal',
			);
		}

		echo json_encode($ret);
	}

	public function getSuratSudahTL()
	{
		$idUser = $this->uri->segment(3);
		$tipeSurat = $this->uri->segment(4);
		$limit = $this->uri->segment(5);
		$start = $this->uri->segment(6);
		$res1 = $this->M_Suratmasuk->getSuratSudahTLTemp($tipeSurat, $idUser);
		$Jumlah_data = count($res1);
		// echo json_encode($res1),exit;
		$res = $this->M_Suratmasuk->getSuratSudahTL($tipeSurat, $idUser, $limit, $start);


		if ($res == true) {
			foreach ($res as $data) {
				$tanggalSuratTxt = $data->tglSurat;
				if ($tanggalSuratTxt == '0000-00-00') {
					$tglSurat = 'Tidak ada tanggal surat';
				} else {
					$tglSurat = $this->panjang($tanggalSuratTxt);
				}


				$tanggalTempoTxt = $data->tglTempo;
				if ($tanggalTempoTxt == '0000-00-00') {
					$tglTempo = 'Tidak ada jatuh tempo';
				} else {
					$tglTempo = $this->panjang($tanggalTempoTxt);
				}

				$created_date = $data->created_date;
				$tglEntri = $this->pendek($created_date);


				$read = $data->read_status;
				$status_surat = $data->status_surat;
				$resaction = $this->M_Suratmasuk->getLastUser($data->idSurat, $idUser);
				$action = $resaction[0]->action;
				$lastUser = $resaction[0]->jabLastUser;

				if ($action == 'belum' && $status_surat == 'normal') {
					$actionTxt = 'Proses di';
				} else if ($action == 'proses_revisi' && $status_surat == 'normal') {
					$actionTxt = 'Proses Revisi di';
				}

				$created_dttm = $resaction[0]->created_dttm;
				$tglRespon = $this->pendek($created_dttm);

				$judul = $data->koresponden;
				$title = substr($judul, 0, 1);

				$koresponden = $data->koresponden;
				$jmlKores = strlen($koresponden);
				if ($jmlKores >= 35) {
					$subkores = substr($koresponden, 0, 30);
					$koresTxt = strtoupper($subkores . '...');
				} else {
					$koresTxt = strtoupper($koresponden);
				}

				$perihal = $data->perihal;
				$jmlPerihal = strlen($perihal);
				if ($jmlPerihal >= 35) {
					$subperihal = substr($perihal, 0, 35);
					$perihalTxt = $subperihal . '...';
				} else {
					$perihalTxt = $perihal;
				}

				$nmSifat = $data->nmSifat;

				$ret[] = array(
					'message' => 'Sukses',
					'idResponse' => $data->idResponse,
					'idSurat' => $data->idSurat,
					'tipe' => $data->tipe,
					'trackID' => $data->trackID,
					'koresponden' => $koresTxt,
					'perihal' => $perihalTxt,
					'tglEntri' => $tglEntri,
					'tglSurat' => $tglSurat,
					'tglTempo' => $tglTempo,
					'tglRespon' => $tglRespon,
					'status_surat' => $status_surat,
					'nmSifat' => $nmSifat,
					'read_status' => $data->read_status,
					'title' => $title,
					'action' => $actionTxt,
					'actionAsli' => $action,
					'jumlah_huruf' => $jmlKores,
					'Jumlah_data' => $Jumlah_data,
					'lastUser' => $lastUser,
				);
			}
		} else {
			$ret[] = array('message' => 'Gagal',);
		}

		echo json_encode($ret);
	}

	public function getSuratBatal()
	{
		$idUser = $this->uri->segment(3);
		$tipeSurat = $this->uri->segment(4);
		$limit = $this->uri->segment(5);
		$start = $this->uri->segment(6);

		$res1 = $this->M_Suratmasuk->getSuratBatalTemp($tipeSurat, $idUser);
		$Jumlah_data =	count($res1);
		$res = $this->M_Suratmasuk->getSuratBatal($tipeSurat, $idUser, $limit, $start);

		if ($res == true) {
			foreach ($res as $data) {
				$tanggalSuratTxt = $data->tglSurat;
				if ($tanggalSuratTxt == '0000-00-00') {
					$tglSurat = 'Tidak ada tanggal surat';
				} else {
					$tglSurat = $this->panjang($tanggalSuratTxt);
				}

				$tanggalTempoTxt = $data->tglTempo;
				if ($tanggalTempoTxt == '0000-00-00') {
					$tglTempo = 'Tidak ada jatuh tempo';
				} else {
					$tglTempo = $this->panjang($tanggalTempoTxt);
				}

				$created_date = $data->created_date;
				$tglEntri = $this->pendek($created_date);

				$created_dttm = $data->created_dttm;
				$tglRespon = $this->pendek($created_dttm);

				$read = $data->read_status;
				$status_surat = $data->status_surat;
				$resaction = $this->M_Suratmasuk->getLastUser($data->idSurat, $idUser);
				$action = $resaction[0]->action;
				if (($action == 'batal' || $action == 'dibatalkan') && $status_surat == 'normal') {
					$actionTxt = 'Dibatalkan';
				}

				$judul = $data->koresponden;
				$title = substr($judul, 0, 1);

				$koresponden = $data->koresponden;
				$jmlKores = strlen($koresponden);
				if ($jmlKores >= 35) {
					$subkores = substr($koresponden, 0, 30);
					$koresTxt = strtoupper($subkores . '...');
				} else {
					$koresTxt = strtoupper($koresponden);
				}

				$perihal = $data->perihal;
				$jmlPerihal = strlen($perihal);
				if ($jmlPerihal >= 35) {
					$subperihal = substr($perihal, 0, 35);
					$perihalTxt = $subperihal . '...';
				} else {
					$perihalTxt = $perihal;
				}

				$nmSifat = $data->nmSifat;

				$ret[] = array(
					'message' => 'Sukses',
					'idResponse' => $data->idResponse,
					'idSurat' => $data->idSurat,
					'tipe' => $data->tipe,
					'trackID' => $data->trackID,
					'koresponden' => $koresTxt,
					'perihal' => $perihalTxt,
					'tglEntri' => $tglEntri,
					'tglSurat' => $tglSurat,
					'tglTempo' => $tglTempo,
					'tglRespon' => $tglRespon,
					'status_surat' => $status_surat,
					'nmSifat' => $nmSifat,
					'read_status' => $data->read_status,
					'title' => $title,
					'action' => $actionTxt,
					'jumlah_huruf' => $jmlKores,
					'Jumlah_data' => $Jumlah_data,
				);
			}
		} else {
			$ret[] = array(
				'message' => 'Gagal',
			);
		}

		echo json_encode($ret);
	}

	public function getSuratSelesai()
	{
		$idUser = $this->uri->segment(3);
		$tipeSurat = $this->uri->segment(4);
		$limit = $this->uri->segment(5);
		$start = $this->uri->segment(6);

		$res1 = $this->M_Suratmasuk->getSuratSelesaiTemp($tipeSurat, $idUser);
		$Jumlah_data =	count($res1);
		$res = $this->M_Suratmasuk->getSuratSelesai($tipeSurat, $idUser, $limit, $start);

		// echo json_encode($res),exit;
		if ($res == true) {
			foreach ($res as $data) {
				$tanggalSuratTxt = $data->tglSurat;
				if ($tanggalSuratTxt == '0000-00-00') {
					$tglSurat = 'Tidak ada tanggal surat';
				} else {
					$tglSurat = $this->panjang($tanggalSuratTxt);
				}

				$tanggalTempoTxt = $data->tglTempo;
				if ($tanggalTempoTxt == '0000-00-00') {
					$tglTempo = 'Tidak ada jatuh tempo';
				} else {
					$tglTempo = $this->panjang($tanggalTempoTxt);
				}

				$created_date = $data->created_date;
				$tglEntri = $this->pendek($created_date);

				$created_dttm = $data->created_dttm;
				$tglRespon = $this->pendek($created_dttm);

				$read = $data->read_status;
				$status_surat = $data->status_surat;
				$resaction = $this->M_Suratmasuk->getLastUser($data->idSurat, $idUser);
				$action = $resaction[0]->action;
				if ($action == 'belum' && $status_surat == 'normal') {
					$actionTxt = 'Belum Ditindaklanjuti';
					$color = '#F39C12';
				} else if ($action == 'sudah' && $status_surat == 'normal') {
					$actionTxt = 'Sudah Ditindaklanjuti';
					$color = '#3498DB';
				} else if (($action == 'batal' || $action == 'dibatalkan') && $status_surat == 'normal') {
					$actionTxt = 'Dibatalkan';
					$color = '#95A5A6';
				} else if ($status_surat == 'finish') {
					$actionTxt = 'Selesai';
					$color = '#27AE60';
				}

				$judul = $data->koresponden;
				$title = substr($judul, 0, 1);

				$koresponden = $data->koresponden;
				$jmlKores = strlen($koresponden);
				if ($jmlKores >= 35) {
					$subkores = substr($koresponden, 0, 30);
					$koresTxt = strtoupper($subkores . '...');
				} else {
					$koresTxt = strtoupper($koresponden);
				}

				$perihal = $data->perihal;
				$jmlPerihal = strlen($perihal);
				if ($jmlPerihal >= 35) {
					$subperihal = substr($perihal, 0, 35);
					$perihalTxt = $subperihal . '...';
				} else {
					$perihalTxt = $perihal;
				}

				$nmSifat = $data->nmSifat;

				$ret[] = array(
					'message' => 'Sukses',
					'idResponse' => $data->idResponse,
					'idSurat' => $data->idSurat,
					'tipe' => $data->tipe,
					'trackID' => $data->trackID,
					'koresponden' => $koresTxt,
					'perihal' => $perihalTxt,
					'tglEntri' => $tglEntri,
					'tglSurat' => $tglSurat,
					'tglTempo' => $tglTempo,
					'tglRespon' => $tglRespon,
					'status_surat' => $status_surat,
					'nmSifat' => $nmSifat,
					'read_status' => $data->read_status,
					'title' => $title,
					'action' => $actionTxt,
					'jumlah_huruf' => $jmlKores,
					'Jumlah_data' => $Jumlah_data,
				);
			}
		} else {
			$ret[] = array(
				'message' => 'Gagal',
			);
		}

		echo json_encode($ret);
	}

	public function getSuratTolak()
	{
		$idUser = $this->uri->segment(3);
		$tipeSurat = $this->uri->segment(4);
		$limit = $this->uri->segment(5);
		$start = $this->uri->segment(6);

		$res1 = $this->M_Suratmasuk->getSuratTolakTemp($tipeSurat, $idUser);
		$Jumlah_data =	count($res1);
		$res = $this->M_Suratmasuk->getSuratTolak($tipeSurat, $idUser, $limit, $start);

		if ($res == true) {
			foreach ($res as $data) {
				$tanggalSuratTxt = $data->tglSurat;
				if ($tanggalSuratTxt == '0000-00-00') {
					$tglSurat = 'Tidak ada tanggal surat';
				} else {
					$tglSurat = $this->panjang($tanggalSuratTxt);
				}

				$tanggalTempoTxt = $data->tglTempo;
				if ($tanggalTempoTxt == '0000-00-00') {
					$tglTempo = 'Tidak ada jatuh tempo';
				} else {
					$tglTempo = $this->panjang($tanggalTempoTxt);
				}

				$created_date = $data->created_date;
				$tglEntri = $this->pendek($created_date);

				$created_dttm = $data->created_dttm;
				$tglRespon = $this->pendek($created_dttm);

				$read = $data->read_status;
				$status_surat = $data->status_surat;
				$resaction = $this->M_Suratmasuk->getLastUser($data->idSurat, $idUser);
				$action = $resaction[0]->action;
				if (($action == 'tolak') && $status_surat == 'rejected') {
					$actionTxt = 'Ditolak';
				}


				$judul = $data->koresponden;
				$title = substr($judul, 0, 1);

				$koresponden = $data->koresponden;
				$jmlKores = strlen($koresponden);
				if ($jmlKores >= 35) {
					$subkores = substr($koresponden, 0, 30);
					$koresTxt = strtoupper($subkores . '...');
				} else {
					$koresTxt = strtoupper($koresponden);
				}

				$perihal = $data->perihal;
				$jmlPerihal = strlen($perihal);
				if ($jmlPerihal >= 35) {
					$subperihal = substr($perihal, 0, 35);
					$perihalTxt = $subperihal . '...';
				} else {
					$perihalTxt = $perihal;
				}

				$nmSifat = $data->nmSifat;

				$ret[] = array(
					'message' => 'Sukses',
					'idResponse' => $data->idResponse,
					'idSurat' => $data->idSurat,
					'tipe' => $data->tipe,
					'trackID' => $data->trackID,
					'koresponden' => $koresTxt,
					'perihal' => $perihalTxt,
					'tglEntri' => $tglEntri,
					'tglSurat' => $tglSurat,
					'tglTempo' => $tglTempo,
					'tglRespon' => $tglRespon,
					'status_surat' => $status_surat,
					'nmSifat' => $nmSifat,
					'read_status' => $data->read_status,
					'title' => $title,
					'action' => $actionTxt,
					'jumlah_huruf' => $jmlKores,
					'Jumlah_data' => $Jumlah_data,
				);
			}
		} else {
			$ret[] = array(
				'message' => 'Gagal',
			);
		}
		echo json_encode($ret);
	}

	public function getSuratMasukDeleted()
	{
		$idUser = $this->uri->segment(3);
		$res = $this->M_Suratmasuk->getSuratMasukDeleted($idUser);

		if ($res == true) {
			foreach ($res as $data) {
				$tanggalSuratTxt = $data->tglSurat;
				if ($tanggalSuratTxt == '0000-00-00') {
					$tglSurat = 'Tidak ada tanggal surat';
				} else {
					$tglSurat = $this->panjang($tanggalSuratTxt);
				}

				$tanggalTempoTxt = $data->tglTempo;
				if ($tanggalTempoTxt == '0000-00-00') {
					$tglTempo = 'Tidak ada jatuh tempo';
				} else {
					$tglTempo = $this->panjang($tanggalTempoTxt);
				}

				$created_date = $data->created_date;
				$tglEntri = $this->pendek($created_date);

				$created_dttm = $data->created_dttm;
				$tglRespon = $this->pendek($created_dttm);

				$read = $data->read_status;
				if ($read == 'N') {
					$shadow = 9;
					$fontWeight = 'bold';
				} else {
					$shadow = 1;
					$fontWeight = 'normal';
				}

				$status_surat = $data->status_surat;
				$resaction = $this->M_Suratmasuk->getaction($data->idSurat, $idUser);
				$action = $resaction[0]->action;
				if ($action == 'belum' && $status_surat == 'normal') {
					$actionTxt = 'Belum Ditindaklanjuti';
					$color = '#F39C12';
				} else if ($action == 'sudah' && $status_surat == 'normal') {
					$actionTxt = 'Sudah Ditindaklanjuti';
					$color = '#3498DB';
				} else if ($action == 'batal' && $status_surat == 'normal') {
					$actionTxt = 'Dibatalkan';
					$color = '#95A5A6';
				} else if ($status_surat == 'finish' || $status_surat == 'nullified') {
					$actionTxt = 'Selesai';
					$color = '#27AE60';
				}

				$judul = $data->koresponden;
				$title = substr($judul, 0, 1);

				$koresponden = $data->koresponden;
				$jmlKores = strlen($koresponden);
				if ($jmlKores >= 35) {
					$subkores = substr($koresponden, 0, 30);
					$koresTxt = strtoupper($subkores . '...');
				} else {
					$koresTxt = strtoupper($koresponden);
				}

				$perihal = $data->perihal;
				$jmlPerihal = strlen($perihal);
				if ($jmlPerihal >= 35) {
					$subperihal = substr($perihal, 0, 35);
					$perihalTxt = $subperihal . '...';
				} else {
					$perihalTxt = $perihal;
				}

				$nmSifat = $data->nmSifat;
				if ($nmSifat == 'Penting') {
					$fontColor = '#FFF';
					$bgColor = '#E74C3C';
				} else if ($nmSifat == 'Segera') {
					$fontColor = '#FFF';
					$bgColor = '#F39C12';
				} else {
					$fontColor = '#FFF';
					$bgColor = '#FFF';
				}

				$ret[] = array(
					'message' => 'Sukses',
					'idSurat' => $data->idSurat,
					'tipe' => $data->tipe,
					'trackID' => $data->trackID,
					'koresponden' => $koresTxt,
					'perihal' => $perihalTxt,
					'tglEntri' => $tglEntri,
					'tglSurat' => $tglSurat,
					'tglTempo' => $tglTempo,
					'tglRespon' => $tglRespon,
					'status_surat' => $status_surat,
					'nmSifat' => $nmSifat,
					'read_status' => $data->read_status,
					'shadow' => $shadow,
					'fontWeight' => $fontWeight,
					'color' => $color,
					'fontColor' => $fontColor,
					'bgColor' => $bgColor,
					'title' => $title,
					'action' => $actionTxt,
					'jumlah_huruf' => $jmlKores,
				);
			}
		} else {
			$ret[] = array(
				'message' => 'Gagal',
			);
		}

		echo json_encode($ret);
	}

	public function getTembusanSuratMasuk()
	{
		$idUser = $this->uri->segment(3);
		$tipeSurat = $this->uri->segment(4);
		$limit = $this->uri->segment(5);
		$start = $this->uri->segment(6);

		$res1 = $this->M_Suratmasuk->getTembusanSuratMasukTemp($tipeSurat, $idUser);
		$Jumlah_data =	count($res1);
		$res = $this->M_Suratmasuk->getTembusanSuratMasuk($tipeSurat, $idUser, $limit, $start);

		if ($res == true) {
			foreach ($res as $data) {
				$tanggalSuratTxt = $data->tglSurat;
				if ($tanggalSuratTxt == '0000-00-00') {
					$tglSurat = 'Tidak ada tanggal surat';
				} else {
					$tglSurat = $this->panjang($tanggalSuratTxt);
				}

				$tanggalTempoTxt = $data->tglTempo;
				if ($tanggalTempoTxt == '0000-00-00') {
					$tglTempo = 'Tidak ada jatuh tempo';
				} else {
					$tglTempo = $this->panjang($tanggalTempoTxt);
				}

				$created_date = $data->created_date;
				$tglEntri = $this->pendek($created_date);



				$status_surat = $data->status_surat;
				$resaction = $this->M_Suratmasuk->getLastUser($data->idSurat, $idUser);
				$action = $resaction[0]->action;
				if ($action == 'belum' && $status_surat == 'normal') {
					$actionTxt = 'Belum Ditindaklanjuti';
					$color = '#F39C12';
				} else if ($action == 'sudah' && $status_surat == 'normal') {
					$actionTxt = 'Sudah Ditindaklanjuti';
					$color = '#3498DB';
				} else if (($action == 'batal' || $action == 'dibatalkan') && $status_surat == 'normal') {
					$actionTxt = 'Dibatalkan';
					$color = '#95A5A6';
				} else if ($status_surat == 'finish') {
					$actionTxt = 'Selesai';
					$color = '#27AE60';
				}

				$judul = $data->koresponden;
				$title = substr($judul, 0, 1);

				$koresponden = $data->koresponden;
				$jmlKores = strlen($koresponden);
				if ($jmlKores >= 35) {
					$subkores = substr($koresponden, 0, 30);
					$koresTxt = strtoupper($subkores . '...');
				} else {
					$koresTxt = strtoupper($koresponden);
				}

				$perihal = $data->perihal;
				$jmlPerihal = strlen($perihal);
				if ($jmlPerihal >= 35) {
					$subperihal = substr($perihal, 0, 35);
					$perihalTxt = $subperihal . '...';
				} else {
					$perihalTxt = $perihal;
				}

				$nmSifat = $data->nmSifat;


				$ret[] = array(
					'message' => 'Sukses',
					'idSurat' => $data->idSurat,
					'tipe' => $data->tipe,
					'trackID' => $data->trackID,
					'koresponden' => $koresTxt,
					'perihal' => $perihalTxt,
					'tglEntri' => $tglEntri,
					'tglSurat' => $tglSurat,
					'tglTempo' => $tglTempo,
					'status_surat' => $status_surat,
					'nmSifat' => $nmSifat,
					'title' => $title,
					'action' => $actionTxt,
					'jumlah_huruf' => $jmlKores,
					'Jumlah_data' => $Jumlah_data,
				);
			}
		} else {
			$ret[] = array(
				'message' => 'Gagal',
			);
		}


		echo json_encode($ret);
	}

	public function getTembusanSuratKeluar()
	{
		$idUser = $this->uri->segment(3);
		$tipeSurat = $this->uri->segment(4);
		$res = $this->M_Suratmasuk->getTembusanSuratKeluar($idUser, $tipeSurat);

		if ($res == true) {
			foreach ($res as $data) {
				$tanggalSuratTxt = $data->tglSurat;
				if ($tanggalSuratTxt == '0000-00-00') {
					$tglSurat = 'Tidak ada tanggal surat';
				} else {
					$tglSurat = $this->panjang($tanggalSuratTxt);
				}

				$tanggalTempoTxt = $data->tglTempo;
				if ($tanggalTempoTxt == '0000-00-00') {
					$tglTempo = 'Tidak ada jatuh tempo';
				} else {
					$tglTempo = $this->panjang($tanggalTempoTxt);
				}

				$tglTembusan = $data->tglTembusan;
				$tglTembusan = $this->pendek($tglTembusan);

				$cek = $data->cek;
				if ($cek == 'N') {
					$shadow = 9;
					$fontWeight = 'bold';
				} else {
					$shadow = 1;
					$fontWeight = 'normal';
				}

				$status_surat = $data->status_surat;
				$resaction = $this->M_Suratmasuk->getaction($data->idSurat, $idUser);
				$action = $resaction[0]->action;
				if ($action == 'belum' && $status_surat == 'normal') {
					$actionTxt = 'Belum Ditindaklanjuti';
					$color = '#F39C12';
				} else if ($action == 'sudah' && $status_surat == 'normal') {
					$actionTxt = 'Sudah Ditindaklanjuti';
					$color = '#3498DB';
				} else if ($action == 'batal' && $status_surat == 'normal') {
					$actionTxt = 'Dibatalkan';
					$color = '#95A5A6';
				} else if ($status_surat == 'finish') {
					$actionTxt = 'Selesai';
					$color = '#27AE60';
				}

				$judul = $data->koresponden;
				$title = substr($judul, 0, 1);

				$koresponden = $data->koresponden;
				$jmlKores = strlen($koresponden);
				if ($jmlKores >= 35) {
					$subkores = substr($koresponden, 0, 30);
					$koresTxt = strtoupper($subkores . '...');
				} else {
					$koresTxt = strtoupper($koresponden);
				}

				$perihal = $data->perihal;
				$jmlPerihal = strlen($perihal);
				if ($jmlPerihal >= 35) {
					$subperihal = substr($perihal, 0, 35);
					$perihalTxt = $subperihal . '...';
				} else {
					$perihalTxt = $perihal;
				}

				$nmSifat = $data->nmSifat;
				if ($nmSifat == 'Penting') {
					$fontColor = '#FFF';
					$bgColor = '#E74C3C';
				} else if ($nmSifat == 'Segera') {
					$fontColor = '#FFF';
					$bgColor = '#F39C12';
				} else {
					$fontColor = '#FFF';
					$bgColor = '#FFF';
				}

				$ret[] = array(
					'message' => 'Sukses',
					'idSurat' => $data->idSurat,
					'tipe' => $data->tipe,
					'trackID' => $data->trackID,
					'koresponden' => $koresTxt,
					'perihal' => $perihalTxt,
					'tglTembusan' => $tglTembusan,
					'tglSurat' => $tglSurat,
					'tglTempo' => $tglTempo,
					'status_surat' => $status_surat,
					'nmSifat' => $nmSifat,
					'cek' => $cek,
					'shadow' => $shadow,
					'fontWeight' => $fontWeight,
					'color' => $color,
					'fontColor' => $fontColor,
					'bgColor' => $bgColor,
					'title' => $title,
					'action' => $actionTxt,
					'jumlah_huruf' => $jmlKores,
				);
			}
		} else {
			$ret[] = array(
				'message' => 'Gagal',
			);
		}

		echo json_encode($ret);
	}

	public function getDetail()
	{
		$idSurat = $this->uri->segment(3);
		$res = $this->M_Suratmasuk->getDetail($idSurat);
		if ($res == true) {
			foreach ($res as $data) {
				$tanggalSuratTxt = $data->tglSurat;
				if ($tanggalSuratTxt == '0000-00-00') {
					$tglSurat = '-';
				} else {
					$tglSurat = $this->panjang($tanggalSuratTxt);
				}

				$tanggalTempoTxt = $data->tglTempo;
				if ($tanggalTempoTxt == '0000-00-00') {
					$tglTempo = '-';
				} else {
					$tglTempo = $this->panjang($tanggalTempoTxt);
				}

				$noSurat = $data->noSurat;
				if ($noSurat == '') {
					$noSuratx = '-';
				} else {
					$noSuratx = $noSurat;
				}

				$isi = $data->isi;
				if ($isi == '') {
					$isix = '-';
				} else {
					$isix = $isi;
				}

				$created_date = $data->created_date;
				$tglEntri = $this->panjang($created_date) . ' - ' . date("H:i", strtotime($created_date)) . ' WIB';

				$cekSurat = $this->M_Suratmasuk->cekSurat($idSurat);
				if (count($cekSurat) > 0) {
					foreach ($cekSurat as $cek) {
						$filePath = $cek->file_path;
						$file_nm = $cek->file_nm;
					}
				} else {
					if ($data->tipe === 'IN') {
						$filePath = 'dokumen_masuk';
						$file_nm = $data->fileSurat;
					} else if ($data->tipe === 'OUT') {
						$filePath = 'dokumen_keluar';
						$file_nm = $data->fileSurat;
					}
				}

				$ret[] = array(
					'message' => 'Sukses',
					'idSurat' => $data->idSurat,
					'tipe' => $data->tipe,
					'trackID' => $data->trackID,
					'koresponden' => strtoupper($data->koresponden),
					'noUrut' => $data->noUrut,
					'noSurat' => $noSuratx,
					'perihal' => $data->perihal,
					'isi' => $isix,
					'tglSurat' => $tglSurat,
					'tglTempo' => $tglTempo,
					'kdKlas' => $data->kdKlas,
					'nmKlas' => $data->nmKlas,
					'nmSifat' => $data->nmSifat,
					'tglEntri' => $tglEntri,
					'filePath' => $filePath,
					'file_nm' => $file_nm,
				);
			}
		} else {
			$ret[] = array(
				'message' => 'Gagal',
			);
		}
		echo json_encode($ret);
	}

	public function getRiwayat()
	{
		$idSurat = $this->uri->segment(3);
		$res = $this->M_Suratmasuk->getRiwayat($idSurat);
		$lastUser = $this->M_Suratmasuk->getLastUser($idSurat);
		$readActlast = $lastUser{
			0}->read_status;

		if ($res == true) {
			foreach ($res as $sender) {
				$tglRiwayatTxt = $sender->created_dttm;
				if ($tglRiwayatTxt == '0000-00-00 00:00:00') {
					$tglRiwayat = '-';
				} else {
					$tglRiwayat = $this->pendek($tglRiwayatTxt);
				}
				$jamRiwayat = date("H:i", strtotime($tglRiwayatTxt));

				$idPembuat = $sender->created_user;
				$idPengirim = $sender->send_user_id;
				$pengirim = $sender->pengirim;
				$jabPengirim = $sender->jabPengirim;
				$idPenerima = $sender->receive_user_id;

				// $isiDisposisi = $getActionTxt{0}->nmDisposisi;
				$read_status = $sender->read_status;
				if ($readActlast == 'N') {
					$read_status = 'Y';
				}
				if ($read_status == 'Y') {
					if ($sender->tipe != 'IN') {
						if ($sender->action == 'selesai') {
							$description4 = 'Diteruskan ' . $tglRiwayat . '';
							$readColor = '#16A0E2';
						} else if ($sender->action == 'dibatalkan') {
							$description4 = 'Membatalkan surat pada ' . $tglRiwayat . '';
							$readColor = '#DC3545';
						} else if ($sender->action == 'batal' || $sender->action == 'revisi') {
							$description4 = 'Diteruskan ' . $tglRiwayat . '';
							$readColor = '#16A0E2';
						} else if ($sender->action == 'setuju') {
							if ($idPembuat == $idPengirim) {
								$description4 = 'Diteruskan ' . $tglRiwayat . '';
								$readColor = '#16A0E2';
							} else {
								$description4 = 'Diteruskan ' . $tglRiwayat . '';
								$readColor = '#16A0E2';
							}
						} else if ($sender->action == 'belum') {
							$description4 = 'Diteruskan ' . $tglRiwayat . '';
							$readColor = '#16A0E2';
						} else if ($sender->action == 'proses_revisi' || $sender->action == 'update') {
							$description4 = 'Revisi ' . $tglRiwayat . '';
							$readColor = '#ba35dc';
						}
					} else {
						if ($sender->action == 'selesai') {
							$description4 = 'Diselesaikan ' . $tglRiwayat . '';
							$readColor = '#27AE60';
						} else if ($sender->action == 'dibatalkan') {
							$description4 = 'Membatalkan surat pada ' . $tglRiwayat . '';
							$readColor = '#DC3545';
						} else if ($sender->action == 'batal') {
							$description4 = 'Diteruskan ' . $tglRiwayat . '';
							$readColor = '#16A0E2';
						} else if ($sender->action == 'sudah') {
							$description4 = 'Didisposisi ' . $tglRiwayat . '';
							$readColor = '#16A0E2';
						} else if ($sender->action == 'belum') {
							$description4 = 'Didisposisi ' . $tglRiwayat . '';
							$readColor = '#16A0E2';
						} else if ($sender->action == 'proses_revisi' || $sender->action == 'update') {
							$description4 = 'Revisi ' . $tglRiwayat . '';
							$readColor = '#ba35dc';
						}
					}
				} else {
					$description4 = 'Belum dibaca';
					$readColor = '#F39C12';
				}

				$ret[] = array(
					'message' => 'Sukses',
					'user' => $pengirim,
					'jabUser' => $jabPengirim,
					'time' => $tglRiwayat,
					'description2' => $sender->nmDisposisi,
					'description3' => $sender->action_txt,
					'description4' => $description4,
					'readColor' => $readColor,
					'idResponse' => $sender->idResponse,
				);
			}

			foreach ($lastUser as $receive) {
				if ($receive->receive_user_id != 0) {
					$penerima =	$receive->lastUser;
					$jabPenerima = $receive->jabLastUser;
					$tglRiwayatTxt = $receive->created_dttm;

					$tanggalReadTxt = $receive->read_dttm;
					if ($tanggalReadTxt == '0000-00-00 00:00:00') {
						$tglRead = '-';
					} else {
						$tglRead = $this->pendek($tanggalReadTxt);
					}
					$jamRead = date("H:i", strtotime($tanggalReadTxt));

					if ($tglRiwayatTxt == '0000-00-00 00:00:00') {
						$tglRiwayat = '-';
					} else {
						$tglRiwayat = $this->pendek($tglRiwayatTxt);
					}
					$jamRiwayat = date("H:i", strtotime($tglRiwayatTxt));

					if ($receive->action == 'belum') {
						$actionTxt = '';
						$isiDisposisi = null;
					} else {
						$actionTxt = $receive->action_txt;
						$isiDisposisi = $receive->nmDisposisi;
					}
					$read_status = $receive->read_status;
					if ($read_status == 'Y') {
						if ($sender->tipe != 'IN') {
							if ($receive->action == 'selesai') {
								$description4 = 'Ditandatangani ' . $tglRiwayat . '';
								$readColor = '#27AE60';
							} else if ($receive->action == 'dibatalkan' || $receive->action == 'batal') {
								$description4 = 'Surat dibatalkan pada ' . $tglRiwayat . '';
								$readColor = '#DC3545';
							} else if ($receive->action == 'setuju') {
								if ($idPembuat == $idPengirim) {
									$description4 = 'Diteruskan ' . $tglRiwayat . '';
									$readColor = '#16A0E2';
								} else {
									$description4 = 'Diteruskan ' . $tglRiwayat . '';
									$readColor = '#16A0E2';
								}
							} else if ($receive->action == 'belum') {
								$description4 = 'Dibaca ' . $tglRiwayat . '';
								$readColor = '#16A0E2';
							} else if ($receive->action == 'proses_revisi' || $receive->action == 'update') {
								$description4 = 'Proses Revisi ' . $tglRiwayat . '';
								$readColor = '#ba35dc';
							} else if ($receive->action == 'tolak') {
								$description4 = 'Ditolak ' . $tglRiwayat . '';
								$readColor = '#DC3545';
							}
						} else {
							if ($receive->action == 'selesai') {
								$description4 = 'Diselesaikan ' . $tglRiwayat . '';
								$readColor = '#27AE60';
							} else if ($receive->action == 'dibatalkan' || $receive->action == 'batal') {
								$description4 = 'dibatalkan pada ' . $tglRiwayat . '';
								$readColor = '#DC3545';
							} else if ($receive->action == 'sudah') {
								if ($idPembuat == $idPengirim) {
									$description4 = 'Didisposisi ' . $tglRiwayat . '';
									$readColor = '#16A0E2';
								} else {
									$description4 = 'Didisposisi ' . $tglRiwayat . '';
									$readColor = '#16A0E2';
								}
							} else if ($receive->action == 'belum') {
								$description4 = 'Dibaca ' . $tglRiwayat . '';
								$readColor = '#16A0E2';
							} else if ($receive->action == 'proses_revisi' || $receive->action == 'update') {
								$description4 = 'Revisi ' . $tglRiwayat . '';
								$readColor = '#ba35dc';
							} else if ($receive->action == 'tolak') {
								$description4 = 'Ditolak ' . $tglRiwayat . '';
								$readColor = '#DC3545';
							}
						}
					} else {
						$description4 = 'Belum dibaca';
						$readColor = '#F39C12';
					}

					$ret[] = array(
						'message' => 'Sukses',
						'user' => $penerima,
						'jabUser' => $jabPenerima,
						'time' => $tglRiwayat,
						'description2' => $isiDisposisi,
						'description3' => $actionTxt,
						'description4' => $description4,
						'readColor' => $readColor,
					);
				}
			}
		}
		// echo json_encode($idPengirim .'=='. $lastUser{0}->send_user_id);
		echo json_encode($ret);
	}




	public function getUserDisposisi()
	{
		$idUser = $this->uri->segment(3);
		$res = $this->M_Suratmasuk->getUserDisposisi($idUser);
		if ($res == true) {
			foreach ($res as $data) {
				$ret[] = array(
					'message' => 'Sukses',
					'idUser' => $data->idUser,
					'kdJabatan' => $data->kdJabatan,
					'nmJabatan' => $data->nmJabatan,
					'nmUser' => $data->nama,
				);
			}
		} else {
			$ret[] = array(
				'message' => 'Gagal',
			);
		}

		echo json_encode($ret);
	}

	public function getIsiDisposisi()
	{
		$res = $this->M_Suratmasuk->getIsiDisposisi();

		if ($res == true) {
			foreach ($res as $data) {
				$ret[] = array(
					'message' => 'Sukses',
					'idIsi' => $data->idIsi,
					'nmDisposisi' => $data->nmDisposisi,
				);
			}
		} else {
			$ret[] = array(
				'message' => 'Gagal',
			);
		}

		echo json_encode($ret);
	}

	public function updateRead()
	{
		$idSurat = $this->uri->segment(3);
		$idUser = $this->uri->segment(4);

		$read_dttm = date('Y-m-d H:i:s');

		$data = array(
			'read_status' => 'Y',
			'read_dttm' => $read_dttm,
		);
		$update = $this->M_Suratmasuk->updateRead($data, $idSurat, $idUser);
		if ($update == true) {
			$ret[] = array(
				'message' => 'Sukses',
			);
		} else {
			$ret[] = array(
				'message' => 'gagal update',
			);
		}
		echo json_encode($ret);
	}

	public function updateReadTembusan()
	{
		$idSurat = $this->uri->segment(3);
		$idUser = $this->uri->segment(4);

		$tglRead = date('Y-m-d H:i:s');

		$data = array(
			'cek' => 'Y',
			'tglRead' => $tglRead,
		);
		$update = $this->M_Suratmasuk->updateReadTembusan($data, $idSurat, $idUser);
		if ($update == true) {
			$ret[] = array(
				'message' => 'Sukses',
			);
		} else {
			$ret[] = array(
				'message' => 'gagal update',
			);
		}
		echo json_encode($ret);
	}

	public function submitSetuju()
	{
		$idSurat = $this->uri->segment(3);
		$idUser = $this->uri->segment(4);
		$idUserDis = $this->uri->segment(5);
		$nmUserDis = urldecode($this->uri->segment(6));
		$nmUser = urldecode($this->uri->segment(7));
		$jbUser = urldecode($this->uri->segment(8));
		$catatanDispos = urldecode($this->uri->segment(9));
		$dateNOW = date('Y-m-d H:i:s');
		$responseText = '<span class="tx-primary">Telah memeriksa dan menyetujui surat, </span>Melanjutkan proses pemeriksaan/persetujuan surat kepada <b>' . $nmUserDis;

		$data = array(
			'idSurat' => $idSurat,
			'created_dttm' => $dateNOW,
			'send_user_id' => $idUser,
			'receive_user_id' => $idUserDis,
			'action' => 'belum',
			'action_txt' => $catatanDispos,
			'response_txt' => $responseText,
		);

		$data2 = array(
			'action' => 'setuju',
		);

		$update2 = $this->M_Suratmasuk->updateResponseDisposisi1($data2, $idSurat);
		if ($update2 == true) {
			$insertResponseDisposisi = $this->M_Suratmasuk->submitDisposisi($data, $data2);
			if ($insertResponseDisposisi == true) {
				$cekRecieveId = $this->M_Suratmasuk->cekRecieveId($idSurat);
				$perihal = $cekRecieveId{
					0}->perihal;
				$perihalTxt = substr($perihal, 0, 100) . '. . .';
				$cekSession = $this->M_pushnotif->cekSession($idUserDis);
				if (count($cekSession) > 0) {
					foreach ($cekSession as $data) {
						$userDevice_id = $data->user_id_device;
						$notif = $this->M_pushnotif->sendMessage($userDevice_id, $nmUser, $jbUser, $perihalTxt);
						if ($notif == true) {
						} else {
							$ret[] = array(
								'message' => 'gagal notif',
							);
						}
					}
				}
				$ret[] = array(
					'message' => 'Sukses insert',
				);
			} else {
				$ret[] = array(
					'message' => 'gagal insert',
				);
			}
		} else {
			$ret[] = array(
				'message' => 'gagal update',
			);
		}

		echo json_encode($ret);
	}

	public function submitDisposisi()
	{
		$idSurat = $this->uri->segment(3);
		$idUser = $this->uri->segment(4);
		$idUserDis = $this->uri->segment(5);
		$idIsiDis = $this->uri->segment(6);
		$nmUser = urldecode($this->uri->segment(7));
		$jbUser = urldecode($this->uri->segment(8));
		$catatanDispos = urldecode($this->uri->segment(9));
		$dateNOW = date('Y-m-d H:i:s');

		$data = array(
			'idSurat' => $idSurat,
			'created_dttm' => $dateNOW,
			'send_user_id' => $idUser,
			'receive_user_id' => $idUserDis,
			'idIsi' => $idIsiDis,
			'action' => 'belum',
			'action_txt' => $catatanDispos,
		);
		// $dataUpdateDisposisi1 = array(
		// 	'action' => 'belum', 
		// );
		$data2 = array(
			'action' => 'sudah',
		);
		$insertResponseDisposisi = $this->M_Suratmasuk->submitDisposisi($data, $data2);
		if ($insertResponseDisposisi == true) {
			$update2 = $this->M_Suratmasuk->updateResponseDisposisi2($data2, $idSurat, $idUser);
			if ($update2 == true) {
				$cekRecieveId = $this->M_Suratmasuk->cekRecieveId($idSurat);
				$perihal = $cekRecieveId{
					0}->perihal;
				$perihalTxt = substr($perihal, 0, 100) . '. . .';
				$cekSession = $this->M_pushnotif->cekSession($idUserDis);
				if (count($cekSession) > 0) {
					foreach ($cekSession as $data) {
						$userDevice_id = $data->user_id_device;
						$notif = $this->M_pushnotif->sendMessage($userDevice_id, $nmUser, $jbUser, $perihalTxt);
					}
				}
				$ret[] = array(
					'message' => 'Sukses',
				);
			} else {
				$ret[] = array(
					'message' => 'gagal update 2',
				);
			}
		} else {
			$ret[] = array(
				'message' => 'gagal insert',
			);
		}
		echo json_encode($ret);
	}

	public function submitTembusan()
	{
		$idSurat = $this->uri->segment(3);
		$idUser = $this->uri->segment(4);
		$idUserTembusan = $this->uri->segment(5);
		$catatan = urldecode($this->uri->segment(6));
		$dateNow = date('Y-m-d H:i:s');

		$dataTembusan = array(
			'idSurat' => $idSurat,
			'tglTembusan' => $dateNow,
			'tembusan_txt' => $catatan,
			'dari' => $idUser,
			'untuk' => $idUserTembusan,
		);

		$insertTembusan = $this->M_Suratmasuk->insertTembusan($dataTembusan);

		echo json_encode($insertTembusan);
	}


	public function submitSelesai()
	{
		$idSurat = $this->uri->segment(3);
		$idUser = $this->uri->segment(4);
		$nmUser = urldecode($this->uri->segment(5));
		$jbUser = urldecode($this->uri->segment(6));
		$catatan = urldecode($this->uri->segment(7));
		$dateNow = date('Y-m-d H:i:s');


		$data = array(
			'idSurat' => $idSurat,
			'send_user_id' => $idUser,
			'action' => 'selesai',
			'read_status' => 'Y',
			'read_dttm' => $dateNow,
			'created_dttm' => $dateNow,
		);
		$dataSuratSelesai = array(
			'status_surat' => 'finish',
			'tglSelesai' => $dateNow,
		);
		$dataUpdateSelesai1 = array(
			'action' => 'sudah',
			'read_status' => 'Y',
			'read_dttm' => $dateNow,
		);
		$dataUpdateSelesai2 = array(
			'read_status' => 'Y',
			'read_dttm' => $dateNow,
		);


		$insertResponseSelesai = $this->M_Suratmasuk->submitSelesai($data);
		if ($insertResponseSelesai == true) {
			$updateSurat = $this->M_Suratmasuk->updateSuratSelesai($dataSuratSelesai, $idSurat);
			if ($updateSurat == true) {
				$updateResponse1 = $this->M_Suratmasuk->updateResponseSelesai1($dataUpdateSelesai1, $idSurat, $idUser);
				if ($updateResponse1 == true) {
					$ret[] = array(
						'message' => 'Sukses',
					);
				} else {
					$ret[] = array(
						'message' => 'gagal response 1',
					);
				}

				$cekRecieveId = $this->M_Suratmasuk->cekRecieveId2($idSurat, $idUser);
				$perihal = $cekRecieveId{
					0}->perihal;
				$perihalTxt = substr($perihal, 0, 100) . '. . .';
				if (count($cekRecieveId) > 0) {
					foreach ($cekRecieveId as $key) {
						$cekSession = $this->M_pushnotif->cekSession($key->receive_user_id);
						foreach ($cekSession as $data) {
							$userDevice_id = $data->user_id_device;
							$notif = $this->M_pushnotif->sendSelesai($userDevice_id, $nmUser, $jbUser, $perihalTxt);
							$ret[] = array(
								'message' => 'Sukses',
							);
						}
						$ret[] = array(
							'message' => 'Sukses',
						);
					}
				}

				$updateResponse2 = $this->M_Suratmasuk->updateResponseSelesai2($dataUpdateSelesai2, $idSurat);
				if ($updateResponse2 == true) {
					$ret[] = array(
						'message' => 'Sukses',
					);
				} else {
					$ret[] = array(
						'message' => 'gagal response 2',
					);
				}
			} else {
				$ret[] = array(
					'message' => 'gagal update surat',
				);
			}
		} else {
			$ret[] = array(
				'message' => 'gagal insert',
			);
		}
		echo json_encode($ret);
	}

	public function submitTolak()
	{
		$idSurat = $this->uri->segment(3);
		$idUser = $this->uri->segment(4);
		$catatan = urldecode($this->uri->segment(5));
		$nmUser = urldecode($this->uri->segment(6));
		$jbUser = urldecode($this->uri->segment(7));
		$dateNow = date('Y-m-d H:i:s');


		$responseText = '<span class="tx-danger">Telah menolak surat <i class="fe-x"></i></span>';

		$getIdPembuat = $this->M_Suratmasuk->getRiwayat($idSurat);
		$idPembuat = $getIdPembuat{
			0}->created_user;

		$dataInput = array(
			'idSurat' => $idSurat,
			'send_user_id' => $idUser,
			'receive_user_id'  => $idPembuat,
			'action' => 'tolak',
			'created_dttm' => $dateNow,
			'action_txt' => $catatan,
			'response_txt' => $responseText,
		);

		$dataSuratSelesai = array(
			'status_surat' => 'rejected',
			'tglSelesai' => $dateNow,
		);

		$insertTolak = $this->M_Suratmasuk->submitTolak($dataInput);
		if ($insertTolak == true) {
			$updateSurat = $this->M_Suratmasuk->updateSuratSelesai($dataSuratSelesai, $idSurat);
			if ($updateSurat == true) {
				$cekRecieveId = $this->M_Suratmasuk->cekRecieveId2($idSurat, $idUser);
				$perihal = $cekRecieveId{
					0}->perihal;
				$perihalTxt = substr($perihal, 0, 100) . '. . .';
				if (count($cekRecieveId) > 0) {
					foreach ($cekRecieveId as $key) {
						$cekSession = $this->M_pushnotif->cekSession($key->receive_user_id);
						foreach ($cekSession as $data) {
							$userDevice_id = $data->user_id_device;
							$notif = $this->M_pushnotif->sendTolak($userDevice_id, $nmUser, $jbUser, $perihalTxt);
							$ret[] = array(
								'message' => 'Sukses',
							);
						}
						$ret[] = array(
							'message' => 'Sukses',
						);
					}
				} else {
					$ret[] = array(
						'message' => 'gagal1',
					);
				}
			} else {
				$ret[] = array(
					'message' => 'gagal2',
				);
			}
		} else {
			$ret[] = array(
				'message' => 'gagal3',
			);
		}

		echo json_encode($ret);
	}

	public function submitBatal()
	{
		$idSurat = $this->uri->segment(3);
		$idUser = $this->uri->segment(4);
		$catatan = urldecode($this->uri->segment(5));
		$nmUser = urldecode($this->uri->segment(6));
		$jbUser = urldecode($this->uri->segment(7));
		$created_dttm = date('Y-m-d H:i:s');
		$data = array(
			'action' => 'batal',
			'created_dttm' => $created_dttm,
		);

		$cekIdTujuan = $this->M_Suratmasuk->cekIdTujuan($idSurat);
		$idTujuan = $cekIdTujuan{
			0}->receive_user_id;
		if ($cekIdTujuan != 0) {
			$update = $this->M_Suratmasuk->submitBatal($data, $idSurat, $idUser);
			if ($update == true) {
				$dataInput = array(
					'idSurat' => $idSurat,
					'send_user_id' => $idUser,
					'receive_user_id'  => $idTujuan,
					'action' => 'dibatalkan',
					'created_dttm' => $created_dttm,
					'action_txt' => $catatan,
				);
				$insertResponseBatal = $this->M_Suratmasuk->insertResponseBatal($dataInput);
				if ($insertResponseBatal == true) {
					$dataResponse = array(
						'action' => 'dibatalkan',
					);
					$updateRespon = $this->M_Suratmasuk->updateRespon($dataResponse, $idSurat);
					if ($updateRespon == true) {
						$cekRecieveId = $this->M_Suratmasuk->cekRecieveId($idSurat);
						$perihal = $cekRecieveId{
							0}->perihal;
						$perihalTxt = substr($perihal, 0, 100) . '. . .';
						$cekSession = $this->M_pushnotif->cekSession($idTujuan);
						foreach ($cekSession as $data) {
							$userDevice_id = $data->user_id_device;
							$notif = $this->M_pushnotif->sendBatal($userDevice_id, $nmUser, $jbUser, $perihalTxt);
							$ret[] = array(
								'message' => 'Sukses',
							);
						}
						$ret[] = array(
							'message' => 'Sukses',
						);
					}
				} else {
					$ret[] = array(
						'message' => 'gagal update',
					);
				}
			} else {
				$ret[] = array(
					'message' => 'gagal update',
				);
			}
		}
		echo json_encode($ret);
	}



	public function getTotal()
	{
		$idUser = $this->uri->segment(3);
		$tipeSuratIN = 'IN';
		$tipeSuratOUT = 'OUT';
		$tipeSuratKEU = 'KEU';
		$tipeSuratREG = 'REG';

		$suratMasuk = $this->M_Suratmasuk->getTotalSurat($idUser, $tipeSuratIN);
		$totalSuratMasuk = count($suratMasuk);

		$suratKeluar = $this->M_Suratmasuk->getTotalSurat($idUser, $tipeSuratOUT);
		$totalSuratKeluar = count($suratKeluar);

		$suratKeuangan = $this->M_Suratmasuk->getTotalSurat($idUser, $tipeSuratKEU);
		$totalSuratKeuangan = count($suratKeuangan);

		$suratRegulasi = $this->M_Suratmasuk->getTotalSurat($idUser, $tipeSuratREG);
		$totalSuratRegulasi = count($suratRegulasi);

		$ret[0] = array(
			'message' => 'Sukses',
			'totalSuratMasuk' => $totalSuratMasuk,
			'totalSuratKeluar' => $totalSuratKeluar,
			'totalSuratKeuangan' => $totalSuratKeuangan,
			'totalSuratRegulasi' => $totalSuratRegulasi,
		);
		echo json_encode($ret);
	}



	public function getTotalSurat()
	{
		$idUser = $this->uri->segment(3);
		$tipeSuratIN = 'IN';
		$tipeSuratOUT = 'OUT';
		$tipeSuratKEU = 'KEU';
		$tipeSuratREG = 'REG';
		$actionBelum = 'belum';
		$actionRevisi = 'proses_revisi';
		$actionBatal = 'dibatalkan';
		$actionTolak = 'tolak';

		$belumTlSM = $this->M_Suratmasuk->getTotal($idUser, $tipeSuratIN, $actionBelum);
		$totalSM_belum = count($belumTlSM);
		$revisiSM = $this->M_Suratmasuk->getTotal($idUser, $tipeSuratIN, $actionRevisi);
		$totalSM_revisi = count($revisiSM);
		$batalSM = $this->M_Suratmasuk->getTotal($idUser, $tipeSuratIN, $actionBatal);
		$totalSM_actionBatal = count($batalSM);

		$belumTlSK = $this->M_Suratmasuk->getTotal($idUser, $tipeSuratOUT, $actionBelum);
		$totalSK_belum = count($belumTlSK);
		$revisiSK = $this->M_Suratmasuk->getTotal($idUser, $tipeSuratOUT, $actionRevisi);
		$totalSK_revisi = count($revisiSK);
		$batalSK = $this->M_Suratmasuk->getTotal($idUser, $tipeSuratOUT, $actionBatal);
		$totalSK_actionBatal = count($batalSK);
		$tolakSK = $this->M_Suratmasuk->getTotal($idUser, $tipeSuratOUT, $actionTolak);
		$totalSK_actionTolak = count($tolakSK);

		$belumTlKEU = $this->M_Suratmasuk->getTotal($idUser, $tipeSuratKEU, $actionBelum);
		$totalKEU_belum = count($belumTlKEU);
		$revisiKEU = $this->M_Suratmasuk->getTotal($idUser, $tipeSuratKEU, $actionRevisi);
		$totalKEU_revisi = count($revisiKEU);
		$batalKEU = $this->M_Suratmasuk->getTotal($idUser, $tipeSuratKEU, $actionBatal);
		$totalKEU_actionBatal = count($batalKEU);
		$tolakKEU = $this->M_Suratmasuk->getTotal($idUser, $tipeSuratKEU, $actionTolak);
		$totalKEU_actionTolak = count($tolakKEU);

		$belumTlREG = $this->M_Suratmasuk->getTotal($idUser, $tipeSuratREG, $actionBelum);
		$totalREG_belum = count($belumTlREG);
		$revisiREG = $this->M_Suratmasuk->getTotal($idUser, $tipeSuratREG, $actionRevisi);
		$totalREG_revisi = count($revisiREG);
		$batalREG = $this->M_Suratmasuk->getTotal($idUser, $tipeSuratREG, $actionBatal);
		$totalREG_actionBatal = count($batalREG);
		$tolakREG = $this->M_Suratmasuk->getTotal($idUser, $tipeSuratREG, $actionTolak);
		$totalREG_actionTolak = count($tolakREG);

		$totalSM = $totalSM_belum + $totalSM_revisi + $totalSM_actionBatal;
		$totalSK = $totalSK_belum + $totalSK_revisi + $totalSK_actionBatal + $totalSK_actionTolak;
		$totalKEU = $totalKEU_belum + $totalKEU_revisi + $totalKEU_actionBatal + $totalKEU_actionTolak;
		$totalREG = $totalREG_belum + $totalREG_revisi + $totalREG_actionBatal + $totalREG_actionTolak;


		$ret[] = array(
			'message' => 'Sukses',
			'totalAllSM' => $totalSM,
			'totalAllSK' => $totalSK,
			'totalAllKEU' => $totalKEU,
			'totalAllREG' => $totalREG,
			'totalSM_belum' => $totalSM_belum,
			'totalSM_revisi' => $totalSM_revisi,
			'totalSM_actionBatal' => $totalSM_actionBatal,
			'totalSK_belum' => $totalSK_belum,
			'totalSK_revisi' => $totalSK_revisi,
			'totalSK_actionBatal' => $totalSK_actionBatal,
			'totalSK_actionTolak' => $totalSK_actionTolak,
			'totalKEU_belum' => $totalKEU_belum,
			'totalKEU_revisi' => $totalKEU_revisi,
			'totalKEU_actionBatal' => $totalKEU_actionBatal,
			'totalKEU_actionTolak' => $totalKEU_actionTolak,
			'totalREG_belum' => $totalREG_belum,
			'totalREG_revisi' => $totalREG_revisi,
			'totalREG_actionBatal' => $totalREG_actionBatal,
			'totalREG_actionTolak' => $totalREG_actionTolak,
		);

		echo json_encode($ret);
	}

	public function getGrandTotalTembusan()
	{
		$idUser = $this->uri->segment(3);
		$resMasuk   = $this->M_Suratmasuk->getCountTembusanMasuk($idUser);
		$tot_masuk  = count($resMasuk);
		$resKeluar  = $this->M_Suratmasuk->getCountTembusanKeluar($idUser);
		$tot_keluar = count($resKeluar);

		$resGT = $tot_masuk + $tot_keluar;

		if ($resGT <= 98) {
			$resGT = $resGT;
		} else {
			$resGT = '99+';
		}
		$ret[0] = array(
			'message' => 'Sukses',
			'kode' => 'tembusan',
			'grand_totalTembusan' => $resGT,
			'total_masuk' => $tot_masuk,
			'total_keluar' => $tot_keluar,
		);
		echo json_encode($ret);
	}

	public function getLogSurat()
	{
		$trackID = strtoupper($this->uri->segment(3));
		$cekTrackId = $this->M_Suratmasuk->getLogSurat($trackID);

		if (count($cekTrackId) > 0) {
			$idSurat = $cekTrackId{
				0}->idSurat;

			$res = $this->M_Suratmasuk->getRiwayat($idSurat);
			$lastUser = $this->M_Suratmasuk->getLastUser($idSurat);
			$readActlast = $lastUser{
				0}->read_status;

			if ($res == true) {
				foreach ($res as $sender) {
					$tglRiwayatTxt = $sender->created_dttm;
					if ($tglRiwayatTxt == '0000-00-00 00:00:00') {
						$tglRiwayat = '-';
					} else {
						$tglRiwayat = $this->pendek($tglRiwayatTxt);
					}
					$jamRiwayat = date("H:i", strtotime($tglRiwayatTxt));

					$idPembuat = $sender->created_user;
					$idPengirim = $sender->send_user_id;
					$pengirim = $sender->pengirim;
					$jabPengirim = $sender->jabPengirim;
					$idPenerima = $sender->receive_user_id;

					// $isiDisposisi = $getActionTxt{0}->nmDisposisi;
					$read_status = $sender->read_status;
					if ($readActlast == 'N') {
						$read_status = 'Y';
					}
					if ($read_status == 'Y') {
						if ($sender->tipe != 'IN') {
							if ($sender->action == 'selesai') {
								$description4 = 'Diteruskan ' . $tglRiwayat . '';
								$readColor = '#16A0E2';
							} else if ($sender->action == 'dibatalkan') {
								$description4 = 'Membatalkan surat pada ' . $tglRiwayat . '';
								$readColor = '#DC3545';
							} else if ($sender->action == 'batal') {
								$description4 = 'Diteruskan ' . $tglRiwayat . '';
								$readColor = '#16A0E2';
							} else if ($sender->action == 'setuju') {
								if ($idPembuat == $idPengirim) {
									$description4 = 'Diteruskan ' . $tglRiwayat . '';
									$readColor = '#16A0E2';
								} else {
									$description4 = 'Diteruskan ' . $tglRiwayat . '';
									$readColor = '#16A0E2';
								}
							} else if ($sender->action == 'belum') {
								$description4 = 'Diteruskan ' . $tglRiwayat . '';
								$readColor = '#16A0E2';
							} else if ($sender->action == 'proses_revisi' || $sender->action == 'update') {
								$description4 = 'Revisi ' . $tglRiwayat . '';
								$readColor = '#ba35dc';
							}
						} else {
							if ($sender->action == 'selesai') {
								$description4 = 'Diselesaikan ' . $tglRiwayat . '';
								$readColor = '#27AE60';
							} else if ($sender->action == 'dibatalkan') {
								$description4 = 'Membatalkan surat pada ' . $tglRiwayat . '';
								$readColor = '#DC3545';
							} else if ($sender->action == 'batal') {
								$description4 = 'Diteruskan ' . $tglRiwayat . '';
								$readColor = '#16A0E2';
							} else if ($sender->action == 'sudah') {
								$description4 = 'Didisposisi ' . $tglRiwayat . '';
								$readColor = '#16A0E2';
							} else if ($sender->action == 'belum') {
								$description4 = 'Didisposisi ' . $tglRiwayat . '';
								$readColor = '#16A0E2';
							} else if ($sender->action == 'proses_revisi' || $sender->action == 'update') {
								$description4 = 'Revisi ' . $tglRiwayat . '';
								$readColor = '#ba35dc';
							}
						}
					} else {
						$description4 = 'Belum dibaca';
						$readColor = '#F39C12';
					}

					$ret[] = array(
						'message' => 'Sukses',
						'user' => $pengirim,
						'jabUser' => $jabPengirim,
						'time' => $tglRiwayat,
						'description2' => $sender->nmDisposisi,
						'description3' => $sender->action_txt,
						'description4' => $description4,
						'readColor' => $readColor,
						'trackID' => $sender->trackID,
					);
				}

				foreach ($lastUser as $receive) {
					if ($receive->receive_user_id != 0) {
						$penerima =	$receive->lastUser;
						$jabPenerima = $receive->jabLastUser;
						$tglRiwayatTxt = $receive->created_dttm;

						$tanggalReadTxt = $receive->read_dttm;
						if ($tanggalReadTxt == '0000-00-00 00:00:00') {
							$tglRead = '-';
						} else {
							$tglRead = $this->pendek($tanggalReadTxt);
						}
						$jamRead = date("H:i", strtotime($tanggalReadTxt));

						if ($tglRiwayatTxt == '0000-00-00 00:00:00') {
							$tglRiwayat = '-';
						} else {
							$tglRiwayat = $this->pendek($tglRiwayatTxt);
						}
						$jamRiwayat = date("H:i", strtotime($tglRiwayatTxt));

						if ($receive->action == 'belum') {
							$actionTxt = '';
							$isiDisposisi = null;
						} else {
							$actionTxt = $receive->action_txt;
							$isiDisposisi = $receive->nmDisposisi;
						}
						$read_status = $receive->read_status;
						if ($read_status == 'Y') {
							if ($sender->tipe != 'IN') {
								if ($receive->action == 'selesai') {
									$description4 = 'Di tanda tangani ' . $tglRiwayat . '';
									$readColor = '#27AE60';
								} else if ($receive->action == 'dibatalkan' || $receive->action == 'batal') {
									$description4 = 'Surat dibatalkan pada ' . $tglRiwayat . '';
									$readColor = '#DC3545';
								} else if ($receive->action == 'setuju') {
									if ($idPembuat == $idPengirim) {
										$description4 = 'Diteruskan ' . $tglRiwayat . '';
										$readColor = '#16A0E2';
									} else {
										$description4 = 'Diteruskan ' . $tglRiwayat . '';
										$readColor = '#16A0E2';
									}
								} else if ($receive->action == 'belum') {
									$description4 = 'Dibaca ' . $tglRiwayat . '';
									$readColor = '#16A0E2';
								} else if ($receive->action == 'proses_revisi' || $receive->action == 'update') {
									$description4 = 'Proses Revisi ' . $tglRiwayat . '';
									$readColor = '#ba35dc';
								} else if ($receive->action == 'tolak') {
									$description4 = 'Ditolak ' . $tglRiwayat . '';
									$readColor = '#DC3545';
								}
							} else {
								if ($receive->action == 'selesai') {
									$description4 = 'Diselesaikan ' . $tglRiwayat . '';
									$readColor = '#27AE60';
								} else if ($receive->action == 'dibatalkan' || $receive->action == 'batal') {
									$description4 = 'dibatalkan pada ' . $tglRiwayat . '';
									$readColor = '#DC3545';
								} else if ($receive->action == 'sudah') {
									if ($idPembuat == $idPengirim) {
										$description4 = 'Didisposisi ' . $tglRiwayat . '';
										$readColor = '#16A0E2';
									} else {
										$description4 = 'Didisposisi ' . $tglRiwayat . '';
										$readColor = '#16A0E2';
									}
								} else if ($receive->action == 'belum') {
									$description4 = 'Dibaca ' . $tglRiwayat . '';
									$readColor = '#16A0E2';
								} else if ($receive->action == 'proses_revisi' || $receive->action == 'update') {
									$description4 = 'Revisi ' . $tglRiwayat . '';
									$readColor = '#ba35dc';
								} else if ($receive->action == 'tolak') {
									$description4 = 'Ditolak ' . $tglRiwayat . '';
									$readColor = '#DC3545';
								}
							}
						} else {
							$description4 = 'Belum dibaca';
							$readColor = '#F39C12';
						}

						$ret[] = array(
							'message' => 'Sukses',
							'user' => $penerima,
							'jabUser' => $jabPenerima,
							'time' => $tglRiwayat,
							'description2' => $isiDisposisi,
							'description3' => $actionTxt,
							'description4' => $description4,
							'readColor' => $readColor,
						);
					}
				}
			}
		} else {
			$ret[] = array(
				'message' => 'Gagal',
			);
		}

		// echo json_encode($idPengirim .'=='. $lastUser{0}->send_user_id);
		echo json_encode($ret);
	}


	public function cekStatusSurat()
	{
		$idSurat = $this->uri->segment(3);
		$idUser = $this->uri->segment(4);

		$cekSelesaiSurat = $this->M_Suratmasuk->cekSelesaiSurat($idSurat);
		$cekStatusSurat = $this->M_Suratmasuk->cekStatusSurat($idSurat, $idUser);
		$cekStatusDispos = $this->M_Suratmasuk->cekStatusDispos($idSurat, $idUser);
		$cekLastActionDispos = $this->M_Suratmasuk->cekLastActionDispos($idSurat);
		if (count($cekStatusDispos) > 0) {
			if (($cekLastActionDispos{
				0}->action == 'selesai')) {
				$actionDispos = 'selesai';
			} else if ($cekLastActionDispos{
				0}->action == 'setuju') {
				$actionDispos = 'sudah';
			} else {
				$actionDispos = $cekStatusDispos[0]->action;
			}
		} else {
			$actionDispos = 'belum';
		}
		if ($cekStatusSurat != null) {
			if ($cekStatusSurat[0]->action == 'setuju') {
				$actionSurat = 'sudah';
			} else {
				$actionSurat = $cekStatusSurat[0]->action;
			}
		} else {
			$actionSurat = 'sudah';
		}


		$actionSelesai = $cekSelesaiSurat[0]->status_surat;

		$ret[] = array(
			'actionSurat' => $actionSurat,
			'actionDispos' => $actionDispos,
			'actionSelesai' => $actionSelesai
		);

		echo json_encode($ret);
	}

	public function submitRevisiFile()
	{
		$idSurat = $this->uri->segment(3);
		$idUser = $this->uri->segment(4);
		$nmUser = urldecode($this->uri->segment(5));
		$nmJabatan = urldecode($this->uri->segment(6));
		$fileStatus = $this->uri->segment(7);
		$actionTxt = urldecode($this->uri->segment(8));
		$created_dttm = date('Y-m-d H:i:s');

		$getUserTujuan = $this->M_Suratmasuk->getIdCreatedSurat($idSurat);
		$idTujuan = $getUserTujuan{
			0}->created_user;
		$nmTujuan = $getUserTujuan{
			0}->nama;
		$jabatanTujuan = $getUserTujuan{
			0}->nmJabatan;

		$responseTxt = '<span class="tx-danger">Telah memeriksa dan merivisi surat, </span>Melanjutkan proses perbaikann surat kepada <b>' . $nmTujuan . '</b> (<em>' . $jabatanTujuan . '</em>)';
		if (!empty($getUserTujuan)) {
			$dataUpdate = array(
				'action' => 'revisi',
			);
			$updateRevisi = $this->M_Suratmasuk->updateResponseRevisi($idSurat, $idUser, $dataUpdate);
			if ($updateRevisi == true) {
				$dataRevisi = array(
					'idSurat' => $idSurat,
					'action_txt' => $actionTxt,
					'send_user_id' => $idUser,
					'receive_user_id' => $idTujuan,
					'action' => 'proses_revisi',
					'response_txt' => $responseTxt,
					'created_dttm' => $created_dttm
				);
				$submitRevisi = $this->M_Suratmasuk->submitRevisi($dataRevisi);
				$idResponse = $submitRevisi;
				if ($submitRevisi == true) {
					$cekRecieveId = $this->M_Suratmasuk->cekRecieveId($idSurat);
					$perihal = $cekRecieveId{
						0}->perihal;
					$perihalTxt = substr($perihal, 0, 100) . '. . .';
					$cekSession = $this->M_pushnotif->cekSession($idTujuan);
					if (count($cekSession) > 0) {
						foreach ($cekSession as $data) {
							$userDevice_id = $data->user_id_device;
							$notif = $this->M_pushnotif->sendRevisi($userDevice_id, $nmUser, $nmJabatan, $perihalTxt);
							$ret[] = array(
								'message' => 'Sukses',
							);
						}
					} else {
						$ret[] = array(
							'message' => 'Sukses',
						);
					}
				}
				if ($fileStatus == true) {
					if ($idResponse > 0) {
						$count = count($_FILES['files']['name']);
						for ($i = 0; $i < $count; $i++) {
							$_FILES['file']['name']     = $_FILES['files']['name'][$i];
							$_FILES['file']['type']     = $_FILES['files']['type'][$i];
							// error_log(print_r($_FILES['file']['type'],TRUE));
							list($image, $ext) = explode('/', $_FILES['file']['type']);
							$_FILES['file']['tmp_name'] = $_FILES['files']['tmp_name'][$i];
							$_FILES['file']['error']     = $_FILES['files']['error'][$i];
							$_FILES['file']['size']     = $_FILES['files']['size'][$i];
							$config['file_name'] = $_FILES['files']['name'][$i] . '_' . $idResponse . '.' . $ext;
							$config['upload_path'] = '../dosis/dokumen_revisi/';
							$config['allowed_types'] = '*';
							$config['max_size']      = '0';
							$config['image_library'] = 'gd2';
							$this->load->library('upload', $config);
							$this->upload->initialize($config);

							if (!empty($_FILES['files']['name'][$i])) {
								if ($this->upload->do_upload('file')) {
									$uploadData[] = $this->upload->data();
								} else {
									$ret[] = array('message' => 'Gagal Upload');
								}
							}

							$dataImage = array(
								'idRespon' => $idResponse,
								'nmFile' => $config['file_name'],
								'created_user' => $idUser,
								'created_date' => $created_dttm
							);
							$insertFileRevisi = $this->M_Suratmasuk->insertFileRevisi($dataImage);
							if ($insertFileRevisi == true) {
								$ret[] = array('message' => 'Sukses');
							} else {
								$ret[] = array('message' => 'Gagal Insert File');
							}
						}
					} else {
						$ret[] = array('message' => 'Input Gagal');
					}
				}
			} else {
				$ret[] = array('message' => 'Update Gagal');
			}
		} else {
			$ret[] = array('message' => 'Data tidak Ditemukan');
		}

		echo json_encode($ret);
	}

	public function submitRevisi()
	{
		$idSurat = $this->uri->segment(3);
		$idUser = $this->uri->segment(4);
		$nmUser = urldecode($this->uri->segment(5));
		$nmJabatan = urldecode($this->uri->segment(6));
		$fileStatus = $this->uri->segment(7);
		$actionTxt = urldecode($this->uri->segment(8));
		$created_dttm = date('Y-m-d H:i:s');

		$getUserTujuan = $this->M_Suratmasuk->getIdCreatedSurat($idSurat);
		$idTujuan = $getUserTujuan{
			0}->created_user;
		$nmTujuan = $getUserTujuan{
			0}->nama;
		$jabatanTujuan = $getUserTujuan{
			0}->nmJabatan;

		$responseTxt = '<span class="tx-danger">Telah memeriksa dan merivisi surat, </span>Melanjutkan proses perbaikann surat kepada <b>' . $nmTujuan . '</b> (<em>' . $jabatanTujuan . '</em>)';
		if (!empty($getUserTujuan)) {
			$dataUpdate = array(
				'action' => 'revisi',
			);
			$updateRevisi = $this->M_Suratmasuk->updateResponseRevisi($idSurat, $idUser, $dataUpdate);
			if ($updateRevisi == true) {
				$dataRevisi = array(
					'idSurat' => $idSurat,
					'action_txt' => $actionTxt,
					'send_user_id' => $idUser,
					'receive_user_id' => $idTujuan,
					'action' => 'proses_revisi',
					'response_txt' => $responseTxt,
					'created_dttm' => $created_dttm
				);
				$submitRevisi = $this->M_Suratmasuk->submitRevisi($dataRevisi);
				if ($submitRevisi == true) {
					$cekRecieveId = $this->M_Suratmasuk->cekRecieveId($idSurat);
					$perihal = $cekRecieveId{
						0}->perihal;
					$perihalTxt = substr($perihal, 0, 100) . '. . .';
					$cekSession = $this->M_pushnotif->cekSession($idTujuan);
					if (count($cekSession) > 0) {
						foreach ($cekSession as $data) {
							$userDevice_id = $data->user_id_device;
							$notif = $this->M_pushnotif->sendRevisi($userDevice_id, $nmUser, $nmJabatan, $perihalTxt);
							$ret[] = array(
								'message' => 'Sukses',
							);
						}
					} else {
						$ret[] = array(
							'message' => 'Sukses',
						);
					}
				} else {
					$ret[] = array(
						'message' => 'Gagal',
					);
				}
			} else {
				$ret[] = array('message' => 'Update Gagal');
			}
		} else {
			$ret[] = array('message' => 'Data tidak Ditemukan');
		}

		echo json_encode($ret);
	}
}
