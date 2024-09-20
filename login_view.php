<html>
    <head>
    <title><?php echo PROJECT_NAME; ?> :: Login</title>
        <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    

        
        <style>
            body{
                background-color: #8bc34a;
            }
.divider:after,
.divider:before {
content: "";
flex: 1;
height: 1px;
background: #eee;
}
.h-custom {
height: calc(100% - 73px);
}
@media (max-width: 450px) {
.h-custom {
height: 100%;
}
}            
        </style>
        
        
        
        
        
   <section class="vh-100">
    <?php echo $this->session->flashdata('alert_msg');?>       
  <div class="container-fluid h-custom">
    <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1" style="background-color: #eee;">
        <form id="login-form" class="form" action="<?php echo site_url('sign-in');?>" method="post">
          <div class="d-flex flex-row align-items-center justify-content-center justify-content-lg-start">
            <p class="lead fw-normal mb-0 me-3" style="font-size: 35px;">Admin Login</p>
          </div>

        <div class="divider d-flex align-items-center my-4">
         
        </div>

          <!-- Email input -->
          <div class="form-outline mb-4">
              <input type="text" name="ah_username" id="form3Example3" class="form-control form-control-lg"
              placeholder="Enter a Username" />
            <label class="form-label" for="form3Example3">Username</label>
          </div>

          <!-- Password input -->
          <div class="form-outline mb-3">
              <input type="password" name="ah_password" id="form3Example4" class="form-control form-control-lg"
              placeholder="Enter password" />
            <label class="form-label" for="form3Example4">Password</label>
          </div>

          <div class="d-flex justify-content-between align-items-center">
          </div>

          <div class="text-center text-lg-start mt-4 pt-2">
            <button type="submit" class="btn btn-primary btn-lg"
              style="padding-left: 2.5rem; padding-right: 2.5rem;">Login</button>
          </div>

        </form>
      </div>
      <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1" style="background-color: #eee;">
        <form action="<?php echo site_url('Customers_portal') ?>" method="post">
          <div class="d-flex flex-row align-items-center justify-content-center justify-content-lg-start">
            <p class="lead fw-normal mb-0 me-3" style="font-size: 35px;">Customer Login</p>
          </div>
          <div class="divider d-flex align-items-center my-4">
 
          </div>
          <!-- Email input -->
          <div class="form-outline mb-4">
              <input type="number" name="username" id="form3Example3" class="form-control form-control-lg"
              placeholder="Enter a Mobile Number" />
            <label class="form-label" for="form3Example3">Mobile Number</label>
          </div>

          <!-- Password input -->
          <div class="form-outline mb-3">
              <input type="password" name="password" id="form3Example4" class="form-control form-control-lg"
              placeholder="Enter password" />
            <label class="form-label" for="form3Example4">Password</label>
          </div>

          <div class="d-flex justify-content-between align-items-center">
              <a href="<?php echo site_url('customers_portal/forgot_password');?>" class="text-body">Forgot password?</a>
              <a href="<?php echo site_url('customer_register');?>" class="text-body">Register Here</a>
          </div>

          <div class="text-center text-lg-start mt-4 pt-2">
            <button type="submit" class="btn btn-primary btn-lg"
              style="padding-left: 2.5rem; padding-right: 2.5rem;">Login</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <div class="d-flex flex-column flex-md-row text-center text-md-start justify-content-between bg-primary">
    <!-- Copyright -->
    <div class="text-white mb-2 mb-md-0">
      Copyright © 2023. All rights reserved.
    </div>
    <!-- Copyright -->
  </div>
</section>     
</html>
