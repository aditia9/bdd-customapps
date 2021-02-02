<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Data_master_m extends CI_Model{

    function all_confirm_paid($id_merchant){
        $this->db->select('*');
        $this->db->from('paid_confirm');
        $this->db->where('paid_confirm.id_merchant', $id_merchant);
        $this->db->order_by('paid_confirm.id DESC');
        $query = $this->db->get();
        return $query->result_array();
    }

    function raffle_list(){
        $this->db->select('*');
        $this->db->from('raffle');
        $this->db->order_by('create_at DESC');
        $query = $this->db->get();
        return $query->result_array();
    }

    function destination_row($destination_code){
        $this->db->select('*');
        $this->db->from('tarif');
        $this->db->where('tarif.destination_code', $destination_code);
        $query = $this->db->get();
        return $query->row();
    }

    function get_ongkir($destination_code){
    	$this->db->select('*');
        $this->db->from('tarif');
        $this->db->join('tarif_service', 'tarif.id = tarif_service.id_tarif', 'left');
        $this->db->where('tarif.destination_code', $destination_code);
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_all_ongkir(){
        $this->db->select('*');
        $this->db->from('tarif');
        $this->db->join('tarif_service', 'tarif.id = tarif_service.id_tarif', 'left');
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_ongkir_dasar($kecamatan,$provinsi,$aktif_service){
        $query = $this->db->query("SELECT *, tarif_service.id AS kode_service FROM `tarif` JOIN tarif_service ON tarif_service.id_tarif = tarif.id WHERE tarif.subdistrict LIKE '%$kecamatan%' AND tarif.city LIKE '%$provinsi%' AND tarif_service.service IN ($aktif_service)");

        return $query->result_array();
    }

    function get_rate($destination_code){
        $query =$this->db->query("SELECT *, tarif_service.id AS kode_service FROM `tarif` JOIN tarif_service ON tarif_service.id_tarif = tarif.id WHERE tarif.destination_code IN ($destination_code)");
        
        return $query->result_array();
    }

    function filter_confirm_paid($id_merchant,$from,$to){
        $this->db->select('*');
        $this->db->from('paid_confirm');
        $this->db->where('paid_confirm.id_merchant', $id_merchant);
        $this->db->where('paid_confirm.tgl_transfer >= ', $from);
        $this->db->where('paid_confirm.tgl_transfer <= ', $to);
        $this->db->order_by('paid_confirm.id DESC');
        $query = $this->db->get();
        return $query->result_array();
    }

    function merchant_all(){
        $this->db->select('*');
        $this->db->from('merchant_data');
        $this->db->where('merchant_data.uninstall = 0');
        $query = $this->db->get();
        return $query->result_array();
    }

    function merchant_ac_active(){
        $this->db->select('*');
        $this->db->from('merchant_data');
        $this->db->where('merchant_data.ac_active = 1');
        $query = $this->db->get();
        return $query->result_array();
    }

    function merchant_row($url){
        $this->db->select('*');
        $this->db->from('merchant_data');
        $this->db->where('merchant_data.url_shopify', $url);
        $this->db->where('merchant_data.uninstall = 0');
        $query = $this->db->get();
        return $query->row();
    }

    function merchant_byid($id_merchant){
        $this->db->select('*');
        $this->db->from('merchant_data');
        $this->db->where('merchant_data.id_merchant', $id_merchant);
        $this->db->where('merchant_data.uninstall = 0');
        $query = $this->db->get();
        return $query->row();
    }
}