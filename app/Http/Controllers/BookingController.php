<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookingRequest;
use App\Http\Requests\StoreCheckBookingRequest;
use App\Http\Requests\StorePaymentRequest;
use App\Models\BookingTransaction;
use App\Models\Workshop;
use App\Services\BookingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BookingController extends Controller
{
    //
    protected $bookingService;

    public function __construct(BookingService $bookingService)
    {
        $this->bookingService = $bookingService;
    }

    public function booking(Workshop $workshop){
        return view('booking.booking', compact('workshop'));
    }

    public function bookingStore(StoreBookingRequest $request, Workshop $Workshop)
    {
        $validated = $request->validated();
        $validated['workshop_id'] = $Workshop->id;

        try {
            $this->bookingService->storeBooking($validated);
            return redirect()->route('front.payment');
        } catch (\Exception $e) { 
            return redirect()->back()->withErrors(['error' => 'Unable to create booking. Please try again']);
        }
    }


    public function payment ()
    {
        if(!$this->bookingService->isBookingSessionAvailable()){
            return redirect()->route('front.index');
        }

        $data = $this->bookingService->getBookingDetails();

        if (!$data){
            return redirect()->route('front.index');
        }

        return view('booking.payment', compact('data'));
    }

    public function paymentStore(StorePaymentRequest $request)
    {
        $validated = $request->validated();

        try{
            $bookingTransactionId = $this->bookingService->finalizeBookingAndPayment($validated);
            return redirect()->route('front.booking.finished', $bookingTransactionId);
        } catch (\Exception $e) {
            log :: error('Payment storage failed: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Unable to complete payment. Please try again' .$e->getMessage()]);
        }
    }
    public function bookingFinished(BookingTransaction $bookingTransaction)
    {
        return view('booking.finished', compact('bookingTransaction'));
    }

    public function checkBooking(){
        return view('booking.my_booking');
    }
    public function checkBookingStore(StoreCheckBookingRequest $request)
    {
        $validated = $request->validated();

        $myBookingDetails = $this->bookingService->getMyBookingDetails($validated);

        if(!$myBookingDetails){
            return view('booking.my_booking_details',compact('myBookingDetails'));
        }
        return redirect()->route('front.check_booking')->withErrors(['error' => 'Transaction not found']);
    }
}
