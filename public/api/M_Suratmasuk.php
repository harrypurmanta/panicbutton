<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_Suratmasuk extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}


	public function getSuratSort($tipe, $idUser, $dateStart, $dateEnd)
	{
		$this->db->select('a.idResponse,
                           b.idSurat,b.tipe,b.trackID,b.koresponden,b.noSurat,b.tglSurat,b.tglTempo,b.perihal,
                           b.created_user,b.created_date,b.status_surat,b.status_respon,
                           c.kdKlas,c.nmKlas,
                           d.nmSifat,
                           a.send_user_id,a.receive_user_id,a.action,a.read_status,a.read_dttm,a.created_dttm');
		$this->db->from('response a');
		$this->db->join('surat b', 'a.idSurat=b.idSurat', 'left');
		$this->db->join('klasifikasi c', 'b.idKlas=c.idKlas', 'left');
		$this->db->join('sifat d', 'b.idSifat=d.idSifat', 'left');
		$this->db->where('b.tipe', $tipe);
		$this->db->where("(b.status_surat!='nullified')");
		$this->db->where('a.receive_user_id', $idUser);
		$this->db->where('a.created_dttm >=', $dateStart);
		$this->db->where('a.created_dttm <=', $dateEnd);
		$this->db->group_by('b.idSurat');
		$this->db->order_by('a.created_dttm', 'DESC');
		$query = $this->db->get();
		return $query->result();
	}

	public function getSuratAllTemp($tipe, $idUser)
	{
		$this->db->select('a.idResponse,
                           b.idSurat,b.tipe,b.trackID,b.koresponden,b.noSurat,b.tglSurat,b.tglTempo,b.perihal,
                           b.created_user,b.created_date,b.status_surat,b.status_respon,
                           c.kdKlas,c.nmKlas,
                           d.nmSifat,
                           a.send_user_id,a.receive_user_id,a.action,a.read_status,a.read_dttm,a.created_dttm');
		$this->db->from('response a');
		$this->db->join('surat b', 'a.idSurat=b.idSurat', 'left');
		$this->db->join('klasifikasi c', 'b.idKlas=c.idKlas', 'left');
		$this->db->join('sifat d', 'b.idSifat=d.idSifat', 'left');
		$this->db->where('b.tipe', $tipe);
		$this->db->where("(b.status_surat!='nullified')");
		$this->db->where("(a.send_user_id=$idUser or a.receive_user_id=$idUser)");
		$this->db->group_by('b.idSurat');
		$this->db->order_by('a.created_dttm', 'DESC');
		$query = $this->db->get();
		return $query->result();
	}

	public function getSuratAll($tipe, $idUser, $limit, $start)
	{
		$this->db->select('a.idResponse,
                           b.idSurat,b.tipe,b.trackID,b.koresponden,b.noSurat,b.tglSurat,b.tglTempo,b.perihal,
                           b.created_user,b.created_date,b.status_surat,b.status_respon,
                           c.kdKlas,c.nmKlas,
                           d.nmSifat,
                           a.send_user_id,a.receive_user_id,a.action,a.read_status,a.read_dttm,a.created_dttm');
		$this->db->from('response a');
		$this->db->join('surat b', 'a.idSurat=b.idSurat', 'left');
		$this->db->join('klasifikasi c', 'b.idKlas=c.idKlas', 'left');
		$this->db->join('sifat d', 'b.idSifat=d.idSifat', 'left');
		$this->db->where('b.tipe', $tipe);
		$this->db->where("(b.status_surat!='nullified')");
		$this->db->where('a.action !=', 'mulai');
		$this->db->where("(a.send_user_id=$idUser or a.receive_user_id=$idUser)");
		$this->db->group_by('b.idSurat');
		$this->db->order_by('a.created_dttm', 'DESC');
		$this->db->limit($limit, $start);
		$query = $this->db->get();
		return $query->result();
	}

	public function getSuratBelumTLTemp($tipe, $idUser)
	{
		$this->db->select('a.idResponse,
                           b.idSurat,b.tipe,b.trackID,b.koresponden,b.noSurat,b.tglSurat,b.tglTempo,b.perihal,
                           b.created_user,b.created_date,b.status_surat,b.status_respon,
                           c.kdKlas,c.nmKlas,
                           d.nmSifat,
                           a.send_user_id,a.receive_user_id,a.action,a.read_status,a.read_dttm,a.created_dttm');
		$this->db->from('response a');
		$this->db->join('surat b', 'a.idSurat=b.idSurat', 'left');
		$this->db->join('klasifikasi c', 'b.idKlas=c.idKlas', 'left');
		$this->db->join('sifat d', 'b.idSifat=d.idSifat', 'left');
		$this->db->where('b.tipe', $tipe);
		$this->db->where('b.status_surat', 'normal');
		$this->db->where('a.action', 'belum');
		$this->db->where('a.receive_user_id', $idUser);
		$this->db->group_by('b.idSurat');
		$this->db->order_by('a.created_dttm', 'DESC');
		$query = $this->db->get();
		return $query->result();
	}


	public function getSuratBelumTL($tipe, $idUser, $limit, $start)
	{
		$this->db->select('a.idResponse,
                           b.idSurat,b.tipe,b.trackID,b.koresponden,b.noSurat,b.tglSurat,b.tglTempo,b.perihal,
                           b.created_user,b.created_date,b.status_surat,b.status_respon,
                           c.kdKlas,c.nmKlas,
                           d.nmSifat,
                           a.send_user_id,a.receive_user_id,a.action,a.read_status,a.read_dttm,a.created_dttm');
		$this->db->from('response a');
		$this->db->join('surat b', 'a.idSurat=b.idSurat', 'left');
		$this->db->join('klasifikasi c', 'b.idKlas=c.idKlas', 'left');
		$this->db->join('sifat d', 'b.idSifat=d.idSifat', 'left');
		$this->db->where('b.tipe', $tipe);
		$this->db->where('b.status_surat', 'normal');
		$this->db->where('a.action', 'belum');
		$this->db->where('a.receive_user_id', $idUser);
		$this->db->group_by('b.idSurat');
		$this->db->order_by('a.created_dttm', 'DESC');
		$this->db->limit($limit, $start);
		$query = $this->db->get();
		return $query->result();
	}

	public function getSuratSudahTLTemp($tipe, $idUser)
	{
		$action = array('belum');
		$this->db->select('a.idResponse,
                           b.idSurat,b.tipe,b.trackID,b.koresponden,b.noSurat,b.tglSurat,b.tglTempo,b.perihal,
                           b.created_user,b.created_date,b.status_surat,b.status_respon,
                           c.kdKlas,c.nmKlas,
                           d.nmSifat,
                           a.send_user_id,a.receive_user_id,a.action,a.read_status,a.read_dttm,a.created_dttm');
		$this->db->from('response a');
		$this->db->join('surat b', 'a.idSurat=b.idSurat', 'left');
		$this->db->join('klasifikasi c', 'b.idKlas=c.idKlas', 'left');
		$this->db->join('sifat d', 'b.idSifat=d.idSifat', 'left');
		$this->db->where('b.tipe', $tipe);
		$this->db->where('b.status_surat', 'normal');
		$this->db->where_in('a.action', $action);
		$this->db->where('a.send_user_id', $idUser);
		$this->db->group_by('b.idSurat');
		$this->db->order_by('a.created_dttm', 'DESC');
		$query = $this->db->get();
		return $query->result();
	}

	public function getSuratSudahTL($tipe, $idUser, $limit, $start)
	{
		$action = array('belum', 'proses_revisi');
		$this->db->select('a.idResponse,
                           b.idSurat,b.tipe,b.trackID,b.koresponden,b.noSurat,b.tglSurat,b.tglTempo,b.perihal,
                           b.created_user,b.created_date,b.status_surat,b.status_respon,
                           c.kdKlas,c.nmKlas,
                           d.nmSifat,
                           a.send_user_id,a.receive_user_id,a.action,a.read_status,a.read_dttm,a.created_dttm');
		$this->db->from('response a');
		$this->db->join('surat b', 'a.idSurat=b.idSurat', 'left');
		$this->db->join('klasifikasi c', 'b.idKlas=c.idKlas', 'left');
		$this->db->join('sifat d', 'b.idSifat=d.idSifat', 'left');
		$this->db->where('b.tipe', $tipe);
		$this->db->where('b.status_surat', 'normal');
		$this->db->where_in('a.action', $action);
		$this->db->where('a.send_user_id', $idUser);
		$this->db->group_by('b.idSurat');
		$this->db->order_by('a.created_dttm', 'DESC');
		$this->db->limit($limit, $start);
		$query = $this->db->get();
		return $query->result();
	}

	public function getSuratRevisiTemp($tipe, $idUser)
	{
		$this->db->select('a.idResponse,
                           b.idSurat,b.tipe,b.trackID,b.koresponden,b.noSurat,b.tglSurat,b.tglTempo,b.perihal,
                           b.created_user,b.created_date,b.status_surat,b.status_respon,
                           c.kdKlas,c.nmKlas,
                           d.nmSifat,
                           a.send_user_id,a.receive_user_id,a.action,a.read_status,a.read_dttm,a.created_dttm');
		$this->db->from('response a');
		$this->db->join('surat b', 'a.idSurat=b.idSurat', 'left');
		$this->db->join('klasifikasi c', 'b.idKlas=c.idKlas', 'left');
		$this->db->join('sifat d', 'b.idSifat=d.idSifat', 'left');
		$this->db->where('b.tipe', $tipe);
		$this->db->where('b.status_surat', 'normal');
		$this->db->where('a.action', 'proses_revisi');
		$this->db->where('a.receive_user_id', $idUser);
		$this->db->group_by('b.idSurat');
		$this->db->order_by('a.created_dttm', 'DESC');
		$query = $this->db->get();
		return $query->result();
	}


	public function getSuratRevisi($tipe, $idUser, $limit, $start)
	{
		$this->db->select('a.idResponse,
                           b.idSurat,b.tipe,b.trackID,b.koresponden,b.noSurat,b.tglSurat,b.tglTempo,b.perihal,
                           b.created_user,b.created_date,b.status_surat,b.status_respon,
                           c.kdKlas,c.nmKlas,
                           d.nmSifat,
                           a.send_user_id,a.receive_user_id,a.action,a.read_status,a.read_dttm,a.created_dttm');
		$this->db->from('response a');
		$this->db->join('surat b', 'a.idSurat=b.idSurat', 'left');
		$this->db->join('klasifikasi c', 'b.idKlas=c.idKlas', 'left');
		$this->db->join('sifat d', 'b.idSifat=d.idSifat', 'left');
		$this->db->where('b.tipe', $tipe);
		$this->db->where('b.status_surat', 'normal');
		$this->db->where('a.action', 'proses_revisi');
		$this->db->where('a.receive_user_id', $idUser);
		$this->db->group_by('b.idSurat');
		$this->db->order_by('a.created_dttm', 'DESC');
		$this->db->limit($limit, $start);
		$query = $this->db->get();
		return $query->result();
	}


	public function getSuratBatalTemp($tipe, $idUser)
	{
		$action = array('batal', 'dibatalkan');
		$this->db->select('a.idResponse,
                           b.idSurat,b.tipe,b.trackID,b.koresponden,b.noSurat,b.tglSurat,b.tglTempo,b.perihal,
                           b.created_user,b.created_date,b.status_surat,b.status_respon,
                           c.kdKlas,c.nmKlas,
                           d.nmSifat,
                           a.send_user_id,a.receive_user_id,a.action,a.read_status,a.read_dttm,a.created_dttm');
		$this->db->from('response a');
		$this->db->join('surat b', 'a.idSurat=b.idSurat', 'left');
		$this->db->join('klasifikasi c', 'b.idKlas=c.idKlas', 'left');
		$this->db->join('sifat d', 'b.idSifat=d.idSifat', 'left');
		$this->db->where('b.tipe', $tipe);
		$this->db->where('b.status_surat', 'normal');
		$this->db->where_in('a.action', $action);
		$this->db->where('a.receive_user_id', $idUser);
		$this->db->group_by('b.idSurat');
		$this->db->order_by('a.created_dttm', 'DESC');
		$query = $this->db->get();
		return $query->result();
	}

	public function getSuratBatal($tipe, $idUser, $limit, $start)
	{
		$action = array('batal', 'dibatalkan');
		$this->db->select('a.idResponse,
                           b.idSurat,b.tipe,b.trackID,b.koresponden,b.noSurat,b.tglSurat,b.tglTempo,b.perihal,
                           b.created_user,b.created_date,b.status_surat,b.status_respon,
                           c.kdKlas,c.nmKlas,
                           d.nmSifat,
                           a.send_user_id,a.receive_user_id,a.action,a.read_status,a.read_dttm,a.created_dttm');
		$this->db->from('response a');
		$this->db->join('surat b', 'a.idSurat=b.idSurat', 'left');
		$this->db->join('klasifikasi c', 'b.idKlas=c.idKlas', 'left');
		$this->db->join('sifat d', 'b.idSifat=d.idSifat', 'left');
		$this->db->where('b.tipe', $tipe);
		$this->db->where('b.status_surat', 'normal');
		$this->db->where_in('a.action', $action);
		$this->db->where('a.receive_user_id', $idUser);
		$this->db->group_by('b.idSurat');
		$this->db->order_by('a.created_dttm', 'DESC');
		$this->db->limit($limit, $start);

		$query = $this->db->get();
		return $query->result();
	}

	public function getSuratSelesaiTemp($tipe, $idUser)
	{
		$this->db->select('a.idResponse,
                           b.idSurat,b.tipe,b.trackID,b.koresponden,b.noSurat,b.tglSurat,b.tglTempo,b.perihal,
                           b.created_user,b.created_date,b.status_surat,b.status_respon,
                           c.kdKlas,c.nmKlas,
                           d.nmSifat,
                           a.send_user_id,a.receive_user_id,a.action,a.read_status,a.read_dttm,a.created_dttm');
		$this->db->from('response a');
		$this->db->join('surat b', 'a.idSurat=b.idSurat', 'left');
		$this->db->join('klasifikasi c', 'b.idKlas=c.idKlas', 'left');
		$this->db->join('sifat d', 'b.idSifat=d.idSifat', 'left');
		$this->db->where('b.tipe', $tipe);
		$this->db->where('b.status_surat', 'finish');
		$this->db->where("(a.send_user_id=$idUser or a.receive_user_id=$idUser)");
		$this->db->group_by('b.idSurat');
		$this->db->order_by('a.created_dttm', 'DESC');
		$query = $this->db->get();
		return $query->result();
	}

	public function getSuratSelesai($tipe, $idUser, $limit, $start)
	{
		$this->db->select('a.idResponse,
                           b.idSurat,b.tipe,b.trackID,b.koresponden,b.noSurat,b.tglSurat,b.tglTempo,b.perihal,
                           b.created_user,b.created_date,b.status_surat,b.status_respon,
                           c.kdKlas,c.nmKlas,
                           d.nmSifat,
                           a.send_user_id,a.receive_user_id,a.action,a.read_status,a.read_dttm,a.created_dttm');
		$this->db->from('response a');
		$this->db->join('surat b', 'a.idSurat=b.idSurat', 'left');
		$this->db->join('klasifikasi c', 'b.idKlas=c.idKlas', 'left');
		$this->db->join('sifat d', 'b.idSifat=d.idSifat', 'left');
		$this->db->where('b.tipe', $tipe);
		$this->db->where('b.status_surat', 'finish');
		$this->db->where("(a.send_user_id=$idUser or a.receive_user_id=$idUser)");
		$this->db->group_by('b.idSurat');
		$this->db->order_by('a.created_dttm', 'DESC');
		$this->db->limit($limit, $start);
		$query = $this->db->get();
		return $query->result();
	}

	public function getSuratTolakTemp($tipe, $idUser)
	{
		$this->db->select('a.idResponse,
                           b.idSurat,b.tipe,b.trackID,b.koresponden,b.noSurat,b.tglSurat,b.tglTempo,b.perihal,
                           b.created_user,b.created_date,b.status_surat,b.status_respon,
                           c.kdKlas,c.nmKlas,
                           d.nmSifat,
                           a.send_user_id,a.receive_user_id,a.action,a.read_status,a.read_dttm,a.created_dttm');
		$this->db->from('response a');
		$this->db->join('surat b', 'a.idSurat=b.idSurat', 'left');
		$this->db->join('klasifikasi c', 'b.idKlas=c.idKlas', 'left');
		$this->db->join('sifat d', 'b.idSifat=d.idSifat', 'left');
		$this->db->where('b.tipe', $tipe);
		$this->db->where('b.status_surat', 'rejected');
		$this->db->where("(a.send_user_id=$idUser or a.receive_user_id=$idUser)");
		$this->db->group_by('b.idSurat');
		$this->db->order_by('a.created_dttm', 'DESC');
		$query = $this->db->get();
		return $query->result();
	}

	public function getSuratTolak($tipe, $idUser, $limit, $start)
	{
		$this->db->select('a.idResponse,
                           b.idSurat,b.tipe,b.trackID,b.koresponden,b.noSurat,b.tglSurat,b.tglTempo,b.perihal,
                           b.created_user,b.created_date,b.status_surat,b.status_respon,
                           c.kdKlas,c.nmKlas,
                           d.nmSifat,
                           a.send_user_id,a.receive_user_id,a.action,a.read_status,a.read_dttm,a.created_dttm');
		$this->db->from('response a');
		$this->db->join('surat b', 'a.idSurat=b.idSurat', 'left');
		$this->db->join('klasifikasi c', 'b.idKlas=c.idKlas', 'left');
		$this->db->join('sifat d', 'b.idSifat=d.idSifat', 'left');
		$this->db->where('b.tipe', $tipe);
		$this->db->where('b.status_surat', 'rejected');
		$this->db->where("(a.send_user_id=$idUser or a.receive_user_id=$idUser)");
		$this->db->group_by('b.idSurat');
		$this->db->order_by('a.created_dttm', 'DESC');
		$this->db->limit($limit, $start);
		$query = $this->db->get();
		return $query->result();
	}

	public function getSuratMasukDeleted($idUser)
	{
		$this->db->select('a.idResponse,
                           b.idSurat,b.tipe,b.trackID,b.koresponden,b.noSurat,b.tglSurat,b.tglTempo,b.perihal,
                           b.created_user,b.created_date,b.status_surat,b.status_respon,
                           c.kdKlas,c.nmKlas,
                           d.nmSifat,
                           a.send_user_id,a.receive_user_id,a.action,a.read_status,a.read_dttm,a.created_dttm');
		$this->db->from('response a');
		$this->db->join('surat b', 'a.idSurat=b.idSurat', 'left');
		$this->db->join('klasifikasi c', 'b.idKlas=c.idKlas', 'left');
		$this->db->join('sifat d', 'b.idSifat=d.idSifat', 'left');
		$this->db->where('b.status_surat', 'nullified');
		$this->db->where("(a.send_user_id=$idUser or a.receive_user_id=$idUser)");
		$this->db->group_by('b.idSurat');
		$this->db->order_by('a.created_dttm', 'DESC');
		$query = $this->db->get();
		return $query->result();
	}

	public function getaction($id, $idUser)
	{
		$this->db->select('action, read_status, read_dttm, created_dttm');
		$this->db->where('idSurat', $id);
		$this->db->where('receive_user_id', $idUser);
		$this->db->order_by('created_dttm', 'DESC');
		$this->db->limit(1);
		$query = $this->db->get('response');
		return $query->result();
	}

	public function getaction2($id)
	{
		$this->db->select('action, read_status, read_dttm, created_dttm,receive_user_id');
		$this->db->where('idSurat', $id);
		$this->db->order_by('created_dttm', 'DESC');
		$this->db->limit(1);
		$query = $this->db->get('response');
		return $query->result();
	}

	public function cekSurat($id)
	{
		$this->db->select('file_path, file_nm');
		$this->db->where('idSurat', $id);
		$query = $this->db->get('file');
		return $query->result();
	}

	public function getDetail($idSurat)
	{
		$this->db->select('a.idSurat,a.tipe,a.trackID,a.noUrut,a.koresponden,a.noSurat,a.tglSurat,a.tglTempo,a.perihal,
                           a.isi,a.fileSurat,a.created_user,a.created_date,a.status_surat,a.status_respon,
                           b.kdKlas,b.nmKlas,
                           c.nmSifat');
		$this->db->from('surat a');
		$this->db->join('klasifikasi b', 'a.idKlas=b.idKlas', 'left');
		$this->db->join('sifat c', 'a.idSifat=c.idSifat', 'left');
		$this->db->where('a.idSurat', $idSurat);
		$query = $this->db->get();
		return $query->result();
	}

	public function getTembusanSuratMasukTemp($tipe, $idUser)
	{
		$this->db->select('a.idTembusan,a.tglTembusan,
                           b.idSurat,b.tipe,b.trackID,b.koresponden,b.noSurat,b.tglSurat,b.tglTempo,b.perihal,
                           b.created_user,b.created_date,b.status_surat,b.status_respon,
                           d.kdKlas,d.nmKlas,
                           e.nmSifat,
                           a.tembusan_txt,a.dari,a.untuk,a.cek,a.tglRead,a.del');
		$this->db->from('tembusan a');
		$this->db->join('surat b', 'a.idSurat=b.idSurat', 'left');
		$this->db->join('klasifikasi d', 'b.idKlas=d.idKlas', 'left');
		$this->db->join('sifat e', 'b.idSifat=e.idSifat', 'left');
		$this->db->where('b.tipe', $tipe);
		$this->db->where('a.untuk', $idUser);
		$this->db->order_by('a.tglTembusan', 'DESC');
		$query = $this->db->get();
		return $query->result();
	}

	public function getTembusanSuratMasuk($tipe, $idUser, $limit, $start)
	{
		$this->db->select('a.idTembusan,a.tglTembusan,
                           b.idSurat,b.tipe,b.trackID,b.koresponden,b.noSurat,b.tglSurat,b.tglTempo,b.perihal,
                           b.created_user,b.created_date,b.status_surat,b.status_respon,
                           d.kdKlas,d.nmKlas,
                           e.nmSifat,
                           a.tembusan_txt,a.dari,a.untuk,a.cek,a.tglRead,a.del');
		$this->db->from('tembusan a');
		$this->db->join('surat b', 'a.idSurat=b.idSurat', 'left');
		$this->db->join('klasifikasi d', 'b.idKlas=d.idKlas', 'left');
		$this->db->join('sifat e', 'b.idSifat=e.idSifat', 'left');
		$this->db->where('b.tipe', $tipe);
		$this->db->where('a.untuk', $idUser);
		$this->db->order_by('a.tglTembusan', 'DESC');
		$this->db->limit($limit, $start);
		$query = $this->db->get();
		return $query->result();
	}

	public function getTembusanSuratKeluar($idUser)
	{
		$this->db->select('a.idTembusan,a.tglTembusan,
                           b.idSurat,b.tipe,b.trackID,b.koresponden,b.noSurat,b.tglSurat,b.tglTempo,b.perihal,
                           b.created_user,b.created_date,b.status_surat,b.status_respon,
                           d.kdKlas,d.nmKlas,
                           e.nmSifat,
                           a.tembusan_txt,a.dari,a.untuk,a.cek,a.tglRead,a.del');
		$this->db->from('tembusan a');
		$this->db->join('surat b', 'a.idSurat=b.idSurat', 'left');
		$this->db->join('klasifikasi d', 'b.idKlas=d.idKlas', 'left');
		$this->db->join('sifat e', 'b.idSifat=e.idSifat', 'left');
		$this->db->where('b.tipe', 'OUT');
		$this->db->where('a.untuk', $idUser);
		$this->db->order_by('a.tglTembusan', 'DESC');
		$query = $this->db->get();
		return $query->result();
	}



	public function getLastUser($id)
	{
		$this->db->select('a.send_user_id,a.receive_user_id, b.nama as lastUser, c.nmJabatan as jabLastUser, a.read_dttm as read_dttm,a.read_status, a.action,a.action_txt, a.created_dttm, d.nmDisposisi');
		$this->db->join('users b', 'a.receive_user_id=b.idUser', 'left');
		$this->db->join('jabatan c', 'b.idJabatan=c.idJabatan', 'left');
		$this->db->join('isi_disposisi d', 'a.idIsi=d.idIsi', 'left');
		$this->db->where('a.idSurat', $id);
		$this->db->order_by('a.idResponse', 'DESC');
		$this->db->limit(1);
		$query = $this->db->get('response a');
		return $query->result();
	}

	public function getFirstUser($id)
	{
		$this->db->select('a.send_user_id,a.receive_user_id, b.nama as firstUser, c.nmJabatan as jabLastUser, a.read_dttm as read_dttm,a.read_status, a.action,a.action_txt, a.created_dttm, d.nmDisposisi');
		$this->db->join('users b', 'a.send_user_id=b.idUser', 'left');
		$this->db->join('jabatan c', 'b.idJabatan=c.idJabatan', 'left');
		$this->db->join('isi_disposisi d', 'a.idIsi=d.idIsi', 'left');
		$this->db->where('a.idSurat', $id);
		$this->db->limit(1);
		$query = $this->db->get('response a');
		return $query->result();
	}

	public function getActionTxt($idSurat, $idUser)
	{
		$this->db->select('a.action_txt, b.nmDisposisi');
		$this->db->join('isi_disposisi b', 'a.idIsi=b.idIsi', 'left');
		$this->db->where('a.idSurat', $idSurat);
		$this->db->where('a.send_user_id', $idUser);
		$query = $this->db->get('response a');
		return $query->result();
	}

	public function getLastUserLog($trackId)
	{
		$this->db->select('a.idResponse,a.receive_user_id, b.nama as lastUser, c.nmJabatan as jabLastUser, a.read_dttm as read_dttm,a.read_status, a.action, d.tipe');
		$this->db->join('users b', 'a.receive_user_id=b.idUser', 'left');
		$this->db->join('jabatan c', 'b.idJabatan=c.idJabatan', 'left');
		$this->db->join('surat d', 'a.idSurat=d.idSurat', 'left');
		$this->db->where('d.trackId', $trackId);
		$this->db->order_by('a.idResponse', 'DESC');
		$this->db->limit(1);
		$query = $this->db->get('response a');
		return $query->result();
	}

	public function getRiwayat($idSurat)
	{

		$this->db->select('a.idResponse, a.idSurat, a.action_txt,a.read_status, a.action, a.read_dttm, a.created_dttm,a.send_user_id,a.receive_user_id, ,b.created_user, c.nmDisposisi, d.nama as pengirim, e.nama as penerima, f.nmJabatan as jabPengirim, g.nmJabatan as jabPenerima, b.status_surat, b.tipe, b.trackID');
		$this->db->from('response a');
		$this->db->join('surat b', 'a.idSurat=b.idSurat', 'left');
		$this->db->join('isi_disposisi c', 'a.idIsi=c.idIsi', 'left');
		$this->db->join('users d', 'a.send_user_id=d.idUser', 'left');
		$this->db->join('users e', 'a.receive_user_id=e.idUser', 'left');
		$this->db->join('jabatan f', 'f.idJabatan=d.idJabatan', 'left');
		$this->db->join('jabatan g', 'g.idJabatan=e.idJabatan', 'left');
		$this->db->where('b.idSurat', $idSurat);
		$this->db->order_by('a.idResponse', 'ASC');
		$query = $this->db->get();
		return $query->result();
	}

	public function updateRead($data, $idSurat, $idUser)
	{
		$this->db->where('idSurat', $idSurat);
		$this->db->where('receive_user_id', $idUser);
		$this->db->where('read_status', 'N');
		$updateRead = $this->db->update('response', $data);
		return $updateRead;
	}
	public function updateRespon($data, $idSurat)
	{
		$this->db->where('action', 'belum');
		$this->db->where('idSurat', $idSurat);
		$updateRead = $this->db->update('response', $data);
		return $updateRead;
	}

	public function updateReadTembusan($data, $idSurat, $idUser)
	{
		$this->db->where('idSurat', $idSurat);
		$this->db->where('untuk', $idUser);
		$updateRead = $this->db->update('tembusan', $data);
		return $updateRead;
	}

	public function getUserDisposisi($idUser)
	{
		$this->db->select('a.idUser,b.kdJabatan,b.nmJabatan,a.nama');
		$this->db->from('users a');
		$this->db->join('jabatan b', 'a.idJabatan=b.idJabatan', 'left');
		$this->db->where('a.idUser !=', $idUser);
		$this->db->where('a.akses !=', 'Super Admin');
		$this->db->where('a.status', 'Active');
		$this->db->order_by('b.kdjabatan', 'ASC');
		$query = $this->db->get();
		return $query->result();
	}

	public function getIsiDisposisi()
	{
		$this->db->select('idIsi,nmDisposisi');
		$this->db->from('isi_disposisi');
		$this->db->order_by('idIsi', 'ASC');
		$query = $this->db->get();
		return $query->result();
	}

	public function updateResponseDisposisi1($data, $idSurat)
	{
		$this->db->where('action', 'belum');
		$this->db->where('idSurat', $idSurat);
		$updateResponseDisposisi1 = $this->db->update('response', $data);
		return $updateResponseDisposisi1;
	}

	public function updateResponseRevisi($idSurat, $idUser, $data)
	{
		$this->db->where('idSurat', $idSurat);
		$this->db->where('receive_user_id', $idUser);
		$this->db->order_by('idResponse', 'DESC');
		$this->db->limit(1);
		$result = $this->db->update('response', $data);
		return $result;
	}

	public function updateResponseDisposisi2($data, $idSurat, $idUser)
	{
		$this->db->where('idSurat', $idSurat);
		$this->db->where('receive_user_id', $idUser);
		$updateResponseDisposisi2 = $this->db->update('response', $data);
		return $updateResponseDisposisi2;
	}



	public function submitDisposisi($data, $data2)
	{
		$insertResponseDisposisi = $this->db->insert('response', $data);
		if ($insertResponseDisposisi == true) {
			$this->db->where('action', 'dibatalkan');
			$updateResponseDisposisi2 = $this->db->update('response', $data2);
		}
		return $insertResponseDisposisi;
	}

	public function submitRevisi($data)
	{
		$insert = $this->db->insert('response', $data);
		$response_id = $this->db->insert_id();
		return $response_id;
	}

	public function insertFileRevisi($data)
	{
		$result = $this->db->insert('file_respon', $data);
		return $result;
	}

	public function insertTembusan($data)
	{
		$insertTembusan = $this->db->insert('tembusan', $data);
		return $insertTembusan;
	}

	public function updateSuratSelesai($data, $idSurat)
	{
		$this->db->where('idSurat', $idSurat);
		$updateSuratSelesai = $this->db->update('surat', $data);
		return $updateSuratSelesai;
	}

	public function updateResponseSelesai1($data, $idSurat, $idUser)
	{
		$this->db->where('idSurat', $idSurat);
		$this->db->where('receive_user_id', $idUser);
		$updateResponseSelesai1 = $this->db->update('response', $data);
		return $updateResponseSelesai1;
	}

	public function updateResponseSelesai2($data, $idSurat)
	{
		$this->db->where('idSurat', $idSurat);
		$updateResponseSelesai2 = $this->db->update('response', $data);
		return $updateResponseSelesai2;
	}

	public function submitSelesai($data)
	{
		$insertResponseSelesai = $this->db->insert('response', $data);
		return $insertResponseSelesai;
	}

	public function submitTolak($data)
	{
		$insertResponseSelesai = $this->db->insert('response', $data);
		return $insertResponseSelesai;
	}


	public function submitBatal($data, $idSurat, $idUser)
	{
		$this->db->where('idSurat', $idSurat);
		$this->db->where('receive_user_id', $idUser);
		$updateBatal = $this->db->update('response', $data);
		return $updateBatal;
	}

	public function cekIdTujuan($idSurat)
	{
		$action = array('sudah', 'setuju');
		$this->db->select('receive_user_id');
		$this->db->from('response');
		$this->db->where('idSurat', $idSurat);
		$this->db->where_in('action', $action);
		$this->db->order_by('idResponse', 'DESC');
		$this->db->limit(1);
		$query = $this->db->get();
		return $query->result();
	}

	public function insertResponseBatal($data)
	{
		$insert = $this->db->insert('response', $data);
		return $insert;
	}


	public function getCountAllSM($idUser)
	{
		$this->db->select('a.idResponse');
		$this->db->from('response a');
		$this->db->join('surat b', 'a.idSurat=b.idSurat', 'left');
		$this->db->where('a.receive_user_id', $idUser);
		$this->db->where('b.tipe', 'IN');
		$this->db->group_by('a.idSurat');
		$query = $this->db->get();
		return $query->result();
	}

	public function getCountBelumSM($idUser)
	{
		$this->db->select('a.idResponse, b.tipe');
		$this->db->from('response a');
		$this->db->join('surat b', 'a.idSurat=b.idSurat', 'left');
		$this->db->where('a.receive_user_id', $idUser);
		$this->db->where('b.tipe', 'IN');
		$this->db->where('b.status_surat', 'normal');
		$this->db->where('a.action', 'belum');
		$this->db->group_by('a.idSurat');
		$query = $this->db->get();
		return $query->result();
	}

	public function getTotal($idUser, $tipe, $action)
	{
		$this->db->select('a.idResponse, b.tipe');
		$this->db->from('response a');
		$this->db->join('surat b', 'a.idSurat=b.idSurat', 'left');
		$this->db->where('a.receive_user_id', $idUser);
		$this->db->where('b.tipe', $tipe);
		$this->db->where('b.status_surat !=', 'nullified');
		$this->db->where('a.action', $action);
		$this->db->group_by('a.idSurat');
		$query = $this->db->get();
		return $query->result();
	}


	public function getCountSudahSM($idUser)
	{
		$this->db->select('a.idResponse, b.tipe,a.action');
		$this->db->from('response a');
		$this->db->join('surat b', 'a.idSurat=b.idSurat', 'left');
		$this->db->where('a.send_user_id', $idUser);
		$this->db->where('b.tipe', 'IN');
		$this->db->where('b.status_surat', 'normal');
		$this->db->group_by('a.idSurat');
		$query = $this->db->get();
		return $query->result();
	}

	public function getTotalSurat($idUser, $tipe)
	{
		$this->db->select('a.idResponse, b.tipe, a.action');
		$this->db->from('response a');
		$this->db->join('surat b', 'a.idSurat=b.idSurat', 'left');
		$this->db->where('a.receive_user_id', $idUser);
		$this->db->where('b.tipe', $tipe);
		$this->db->group_by('a.idSurat');
		$query = $this->db->get();
		return $query->result();
	}

	public function getsuratbae($iduser)
	{
		$this->db->select('a.idSurat,a.send_user_id');
		$this->db->from('response a');
		$this->db->join('surat b', 'b.idSurat=a.idSurat');
		$this->db->where('a.send_user_id', $iduser);
		$this->db->where('b.tipe', 'IN');
		$this->db->where('b.status_surat', 'normal');
		$this->db->group_by('a.idSurat');
		$this->db->order_by('a.created_dttm', 'DESC');
		$query = $this->db->get();
		return $query->result();
	}

	public function getprosessurat($idsurat, $tipe)
	{
		$this->db->select('a.idResponse,a.action,b.idSurat, a.receive_user_id');
		$this->db->from('response a');
		$this->db->join('surat b', 'b.idSurat=a.idSurat');
		$this->db->where('a.idSurat', $idsurat);
		$this->db->where('b.tipe', $tipe);
		$this->db->where('b.status_surat', 'normal');
		$this->db->order_by('a.created_dttm', 'DESC');
		$this->db->limit(1);
		$query = $this->db->get();
		return $query->result();
	}

	public function getCountBatalSM($idUser)
	{
		$this->db->select('a.idResponse, b.tipe');
		$this->db->from('response a');
		$this->db->join('surat b', 'a.idSurat=b.idSurat', 'left');
		$this->db->where('a.receive_user_id', $idUser);
		$this->db->where('b.tipe', 'IN');
		$this->db->where('b.status_surat', 'normal');
		$this->db->where('a.action', 'batal');
		$this->db->group_by('a.idSurat');
		$query = $this->db->get();
		return $query->result();
	}

	public function getCountSelesaiSM($idUser)
	{
		$this->db->select('a.idResponse, b.tipe');
		$this->db->from('response a');
		$this->db->join('surat b', 'a.idSurat=b.idSurat', 'left');
		$this->db->where('a.receive_user_id', $idUser);
		$this->db->where('b.tipe', 'IN');
		$this->db->where('b.status_surat', 'finish');
		$this->db->group_by('a.idSurat');
		$query = $this->db->get();
		return $query->result();
	}

	public function getCountDeletedSM($idUser)
	{
		$this->db->select('a.idResponse, b.tipe');
		$this->db->from('response a');
		$this->db->join('surat b', 'a.idSurat=b.idSurat', 'left');
		$this->db->where('a.receive_user_id', $idUser);
		$this->db->where('b.status_surat', 'nullified');
		$this->db->group_by('a.idSurat');
		$query = $this->db->get();
		return $query->result();
	}

	public function getCountTembusanMasuk($idUser)
	{
		$this->db->select('a.idTembusan, b.tipe');
		$this->db->from('tembusan a');
		$this->db->join('surat b', 'a.idSurat=b.idSurat', 'left');
		$this->db->where('a.untuk', $idUser);
		$this->db->where('b.tipe', 'IN');
		$query = $this->db->get();
		return $query->result();
	}

	public function getCountTembusanKeluar($idUser)
	{
		$this->db->select('a.idTembusan, b.tipe');
		$this->db->from('tembusan a');
		$this->db->join('surat b', 'a.idSurat=b.idSurat', 'left');
		$this->db->where('a.untuk', $idUser);
		$this->db->where('b.tipe', 'OUT');
		$query = $this->db->get();
		return $query->result();
	}

	public function getLogSurat($trackID)
	{
		$this->db->select('idSurat');
		$this->db->from('surat');
		$this->db->where('trackID', $trackID);
		$query = $this->db->get();
		return $query->result();
	}

	public function cekStatusDispos($idSurat, $idUser)
	{
		$this->db->select('action');
		$this->db->from('response');
		$this->db->where('idSurat', $idSurat);
		$this->db->where('send_user_id', $idUser);
		$this->db->order_by('idResponse', 'DESC');
		$this->db->limit(1);
		$query = $this->db->get();
		return $query->result();
	}

	public function cekStatusSurat($idSurat, $idUser)
	{
		$this->db->select('action');
		$this->db->from('response');
		$this->db->where('idSurat', $idSurat);
		$this->db->where("(receive_user_id=$idUser)");
		$this->db->order_by('idResponse', 'DESC');
		$this->db->limit(1);
		$query = $this->db->get();
		return $query->result();
	}

	public function cekSelesaiSurat($idSurat)
	{
		$this->db->select('status_surat');
		$this->db->from('surat');
		$this->db->where('idSurat', $idSurat);
		$query = $this->db->get();
		return $query->result();
	}

	public function getIdCreatedSurat($idSurat)
	{
		$this->db->select('a.created_user, b.nama, c.nmJabatan');
		$this->db->from('surat a');
		$this->db->join('users b', 'b.idUser=a.created_user', 'left');
		$this->db->join('jabatan c', 'b.idJabatan=c.idJabatan', 'left');
		$this->db->where('idSurat', $idSurat);
		$query = $this->db->get();
		return $query->result();
	}

	public function cekLastActionDispos($idSurat)
	{
		$this->db->select('action');
		$this->db->from('response');
		$this->db->where('idSurat', $idSurat);
		$this->db->order_by('idResponse', 'DESC');
		$this->db->limit(1);
		$query = $this->db->get();
		return $query->result();
	}

	public function cekRecieveId($idSurat)
	{
		$this->db->select('a.receive_user_id, b.perihal');
		$this->db->from('response a');
		$this->db->join('surat b', 'a.idSurat=b.idSurat', 'left');
		$this->db->where('a.idSurat', $idSurat);
		$query = $this->db->get();
		return $query->result();
	}

	public function cekRecieveId2($idSurat, $idUser)
	{
		$this->db->select('a.receive_user_id, b.perihal');
		$this->db->from('response a');
		$this->db->join('surat b', 'a.idSurat=b.idSurat', 'left');
		$this->db->where('a.idSurat', $idSurat);
		$this->db->where('a.receive_user_id !=', $idUser);
		$this->db->group_by('a.receive_user_id');
		$query = $this->db->get();
		return $query->result();
	}

	public function cekCreatedUser($idSurat)
	{
		$this->db->select('created_user, perihal');
		$this->db->from('surat');
		$this->db->where('idSurat', $idSurat);
		$query = $this->db->get();
		return $query->result();
	}
}
