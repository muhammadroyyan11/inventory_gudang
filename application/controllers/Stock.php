<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Stock extends CI_Controller
{
	var $table = 'stock';
	var $column_order = array(null, 'lokasi.name', 'barang.kode', 'barang.name', 'brand.name', 'satuan.name', 'kategori.name', 'barang.harga', 'stock', 'min_stock'); //set column field database for datatable orderable
	var $column_search = array('lokasi.name', 'barang.kode', 'barang.name', 'brand.name', 'satuan.name', 'kategori.name', 'barang.harga', 'stock', 'min_stock'); //set column field database for datatable searchable just firstname , lastname , address are searchable
	var $order = array('barang.id' => 'desc'); // default order 

	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_global', 'global');
		is_login();
	}

	public function index()
	{
		$this->load->view('template/header');
		$this->load->view('stock/index');
		$this->load->view('template/footer');
	}

	public function histori()
	{
		$this->load->view('template/header');
		$this->load->view('stock/histori');
		$this->load->view('template/footer');
	}

	public function masuk()
	{
		$data['supplier'] = $this->global->get_all('supplier');
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
		$this->load->view('masuk/input_masuk', $data);
		$this->load->view('template/footer');
	}

	public function data_masuk()
	{
		$this->load->view('template/header');
		$this->load->view('masuk/data_masuk');
		$this->load->view('template/footer');
	}

	public function keluar()
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
		$this->load->view('keluar/input_keluar', $data);
		$this->load->view('template/footer');
	}

	public function data_keluar()
	{
		$this->load->view('template/header');
		$this->load->view('keluar/data_keluar');
		$this->load->view('template/footer');
	}

	public function return()
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
		$data['referensi'] = $this->global->get_where(array('jenis' => 2), 'transaksi')->result();
		$this->load->view('template/header');
		$this->load->view('return/input_return', $data);
		$this->load->view('template/footer');
	}

	public function data_return()
	{
		$this->load->view('template/header');
		$this->load->view('return/data_return');
		$this->load->view('template/footer');
	}

	public function transfer()
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
		$lokasi_tujuan = array();
		$lokasi_tujuan = $this->global->get_all('lokasi');

		$data['lokasi'] = $lokasi;
		$data['lokasi_tujuan'] = $lokasi_tujuan;
		$this->load->view('template/header');
		$this->load->view('transfer/input_transfer', $data);
		$this->load->view('template/footer');
	}

	public function data_transfer()
	{
		$this->load->view('template/header');
		$this->load->view('transfer/data_transfer');
		$this->load->view('template/footer');
	}

	public function ajax_table()
	{
		$this->db->select('barang.*, brand.name as brand_name, satuan.name as satuan_name, kategori.name as kategori_name,lokasi.name as lokasi_name,stock.stock');
		$this->db->join('barang', 'barang.id=stock.barang_id', 'left');
		$this->db->join('brand', 'brand.id=barang.brand_id', 'left');
		$this->db->join('satuan', 'satuan.id=barang.satuan_id', 'left');
		$this->db->join('kategori', 'kategori.id=barang.kategori_id', 'left');
		$this->db->join('lokasi', 'lokasi.id=stock.lokasi_id');
		if ($this->session->userdata('level') == 3) {
			$this->db->where_in('stock.lokasi_id', $this->session->userdata('gudang'));
		}
		$list = $this->global->get_datatables($this->table, $this->column_order, $this->column_search, $this->order);
		$response = array();
		$no = $_POST['start'];
		foreach ($list as $r) {
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $r->lokasi_name;
			$row[] = $r->kode;
			$row[] = $r->name;
			$row[] = $r->satuan_name ?? '';
			$row[] = $r->kategori_name ?? '';
			$row[] = $r->brand_name ?? '';
			$row[] = format_rupiah($r->harga);
			$stock = $r->stock;
			if ($stock <= $r->min_stock) {
				$stock = '<span class="badge rounded-pill bg-danger">' . $stock . '</span>';
			}
			$row[] = $stock;
			$row[] = $r->min_stock;
			// $row[] = '<a class="btn btn-sm btn-success detail" href="javascript:void(0)" title="Detail" data-id="' . $r->id . '"><i class="bi bi-eye"></i> </a> <a class="btn btn-sm btn-info data-satuan" href="javascript:void(0)" title="Satuan" data-id="' . $r->id . '"><i class="bi bi-plus-square"></i> </a> <a class="btn btn-sm btn-warning edit" href="javascript:void(0)" title="Edit" data-id="' . $r->id . '"><i class="bi bi-pencil-square"></i> </a> <a class="btn btn-sm btn-danger delete" href="javascript:void(0)" title="Hapus" data-id="' . $r->id . '"><i class="bi bi-trash"></i> </a>';
			$row[] = '<a class="btn btn-sm btn-warning edit" href="javascript:void(0)" title="Edit" data-id="' . $r->id . '"><i class="bi bi-pencil-square"></i> </a> <a class="btn btn-sm btn-danger delete" href="javascript:void(0)" title="Hapus" data-id="' . $r->id . '"><i class="bi bi-trash"></i> </a>';
			$row[] = $r->id;
			$response[] = $row;
		}
		$this->db->select('barang.*, brand.name as brand_name, satuan.name as satuan_name, kategori.name as kategori_name,lokasi.name as lokasi_name,stock.stock');
		$this->db->join('barang', 'barang.id=stock.barang_id', 'left');
		$this->db->join('brand', 'brand.id=barang.brand_id', 'left');
		$this->db->join('satuan', 'satuan.id=barang.satuan_id', 'left');
		$this->db->join('kategori', 'kategori.id=barang.kategori_id', 'left');
		$this->db->join('lokasi', 'lokasi.id=stock.lokasi_id');
		if ($this->session->userdata('level') == 3) {
			$this->db->where_in('stock.lokasi_id', $this->session->userdata('gudang'));
		}
		$recordsTotal = $this->global->count_all($this->table);

		$this->db->select('barang.*, brand.name as brand_name, satuan.name as satuan_name, kategori.name as kategori_name,lokasi.name as lokasi_name,stock.stock');
		$this->db->join('barang', 'barang.id=stock.barang_id', 'left');
		$this->db->join('brand', 'brand.id=barang.brand_id', 'left');
		$this->db->join('satuan', 'satuan.id=barang.satuan_id', 'left');
		$this->db->join('kategori', 'kategori.id=barang.kategori_id', 'left');
		$this->db->join('lokasi', 'lokasi.id=stock.lokasi_id');
		if ($this->session->userdata('level') == 3) {
			$this->db->where_in('stock.lokasi_id', $this->session->userdata('gudang'));
		}
		$recordsFiltered = $this->global->count_filtered($this->table, $this->column_order, $this->column_search, $this->order);
		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $recordsTotal,
			"recordsFiltered" => $recordsFiltered,
			"data" => $response,
		);
		//output to json format
		echo json_encode($output);
	}

	public function histori_table()
	{
		$tanggal = $this->input->post('tanggal');
		$lokasi_id = $this->input->post('lokasi_id');
		$jenis = $this->input->post('jenis');

		if ($tanggal) {
			list($startDateStr, $endDateStr) = explode(" - ", $tanggal);
			$startDate = date_create_from_format('m/d/Y', $startDateStr);
			$endDate = date_create_from_format('m/d/Y', $endDateStr);
			$awal = date_format($startDate, 'Y-m-d');
			$akhir = date_format($endDate, 'Y-m-d');
			$this->db->where("transaksi.tgl BETWEEN '$awal' AND '$akhir'");
		}


		if ($lokasi_id) {
			$this->db->where('transaksi_detail.lokasi_id', $lokasi_id);
		}

		if ($jenis) {
			$this->db->where('transaksi_detail.jenis', $jenis);
		}
		$this->db->select('transaksi_detail.*,transaksi.tgl,brand.name as brand_name, satuan.name as satuan_name, 
		kategori.name as kategori_name,lokasi.name as lokasi_name,barang.kode as barang_kode,barang.name as barang_name');
		$this->db->join('barang', 'barang.id=transaksi_detail.barang_id', 'left');
		$this->db->join('brand', 'brand.id=barang.brand_id', 'left');
		$this->db->join('satuan', 'satuan.id=barang.satuan_id', 'left');
		$this->db->join('kategori', 'kategori.id=barang.kategori_id', 'left');
		$this->db->join('lokasi', 'lokasi.id=transaksi_detail.lokasi_id');
		$this->db->join('transaksi', 'transaksi.id=transaksi_detail.transaksi_id', 'left');
		if ($this->session->userdata('level') == 3) {
			$this->db->where_in('transaksi_detail.lokasi_id', $this->session->userdata('gudang'));
			$this->db->group_by('transaksi_detail.lokasi_id');
		}
		$this->db->where_in('transaksi_detail.jenis', [1, 2]);
		$this->db->group_by('transaksi_detail.id');

		$list = $this->global->get_datatables('transaksi_detail', array(null, 'transaksi.tgl', 'lokasi.name', 'transaksi_detail.jenis', 'barang.kode', 'barang.name', 'satuan.name', 'kategori.name', 'brand.name', 'stock_awal', 'jumlah', 'stock_akhir'), array('transaksi.tgl', 'lokasi.name', 'transaksi_detail.jenis', 'barang.kode', 'barang.name', 'satuan.name', 'kategori.name', 'brand.name', 'stock_awal', 'jumlah', 'stock_akhir'), array('id' => 'desc'));
		$response = array();
		$no = $_POST['start'];
		foreach ($list as $r) {
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $r->lokasi_name;
			$jenis = '';
			if ($r->jenis == 1) {
				$jenis = '<span class="badge rounded-pill bg-primary">Masuk</span>';
			} elseif ($r->jenis == 2) {
				$jenis = '<span class="badge rounded-pill bg-warning">Keluar</span>';
			}
			$row[] = $jenis;
			$row[] = $r->barang_kode;
			$row[] = $r->barang_name;
			$row[] = $r->satuan_name ?? '';
			$row[] = $r->kategori_name ?? '';
			$row[] = $r->brand_name ?? '';
			$row[] = $r->stock_awal;
			$row[] = $r->jumlah;
			$row[] = $r->stock_akhir;
			$row[] = $r->tgl;
			$row[] = $r->id;
			$response[] = $row;
		}

		$tanggal = $this->input->post('tanggal');
		$lokasi_id = $this->input->post('lokasi_id');
		$jenis = $this->input->post('jenis');

		if ($tanggal) {
			list($startDateStr, $endDateStr) = explode(" - ", $tanggal);
			$startDate = date_create_from_format('m/d/Y', $startDateStr);
			$endDate = date_create_from_format('m/d/Y', $endDateStr);
			$awal = date_format($startDate, 'Y-m-d');
			$akhir = date_format($endDate, 'Y-m-d');
			$this->db->where("transaksi.tgl BETWEEN '$awal' AND '$akhir'");
		}


		if ($lokasi_id) {
			$this->db->where('transaksi_detail.lokasi_id', $lokasi_id);
		}

		if ($jenis) {
			$this->db->where('transaksi_detail.jenis', $jenis);
		}
		$this->db->select('transaksi_detail.*,transaksi.tgl, brand.name as brand_name, satuan.name as satuan_name, 
		kategori.name as kategori_name,lokasi.name as lokasi_name,barang.kode as barang_kode,barang.name as barang_name');
		$this->db->join('barang', 'barang.id=transaksi_detail.barang_id', 'left');
		$this->db->join('brand', 'brand.id=barang.brand_id', 'left');
		$this->db->join('satuan', 'satuan.id=barang.satuan_id', 'left');
		$this->db->join('kategori', 'kategori.id=barang.kategori_id', 'left');
		$this->db->join('lokasi', 'lokasi.id=transaksi_detail.lokasi_id');
		$this->db->join('transaksi', 'transaksi.id=transaksi_detail.transaksi_id', 'left');
		if ($this->session->userdata('level') == 3) {
			$this->db->where_in('transaksi_detail.lokasi_id', $this->session->userdata('gudang'));
			$this->db->group_by('transaksi_detail.lokasi_id');
		}
		$this->db->where_in('transaksi_detail.jenis', [1, 2]);
		$this->db->group_by('transaksi_detail.id');
		$recordsTotal = $this->global->count_all('transaksi_detail');

		$tanggal = $this->input->post('tanggal');
		$lokasi_id = $this->input->post('lokasi_id');
		$jenis = $this->input->post('jenis');

		if ($tanggal) {
			list($startDateStr, $endDateStr) = explode(" - ", $tanggal);
			$startDate = date_create_from_format('m/d/Y', $startDateStr);
			$endDate = date_create_from_format('m/d/Y', $endDateStr);
			$awal = date_format($startDate, 'Y-m-d');
			$akhir = date_format($endDate, 'Y-m-d');
			$this->db->where("transaksi.tgl BETWEEN '$awal' AND '$akhir'");
		}


		if ($lokasi_id) {
			$this->db->where('transaksi_detail.lokasi_id', $lokasi_id);
		}

		if ($jenis) {
			$this->db->where('transaksi_detail.jenis', $jenis);
		}
		$this->db->select('transaksi_detail.*,transaksi.tgl, brand.name as brand_name, satuan.name as satuan_name, 
		kategori.name as kategori_name,lokasi.name as lokasi_name,barang.kode as barang_kode,barang.name as barang_name');
		$this->db->join('barang', 'barang.id=transaksi_detail.barang_id', 'left');
		$this->db->join('brand', 'brand.id=barang.brand_id', 'left');
		$this->db->join('satuan', 'satuan.id=barang.satuan_id', 'left');
		$this->db->join('kategori', 'kategori.id=barang.kategori_id', 'left');
		$this->db->join('lokasi', 'lokasi.id=transaksi_detail.lokasi_id');
		$this->db->join('transaksi', 'transaksi.id=transaksi_detail.transaksi_id', 'left');
		if ($this->session->userdata('level') == 3) {
			$this->db->where_in('transaksi_detail.lokasi_id', $this->session->userdata('gudang'));
			$this->db->group_by('transaksi_detail.lokasi_id');
		}
		$this->db->where_in('transaksi_detail.jenis', [1, 2]);
		$this->db->group_by('transaksi_detail.id');
		$recordsFiltered = $this->global->count_filtered('transaksi_detail', array(null, 'transaksi.tgl', 'lokasi.name', 'transaksi_detail.jenis', 'barang.kode', 'barang.name', 'satuan.name', 'kategori.name', 'brand.name', 'stock_awal', 'jumlah', 'stock_akhir'), array('transaksi.tgl', 'lokasi.name', 'transaksi_detail.jenis', 'barang.kode', 'barang.name', 'satuan.name', 'kategori.name', 'brand.name', 'stock_awal', 'jumlah', 'stock_akhir'), array('id' => 'desc'));

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $recordsTotal,
			"recordsFiltered" => $recordsFiltered,
			"data" => $response,
		);
		//output to json format
		echo json_encode($output);
	}
}
