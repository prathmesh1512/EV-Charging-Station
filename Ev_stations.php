<?php 

class Ev_stations extends CI_Controller{
 function __construct()
 {
       parent::__construct();
             if(!$this->session->userdata('authid')){
            redirect('sign-in');
        }               
      $this->load->model('Ev_stations_model');
 } 
 /*
* Listing of ev_stations
 */
public function index()
{
  try{
      $data['noof_page'] = 0;
     $data['ev_stations'] = $this->Ev_stations_model->get_all_with_asso_ev_stations();
      $data['_view'] = 'ev_stations/index';
      $this->load->view('layouts/main',$data);
    } catch (Exception $ex) {
      throw new Exception('Ev_stations Controller : Error in index function - ' . $ex);
  }  
}
 /*
  * Adding a new ev_stations
  */
 function add()
 {  
try{
      $params = array(
       'StationName'=> $this->input->post('StationName'),
       'StationIdCity'=> $this->input->post('StationIdCity'),
       'StationAddress'=> $this->input->post('StationAddress'),
       'StationLat'=> $this->input->post('StationLat'),
       'StationLong'=> $this->input->post('StationLong'),
        );
       $this->load->library('upload');
       $this->load->library('form_validation');
       $this->form_validation->set_rules('StationName','Station Name','required');
       $this->form_validation->set_rules('StationIdCity','City','required');
       $this->form_validation->set_rules('StationLat','Station Latitude','required');
       $this->form_validation->set_rules('StationLong','Station Longitude','required');
        if($this->form_validation->run())  
        {  
            $idev_stations= $this->Ev_stations_model->add_ev_stations($params);
             $this->session->set_flashdata('alert_msg','<div class="alert alert-success text-center">Succesfully added.</div>');
              redirect('ev_stations/index');
        }
        else
        { 
         $this->load->model('Cities_model');
         $data['all_cities'] = $this->Cities_model->get_all_cities(); 
           $data['_view'] = 'ev_stations/add';
            $this->load->view('layouts/main',$data);
        }
  } catch (Exception $ex) {
    throw new Exception('Ev_stations Controller : Error in add function - ' . $ex);
  }  
 }  
  /*
  * Editing a ev_stations
 */
 public function edit($idev_stations)
 {   
  try{
   $data['ev_stations'] = $this->Ev_stations_model->get_ev_stations($idev_stations);
       $this->load->library('upload');
       $this->load->library('form_validation');
     if(isset($data['ev_stations']['idev_stations']))
      {
        $params = array(
           'StationName'=> $this->input->post('StationName'),
           'StationIdCity'=> $this->input->post('StationIdCity'),
           'StationAddress'=> $this->input->post('StationAddress'),            
           'StationLat'=> $this->input->post('StationLat'),
           'StationLong'=> $this->input->post('StationLong'),
        );
        $this->form_validation->set_rules('StationName','StationName','required');
        $this->form_validation->set_rules('StationIdCity','StationIdCity','required');
        $this->form_validation->set_rules('StationLat','StationLat','required');
        $this->form_validation->set_rules('StationLong','StationLong','required');
        
        if($this->form_validation->run())  
           {  
           $this->Ev_stations_model->update_ev_stations($idev_stations,$params);
             $this->session->set_flashdata('alert_msg','<div class="alert alert-success text-center">Succesfully updated.</div>');
                redirect('ev_stations/index');
           }
           else
          {
             $this->load->model('Cities_model');
             $data['all_cities'] = $this->Cities_model->get_all_cities(); 
              $data['_view'] = 'ev_stations/edit';
              $this->load->view('layouts/main',$data);
          }
  }
  else
  show_error('The ev_stations you are trying to edit does not exist.');
  } catch (Exception $ex) {
    throw new Exception('Ev_stations Controller : Error in edit function - ' . $ex);
  }  
} 
/*
  * Deleting ev_stations
  */
  function remove($idev_stations)
   {
    try{
      $ev_stations = $this->Ev_stations_model->get_ev_stations($idev_stations);
  // check if the ev_stations exists before trying to delete it
       if(isset($ev_stations['idev_stations']))
       {
         $this->Ev_stations_model->delete_ev_stations($idev_stations);
             $this->session->set_flashdata('alert_msg','<div class="alert alert-success text-center">Succesfully Removed.</div>');
           redirect('ev_stations/index');
       }
       else
       show_error('The ev_stations you are trying to delete does not exist.');
  } catch (Exception $ex) {
    throw new Exception('Ev_stations Controller : Error in remove function - ' . $ex);
  }  
  }
  /*
  * View more a ev_stations
 */
 public function view_more($idev_stations)
 {   
try{
   $data['ev_stations'] = $this->Ev_stations_model->get_ev_stations($idev_stations);
     if(isset($data['ev_stations']['idev_stations']))
      {
              $data['_view'] = 'ev_stations/view_more';
              $this->load->view('layouts/main',$data);
      }
      else
        show_error('The ev_stations you are trying to view more does not exist.');
    } catch (Exception $ex) {
    throw new Exception('Ev_stations Controller : Error in View more function - ' . $ex);
  }  
} 
 /*
* Listing of ev_stations
 */
public function search_by_clm()
{
    $column_name= $this->input->post('column_name');
    $value_id= $this->input->post('value_id');
     $data['noof_page'] = 0;
     $params = array();
    $data['ev_stations'] = $this->Ev_stations_model->get_all_with_asso_ev_stations_by_cat($column_name,$value_id);
      $data['_view'] = 'ev_stations/index';
      $this->load->view('layouts/main',$data);
}
  /*
  * get get_search_values_byclms by id
 */
 public function get_search_values_by_StationIdCity()
 {   
     $StationIdCity= $this->input->post('value');
        $this->load->model('Cities_model');
        $data['all_cities'] = $this->Cities_model->get_all_cities(); 
      $ev_stations = $this->Ev_stations_model->get_all_with_asso_ev_stations();
if(isset($data['all_cities']) && $data['all_cities']!=null)
                                              {
                                              foreach($data['all_cities'] as $e){ 
      echo          "<option value='".$e['idcities']."'> ".$e['CityTitle']."</option>"; 
 } 
                                              }
                                              else{
                                                        echo '<tr>No data found</tr>';
                                              }
 } 
 /*
* get search values by column- ev_stations
 */
public function get_search_values_by_clm()
{
    $clm_name= $this->input->post('clm_name');
    $value= $this->input->post('value');
    $id= $this->input->post('id');
        $params = array(
        $clm_name=>$value,
        );
           $this->Ev_stations_model->update_ev_stations($id,$params);
   $data['noof_page'] = 0;
  $data['ev_stations'] = $this->Ev_stations_model->get_all_with_asso_ev_stations();
  $this->load->view('ev_stations/index',$data);
}
 }
