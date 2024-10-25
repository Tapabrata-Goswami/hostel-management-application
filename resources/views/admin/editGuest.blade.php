@include('includes.header')

<div class="container-fluid">

<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Edit Guest</h1>

<div class="row">
    <div class="col-md-6">
        <div class="card shadow mb-4">
            <!-- <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Gust list</h6>
            </div> -->
            <div class="card-body">
                <form action="{{route('updateGuest', $guest->id)}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>First Name*</label>
                                <input type="text" name="first_name" class="form-control" value="{{$guest->first_name}}">
                                @if ($errors->has('first_name'))
                                    <span class="text-danger">{{ $errors->first('first_name') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Last Name*</label>
                                <input type="text" name="last_name" class="form-control" value="{{$guest->last_name}}">
                                @if ($errors->has('last_name'))
                                    <span class="text-danger">{{ $errors->first('last_name') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Check-in Date *</label>
                                <input type="date" name="check_in_date" class="form-control" value="{{$guest->check_in_date}}">
                                @if ($errors->has('check_in_date'))
                                    <span class="text-danger">{{ $errors->first('check_in_date') }}</span>
                                @endif
                            </div>

                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Code</label>
                                <input type="number" name="code" class="form-control" value="{{$guest->code}}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Room Number*</label>
                                <input type="number" name="room_number" min="1" class="form-control" id="" value="{{$guest->room_number}}">
                                @if ($errors->has('room_number'))
                                    <span class="text-danger">{{ $errors->first('room_number') }}</span>
                                @endif
                            </div>  
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Bed Number*</label>
                                <input type="number" name="bed_number" min="1" class="form-control" id="" value="{{$guest->bed_number}}">
                                @if ($errors->has('bed_number'))
                                    <span class="text-danger">{{ $errors->first('bed_number') }}</span>
                                @endif
                            </div>
                        </div>
                        
                    </div>

                    <!-- <div class="form-group">
                        <label for="">Payment Status*</label>
                        <select name="payment_status" class="form-control" id="">
                            <option value="" disabled>Select Payment Status</option>
                            <option value="pending" {{ $guest_payment->payment_status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="completed" {{ $guest_payment->payment_status == 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="failed" {{ $guest_payment->payment_status == 'failed' ? 'selected' : '' }}>Failed</option>
                        </select>
                        @if ($errors->has('payment_status'))
                            <span class="text-danger">{{ $errors->first('payment_status') }}</span>
                        @endif
                    </div>

                    <div class="from-group">
                        <label for="">Payment Comment</label>
                        <textarea class="form-control" name="payment_comment" id="">{{$guest_payment->payment_comment}}</textarea>
                    </div> -->
                    <div class="form-group">
                        <label for="">Registration Type*</label><br>

                        <!-- Booking Checkbox -->
                        <label for="booking">Booking</label>
                        <input 
                            type="checkbox" 
                            name="booking" 
                            class="mr-3" 
                            id="booking" 
                            @if($guest->booking == true)
                                checked
                            @endif
                        >

                        <!-- Flyer Checkbox -->
                        <label for="flyer">Flyer</label>
                        <input 
                            type="checkbox" 
                            name="flyer" 
                            class="mr-3" 
                            id="flyer" 
                            @if($guest->flyer == true)
                                checked
                            @endif
                        >

                        <!-- Interdependent Checkbox -->
                        <label for="interdependent">Interdependent</label>
                        <input 
                            type="checkbox" 
                            name="interdependent" 
                            class="mr-3" 
                            id="interdependent" 
                            @if($guest->interdependent == true)
                                checked
                            @endif
                        >

                    </div>

                    <div class="form-group mt-4">
                        <label>Passport Scan*</label><a class="ml-4 btn btn-outline-primary btn-sm" href="{{ url('/') }}/storage/{{$guest->passport_scan}}" target="_blank">View Document</a>
                        <div class="input-group">
                            <span class="input-group-text" id="inputGroupFileAddon01">
                                <i class="fas fa-passport"></i>
                            </span>
                            <input type="file" name="passport_scan" class="form-control d-none" id="passportScan" aria-describedby="inputGroupFileAddon01" aria-label="Upload">
                            <label class="form-control" id="passportScanLabel" for="passportScan">Upload passport scan</label>
                        </div>
                        @if ($errors->has('passport_scan'))
                            <span class="text-danger">{{ $errors->first('passport_scan') }}</span>
                        @endif
                    </div>

                    <script>
                        // JavaScript to handle the file input and display file name
                        document.getElementById('passportScan').addEventListener('change', function(e) {
                            var fileName = e.target.files[0] ? e.target.files[0].name : 'Upload passport scan';
                            document.getElementById('passportScanLabel').textContent = fileName;
                        });
                    </script>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Contact No.</label>
                                <input type="tel" class="form-control" name="contact_no" id="" value="{{$guest->contact_no}}">
                                @if ($errors->has('contact_no'))
                                    <span class="text-danger">{{ $errors->first('contact_no') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Email</label>
                                <input type="email" class="form-control" name="email" id="" value="{{$guest->email}}">
                                @if ($errors->has('email'))
                                    <span class="text-danger">{{ $errors->first('email') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-primary btn-icon-split">
                        <span class="icon text-white-50">
                            <i class="fas fa-arrow-right"></i>
                        </span>
                        <span class="text">Update Guest</span>
                    </button>
                </form>
            </div>
        </div>
    </div>

</div>
<!-- DataTales Example -->
    


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


</div>

@include('includes.footer')