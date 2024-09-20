<?php 

class Vehicle_type extends CI_Controller{
 function __construct()
 {
       parent::__construct();
      $this->load->model('Vehicle_type_model');
 } 
 /*
* Listing of vehicle_type
 */
public function index()
{
  try{
      $data['noof_page'] = 0;
     $params['limit'] = RECORDS_PER_PAGE;
     $params['offset'] = ($this->input->get('per_page')) ? $this->input->get('per_page') : 0;
     $data['noof_page'] = $params['offset'];
     $config = $this->config->item('pagination');
     $config['base_url'] = site_url('vehicle_type/index?');
     $config['total_rows'] = $this->Vehicle_type_model->get_all_vehicle_type_count();
     $this->pagination->initialize($config);
     $data['vehicle_type'] = $this->Vehicle_type_model->get_all_vehicle_type($params);
      $data['_view'] = 'vehicle_type/index';
      $this->load->view('layouts/main',$data);
    } catch (Exception $ex) {
      throw new Exception('Vehicle_type Controller : Error in index function - ' . $ex);
  }  
}
 /*
  * Adding a new vehicle_type
  */
 function add()
 {  
try{
      $params = array(
       'VType_Name'=> $this->input->post('VType_Name'),
        );
       $this->load->library('upload');
       $this->load->library('form_validation');
       $this->form_validation->set_rules('VType_Name','Vehicle Type','required');
        if($this->form_validation->run())  
        {  
            $idvehicle_type= $this->Vehicle_type_model->add_vehicle_type($params);
             $this->session->set_flashdata('alert_msg','<div class="alert alert-success text-center">Succesfully added.</div>');
              redirect('vehicle_type/index');
        }
        else
        { 
           $data['_view'] = 'vehicle_type/add';
            $this->load->view('layouts/main',$data);
        }
  } catch (Exception $ex) {
    throw new Exception('Vehicle_type Controller : Error in add function - ' . $ex);
  }  
 }  
  /*
  * Editing a vehicle_type
 */
 public function edit($idvehicle_type)
 {   
  try{
   $data['vehicle_type'] = $this->Vehicle_type_model->get_vehicle_type($idvehicle_type);
       $this->load->library('upload');
       $this->load->library('form_validation');
     if(isset($data['vehicle_type']['idvehicle_type']))
      {
        $params = array(
           'VType_Name'=> $this->input->post('VType_Name'),
        );
               $this->form_validation->set_rules('VType_Name','VType_Name','required');
         if($this->form_validation->run())  
           {  
           $this->Vehicle_type_model->update_vehicle_type($idvehicle_type,$params);
             $this->session->set_flashdata('alert_msg','<div class="alert alert-success text-center">Succesfully updated.</div>');
                redirect('vehicle_type/index');
           }
           else
          {
              $data['_view'] = 'vehicle_type/edit';
              $this->load->view('layouts/main',$data);
          }
  }
  else
  show_error('The vehicle_type you are trying to edit does not exist.');
  } catch (Exception $ex) {
    throw new Exception('Vehicle_type Controller : Error in edit function - ' . $ex);
  }  
} 
/*
  * Deleting vehicle_type
  */
  function remove($idvehicle_type)
   {
    try{
      $vehicle_type = $this->Vehicle_type_model->get_vehicle_type($idvehicle_type);
  // check if the vehicle_type exists before trying to delete it
       if(isset($vehicle_type['idvehicle_type']))
       {
         $this->Vehicle_type_model->delete_vehicle_type($idvehicle_type);
             $this->session->set_flashdata('alert_msg','<div class="alert alert-success text-center">Succesfully Removed.</div>');
           redirect('vehicle_type/index');
       }
       else
       show_error('The vehicle_type you are trying to delete does not exist.');
  } catch (Exception $ex) {
    throw new Exception('Vehicle_type Controller : Error in remove function - ' . $ex);
  }  
  }
  /*
  * View more a vehicle_type
 */
 public function view_more($idvehicle_type)
 {   
try{
   $data['vehicle_type'] = $this->Vehicle_type_model->get_vehicle_type($idvehicle_type);
     if(isset($data['vehicle_type']['idvehicle_type']))
      {
              $data['_view'] = 'vehicle_type/view_more';
              $this->load->view('layouts/main',$data);
      }
      else
        show_error('The vehicle_type you are trying to view more does not exist.');
    } catch (Exception $ex) {
    throw new Exception('Vehicle_type Controller : Error in View more function - ' . $ex);
  }  
} 
 /*
* Listing of vehicle_type
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
    $config['base_url'] = site_url('vehicle_type/index?');
    $config['total_rows'] = $this->Vehicle_type_model->get_all_vehicle_type_count();
     $this->pagination->initialize($config);
     $data['vehicle_type'] = $this->Vehicle_type_model->get_all_vehicle_type_by_cat($column_name,$value_id,$params);
      $data['_view'] = 'vehicle_type/index';
      $this->load->view('layouts/main',$data);
}
 /*
* get search values by column- vehicle_type
 */
public function get_search_values_by_clm()
{
    $clm_name= $this->input->post('clm_name');
    $value= $this->input->post('value');
    $id= $this->input->post('id');
        $params = array(
        $clm_name=>$value,
        );
           $this->Vehicle_type_model->update_vehicle_type($id,$params);
   $data['noof_page'] = 0;
   $params['limit'] = RECORDS_PER_PAGE;
   $params['offset'] = ($this->input->get('per_page')) ? $this->input->get('per_page') : 0;
   $data['noof_page'] = $params['offset'];
   $config = $this->config->item('pagination');
   $config['base_url'] = site_url('vehicle_type/index?');
    $config['total_rows'] = $this->Vehicle_type_model->get_all_vehicle_type_count();
    $this->pagination->initialize($config);
  $data['vehicle_type'] = $this->Vehicle_type_model->get_all_vehicle_type($params);
  $this->load->view('vehicle_type/index',$data);
}
 }
