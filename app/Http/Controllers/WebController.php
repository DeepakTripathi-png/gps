<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RoomType;
use Carbon\Carbon;
use App\Models\LinkBookingRequest;
use App\Models\BookedHall;
use App\Models\Hall;
use App\Models\Booking;
use App\Constants\Status;
use App\Models\BookedRoom;
use App\Models\Room;
use App\Models\Donation;
use App\Models\patthbookings;
use App\Models\patths;
use App\Models\Ardaspurposes;   
use App\Models\Funds;
use App\Models\Event;
use App\Models\News;
use App\Models\Gallery;
use App\Models\Messageadmini;
use App\Models\Dailyschedule;
use App\Models\Occasions;
use App\Models\Contactus;
use App\Models\Tender;
use App\Models\New_proposed;
use App\Models\User;
use App\Models\Faq;
use App\Models\Termsandcondition;
use App\Models\Subscriber;



use App\Models\ShiftCollectionDetail;
use Illuminate\Support\Facades\Validator;
use App\Models\Admin;
use App\Models\Slider;


class WebController extends Controller
{


    public function subscribe(Request $request) {
        $validator = Validator::make(
            $request->all(),
            [
                'email' => 'required|email|max:255|unique:subscribers',
            ],
            [
                'email.unique' => 'You are already subscribed'
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $subscriber = new Subscriber();
        $subscriber->email = $request->email;
        $subscriber->save();
        $notify[] = ['success', 'Subscribed Successfully'];
        return redirect()->back()->withNotify($notify);
    }


   
    public function index(){
        $sliders = Slider::active()->get();        
        $newss = News::active()->orderBy('title', 'desc')->limit(3)->get();
        $gallery = Gallery::active()->limit(3)->get();
        $message = Messageadmini::active()->first();        
        if ($message) {
            $text = strip_tags($message->message); 
            $words = preg_split('/\s+/', $text, 60 + 1); 
            $limitedText = implode(' ', array_slice($words, 0, 60)); 
        } else {
            $limitedText ='';
        }
        return view('frontend.home_page',compact('sliders','newss','gallery','message','limitedText'));
    }

    public function history(){
        return view('frontend.history');
    }
    public function header(){
        return view('frontend.header');
    }

    public function dailyPoojaPath(){
        $daily_schedules = Dailyschedule::active()->get();

        return view('frontend.daily_schedule_pooja',compact('daily_schedules'));
    }

    public function occasions(){
        $occasions = Occasions::active()->get();
        return view('frontend.occasions',compact('occasions'));
    }

    public function accomadation(){
        return view('frontend.accomadation');
    }

    public function presidentMessage(){
        $message = Messageadmini::active()->first();        

        return view('frontend.president_message',compact('message'));
    }

    public function howToReach(){
        return view('frontend.how_to_reach');
    }

    public function gurudwaraBandaGhat(){
        return view('frontend.gurudwara_banda_ghat');
    }
    public function gurudwaraHeeraGhat(){
        return view('frontend.gurudwara_heera');
    }
    public function gurudwaraMaalTekdi(){
        return view('frontend.gurudwara_maal_tekdi');
    }

    public function gurudwaraMata(){
        return view('frontend.gurudwara_mata');
    }
    public function gurudwaraNagina(){
        return view('frontend.gurudwara_nagina');
    }
    public function gurudwaraSangat(){
        return view('frontend.gurudwara_sangat');
    }

    public function gurudwaraShikar(){
        return view('frontend.gurudwara_shikar');
    }
    public function jantri(){
        
        return view('frontend.jantri');
    }
    public function hukaamnama(){
        return view('frontend.hukaamnama');
    }
    public function upcomingEvents(){
        $now = now();
        $events = Event::join('room_types', 'events.room_type_id', '=', 'room_types.id')
        ->select('events.*', 'room_types.name as complexname')
        ->whereYear('events.date', $now->year)
        ->whereMonth('events.date', $now->month)
        ->limit(4)
        ->get();
        return view('frontend.upcoming_events',compact('events'));
    }

    public function panjPiyare(){
        return view('frontend.panj_piyare');
    }

    
    public function hazurSahibIti(){
        return view('frontend.hazur_sahib_iti');
    }

    public function sachkhandPattar(){
        return view('frontend.sachkhand_pattar');
    }

    public function education(){
        return view('frontend.education');
    }
    public function donateOnline(){
        $fund = Funds::get(['id', 'name']);
        $ardaspurpose = Ardaspurposes::get(['id', 'name']);
        return view('frontend.donate_online', compact('fund','ardaspurpose'));
    }
    public function roomBooking(){
        $roomTypes = RoomType::active()->get(['id', 'name']);
      
        return view('frontend.room_booking',compact('roomTypes'));

    }

    public function mobileChatbot(){
        return view('frontend.partials.index-mobile');
    }

    public function roomBookingMobile(Request $request) {
        $roomTypes = RoomType::active()->get(['id', 'name']);
        $ENCRYPTION_KEY = env("ENCRYPTION_KEY");
        $INITIALIZATION_VECTOR = env("INITIALIZATION_VECTOR");
        $CIPHER = env("CIPHER");
        //echo $user_data = $ENCRYPTION_KEY."#7874381453#3"; 
        // $encrypted_data = openssl_encrypt($user_data, $CIPHER, $ENCRYPTION_KEY, 0, $INITIALIZATION_VECTOR);
        $fullUrl = $_SERVER['REQUEST_URI'];
        $queryString = parse_url($fullUrl, PHP_URL_QUERY);
        $key_arr = explode('ci_key=',$queryString);
        $clean_arr_key = array_filter($key_arr, fn($value) => !is_null($value) && $value !== '');
        $ci_key = (isset($clean_arr_key[1])) ? $clean_arr_key[1] : '';
        $decrypted_data = openssl_decrypt($ci_key, $CIPHER, $ENCRYPTION_KEY, 0, $INITIALIZATION_VECTOR);
        $user_arr = explode('#',$decrypted_data);
        $clean_arr = array_filter($user_arr, fn($value) => !is_null($value) && $value !== '');
        $user = '';
        $ac_token = '';
        if(!empty($clean_arr)) {
            $secret_key = (isset($clean_arr[0])) ? $clean_arr[0] :'';
            $mobile_no = (isset($clean_arr[1])) ? $clean_arr[1] : '';
            $user_id = (isset($clean_arr[2])) ? $clean_arr[2] :'' ;
            $ac_token = (isset($clean_arr[3])) ? $clean_arr[3] :'' ;
            if(isset($user_id) && !empty($user_id)) {
                $user  = User::where('id',$user_id)->first();
            }
        }
        // echo "<pre>";
        // print_r($ac_token);die;
        return view('frontend.room_booking_mobile',compact('roomTypes','user','ci_key'));
    }

    public function donateOnlineMobile() {
        $fund = Funds::get(['id', 'name']);
        $ardaspurpose = Ardaspurposes::get(['id', 'name']);

        $ENCRYPTION_KEY = env("ENCRYPTION_KEY");
        $INITIALIZATION_VECTOR = env("INITIALIZATION_VECTOR");
        $CIPHER = env("CIPHER");

        $fullUrl = $_SERVER['REQUEST_URI'];
        $queryString = parse_url($fullUrl, PHP_URL_QUERY);
        $key_arr = explode('ci_key=',$queryString);
        $clean_arr_key = array_filter($key_arr, fn($value) => !is_null($value) && $value !== '');
        $ci_key = (isset($clean_arr_key[1])) ? $clean_arr_key[1] : '';
       
        $decrypted_data = openssl_decrypt($ci_key, $CIPHER, $ENCRYPTION_KEY, 0, $INITIALIZATION_VECTOR);
        $user_arr = explode('#',$decrypted_data);
        $clean_arr = array_filter($user_arr, fn($value) => !is_null($value) && $value !== '');
        
        $user = '';
        $ac_token = '';
        if(!empty($clean_arr)) {
            $secret_key = (isset($clean_arr[0])) ? $clean_arr[0] :'';
            $mobile_no = (isset($clean_arr[1])) ? $clean_arr[1] : '';
            $user_id = (isset($clean_arr[2])) ? $clean_arr[2] :'' ;
            $ac_token = (isset($clean_arr[3])) ? $clean_arr[3] :'' ;
            if(isset($user_id) && !empty($user_id)) {
                $user  = User::where('id',$user_id)->first();
            }
        }
        return view('frontend.donate_online_mobile', compact('fund','ardaspurpose','user','ci_key'));
    }



    function searchRoomBooking(Request $request) {

        $validator = Validator::make($request->all(), [
            'room_type' => 'required|exists:room_types,id',
            'date' => 'required|string',
            'rooms' => 'required|integer|gt:0',
            'ac_and_non_ac' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()]);
        }
      

        $date = explode('-', $request->date);

        $request->merge([
            'checkin_date'  => trim(@$date[0]),
            'checkout_date' => trim(@$date[1]),
        ]);

        $validator = Validator::make($request->all(), [
            'checkin_date'  => 'required|date_format:m/d/Y|after:yesterday',
            'checkout_date' => 'required|date_format:m/d/Y|after:checkin_date',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()]);
        }

        $view = $this->getRooms($request);
      
        return response()->json(['html' => $view]);
    }

    public function getRooms(Request $request) {
        $checkIn = Carbon::parse($request->checkin_date);
        $checkOut = $request->checkout_date ? Carbon::parse($request->checkout_date) : $checkIn;
        $ac_and_non_ac = $request->ac_and_non_ac;

        if($request->room_type_category == 'Hall') {
            $rooms = Hall::active()
            ->where('room_type_id', $request->room_type)
            ->where(function ($query) use ($ac_and_non_ac) {
                if($ac_and_non_ac == 'AC' || $ac_and_non_ac == 'NON-AC') {
                    $query->where('hall_type', $ac_and_non_ac);
                } else {
                    return $query;
                }
            })
            ->with([
                'booked' => function ($q) {
                    $q->active();
                },
                'roomType' => function ($q) {
                    $q->select('id', 'name', 'hallfare_night as fare');
                }
            ])
            ->get();

            if (count($rooms) < $request->rooms) {
                return ['error' => ['The requested number of Halls is not available for the selected date']];
            }

            $numberOfRooms = $request->rooms;
            $requestUnitFare = $request->unit_fare;
            $hall = "Hall"; 

            return view('frontend.partials.rooms', compact('checkIn', 'checkOut', 'rooms', 'numberOfRooms', 'requestUnitFare','hall'))->render();
        }
        
        
        $rooms = Room::active()
            ->where('room_type_id', $request->room_type)
            ->where(function ($query) use ($ac_and_non_ac) {
                if($ac_and_non_ac == 'AC' || $ac_and_non_ac == 'NON-AC') {
                    $query->where('roomtype', $ac_and_non_ac);
                } else {
                    return $query;
                }
            })
            ->with([
                'booked' => function ($q) {
                    $q->active();
                },
                'roomType' => function ($q) {
                    $q->select('id', 'name', 'fare');
                }
            ])
            ->get();

        if (count($rooms) < $request->rooms) {
            return ['error' => ['The requested number of rooms is not available for the selected date']];
        }

        $numberOfRooms = $request->rooms;
        $requestUnitFare = $request->unit_fare;
        
      
        return view('frontend.partials.rooms', compact('checkIn', 'checkOut', 'rooms', 'numberOfRooms', 'requestUnitFare'))->render();
    }

    public function book(Request $request) {
        
        
        $validator = Validator::make($request->all(), [
            'room_type'    => 'required|integer|gt:0',
            'name'            => 'required',
            //'email'           => 'nullable|email',
            'mobile'          => 'required|regex:/^([0-9]*)$/',
            'address'         => 'required|string',
           // 'payment_type'    => 'nullable|required_if:guest_type,0|string',
           // 'security_deposit' =>'nullable|required_if:guest_type,0|string',
            'aadhar_pan'      => 'required|string',
            'room'            => 'required|array',
            'paid_amount'     => 'nullable|numeric|gte:0'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()]);
        }

        $booking_user_id = (isset($request->booking_user_id) && !empty($request->booking_user_id)) ? $request->booking_user_id : 0;
        $booking_token = (isset($request->booking_token) && !empty($request->booking_token)) ? $request->booking_token : '';
        
        $booking_record = Booking::where('booking_token', $booking_token)->first();
        if(!empty($booking_record) && !empty($booking_user_id)) {
            return response()->json(['error' => 'Invalid URL']);
        }
       
        $guest = [];
        $guest['name'] = $request->name;
        $guest['mobile'] = $request->mobile;
        $guest['email'] = $request->email;
        $guest['country'] = $request->country;
        $guest['state'] = $request->state;
        $guest['city'] = $request->city;     
        $guest['pin'] = $request->pin;
        $guest['aadhar_pan']   =$request->aadhar_pan;
        $guest['address'] = $request->address;

        $bookedRoomData = [];
        $totalFare      = 0;
        $tax            = gs('tax');

        if($request->room_type_category == "Hall"){
            foreach ($request->room as $room) {

            $data      = [];
            $roomId    = explode('-', $room)[0];
            $bookedFor = explode('-', $room)[1];
            $isBooked  = BookedHall::where('hall_id', $roomId)->where('booked_for', $bookedFor)->exists();
            if ($isBooked) {
                return response()->json(['error' => 'Hall has been booked']);
            }

            $room = Hall::with('roomType')->find($roomId);

            if ($request->room_type != @$room->roomType->id) {
                return response()->json(['error' => 'Invalid room type selected']);
            }

            $data['booking_id']       = 0;
            $data['room_type_id']     = $request->room_type;
            $data['hall_id']          = $room->id;
            $data['booked_for']       = Carbon::parse($bookedFor)->format('Y-m-d');
            $data['fare']             = $room->hall_fare;
            $data['tax_charge']       = $room->hall_fare * $tax / 100;
            $data['cancellation_fee'] = $room->roomType->cancellation_fee;
            $data['status']           = Status::ROOM_ACTIVE;
            $data['created_at']       = now();
            $data['updated_at']       = now();
            $bookedRoomData[] = $data;

            $totalFare += $room->hall_fare;

         }

         $taxCharge = $totalFare * $tax / 100;

         if ($request->paid_amount && $request->paid_amount < $totalFare + $taxCharge) {
             return response()->json(['error' => 'Paying amount can\'t be greater than total amount']);
         }
        
         if ($request->payment_type === 'online' || $request->payment_type === 'card'){
             if (!isset($request->transaction_id) || empty($request->transaction_id)) {
                 return response()->json(['error' => 'Transaction ID is required.']); 
             }
         }
        
         $shift_id = 0;
         $payment_type = 'online';
         $transaction_id = ($payment_type === 'cash') ? 0: sha1(md5(time())); 
         $payment_narration="Booking Amount";
         $security_deposit = $request->security_deposit ? $request->security_deposit : 450;


        
         $booking                 = new Booking();
         $booking->booking_number = getTrx();
         $booking->booking_type   = 'hall';
         $booking->shift_id       = $shift_id;
         $booking->user_id        = $booking_user_id;
         $booking->guest_details  = $guest;
         $booking->tax_charge     = $taxCharge;
         $booking->booking_fare   = $totalFare;
         $booking->security_deposit = $security_deposit;
         $booking->payment_type   = $payment_type;
         $booking->paid_amount    = $request->paid_amount ?? 0;
         $booking->status         = Status::BOOKING_ACTIVE;
         $booking->booking_token   = $booking_token;
         $booking->save();

      
 
         if ($request->paid_amount) {
             $booking->createPaymentLogforbookingpage($booking->paid_amount,'RECEIVED',true,$booking->payment_type, $transaction_id,$payment_narration);
         }
 
 
 
         foreach ($bookedRoomData as $key => $bookedRoom) {
             $bookedRoomData[$key]['booking_id'] = $booking->id;
         }
         BookedHall::insert($bookedRoomData);
 
         $checkIn  = BookedHall::where('booking_id', $booking->id)->min('booked_for');
         $checkout = BookedHall::where('booking_id', $booking->id)->max('booked_for');
 
         $booking->check_in = $checkIn;
         $booking->check_out = Carbon::parse($checkout)->addDay()->toDateString();
         $booking->save();
 
         return response()->json(['success' => 'Hall booked successfully']);

        }

        if($request->room_type_category == "Room"){

            foreach ($request->room as $room) {
                $data      = [];
                $roomId    = explode('-', $room)[0];
                $bookedFor = explode('-', $room)[1];
                $isBooked  = BookedRoom::where('room_id', $roomId)->where('booked_for', $bookedFor)->exists();
                if ($isBooked) {
                    return response()->json(['error' => 'Room has been booked']);
                }
    
                $room = Room::with('roomType')->find($roomId);
    
                if ($request->room_type != @$room->roomType->id) {
                    return response()->json(['error' => 'Invalid room type selected']);
                }
    
                $data['booking_id']       = 0;
                $data['room_type_id']     = $request->room_type;
                $data['room_id']          = $room->id;
                $data['booked_for']       = Carbon::parse($bookedFor)->format('Y-m-d');
                $data['fare']             = $room->room_fare;
                $data['tax_charge']       = $room->room_fare * $tax / 100;
                $data['cancellation_fee'] = $room->roomType->cancellation_fee;
                $data['status']           = Status::ROOM_ACTIVE;
                $data['created_at']       = now();
                $data['updated_at']       = now();
                $bookedRoomData[] = $data;
    
                $totalFare += $room->room_fare;
            }
          
            $taxCharge = $totalFare * $tax / 100;
            if ($request->paid_amount && $request->paid_amount < $totalFare + $taxCharge) {
                return response()->json(['error' => 'Paying amount can\'t be greater than total amount']);
            }
           
            if ($request->payment_type === 'online' || $request->payment_type === 'card'){
                if (!isset($request->transaction_id) || empty($request->transaction_id)) {
                    return response()->json(['error' => 'Transaction ID is required.']); 
                }
            }
          
            $payment_type = 'online';
            $transaction_id = ($payment_type === 'cash') ? 0: sha1(md5(time())); 
            $shift_id = 0;
            $security_deposit = $request->security_deposit ? $request->security_deposit : 450;
    
            $payment_narration="Booking Amount";
          
            
            $booking                    = new Booking();
            $booking->booking_number    = getTrx();
            $booking->user_id           = $booking_user_id;
            $booking->guest_details     = $guest;
            $booking->shift_id          = $shift_id;
            $booking->tax_charge        = $taxCharge;
            $booking->booking_fare      = $totalFare;
            $booking->security_deposit  = $security_deposit;
            $booking->payment_type      = $payment_type;
            $booking->paid_amount       = $request->paid_amount ?? 0;
            $booking->status            = Status::BOOKING_ACTIVE;
            $booking->booking_token     = $booking_token;
            $booking->save();


            
           
            if ($request->paid_amount) {
                $booking->createPaymentLogforbookingpage($booking->paid_amount,'RECEIVED',true, $booking->payment_type, $transaction_id,$payment_narration);
            }
           
           
            foreach ($bookedRoomData as $key => $bookedRoom) {
                $bookedRoomData[$key]['booking_id'] = $booking->id;
            }
          
            
            BookedRoom::insert($bookedRoomData);
    
            $checkIn  = BookedRoom::where('booking_id', $booking->id)->min('booked_for');
            $checkout = BookedRoom::where('booking_id', $booking->id)->max('booked_for');
    
            $booking->check_in = $checkIn;
            $booking->check_out = Carbon::parse($checkout)->addDay()->toDateString();
            $booking->save();
           
            return response()->json(['success' => 'Room booked successfully']);
        }
    }
    public function termsandconditionsmobile(){
        $conditions = Termsandcondition::first();
        return view('frontend.terms_and_conditions_mobile', compact('conditions'));
    }
    public function faq(){
        $faqs = Faq::Active()->get();
        return view('frontend.faq', compact('faqs'));
    }

    public function faqmobile(){
        $faqs = Faq::Active()->get();
        return view('frontend.faq_mobile', compact('faqs'));
    }
    public function bankdetails_mobile(){
        return view('frontend.bankdetails_mobile');
    }
    public function cancellationpolicy_mobile(){
        return view('frontend.cancellation_policy_mobile');
    }
    public function termsandconditions(){
        $conditionss = Termsandcondition::first();
    

        return view('frontend.terms_and_conditions', compact('conditionss'));
    }
    public function privacypolicy(){
        return view('frontend.privacy_policy');
    }
    public function privacypolicymobile(){
        return view('frontend.privacy_policy_mobile');
    }
    public function boardMember(){
        return view('frontend.board_member');
    }

    public function patthBooking(){
        $ardaspurpose = Ardaspurposes::get(['id', 'name']);
        $patths = patths::get(['id', 'patth_name']);
        return view('frontend.patth_booking', compact('ardaspurpose','patths'));
    }

    public function patthBookingMobile(){
        $ardaspurpose = Ardaspurposes::get(['id', 'name']);
        $patths = patths::get(['id', 'patth_name']);


        $ENCRYPTION_KEY = env("ENCRYPTION_KEY");
        $INITIALIZATION_VECTOR = env("INITIALIZATION_VECTOR");
        $CIPHER = env("CIPHER");

        $fullUrl = $_SERVER['REQUEST_URI'];
        $queryString = parse_url($fullUrl, PHP_URL_QUERY);
        $key_arr = explode('ci_key=',$queryString);
        $clean_arr_key = array_filter($key_arr, fn($value) => !is_null($value) && $value !== '');
        $ci_key = (isset($clean_arr_key[1])) ? $clean_arr_key[1] : '';
        $decrypted_data = openssl_decrypt($ci_key, $CIPHER, $ENCRYPTION_KEY, 0, $INITIALIZATION_VECTOR);
        $user_arr = explode('#',$decrypted_data);
        $clean_arr = array_filter($user_arr, fn($value) => !is_null($value) && $value !== '');
        
        $user = '';
        $ac_token = '';
        if(!empty($clean_arr)) {
            $secret_key = (isset($clean_arr[0])) ? $clean_arr[0] :'';
            $mobile_no = (isset($clean_arr[1])) ? $clean_arr[1] : '';
            $user_id = (isset($clean_arr[2])) ? $clean_arr[2] :'' ;
            $ac_token = (isset($clean_arr[3])) ? $clean_arr[3] :'' ;
            if(isset($user_id) && !empty($user_id)) {
                $user  = User::where('id',$user_id)->first();
            }
        }

        return view('frontend.patth_booking_mobile', compact('ardaspurpose','patths','user','ci_key'));
    }


    public function gallery(){
        $gallerys = Gallery::active()->groupby('title')->get();
        $galleryItems = Gallery::active()->get();
        
        foreach ($gallerys as $gallery) {
            foreach ($galleryItems as $key => $galleryItem) {
                if ($gallery->title == $galleryItem->title) {
                    $galleryItem->filter_id = $gallery->id; 
                    
                }
            }
        }

        return view('frontend.gallery',compact('galleryItems','gallerys'));
    }

    public function gallerymobile (){
        $gallerys = Gallery::active()->groupby('title')->get();
        $galleryItems = Gallery::active()->get();
        
        foreach ($gallerys as $gallery) {
            foreach ($galleryItems as $key => $galleryItem) {
                if ($gallery->title == $galleryItem->title) {
                    $galleryItem->filter_id = $gallery->id; 
                    
                }
            }
        }

        return view('frontend.gallery_mobile',compact('galleryItems','gallerys'));
    }
    public function news(){
        $news = News::active()->get();
        return view('frontend.viewallnews',compact('news'));
    }
    public function threesixty_tour(){
        return view('frontend.threesixty_tour');
    }

    public function tender(){
        $tenderdata = Tender::active()->get();
        

        return view('frontend.tender',compact('tenderdata'));
    }
    public function newProposedProject(){
        $new_proposeddata = New_proposed::active()->first();

        return view('frontend.new_proposed_project',compact('new_proposeddata'));
    }

    public function contact(){
        $contactusdata = Contactus::Active()->get();
        return view('frontend.contact',compact('contactusdata'));
    }

    public function contactmobile(){
        $contactusdata = Contactus::Active()->get();
        return view('frontend.contact_mobile',compact('contactusdata'));
    }
    public function allEvent(){
        $events = Event::join('room_types', 'events.room_type_id', '=', 'room_types.id')
        ->select('events.*', 'room_types.name as complexname')
        ->where('events.status', 1)
        ->get();
        return view('frontend.view_allevent',compact('events'));
    }

    public function bookRoomFromLink($bookingId) {
        $booking = LinkBookingRequest::where('code',$bookingId)->first();
        if($booking) {
            $then = Carbon::createFromFormat('Y-m-d H:i:s', $booking->created_at);
            if($then->addMinutes(10)->isPast()) {
                $link_expire = true;
            } else {
                $link_expire = false;
            }
        } else {
            $link_expire = true;
        }
        
        return view('frontend.book_room_via_link',compact('booking','link_expire','bookingId')); 
    }

    public function bookRoomSuccess($bookingId) {
        $bookingData = Booking::where('booking_number',$bookingId)->first();
        $booking_date ='';
        if($bookingData){
            $created_at = $bookingData->created_at;
            $booking_date = Carbon::parse($created_at)->format('d M,Y');
        }
        return view('frontend.book_room_success',compact('bookingData','booking_date')); 
    }

    public function bookRoomPaymentSuccess(Request $request) {

        $link_booking =  LinkBookingRequest::where('code',$request->bookingId)->first();
      
        if ($link_booking) {
            $tax            = gs('tax');

            if($link_booking->booking_type == "hall"){
                $bookingIds = explode(',', $link_booking->room_id);
               
                foreach ($bookingIds as $room) {
                $roomId    = explode('-', $room)[0];
                $bookedFor = explode('-', $room)[1];
                
                $data      = [];
                $hallData = Hall::with('roomType')->find($roomId);
    
                $data['booking_id']       = 0;
                $data['room_type_id']     = $hallData->room_type_id;
                $data['hall_id']          = $roomId;
                $data['booked_for']       = Carbon::parse($bookedFor)->format('Y-m-d');
                $data['fare']             = $hallData->hall_fare;
                $data['tax_charge']       = $hallData->hall_fare * $tax / 100;
                $data['cancellation_fee'] = $hallData->roomType->cancellation_fee;
                $data['status']           = Status::ROOM_ACTIVE;
                $data['created_at']       = now();
                $data['updated_at']       = now();
                $bookedRoomData[] = $data;
    
    
             }
    
              
                if ($link_booking->admin_id) {
                    $admin  = Admin::where('id',$link_booking->admin_id)->first();
                    if (!empty($admin) && $admin->role_id == 2) {
                        $shift_id = 0;
                    } else {
                        $shifcollection = ShiftCollectionDetail::where('room_type_id',$link_booking->room_type_id)->where('admin_id',$link_booking->admin_id)->where('status',0)->first();
                        $shift_id = $shifcollection->id;
                    }
                }else{
                    $shift_id = 0;
                }
            
                $payment_narration="Booking Amount";
                $payment_type ='link';
                $transaction_id = ($payment_type === 'link') ? 0: $request->transaction_id; 
                
                $booking                 = new Booking();
                $booking->booking_number = getTrx();
                $booking->booking_type   = 'hall';
                $booking->shift_id       = $shift_id;
                $booking->user_id        = 0;
                $booking->guest_details  = $link_booking->guest_details;
                $booking->tax_charge     = $link_booking->tax_charge;
                $booking->booking_fare   = $link_booking->booking_fare;
                $booking->security_deposit = $link_booking->security_deposit;
                $booking->payment_type   = $payment_type;
                $booking->paid_amount    = $link_booking->paid_amount ?? 0;
                $booking->status         = Status::BOOKING_ACTIVE;
                $booking->save();
        
                if ($link_booking->paid_amount) {
                    $booking->createPaymentLogforbookingpage($booking->paid_amount,'RECEIVED',false,$booking->payment_type, $transaction_id,$payment_narration);
                }
                
                $booking->createActionHistory('book_room');
        
                foreach ($bookedRoomData as $key => $bookedRoom) {
                    $bookedRoomData[$key]['booking_id'] = $booking->id;
                }
                BookedHall::insert($bookedRoomData);
        
                $booking->check_in =  $link_booking->check_in;
                $booking->check_out = $link_booking->check_out;
                $booking->save();

                $link_booking->delete();

                foreach ($bookingIds as $roomId) {
                    Hall::changeStatus($roomId);
                }
                return response()->json(['success' => 'Hall booked successfully','bookingId'=> $booking->booking_number]);
            }

            if($link_booking->booking_type == "room"){

                $bookingIds = explode(',', $link_booking->room_id);
                
                
                foreach ($bookingIds as $room) {
                    $roomId    = explode('-', $room)[0];
                    $bookedFor = explode('-', $room)[1];
                    $data      = [];
                   
                    $roomData = Room::with('roomType')->find($roomId);
        
                    $data['booking_id']       = 0;
                    $data['room_type_id']     = $link_booking->room_type_id;
                    $data['room_id']          = $roomId;
                    $data['booked_for']       = Carbon::parse($bookedFor)->format('Y-m-d');
                    $data['fare']             = $roomData->room_fare;
                    $data['tax_charge']       = $roomData->room_fare * $tax / 100;
                    $data['cancellation_fee'] = $roomData->roomType->cancellation_fee;
                    $data['status']           = Status::ROOM_ACTIVE;
                    $data['created_at']       = now();
                    $data['updated_at']       = now();
                    $bookedRoomData[] = $data;
        
                }
                
        
                if ($link_booking->admin_id) {
                    $admin  = Admin::where('id',$link_booking->admin_id)->first();
                    if (!empty($admin) && $admin->role_id == 2) {
                        $shift_id = 0;
                    } else {
                        $shifcollection = ShiftCollectionDetail::where('room_type_id',$link_booking->room_type_id)->where('admin_id',$link_booking->admin_id)->where('status',0)->first();
                        $shift_id = $shifcollection->id;
                    }
                } else {
                    $shift_id = 0;
                }
        
                $payment_narration="Booking Amount";
                $payment_type ='link';
                $transaction_id = ($payment_type === 'link') ? 0: $request->transaction_id; 

                $booking                   = new Booking();
                $booking->booking_number   = getTrx();
                $booking->user_id          = 0;
                $booking->guest_details    = $link_booking->guest_details;
                $booking->shift_id         = $shift_id;
                $booking->tax_charge       = $link_booking->tax_charge;
                $booking->booking_fare     = $link_booking->booking_fare;
                $booking->security_deposit = $link_booking->security_deposit;
                $booking->payment_type     = $payment_type;
                $booking->paid_amount      = $link_booking->paid_amount ?? 0;
                $booking->status           = Status::BOOKING_ACTIVE;
                $booking->save();
        
        
                if ($link_booking->paid_amount) {
        
                    $booking->createPaymentLogforbookingpage($booking->paid_amount,'RECEIVED',0, $booking->payment_type, $transaction_id,$payment_narration);
                }
        
        
                $booking->createActionHistory('book_room');
        
                foreach ($bookedRoomData as $key => $bookedRoom) {
                    $bookedRoomData[$key]['booking_id'] = $booking->id;
                }
                BookedRoom::insert($bookedRoomData);
        
                $booking->check_in =  $link_booking->check_in;
                $booking->check_out = $link_booking->check_out;
                $booking->save();

                $link_booking->delete();

                foreach ($bookingIds as $roomId) {
                    Room::changeStatus($roomId);
                }
        
                return response()->json(['success' => 'Room booked successfully','bookingId'=> $booking->booking_number]);
            }
            
        }
        
    }





    
    
    public function donationsave(Request $request)
    {
        $validatedData = Validator::make($request->all(),[
            //'donation_receipt_no' => 'required|string',
            'devotee_name' => 'required|string',
            'address' => 'required|string',
            'city' => 'nullable|string',
            'state' => 'nullable|string',
            'country' => 'required|string',
            'postal_code' => 'required|string',
            'email' => 'nullable|email',
            'phone_number' => 'required|string',
            'amount' => 'required|numeric',
            'payment_type' => 'required|string',
            'ardas_purpose_id' => 'required|integer',
            'fund_id' => 'required|integer',
        ]);

        if ($validatedData->fails()) {
            return redirect()->back()->withErrors($validatedData)->withInput();
        }
        // if ($request->payment_type === 'card' || $request->payment_type === 'googlepay_phonepay') {
        //     if (!isset($request->transaction_id) || empty($request->transaction_id)) {
        //         $notify[] = ['error', 'Transaction ID is required.'];
        //         return back()->withNotify($notify)->withInput();
        //     }
        // } elseif ($request->payment_type === 'dd') {
        //     if (!isset($request->dd_cheque_no) || empty($request->dd_cheque_no)) {
        //         $notify[] = ['error', 'DD/Cheque No is required.'];
        //         return back()->withNotify($notify)->withInput();
        //     }
        // }   
      

        $transaction_id = 0;
        $dd_cheque_no = 0;
        
        if ($request->payment_type === 'cash') {
            $transaction_id = 0;
            $dd_cheque_no = 0;
        } elseif ($request->payment_type === 'card' || $request->payment_type === 'googlepay_phonepay') {
            $transaction_id = $request->transaction_id;
            $dd_cheque_no = 0;
        } elseif ($request->payment_type === 'dd') {
            $transaction_id = 0;
            $dd_cheque_no = $request->dd_cheque_no;
        }
        $shift_id=0;
        $donation_user_id = (isset($request->donation_user_id) && !empty($request->donation_user_id)) ? $request->donation_user_id : 0;
        $donation_token = (isset($request->donation_token) && !empty($request->donation_token)) ? $request->donation_token : '';

        $donation_record = Donation::where('donation_token', $donation_token)->first();
        if(!empty($donation_record)) {
            $notify[] = ['error', 'Invalid URL'];
            return back()->withNotify($notify);
        }

        $donation = new Donation();
        $donation->shift_id = $shift_id;
        $donation->user_id = $donation_user_id;
        $donation->donation_receipt_no = $request->donation_receipt_no;
        $donation->devotee_name = $request->devotee_name;
        $donation->address      = $request->address;
        $donation->city         = $request->city;
        $donation->state        = $request->state;
        $donation->country      = $request->country;
        $donation->postal_code  = $request->postal_code;
        $donation->email        = $request->email;
        $donation->phone_number = $request->phone_number;
        $donation->ardas_purpose_id = $request->ardas_purpose_id;
        $donation->fund_id          = $request->fund_id;
        $donation->amount        = $request->amount;
        $donation->payment_type = $request->payment_type;
        $donation->transaction_id  =$transaction_id;
        $donation->dd_cheque_no   = $dd_cheque_no;
        $donation->donation_token   = $donation_token;
        $donation->admin_id        =  auth('admin')->user()->id?? 0;
        $donation->save();

        $notify[] = ['success', 'Donation saved successfully'];
        if(!empty($donation_token) && !empty($donation_user_id)) {
            return redirect()->back()->withNotify($notify);
        } else {
            return redirect()->route('donateOnline')->withNotify($notify);
        }
    }


    public function savePathBooking(Request $request)
    {

        $validatedData = Validator::make($request->all(),[
            'devotee_name' => 'required|string',
            'address' => 'required|string',
            'city' => 'nullable|string',
            'state' => 'nullable|string',
            'country' => 'required|string',
            'postal_code' => 'required|string',
            'email' => 'nullable|email',
            'phone_number' => 'required|string',
            'amount' => 'required|numeric',
            'payment_type' => 'required|string',
            'ardas_purpose_id' => 'required|integer',
            'patth_id' => 'required|integer',
            'funds' => 'nullable|string',

        ]);
        
    
        if ($validatedData->fails()) {
            return redirect()->back()->withErrors($validatedData)->withInput();
        }
        
        // if ($request->payment_type === 'card' || $request->payment_type === 'googlepay_phonepay') {
        //     if (!isset($request->transaction_id) || empty($request->transaction_id)) {
        //         $notify[] = ['error', 'Transaction ID is required.'];
        //         return back()->withNotify($notify)->withInput();
        //     }
        // } elseif ($request->payment_type === 'dd') {
        //     if (!isset($request->dd_cheque_no) || empty($request->dd_cheque_no)) {
        //         $notify[] = ['error', 'DD/Cheque No is required.'];
        //         return back()->withNotify($notify)->withInput();
        //     }
        // }   

        $transaction_id = 0;
        $dd_cheque_no = 0;
        
        if ($request->payment_type === 'cash') {
            $transaction_id = 0;
            $dd_cheque_no = 0;
        } elseif ($request->payment_type === 'card' || $request->payment_type === 'googlepay_phonepay') {
            $transaction_id = $request->transaction_id;
            $dd_cheque_no = 0;
        } elseif ($request->payment_type === 'dd') {
            $transaction_id = 0;
            $dd_cheque_no = $request->dd_cheque_no;
        }
        $path_user_id = (isset($request->path_user_id) && !empty($request->path_user_id)) ? $request->path_user_id : 0;
        $path_token = (isset($request->path_token) && !empty($request->path_token)) ? $request->path_token : '';

        $path_record = patthbookings::where('path_token', $path_token)->first();
        if(!empty($path_record)) {
            $notify[] = ['error', 'Invalid URL'];
            return back()->withNotify($notify);
        }

        $shift_id=0;
        $patthBookings = new patthbookings();
        $patthBookings->shift_id     = $shift_id;
        $patthBookings->patth_id     = $request->patth_id;
        $patthBookings->user_id      = $request->path_user_id;
        $patthBookings->path_token   = $request->path_token;
        $patthBookings->devotee_name = $request->devotee_name;
        $patthBookings->address      = $request->address;
        $patthBookings->city         = $request->city;
        $patthBookings->state        = $request->state;
        $patthBookings->country      = $request->country;
        $patthBookings->postal_code  = $request->postal_code;
        $patthBookings->email        = $request->email;
        $patthBookings->phone_number = $request->phone_number;
        $patthBookings->ardas_purpose_id = $request->ardas_purpose_id;
        $patthBookings->funds = $request->funds;
        $patthBookings->ardass_remark    = $request->ardass_remark;
        $patthBookings->amount        = $request->amount;
        $patthBookings->payment_type = $request->payment_type;
        $patthBookings->transaction_id  =$transaction_id;
        $patthBookings->dd_cheque_no   = $dd_cheque_no;
        $patthBookings->admin_id        =  auth('admin')->user()->id?? 0;

        $patthBookings->save();

        $notify[] = ['success', 'Patth booking saved successfully'];
        if(!empty($path_user_id) && !empty($path_token)) {
            return redirect()->back()->withNotify($notify);
        } else {
            return redirect()->route('patthBooking')->withNotify($notify);
        }
       
    }

    public function getBalance($patths)
    {
        $Balance = patths::where('id', $patths)->value('amount');
        return response()->json($Balance);
    }

}
