<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_global', 'global');
		is_login();
	}

	public function index()
	{
		$data['total_barang'] = $this->total_barang();
		$data['total_user'] = $this->total_user();
		$this->load->view('template/header');
		$this->load->view('dashboard/index', $data);
		$this->load->view('template/footer');
	}

	public function card_total()
	{
		$this->filter();
		$total_penjualan = $this->total_penjualan();

		$this->filter();
		$total_trx_masuk = $this->total_trx_masuk();

		$this->filter();
		$total_trx_keluar = $this->total_trx_keluar();

		$this->filter();
		$total_trx_return = $this->total_trx_return();
		$res = array(
			'total_penjualan' => format_rupiah($total_penjualan),
			'total_trx_masuk' => $total_trx_masuk,
			'total_trx_keluar' => $total_trx_keluar,
			'total_trx_return' => $total_trx_return
		);
		echo json_encode($res);
	}

	private function filter()
	{
		if ($this->input->get('jenis') == 1) {
			$param = $this->input->get('param');
			$startDate = date('Y-m-d', strtotime($param . ' -1 days'));
			$endDate = date('Y-m-d', strtotime($param . ' +6 days'));


			$this->db->where('transaksi.tgl >=', $startDate);
			$this->db->where('transaksi.tgl <=', $endDate);
			// $this->db->group_by('transaksi.jenis,transaksi.tgl');
		} elseif ($this->input->get('jenis') == 2) {
			$param = $this->input->get('param');
			$bulan = date('m', strtotime($param));
			$tahun = date('Y', strtotime($param));

			$startDate = date('Y-m-01', strtotime($tahun . '-' . $bulan));
			$endDate = date('Y-m-t', strtotime($tahun . '-' . $bulan));
			$this->db->where('transaksi.tgl >=', $startDate);
			$this->db->where('transaksi.tgl <=', $endDate);
			// $this->db->group_by('transaksi.jenis, transaksi.tgl');
		} elseif ($this->input->get('jenis') == 3) {
			$tahun = $this->input->get('param');

			$this->db->where('YEAR(transaksi.tgl)', $tahun);
			// $this->db->group_by('MONTH(transaksi.tgl), transaksi.jenis');
		} else {
			$bulan = date('m');
			$tahun = date('Y');

			$startDate = date('Y-m-01', strtotime($tahun . '-' . $bulan));
			$endDate = date('Y-m-t', strtotime($tahun . '-' . $bulan));

			$this->db->where('transaksi.tgl >=', $startDate);
			$this->db->where('transaksi.tgl <=', $endDate);
			// $this->db->group_by('transaksi.jenis, transaksi.tgl');
		}
	}


	public function total_penjualan()
	{
		$this->db->select('sum(total) as total');
		if ($this->session->userdata('level') == 3) {
			$this->db->where_in('transaksi.lokasi_id', $this->session->userdata('gudang'));
		}
		$total = $this->db->get('transaksi')->row();
		return	$total->total;
	}

	public function total_stock_barang()
	{
		$this->db->select('sum(stock.stock) as total');
		if ($this->session->userdata('level') == 3) {
			$this->db->where_in('stock.lokasi_id', $this->session->userdata('gudang'));
		}
		$total = $this->db->get('stock')->row();
		return	$total->total;
	}

	public function total_barang()
	{
		$this->db->select('count(id) as total');
		$total = $this->db->get('barang')->row();
		return	$total->total;
	}

	public function total_trx_masuk()
	{
		$this->db->select('count(transaksi.id) as total');
		if ($this->session->userdata('level') == 3) {
			$this->db->where_in('transaksi.lokasi_id', $this->session->userdata('gudang'));
		}
		$this->db->where('jenis', 1);
		$total = $this->db->get('transaksi')->row();
		return	$total->total;
	}

	public function total_trx_keluar()
	{
		$this->db->select('count(transaksi.id) as total');
		if ($this->session->userdata('level') == 3) {
			$this->db->where_in('transaksi.lokasi_id', $this->session->userdata('gudang'));
		}
		$this->db->where('jenis', 2);
		$total = $this->db->get('transaksi')->row();
		return	$total->total;
	}

	public function total_trx_return()
	{
		$this->db->select('count(transaksi.id) as total');
		if ($this->session->userdata('level') == 3) {
			$this->db->where_in('transaksi.lokasi_id', $this->session->userdata('gudang'));
		}
		$this->db->where('jenis', 3);
		$total = $this->db->get('transaksi')->row();
		return	$total->total;
	}

	public function total_user()
	{
		$this->db->select('count(user.id) as total');
		$total = $this->db->get('user')->row();
		return	$total->total;
	}

	public function top_selling()
	{

		if ($this->input->post('jenis') == 1) {
			$param = $this->input->post('param');
			$startDate = date('Y-m-d', strtotime($param . ' -1 days'));
			$endDate = date('Y-m-d', strtotime($param . ' +6 days'));


			$this->db->where('transaksi.tgl >=', $startDate);
			$this->db->where('transaksi.tgl <=', $endDate);
			// $this->db->group_by('transaksi.jenis,transaksi.tgl');
		} elseif ($this->input->post('jenis') == 2) {
			$param = $this->input->post('param');
			$bulan = date('m', strtotime($param));
			$tahun = date('Y', strtotime($param));

			$startDate = date('Y-m-01', strtotime($tahun . '-' . $bulan));
			$endDate = date('Y-m-t', strtotime($tahun . '-' . $bulan));
			$this->db->where('transaksi.tgl >=', $startDate);
			$this->db->where('transaksi.tgl <=', $endDate);
			// $this->db->group_by('transaksi.jenis, transaksi.tgl');
		} elseif ($this->input->post('jenis') == 3) {
			$tahun = $this->input->post('param');

			$this->db->where('YEAR(transaksi.tgl)', $tahun);
			// $this->db->group_by('MONTH(transaksi.tgl), transaksi.jenis');
		} else {
			$bulan = date('m');
			$tahun = date('Y');

			$startDate = date('Y-m-01', strtotime($tahun . '-' . $bulan));
			$endDate = date('Y-m-t', strtotime($tahun . '-' . $bulan));

			$this->db->where('transaksi.tgl >=', $startDate);
			$this->db->where('transaksi.tgl <=', $endDate);
			// $this->db->group_by('transaksi.jenis, transaksi.tgl');
		}

		$this->db->select('barang.name,transaksi_detail.harga,sum(transaksi_detail.jumlah) as jumlah,sum(transaksi_detail.harga*transaksi_detail.jumlah) as total');
		// $this->db->limit('5', 0);
		$this->db->where('transaksi.jenis', 2);
		$this->db->join('transaksi', 'transaksi.id=transaksi_detail.transaksi_id', 'left');
		$this->db->join('barang', 'barang.id=transaksi_detail.barang_id');
		if ($this->session->userdata('level') == 3) {
			$this->db->where_in('transaksi_detail.lokasi_id', $this->session->userdata('gudang'));
		}
		$this->db->group_by('transaksi_detail.barang_id');
		$this->db->order_by('transaksi_detail.jumlah', 'desc');
		$list = $this->global->get_datatables('transaksi_detail', array(null, 'barang.name', 'transaksi_detail.harga', 'transaksi_detail.jumlah', 'total'),  array('barang.name', 'transaksi_detail.harga', 'transaksi_detail.jumlah', 'total'), array('id', 'desc'));
		$response = array();
		$no = $_POST['start'];
		foreach ($list as $r) {
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $r->name;
			$row[] = format_rupiah($r->harga);
			$row[] = $r->jumlah;
			$row[] = format_rupiah($r->total);
			$response[] = $row;
		}
		if ($this->input->post('jenis') == 1) {
			$param = $this->input->post('param');
			$startDate = date('Y-m-d', strtotime($param . ' -1 days'));
			$endDate = date('Y-m-d', strtotime($param . ' +6 days'));


			$this->db->where('transaksi.tgl >=', $startDate);
			$this->db->where('transaksi.tgl <=', $endDate);
			// $this->db->group_by('transaksi.jenis,transaksi.tgl');
		} elseif ($this->input->post('jenis') == 2) {
			$param = $this->input->post('param');
			$bulan = date('m', strtotime($param));
			$tahun = date('Y', strtotime($param));

			$startDate = date('Y-m-01', strtotime($tahun . '-' . $bulan));
			$endDate = date('Y-m-t', strtotime($tahun . '-' . $bulan));
			$this->db->where('transaksi.tgl >=', $startDate);
			$this->db->where('transaksi.tgl <=', $endDate);
			// $this->db->group_by('transaksi.jenis, transaksi.tgl');
		} elseif ($this->input->post('jenis') == 3) {
			$tahun = $this->input->post('param');

			$this->db->where('YEAR(transaksi.tgl)', $tahun);
			// $this->db->group_by('MONTH(transaksi.tgl), transaksi.jenis');
		} else {
			$bulan = date('m');
			$tahun = date('Y');

			$startDate = date('Y-m-01', strtotime($tahun . '-' . $bulan));
			$endDate = date('Y-m-t', strtotime($tahun . '-' . $bulan));

			$this->db->where('transaksi.tgl >=', $startDate);
			$this->db->where('transaksi.tgl <=', $endDate);
			// $this->db->group_by('transaksi.jenis, transaksi.tgl');
		}
		$this->db->select('barang.name,transaksi_detail.harga,sum(transaksi_detail.jumlah) as jumlah,sum(transaksi_detail.harga*transaksi_detail.jumlah) as total');
		// $this->db->limit('5', 0);
		$this->db->where('transaksi.jenis', 2);
		$this->db->join('transaksi', 'transaksi.id=transaksi_detail.transaksi_id');
		$this->db->join('barang', 'barang.id=transaksi_detail.barang_id');
		if ($this->session->userdata('level') == 3) {
			$this->db->where_in('transaksi_detail.lokasi_id', $this->session->userdata('gudang'));
		}
		$this->db->group_by('transaksi_detail.barang_id');
		$this->db->order_by('transaksi_detail.jumlah', 'desc');
		$recordsTotal = $this->global->count_all('transaksi_detail');

		if ($this->input->post('jenis') == 1) {
			$param = $this->input->post('param');
			$startDate = date('Y-m-d', strtotime($param . ' -1 days'));
			$endDate = date('Y-m-d', strtotime($param . ' +6 days'));


			$this->db->where('transaksi.tgl >=', $startDate);
			$this->db->where('transaksi.tgl <=', $endDate);
			// $this->db->group_by('transaksi.jenis,transaksi.tgl');
		} elseif ($this->input->post('jenis') == 2) {
			$param = $this->input->post('param');
			$bulan = date('m', strtotime($param));
			$tahun = date('Y', strtotime($param));

			$startDate = date('Y-m-01', strtotime($tahun . '-' . $bulan));
			$endDate = date('Y-m-t', strtotime($tahun . '-' . $bulan));
			$this->db->where('transaksi.tgl >=', $startDate);
			$this->db->where('transaksi.tgl <=', $endDate);
			// $this->db->group_by('transaksi.jenis, transaksi.tgl');
		} elseif ($this->input->post('jenis') == 3) {
			$tahun = $this->input->post('param');

			$this->db->where('YEAR(transaksi.tgl)', $tahun);
			// $this->db->group_by('MONTH(transaksi.tgl), transaksi.jenis');
		} else {
			$bulan = date('m');
			$tahun = date('Y');

			$startDate = date('Y-m-01', strtotime($tahun . '-' . $bulan));
			$endDate = date('Y-m-t', strtotime($tahun . '-' . $bulan));

			$this->db->where('transaksi.tgl >=', $startDate);
			$this->db->where('transaksi.tgl <=', $endDate);
			// $this->db->group_by('transaksi.jenis, transaksi.tgl');
		}
		$this->db->select('barang.name,transaksi_detail.harga,sum(transaksi_detail.jumlah) as jumlah,sum(transaksi_detail.harga*transaksi_detail.jumlah) as total');
		// $this->db->limit('5', 0);
		$this->db->where('transaksi.jenis', 2);
		$this->db->join('transaksi', 'transaksi.id=transaksi_detail.transaksi_id');
		$this->db->join('barang', 'barang.id=transaksi_detail.barang_id');
		if ($this->session->userdata('level') == 3) {
			$this->db->where_in('transaksi_detail.lokasi_id', $this->session->userdata('gudang'));
		}
		$this->db->group_by('transaksi_detail.barang_id');
		$this->db->order_by('transaksi_detail.jumlah', 'desc');
		$recordsFiltered = $this->global->count_filtered('transaksi_detail', array(null, 'barang.name', 'transaksi_detail.harga', 'transaksi_detail.jumlah', 'total'),  array('barang.name', 'transaksi_detail.harga', 'transaksi_detail.jumlah', 'total'), array('id', 'desc'));
		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $recordsTotal,
			"recordsFiltered" => $recordsFiltered,
			"data" => $response,
		);
		echo json_encode($output);
	}

	public function data_chart()
	{
		if ($this->session->userdata('level') == 3) {
			$this->db->where_in('transaksi_detail.lokasi_id', $this->session->userdata('gudang'));
		}
		if ($this->input->get('jenis') == 1) {
			$param = $this->input->get('param');
			$startDate = date('Y-m-d', strtotime($param . ' -1 days'));
			$endDate = date('Y-m-d', strtotime($param . ' +6 days'));

			$dateArray = [];
			$currentDate = new DateTime($startDate);
			$endDateObj = new DateTime($endDate);
			while ($currentDate <= $endDateObj) {
				$dateArray[] = $currentDate->format('Y-m-d');
				$currentDate->modify('+1 day');
			}

			$this->db->select('transaksi.tgl, transaksi.jenis, sum(transaksi_detail.jumlah) as jumlah');
			$this->db->join('transaksi', 'transaksi.id=transaksi_detail.transaksi_id', 'left');
			$this->db->where('transaksi.tgl >=', $startDate);
			$this->db->where('transaksi.tgl <=', $endDate);
			$this->db->group_by('transaksi.jenis,transaksi.tgl');
			$this->db->where_in('transaksi.jenis', [1, 2, 3]);
			$query = $this->db->get('transaksi_detail')->result_array();

			$result = [];
			foreach ($dateArray as $date) {
				$result[$date] = [
					'barang_masuk' => 0,
					'barang_keluar' => 0,
					'barang_return' => 0
				];
			}

			foreach ($query as $row) {
				$result[$row['tgl']][$this->getTransactionTypeLabel($row['jenis'])] = (int)$row['jumlah'];
			}

			echo json_encode($result);
		} elseif ($this->input->get('jenis') == 2) {
			$param = $this->input->get('param');
			$bulan = date('m', strtotime($param));
			$tahun = date('Y', strtotime($param));

			$startDate = date('Y-m-01', strtotime($tahun . '-' . $bulan));
			$endDate = date('Y-m-t', strtotime($tahun . '-' . $bulan));

			$this->db->select('transaksi.tgl, transaksi.jenis, sum(transaksi_detail.jumlah) as jumlah');
			$this->db->join('transaksi', 'transaksi.id=transaksi_detail.transaksi_id', 'left');
			$this->db->where('transaksi.tgl >=', $startDate);
			$this->db->where('transaksi.tgl <=', $endDate);
			$this->db->group_by('transaksi.jenis, transaksi.tgl');
			$this->db->where_in('transaksi.jenis', [1, 2, 3]);
			$query = $this->db->get('transaksi_detail')->result_array();

			$result = [];
			$currentDate = new DateTime($startDate);
			while ($currentDate <= new DateTime($endDate)) {
				$result[$currentDate->format('Y-m-d')] = [
					'barang_masuk' => 0,
					'barang_keluar' => 0,
					'barang_return' => 0
				];
				$currentDate->modify('+1 day');
			}

			foreach ($query as $row) {
				$result[$row['tgl']][$this->getTransactionTypeLabel($row['jenis'])] = (int)$row['jumlah'];
			}

			echo json_encode($result);
		} elseif ($this->input->get('jenis') == 3) {
			$tahun = $this->input->get('param');

			$result = [];

			$nama_bulan = [
				'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
				'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
			];

			$this->db->select('MONTH(transaksi.tgl) as bulan, transaksi.jenis, sum(transaksi_detail.jumlah) as jumlah');
			$this->db->join('transaksi', 'transaksi.id=transaksi_detail.transaksi_id', 'left');
			$this->db->where('YEAR(transaksi.tgl)', $tahun);
			$this->db->group_by('MONTH(transaksi.tgl), transaksi.jenis');
			$this->db->where_in('transaksi.jenis', [1, 2, 3]);
			$query = $this->db->get('transaksi_detail')->result_array();

			foreach ($nama_bulan as $bulan) {
				$result[$bulan] = [
					'barang_masuk' => 0,
					'barang_keluar' => 0,
					'barang_return' => 0
				];
			}

			foreach ($query as $row) {
				$bulan = $row['bulan'];
				$nama_bulan_indonesia = $nama_bulan[$bulan - 1];
				$jenis_transaksi = $row['jenis'];

				switch ($jenis_transaksi) {
					case 1:
						$result[$nama_bulan_indonesia]['barang_masuk'] = (int)$row['jumlah'];
						break;
					case 2:
						$result[$nama_bulan_indonesia]['barang_keluar'] = (int)$row['jumlah'];
						break;
					case 3:
						$result[$nama_bulan_indonesia]['barang_return'] = (int)$row['jumlah'];
						break;
				}
			}

			echo json_encode($result);
		} else {
			$bulan = date('m');
			$tahun = date('Y');

			$startDate = date('Y-m-01', strtotime($tahun . '-' . $bulan));
			$endDate = date('Y-m-t', strtotime($tahun . '-' . $bulan));

			$this->db->select('transaksi.tgl, transaksi.jenis, sum(transaksi_detail.jumlah) as jumlah');
			$this->db->join('transaksi', 'transaksi.id=transaksi_detail.transaksi_id', 'left');
			$this->db->where('transaksi.tgl >=', $startDate);
			$this->db->where('transaksi.tgl <=', $endDate);
			$this->db->group_by('transaksi.jenis, transaksi.tgl');
			$this->db->where_in('transaksi.jenis', [1, 2, 3]);
			$query = $this->db->get('transaksi_detail')->result_array();

			$result = [];
			$currentDate = new DateTime($startDate);
			while ($currentDate <= new DateTime($endDate)) {
				$result[$currentDate->format('Y-m-d')] = [
					'barang_masuk' => 0,
					'barang_keluar' => 0,
					'barang_return' => 0
				];
				$currentDate->modify('+1 day');
			}

			foreach ($query as $row) {
				$result[$row['tgl']][$this->getTransactionTypeLabel($row['jenis'])] = (int)$row['jumlah'];
			}

			echo json_encode($result);
		}
	}

	private function getTransactionTypeLabel($type)
	{
		switch ($type) {
			case 1:
				return 'barang_masuk';
			case 2:
				return 'barang_keluar';
			case 3:
				return 'barang_return';
			default:
				return '';
		}
	}


	public function data_chart_donut()
	{
		if ($this->session->userdata('level') == 3) {
			$this->db->where_in('transaksi_detail.lokasi_id', $this->session->userdata('gudang'));
		}
		if ($this->input->get('jenis') == 1) {
			$param = $this->input->get('param');
			$startDate = date('Y-m-d', strtotime($param . ' -1 days'));
			$endDate = date('Y-m-d', strtotime($param . ' +6 days'));

			$this->db->select('transaksi.sumber, sum(transaksi_detail.jumlah) as jumlah');
			$this->db->join('transaksi', 'transaksi.id=transaksi_detail.transaksi_id', 'left');
			$this->db->where('transaksi.tgl >=', $startDate);
			$this->db->where('transaksi.tgl <=', $endDate);
			$this->db->group_by('transaksi.sumber');
			$this->db->where('transaksi.jenis', 2);
			$query = $this->db->get('transaksi_detail')->result_array();

			$result = [
				'offline' => 0,
				'online' => 0
			];

			foreach ($query as $row) {
				$result[$this->getTransactionSumber($row['sumber'])] = (int)$row['jumlah'];
			}

			echo json_encode($result);
		} elseif ($this->input->get('jenis') == 2) {
			$param = $this->input->get('param');
			$bulan = date('m', strtotime($param));
			$tahun = date('Y', strtotime($param));

			$startDate = date('Y-m-01', strtotime($tahun . '-' . $bulan));
			$endDate = date('Y-m-t', strtotime($tahun . '-' . $bulan));

			$this->db->select('transaksi.sumber, sum(transaksi_detail.jumlah) as jumlah');
			$this->db->join('transaksi', 'transaksi.id=transaksi_detail.transaksi_id', 'left');
			$this->db->where('transaksi.tgl >=', $startDate);
			$this->db->where('transaksi.tgl <=', $endDate);
			$this->db->group_by('transaksi.sumber');
			$this->db->where('transaksi.jenis', 2);
			$query = $this->db->get('transaksi_detail')->result_array();

			$result = [
				'offline' => 0,
				'online' => 0
			];

			foreach ($query as $row) {
				$result[$this->getTransactionSumber($row['sumber'])] = (int)$row['jumlah'];
			}

			echo json_encode($result);
		} elseif ($this->input->get('jenis') == 3) {
			$tahun = $this->input->get('param');

			$result = [
				'offline' => 0,
				'online' => 0
			];

			$this->db->select('transaksi.sumber, sum(transaksi_detail.jumlah) as jumlah');
			$this->db->join('transaksi', 'transaksi.id=transaksi_detail.transaksi_id', 'left');
			$this->db->where('YEAR(transaksi.tgl)', $tahun);
			$this->db->group_by('transaksi.sumber');
			$this->db->where('transaksi.jenis', 2);
			$query = $this->db->get('transaksi_detail')->result_array();

			foreach ($query as $row) {
				$result[$this->getTransactionSumber($row['sumber'])] = (int)$row['jumlah'];
			}

			echo json_encode($result);
		} else {
			$bulan = date('m');
			$tahun = date('Y');

			$startDate = date('Y-m-01', strtotime($tahun . '-' . $bulan));
			$endDate = date('Y-m-t', strtotime($tahun . '-' . $bulan));

			$this->db->select('transaksi.sumber, sum(transaksi_detail.jumlah) as jumlah');
			$this->db->join('transaksi', 'transaksi.id=transaksi_detail.transaksi_id', 'left');
			$this->db->where('transaksi.tgl >=', $startDate);
			$this->db->where('transaksi.tgl <=', $endDate);
			$this->db->group_by('transaksi.sumber');
			$this->db->where('transaksi.jenis', 2);
			$query = $this->db->get('transaksi_detail')->result_array();

			$result = [
				'offline' => 0,
				'online' => 0
			];

			foreach ($query as $row) {
				$result[$this->getTransactionSumber($row['sumber'])] = (int)$row['jumlah'];
			}

			echo json_encode($result);
		}
	}

	private function getTransactionSumber($type)
	{
		switch ($type) {
			case 1:
				return 'offline';
			case 2:
				return 'online';
			default:
				return '';
		}
	}
}
