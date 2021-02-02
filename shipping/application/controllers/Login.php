<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        //load model admin
        $this->load->model('Login_m');
    }

    public function index()
    {
      if($this->Login_m->logged_id())
      {

        $url = $this->db->query("select a.link from tb_menu a join role_group b on a.id_menu = b.id_menu where b.id_group = '".$this->session->userdata('id_groups')."' ")->row();
        redirect($url->link);

      }else{
          //jika session belum terdaftar
          //set form validation
          $this->form_validation->set_rules('username', 'Username', 'required');
          $this->form_validation->set_rules('password', 'Password', 'required');

          //set message form validation
          $this->form_validation->set_message('required', '<div class="alert alert-danger" style="margin-top: 3px">
              <div class="header"><b><i class="fa fa-exclamation-circle"></i> {field}</b> harus diisi</div></div>');

          //cek validasi
          if ($this->form_validation->run() == TRUE) {

          //get data dari FORM
          $username = $this->input->post("username", TRUE);
          $password = MD5($this->input->post('password', TRUE));

          //checking data via model
          $checking = $this->Login_m->check_login('user', array('username' => $username), array('password' => $password));

          //jika ditemukan, maka create session
          if ($checking != FALSE) {
              foreach ($checking as $apps) {
                  if ($apps->photo == NULL) {
                    $foto = base_url().'upload/1549665271_user.png';
                  }else{
                    $foto = $apps->photo;
                  }
                  $session_data = array(
                      'id_user'   => $apps->id_user,
                      'id_groups' => $apps->id_groups,
                      'nama_user' => $apps->nama_user,
                      'username'  => $apps->username,
                      'last_login'=> $apps->last_login,
                      'photo'     => $foto,
                      'status'    => $apps->status,
                      
                  );
                  //set session userdata
                  $this->session->set_userdata($session_data);

                  if ($session_data['id_groups'] == 1) {
                  redirect('dashboard');
                  }else if ($session_data['id_groups'] == 2) {
                  redirect('dashboard');
                  }else if ($session_data['id_groups'] == 3) {
                  redirect('dashboard');
                  }else if ($session_data['id_groups'] == 4) {
                  redirect('guest');
                  }

              }
          }else{

              $data['error'] = '<div class="alert alert-danger" style="margin-top: 3px">
                  <div class="header"><b><i class="fa fa-exclamation-circle"></i> ERROR</b> username atau password salah!</div></div>';
              $this->load->view('login', $data);
          }

      }else{
          session_destroy();
          $this->load->view('login');
      //   session_destroy();
      // redirect('login');
      }

    }

  }

  public function logout() 
  {
    $this->session->unset_userdata('username');
    $this->session->unset_userdata('id_user');
    $this->session->unset_userdata('id_groups');
    session_destroy();
    redirect('login');
  }
}