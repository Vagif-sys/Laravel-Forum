@extends('layouts.app')

@section('content')


<div class="row">
    <div class="col-lg-8">
      <div class="row">

        @if(count($categories) > 0)
             @foreach($categories as $category)
             <div class="col-lg-12">
              <!-- second section  -->
              <a href="{{route('client.category',$category->id)}}">
                <h4 class="text-white bg-info mb-0 p-4 rounded-top">
                  {{$category->title}}
                </h4>
              </a>
             
              <table
                class="table table-striped table-responsive table-bordered"
              >
                <thead class="thead-light">
                  <tr>
                    <th scope="col">Forum</th>
                    <th scope="col">Topics</th>
                  </tr>
                </thead>
                <tbody>
                  @if(count($category->forums) > 0)
                      @foreach($category->forums as $forum)
                      <tr>
                        <td>
                          <h3 class="h5">
                            <a href="{{route('forum.overview',$forum->id)}}" class="text-uppercase">{{$forum->title}}</a>
                          </h3>
                          <p class="mb-0">
                            {!! $forum->desc !!}
                          </p>
                        </td>
                        <td><div>{{$forum->discussions->count()}}</div></td>
                      </tr>
                      @endforeach
                  @else
                      0 forums found in this category
                  @endif
                </tbody>
              </table>
            </div>
          
    
             @endforeach
        @else

           <h1>No Forum Categories Found!</h1>
        @endif
        <!-- Category one -->
        
      </div>
    </div>
    <div class="col-lg-4">
      <aside>
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">Members Online</h4>
            <ul class="list-unstyled mb-0">
               @if(count($users_online) > 0)
                  @foreach($users_online as $user)
                      <li><a href="{{route('client.user.profile',$user->id)}}">{{$user->name}} <span class="badge badge-success">online</span></a></li>
                  @endforeach
               @endif
            </ul>
          </div>
        </div>

        <div class="card mt-3">
          <div class="card-body">
            <h4 class="card-title">All Members</h4>
            <ul class="list-unstyled mb-0">
                @if($few_users && count($few_users) > 0)
                  @foreach($few_users as $user)
                      <li><a href="{{ route('client.user.profile', $user->id) }}">{{ $user->name }}</a></li>
                  @endforeach
                @endif
          
               <li><a href="{{route('client.users')}}">View All Members</a></li>
            </ul>
          </div>
        </div>
        <div class="card mt-3">
          <div class="card-body">
            <h4 class="card-title">Members Statistics</h4>
            <dl class="row">
              <dt class="col-8 mb-0">Total Forums:</dt>
              <dd class="col-4 mb-0">{{$forumCount}}</dd>
            </dl>
            <dl class="row">
              <dt class="col-8 mb-0">Total Topics:</dt>
              <dd class="col-4 mb-0">{{$discussCount}}</dd>
            </dl>
            <dl class="row">
              <dt class="col-8 mb-0">Total members:</dt>
              <dd class="col-4 mb-0">{{$userCount}}</dd>
            </dl>
          </div>
          <div class="card-footer">
            <div>Newest Member</div>
            <div><a href="#">
             @php
              if ($newest !== null && isset($newest->name)) {
                echo $newest->name;
            } else {
                echo "No Users Yet!";
            }

            @endphp
            </a>
            </div>
          </div>
        </div>
      </aside>
    </div>
  </div>
</div>

@endsection
















{{-- @if (Route::has('login'))
<div class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
    @auth
        <a href="{{ url('/home') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Home</a>
    @else
        <a href="{{ route('login') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Log in</a>

        @if (Route::has('register'))
            <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 dark:text-gray-500 underline">Register</a>
        @endif
    @endauth
</div>
@endif --}}