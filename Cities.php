<?php 

class Cities extends CI_Controller{
 function __construct()
 {
       parent::__construct();
       if(!$this->session->userdata('authid')){
            redirect('sign-in');
        }                     
      $this->load->model('Cities_model');
 } 
 /*
* Listing of cities
 */
public function index()
{
  try{
      $data['noof_page'] = 0;
     $data['cities'] = $this->Cities_model->get_all_cities();
      $data['_view'] = 'cities/index';
      $this->load->view('layouts/main',$data);
    } catch (Exception $ex) {
      throw new Exception('Cities Controller : Error in index function - ' . $ex);
  }  
}
 /*
  * Adding a new cities
  */
 function add()
 {  
try{
      $params = array(
       'CityTitle'=> $this->input->post('CityTitle'),
        );
       $this->load->library('upload');
       $this->load->library('form_validation');
       $this->form_validation->set_rules('CityTitle','City Name','required');
        if($this->form_validation->run())  
        {  
            $idcities= $this->Cities_model->add_cities($params);
             $this->session->set_flashdata('alert_msg','<div class="alert alert-success text-center">Succesfully added.</div>');
              redirect('cities/index');
        }
        else
        { 
           $data['_view'] = 'cities/add';
            $this->load->view('layouts/main',$data);
        }
  } catch (Exception $ex) {
    throw new Exception('Cities Controller : Error in add function - ' . $ex);
  }  
 }  
  /*
  * Editing a cities
 */
 public function edit($idcities)
 {   
  try{
   $data['cities'] = $this->Cities_model->get_cities($idcities);
       $this->load->library('upload');
       $this->load->library('form_validation');
     if(isset($data['cities']['idcities']))
      {
        $params = array(
           'CityTitle'=> $this->input->post('CityTitle'),
        );
               $this->form_validation->set_rules('CityTitle','CityTitle','required');
         if($this->form_validation->run())  
           {  
           $this->Cities_model->update_cities($idcities,$params);
             $this->session->set_flashdata('alert_msg','<div class="alert alert-success text-center">Succesfully updated.</div>');
                redirect('cities/index');
           }
           else
          {
              $data['_view'] = 'cities/edit';
              $this->load->view('layouts/main',$data);
          }
  }
  else
  show_error('The cities you are trying to edit does not exist.');
  } catch (Exception $ex) {
    throw new Exception('Cities Controller : Error in edit function - ' . $ex);
  }  
} 
/*
  * Deleting cities
  */
  function remove($idcities)
   {
    try{
      $cities = $this->Cities_model->get_cities($idcities);
  // check if the cities exists before trying to delete it
       if(isset($cities['idcities']))
       {
         $this->Cities_model->delete_cities($idcities);
             $this->session->set_flashdata('alert_msg','<div class="alert alert-success text-center">Succesfully Removed.</div>');
           redirect('cities/index');
       }
       else
       show_error('The cities you are trying to delete does not exist.');
  } catch (Exception $ex) {
    throw new Exception('Cities Controller : Error in remove function - ' . $ex);
  }  
  }
  /*
  * View more a cities
 */
 public function view_more($idcities)
 {   
try{
   $data['cities'] = $this->Cities_model->get_cities($idcities);
     if(isset($data['cities']['idcities']))
      {
              $data['_view'] = 'cities/view_more';
              $this->load->view('layouts/main',$data);
      }
      else
        show_error('The cities you are trying to view more does not exist.');
    } catch (Exception $ex) {
    throw new Exception('Cities Controller : Error in View more function - ' . $ex);
  }  
} 
 /*
* Listing of cities
 */
public function search_by_clm()
{
    $column_name= $this->input->post('column_name');
    $value_id= $this->input->post('value_id');
     $data['noof_page'] = 0;
     $params = array();
    $data['cities'] = $this->Cities_model->get_all_cities_by_cat($column_name,$value_id);
      $data['_view'] = 'cities/index';
      $this->load->view('layouts/main',$data);
}
 /*
* get search values by column- cities
 */
public function get_search_values_by_clm()
{
    $clm_name= $this->input->post('clm_name');
    $value= $this->input->post('value');
    $id= $this->input->post('id');
        $params = array(
        $clm_name=>$value,
        );
           $this->Cities_model->update_cities($id,$params);
   $data['noof_page'] = 0;
  $data['cities'] = $this->Cities_model->get_all_cities();
  $this->load->view('cities/index',$data);
}
 }
