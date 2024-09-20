<?php 

class Recharge_trnxs extends CI_Controller{
 function __construct()
 {
       parent::__construct();
       if(!$this->session->userdata('authid')){
            redirect('sign-in');
        }                     
      $this->load->model('Recharge_trnxs_model');
 } 
 /*
* Listing of recharge_trnxs
 */
public function index()
{
  try{
        $data['noof_page'] = 0;
        $params = array(
          'crt_idcustomer' => $this->input->get('crt_idcustomer'),
          'from_date' => $this->input->get('from_date'),
          'to_date' => $this->input->get('to_date'),
          'crt_idevstation' => $this->input->get('crt_idevstation'),
          'crt_paymode' => $this->input->get('crt_paymode'),
        );
        $data['recharge_trnxs'] = $this->Recharge_trnxs_model->get_all_with_asso_recharge_trnxs($params);
     
        $this->load->model('Customers_model');
        $data['all_customers'] = $this->Customers_model->get_all_customers(); 
        
        $this->load->model('Payment_modes_model');
        $data['all_payment_modes'] = $this->Payment_modes_model->get_all_payment_modes(); 
        
        $this->load->model('Ev_stations_model');
        $data['all_ev_stations'] = $this->Ev_stations_model->get_all_ev_stations();        

        $data['_view'] = 'recharge_trnxs/index';
      $this->load->view('layouts/main',$data);
    } catch (Exception $ex) {
      throw new Exception('Recharge_trnxs Controller : Error in index function - ' . $ex);
  }  
}
 /*
  * Adding a new recharge_trnxs
  */
 function add()
 {  
try{
       $this->load->library('upload');
       $this->load->library('form_validation');
       $this->form_validation->set_rules('crt_idcustomer','Customer','required');
       $this->form_validation->set_rules('crt_amount','Amount','required');
       $this->form_validation->set_rules('crt_paymode','Paymode','required');
        if($this->form_validation->run())  
        {  
          $params = array(
           'crt_idcustomer'=> $this->input->post('crt_idcustomer'),
           'crt_amount'=> $this->input->post('crt_amount'),
           'crt_paymode'=> $this->input->post('crt_paymode'),
           'crt_idevstation'=> $this->session->userdata('auth_idev'),
            'crt_date'=>DATE,
            'crt_time'=>date('H:i:s'),
            );
            $idrecharge_trnxs= $this->Recharge_trnxs_model->add_recharge_trnxs($params);
            
            $this->db->set('CustBalance', 'CustBalance + '.$this->input->post('crt_amount'), FALSE);
            $this->db->where('idcustomers', $this->input->post('crt_idcustomer'));
            $this->db->update('customers');
            
              $this->session->set_flashdata('alert_msg','<div class="alert alert-success text-center">Succesfully added.</div>');
              redirect('recharge_trnxs/index');
        }
        else
        { 
         $this->load->model('Customers_model');
         $data['all_customers'] = $this->Customers_model->get_all_customers(); 
         $this->load->model('Payment_modes_model');
         $data['all_payment_modes'] = $this->Payment_modes_model->get_all_payment_modes(); 
           $data['_view'] = 'recharge_trnxs/add';
            $this->load->view('layouts/main',$data);
        }
  } catch (Exception $ex) {
    throw new Exception('Recharge_trnxs Controller : Error in add function - ' . $ex);
  }  
 }  
  /*
  * Editing a recharge_trnxs
 */
 public function edit($idrecharge_trnxs)
 {   
  try{
   $data['recharge_trnxs'] = $this->Recharge_trnxs_model->get_recharge_trnxs($idrecharge_trnxs);
       $this->load->library('upload');
       $this->load->library('form_validation');
     if(isset($data['recharge_trnxs']['idrecharge_trnxs']))
      {
        $params = array(
           'crt_idcustomer'=> $this->input->post('crt_idcustomer'),
           'crt_amount'=> $this->input->post('crt_amount'),
           'crt_paymode'=> $this->input->post('crt_paymode'),
       'crt_date'=>DATE,
            'crt_time'=>'',
        );
               $this->form_validation->set_rules('crt_idcustomer','crt_idcustomer','required');
               $this->form_validation->set_rules('crt_amount','crt_amount','required');
               $this->form_validation->set_rules('crt_paymode','crt_paymode','required');
         if($this->form_validation->run())  
           {  
           $this->Recharge_trnxs_model->update_recharge_trnxs($idrecharge_trnxs,$params);
             $this->session->set_flashdata('alert_msg','<div class="alert alert-success text-center">Succesfully updated.</div>');
                redirect('recharge_trnxs/index');
           }
           else
          {
             $this->load->model('Customers_model');
             $data['all_customers'] = $this->Customers_model->get_all_customers(); 
             $this->load->model('Payment_modes_model');
             $data['all_payment_modes'] = $this->Payment_modes_model->get_all_payment_modes(); 
              $data['_view'] = 'recharge_trnxs/edit';
              $this->load->view('layouts/main',$data);
          }
  }
  else
  show_error('The recharge_trnxs you are trying to edit does not exist.');
  } catch (Exception $ex) {
    throw new Exception('Recharge_trnxs Controller : Error in edit function - ' . $ex);
  }  
} 
/*
  * Deleting recharge_trnxs
  */
  function remove($idrecharge_trnxs)
   {
    try{
      $recharge_trnxs = $this->Recharge_trnxs_model->get_recharge_trnxs($idrecharge_trnxs);
  // check if the recharge_trnxs exists before trying to delete it
       if(isset($recharge_trnxs['idrecharge_trnxs']))
       {
         $this->Recharge_trnxs_model->delete_recharge_trnxs($idrecharge_trnxs);
             $this->session->set_flashdata('alert_msg','<div class="alert alert-success text-center">Succesfully Removed.</div>');
           redirect('recharge_trnxs/index');
       }
       else
       show_error('The recharge_trnxs you are trying to delete does not exist.');
  } catch (Exception $ex) {
    throw new Exception('Recharge_trnxs Controller : Error in remove function - ' . $ex);
  }  
  }
  /*
  * View more a recharge_trnxs
 */
 public function view_more($idrecharge_trnxs)
 {   
try{
   $data['recharge_trnxs'] = $this->Recharge_trnxs_model->get_recharge_trnxs($idrecharge_trnxs);
     if(isset($data['recharge_trnxs']['idrecharge_trnxs']))
      {
              $data['_view'] = 'recharge_trnxs/view_more';
              $this->load->view('layouts/main',$data);
      }
      else
        show_error('The recharge_trnxs you are trying to view more does not exist.');
    } catch (Exception $ex) {
    throw new Exception('Recharge_trnxs Controller : Error in View more function - ' . $ex);
  }  
} 
 /*
* Listing of recharge_trnxs
 */
public function search_by_clm()
{
    $column_name= $this->input->post('column_name');
    $value_id= $this->input->post('value_id');
     $data['noof_page'] = 0;
     $params = array();
    $data['recharge_trnxs'] = $this->Recharge_trnxs_model->get_all_with_asso_recharge_trnxs_by_cat($column_name,$value_id);
      $data['_view'] = 'recharge_trnxs/index';
      $this->load->view('layouts/main',$data);
}
  /*
  * get get_search_values_byclms by id
 */
 public function get_search_values_by_crt_idcustomer()
 {   
     $crt_idcustomer= $this->input->post('value');
        $this->load->model('Customers_model');
        $data['all_customers'] = $this->Customers_model->get_all_customers(); 
      $recharge_trnxs = $this->Recharge_trnxs_model->get_all_with_asso_recharge_trnxs();
if(isset($data['all_customers']) && $data['all_customers']!=null)
                                              {
                                              foreach($data['all_customers'] as $r){ 
      echo          "<option value='".$r['idcustomers']."'> ".$r['CustName']."</option>"; 
 } 
                                              }
                                              else{
                                                        echo '<tr>No data found</tr>';
                                              }
 } 
  /*
  * get get_search_values_byclms by id
 */
 public function get_search_values_by_crt_paymode()
 {   
     $crt_paymode= $this->input->post('value');
        $this->load->model('Payment_modes_model');
        $data['all_payment_modes'] = $this->Payment_modes_model->get_all_payment_modes(); 
      $recharge_trnxs = $this->Recharge_trnxs_model->get_all_with_asso_recharge_trnxs();
if(isset($data['all_payment_modes']) && $data['all_payment_modes']!=null)
                                              {
                                              foreach($data['all_payment_modes'] as $r){ 
      echo          "<option value='".$r['idpayment_modes']."'> ".$r['PayMode_Title']."</option>"; 
 } 
                                              }
                                              else{
                                                        echo '<tr>No data found</tr>';
                                              }
 } 
 /*
* get search values by column- recharge_trnxs
 */
public function get_search_values_by_clm()
{
    $clm_name= $this->input->post('clm_name');
    $value= $this->input->post('value');
    $id= $this->input->post('id');
        $params = array(
        $clm_name=>$value,
        );
           $this->Recharge_trnxs_model->update_recharge_trnxs($id,$params);
   $data['noof_page'] = 0;
  $data['recharge_trnxs'] = $this->Recharge_trnxs_model->get_all_with_asso_recharge_trnxs();
  $this->load->view('recharge_trnxs/index',$data);
}
 }
