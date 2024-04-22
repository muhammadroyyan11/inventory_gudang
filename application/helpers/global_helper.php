<?php
defined('BASEPATH') or exit('No direct script access allowed');

if (!function_exists('toko')) {
    function toko()
    {
        $CI = &get_instance();
        $CI->load->database();

        return $CI->db->get('setting')->row();
    }
}

if (!function_exists('generate_code')) {
    function generate_code($table_name, $column_name, $prefix = 'Rand')
    {
        $CI = &get_instance();
        $CI->load->database();

        $query = $CI->db->select('COUNT(*) as count')->from($table_name)->get();
        $result = $query->row_array();
        $count = $result['count'] + 1;

        $product_code = $prefix . str_pad($count, 5, '0', STR_PAD_LEFT);

        $query = $CI->db->select('id')->from($table_name)->where($column_name, $product_code)->get();
        $result = $query->row_array();

        while (!empty($result)) {
            $count++;
            $product_code = $prefix . str_pad($count, 5, '0', STR_PAD_LEFT);

            $query = $CI->db->select('id')->from($table_name)->where($column_name, $product_code)->get();
            $result = $query->row_array();
        }

        return $product_code;
    }
}

function enc($id, $key = 123)
{
    $encrypted_id = base64_encode($id);
    return urlencode($encrypted_id);
}

function dec($id, $key = 123)
{
    $decrypted_id = base64_decode(urldecode($id));
    return $decrypted_id;
}


function format_rupiah($angka)
{
    $rupiah = number_format($angka, 0, ',', '.');
    return 'Rp. ' . $rupiah;
}

function clean_rupiah($rupiah)
{
    $cleaned = preg_replace('/[^0-9\,]/', '', $rupiah);
    $cleaned = str_replace(',', '', $cleaned);
    $numeric_value = (float) $cleaned;
    return $numeric_value;
}

if (!function_exists('tglIndo')) {
    function tglIndo($tanggal)
    {
        $bulan = array(
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember'
        );

        // Memisahkan tanggal, bulan, dan tahun
        $tanggal_split = explode('-', $tanggal);
        $hari = $tanggal_split[2];
        $bulan_index = $tanggal_split[1];
        $tahun = $tanggal_split[0];

        // Format tanggal dalam bahasa Indonesia
        $hasil = $hari . ' ' . $bulan[(int)$bulan_index] . ' ' . $tahun;
        return $hasil;
    }
}

if (!function_exists('blnIndo')) {
    function blnIndo($bulan)
    {
        $bulan_dict = array(
            '01' => 'Januari',
            '02' => 'Februari',
            '03' => 'Maret',
            '04' => 'April',
            '05' => 'Mei',
            '06' => 'Juni',
            '07' => 'Juli',
            '08' => 'Agustus',
            '09' => 'September',
            '10' => 'Oktober',
            '11' => 'November',
            '12' => 'Desember'
        );
        return isset($bulan_dict[$bulan]) ? $bulan_dict[$bulan] : '';
    }
}
