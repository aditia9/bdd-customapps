<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_data extends CI_Model{

    function merchant_all(){
        $this->db->select('*');
        $this->db->from('merchant_data');
        $this->db->where('merchant_data.uninstall = 0');
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

    function merchant_uninstalled($url){
        $this->db->select('*');
        $this->db->from('uninstall_merchant');
        $this->db->where('uninstall_merchant.url_shopify', $url);
        $query = $this->db->get();
        return $query->result_array();
    }

    function update_shop($where_id, $data, $table){
        $this->db->where($where_id);
        $this->db->update($table,$data);
    }

}