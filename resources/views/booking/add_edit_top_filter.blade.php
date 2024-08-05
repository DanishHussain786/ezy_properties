@if (isset($data->id))
  @php $title = 'Update Property' @endphp
@else
  @php $title = 'Add Property' @endphp
@endif

@section('title', $title)
@extends('master')
@section('content-view')
  <section class="content-header">
    <div class="header-icon">
      <i class="fa fa-dashboard"></i>
    </div>
    <div class="header-title">
      <h1>Property Panel</h1>
      <small>{{ $title }}</small>
    </div>
  </section>
  
  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-sm-12">
        <div class="panel panel-bd lobidrag">
          <div class="panel-heading">
            <div class="btn-group"> 
              <a class="btn btn-add" href="{{url($data['route_name'])}}">
                <i class="fa fa-list"></i> Properties List 
              </a>
            </div>
          </div>
          <div class="panel-body" style="padding: 8px 15px 8px 15px;">
            @if (Session::has('message'))
              <div class="alert alert-success"><b>Success: </b>{{ Session::get('message') }}</div>
            @endif
            @if (Session::has('error_message'))
              <div class="alert alert-danger"><b>Sorry: </b>{{ Session::get('error_message') }}</div>
            @endif

            <div class="container-fluid">
              <!-- Top Filter Bar -->
              <form id="propertyFilterForm">
                <div class="row">
                  <!-- Labels Row -->
                  <div class="col-md-3"><label class="label-min" for="propertyType">Property Type</label></div>
                  <div class="col-md-3"><label class="label-min" for="priceRange">Price Range</label></div>
                  <div class="col-md-3"><label class="label-min" for="bedrooms">Bedrooms</label></div>
                  <div class="col-md-3"><label class="label-min" for="bathrooms">Bathrooms</label></div>
                </div>
                <div class="row">
                  <!-- Inputs Row -->
                  <div class="col-md-3">
                    <div class="form-group">
                      <select class="form-control input-min" id="propertyType">
                        <option>All</option>
                        <option>House</option>
                        <option>Apartment</option>
                        <option>Condo</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <input type="range" class="form-control input-min" id="priceRange" min="0" max="1000000" step="10000">
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <select class="form-control input-min" id="bedrooms">
                        <option>Any</option>
                        <option>1</option>
                        <option>2</option>
                        <option>3</option>
                        <option>4+</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <select class="form-control input-min" id="bathrooms">
                        <option>Any</option>
                        <option>1</option>
                        <option>2</option>
                        <option>3</option>
                        <option>4+</option>
                      </select>
                    </div>
                  </div>
                </div>
                <!-- Search Button -->
                <div class="row">
                  <div class="col-md-12 text-right">
                    <button type="button" class="btn btn-primary" onclick="filterProperties()">Search</button>
                  </div>
                </div>
              </form>
              <!-- Dynamic Content -->
              <div id="propertyList" class="mt-3">
                <!-- Property Listings will be dynamically added here -->
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>
  </section>
@endsection