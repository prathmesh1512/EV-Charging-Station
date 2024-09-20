<?php  
defined('BASEPATH') OR exit('No direct script access allowed');  
  
class Login extends CI_Controller {  
      
    public function index()  
    {  
        $this->load->view('login_view');  
    }  
    public function process()  
    {  
        $params = array(
            'UA_Login' => $this->input->post('ah_username'),  
            'US_Passkey' => $this->input->post('ah_password'),              
            'US_Active' => 1              
        );
        $login_data = $this->db->get_where('user_auths',$params)->row_array();
        print_r($login_data);
        if(isset($login_data['iduser_auths']))
        {  
            //declaring session  
            $user_data = array(
                'authid' => $login_data['iduser_auths'],
                'auth_idev' => $login_data['US_Idevstation'],
                'authname' => $login_data['UA_Name']
            );
            $this->session->set_userdata($user_data);  
                print_r($this->session->userdata());
            redirect('dashboard');
        }  
        else{                             
            $this->session->set_flashdata('alert_msg', '<div class="alert alert-danger text-center">Login Failed!! Invalid Username or password. Please try again.</div>'); 
            $data['error'] = 'Please Try Again';
            $this->load->view('login_view', $data);  
        }  
    }  
    public function logout()  
    {  
        //removing session  
        $this->session->sess_destroy();
        redirect("login");  
    }  
  
    
 function customer_register()
 {  
     $this->load->model('Customers_model');
try{
      $params = array(
       'CustName'=> $this->input->post('CustName'),
       'CustPass'=> $this->input->post('CustPass'),
       'CustDOB'=> $this->input->post('CustDOB'),          
       'CustPhone'=> $this->input->post('CustPhone'),
       'CustAddress'=> $this->input->post('CustAddress'),
       'CustBalance'=>'',
        );
        $this->load->library('upload');
        $this->load->library('form_validation');
        $foldername='CustPhoto';
        $fileuploaddire='./resource/'.$foldername;
        $directory=base_url('resource/').$foldername;
        if (!is_dir($fileuploaddire)) {
         mkdir($fileuploaddire, 0777, true);
        }
        $CustPhoto="";
        if (!empty($_FILES['CustPhoto']['name']))
        { 
            $filename =time().$_FILES['CustPhoto']['name'];
            $CustPhoto = str_replace(' ','_',$filename);
            $config['file_name'] = $CustPhoto; 
            $config['upload_path']=$fileuploaddire;
            $config['allowed_types']='pdf|doc|docx|docs|jpg|jpeg|png|';
            $config['max_length']='100000';
            $this->upload->initialize($config);
            if(!$this->upload->do_upload('CustPhoto'))
            {
                $error =$this->upload->display_errors();
                // print_r($error);
                $msg='File Can not Upload ..Please upload pdf |doc |docs|jpg|jpeg|png  type only and Maximum file size 25MB '.$error;
                $this->session->set_flashdata('CustPhoto',$msg);
                $this->form_validation->set_rules('CustPhoto',$msg,'required');
            }
            else 
            {
            }
        }
        else
        {
               //$this->form_validation->set_rules('CustPhoto','file','required');
                $this->session->set_flashdata('CustPhoto','File required');
        }
        $params['CustPhoto'] = $CustPhoto;
       $this->form_validation->set_rules('CustName','Customer Name','required');
       $this->form_validation->set_rules('CustPass','Customer Pass','required');
       $this->form_validation->set_rules('CustPhone','Customer Phone','required|numeric|exact_length[10]');
       $this->form_validation->set_rules('CustDOB','Customer DOB','required');
       $this->form_validation->set_rules('CustAddress','Customer Address','required');
        if($this->form_validation->run())  
        {  
            $idcustomers= $this->Customers_model->add_customers($params);
            $this->session->set_flashdata('alert_msg','<div class="alert alert-success text-center">Account Created Succesfully.</div>');
            redirect('login');
        }
        else
        { 
            $this->load->view('customer_register');
        }
  } catch (Exception $ex) {
    throw new Exception('Customers : Error in Register ' . $ex);
  }  
 }      
    
}  
?>  