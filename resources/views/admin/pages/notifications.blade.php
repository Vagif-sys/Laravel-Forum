@extends('layouts.dashboard')

@section('content')
      <!--main content start-->
      <section id="main-content">
        <section class="wrapper">

              <!--overview start-->
          <div class="row">
            <div class="col-lg-12">
              <h3 class="page-header"><i class="fa fa-users"></i>Users</h3>
              <ol class="breadcrumb">
                <li><i class="fa fa-home"></i><a href="/dashboard/home">Home</a></li>
                <li><i class="fa fa-users"></i>Notifications</li>
              </ol>
            </div>
          </div>

          <div class="row">

            <div class="col-lg-12 col-md-12">
              <div class="panel panel-default">
                <div class="panel-heading">
                  <h2><i class="fa fa-flag-o red"></i><strong>Unread Notifications</strong></h2>
                  <div class="panel-actions">
                    <a href="/dashboard/home" class="btn-setting"><i class="fa fa-rotate-right"></i></a>
                    <a href="/dashboard/home" class="btn-minimize"><i class="fa fa-chevron-up"></i></a>
                    <a href="/dashboard/home" class="btn-close"><i class="fa fa-times"></i></a>
                  </div>
                </div>
                <div class="panel-body">
                  <table class="table bootstrap-datatable countries">
                    <thead>
                      <tr>
                       
                        <th>Description</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Read</th>
                        <th>Delete</th>
                        
                      </tr>
                    </thead>
                    <tbody>
                        @if (count($notifications)> 0)
                            @foreach ($notifications as $notification)
                            <tr>
                                
                                <td>{{$notification->data['message']}}</td>
                                <td>{{$notification->data['name']}}</td>
                                <td>{{$notification->data['email']}}</td>
                                <td><a href="{{route('notification.read', $notification->id)}}" class="btn btn-success">mark as read</a></td>
                                <td>
                                    <form id="delete-form-{{ $notification->id }}" action="{{ route('notification.delete', $notification->id)}}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete({{ $notification->id }})">Delete</button>
                                    </form>
                                </td>
                               
                              </tr>
                            @endforeach
                        @endif
                    </tbody>
                  </table>
                </div>  
              </div>
  
            </div>
            
            </div>
            <!--/col-->
  
          </div>
  


        </section>


      </section>
      <!--main content end-->
@endsection