<?php 

class Charging_points extends CI_Controller{
 function __construct()
 {
       parent::__construct();
       if(!$this->session->userdata('authid')){
            redirect('sign-in');
        }              
      $this->load->model('Charging_points_model');
 } 
 /*
* Listing of charging_points
 */
public function index()
{
  try{
      $data['noof_page'] = 0;
     $data['charging_points'] = $this->Charging_points_model->get_all_with_asso_charging_points();
      $data['_view'] = 'charging_points/index';
      $this->load->view('layouts/main',$data);
    } catch (Exception $ex) {
      throw new Exception('Charging_points Controller : Error in index function - ' . $ex);
  }  
}
 /*
  * Adding a new charging_points
  */
 function add()
 {  
try{
      $params = array(
       'CP_IdStations'=> $this->input->post('CP_IdStations'),
       'CP_Name'=> $this->input->post('CP_Name'),
       'CP_InUse'=>'',
        );
       $this->load->library('upload');
       $this->load->library('form_validation');
       $this->form_validation->set_rules('CP_Name','Name','required');
        if($this->form_validation->run())  
        {  
            $idcharging_points= $this->Charging_points_model->add_charging_points($params);
             $this->session->set_flashdata('alert_msg','<div class="alert alert-success text-center">Succesfully added.</div>');
            redirect($_SERVER['HTTP_REFERER']);
        }
        else
        { 
         $this->load->model('Ev_stations_model');
         $data['all_ev_stations'] = $this->Ev_stations_model->get_all_ev_stations(); 
           $data['_view'] = 'charging_points/add';
            $this->load->view('layouts/main',$data);
        }
  } catch (Exception $ex) {
    throw new Exception('Charging_points Controller : Error in add function - ' . $ex);
  }  
 }  
  /*
  * Editing a charging_points
 */
 public function edit($idcharging_points)
 {   
  try{
   $data['charging_points'] = $this->Charging_points_model->get_charging_points($idcharging_points);
       $this->load->library('upload');
       $this->load->library('form_validation');
     if(isset($data['charging_points']['idcharging_points']))
      {
        $params = array(
           'CP_IdStations'=> $this->input->post('CP_IdStations'),
           'CP_Name'=> $this->input->post('CP_Name'),
            'CP_InUse'=>'',
        );
               $this->form_validation->set_rules('CP_Name','CP_Name','required');
         if($this->form_validation->run())  
           {  
           $this->Charging_points_model->update_charging_points($idcharging_points,$params);
             $this->session->set_flashdata('alert_msg','<div class="alert alert-success text-center">Succesfully updated.</div>');
redirect($_SERVER['HTTP_REFERER']);
           }
           else
          {
             $this->load->model('Ev_stations_model');
             $data['all_ev_stations'] = $this->Ev_stations_model->get_all_ev_stations(); 
              $data['_view'] = 'charging_points/edit';
              $this->load->view('layouts/main',$data);
          }
  }
  else
  show_error('The charging_points you are trying to edit does not exist.');
  } catch (Exception $ex) {
    throw new Exception('Charging_points Controller : Error in edit function - ' . $ex);
  }  
} 
/*
  * Deleting charging_points
  */
  function remove($idcharging_points)
   {
    try{
      $charging_points = $this->Charging_points_model->get_charging_points($idcharging_points);
  // check if the charging_points exists before trying to delete it
       if(isset($charging_points['idcharging_points']))
       {
         $this->Charging_points_model->delete_charging_points($idcharging_points);
             $this->session->set_flashdata('alert_msg','<div class="alert alert-success text-center">Succesfully Removed.</div>');
           redirect($_SERVER['HTTP_REFERER']);
       }
       else
       show_error('The charging_points you are trying to delete does not exist.');
  } catch (Exception $ex) {
    throw new Exception('Charging_points Controller : Error in remove function - ' . $ex);
  }  
  }
  /*
  * View more a charging_points
 */
 public function view_more($idcharging_points)
 {   
try{
   $data['charging_points'] = $this->Charging_points_model->get_charging_points($idcharging_points);
     if(isset($data['charging_points']['idcharging_points']))
      {
              $data['_view'] = 'charging_points/view_more';
              $this->load->view('layouts/main',$data);
      }
      else
        show_error('The charging_points you are trying to view more does not exist.');
    } catch (Exception $ex) {
    throw new Exception('Charging_points Controller : Error in View more function - ' . $ex);
  }  
} 
 /*
* Listing of charging_points
 */
public function search_by_clm()
{
    $column_name= $this->input->post('column_name');
    $value_id= $this->input->post('value_id');
     $data['noof_page'] = 0;
     $params = array();
    $data['charging_points'] = $this->Charging_points_model->get_all_with_asso_charging_points_by_cat($column_name,$value_id);
      $data['_view'] = 'charging_points/index';
      $this->load->view('layouts/main',$data);
}
  /*
  * get get_search_values_byclms by id
 */
 public function get_search_values_by_CP_IdStations()
 {   
     $CP_IdStations= $this->input->post('value');
        $this->load->model('Ev_stations_model');
        $data['all_ev_stations'] = $this->Ev_stations_model->get_all_ev_stations(); 
      $charging_points = $this->Charging_points_model->get_all_with_asso_charging_points();
if(isset($data['all_ev_stations']) && $data['all_ev_stations']!=null)
                                              {
                                              foreach($data['all_ev_stations'] as $c){ 
      echo          "<option value='".$c['idev_stations']."'> ".$c['StationName']."</option>"; 
 } 
                                              }
                                              else{
                                                        echo '<tr>No data found</tr>';
                                              }
 } 
 /*
* get search values by column- charging_points
 */
public function get_search_values_by_clm()
{
    $clm_name= $this->input->post('clm_name');
    $value= $this->input->post('value');
    $id= $this->input->post('id');
        $params = array(
        $clm_name=>$value,
        );
           $this->Charging_points_model->update_charging_points($id,$params);
   $data['noof_page'] = 0;
  $data['charging_points'] = $this->Charging_points_model->get_all_with_asso_charging_points();
  $this->load->view('charging_points/index',$data);
}
 }
