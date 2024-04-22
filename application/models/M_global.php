<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_global extends CI_Model
{


	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	function get_all($table)
	{
		$res = $this->db->get($table)->result();
		return $res;
	}

	private function _get_datatables_query($table, $column_order, $column_search, $order, $database = NULL)
	{
		$this->db->from($table);

		$i = 0;

		foreach ($column_search as $item) // loop kolom 
		{
			if ($_POST['search']['value']) // jika datatable mengirim POST untuk pencarian
			{
				if ($i === 0) // iterasi pertama
				{
					$this->db->group_start(); // buka tanda kurung. Query WHERE dengan klausa OR lebih baik dengan tanda kurung, karena mungkin dapat digabungkan dengan WHERE lain dengan klausa AND.
					$this->db->like($item, $_POST['search']['value']);
				} else {
					$this->db->or_like($item, $_POST['search']['value']);
				}

				if (count($column_search) - 1 == $i) // iterasi terakhir
					$this->db->group_end(); // tutup tanda kurung
			}
			$i++;
		}

		if (isset($_POST['order'])) // pengolahan order disini
		{
			$this->db->order_by($column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} else if (isset($order)) {
			$this->db->order_by(key($order), $order[key($order)]);
		}

		if (!empty($database)) {
			if (isset($database['where'])) {
				$this->db->where($database['where']);
			}
			if (isset($database['join'])) {
				foreach ($database['join'] as $join) {
					$this->db->join($join[0], $join[1], $join[2]);
				}
			}
			if (isset($database['select'])) {
				$this->db->select($database['select']);
			}
		}
	}


	function get_datatables($table, $column_order, $column_search, $order, $database = NULL)
	{
		$this->_get_datatables_query($table, $column_order, $column_search, $order, $database);
		if ($_POST['length'] != -1)
			$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	function count_filtered($table, $column_order, $column_search, $order, $database = NULL)
	{
		$this->_get_datatables_query($table, $column_order, $column_search, $order, $database);
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all($table, $database = NULL)
	{
		if (!empty($database)) {
			if (isset($database['where'])) {
				$this->db->where($database['where']);
			}
			if (isset($database['join'])) {
				foreach ($database['join'] as $join) {
					$this->db->join($join[0], $join[1], $join[2]);
				}
			}
			if (isset($database['select'])) {
				$this->db->select($database['select']);
			}
		}

		$this->db->from($table);
		return $this->db->count_all_results();
	}

	public function get_where($where, $table)
	{
		$this->db->where($where);
		$this->db->from($table);
		$query = $this->db->get();
		return $query;
	}

	public function get_by_id($id, $table)
	{
		$this->db->from($table);
		$this->db->where('id', $id);
		$query = $this->db->get();

		return $query->row();
	}

	public function save($data, $table)
	{
		$res = $this->db->insert($table, $data);
		return $this->db->insert_id();
	}

	public function update($where, $data, $table)
	{
		$this->db->update($table, $data, $where);
		return $this->db->affected_rows();
	}

	public function delete_by_id($id, $table)
	{
		$this->db->where('id', $id);
		$this->db->delete($table);
		return true;
	}
}
