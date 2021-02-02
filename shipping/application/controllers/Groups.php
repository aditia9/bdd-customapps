<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Groups extends CI_Controller {

	function __construct() {
        parent::__construct();

        $this->load->library('session');
        $this->load->model('Login_m');
        $this->load->model('Master_employe','model');

        if(!$this->Login_m->logged_id())
        {
            session_destroy();
            redirect('login');
        }
    }

	function index()
	{
        $data['sub_menu'] = 23;
        $data['page_id'] = 18;
        $data['groups'] = $this->model->groups();    
		$this->template->load('template','master_employe/groups/index',$data);
	}

    function add()
    {
        $this->load->view('master_employe/groups/add');
    }

    function save()
    {
        $data = array(
                'name_groups'  => $this->input->post('name_groups')
        );
        $this->db->insert('groups',$data);
        redirect('groups/index');
    }

    function delete($id_groups)
    {
        $this->db->where('id_groups',$id_groups);
        $this->db->delete('groups');

        redirect('groups/index');
    }

    function edit($id_groups)
    {
        $data['sub_menu'] = 23;
        $data['page_id'] = 18;
        $data['datana'] = $this->model->groups_edit($id_groups);  
        $this->template->load('template','master_employe/groups/edit',$data);  
    }

    function update($id_groups)
    {
        $data = array(
                'name_groups'  => $this->input->post('name_groups')
        );

        $this->db->where('id_groups',$id_groups);
        $this->db->update('groups',$data);
        redirect('groups/index');
    }

}
