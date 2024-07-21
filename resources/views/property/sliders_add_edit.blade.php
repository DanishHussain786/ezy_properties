@if (isset($data->id))
  @section('title', 'Update Chapter')
@else
  @section('title', 'Add Chapter')
@endif

<style>
  .step-form {
      display: none;
  }
  .step-form.active {
      display: block;
  }
  .step-indicators {
      margin-bottom: 20px;
  }
  .step-indicators .step {
      display: inline-block;
      width: 25%;
      text-align: center;
      position: relative;
  }
  .step-indicators .step .step-number {
      display: inline-block;
      width: 30px;
      height: 30px;
      line-height: 30px;
      border-radius: 50%;
      background: #ddd;
      color: #fff;
  }
  .step-indicators .step.active .step-number,
  .step-indicators .step.completed .step-number {
      background: #337ab7;
  }
  .step-indicators .step .step-title {
      display: block;
      margin-top: 10px;
      font-size: 12px;
      color: #888;
  }
  .step-indicators .step.active .step-title,
  .step-indicators .step.completed .step-title {
      color: #337ab7;
  }
  .step-indicators .step.completed::before,
  .step-indicators .step.completed::after {
      content: "";
      position: absolute;
      top: 15px;
      left: 50%;
      width: 100%;
      height: 2px;
      background: #337ab7;
      z-index: -1;
  }
  .step-indicators .step:first-child::before {
      content: none;
  }
  .step-indicators .step.completed::after {
      left: 50%;
      width: 50%;
  }
  .step-indicators .step.completed::before {
      left: -50%;
      width: 50%;
  }
</style>

@extends('master')

@section('content-view')
  <section class="content-header">
    <div class="header-icon">
      <i class="fa fa-dashboard"></i>
    </div>
    <div class="header-title">
      <h1>User Panel</h1>
      <small>Add User</small>
    </div>
  </section>
  
  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-sm-12">
        <div class="panel panel-bd lobidrag">
          <div class="panel-heading">
            <div class="btn-group"> 
              <a class="btn btn-add" href="{{url('user')}}">
                <i class="fa fa-list"></i> User List 
              </a>
            </div>
          </div>
          <div class="panel-body">
            @if (Session::has('message'))
              <div class="alert alert-success"><b>Success: </b>{{ Session::get('message') }}</div>
            @endif
            @if (Session::has('error_message'))
              <div class="alert alert-danger"><b>Sorry: </b>{{ Session::get('error_message') }}</div>
            @endif

            @if (isset($data->id))
            <form class="form" action="{{ route('user.update', $data->id) }}" method="post" enctype="multipart/form-data">
            @method('PUT')
            <input type="hidden" name="update_id" value="{{$data->id}}">
            @else
            <form class="form col-sm-12" action="{{ route('user.store') }}" method="POST" enctype="multipart/form-data">
            @endif
            @csrf

            <div class="container mt-5">
              <div class="step-indicators">
                  <div class="step active">
                      <div class="step-number">1</div>
                      <div class="step-title">Order Details</div>
                  </div>
                  <div class="step">
                      <div class="step-number">2</div>
                      <div class="step-title">Shipping Info</div>
                  </div>
                  <div class="step">
                      <div class="step-number">3</div>
                      <div class="step-title">Payment Details</div>
                  </div>
                  <div class="step">
                      <div class="step-number">4</div>
                      <div class="step-title">Confirmation</div>
                  </div>
              </div>
              <form id="multiStepForm">
                  <div class="step-form active">
                      <h3>Order Details</h3>
                      <!-- Order details fields -->
                      <div class="form-group">
                          <label for="product">Product</label>
                          <input type="text" class="form-control" id="product" required>
                      </div>
                      <div class="form-group">
                          <label for="quantity">Quantity</label>
                          <input type="number" class="form-control" id="quantity" required>
                      </div>
                      <button type="button" class="btn btn-primary next-btn">Next</button>
                  </div>
                  <div class="step-form">
                      <h3>Shipping Info</h3>
                      <!-- Shipping info fields -->
                      <div class="form-group">
                          <label for="name">Name</label>
                          <input type="text" class="form-control" id="name" required>
                      </div>
                      <div class="form-group">
                          <label for="address">Address</label>
                          <input type="text" class="form-control" id="address" required>
                      </div>
                      <button type="button" class="btn btn-default prev-btn">Previous</button>
                      <button type="button" class="btn btn-primary next-btn">Next</button>
                  </div>
                  <div class="step-form">
                      <h3>Payment Details</h3>
                      <!-- Payment details fields -->
                      <div class="form-group">
                          <label for="cardNumber">Card Number</label>
                          <input type="text" class="form-control" id="cardNumber" required>
                      </div>
                      <div class="form-group">
                          <label for="expiryDate">Expiry Date</label>
                          <input type="text" class="form-control" id="expiryDate" required>
                      </div>
                      <button type="button" class="btn btn-default prev-btn">Previous</button>
                      <button type="button" class="btn btn-primary next-btn">Next</button>
                  </div>
                  <div class="step-form">
                      <h3>Confirmation</h3>
                      <p>Review your order and submit.</p>
                      <button type="button" class="btn btn-default prev-btn">Previous</button>
                      <button type="submit" class="btn btn-success">Submit</button>
                  </div>
              </form>
          </div>

              <div class="col-sm-12 reset-button">
                <a href="" class="btn btn-warning">Reset</a>
                <button type="submit" class="btn btn-success">{{ isset($data->id) ? 'Update':'Add' }}</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>

  <script>
    $(document).ready(function() {
      var currentStep = 0;
      var steps = $(".step-form");
      var indicators = $(".step-indicators .step");

      function showStep(step) {
          steps.removeClass("active").eq(step).addClass("active");
          indicators.removeClass("active").removeClass("completed");
          indicators.slice(0, step).addClass("completed");
          indicators.eq(step).addClass("active");
      }

      $(".next-btn").on("click", function() {
          if (currentStep < steps.length - 1) {
              currentStep++;
              showStep(currentStep);
          }
      });

      $(".prev-btn").on("click", function() {
          if (currentStep > 0) {
              currentStep--;
              showStep(currentStep);
          }
      });

      $("#multiStepForm").on("submit", function(event) {
          event.preventDefault();
          alert("Form submitted!");
          // Handle form submission here
      });
    });

  </script>
@endsection