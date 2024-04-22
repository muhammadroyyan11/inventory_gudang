<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Barang extends CI_Controller
{
	var $table = 'barang';
	var $column_order = array(null, 'kode', 'name', 'satuan_name', 'kategori_name', 'brand_name', 'harga', 'min_stock', null); //set column field database for datatable orderable
	var $column_search = array(null, 'kode', 'name', 'satuan_name', 'kategori_name', 'brand_name', 'harga', 'min_stock', null); //set column field database for datatable searchable just firstname , lastname , address are searchable
	var $order = array('created_at' => 'desc'); // default order 

	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_global', 'global');
		is_login();
	}

	public function index()
	{
		is_admin();
		$this->load->view('template/header');
		$this->load->view('barang/index');
		$this->load->view('template/footer');
	}

	public function detail($id)
	{
		$id = dec($id);
		$data['id'] = $id;
		$data['gudang'] = $this->global->get_all('lokasi');
		$this->load->view('template/header');
		$this->load->view('barang/detail', $data);
		$this->load->view('template/footer');
	}

	public function ajax_table()
	{
		// is_admin();
		$opsi_database = array(
			'select' => 'barang.*, brand.name as brand_name, satuan.name as satuan_name, kategori.name as kategori_name',
			'join' => array(
				array('brand', 'brand.id=barang.brand_id', 'left'),
				array('satuan', 'satuan.id=barang.satuan_id', 'left'),
				array('kategori', 'kategori.id=barang.kategori_id', 'left'),
			)
		);

		$list = $this->global->get_datatables($this->table, $this->column_order, $this->column_search, $this->order, $opsi_database);
		$response = array();
		$no = $_POST['start'];
		foreach ($list as $r) {
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $r->id;
			$row[] = $r->kode;
			$row[] = $r->name;
			$row[] = $r->satuan_name ?? '';
			$row[] = $r->kategori_name ?? '';
			$row[] = $r->brand_name ?? '';
			$row[] = format_rupiah($r->harga);
			$row[] = $r->min_stock;
			$row[] = '<a class="btn btn-sm btn-success detail" href="' . base_url('barang/detail/') . enc($r->id) . '" title="Detail" data-id="' . $r->id . '"><i class="bi bi-eye"></i> </a> <a class="btn btn-sm btn-warning edit" href="javascript:void(0)" title="Edit" data-id="' . $r->id . '"><i class="bi bi-pencil-square"></i> </a> <a class="btn btn-sm btn-danger delete" href="javascript:void(0)" title="Hapus" data-id="' . $r->id . '"><i class="bi bi-trash"></i> </a>';
			// $row[] = '<a class="btn btn-sm btn-warning edit" href="javascript:void(0)" title="Edit" data-id="' . $r->id . '"><i class="bi bi-pencil-square"></i> </a> <a class="btn btn-sm btn-danger delete" href="javascript:void(0)" title="Hapus" data-id="' . $r->id . '"><i class="bi bi-trash"></i> </a>';
			$response[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->global->count_all($this->table, $opsi_database),
			"recordsFiltered" => $this->global->count_filtered($this->table, $this->column_order, $this->column_search, $this->order, $opsi_database),
			"data" => $response,
		);
		//output to json format
		echo json_encode($output);
	}

	public function ajax_detail($id)
	{
		$gudang = $this->input->post('gudang');
		$bulan = $this->input->post('bulan');
		$tahun = $this->input->post('tahun');
		$tipe = $this->input->post('tipe');

		$opsi_database = array(
			'select' => 'transaksi_detail.*, transaksi.tgl,  transaksi.id as transaksi_id, transaksi.nota as transaksi_nota, transaksi.ref_id as transaksi_ref, transaksi.created_at as tanggal, transaksi.jenis as jenis_trans, transaksi_detail.jenis as jenis_detail, barang.name as nama_barang, supplier.name as supplier_name, lokasi_asal.name as lokasi_asal_name, lokasi_tujuan.name as lokasi_tujuan_name, pelanggan.name as pelanggan_name',
			'join' => array(
				array('transaksi', 'transaksi.id=transaksi_detail.transaksi_id', 'left'),
				array('barang', 'barang.id=transaksi_detail.barang_id', 'left'),
				array('supplier', 'supplier.id=transaksi.supplier_id', 'left'),
				array('lokasi as lokasi_asal', 'lokasi_asal.id=transaksi.lokasi_id', 'left'), // Alias untuk lokasi asal
				array('lokasi as lokasi_tujuan', 'lokasi_tujuan.id=transaksi.tujuan', 'left'), // Alias untuk lokasi tujuan
				array('pelanggan', 'pelanggan.id=transaksi.pelanggan_id', 'left'),
			),
			'where' => array('barang_id' => $id)
		);

		if ($gudang) {
			$opsi_database['where']['(transaksi.lokasi_id = ' . $gudang . ' OR transaksi.tujuan = ' . $gudang . ')'] = null;
		}

		if ($tipe) {
			$opsi_database['where']['transaksi_detail.jenis'] = $tipe;
		}

		if ($bulan && $tahun) {
			$opsi_database['where']['MONTH(transaksi.tgl)'] = $bulan;
			$opsi_database['where']['YEAR(transaksi.tgl)'] = $tahun;
		}


		$list = $this->global->get_datatables('transaksi_detail', array(null, 'name', null, null, null, null), array(null, null, null, null, null, null), array('transaksi.created_at' => 'desc'), $opsi_database);
		$response = array();
		$no = $_POST['start'];
		foreach ($list as $r) {
			if ($r->jenis_trans == 1) {
				$jenis = '<span class="badge bg-primary" style="width: 100px; display: inline-block;">Masuk</span>';
				$keterangan = '<b class=\'text-primary\'>Barang Masuk</b> dari ' . $r->supplier_name;
				$keterangan .= '<br><b class=\'text-primary\'>Barang Ditempatkan</b> pada ' . $r->lokasi_asal_name;
			} elseif ($r->jenis_trans == 2) {
				$jenis = '<span class="badge bg-danger" style="width: 100px; display: inline-block;">Keluar</span>';
				$keterangan = '<b class=\'text-danger\'>Barang Keluar</b> untuk ' . $r->pelanggan_name;
				$keterangan .= '<br><b class=\'text-danger\'>Barang Diambil</b> dari ' . $r->lokasi_asal_name;
			} elseif ($r->jenis_trans == 3) {
				$query = $this->db->select('ref_id, id, nota')->from('transaksi')->where('id', $r->transaksi_ref)->get()->row();
				$jenis = '<span class="badge bg-success" style="width: 100px; display: inline-block;">Return</span>';
				$keterangan = '<b class=\'text-success\'>Return </b> Barang Keluar <br> ID Transaksi ' . $query->nota;
			} elseif ($r->jenis_trans == 4) {
				$jenis = '<span class="badge bg-info" style="width: 100px; display: inline-block;">Pengurangan</span>';
				$keterangan = '<b class=\'text-info\'>Pengurangan </b> pada ' . $r->lokasi_asal_name;
			} elseif ($r->jenis_trans == 5) {
				if ($r->jenis_detail == 1) {
					$jenis = '<span class="badge bg-warning" style="width: 100px; display: inline-block;">Transfer In</span>';
					$keterangan = '<b class=\'text-warning\'>Barang Ditransfer</b> ke ' . $r->lokasi_tujuan_name;
				} else {
					$jenis = '<span class="badge bg-warning" style="width: 100px; display: inline-block;">Transfer Out</span>';
					$keterangan = '<b class=\'text-warning\'>Barang Diambil</b> dari ' . $r->lokasi_asal_name;
				}
			}

			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $r->nama_barang;
			$row[] = $keterangan;
			$row[] = date('d/m/Y', strtotime($r->tgl));
			$row[] = $r->jumlah;
			$row[] = $jenis;
			$row[] = $r->stock_awal;
			$row[] = $r->stock_akhir;
			$response[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->global->count_all('transaksi_detail', $opsi_database),
			"recordsFiltered" => $this->global->count_filtered('transaksi_detail', array(null, null, null, null, null, null), array(null, null, null, null, null, null), array('transaksi.created_at' => 'desc'), $opsi_database),
			"data" => $response,
		);
		//output to json format
		echo json_encode($output);
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


	public function store()
	{
		is_admin();

		$this->form_validation->set_rules('nama', 'Nama', 'required');
		$this->form_validation->set_rules('brand_id', 'Brand', 'required|numeric');
		$this->form_validation->set_rules('kategori_id', 'Kategori', 'required|numeric');
		$this->form_validation->set_rules('satuan_id', 'Satuan', 'required|numeric');
		$this->form_validation->set_rules('harga', 'Harga', 'required');

		if ($this->form_validation->run() == FALSE) {
			$response = array(
				'success' => false,
				'message' => validation_errors()
			);
			echo json_encode($response);
			exit;
		}

		$cek = $this->global->get_where(array('name' => $this->input->post('nama')), $this->table);
		if ($cek->num_rows() > 0) {
			echo json_encode(array('success' => false, 'message' => 'Nama barang sudah ada'));
			exit;
		}

		$kode = $this->input->post('kode');
		if ($kode == '') {
			$kode = generate_code('barang', 'kode', 'PRD-');
		}
		$data = array(
			'name' => $this->input->post('nama'),
			'kode' => $kode,
			'brand_id' => $this->input->post('brand_id'),
			'satuan_id' => $this->input->post('satuan_id'),
			'kategori_id' => $this->input->post('kategori_id'),
			'harga' => clean_rupiah($this->input->post('harga')),
			'min_stock' => $this->input->post('min_stock'),
		);
		$res = $this->global->save($data, $this->table);
		if ($res) {
			echo json_encode(array('success' => true, 'message' => 'Simpan Berhasil'));
		} else {
			echo json_encode(array('success' => false, 'message' => 'Simpan Gagal'));
		}
	}

	public function update()
	{
		is_admin();
		$this->form_validation->set_rules('kode', 'Kode', 'required');
		$this->form_validation->set_rules('nama', 'Nama', 'required');
		$this->form_validation->set_rules('brand_id', 'Brand', 'required|numeric');
		$this->form_validation->set_rules('kategori_id', 'Kategori', 'required|numeric');
		$this->form_validation->set_rules('satuan_id', 'Satuan', 'required|numeric');
		$this->form_validation->set_rules('harga', 'Harga', 'required');

		if ($this->form_validation->run() == FALSE) {
			$response = array(
				'success' => false,
				'message' => validation_errors()
			);
			echo json_encode($response);
			exit;
		}
		$id = $this->input->post('id');
		$where = array('name' => $this->input->post('nama'));
		if ($id != null) {
			$where['id !='] = $id;
		}
		$digunakan = $this->global->get_where($where, $this->table)->num_rows();
		if ($digunakan > 0) {
			$response = array(
				'success' => false,
				'message' => 'Username sudah digunakan'
			);
			echo json_encode($response);
			exit;
		}

		$data = array(
			'name' => $this->input->post('nama'),
			'kode' => $this->input->post('kode'),
			'brand_id' => $this->input->post('brand_id'),
			'satuan_id' => $this->input->post('satuan_id'),
			'kategori_id' => $this->input->post('kategori_id'),
			'harga' => clean_rupiah($this->input->post('harga')),
			'min_stock' => $this->input->post('min_stock'),
		);
		$res = $this->global->update(array('id' => $id), $data, $this->table);
		if ($res) {
			echo json_encode(array('success' => true, 'message' => 'Update Berhasil'));
		} else {
			echo json_encode(array('success' => false, 'message' => 'Update Gagal'));
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
