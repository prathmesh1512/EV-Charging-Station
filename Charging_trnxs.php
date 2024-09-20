<?php 

class Charging_trnxs extends CI_Controller{
 function __construct()
 {
       parent::__construct();
              if(!$this->session->userdata('authid')){
            redirect('sign-in');
        }              
      $this->load->model('Charging_trnxs_model');
 } 
 /*
* Listing of charging_trnxs
 */
public function index()
{
  try{
    $data['noof_page'] = 0;

    $params = array(
      'ct_IdCustomers' => ($this->input->get('ct_IdCustomers'))?$this->input->get('ct_IdCustomers'):0,
      'ct_VType' => ($this->input->get('ct_VType'))?$this->input->get('ct_VType'):0,
      'from_date' => ($this->input->get('from_date'))?$this->input->get('from_date'):date('Y-m-d', strtotime('-30days')),
      'to_date' => ($this->input->get('to_date'))?$this->input->get('to_date'):date('Y-m-d'),
      'ct_idevstation' => ($this->input->get('ct_idevstation'))?$this->input->get('ct_idevstation'):0,
      'ct_paymode' => ($this->input->get('ct_paymode'))?$this->input->get('ct_paymode'):0,
    );
    
     $params['limit'] = RECORDS_PER_PAGE;
     $params['offset'] = ($this->input->get('per_page')) ? $this->input->get('per_page') : 0;

     $data['noof_page'] = $params['offset'];
     $config = $this->config->item('pagination');
     $config['base_url'] = site_url('charging_trnxs/index?');
     $config['total_rows'] = $this->Charging_trnxs_model->get_all_charging_trnxs_count();
     $this->pagination->initialize($config);
     
    $data['charging_trnxs'] = $this->Charging_trnxs_model->get_all_with_asso_charging_trnxs($params);
     
    $this->load->model('Customers_model');
    $data['all_customers'] = $this->Customers_model->get_all_customers(); 

    $this->load->model('Payment_modes_model');
    $data['all_payment_modes'] = $this->Payment_modes_model->get_all_payment_modes(); 

    $this->load->model('Ev_stations_model');
    $data['all_ev_stations'] = $this->Ev_stations_model->get_all_ev_stations();             

    $this->load->model('Vehicle_type_model');
    $data['all_vehicle_type'] = $this->Vehicle_type_model->get_all_vehicle_type();     
     
     $data['_view'] = 'charging_trnxs/index';
      $this->load->view('layouts/main',$data);
    } catch (Exception $ex) {
      throw new Exception('Charging_trnxs Controller : Error in index function - ' . $ex);
  }  
}
 /*
  * Adding a new charging_trnxs
  */
 function add()
 {  
try{
    
       $this->load->library('upload');
       $this->load->library('form_validation');
       $this->form_validation->set_rules('ct_IdCustomers','Customers','required');
       $this->form_validation->set_rules('ct_VType','Vehicle Type','required');       
       $this->form_validation->set_rules('ct_date','Date','required');
       $this->form_validation->set_rules('ct_hours','Hours','required');
       $this->form_validation->set_rules('ct_paymode','Paymode','required');
        if($this->form_validation->run())  
        {  

        $this->load->model('Rate_chart_model');
        $data['rate_chart'] = $this->Rate_chart_model->get_rate_chart_by_hours($this->input->post('ct_hours')); 

        
            $this->load->model('Customers_model');
            $customers = $this->Customers_model->get_customers($this->input->post('ct_IdCustomers'));        
        
          $params = array(
           'ct_IdCustomers'=> $this->input->post('ct_IdCustomers'),
           'ct_VType'=> $this->input->post('ct_VType'),              
           'ct_date'=> $this->input->post('ct_date'),
           'ct_idrate'=> $data['rate_chart']['idrate_chart'],
           'ct_hours'=> $this->input->post('ct_hours'),
           'ct_amount'=>$data['rate_chart']['rc_amount'],
           'ct_id_evstation'=> $this->session->userdata('auth_idev'),
           'ct_paymode'=> $this->input->post('ct_paymode'),
            );

          if($this->input->post('ct_paymode') == 1){
              if($customers['CustBalance'] > $data['rate_chart']['rc_amount']){
                $idcharging_trnxs= $this->Charging_trnxs_model->add_charging_trnxs($params);
                
                $this->db->set('CustBalance', 'CustBalance - '.$data['rate_chart']['rc_amount'], FALSE);
                $this->db->where('idcustomers', $this->input->post('ct_IdCustomers'));
                $this->db->update('customers');                
                redirect('charging_trnxs');
              }else{
                 $this->session->set_flashdata('alert_msg','<div class="alert alert-success text-center">Not Enough Balance. Available Balance : Rs.'.$customers['CustBalance'].'</div>');
                 redirect('charging_trnxs/add');
              }
          }else{
                $idcharging_trnxs= $this->Charging_trnxs_model->add_charging_trnxs($params);
                $this->session->set_flashdata('alert_msg','<div class="alert alert-success text-center">Balance Not Available.</div>');
                redirect('charging_trnxs/index');
          }
        }
        else
        { 
         $this->load->model('Customers_model');
         $data['all_customers'] = $this->Customers_model->get_all_customers(); 
         $this->load->model('Rate_chart_model');
         $data['all_rate_chart'] = $this->Rate_chart_model->get_all_rate_chart(); 
         $this->load->model('Payment_modes_model');
         $data['all_payment_modes'] = $this->Payment_modes_model->get_all_payment_modes(); 
           $data['_view'] = 'charging_trnxs/add';
            $this->load->view('layouts/main',$data);
        }
  } catch (Exception $ex) {
    throw new Exception('Charging_trnxs Controller : Error in add function - ' . $ex);
  }  
 }  
  /*
  * Editing a charging_trnxs
 */
 public function edit($idcharging_trnxs)
 {   
  try{
   $data['charging_trnxs'] = $this->Charging_trnxs_model->get_charging_trnxs($idcharging_trnxs);
       $this->load->library('upload');
       $this->load->library('form_validation');
     if(isset($data['charging_trnxs']['idcharging_trnxs']))
      {
        $params = array(
           'ct_IdCustomers'=> $this->input->post('ct_IdCustomers'),
           'ct_date'=> $this->input->post('ct_date'),
           'ct_idrate'=> $this->input->post('ct_idrate'),
           'ct_hours'=> $this->input->post('ct_hours'),
            'ct_amount'=>'',
           'ct_paymode'=> $this->input->post('ct_paymode'),
        );
               $this->form_validation->set_rules('ct_IdCustomers','ct_IdCustomers','required');
               $this->form_validation->set_rules('ct_date','ct_date','required');
               $this->form_validation->set_rules('ct_idrate','ct_idrate','required');
               $this->form_validation->set_rules('ct_hours','ct_hours','required');
               $this->form_validation->set_rules('ct_paymode','ct_paymode','required');
         if($this->form_validation->run())  
           {  
           $this->Charging_trnxs_model->update_charging_trnxs($idcharging_trnxs,$params);
             $this->session->set_flashdata('alert_msg','<div class="alert alert-success text-center">Succesfully updated.</div>');
                redirect('charging_trnxs/index');
           }
           else
          {
             $this->load->model('Customers_model');
             $data['all_customers'] = $this->Customers_model->get_all_customers(); 
             $this->load->model('Rate_chart_model');
             $data['all_rate_chart'] = $this->Rate_chart_model->get_all_rate_chart(); 
             $this->load->model('Payment_modes_model');
             $data['all_payment_modes'] = $this->Payment_modes_model->get_all_payment_modes(); 
              $data['_view'] = 'charging_trnxs/edit';
              $this->load->view('layouts/main',$data);
          }
  }
  else
  show_error('The charging_trnxs you are trying to edit does not exist.');
  } catch (Exception $ex) {
    throw new Exception('Charging_trnxs Controller : Error in edit function - ' . $ex);
  }  
} 
/*
  * Deleting charging_trnxs
  */
  function remove($idcharging_trnxs)
   {
    try{
      $charging_trnxs = $this->Charging_trnxs_model->get_charging_trnxs($idcharging_trnxs);
  // check if the charging_trnxs exists before trying to delete it
       if(isset($charging_trnxs['idcharging_trnxs']))
       {
         $this->Charging_trnxs_model->delete_charging_trnxs($idcharging_trnxs);
             $this->session->set_flashdata('alert_msg','<div class="alert alert-success text-center">Succesfully Removed.</div>');
           redirect('charging_trnxs/index');
       }
       else
       show_error('The charging_trnxs you are trying to delete does not exist.');
  } catch (Exception $ex) {
    throw new Exception('Charging_trnxs Controller : Error in remove function - ' . $ex);
  }  
  }
  /*
  * View more a charging_trnxs
 */
 public function view_more($idcharging_trnxs)
 {   
try{
   $data['charging_trnxs'] = $this->Charging_trnxs_model->get_charging_trnxs($idcharging_trnxs);
     if(isset($data['charging_trnxs']['idcharging_trnxs']))
      {
              $data['_view'] = 'charging_trnxs/view_more';
              $this->load->view('layouts/main',$data);
      }
      else
        show_error('The charging_trnxs you are trying to view more does not exist.');
    } catch (Exception $ex) {
    throw new Exception('Charging_trnxs Controller : Error in View more function - ' . $ex);
  }  
} 
 /*
* Listing of charging_trnxs
 */
public function search_by_clm()
{
    $column_name= $this->input->post('column_name');
    $value_id= $this->input->post('value_id');
     $data['noof_page'] = 0;
     $params = array();
    $params['limit'] = RECORDS_PER_PAGE;
    $params['offset'] = ($this->input->get('per_page')) ? $this->input->get('per_page') : 0;
    $data['noof_page'] = $params['offset'];
    $config = $this->config->item('pagination');
    $config['base_url'] = site_url('charging_trnxs/index?');
    $config['total_rows'] = $this->Charging_trnxs_model->get_all_charging_trnxs_count();
     $this->pagination->initialize($config);
     $data['charging_trnxs'] = $this->Charging_trnxs_model->get_all_charging_trnxs_by_cat($column_name,$value_id,$params);
      $data['_view'] = 'charging_trnxs/index';
      $this->load->view('layouts/main',$data);
}
  /*
  * get get_search_values_byclms by id
 */
 public function get_search_values_by_ct_IdCustomers()
 {   
     $ct_IdCustomers= $this->input->post('value');
        $this->load->model('Customers_model');
        $data['all_customers'] = $this->Customers_model->get_all_customers(); 
      $charging_trnxs = $this->Charging_trnxs_model->get_all_with_asso_charging_trnxs();
if(isset($data['all_customers']) && $data['all_customers']!=null)
                                              {
                                              foreach($data['all_customers'] as $c){ 
      echo          "<option value='".$c['idcustomers']."'> ".$c['CustName']."</option>"; 
 } 
                                              }
                                              else{
                                                        echo '<tr>No data found</tr>';
                                              }
 } 
  /*
  * get get_search_values_byclms by id
 */
 public function get_search_values_by_ct_idrate()
 {   
     $ct_idrate= $this->input->post('value');
        $this->load->model('Rate_chart_model');
        $data['all_rate_chart'] = $this->Rate_chart_model->get_all_rate_chart(); 
      $charging_trnxs = $this->Charging_trnxs_model->get_all_with_asso_charging_trnxs();
if(isset($data['all_rate_chart']) && $data['all_rate_chart']!=null)
                                              {
                                              foreach($data['all_rate_chart'] as $c){ 
      echo          "<option value='".$c['idrate_chart']."'> ".$c['rc_hours']."</option>"; 
 } 
                                              }
                                              else{
                                                        echo '<tr>No data found</tr>';
                                              }
 } 
  /*
  * get get_search_values_byclms by id
 */
 public function get_search_values_by_ct_paymode()
 {   
     $ct_paymode= $this->input->post('value');
        $this->load->model('Payment_modes_model');
        $data['all_payment_modes'] = $this->Payment_modes_model->get_all_payment_modes(); 
      $charging_trnxs = $this->Charging_trnxs_model->get_all_with_asso_charging_trnxs();
if(isset($data['all_payment_modes']) && $data['all_payment_modes']!=null)
                                              {
                                              foreach($data['all_payment_modes'] as $c){ 
      echo          "<option value='".$c['idpayment_modes']."'> ".$c['PayMode_Title']."</option>"; 
 } 
                                              }
                                              else{
                                                        echo '<tr>No data found</tr>';
                                              }
 } 
 /*
* get search values by column- charging_trnxs
 */
public function get_search_values_by_clm()
{
    $clm_name= $this->input->post('clm_name');
    $value= $this->input->post('value');
    $id= $this->input->post('id');
        $params = array(
        $clm_name=>$value,
        );
           $this->Charging_trnxs_model->update_charging_trnxs($id,$params);
   $data['noof_page'] = 0;
   $params['limit'] = RECORDS_PER_PAGE;
   $params['offset'] = ($this->input->get('per_page')) ? $this->input->get('per_page') : 0;
   $data['noof_page'] = $params['offset'];
   $config = $this->config->item('pagination');
   $config['base_url'] = site_url('charging_trnxs/index?');
    $config['total_rows'] = $this->Charging_trnxs_model->get_all_charging_trnxs_count();
    $this->pagination->initialize($config);
  $data['charging_trnxs'] = $this->Charging_trnxs_model->get_all_charging_trnxs($params);
  $this->load->view('charging_trnxs/index',$data);
}
 }
