@extends('layouts.app')

@section('content')
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<div class="container">
@if(session()->has('message'))
    <div class="alert alert-success">
        {{ session()->get('message') }}
    </div>
@endif

  <h2>User List: <a href="{{route('adduser')}}" class="btn btn-secondary">Add User</a>
</h2>
  <p>Showing {{ $pagelist = isset($_GET['page']) ? $_GET['page'] : '1' }} to {{count($userList)}} of {{$totalusers}} entries </p>
  <table class="table table-bordered">
    <thead>
      <tr>
        <th>#</th>
        <th>Name</th>
        <th>Email</th>
        <th>Address</th>
        <th>Role</th>
        <th>Created At</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      @if(count($userList)>0)
      @php $i=0; @endphp
        @foreach($userList as $list)
          <tr>
            <td>{{(($userList->currentPage() - 1 ) * $userList->perPage() ) + $loop->iteration}}</td>
            <td>{{$list->name}}</td>
            <td>{{$list->email}}</td>
            <td>{{$list->address}}</td>
            <td>{{($list->is_admin && $list->is_admin==1)?'Admin':'User'}}</td>
            <td>{{$list->created_at}}</td>
            <td>
              <a href="{{route('edituser',['id'=>$list->id])}}" class="btn btn-primary btn-sm">Edit</a>  
              @if(auth()->user()->id!=$list->id)
              <button type="button" class="btn btn-default btn-sm" data-toggle="modal" data-target="#roleModal{{$list->id}}">
                Role
              </button>            
              <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delModal{{$list->id}}">
                Delete
              </button>  
              @endif
              <!-- Modal Start -->
                <div class="modal fade" id="roleModal{{$list->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" aria-hidden="true" >
                <div class="modal-dialog" role="document" style="max-width:80%!important;">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Change the Role.</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{route('editRole',['id'=>$list->id])}}" method="post">
                    @csrf 
                    <div class="modal-body">                   
                    <div class="form-group">
                      <label for="userType">User type:</label>
                      <select class="form-control" id="userType"name="userType">
                        <option value="">Select</option>
                        <option value="1" {{(isset($list) && $list->is_admin==1)?'selected':''}}>Admin</option>
                        <option value="0" {{(isset($list) && $list->is_admin==0)?'selected':''}}>User</option>
                      </select> 
                    </div> 
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                    </div>
                  </form>
                </div>
                </div>
              </div>
                <!-- Modal End -->  
                <!-- Modal Start -->
                <div class="modal fade" id="delModal{{$list->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" >
                <div class="modal-dialog" role="document" style="max-width:80%!important;">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Delete the Record.</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">                   
                        <h4 style="text-align: center;">Do You want to delete this record?</h4>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                        <!-- <button type="submit" class="btn btn-primary">Upload</button> -->
                        <a href="{{route('deleteUser',['id'=>$list->id])}}" class="edit btn btn-primary">Yes</a>
                    </div>
                    </div>
                </div>
                </div>
              </div>
                <!-- Modal End -->  
            </td>
          </tr>
          @php $i++; @endphp
        @endforeach
      @else
        <tr><th colspan='8'>No Record found</th></tr>
      @endif
    </tbody>
  </table>
  {!! $userList->links() !!}
</div>
@endsection

