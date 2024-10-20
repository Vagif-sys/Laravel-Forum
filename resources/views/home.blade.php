@extends('layouts.app')

@section('content')
<!-- Main content -->
<section class="content">
    <div class="container">
        <div class="row">
            <div class="col-md-3">

                <!-- Profile Image -->
                <div class="card card-primary card-outline">
                    <div class="card-body box-profile">
                        <div class="text-center">
                            <img class="profile-user-img img-fluid img-circle" src="{{asset("
                                /storage/profile/".auth()->user()->image)}}" alt="User profile picture">
                        </div>

                        <h3 class="profile-username text-center">{{auth()->user()->name}}</h3>

                        <p class="text-muted text-center">{{auth()->user()->email}}</p>

                        <ul class="list-group list-group-unbordered mb-3">
                            <li class="list-group-item">
                                <b>Your Total Topics: </b> <a class="float-right">{{auth()->user()->topics}}</a>
                            </li>

                            <li class="list-group-item">
                                 <form action="{{route('user.photo.update', auth()->id())}}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                      <input type="file" class="form-control" name="profile_image">
                                      <input type="submit" class="form-control mt-3" value="Update Photo">
                                 </form>
                            </li>
                        </ul>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->

                <!-- About Me Box -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">About Me</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <strong><i class="fas fa-book mr-1"></i> Education</strong>

                        <p class="text-muted">
                            {{auth()->user()->education}}
                        </p>

                        <hr>

                        <strong><i class="fas fa-map-marker-alt mr-1"></i> Location</strong>

                        <p class="text-muted">{{auth()->user()->country}}</p>

                        <hr>

                        <strong><i class="fas fa-pencil-alt mr-1"></i> Skills</strong>

                        <p class="text-muted">
                            {{auth()->user()->skills}}
                        </p>

                        <hr>

                        <strong><i class="far fa-file-alt mr-1"></i>Bio</strong>

                        <p class="text-muted">{{auth()->user()->bio}}</p>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->






            <div class="col-md-9">






                <div class="card">
                    <div class="card-header p-2">
                        <ul class="nav nav-pills">
                            <li class="nav-item"><a class="nav-link active" href="#activity"
                                    data-toggle="tab">Activity</a></li>
                            <li class="nav-item"><a class="nav-link" href="#timeline" data-toggle="tab">Timeline</a>
                            </li>
                            <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Settings</a>
                            </li>
                        </ul>
                    </div><!-- /.card-header -->
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="active tab-pane" id="activity">










                                <!-- Post -->
                                <div class="post">
                                    <div class="user-block">
                                        <img class="img-circle img-bordered-sm" src="{{asset('storage/images/profile/profile.png')}}"
                                            alt="user image">
                                        <span class="username">
                                            <a href="#">You</a>
                                            <a href="#" class="float-right btn-tool"><i class="fas fa-times"></i></a>
                                        </span>
                                        <span class="description">started the discussion - 
                                        @if($latest_user_post)
                                            {{ $latest_user_post->created_at->diffForHumans() }}
                                        @else
                                            <p>No recent discussions found.</p>
                                        @endif</span>
                                    </div>
                                    <!-- /.user-block -->
                                   
                                    @if($latest_user_post)
                                             
                                         {{$latest_user_post->desc}}
                                    @else 
                                        <h3 class="mb-5">You have not started discussions yet!</h3>
                                    @endif
                                    <p>
                                        <a href="#" class="link-black text-sm mr-2">
                                            <i class="fas fa-eye mr-1"></i>
                                            {{ $latest_user_post->view ?? 0 }} views
                                        </a>

                                        <a href="#" class="link-black text-sm">
                                            <i class="far fa-comment mr-1"></i>
                                            {{ isset($latest_user_post) && $latest_user_post->replies ? $latest_user_post->replies->count() : 0 }} replies
                                        </a>
                                        
                                        
                                        

                                        <span class="float-right">
                                            @if($latest_user_post && $latest_user_post->replies && $latest_user_post->replies->count() > 0)
                                            <!-- Disable the delete button if there are replies -->
                                            <button class="btn btn-danger disabled">
                                               <i class="fa fa-trash"></i>
                                            </button>
                                        @elseif($latest_user_post)
                                            <!-- Show the delete button if there are no replies -->
                                            <a href="{{ route('topic.delete', $latest_user_post->id) }}" class="link-black text-sm">
                                               <i class="far fa-trash"></i>
                                            </a>
                                        @else
                                            <!-- Display fallback if there is no latest post -->
                                            <p>No post found.</p>
                                        @endif
                                        
                                        </span>
                                    </p>

                                    <input class="form-control form-control-sm" type="text"
                                        placeholder="Type a comment">
                                </div>
                                <!-- /.post -->




                                <!-- Post -->
                                <div class="post clearfix">
                                    <div class="user-block">
                                        <img class="img-circle img-bordered-sm" src="{{asset('storage/profile'.auth()->user()->image)}}"
                                            alt="User Image">
                                        <span class="username">
                                            <a href="#">
                                            @if($latest)
                                                {{ $latest->user->name ?? 'Unknown User' }}
                                            @else
                                                <p>No latest discussion available.</p>
                                            @endif</a>
                                            <a href="#" class="float-right btn-tool"><i class="fas fa-times"></i></a>
                                        </span>
                                        <span class="description">started the discussion-   
                                        @if($latest)
                                            {{ $latest->created_at->diffForHumans() }}
                                        @else
                                            <p>No recent discussions found.</p>
                                        @endif</span></span>
                                    </div>
                                    <!-- /.user-block -->
                                    <p>
                                      @if($latest)

                                          <p>{{$latest->desc}}</p>
                                      @else 
                                          <h3 class='mb-3'>there is no topic yet!</h3>
                                     @endif
                                    </p>

                                    <form class="form-horizontal" method="POST" action="{{route('topic.reply',$latest->id)}}">
                                        @csrf
                                        <div class="input-group input-group-sm mb-0">
                                            <input class="form-control form-control-sm" name="desc" placeholder="Response">
                                            <div class="input-group-append">
                                                <button type="submit" class="btn btn-danger">Send</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <!-- /.post -->


                            </div>










                            <!-- /.tab-pane -->
                            <div class="tab-pane" id="timeline">

                                ghghghghg
                            </div>
                            <!-- /.tab-pane -->

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

                                <form class="form-horizontal" action="{{route('user.update',auth()->id())}}"
                                    method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group row">
                                        <label for="name" class="col-sm-2 col-form-label">Name</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" value='{{auth()->user()->name}}'
                                                name="username" placeholder="Name">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="Email" class="col-sm-2 col-form-label">Email</label>
                                        <div class="col-sm-10">
                                            <input type="email" class="form-control" value='{{auth()->user()->email}}'
                                                name="email" placeholder="Email">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="phone" class="col-sm-2 col-form-label">Phone</label>
                                        <div class="col-sm-10">
                                            <input type="phone" class="form-control" value='{{auth()->user()->phone}}'
                                                name="phone" placeholder="Phone">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="phone" class="col-sm-2 col-form-label">Education</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control"
                                                value='{{auth()->user()->education}}' name="education"
                                                placeholder="Describe your education background">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="skills" class="col-sm-2 col-form-label">Skills</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" value='{{auth()->user()->skills}}'
                                                name="skills" placeholder="Skills separeted by comma">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="profession" class="col-sm-2 col-form-label">Profession</label>
                                        <div class="col-sm-10">
                                            <input type="phone" class="form-control"
                                                value='{{auth()->user()->profession}}' name="profession"
                                                placeholder="Profession">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="country" class="col-sm-2 col-form-label">Country</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" value='{{auth()->user()->country}}'
                                                name="country" placeholder="Country">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="Your Bio" class="col-sm-2 col-form-label">Your Bio</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" value='{{auth()->user()->bio}}'
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
                            <!-- /.tab-pane -->
                        </div>
                        <!-- /.tab-content -->
                    </div><!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</section>
<!-- /.content -->

@endsection