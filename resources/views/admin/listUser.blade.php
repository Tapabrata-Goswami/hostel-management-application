@include('includes.header')

<div class="container-fluid">

<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Manager list</h1>


<!-- DataTales Example -->
<div class="card shadow mb-4">

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>User Name</th>
                        <th>Name</th>
                        <th>Contact info</th>
                        <th>Status</th>
                        <th>User Type</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>#</th>
                        <th>User Name</th>
                        <th>Name</th>
                        <th>Contact info</th>
                        <th>Status</th>
                        <th>User Type</th>
                        <th>Action</th>
                    </tr>
                </tfoot>
                <tbody>
                    @php
                        $count = 1
                    @endphp
                    @foreach ($users as $user)
                    @if(session('user_id') != $user->id)
                    <tr>
                        <td>{{$count}}</td>
                        <td>{{$user->username}}</td>
                        <td>{{$user->fname}} {{$user->lname}}</td>
                        <td>{{$user->email}}<br>{{$user->mobile_number}}</td>
                        <td>Active</td>
                        <td>
                            @if($user->user_type == 1)
                                admin
                            @elseif($user->user_type == 2)
                                commentator
                            @elseif($user->user_type == 3)
                                viwer
                            @endif
                        </td>
                        <td>
                            <a href="#" class="btn btn-primary btn-sm">
                                <span class="text"><i class="fa-solid fa-pen-to-square"></i></span>
                            </a>
                            <a href="#" class="btn btn-danger btn-sm">
                                <span class="text"><i class="fa-solid fa-trash"></i></span>
                            </a>
                        </td>
                    </tr>
                    @php
                        $count ++;
                    @endphp
                    @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

</div>

@include('includes.footer')