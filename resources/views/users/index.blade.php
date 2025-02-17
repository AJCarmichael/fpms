@extends('layouts.app')

@section('content')
<div class="card shadow-sm mb-4">
    <div class="card-header bg-primary text-white">
         <h4 class="mb-0">Users</h4>
    </div>
    <div class="card-body">
         <table class="table table-striped">
             <thead>
                 <tr>
                     <th>ID</th>
                     <th>Username</th>
                     <th>Email</th>
                     <th>User Type</th> <!-- Added usertype column -->
                 </tr>
             </thead>
             <tbody>
                 @forelse($users as $user)
                 <tr>
                     <td>{{ $user->id }}</td>
                     <td>{{ $user->username }}</td>
                     <td>{{ $user->email ?? 'N/A' }}</td>
                     <td>{{ $user->usertype }}</td> <!-- Display usertype -->
                 </tr>
                 @empty
                 <tr>
                     <td colspan="4">No users available.</td> <!-- Updated colspan -->
                 </tr>
                 @endforelse
             </tbody>
         </table>
    </div>
</div>
@endsection