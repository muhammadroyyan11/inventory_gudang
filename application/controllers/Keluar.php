<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Keluar extends CI_Controller
{
	var $table = 'transaksi';
	var $column_order = array(null, 'tgl', 'nota', 'metode_transaksi', 'lokasi', 'pelanggan', 'total', 'bayar', 'status', 'user', 'created_at', null, null); //set column field database for datatable orderable
	var $column_search = array('tgl', 'nota', 'metode_transaksi', 'tgl_jatuh_tempo', 'lokasi.name', 'pelanggan.name', 'total', 'bayar', 'status', 'user.name', 'transaksi.created_at'); //set column field database for datatable searchable just firstname , lastname , address are searchable
	var $order = array('created_at' => 'desc'); // default order 

	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_global', 'global');
		is_login();
	}

	public function detail($id)
	{
		$id = dec($id);
		$this->db->select('transaksi.*, lokasi.name as lokasi_name,lokasi.hp as lokasi_hp,lokasi.alamat as lokasi_alamat, pelanggan.name as pelanggan_name,pelanggan.hp as pelanggan_hp,pelanggan.alamat as pelanggan_alamat,user.name as user_name');
		$this->db->join('lokasi', 'lokasi.id=transaksi.lokasi_id', 'left');
		$this->db->join('pelanggan', 'pelanggan.id=transaksi.pelanggan_id', 'left');
		$this->db->join('user', 'user.id=transaksi.user_id', 'left');
		$data['transaksi'] = $this->global->get_where(array('transaksi.id' => $id), $this->table)->row();
		$this->db->select('transaksi_detail.*,barang.name as barang_name,barang.kode as barang_kode, brand.name as brand_name, satuan.name as satuan_name, kategori.name as kategori_name');
		$this->db->join('barang', 'barang.id=transaksi_detail.barang_id', 'left');
		$this->db->join('brand', 'brand.id=barang.brand_id', 'left');
		$this->db->join('satuan', 'satuan.id=barang.satuan_id', 'left');
		$this->db->join('kategori', 'kategori.id=barang.kategori_id', 'left');
		$data['detail'] = $this->global->get_where(array('transaksi_id' => $id), 'transaksi_detail')->result();
		$this->load->view('template/header');
		$this->load->view('keluar/detail', $data);
		$this->load->view('template/footer');
	}

	public function nota($id)
	{
		$id = dec($id);
		$this->db->select('transaksi.*, lokasi.name as lokasi_name,lokasi.hp as lokasi_hp,lokasi.alamat as lokasi_alamat, pelanggan.name as pelanggan_name,pelanggan.hp as pelanggan_hp,pelanggan.alamat as pelanggan_alamat,user.name as user_name');
		$this->db->join('lokasi', 'lokasi.id=transaksi.lokasi_id', 'left');
		$this->db->join('pelanggan', 'pelanggan.id=transaksi.pelanggan_id', 'left');
		$this->db->join('user', 'user.id=transaksi.user_id', 'left');
		$data['transaksi'] = $this->global->get_where(array('transaksi.id' => $id), $this->table)->row();
		$this->db->select('transaksi_detail.*,barang.name as barang_name,barang.kode as barang_kode, brand.name as brand_name, satuan.name as satuan_name, kategori.name as kategori_name');
		$this->db->join('barang', 'barang.id=transaksi_detail.barang_id', 'left');
		$this->db->join('brand', 'brand.id=barang.brand_id', 'left');
		$this->db->join('satuan', 'satuan.id=barang.satuan_id', 'left');
		$this->db->join('kategori', 'kategori.id=barang.kategori_id', 'left');
		$data['detail'] = $this->global->get_where(array('transaksi_id' => $id), 'transaksi_detail')->result();
		$this->load->view('template/header');
		$this->load->view('keluar/nota', $data);
		$this->load->view('template/footer');
	}

	public function ajax_table()
	{
		$tanggal = $this->input->post('tanggal');
		$lokasi_id = $this->input->post('lokasi_id');
		$pelanggan_id = $this->input->post('pelanggan_id');
		$metode_transaksi = $this->input->post('metode_transaksi');
		$status = $this->input->post('status');

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

		if ($pelanggan_id <> '') {
			$this->db->where('transaksi.pelanggan_id', $pelanggan_id);
		}

		if ($status) {
			$this->db->where('transaksi.status', $status);
		}

		if ($metode_transaksi) {
			$this->db->where('transaksi.metode_transaksi', $metode_transaksi);
		}
		$this->db->select('transaksi.*, lokasi.name as lokasi, pelanggan.name as pelanggan,user.name as user');
		$this->db->join('lokasi', 'lokasi.id=transaksi.lokasi_id', 'left');
		$this->db->join('pelanggan', 'pelanggan.id=transaksi.pelanggan_id', 'left');
		$this->db->join('user', 'user.id=transaksi.user_id', 'left');
		if ($this->session->userdata('level') == 3) {
			$this->db->where_in('transaksi.lokasi_id', $this->session->userdata('gudang'));
		}
		$this->db->where('transaksi.jenis', 2);
		$list = $this->global->get_datatables($this->table, $this->column_order, $this->column_search, $this->order);
		$response = array();
		$no = $_POST['start'];
		foreach ($list as $r) {
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $r->tgl;
			$row[] = $r->nota;
			$metode_transaksi = '';
			if ($r->metode_transaksi == 'tunai') {
				$metode_transaksi = '<span class="badge rounded-pill bg-primary">Tunai</span>';
			} elseif ($r->metode_transaksi == 'hutang') {
				$metode_transaksi = '<span class="badge rounded-pill bg-success">Hutang</span>';
			}
			$row[] = $metode_transaksi;
			$row[] = $r->lokasi ?? '';
			$row[] = $r->pelanggan ?? 'Umum';
			$row[] = format_rupiah($r->total);
			$row[] = format_rupiah($r->bayar);
			// $file = '<a href="javascript:void(0);" class="btn btn-info btn-sm upload">Upload</a>';
			// if ($r->file <> '') {
			// 	$file = '<a target="_blank" href="' . base_url('assets/suratjalan/') . $r->file . '">Download</a>';
			// }
			// $row[] = $file;
			$status = '';
			if ($r->status == 1) {
				$status = '<span class="badge rounded-pill bg-primary">Selesai</span>';
			} elseif ($r->status == 2) {
				$status = '<span class="badge rounded-pill bg-success">Proses</span>';
			}
			$row[] = $status;
			$row[] = $r->user ?? '';
			$row[] = $r->created_at;
			$btnBayar = '';
			if ($r->bayar < $r->total or $r->status == 2) {
				$btnBayar = '<a class="btn btn-sm btn-primary mb-2 bayar" title="Bayar" data-id="' . $r->id . '"  data-nota="' . $r->nota . '"  data-total="' . $r->total . '" data-bayar="' . $r->bayar . '"><i class="bi bi-cash-stack"></i> </a>';
			}
			$row[] = $btnBayar . ' <a class="btn btn-sm btn-success mb-2 detail" href="' . base_url('keluar/detail/') . enc($r->id) . '" title="Detail" data-id="' . $r->id . '"><i class="bi bi-eye"></i> </a> <a class="btn btn-sm btn-info mb-2 detail" href="' . base_url('keluar/nota/') . enc($r->id) . '" title="Nota Transaksi"><i class="bi bi-card-list"></i> </a>';

			$row[] = $r->tgl_jatuh_tempo;

			$sumber = '';
			if ($r->sumber == 1) {
				$sumber = 'Offline';
			} elseif ($r->sumber == 2) {
				$sumber = 'Online';
			}
			$row[] = $sumber;

			$row[] = $r->keterangan;
			$row[] = $r->id;
			// $row[] = '<a class="btn btn-sm btn-warning edit" href="javascript:void(0)" title="Edit" data-id="' . $r->id . '"><i class="bi bi-pencil-square"></i> </a> <a class="btn btn-sm btn-danger delete" href="javascript:void(0)" title="Hapus" data-id="' . $r->id . '"><i class="bi bi-trash"></i> </a>';
			$response[] = $row;
		}
		$tanggal = $this->input->post('tanggal');
		$lokasi_id = $this->input->post('lokasi_id');
		$pelanggan_id = $this->input->post('pelanggan_id');
		$metode_transaksi = $this->input->post('metode_transaksi');
		$status = $this->input->post('status');

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

		if ($pelanggan_id <> '') {
			$this->db->where('transaksi.pelanggan_id', $pelanggan_id);
		}

		if ($status) {
			$this->db->where('transaksi.status', $status);
		}

		if ($metode_transaksi) {
			$this->db->where('transaksi.metode_transaksi', $metode_transaksi);
		}
		$this->db->select('transaksi.*, lokasi.name as lokasi, pelanggan.name as pelanggan,user.name as user');
		$this->db->join('lokasi', 'lokasi.id=transaksi.lokasi_id', 'left');
		$this->db->join('pelanggan', 'pelanggan.id=transaksi.pelanggan_id', 'left');
		$this->db->join('user', 'user.id=transaksi.user_id', 'left');
		if ($this->session->userdata('level') == 3) {
			$this->db->where_in('transaksi.lokasi_id', $this->session->userdata('gudang'));
		}
		$this->db->where('transaksi.jenis', 2);
		$countAll = $this->global->count_all($this->table);

		$tanggal = $this->input->post('tanggal');
		$lokasi_id = $this->input->post('lokasi_id');
		$pelanggan_id = $this->input->post('pelanggan_id');
		$metode_transaksi = $this->input->post('metode_transaksi');
		$status = $this->input->post('status');

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

		if ($pelanggan_id <> '') {
			$this->db->where('transaksi.pelanggan_id', $pelanggan_id);
		}

		if ($status) {
			$this->db->where('transaksi.status', $status);
		}

		if ($metode_transaksi) {
			$this->db->where('transaksi.metode_transaksi', $metode_transaksi);
		}
		$this->db->select('transaksi.*, lokasi.name as lokasi, pelanggan.name as pelanggan,user.name as user');
		$this->db->join('lokasi', 'lokasi.id=transaksi.lokasi_id', 'left');
		$this->db->join('pelanggan', 'pelanggan.id=transaksi.pelanggan_id', 'left');
		$this->db->join('user', 'user.id=transaksi.user_id', 'left');
		if ($this->session->userdata('level') == 3) {
			$this->db->where_in('transaksi.lokasi_id', $this->session->userdata('gudang'));
		}
		$this->db->where('transaksi.jenis', 2);
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
		$this->form_validation->set_rules('metode_transaksi', 'Metode Transaksi', 'required');
		$this->form_validation->set_rules('gudang', 'Lokasi', 'required|numeric');
		$this->form_validation->set_rules('sumber', 'Sumber', 'required|numeric');

		if ($this->form_validation->run() == FALSE) {
			$response = array(
				'success' => false,
				'message' => validation_errors()
			);
			echo json_encode($response);
			return;
		}

		$status = 1;
		$tgl_jatuh_tempo = '';
		if ($this->input->post('metode_transaksi') == 'hutang') {
			$this->form_validation->set_rules('tgl_jatuh_tempo', 'Tanggal Jatuh Tempo', 'required');

			if ($this->form_validation->run() == FALSE) {
				$response = array(
					'success' => false,
					'message' => validation_errors()
				);
				echo json_encode($response);
				return;
			}
			$status = 2;
			$tgl_jatuh_tempo = $this->input->post('tgl_jatuh_tempo');
		}

		$this->db->trans_start();

		$lokasi_id = $this->input->post('gudang');

		$nota = $this->input->post('nota');
		if ($nota == '') {
			$nota = generate_code('transaksi', 'nota', 'TRX-OUT-');
		}

		$data['tgl'] = $this->input->post('tgl');
		$data['nota'] = $nota;
		$data['lokasi_id'] = $lokasi_id;
		$data['metode_transaksi'] = $this->input->post('metode_transaksi');
		$data['pelanggan_id'] = $this->input->post('pelanggan') ?? 0;
		$data['keterangan'] = $this->input->post('deskripsi');
		$data['sumber'] = $this->input->post('sumber');
		$data['jenis'] = 2;
		$data['status'] = $status;
		$data['tgl_jatuh_tempo'] = $tgl_jatuh_tempo;
		$data['user_id'] = $this->session->userdata('id');
		$data['total'] = clean_rupiah($this->input->post('total'));
		$data['bayar'] = clean_rupiah($this->input->post('bayar'));

		$save = $this->global->save($data, 'transaksi');
		$transaksi_id = $save;

		if ($transaksi_id) {
			$barang_id = $this->input->post('barang_id');
			$jumlah = $this->input->post('jumlah');
			$harga = $this->input->post('harga');
			$diskon = $this->input->post('diskon');

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
				} else {
					$response = array(
						'success' => false,
						'message' => 'Stock tidak ditemukan!'
					);
					echo json_encode($response);
					return;
				}

				$data = array(
					'transaksi_id' => $transaksi_id,
					'jenis' => 2,
					'lokasi_id' => $lokasi_id,
					'barang_id' => $barang_id[$index],
					'jumlah' => $jumlah[$index],
					'stock_awal' => $stock_awal,
					'stock_akhir' => $stock_akhir,
					'harga' => clean_rupiah($harga[$index]),
					'diskon' => $diskon[$index]
				);
				$this->global->save($data, 'transaksi_detail');
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
		}
	}

	public function getProdukLokasi()
	{
		$lokasi_id = $this->input->get('lokasi');
		$barang_id = $this->input->get('barang');
		$this->db->select('barang.kode as barang_kode,barang.name as barang_name,barang.harga,satuan.name as satuan_name,kategori.name as kategori_name,brand.name as brand_name,barang.min_stock,stock.*');
		$this->db->join('barang', 'barang.id=stock.barang_id', 'left');
		$this->db->join('kategori', 'kategori.id=barang.kategori_id', 'left');
		$this->db->join('satuan', 'satuan.id=barang.satuan_id', 'left');
		$this->db->join('brand', 'brand.id=barang.brand_id', 'left');
		$data = $this->global->get_where(array('lokasi_id' => $lokasi_id, 'barang_id' => $barang_id), 'stock');
		if ($data->num_rows() > 0) {
			$data = $data->row();
			if ($data->stock < 1) {
				$response = array(
					'success' => false,
					'message' => 'Stock habis',
				);
				echo json_encode($response);
				exit;
			}
			$response = array(
				'success' => true,
				'message' => 'Berhasil ambil data',
				'data' => $data
			);
		} else {

			$response = array(
				'success' => false,
				'message' => 'Stock barang tidak ditemukan',
			);
		}

		echo json_encode($response);
		exit;
	}

	public function get_by_id($id)
	{
		$data = $this->global->get_by_id($id, $this->table);
		echo json_encode($data);
	}

	public function bayar()
	{
		$id = $this->input->post('id');
		$bayar = clean_rupiah($this->input->post('bayar'));
		$cekTransaksi = $this->global->get_by_id($id, 'transaksi');
		if ($bayar < $cekTransaksi->total) {
			$response = array(
				'success' => false,
				'message' => 'Jumlah bayar masih kurang!',
			);
			echo json_encode($response);
			exit;
		}

		if ($cekTransaksi->status == 1 and $cekTransaksi->bayar == $cekTransaksi->total) {
			$response = array(
				'success' => false,
				'message' => 'Transaksi sudah selesai!',
			);
			echo json_encode($response);
			exit;
		}
		$this->db->trans_start();
		$data = array(
			'transaksi_id' => $id,
			'bayar' => $bayar,
			'user_id' => $this->session->userdata('id')
		);
		$res = $this->global->save($data, 'pembayaran');

		if (!$res) {
			$response = array(
				'success' => false,
				'message' => 'Gagal Disimpan!'
			);
			echo json_encode($response);
			return;
		}

		$update = $this->global->update(array('id' => $id), array('status' => 1, 'bayar' => $bayar), 'transaksi');
		if (!$update) {
			$response = array(
				'success' => false,
				'message' => 'Gagal Disimpan!'
			);
			echo json_encode($response);
			return;
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
	}
}
