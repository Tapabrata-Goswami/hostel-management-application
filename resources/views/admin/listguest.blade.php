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
        <h6 class="m-0 font-weight-bold text-primary">Guest list</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Code</th>
                        <th>Room/Bed No.</th>
                        <th>Check in</th>
                        <th>Contact info</th>
                        <th>Booking Type</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Code</th>
                        <th>Room/Bed No.</th>
                        <th>Check in</th>
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
                    @if($guest->archive_status == false)
                    <tr>
                        <td>{{$count}}</td>
                        <td>{{ $guest->first_name }} {{ $guest->last_name }}</td>
                        <td>{{ $guest->code }}</td>
                        <td>{{ $guest->room_number }}/{{$guest->bed_number}}</td>
                        <td>{{ $guest->check_in_date }}</td>
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
                            <a href="{{route('guestEditView',$guest->id)}}" class="btn btn-primary btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit User">
                                <span class="text"><i class="fa-solid fa-pen-to-square"></i></span>
                            </a>
                            <a href="#" id="{{$guest->id}}" class="btn btn-success btn-sm comment-popup-open" data-bs-toggle="tooltip" data-bs-placement="top" title="Comment" data-toggle="modal" data-target="#commentModal">
                                <span class="text"><i class="fa-solid fa-comment"></i>
                                    @php
                                        $ccount = 0;
                                    @endphp
                                    @foreach($guest_comment as $gc)
                                        @if($gc->guest_id == $guest->id)
                                            @php
                                                $ccount++;
                                            @endphp
                                        @endif
                                    @endforeach
                                    {{$ccount}}
                                </span>
                            </a>
                            <a href="#" id="{{$guest->id}}" class="btn btn-warning btn-sm btn-for-archive-guest" data-bs-toggle="tooltip" data-bs-placement="top" title="Archive User" data-toggle="modal" data-target="#archiveModal">
                                <span class="text"><i class="fa-solid fa-box-archive"></i></span>
                            </a>
                            <a href="{{route('viewPayment',$guest->id)}}" class="btn btn-secondary btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Payment">
                                <span class="text"><i class="fa-regular fa-credit-card"></i></span>
                            </a>
                            <a href="{{route('deleteGuest',$guest->id)}}" class="btn btn-danger btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete User">
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

<!-- Comment popup -->
<div class="modal fade" id="commentModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Comments</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close" id="close-button-for-comment">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body p-2" id="list-comment-all">
            </div>
            <div class="modal-footer" style="display:block;">
                <div class="form-group">
                    <label for="comments">Write a comment</label>
                    <textarea class="form-control" id="comments"></textarea>
                    <button id="submit_comment" class="btn btn-success mt-2" type="button">Add Comment</button>
                </div>

            </div>
        </div>
    </div>
</div>
<!-- Comment popup -->

<!-- Archive Popup -->
<div class="modal fade" id="archiveModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Guest Check Out</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close" id="close-button-for-arcive">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-footer" style="display:block;">
                <div class="row align-items-center ">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="comments">Check-out Date</label>
                            <input type="date" id="checkoutdate" class="form-control">
                            
                        </div>
                    </div>
                    <div class="col-md-4">
                        <button id="archive_guest" class="btn btn-success mt-2" type="button">Archive Guest</button>
                    </div>
                </div>
                

            </div>
        </div>
    </div>
</div>
<!-- Archive Popup -->


@include('includes.footer')