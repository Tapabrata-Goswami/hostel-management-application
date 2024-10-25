@include('includes.header')

<div class="container-fluid">

<!-- Page Heading -->

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Guest Debts details</h6>
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
                        <th>Payment Type</th>
                        <th>Total Amount</th>
                        <th>Paid Amount</th>
                        <th>Pending Amount</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Room/Bed No.</th>
                        <th>Check in</th>
                        <th>Payment Type</th>
                        <th>Total Amount</th>
                        <th>Paid Amount</th>
                        <th>Pending Amount</th>
                    </tr>
                </tfoot>
                <tbody>
                    @php
                        $count = 1;
                    @endphp
                    @foreach($guest as $G)
                        @foreach($guestPayment as $GP)
                            @if($G->id == $GP->guest_id)
                                @if($GP->payment_status != 'completed')
                                    <tr>
                                        <td>{{$count}}</td>
                                        <td>{{ $G->first_name }} {{ $G->last_name }}</td>
                                        <td>{{ $G->room_number }}/{{$G->bed_number}}</td>
                                        <td>{{$G->check_in_date}}</td>
                                        <td>{{$GP->daily ? 'Daily' : ''}}{{$GP->monthly ? 'Monthly' : ''}}</td>
                                        <td>{{$GP->total_amount}}</td>
                                        <td>{{$GP->paid_amount}}</td>
                                        <td>{{$GP->pending_amount}}</td>
                                    </tr>
                                    @php
                                        $count++;
                                    @endphp
                                @endif
                            @endif
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

</div>




@include('includes.footer')