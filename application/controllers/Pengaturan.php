<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pengaturan extends CI_Controller
{
	var $table = 'setting';

	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_global', 'global');
		is_login();
	}

	public function index()
	{
		is_admin();
		$data['setting'] = $this->db->get($this->table)->row();
		$this->load->view('template/header');
		$this->load->view('pengaturan', $data);
		$this->load->view('template/footer');
	}


	public function update()
	{

		is_admin();
		$this->form_validation->set_rules('name', 'Nama Toko', 'required');
		$this->form_validation->set_rules('pemilik', 'Pemilik', 'required');
		$this->form_validation->set_rules('alamat', 'alamat', 'required');

		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('error', json_encode(validation_errors()));
			redirect(base_url('pengaturan'));
			exit;
		}

		if (!empty($_FILES['file']['name'])) {
			$config['upload_path'] = './assets/toko/';
			$config['allowed_types'] = 'gif|jpg|png|ico';

			$this->load->library('upload', $config);

			if (!$this->upload->do_upload('file')) {
				$this->session->set_flashdata('error', json_encode($this->upload->display_errors()));
				redirect(base_url('pengaturan'));
				exit;
			} else {
				$upload_data = $this->upload->data();
				$file_name = uniqid() . '_' . $upload_data['file_name'];
				rename($config['upload_path'] . $upload_data['file_name'], $config['upload_path'] . $file_name);
				$file_name = $file_name;
			}
		}

		$id = $this->input->post('id');
		$cek = $this->global->get_by_id($id, $this->table);
		if (empty($_FILES['file']['name'])) {
			$file_name = $cek->file;
		}

		$data = array(
			'name' => $this->input->post('name'),
			'hp' => $this->input->post('hp'),
			'pemilik' => $this->input->post('pemilik'),
			'alamat' => $this->input->post('alamat'),
			'file' => $file_name,
		);
		$res = $this->global->update(array('id' => $id), $data, $this->table);
		if ($res) {
			$this->session->set_flashdata('success', 'Update data berhasil');
			redirect(base_url('pengaturan'));
			exit;
		} else {
			$this->session->set_flashdata('error', 'Update data gagal');
			redirect(base_url('pengaturan'));
			exit;
		}
	}
}
