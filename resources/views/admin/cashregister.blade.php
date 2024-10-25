@include('includes.header')

<div class="container-fluid">

        <div class="row mb-3">
            <div class="col-md-6"></div>
            <div class="col-md-6 d-flex justify-content-end">
                <div>
                    <button class="btn btn-success"><i class="fa-solid fa-arrow-right-to-bracket"></i> Cash In </button>
                    <button class="btn btn-danger" data-toggle="modal" data-target="#cashOutModal"><i class="fa-solid fa-arrow-right-from-bracket"></i> Cash Out</button>
                    <div class="btn btn-warning py-2 px-3 ml-3">
                        <p class="mb-0" style="color:#222222;">Total Cash</p>
                        <h5 class="h5" style="color:#222222;font-weight:700;">
                        @php
                            $total = 0;
                            $totalIn = 0;
                            $totalOut = 0;
                        @endphp

                        @foreach($cashRegister as $ca)
                            @if($ca->cash_flow == 1)
                                @php
                                    $totalIn += $ca->payments;
                                @endphp
                            @elseif($ca->cash_flow == 0)
                                @php
                                    $totalOut += $ca->payments;
                                @endphp
                            @endif
                        @endforeach

                        @php
                            $total = $totalIn - $totalOut;
                        @endphp

                        ${{ $total }}
                        </h5>
                    </div>
                </div>
                
            </div>
        </div>


<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Cash Register</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Guest Code</th>
                        <th>Room/Bed no.</th>
                        <th>Amount</th>
                        <th>Payment Rgister By</th>
                        <th>Payment Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>#</th>
                        <th>Guest Code</th>
                        <th>Room/Bed no.</th>
                        <th>Amount</th>
                        <th>Payment Rgister By</th>
                        <th>Payment Date</th>
                        <th>Action</th>
                    </tr>
                </tfoot>
                <tbody>
                    @php
                        $count =1;
                    @endphp
                    @foreach($cashRegister as $ca)
                    <tr>
                        <td>{{$count}}</td>
                        <td>{{$ca->code}}</td>
                        @if($ca->guest_id == 'N/A')
                            <td>{{$ca->guest_id}}</td>
                        @else
                            @foreach($guests as $gs)
                                @if($ca->guest_id == $gs->id)
                                    <td>{{$gs->room_number}}/{{$gs->bed_number}}</td>
                                @endif
                            @endforeach
                        @endif
                        <td>
                            ${{$ca->payments}} 
                            @if($ca->cash_flow == 1)
                                <span class="btn btn-success" style="padding: 0px 10px;margin-left: 10px;">In</span>
                            @elseif($ca->cash_flow == 0)
                                <span class="btn btn-danger"  style="padding: 0px 10px;margin-left: 10px;">Out</span>
                            @endif
                        </td>
                        @foreach($user as $us)
                            @if($ca->user_id == $us->id)
                                <td>{{$us->fname}}</td>
                            @endif
                        @endforeach
                        <td>{{ $ca->created_at->format('F j, Y') }}</td>
                        <td>
                            <a href="{{route('deleteCashRegister',$ca->id)}}" class="btn btn-danger btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete register">
                                <span class="text"><i class="fa-solid fa-trash"></i></span>
                            </a>
                        </td>
                        @php
                            $count++;
                        @endphp
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

</div>


<!-- CashOut popup -->
<div class="modal fade" id="cashOutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Cash Out</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close" id="close-button-cash-out-modal">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body p-3">
                <label>Choose Cash out reason</label><br>
                <input type="radio" name="cash_out_reason" id="gust" value="gust" onclick="showSection('gust')">
                <label for="gust">Gust</label>
                <input type="radio" name="cash_out_reason" id="other" value="other" onclick="showSection('other')">
                <label for="other">Other</label>

                <div class="row" id="guest-choose">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Guest Code*</label>
                            <input type="text" id="guest-code" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Amount*</label>
                            <input type="text" id="guest-amount" class="form-control">
                        </div>
                    </div>
                </div>

                <div id="other-choose">
                    <div class="form-group">
                        <label for="">Comments for cash out*</label>
                        <textarea class="form-control" id="other-cash-out-comments"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="">Amount*</label>
                        <input type="text" id="other-amount" class="form-control">
                    </div>
                </div>

            </div>
            <script>
                function showSection(option) {
                    document.getElementById('guest-choose').style.display = (option === 'gust') ? 'flex' : 'none';
                    document.getElementById('other-choose').style.display = (option === 'other') ? 'block' : 'none';
                }
                window.onload = function() {
                    document.getElementById('gust').checked = true;
                    showSection('gust');
                }
            </script>

            <div class="modal-footer" style="display:block;">
                <div class="form-group">
                    <button class="btn btn-danger mt-2" id="cash-out-btn" type="button">Cash Out</button>
                </div>

            </div>
        </div>
    </div>
</div>
<!-- CashOut popup -->

@include('includes.footer')