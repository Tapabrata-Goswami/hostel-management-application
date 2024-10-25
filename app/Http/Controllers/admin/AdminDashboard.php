<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Guest;
use App\Models\GuestPayment;
use App\Models\guestComments;
use App\Models\HostelUser;

class AdminDashboard extends Controller
{
    public function dashboardView(){
        $totalGuests = Guest::count();
        $pendingPaymentsCount = GuestPayment::where('payment_status', 'pending')->count();
        $archivedGuestsCount = Guest::where('archive_status', true)->count();
        return view('admin.dashboard')->with(['totalGuest'=>$totalGuests,'pendingPaymentsCount'=>$pendingPaymentsCount,'archiveGuest'=>$archivedGuestsCount]);
    }
    // Guest
    public function addGuestView(){
        return view('admin.addguest');
    }
    public function addGuest(Request $request){
        // Custom error messages
        $messages = [
            'first_name.required' => 'The first name is required.',
            'last_name.required' => 'The last name is required.',
            'check_in_date.required' => 'Please provide a check-in date.',
            'check_in_date.date' => 'The check-in date must be a valid date.',
            'room_number.required' => 'Room number is required.',
            'booking.required' => 'Booking status is required.',
            'flyer.required' => 'Flyer status is required.',
            'interdependent.required' => 'Interdependent status is required.',
            'passport_scan.required' => 'Passport scan is required.',
            'passport_scan.file' => 'The passport scan must be a valid file.',
            'passport_scan.mimes' => 'The passport scan must be a file of type: jpg, jpeg, png, pdf.',
            'code.required' => 'The Code is required.'
        ];
    
        // Clean up the data to handle boolean inputs (in case 'on'/'off' is sent)
        $request->merge([
            'booking' => $request->has('booking') ? 1 : 0,
            'flyer' => $request->has('flyer') ? 1 : 0,
            'interdependent' => $request->has('interdependent') ? 1 : 0
        ]);
    
        // Validate the incoming request
        $validatedData = $request->validate([
            'first_name'     => 'required|string|max:255',
            'last_name'      => 'required|string|max:255',
            'check_in_date'  => 'required|date',
            'room_number'    => 'required|string|max:10',
            'bed_number'     => 'required|string|max:10',
            'booking'        => 'required|boolean',
            'flyer'          => 'required|boolean',
            'interdependent' => 'required|boolean',
            'passport_scan'  => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'code' => 'required',
            'email' => '',
            'contact_no' => ''
        ], $messages);
        // dd($validatedData);
        // Handle the passport scan file upload
        if ($request->hasFile('passport_scan')) {
            // Store the file in the 'uploads/passports' directory
            $passportScanPath = $request->file('passport_scan')->store('uploads/passports', 'public');

            // Add the path to the validated data
            $validatedData['passport_scan'] = $passportScanPath;
        }

        // Insert the data into the database
        try {
            // Create and save the guest record
            $guest = Guest::create($validatedData);

            // Create a payment record for the guest
            $guestPaymentData = [
                'guest_id' => $guest->id, // Foreign key
                'payment_status' => 'pending', // Set status to pending
                'payment_comment' => null // Optionally, set a comment (or make it nullable)
            ];
        
        // Create and save the payment record
        GuestPayment::create($guestPaymentData);
    
            // Return success response
            return redirect()->back()->with('success', 'Guest added successfully!');
            
        } catch (\Exception $e) {
            // Handle any errors during insertion
            return redirect()->back()->withErrors(['error' => 'An error occurred while saving the guest data. Please try again.']);
        }
    }
    public function listGuestView(){

        $guests = Guest::all();
        $guests_payment = GuestPayment::all();
        $guest_comment = guestComments::all();

        // Pass the data to the view using with()
        return view('admin.listguest')->with(['guests'=>$guests,'guest_payment' => $guests_payment,'guest_comment'=>$guest_comment]);
    }
    public function editGuestView(Request $request){
        $guest = Guest::where('id', $request->guestId)->first();
        $guest_payment = GuestPayment::where('guest_id', $request->guestId)->first();
        return view('admin.editGuest')->with(['guest'=> $guest,'guest_payment' => $guest_payment]);
    }
    public function updateGuest(Request $request){
        // Validate the incoming request
        $request->validate([
            'first_name'     => 'required|string|max:255',
            'last_name'      => 'required|string|max:255',
            'check_in_date'  => 'required|date',
            'room_number'    => 'required|string|max:10',
            'bed_number'     => 'required|string|max:10',

        ]);

        // Find the guest by ID
        $guest = Guest::find($request->guestId);

        // Check if the guest exists
        if ($guest) {
            // Update guest details
            $guest->first_name = $request->first_name;
            $guest->last_name = $request->last_name;
            $guest->check_in_date = $request->check_in_date;
            // $guest->check_out_date = $request->check_out_date;
            $guest->room_number = $request->room_number;
            $guest->bed_number = $request->bed_number;
            $guest->contact_no = $request->contact_no;
            $guest->email = $request->email;
            $guest->booking = $request->has('booking'); // If checked, set to true
            $guest->flyer = $request->has('flyer'); // If checked, set to true
            $guest->interdependent = $request->has('interdependent'); // If checked, set to true

            // Check if a new passport scan is uploaded
            if ($request->hasFile('passport_scan')) {
                // Handle file upload (you might want to validate the file type and size)
                $passportScanPath = $request->file('passport_scan')->store('uploads/passports', 'public');
                $guest->passport_scan = $passportScanPath; // Save the new path
            }

            // Save the guest changes
            $guest->save();

            // Now, handle the guest payment update if needed
            // $guestPayment = GuestPayment::where('guest_id', $guest->id)->first();
            // if ($guestPayment) {
            //     $guestPayment->payment_status = $request->payment_status;
            //     $guestPayment->payment_comment = $request->payment_comment; // Optional field
            //     $guestPayment->save(); // Save the payment updates
            // }

            // Redirect or return response with success message
            return redirect()->back()->with('success', 'Guest and payment details updated successfully!');
        } else {
            // If the guest was not found, return an error message
            return redirect()->back()->withErrors(['error' => 'Guest not found.']);
        }
    }
    public function archiveGuest(Request $request){

        $guest = Guest::find($request->guestId);

        // Check if the guest exists
        if ($guest) {
            if($guest->archive_status){
                $guest->archive_status = false;
                $guest->check_out_date = null;
                $guest->save(); 
                // $message = 'Guest Unarchived successfully!';
            }else{
                $guest->archive_status = true;
                $guest->check_out_date = $request->checkOutDate;
                $guest->save(); 
                // $message = 'Guest Archived successfully!';
            }
            // return redirect()->back()->with('success', $message);
        }
    }
    public function archiveGuestShow(){
        $guest = Guest::where('archive_status',true)->get();
        $guests_payment = GuestPayment::all();
        return view('admin.archivelistGuest')->with(['guests'=> $guest,'guest_payment' => $guests_payment]);
    }
    public function deleteGuest(Request $request) {
        // Find the guest by the provided ID
        $guest = Guest::find($request->guestId);
        
        // Find associated payment status and comments using the guest ID
        $guestPaymentStatus = GuestPayment::where('guest_id', $guest->id)->first();
        $guestComment = GuestComments::where('guest_id', $guest->id)->get(); // Using `get` since there may be multiple comments

        if ($guest) {
            // Delete the guest's associated payment status
            if ($guestPaymentStatus) {
                // Check if the guest has a passport scan file and delete it
                if ($guest->passport_scan) {
                    $passportScanPath = storage_path('app/public/' . $guest->passport_scan);
                    if (file_exists($passportScanPath)) {
                        unlink($passportScanPath); // Delete the file from storage
                    }
                }
                
                // Delete associated guest payment record
                $guestPaymentStatus->delete();

                // Delete associated guest comments
                foreach ($guestComment as $comment) {
                    $comment->delete();
                }

                // Delete the guest record itself
                $guest->delete();

                return redirect()->back()->with('success', 'Guest and related data deleted successfully!');
            } else {
                return redirect()->back()->withErrors(['error' => 'Guest payment status not found.']);
            }
        }

        return redirect()->back()->withErrors(['error' => 'Guest not found.']);
    }
    public function addComment(Request $request){
        $guestId = $request->guestId;
        $comments = $request->comments;
        guestComments::create([
            'guest_id' => $guestId,
            'comment' => $comments,
        ]);

        return true;

    }
    public function viewComment(Request $request){
        $comments = guestComments::where('guest_id', $request->guestId)->get();
        return response()->json($comments);
    }
    public function deleteComment(Request $request){
        $cId = $request->commentID;
        $cID = guestComments::find($cId);
        if($cID){
            $cID->delete();
            return true;
        }

    }
    public function viewPayment(Request $request){
        $guestPayment = GuestPayment::where('guest_id',$request->guestId)->first();
        return view('admin.addpayment')->with('guestPayment',$guestPayment);
    }
    public function updatePayment(Request $request){

        $guestPayment = GuestPayment::where('guest_id', $request->guestId)->first();
        $totalAmount='';
        $paymentType = $request->payment_type;
        if ($guestPayment) {
            
            if($paymentType == 'monthly'){
                $guestPayment->monthly = true;
                $totalAmount = $request->monthly_amount;
            }else if($paymentType == 'daily'){
                $guestPayment->daily = true;
                $totalAmount = $request->daily_amount;
            }
            $PaidAmount = $request->amount_paid;
            $guestPayment->total_amount = $totalAmount;
            $guestPayment->paid_amount = $PaidAmount;
            $pendingAmount = $totalAmount - $PaidAmount;
            $guestPayment->pending_amount = $pendingAmount;
            if($pendingAmount > 0){
                $guestPayment->payment_status = 'pending';
            }else{
                $guestPayment->payment_status = 'completed';
            }
            $guestPayment->payment_comment = $request->payment_comment;
            $guestPayment->save();

            return redirect()->back()->with('success', 'Payment details updated successfully!');
        }
    }
    public function debetsGuest(){
        $guestPayment = GuestPayment::all();
        $guest = Guest::all();
        return view('admin.debtlist')->with(['guestPayment' => $guestPayment, 'guest' => $guest]);
    }

    // public function countComment(Request $request){

    // }
    // User
    public function listUserView(){
        $user = HostelUser::all();
        return view('admin.listUser')->with('users', $user);
    }
}
