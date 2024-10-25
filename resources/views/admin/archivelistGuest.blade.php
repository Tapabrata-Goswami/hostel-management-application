@include('includes.header')

<div class="container-fluid">

<!-- Page Heading -->


@if(session('success'))
    <div id="success-message" class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif
<script>
    window.onload = function() {
        var successMessage = document.getElementById('success-message');
        if (successMessage) {
            setTimeout(function() {
                $(successMessage).alert('close'); // Close the alert after 1 second
            }, 1500);
        }
    };
</script>
<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Archive Guest list</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Room/Bed No.</th>
                        <th>Check in</th>
                        <th>Check Out</th>
                        <th>Contact info</th>
                        <th>Booking Type</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Room/Bed No.</th>
                        <th>Check in</th>
                        <th>Check Out</th>
                        <th>Contact info</th>
                        <th>Booking Type</th>
                        <th>Action</th>
                    </tr>
                </tfoot>
                <tbody>
                    @php
                        $count = 1;
                    @endphp
                @foreach($guests as $guest)

                    <tr>
                        <td>{{$count}}</td>
                        <td>{{ $guest->first_name }} {{ $guest->last_name }}</td>
                        <td>{{ $guest->room_number }}/{{$guest->bed_number}}</td>
                        <td>{{ $guest->check_in_date }}</td>
                        <td>{{ $guest->check_out_date }}</td>
                        <td>{{ $guest->email }} <br>{{ $guest->contact_no }} </td>
                        <!-- Booking Type based on conditions -->
                        <td>
                            @if($guest->booking && $guest->flyer && $guest->interdependent)
                                Full Package
                            @elseif($guest->booking && $guest->flyer)
                                Booking + Flyer
                            @elseif($guest->booking && $guest->interdependent)
                                Booking + Interdependent
                            @elseif($guest->flyer && $guest->interdependent)
                                Flyer + Interdependent
                            @elseif($guest->booking)
                                Standard Booking
                            @elseif($guest->flyer)
                                Flyer Only
                            @elseif($guest->interdependent)
                                Interdependent Only
                            @else
                                No Booking
                            @endif
                        </td>
                        <!-- Booking Type based on conditions -->

                        <td>
                            <a href="#" id="{{$guest->id}}" class="btn btn-success btn-sm btn-unarchived-guest" data-bs-toggle="tooltip" data-bs-placement="top" title="Unarchive User">
                                <span class="text"><i class="fa-solid fa-box-archive"></i></span>
                            </a>
                            <a href="{{route('deleteGuest',$guest->id)}}" class="btn btn-danger btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete User">
                                <span class="text"><i class="fa-solid fa-trash"></i></span>
                            </a>
                        </td>
                    </tr>
                    @php
                        $count ++;
                    @endphp
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

</div>

@include('includes.footer')