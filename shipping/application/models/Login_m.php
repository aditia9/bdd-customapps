<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login_m extends CI_Model
{

    function logged_id()
    {
        return $this->session->userdata('id_groups');
    }


    function check_login($table, $field1, $field2)
    {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where($field1);
        $this->db->where($field2);
        $this->db->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() == 0) {
            return FALSE;
        } else {
            return $query->result();
        }
    }
    // public function check_login($data) {
    //   $query = $this->db->get_where('user', $data);
    //   return $query;
    // }
}