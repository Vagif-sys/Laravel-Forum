@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        @if($users &&  count($users) > 0)
            @foreach ($users as $user)
            <div class="col-lg-4">
                <div class="card p-2 mt-3">
                    <div class="first">
                        <h6 class="heading">{{$user->name}}</h6>
                        <div class="time d-flex flex-row align-items-center justify-content-between mt-3">
                            <div class="d-flex align-items-center"> <i class="fa fa-clock-o clock"></i> <span class="hour ml-1">joined {{$user->updated_at->diffForHumans()}}</span> </div>
                            <div> <span class="font-weight-bold">{{$user->rank ? $user->rank : 'no rank'}}</span> </div>
                        </div>
                    </div>
                    <div class="second d-flex flex-row mt-2">
                        <div class="image mr-3"> <img src="https://i.imgur.com/0LKZQYM.jpg" class="rounded-circle" width="60" /> </div>
                        <div class="">
                            <div class="d-flex flex-row mb-1"> <span>Posts: {{$user->discussions->count()}}</span>
                            <div> <button class="btn btn-outline-dark btn-sm px-2">+ follow</button><a href="{{route('client.user.profile',$user->id)}}"><button class="btn btn-outline-dark btn-sm">See Profile</button></a>
                        </div>
                    </div>
                    <hr class="line-color">
                    <h6>{{$user->profession ? $user->profession : 'Not Updated'}}</h6>
    
                </div>
            </div>
            @endforeach
        @else
            
        @endif
        
    </div>
    <!-- /.row -->
</div><!-- /.container-fluid -->
@endsection