@extends('layouts.app')


@section('content')

   <div class="content">
       <div class="container">
        <div class="row">
        
            <div class="col-md-3">
       
                <!-- Profile Image -->
                <div class="card card-primary card-outline">
                    <div class="card-body box-profile">
                        <div class="text-center">
                            <img class="profile-user-img img-fluid img-circle" src="{{ asset('storage/images/profile/profile.jpeg') }}" alt="User profile picture">
                        </div>
  
                        <h3 class="profile-username text-center">{{ $user->name }}</h3>
  
                        <p class="text-muted text-center">{{ $user->email }}</p>
  
                        <ul class="list-group list-group-unbordered mb-3">
                            <li class="list-group-item">
                                <b>Your Total Topics: </b> <a class="float-right">{{ $user->topics }}</a>
                            </li>
                        </ul>
                    </div>
                </div>
  
                <!-- About Me Box -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">About Me</h3>
                    </div>
                    <div class="card-body">
                        <strong><i class="fas fa-book mr-1"></i> Education</strong>
                        <p class="text-muted">{{ $user->education }}</p>
                        <hr>
  
                        <strong><i class="fas fa-map-marker-alt mr-1"></i> Location</strong>
                        <p class="text-muted">{{ $user->country }}</p>
                        <hr>
  
                        <strong><i class="fas fa-pencil-alt mr-1"></i> Skills</strong>
                        <p class="text-muted">{{ $user->skills }}</p>
                        <hr>
  
                        <strong><i class="far fa-file-alt mr-1"></i> Bio</strong>
                        <p class="text-muted">{{ $user->bio }}</p>
                    </div>
                </div>
            </div>
  
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header p-2">
                        <ul class="nav nav-pills">
                            <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">Activity</a></li>
                            <li class="nav-item"><a class="nav-link" href="#timeline" data-toggle="tab">Timeline</a></li>
                            <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Settings</a></li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="active tab-pane" id="activity">
                                <!-- Post -->
                                <div class="post">
                                    <div class="user-block">
                                        <img class="img-circle img-bordered-sm" src="{{ asset('storage/images/profile/profile.png') }}" alt="user image">
                                        <span class="username">
                                            <a href="#">You</a>
                                            <a href="#" class="float-right btn-tool"><i class="fas fa-times"></i></a>
                                        </span>
                                        <span class="description">
                                            started the discussion - 
                                            @if($latest_user_post)
                                                {{ $latest_user_post->created_at->diffForHumans() }}
                                            @else
                                                No recent discussions found.
                                            @endif
                                        </span>
                                    </div>
                                    @if($latest_user_post)
                                         {{ $latest_user_post->desc }}
                                    @else 
                                        <h3 class="mb-5">You have not started discussions yet!</h3>
                                    @endif
                                    <p>
                                        <a href="#" class="link-black text-sm mr-2"><i class="fas fa-eye mr-1"></i>{{ optional($latest_user_post)->view ?? 0 }} views</a>
                                        <a href="#" class="link-black text-sm"><i class="far fa-comment mr-1"></i>{{ $latest_user_post && $latest_user_post->replies ? $latest_user_post->replies->count() : 0 }} replies</a>
  
                                        <span class="float-right">
                                         
                                          @if($latest_user_post && $latest_user_post->replies && $latest_user_post->replies->count() > 0)
                                          @if(auth()->user() && auth()->user()->is_admin)
                                              <a href="{{ route('topic.delete', $latest_user_post->id) }}" class="link-black text-sm"><i class="far fa-trash"></i></a>
                                          @endif
                                          @else
                                              @if($latest_user_post)
                                                  <a href="{{ route('topic.delete', $latest_user_post->id) }}" class="link-black text-sm"><i class="far fa-trash"></i></a>
                                              @endif
                                          @endif
                                      
                                         
                                             
                                        
                                        </span>
                                    </p>
                                    <input class="form-control form-control-sm" type="text" placeholder="Type a comment">
                                </div>
  
                                <!-- Additional posts -->
  
                            </div>
  
                            <div class="tab-pane" id="timeline">
                                <!-- Timeline content -->
                                
                            </div>
                             @if(auth()->id() == $user->id)
                             <div class="tab-pane" id="settings">
                                @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                                @endif
    
                                <form class="form-horizontal" action="{{route('user.update',$user->id)}}"
                                    method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group row">
                                        <label for="name" class="col-sm-2 col-form-label">Name</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" value='{{$user->name}}'
                                                name="username" placeholder="Name">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="Email" class="col-sm-2 col-form-label">Email</label>
                                        <div class="col-sm-10">
                                            <input type="email" class="form-control" value='{{$user->email}}'
                                                name="email" placeholder="Email">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="phone" class="col-sm-2 col-form-label">Phone</label>
                                        <div class="col-sm-10">
                                            <input type="phone" class="form-control" value='{{$user->phone}}'
                                                name="phone" placeholder="Phone">
                                        </div>
                                    </div>
    
                                    <div class="form-group row">
                                        <label for="phone" class="col-sm-2 col-form-label">Education</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control"
                                                value='{{$user->education}}' name="education"
                                                placeholder="Describe your education background">
                                        </div>
                                    </div>
    
                                    <div class="form-group row">
                                        <label for="skills" class="col-sm-2 col-form-label">Skills</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" value='{{$user->skills}}'
                                                name="skills" placeholder="Skills separeted by comma">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="profession" class="col-sm-2 col-form-label">Profession</label>
                                        <div class="col-sm-10">
                                            <input type="phone" class="form-control"
                                                value='{{$user->profession}}' name="profession"
                                                placeholder="Profession">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="country" class="col-sm-2 col-form-label">Country</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" value='{{$user->country}}'
                                                name="country" placeholder="Country">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="Your Bio" class="col-sm-2 col-form-label">Your Bio</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" value='{{$user->bio}}'
                                                name="bio" placeholder="A short introduction about yourself">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="offset-sm-2 col-sm-10">
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox"> I agree to the <a href="#">terms and
                                                        conditions</a>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="offset-sm-2 col-sm-10">
                                            <button type="submit" class="btn btn-danger">Submit</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                             @else
                                 <div class="alert alert-warning mt-3">You are not authorized to access this page!</div>
                             @endif
                          
                        </div>
                    </div>
                </div>
            </div>
        </div>
       </div>
   </div>
@endsection