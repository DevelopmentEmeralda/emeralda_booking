<?php

/* * ***
 * Version: 1.0.0
 *
 * Description of Auth Controller
 *
 * @author CodersMag Team
 *
 * @email  info@codersmag.com
 *
 * *** */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct() {
        parent::__construct();
        //load model
        $this->load->model('Auth_model', 'auth');
        $this->load->library('form_validation');
    }

    // index method
    public function registration() {        
        $data = array();
        $data['metaDescription'] = 'Reservasi';
        $data['metaKeywords'] = 'Reservasi';
        $data['title'] = "Reservasi Emeralda Resort";
        $data['breadcrumbs'] = array('Login' => '#');
        if (isset($_GET['ref'])) { $ref = $_GET['ref']; }
        echo $ref;
        exit;
        $this->load->view('auth/registration', $data);
    }

    // action create user method
    public function actionRegister() {
        // $this->form_validation->set_rules('nik_id', 'NIK', 'required');
        // $this->form_validation->set_rules('full_name', 'NIK', 'required');
        // $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[users.email]');
        // $this->form_validation->set_rules('contact_no', 'Contact No', 'required|regex_match[/^[0-9]{18}$/]');
        // $this->form_validation->set_rules('cluster', 'Cluster', 'required');
        // $this->form_validation->set_rules('transaksi', 'Transaksi', 'required');
        // $this->form_validation->set_rules('file_ktp', 'KTP', 'required');
        // $this->form_validation->set_rules('file_npwp', 'NPWP', 'required');
        
        // if ($this->form_validation->run() == FALSE) {
        //     $this->registration();
        // } else {
            $nik        = $this->input->post('nik_id');
            $firstName  = $this->input->post('full_name');
           
            $email      = $this->input->post('email');
            $contactNo  = $this->input->post('contact_no');

            $cluster    = $this->input->post('cluster');
            $transaksi  = $this->input->post('transaksi');

            $ktp        = $this->input->post('file_ktp');
            $npwp       = $this->input->post('file_npwp');
            $reff       = $this->input->post('ref_code');

            $info_ktp = $_FILES['file_ktp']['name'];
			$newname_ktp = $nik."-ktp.png"; 
	
			$target_ktp = 'uploads/'.$newname_ktp;
	
			$info_npwp = $_FILES['file_npwp']['name'];
			$newname_npwp = $nik."-nwpw.png"; 
	
			$target_npwp = 'uploads/'.$newname_npwp;

             move_uploaded_file( $_FILES['file_ktp']['tmp_name'],$target_ktp);
             move_uploaded_file( $_FILES['file_npwp']['tmp_name'], $target_npwp);

        


            $timeStamp  = time();
            $status     = 1;
            $verificationCode = 1;

            

            
            // $userName = $this->auth->generateUniqueUserName('users', trim($firstName . $lastName), 'user_name', NULL, NULL);
            $this->auth->setNIK($nik);
            $this->auth->setFullName($firstName);
            $this->auth->setEmail(trim($email));
            $this->auth->setContact($contactNo);  
            $this->auth->setCluster($cluster);
            $this->auth->setTransaksi($transaksi);
            $this->auth->setKtp($newname_ktp);
            $this->auth->setNPWP($newname_npwp);
            $this->auth->setReferral($reff);
            $chk = $this->auth->create();
            // redirect('auth/login');
        // }
    }
    
    // login method
    public function login() {        
        $data = array();
        $data['metaDescription'] = 'Login';
        $data['metaKeywords'] = 'Login';
        $data['title'] = "Login - CodersMag";
        $data['breadcrumbs'] = array('Login' => '#');
        
        $this->load->view('auth/login', $data);
    }
    

    // action login method
    function doLogin() {        
        // Check form  validation
        $this->load->library('form_validation');
        $this->form_validation->set_rules('user_name', 'User Name', 'trim|required');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            //Field validation failed.  User redirected to login page
            $this->login();
        } else {
          $sessArray = array();
            //Field validation succeeded.  Validate against database
            $username = $this->input->post('user_name');
            $password = $this->input->post('password');
            
            $this->auth->setUserName($username);
            $this->auth->setPassword($password);
            //query the database
            $result = $this->auth->login();

            if (!empty($result) && count($result) > 0) {
                foreach ($result as $row) {
                    $authArray = array(
                        'user_id' => $row->user_id,
                        'first_name' => $row->first_name,
                        'address' => $row->address,
                        'user_name' => $row->user_name,
                        'email' => $row->email,
                        'is_authenticate_user' => TRUE,
                    );
                    $this->session->set_userdata('ci_session_key_generate', TRUE);
                    $this->session->set_userdata('ci_seesion_key', $authArray);
                    // remember me
                    if(!empty($this->input->post("remember"))) {
	                    setcookie ("loginId", $username, time()+ (10 * 365 * 24 * 60 * 60));  
	                    setcookie ("loginPass",	$password,	time()+ (10 * 365 * 24 * 60 * 60));
                    } else {
	                    setcookie ("loginId",""); 
	                    setcookie ("loginPass","");
                    }                    
                }
                redirect('auth/profile');
            } else {
                $this->login();
            }
        }
    }
    // profile page
    public function profile() {  
        if ($this->session->userdata('ci_seesion_key')['is_authenticate_user'] == FALSE) {
            redirect('auth/login');
        } else {     
            $data = array();
            $data['metaDescription'] = 'Profile';
            $data['metaKeywords'] = 'Profile';
            $data['title'] = "Profile - CodersMag";
            $data['breadcrumbs'] = array('Profile' => '#');
            $this->load->view('auth/index', $data);
        }
    }
    //logout method
    public function logout() {
        $this->session->unset_userdata('ci_seesion_key');
        $this->session->unset_userdata('ci_session_key_generate');
        $this->session->sess_destroy();
        $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
        $this->output->set_header("Pragma: no-cache");
        redirect('auth/login');
    }   

}

