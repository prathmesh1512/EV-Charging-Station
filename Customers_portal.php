<?php 

class Customers_portal extends CI_Controller{
 function __construct()
 {
       parent::__construct();
//        if(!$this->session->userdata('uid')){
//            redirect('sign-in');
//        }              
      $this->load->model('Customers_model');
 } 
 /*
* Listing of customers
 */
public function index()
{
        $this->load->library('form_validation');
        $this->form_validation->set_rules('password','Password','required');
        $this->form_validation->set_rules('username','username','required'); 
        if($this->form_validation->run())     
        { 
            $this->load->model('Customers_model');
            $customers = $this->Customers_model->get_customersbyclm_name('CustPhone',$this->input->post('username'));
        		$username=$this->input->post('username');
        		$password=$this->input->post('password');
                        if($username == $customers['CustPhone'] && $password == $customers['CustPass'])
        		{ 
                            $user_data = array(
                                'uid' => $customers['idcustomers'],
                                'uname' => $customers['CustName']
                            );
                            $this->session->set_userdata($user_data);  
                            redirect('Customers_portal/dashboard');
                        }
        		else
        		{
                            $this->session->set_flashdata('alert_msg', '<div class="alert alert-danger text-center">Login Failed!! Invalid Username or password. Please try again.</div>');
                            redirect('login');
        		}
		}
        else
        { 
 			$data['logintype'] = 'admin';
			$this->load->view('login_view',$data);
        }
		 
}

public function forgot_password()
{
        $this->load->library('form_validation');
        $this->form_validation->set_rules('dob','DOB','required');
        $this->form_validation->set_rules('password','Password','required');
        $this->form_validation->set_rules('username','username','required'); 
        if($this->form_validation->run())     
        { 
            $this->load->model('Customers_model');
            $customers = $this->Customers_model->get_customersbyclm_name('CustPhone',$this->input->post('username'));
        		$username=$this->input->post('username');
        		$password=$this->input->post('password');
        		$dob=$this->input->post('dob');
                        if($username == $customers['CustPhone'] && $dob == $customers['CustDOB'])
        		{ 
                            $params = array(
                               'CustPass'=> $password,
                            );
                            $this->Customers_model->update_customers($customers['idcustomers'],$params);
                            $this->session->set_flashdata('alert_msg','<div class="alert alert-success text-center">Succesfully updated.</div>');                            
                            redirect('Customers_portal');
                        }
        		else
        		{
                            $this->session->set_flashdata('alertDmessage','Try Again'); 
                            redirect('login');
        		}
		}
        else
        { 
 			$data['logintype'] = 'admin';
			$this->load->view('customers_portal/forgot_password',$data);
        }
		 
}




 /*
  * Adding a new customers
  */
 function dashboard()
 {
        $this->load->model('Customers_model');
        $data['customer'] = $this->Customers_model->get_customers($this->session->userdata('uid'));

        $this->load->model('Charging_trnxs_model');
        $data['charging_trnxs'] = $this->Charging_trnxs_model->get_customer_with_asso_charging_trnxs($this->session->userdata('uid'));        

        $this->load->model('Recharge_trnxs_model');
        $data['recharge_trnxs'] = $this->Recharge_trnxs_model->get_customer_with_asso_recharge_trnxs($this->session->userdata('uid'));

        $params['idcity'] = 0;
        if($this->input->get('idcity')){
            $params['idcity'] = $this->input->get('idcity');
        }
        $this->load->model('Ev_stations_model');
        $data['ev_stations'] = $this->Ev_stations_model->get_all_with_asso_ev_stations($params);
     
        $this->load->model('Cities_model');
        $data['all_cities'] = $this->Cities_model->get_all_cities(); 
         
        $this->load->view('customers_portal/dashboard',$data);       
  }


function recharge()
 {  
try{
      $data = array(
          'recharge_amount' => $this->input->post('recharge_amount')
        );
       $this->load->library('form_validation');
       $this->form_validation->set_rules('recharge_amount','Amount','required');
        if($this->form_validation->run())  
        {  
            $this->load->view('customers_portal/payment_process',$data);
        }
        else
        { 
            redirect('customers_portal/dashboard');
        }
  } catch (Exception $ex) {
    throw new Exception('Customers Controller : Error in add function - ' . $ex);
  }  
 }  
  /*
  * Editing a customers
 */
 public function payment_process()
 {   
  try{
       $this->load->library('upload');
       $this->load->library('form_validation');
       $this->form_validation->set_rules('recharge_amount','Recharge Aamount','required');
         if($this->form_validation->run())  
           {  

          $params = array(
            'crt_idcustomer'=> $this->session->userdata('uid'),
            'crt_amount'=> $this->input->post('recharge_amount'),
            'crt_paymode'=> 2,
            'crt_idevstation'=> 0,
            'crt_date'=>DATE,
            'crt_time'=>date('H:i:s'),
            );
            $this->load->model('Recharge_trnxs_model');
            $idrecharge_trnxs = $this->Recharge_trnxs_model->add_recharge_trnxs($params);             
             
            $this->db->set('CustBalance', 'CustBalance + '.$this->input->post('recharge_amount'), FALSE);
            $this->db->where('idcustomers', $this->session->userdata('uid'));
            $this->db->update('customers');
            
            $this->session->set_flashdata('alert_msg','<div class="alert alert-success text-center">Balance Added Succesfully.</div>');
            redirect('customers_portal/dashboard');
           }
           else
          {
              $this->load->view('customers_portal/payment_process');
          }
  } catch (Exception $ex) {
    throw new Exception('Customers Controller : Error in edit function - ' . $ex);
  }  
} 


    public function logout()  
    {  
        //removing session  
        $this->session->sess_destroy();
        redirect("login");  
    }  

 }
