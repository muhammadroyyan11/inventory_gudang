<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pengurangan extends CI_Controller
{
	var $table = 'transaksi';
	var $column_order = array('tgl', 'nota', 'lokasi.name', 'keterangan', 'user.name', 'transaksi.created_at', null); //set column field database for datatable orderable
	var $column_search = array('tgl', 'nota', 'lokasi.name', 'keterangan', 'user.name', 'transaksi.created_at'); //set column field database for datatable searchable just firstname , lastname , address are searchable
	var $order = array('created_at' => 'desc'); // default order 

	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_global', 'global');
		is_login();
	}


	public function index()
	{
		$this->load->view('template/header');
		$this->load->view('pengurangan/index');
		$this->load->view('template/footer');
	}

	public function input_pengurangan()
	{
		$data['pelanggan'] = $this->global->get_all('pelanggan');
		$data['barang'] = $this->global->get_all('barang');
		$lokasi = array();
		if ($this->session->userdata('level') == 2) {
			$lokasi = $this->global->get_all('lokasi');
		} elseif ($this->session->userdata('level') == 3) {
			$this->db->where_in('id', $this->session->userdata('gudang'));
			$lokasi = $this->db->get('lokasi')->result();
		}
		$data['lokasi'] = $lokasi;
		$this->load->view('template/header');
		$this->load->view('pengurangan/input_pengurangan', $data);
		$this->load->view('template/footer');
	}

	public function detail($id)
	{
		$id = dec($id);
		$this->db->select('transaksi.*, lokasi.name as lokasi_name,lokasi.hp as lokasi_hp,lokasi.alamat as lokasi_alamat,user.name as user_name');
		$this->db->join('lokasi', 'lokasi.id=transaksi.lokasi_id', 'left');
		$this->db->join('user', 'user.id=transaksi.user_id', 'left');
		$data['transaksi'] = $this->global->get_where(array('transaksi.id' => $id), $this->table)->row();
		$this->db->select('transaksi_detail.*,barang.name as barang_name,barang.kode as barang_kode, brand.name as brand_name, satuan.name as satuan_name, kategori.name as kategori_name');
		$this->db->join('barang', 'barang.id=transaksi_detail.barang_id', 'left');
		$this->db->join('brand', 'brand.id=barang.brand_id', 'left');
		$this->db->join('satuan', 'satuan.id=barang.satuan_id', 'left');
		$this->db->join('kategori', 'kategori.id=barang.kategori_id', 'left');
		$data['detail'] = $this->global->get_where(array('transaksi_id' => $id), 'transaksi_detail')->result();
		$this->load->view('template/header');
		$this->load->view('pengurangan/detail', $data);
		$this->load->view('template/footer');
	}


	public function ajax_table()
	{
		$tanggal = $this->input->post('tanggal');
		$lokasi_id = $this->input->post('lokasi_id');

		if ($tanggal) {
			list($startDateStr, $endDateStr) = explode(" - ", $tanggal);
			$startDate = date_create_from_format('m/d/Y', $startDateStr);
			$endDate = date_create_from_format('m/d/Y', $endDateStr);
			$awal = date_format($startDate, 'Y-m-d');
			$akhir = date_format($endDate, 'Y-m-d');
			$this->db->where("transaksi.tgl BETWEEN '$awal' AND '$akhir'");
		}


		if ($lokasi_id) {
			$this->db->where('transaksi.lokasi_id', $lokasi_id);
		}
		$this->db->select('transaksi.*, lokasi.name as lokasi,user.name as user');
		$this->db->join('lokasi', 'lokasi.id=transaksi.lokasi_id', 'left');
		$this->db->join('user', 'user.id=transaksi.user_id', 'left');
		$this->db->where('jenis', 4);
		if ($this->session->userdata('level') == 3) {
			$this->db->where_in('transaksi.lokasi_id', $this->session->userdata('gudang'));
		}
		$list = $this->global->get_datatables($this->table, $this->column_order, $this->column_search, $this->order);
		$response = array();
		$no = $_POST['start'];
		foreach ($list as $r) {
			$no++;
			$row = array();
			$row[] = $no; //0
			$row[] = $r->id; //1
			$row[] = $r->tgl; //2
			$row[] = $r->nota; //3
			$row[] = $r->lokasi ?? ''; //4
			$row[] = $r->keterangan; //5
			$row[] = $r->user ?? ''; //6
			$row[] = $r->created_at; //7
			$row[] = '<a class="btn btn-sm btn-success detail" href="' . base_url('pengurangan/detail/') . enc($r->id) . '" title="Detail" data-id="' . $r->id . '"><i class="bi bi-eye"></i> </a>';
			// $row[] = '<a class="btn btn-sm btn-warning edit" href="javascript:void(0)" title="Edit" data-id="' . $r->id . '"><i class="bi bi-pencil-square"></i> </a> <a class="btn btn-sm btn-danger delete" href="javascript:void(0)" title="Hapus" data-id="' . $r->id . '"><i class="bi bi-trash"></i> </a>';
			$response[] = $row;
		}

		$tanggal = $this->input->post('tanggal');
		$lokasi_id = $this->input->post('lokasi_id');

		if ($tanggal) {
			list($startDateStr, $endDateStr) = explode(" - ", $tanggal);
			$startDate = date_create_from_format('m/d/Y', $startDateStr);
			$endDate = date_create_from_format('m/d/Y', $endDateStr);
			$awal = date_format($startDate, 'Y-m-d');
			$akhir = date_format($endDate, 'Y-m-d');
			$this->db->where("transaksi.tgl BETWEEN '$awal' AND '$akhir'");
		}


		if ($lokasi_id) {
			$this->db->where('transaksi.lokasi_id', $lokasi_id);
		}
		$this->db->select('transaksi.*, lokasi.name as lokasi,user.name as user');
		$this->db->join('lokasi', 'lokasi.id=transaksi.lokasi_id', 'left');
		$this->db->join('user', 'user.id=transaksi.user_id', 'left');
		$this->db->where('jenis', 4);
		if ($this->session->userdata('level') == 3) {
			$this->db->where_in('transaksi.lokasi_id', $this->session->userdata('gudang'));
		}
		$countAll = $this->global->count_all($this->table);

		$tanggal = $this->input->post('tanggal');
		$lokasi_id = $this->input->post('lokasi_id');

		if ($tanggal) {
			list($startDateStr, $endDateStr) = explode(" - ", $tanggal);
			$startDate = date_create_from_format('m/d/Y', $startDateStr);
			$endDate = date_create_from_format('m/d/Y', $endDateStr);
			$awal = date_format($startDate, 'Y-m-d');
			$akhir = date_format($endDate, 'Y-m-d');
			$this->db->where("transaksi.tgl BETWEEN '$awal' AND '$akhir'");
		}


		if ($lokasi_id) {
			$this->db->where('transaksi.lokasi_id', $lokasi_id);
		}
		$this->db->select('transaksi.*, lokasi.name as lokasi,user.name as user');
		$this->db->join('lokasi', 'lokasi.id=transaksi.lokasi_id', 'left');
		$this->db->join('user', 'user.id=transaksi.user_id', 'left');
		$this->db->where('jenis', 4);
		if ($this->session->userdata('level') == 3) {
			$this->db->where_in('transaksi.lokasi_id', $this->session->userdata('gudang'));
		}
		$countFilter = $this->global->count_filtered($this->table, $this->column_order, $this->column_search, $this->order);
		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $countAll,
			"recordsFiltered" => $countFilter,
			"data" => $response,
		);
		//output to json format
		echo json_encode($output);
	}

	public function store()
	{

		$this->form_validation->set_rules('tgl', 'Tanggal', 'required');
		$this->form_validation->set_rules('gudang', 'Lokasi', 'required|numeric');

		if ($this->form_validation->run() == FALSE) {
			$response = array(
				'success' => false,
				'message' => validation_errors()
			);
			echo json_encode($response);
			exit;
		}

		$lokasi_id = $this->input->post('gudang');

		$nota = $this->input->post('nota');
		if ($nota == '') {
			$nota = generate_code('transaksi', 'nota', 'TRX-PNG-');
		}

		$this->db->trans_start();

		$data['tgl'] = $this->input->post('tgl');
		$data['nota'] = $nota;
		$data['lokasi_id'] = $lokasi_id;
		$data['keterangan'] = $this->input->post('deskripsi');
		$data['jenis'] = 4;
		$data['status'] = 1;
		$data['user_id'] = $this->session->userdata('id');
		$save = $this->global->save($data, $this->table);
		$transaksi_id = $save;
		if ($transaksi_id) {
			$barang_id = $this->input->post('barang_id');
			$jumlah = $this->input->post('jumlah');
			$harga = $this->input->post('harga');
			$kondisi = $this->input->post('kondisi');
			$keterangan = $this->input->post('keterangan');
			foreach ($barang_id as $index => $item) {
				$where = array('lokasi_id' => $lokasi_id, 'barang_id' => $barang_id[$index]);
				$cekStock = $this->global->get_where($where, 'stock');
				if ($cekStock->num_rows() > 0) {
					$cekStock = $cekStock->row();
					if ($cekStock->stock < $jumlah[$index]) {
						$response = array(
							'success' => false,
							'message' => 'Stock tidak cukup!' . json_encode($cekStock)
						);
						echo json_encode($response);
						return;
					}

					$stock_awal = $cekStock->stock;
					$stock_akhir = $stock_awal - $jumlah[$index];

					$updateStock = array('stock' => $stock_akhir);
					$this->global->update($where, $updateStock, 'stock');

					$data = array(
						'transaksi_id' => $transaksi_id,
						'jenis' => 2,
						'lokasi_id' => $lokasi_id,
						'barang_id' => $barang_id[$index],
						'stock_awal' => $stock_awal,
						'stock_akhir' => $stock_akhir,
						'jumlah' => $jumlah[$index],
						'kondisi' => $kondisi[$index],
						'harga' => clean_rupiah($harga[$index]),
						'keterangan' => $keterangan[$index],

					);
					$this->global->save($data, 'transaksi_detail');
				} else {
					$response = array(
						'success' => false,
						'message' => 'Stock tidak ditemukan!'
					);
					echo json_encode($response);
					return;
				}
			}
			$this->db->trans_complete();

			if ($this->db->trans_status() === FALSE) {
				$this->db->trans_rollback();
				$response = array(
					'success' => false,
					'message' => 'Gagal Disimpan!'
				);
				echo json_encode($response);
			} else {
				$response = array(
					'success' => true,
					'message' => 'Berhasil disimpan!'
				);
				echo json_encode($response);
			}
		} else {
			$response = array(
				'success' => false,
				'message' => 'Gagal disimpan!'
			);
			echo json_encode($response);
			exit;
		}
	}

	public function getProdukLokasi()
	{
		$lokasi_id = $this->input->get('lokasi');
		$barang_id = $this->input->get('barang');
		$this->db->select('barang.kode as barang_kode,barang.name as barang_name,barang.harga,satuan.name as satuan_name,kategori.name as kategori_name,brand.name as brand_name,stock.*');
		$this->db->join('barang', 'barang.id=stock.barang_id', 'left');
		$this->db->join('kategori', 'kategori.id=barang.kategori_id', 'left');
		$this->db->join('satuan', 'satuan.id=barang.satuan_id', 'left');
		$this->db->join('brand', 'brand.id=barang.brand_id', 'left');
		$data = $this->global->get_where(array('lokasi_id' => $lokasi_id, 'barang_id' => $barang_id), 'stock');
		if ($data->num_rows() > 0) {
			$data = $data->row();
			$response = array(
				'success' => true,
				'message' => 'Berhasil ambil data',
				'data' => $data
			);
		} else {
			$response = array(
				'success' => false,
				'message' => 'Stock barang tidak ditemukan!',
			);
		}

		echo json_encode($response);
		exit;
	}
}
