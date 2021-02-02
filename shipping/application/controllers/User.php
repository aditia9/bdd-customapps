<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

  function __construct() {
    parent::__construct();
    $this->load->library('session');
    $this->load->model('Login_m');

    if(!$this->Login_m->logged_id())
    {
      session_destroy();
      redirect('login');         
    }
  }

 function index()
 {

    $data['sub_menu'] = 2;
    $data['page_id'] = 3;
    $data['user'] = $this->db->query("select a.*, b.name_groups from user a join groups b on a.id_groups = b.id_groups")->result_array();
    $this->template->load('template','master_employe/user/index',$data);
 }

 function save()
 {
    extract($_POST);
      $upload1 = $_FILES['photo']['name'];
      $nmfile1 = time()."_".$upload1;

      if($upload1 !== ""){
           $config['upload_path']          = './upload/';
           $config['allowed_types']        = 'pdf|jpg|jpeg|png';
           $config['max_size']             = 1000000;
           $config['file_name']            = $nmfile1;
           
           $this->load->library('upload', $config);
           $this->upload->do_upload('photo');               
           $data1 = $this->upload->data();
      }

      $data = array(
            'nama_user' => $nama_user,
            'id_groups' => $id_groups,
            'username'  => $username,
            'password'  => md5($password),
            'status'    => $status,
            'photo'     => $data1['file_name'],
    );

    $this->db->insert('user',$data);
    redirect('user/index');
 }

 function edit($id_user)
 {
    $data['sub_menu'] = 2;
    $data['page_id'] = 3;
    $data['user'] = $this->db->query("select a.*, b.name_groups from user a join groups b on a.id_groups = b.id_groups where a.id_user = $id_user")->row();
    $this->template->load('template','master_employe/user/edit',$data);
 }

 function update($id_user)
 {
    extract($_POST);
      $upload1 = $_FILES['photo']['name'];
      $nmfile1 = time()."_".$upload1;

      if($upload1 !== ""){
           $config['upload_path']          = './upload/';
           $config['allowed_types']        = 'pdf|jpg|jpeg|png';
           $config['max_size']             = 1000000;
           $config['file_name']            = $nmfile1;
           
           $this->load->library('upload', $config);
           $this->upload->do_upload('photo');               
           $data1 = $this->upload->data();
      }

      if ($password != "") {
        $passna = md5($password);
      }

      $data = array(
            'nama_user' => $nama_user,
            'id_groups' => $id_groups,
            'username'  => $username,
            'password'  => $passna,
            'status'    => $status,
            'photo'     => $data1['file_name'],
    );

    $this->db->where('id_user',$id_user);
    $this->db->update('user',$data);
    redirect('user/index');
 }

 function delete($id_user)
 {
    $this->db->where('id_user',$id_user);
    $this->db->delete('user');
     redirect('user');
 }

 function myprofile($id_user){
    $data['sub_menu'] = 2;
    $data['page_id'] = 3;
    $data['user'] = $this->db->query("select a.*, b.name_groups from user a join groups b on a.id_groups = b.id_groups where a.id_user = $id_user")->row();

    $this->template->load('template','master_employe/user/my',$data);

 }

}
