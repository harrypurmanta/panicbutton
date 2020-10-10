<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_pushnotif extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function sendMessagePanic($id )
	{
		$headings = array(
			"en" => 'Permintaan pertolongan ',
		);

		$content = array(
			"en" =>'Harap segera merespon Panic Button',
		);


		$hashes_array = array();
		array_push($hashes_array, array(
			"id"   => "like-button",
			"text" => "Like",
			"icon" => "http://i.imgur.com/N8SN8ZS.png",
		));
		$fields = array(
			'app_id' => "909e2b5c-7c03-4218-afba-0d93577cfabb",
			'include_player_ids' => array($id),
			// 'included_segments' => array(
			//     'All'
			// ),
			'data' => array(
				"idSurat" => $id,
				
			),
			"large_icon" => "https://i.pinimg.com/originals/e1/ab/6b/e1ab6b605c1841576390ca92cbadbaa1.png",
			// "big_picture" => "https://dosis.cliniccoding.id/assets/images/logo/notif_banner.png",
			'contents'    => $content,
			'headings'    => $headings,
			// 'buttons' => $hashes_array,
		);

		$fields = json_encode($fields);
		// print("\nJSON sent:\n");
		// print($fields);

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'Content-Type: application/json; charset=utf-8',
			'Authorization: Basic ZGJiYjJkNjctZGQ5Mi00ZWNhLWFhNzgtNjAzMTg1NjJmNzIz'
		));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		curl_setopt($ch, CURLOPT_POST, TRUE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

		$response = curl_exec($ch);
		curl_close($ch);

		$return = $response;

		return json_decode($return);
	}

	public function sendMessageResponse($id )
	{
		$headings = array(
			"en" => 'Permintaan Anda diterima ',
		);

		$content = array(
			"en" =>'Harap menunggu dan tenang sampai bantuan tiba',
		);


		$hashes_array = array();
		array_push($hashes_array, array(
			"id"   => "like-button",
			"text" => "Like",
			"icon" => "http://i.imgur.com/N8SN8ZS.png",
		));
		$fields = array(
			'app_id' => "909e2b5c-7c03-4218-afba-0d93577cfabb",
			'include_player_ids' => array($id),
			// 'included_segments' => array(
			//     'All'
			// ),
			'data' => array(
				"idSurat" => $id,
				
			),
			"large_icon" => "https://i.pinimg.com/originals/e1/ab/6b/e1ab6b605c1841576390ca92cbadbaa1.png",
			// "big_picture" => "https://dosis.cliniccoding.id/assets/images/logo/notif_banner.png",
			'contents'    => $content,
			'headings'    => $headings,
			// 'buttons' => $hashes_array,
		);

		$fields = json_encode($fields);
		// print("\nJSON sent:\n");
		// print($fields);

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'Content-Type: application/json; charset=utf-8',
			'Authorization: Basic ZGJiYjJkNjctZGQ5Mi00ZWNhLWFhNzgtNjAzMTg1NjJmNzIz'
		));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		curl_setopt($ch, CURLOPT_POST, TRUE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

		$response = curl_exec($ch);
		curl_close($ch);

		$return = $response;

		return json_decode($return);
	}

	public function getAccount($user_id){
		$this->db->select('a.user_id_device');
        $this->db->from('session_login_mobile a');
		$this->db->join('users b','a.user_id=b.user_id','left');
        $this->db->where('a.session_status', 'login');
        $this->db->where('b.user_group', 'medic');
        $this->db->where('a.user_id !=', $user_id);
        $query = $this->db->get();
        return $query->result();
	}

	public function getAccountRespon($user_id){
		$this->db->select('a.user_id_device');
        $this->db->from('session_login_mobile a');
		$this->db->join('users b','a.user_id=b.user_id','left');
        $this->db->where('a.session_status', 'login');
        $this->db->where('a.user_id', $user_id);
        $query = $this->db->get();
        return $query->result();
	}
	
}
