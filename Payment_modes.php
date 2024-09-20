<?php 

class Payment_modes extends CI_Controller{
 function __construct()
 {
       parent::__construct();
       if(!$this->session->userdata('authid')){
            redirect('sign-in');
        }                     
      $this->load->model('Payment_modes_model');
 } 
 /*
* Listing of payment_modes
 */
public function index()
{
  try{
      $data['noof_page'] = 0;
     $data['payment_modes'] = $this->Payment_modes_model->get_all_payment_modes();
      $data['_view'] = 'payment_modes/index';
      $this->load->view('layouts/main',$data);
    } catch (Exception $ex) {
      throw new Exception('Payment_modes Controller : Error in index function - ' . $ex);
  }  
}
 /*
  * Adding a new payment_modes
  */
 function add()
 {  
try{
      $params = array(
       'PayMode_Title'=> $this->input->post('PayMode_Title'),
        );
       $this->load->library('upload');
       $this->load->library('form_validation');
       $this->form_validation->set_rules('PayMode_Title','Payment Mode Title','required');
        if($this->form_validation->run())  
        {  
            $idpayment_modes= $this->Payment_modes_model->add_payment_modes($params);
             $this->session->set_flashdata('alert_msg','<div class="alert alert-success text-center">Succesfully added.</div>');
              redirect('payment_modes/index');
        }
        else
        { 
           $data['_view'] = 'payment_modes/add';
            $this->load->view('layouts/main',$data);
        }
  } catch (Exception $ex) {
    throw new Exception('Payment_modes Controller : Error in add function - ' . $ex);
  }  
 }  
  /*
  * Editing a payment_modes
 */
 public function edit($idpayment_modes)
 {   
  try{
   $data['payment_modes'] = $this->Payment_modes_model->get_payment_modes($idpayment_modes);
       $this->load->library('upload');
       $this->load->library('form_validation');
     if(isset($data['payment_modes']['idpayment_modes']))
      {
        $params = array(
           'PayMode_Title'=> $this->input->post('PayMode_Title'),
        );
               $this->form_validation->set_rules('PayMode_Title','PayMode_Title','required');
         if($this->form_validation->run())  
           {  
           $this->Payment_modes_model->update_payment_modes($idpayment_modes,$params);
             $this->session->set_flashdata('alert_msg','<div class="alert alert-success text-center">Succesfully updated.</div>');
                redirect('payment_modes/index');
           }
           else
          {
              $data['_view'] = 'payment_modes/edit';
              $this->load->view('layouts/main',$data);
          }
  }
  else
  show_error('The payment_modes you are trying to edit does not exist.');
  } catch (Exception $ex) {
    throw new Exception('Payment_modes Controller : Error in edit function - ' . $ex);
  }  
} 
/*
  * Deleting payment_modes
  */
  function remove($idpayment_modes)
   {
    try{
      $payment_modes = $this->Payment_modes_model->get_payment_modes($idpayment_modes);
  // check if the payment_modes exists before trying to delete it
       if(isset($payment_modes['idpayment_modes']))
       {
         $this->Payment_modes_model->delete_payment_modes($idpayment_modes);
             $this->session->set_flashdata('alert_msg','<div class="alert alert-success text-center">Succesfully Removed.</div>');
           redirect('payment_modes/index');
       }
       else
       show_error('The payment_modes you are trying to delete does not exist.');
  } catch (Exception $ex) {
    throw new Exception('Payment_modes Controller : Error in remove function - ' . $ex);
  }  
  }
  /*
  * View more a payment_modes
 */
 public function view_more($idpayment_modes)
 {   
try{
   $data['payment_modes'] = $this->Payment_modes_model->get_payment_modes($idpayment_modes);
     if(isset($data['payment_modes']['idpayment_modes']))
      {
              $data['_view'] = 'payment_modes/view_more';
              $this->load->view('layouts/main',$data);
      }
      else
        show_error('The payment_modes you are trying to view more does not exist.');
    } catch (Exception $ex) {
    throw new Exception('Payment_modes Controller : Error in View more function - ' . $ex);
  }  
} 
 /*
* Listing of payment_modes
 */
public function search_by_clm()
{
    $column_name= $this->input->post('column_name');
    $value_id= $this->input->post('value_id');
     $data['noof_page'] = 0;
     $params = array();
    $data['payment_modes'] = $this->Payment_modes_model->get_all_payment_modes_by_cat($column_name,$value_id);
      $data['_view'] = 'payment_modes/index';
      $this->load->view('layouts/main',$data);
}
 /*
* get search values by column- payment_modes
 */
public function get_search_values_by_clm()
{
    $clm_name= $this->input->post('clm_name');
    $value= $this->input->post('value');
    $id= $this->input->post('id');
        $params = array(
        $clm_name=>$value,
        );
           $this->Payment_modes_model->update_payment_modes($id,$params);
   $data['noof_page'] = 0;
  $data['payment_modes'] = $this->Payment_modes_model->get_all_payment_modes();
  $this->load->view('payment_modes/index',$data);
}
 }
