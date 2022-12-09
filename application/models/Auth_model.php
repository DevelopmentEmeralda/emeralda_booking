<?php

/* * ***
 * Version: V1.0.1
 *
 * Description of Auth model
 *
 * @author TechArise Team
 *
 * @email  info@techarise.com
 *
 * *** */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Auth_model extends CI_Model {
    // Declaration of a variables
    private $_nik;
    private $_fullname;
    private $_email;
    private $_contactNo;
    private $_cluster;
    private $_transaksi;
    private $_ktp;
    private $_npwp;
    private $_referral;
    private $_id_sales;

    private $_is_reserv;
    private $_is_book;
 
    //Declaration of a methods
 
    public function setNIK($nik) {
        $this->_nik = $nik;
    }

    public function setFullName($fullname) {
        $this->_fullname = $fullname;
    }
 
    public function setEmail($email) {
        $this->_email = $email;
    }
 
    public function setContact($contactNo) {
        $this->_contactNo = $contactNo;
    }
 
    public function setCluster($cluster) {
        $this->_cluster = $cluster;
    }
 
    public function setTransaksi($transaksi) {
        $this->_transaksi = $transaksi;

        if ($transaksi == 2) {
            $this->_is_reserv  = 1;
            $this->_is_book  = 0;
        } else {
            $this->_is_reserv  = 0;
            $this->_is_book  = 1;
        }
    }
 
 
    public function setKtp($ktp) {
        $this->_ktp = $ktp;
    }

    public function setNPWP($npwp) {
        $this->_npwp = $npwp;
    }
 
    public function setReferral($referral) {
        $this->_referral = $referral;
    }

    public function getsales($referral) {
        $this->db->select('id');
        $this->db->from('yanpro_master.mr_sales');
        $this->db->where('referral_code', $this->_referral);
       
        $query = $this->db->get();
        return $query->row();	

    }

    public function getcustomer($nik) {
        $this->db->select('id');
        $this->db->from('yanpro_master.mr_customer');
        $this->db->where('nik', $nik);
       
        $query = $this->db->get();
        return $query->row();	

    }



    public function createCustomer() {

        $data = [
                    'nik'           => $this->_nik,
                    'full_name'     => $this->_fullname,
                    'phone'         => $this->_contactNo,
                    'email'         => $this->_email,
                    'referral_code' => $this->_referral,
                    'id_sales'      => $this->_id_sales,
                    'upload_ktp'    => $this->_ktp,
                    'upload_npwp'   => $this->_npwp,
                    'is_leads'      => 0,
                    'is_reserve'    => $this->_is_reserv,

                    'is_book'       => $this->_is_book,
                    'is_skup'       => 0,
                    ];

        $this->db->insert('yanpro_master.mr_customer', $data);
        $this->db->trans_complete();
       
        $idcustomer = get_object_vars($this->getcustomer($this->_nik));
        


        $hdr = array(
            'id_customer'       => $idcustomer['id'],
            'id_transaction'    => $this->_transaksi,
            'id_status'         => 4,
            'referral_code'     => $this->_referral,
            'id_sales'          => $this->_id_sales,
            'description'       => ''
        );
        $this->db->insert('yanpro_master.tr_transaction_hdr', $hdr);
       
        
        $this->db->trans_complete();

    }

    
    //create new user
    public function create() {
        
        $hasil = get_object_vars($this->getsales($this->_referral));
        $this->_id_sales = $hasil['id']; 
        $this->createCustomer();

    }
       
    // login method and password verify
    function login() {
        
        $this->db->select('id as user_id, user_name, email, first_name, password, address');
        $this->db->from('users');
        $this->db->where('email', $this->_userName);
        $this->db->where('verification_code', 1);
        $this->db->where('status', 1);
        //{OR}
        $this->db->or_where('user_name', $this->_userName);
        $this->db->where('verification_code', 1);
        $this->db->where('status', 1);
        $this->db->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            $result = $query->result();
            foreach ($result as $row) {
                if ($this->verifyHash($this->_password, $row->password) == TRUE) {
                    return $result;
                } else {
                    return FALSE;
                }
            }
        } else {
            return FALSE;
        }
    }
    
    // password hash
    public function hash($password) {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        return $hash;
    }
 
    // password verify
    public function verifyHash($password, $vpassword) {
        if (password_verify($password, $vpassword)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    // generate Unique Username
    public function generateUniqueUserName($tableName, $string, $field, $key = NULL, $value = NULL) {
        $slug = $this->cleanUserName($string);
        $i = 0;
        $params = array();
        $params[$field] = $slug;
        if ($key)
            $params["$key !="] = $value;
        while ($this->db->where($params)->get($tableName)->num_rows()) {
            if (!preg_match('/[0-9]+$/', $slug))
                $slug .= '' . ++$i;
            else
                $slug = preg_replace('/[0-9]+$/', ++$i, $slug);
            $params [$field] = $slug;
        }
        return $slug;
    }

    // clean Username
    public function cleanUserName($string) {
        //Lower case everything
        $string = strtolower(trim($string));
        //Make alphanumeric (removes all other characters)
        $string = preg_replace("/[^a-z0-9_\s-]/", "", $string);
        //Clean up multiple dashes or whitespaces
        $string = preg_replace("/[\s-]+/", " ", $string);
        //Convert whitespaces and underscore to dash
        $string = preg_replace("/[\s_]/", "", $string);
        $string = rtrim($string, '');
        return $string;
    }

}
?>
