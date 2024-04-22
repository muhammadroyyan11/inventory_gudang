<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Akses extends CI_Controller
{
	var $table = 'user_lokasi';
	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_global', 'global');
		is_login();
	}

	public function get_all()
	{
		$data = $this->global->get_all($this->table);
		$response = array(
			'success' => true,
			'message' => 'Berhasil ambil data',
			'data' => $data
		);
		echo json_encode($response);
		exit;
	}

	public function get_by_user($user_id)
	{
		$this->db->select('user_lokasi.id,lokasi.name as lokasi_name');
		$this->db->join('lokasi', 'lokasi.id=user_lokasi.lokasi_id');
		$data = $this->global->get_where(array('user_lokasi.user_id' => $user_id), $this->table)->result();
		$response = array(
			'success' => true,
			'message' => 'Berhasil ambil data',
			'data' => $data
		);
		echo json_encode($response);
		exit;
	}

	public function store()
	{
		is_admin();

		$this->form_validation->set_rules('user_id', 'User', 'required');
		$this->form_validation->set_rules('lokasi_id', 'Lokasi', 'required');

		if ($this->form_validation->run() == FALSE) {
			$response = array(
				'success' => false,
				'message' => validation_errors()
			);
			echo json_encode($response);
			exit;
		}

		$cek = $this->global->get_where(array('user_id' => $this->input->post('user_id'), 'lokasi_id' => $this->input->post('lokasi_id')), $this->table);
		if ($cek->num_rows() > 0) {
			echo json_encode(array('success' => false, 'message' => 'Akses lokasi sudah ada'));
			exit;
		}

		$data = array(
			'user_id' => $this->input->post('user_id'),
			'lokasi_id' => $this->input->post('lokasi_id'),
		);
		$res = $this->global->save($data, $this->table);
		if ($res) {
			echo json_encode(array('success' => true, 'message' => 'Simpan Berhasil'));
		} else {
			echo json_encode(array('success' => false, 'message' => 'Simpan Gagal'));
		}
	}


	public function get_by_id($id)
	{
		$data = $this->global->get_by_id($id, $this->table);
		echo json_encode($data);
	}

	public function delete($id)
	{
		is_admin();
		$hapus = $this->global->delete_by_id($id, $this->table);
		if ($hapus) {
			echo json_encode(array("success" => true, "message" => "Hapus data Berhasil"));
		} else {
			echo json_encode(array("success" => false, "message" => "Hapus data Gagal"));
		}
	}
}
