@extends('layouts.app')

@section('content')
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<div class="container">
      @if (count($errors) > 0)
         <div class = "alert alert-danger">
            <ul>
               @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
               @endforeach
            </ul>
         </div>
      @endif
  <a href="{{route('dashboard')}}">back</a><h2>{{isset($user)?'Edit':'Add'}} User:</h2>
  <form action="{{ isset($user)?route('updateuser',['id'=>$user->id]):route('saveuser')}}" method="post">
    @csrf
    <div class="form-group">
      <label for="name">Name:</label>
      <input type="text" class="form-control" id="name" placeholder="Enter Name" name="name" value="{{isset($user)?$user->name:''}}">
    </div>
    <div class="form-group">
      <label for="email">Email:</label>
      <input type="email" class="form-control" id="email" placeholder="Enter email" name="email" value="{{isset($user)?$user->email:''}}">
    </div>
    <div class="form-group">
      <label for="address">Address:</label>
      <input type="address" class="form-control" id="address" placeholder="Enter Address" name="address" value="{{isset($user)?$user->address:''}}">
    </div>    
    <div class="form-group">
      <label for="pwd">Password:</label>
      <input type="password" class="form-control" id="pwd" placeholder="Enter password" name="pwd">
    </div>
    <div class="form-group">
      <label for="userType">User type:</label>
      <select class="form-control" id="userType"name="userType">
        <option value="">Select</option>
        <option value="1" {{(isset($user) && $user->is_admin==1)?'selected':''}}>Admin</option>
        @if(auth()->user()->id!=@$user->id)
        <option value="0" {{(isset($user) && $user->is_admin==0)?'selected':''}}>User</option>
        @endif
      </select> 
    </div>
    <button type="submit" class="btn btn-default">{{isset($user)?'Update':'Save'}}</button>
  </form>
</div>
@endsection

