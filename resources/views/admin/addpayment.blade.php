@include('includes.header')

<div class="container-fluid">

<!-- Page Heading -->
<!-- <h1 class="h3 mb-2 text-gray-800">Add Guest</h1> -->

<div class="row">
    <div class="col-md-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Guest payment details</h6>
            </div>
            <div class="card-body">
            <form action="{{route('updatePayment',$guestPayment->guest_id)}}" method="post">
                @csrf
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-6">
                            <p class="h6">Daily payemnt</p>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <!-- Radio button for Daily -->
                                        <input type="radio" name="payment_type" value="daily" aria-label="Radio for Daily Amount"
                                            {{ $guestPayment->daily == true ? 'checked' : '' }}>
                                    </div>
                                </div>
                                <!-- Show total amount in daily input if 'daily' is true -->
                                <input type="text" class="form-control" aria-label="Text input with radio" placeholder="Daily Amount" 
                                    name="daily_amount" value="{{ $guestPayment->daily == true ? $guestPayment->total_amount : '' }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <p class="h6">Monthly payemnt</p>
                            <div class="input-group mb-3">
                                
                                <div class="input-group-prepend">
                                
                                    <div class="input-group-text">
                                        <!-- Radio button for Monthly -->
                                        <input type="radio" name="payment_type" value="monthly" aria-label="Radio for Monthly Amount"
                                            {{ $guestPayment->monthly == true ? 'checked' : '' }}>
                                    </div>
                                </div>
                                <!-- Show total amount in monthly input if 'monthly' is true -->
                                <input type="text" class="form-control" aria-label="Text input with radio" placeholder="Monthly Amount" 
                                    name="monthly_amount" value="{{ $guestPayment->monthly == true ? $guestPayment->total_amount : '' }}">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="h6" for="">Amount paid*</label>
                        <input class="form-control" type="number" name="amount_paid" value="{{$guestPayment->paid_amount}}">
                    </div>
                    <div class="form-group">
                        <label class="h6" for="">Comment</label>
                        <textarea class="form-control" name="payment_comment" id="">{{$guestPayment->payment_comment}}</textarea>
                    </div>
                </div>
                <button class="btn btn-primary btn-icon-split">
                    <span class="icon text-white-50">
                        <i class="fas fa-arrow-right"></i>
                    </span>
                    <span class="text">Update payment status</span>
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