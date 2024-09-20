<?php 

class Rate_chart extends CI_Controller{
 function __construct()
 {
       parent::__construct();
       if(!$this->session->userdata('authid')){
            redirect('sign-in');
        }                     
      $this->load->model('Rate_chart_model');
 } 
 /*
* Listing of rate_chart
 */
public function index()
{
  try{
      $data['noof_page'] = 0;
     $data['rate_chart'] = $this->Rate_chart_model->get_all_rate_chart();
      $data['_view'] = 'rate_chart/index';
      $this->load->view('layouts/main',$data);
    } catch (Exception $ex) {
      throw new Exception('Rate_chart Controller : Error in index function - ' . $ex);
  }  
}
 /*
  * Adding a new rate_chart
  */
 function add()
 {  
try{
      $params = array(
       'rc_name'=> $this->input->post('rc_name'),
       'rc_hours'=> $this->input->post('rc_hours'),
       'rc_amount'=> $this->input->post('rc_amount'),
        );
       $this->load->library('upload');
       $this->load->library('form_validation');
       $this->form_validation->set_rules('rc_name','Name','required');
       $this->form_validation->set_rules('rc_hours','Hours','required');
       $this->form_validation->set_rules('rc_amount','Amount','required');
        if($this->form_validation->run())  
        {  
            $idrate_chart= $this->Rate_chart_model->add_rate_chart($params);
             $this->session->set_flashdata('alert_msg','<div class="alert alert-success text-center">Succesfully added.</div>');
              redirect('rate_chart/index');
        }
        else
        { 
           $data['_view'] = 'rate_chart/add';
            $this->load->view('layouts/main',$data);
        }
  } catch (Exception $ex) {
    throw new Exception('Rate_chart Controller : Error in add function - ' . $ex);
  }  
 }  
  /*
  * Editing a rate_chart
 */
 public function edit($idrate_chart)
 {   
  try{
   $data['rate_chart'] = $this->Rate_chart_model->get_rate_chart($idrate_chart);
       $this->load->library('upload');
       $this->load->library('form_validation');
     if(isset($data['rate_chart']['idrate_chart']))
      {
        $params = array(
           'rc_name'=> $this->input->post('rc_name'),
           'rc_hours'=> $this->input->post('rc_hours'),
           'rc_amount'=> $this->input->post('rc_amount'),
        );
               $this->form_validation->set_rules('rc_name','rc_name','required');
               $this->form_validation->set_rules('rc_hours','rc_hours','required');
               $this->form_validation->set_rules('rc_amount','rc_amount','required');
         if($this->form_validation->run())  
           {  
           $this->Rate_chart_model->update_rate_chart($idrate_chart,$params);
             $this->session->set_flashdata('alert_msg','<div class="alert alert-success text-center">Succesfully updated.</div>');
                redirect('rate_chart/index');
           }
           else
          {
              $data['_view'] = 'rate_chart/edit';
              $this->load->view('layouts/main',$data);
          }
  }
  else
  show_error('The rate_chart you are trying to edit does not exist.');
  } catch (Exception $ex) {
    throw new Exception('Rate_chart Controller : Error in edit function - ' . $ex);
  }  
} 
/*
  * Deleting rate_chart
  */
  function remove($idrate_chart)
   {
    try{
      $rate_chart = $this->Rate_chart_model->get_rate_chart($idrate_chart);
  // check if the rate_chart exists before trying to delete it
       if(isset($rate_chart['idrate_chart']))
       {
         $this->Rate_chart_model->delete_rate_chart($idrate_chart);
             $this->session->set_flashdata('alert_msg','<div class="alert alert-success text-center">Succesfully Removed.</div>');
           redirect('rate_chart/index');
       }
       else
       show_error('The rate_chart you are trying to delete does not exist.');
  } catch (Exception $ex) {
    throw new Exception('Rate_chart Controller : Error in remove function - ' . $ex);
  }  
  }
  /*
  * View more a rate_chart
 */
 public function view_more($idrate_chart)
 {   
try{
   $data['rate_chart'] = $this->Rate_chart_model->get_rate_chart($idrate_chart);
     if(isset($data['rate_chart']['idrate_chart']))
      {
              $data['_view'] = 'rate_chart/view_more';
              $this->load->view('layouts/main',$data);
      }
      else
        show_error('The rate_chart you are trying to view more does not exist.');
    } catch (Exception $ex) {
    throw new Exception('Rate_chart Controller : Error in View more function - ' . $ex);
  }  
} 
 /*
* Listing of rate_chart
 */
public function search_by_clm()
{
    $column_name= $this->input->post('column_name');
    $value_id= $this->input->post('value_id');
     $data['noof_page'] = 0;
     $params = array();
    $data['rate_chart'] = $this->Rate_chart_model->get_all_rate_chart_by_cat($column_name,$value_id);
      $data['_view'] = 'rate_chart/index';
      $this->load->view('layouts/main',$data);
}
 /*
* get search values by column- rate_chart
 */
public function get_search_values_by_clm()
{
    $clm_name= $this->input->post('clm_name');
    $value= $this->input->post('value');
    $id= $this->input->post('id');
        $params = array(
        $clm_name=>$value,
        );
           $this->Rate_chart_model->update_rate_chart($id,$params);
   $data['noof_page'] = 0;
  $data['rate_chart'] = $this->Rate_chart_model->get_all_rate_chart();
  $this->load->view('rate_chart/index',$data);
}
 }
