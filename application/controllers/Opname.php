<?php
require_once 'vendor/autoload.php';

use Dompdf\Dompdf;

defined('BASEPATH') or exit('No direct script access allowed');

class Opname extends CI_Controller
{
	var $table = 'opname';
	var $column_order = array(null, 'tgl', 'nota', 'lokasi', 'bulan', 'tahun', 'keterangan', 'user', 'created_at'); //set column field database for datatable orderable
	var $column_search = array('tgl', 'nota', 'lokasi.name', 'bulan', 'tahun', 'keterangan', 'user.name', 'opname.created_at'); //set column field database for datatable searchable just firstname , lastname , address are searchable
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
		$this->load->view('opname/index');
		$this->load->view('template/footer');
	}

	public function input_opname()
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
		$this->load->view('opname/input_opname', $data);
		$this->load->view('template/footer');
	}


	public function detail($id)
	{
		$id = dec($id);
		$this->db->select('opname.*, lokasi.name as lokasi_name,lokasi.hp as lokasi_hp,lokasi.alamat as lokasi_alamat,user.name as user_name');
		$this->db->join('lokasi', 'lokasi.id=opname.lokasi_id', 'left');
		$this->db->join('user', 'user.id=opname.user_id', 'left');
		$data['transaksi'] = $this->global->get_where(array('opname.id' => $id), $this->table)->row();
		$this->db->select('opname_detail.*,barang.name as barang_name,barang.kode as barang_kode, brand.name as brand_name, satuan.name as satuan_name, kategori.name as kategori_name');
		$this->db->join('barang', 'barang.id=opname_detail.barang_id', 'left');
		$this->db->join('brand', 'brand.id=barang.brand_id', 'left');
		$this->db->join('satuan', 'satuan.id=barang.satuan_id', 'left');
		$this->db->join('kategori', 'kategori.id=barang.kategori_id', 'left');
		$data['detail'] = $this->global->get_where(array('opname_id' => $id), 'opname_detail')->result();
		$this->load->view('template/header');
		$this->load->view('opname/detail', $data);
		$this->load->view('template/footer');
	}


	public function ajax_table()
	{
		$tanggal = $this->input->post('tanggal');
		$lokasi_id = $this->input->post('lokasi_id');
		$bulan = $this->input->post('bulan');
		$tahun = $this->input->post('tahun');

		if ($tanggal) {
			list($startDateStr, $endDateStr) = explode(" - ", $tanggal);
			$startDate = date_create_from_format('m/d/Y', $startDateStr);
			$endDate = date_create_from_format('m/d/Y', $endDateStr);
			$awal = date_format($startDate, 'Y-m-d');
			$akhir = date_format($endDate, 'Y-m-d');
			$this->db->where("opname.tgl BETWEEN '$awal' AND '$akhir'");
		}


		if ($lokasi_id) {
			$this->db->where('opname.lokasi_id', $lokasi_id);
		}

		if ($bulan && $tahun) {
			$this->db->where('opname.bulan', $bulan);
			$this->db->where('opname.tahun', $tahun);
		}

		$this->db->select('opname.*, lokasi.name as lokasi,user.name as user');
		$this->db->join('lokasi', 'lokasi.id=opname.lokasi_id', 'left');
		$this->db->join('user', 'user.id=opname.user_id', 'left');
		if ($this->session->userdata('level') == 3) {
			$this->db->where_in('opname.lokasi_id', $this->session->userdata('gudang'));
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
			$row[] = '<a class="btn btn-sm btn-success detail" href="' . base_url('opname/detail/') . enc($r->id) . '" title="Detail" data-id="' . $r->id . '"><i class="bi bi-eye"></i> </a> <a class="btn btn-sm btn-info" href="' . base_url('opname/export/') . enc($r->id) . '" title="Export"><i class="bi bi-journal-text"></i> </a>';
			// $row[] = '<a class="btn btn-sm btn-warning edit" href="javascript:void(0)" title="Edit" data-id="' . $r->id . '"><i class="bi bi-pencil-square"></i> </a> <a class="btn btn-sm btn-danger delete" href="javascript:void(0)" title="Hapus" data-id="' . $r->id . '"><i class="bi bi-trash"></i> </a>';

			$row[] = blnIndo($r->bulan); //9
			$row[] = $r->tahun; //10
			$response[] = $row;
		}
		$tanggal = $this->input->post('tanggal');
		$lokasi_id = $this->input->post('lokasi_id');
		$bulan = $this->input->post('bulan');
		$tahun = $this->input->post('tahun');

		if ($tanggal) {
			list($startDateStr, $endDateStr) = explode(" - ", $tanggal);
			$startDate = date_create_from_format('m/d/Y', $startDateStr);
			$endDate = date_create_from_format('m/d/Y', $endDateStr);
			$awal = date_format($startDate, 'Y-m-d');
			$akhir = date_format($endDate, 'Y-m-d');
			$this->db->where("opname.tgl BETWEEN '$awal' AND '$akhir'");
		}


		if ($lokasi_id) {
			$this->db->where('opname.lokasi_id', $lokasi_id);
		}

		if ($bulan && $tahun) {
			$this->db->where('opname.bulan', $bulan);
			$this->db->where('opname.tahun', $tahun);
		}

		$this->db->select('opname.*, lokasi.name as lokasi,user.name as user');
		$this->db->join('lokasi', 'lokasi.id=opname.lokasi_id', 'left');
		$this->db->join('user', 'user.id=opname.user_id', 'left');
		if ($this->session->userdata('level') == 3) {
			$this->db->where_in('opname.lokasi_id', $this->session->userdata('gudang'));
		}
		$countAll = $this->global->count_all($this->table);

		$tanggal = $this->input->post('tanggal');
		$lokasi_id = $this->input->post('lokasi_id');
		$bulan = $this->input->post('bulan');
		$tahun = $this->input->post('tahun');

		if ($tanggal) {
			list($startDateStr, $endDateStr) = explode(" - ", $tanggal);
			$startDate = date_create_from_format('m/d/Y', $startDateStr);
			$endDate = date_create_from_format('m/d/Y', $endDateStr);
			$awal = date_format($startDate, 'Y-m-d');
			$akhir = date_format($endDate, 'Y-m-d');
			$this->db->where("opname.tgl BETWEEN '$awal' AND '$akhir'");
		}


		if ($lokasi_id) {
			$this->db->where('opname.lokasi_id', $lokasi_id);
		}

		if ($bulan && $tahun) {
			$this->db->where('opname.bulan', $bulan);
			$this->db->where('opname.tahun', $tahun);
		}

		$this->db->select('opname.*, lokasi.name as lokasi,user.name as user');
		$this->db->join('lokasi', 'lokasi.id=opname.lokasi_id', 'left');
		$this->db->join('user', 'user.id=opname.user_id', 'left');
		if ($this->session->userdata('level') == 3) {
			$this->db->where_in('opname.lokasi_id', $this->session->userdata('gudang'));
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
		$this->form_validation->set_rules('bulan', 'Bulan', 'required|numeric');
		$this->form_validation->set_rules('tahun', 'Tahun', 'required|numeric');

		if ($this->form_validation->run() == FALSE) {
			$response = array(
				'success' => false,
				'message' => validation_errors()
			);
			echo json_encode($response);
			exit;
		}

		$lokasi_id = $this->input->post('gudang');
		$bulan = $this->input->post('bulan');
		$tahun = $this->input->post('tahun');
		$where = array('lokasi_id' => $lokasi_id, 'bulan' => $bulan, 'tahun' => $tahun);
		$cekOpname = $this->global->get_where($where, $this->table);
		if ($cekOpname->num_rows() > 0) {
			$response = array(
				'success' => false,
				'message' => 'Data opname sudah ada'
			);
			echo json_encode($response);
			exit;
		}
		$nota = $this->input->post('nota');
		if ($nota == '') {
			$nota = generate_code('opname', 'nota', 'TRX-OPN-');
		}

		$this->db->trans_start();

		$data['tgl'] = $this->input->post('tgl');
		$data['bulan'] = $bulan;
		$data['tahun'] = $tahun;
		$data['nota'] = $nota;
		$data['lokasi_id'] = $lokasi_id;
		$data['keterangan'] = $this->input->post('deskripsi');
		$data['status'] = 1;
		$data['user_id'] = $this->session->userdata('id');
		$save = $this->global->save($data, $this->table);
		$transaksi_id = $save;
		if ($transaksi_id) {
			$barang_id = $this->input->post('barang_id');
			$jumlah = $this->input->post('jumlah');
			$harga = $this->input->post('harga');
			$selisih = $this->input->post('selisih');
			$keterangan = $this->input->post('keterangan');
			foreach ($barang_id as $index => $item) {
				$where = array('lokasi_id' => $lokasi_id, 'barang_id' => $barang_id[$index]);
				$cekStock = $this->global->get_where($where, 'stock');
				if ($cekStock->num_rows() > 0) {
					$cekStock = $cekStock->row();
					$stock_awal = $cekStock->stock;
					$data = array(
						'opname_id' => $transaksi_id,
						'lokasi_id' => $lokasi_id,
						'barang_id' => $barang_id[$index],
						'stock_sistem' => $stock_awal,
						'stock_real' => $jumlah[$index],
						'selisih' => $selisih[$index],
						'harga' => clean_rupiah($harga[$index]),
						'keterangan' => $keterangan[$index],

					);
					$this->global->save($data, 'opname_detail');
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

		if ($barang_id) {
			$this->db->where('barang_id', $barang_id);
		}
		$data = $this->global->get_where(array('lokasi_id' => $lokasi_id), 'stock');
		if ($data->num_rows() > 0) {
			if ($barang_id) {
				$data = $data->row();
			} else {
				$data = $data->result();
			}
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

	public function export($id)
	{
		$id = dec($id);
		$this->db->select('opname.*, lokasi.name as lokasi_name,lokasi.hp as lokasi_hp,lokasi.alamat as lokasi_alamat,user.name as user_name');
		$this->db->join('lokasi', 'lokasi.id=opname.lokasi_id', 'left');
		$this->db->join('user', 'user.id=opname.user_id', 'left');
		$data['transaksi'] = $this->global->get_where(array('opname.id' => $id), $this->table)->row();
		$this->db->select('opname_detail.*,barang.name as barang_name,barang.kode as barang_kode, brand.name as brand_name, satuan.name as satuan_name, kategori.name as kategori_name');
		$this->db->join('barang', 'barang.id=opname_detail.barang_id', 'left');
		$this->db->join('brand', 'brand.id=barang.brand_id', 'left');
		$this->db->join('satuan', 'satuan.id=barang.satuan_id', 'left');
		$this->db->join('kategori', 'kategori.id=barang.kategori_id', 'left');
		$data['detail'] = $this->global->get_where(array('opname_id' => $id), 'opname_detail')->result();

		$dompdf = new Dompdf();

		// Load HTML content from the view
		$html = $this->load->view('opname/export', $data, true);

		// Load HTML content into Dompdf
		$dompdf->loadHtml($html);

		// Set paper size and orientation
		$dompdf->setPaper('A4', 'landscape');

		// Render the HTML as PDF
		$dompdf->render();

		// Output the generated PDF (inline or as attachment)
		$dompdf->stream('detail_opname_stock.pdf', array('Attachment' => 0));
	}
}
