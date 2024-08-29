<?php

namespace App\Http\Controllers\Hotels;

use App\Http\Controllers\Controller;
use App\Models\Hotel;
use App\Models\Country;
use App\Models\CountryState;
use App\Models\HotelRoom;
use App\Models\HotelImage;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\HotelRoomService;
use App\Models\LongWeekend;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class HotelController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $cities       = Hotel::select('city')->distinct('city')->get();
        $states       = CountryState::get(['id', 'state']);
        $hotels  = Hotel::latest();
        $filter_name = $request->filter_name;
        $filter_state = $request->filter_state;
        $filter_rating = $request->filter_rating;
        $filter_city = $request->filter_city;

        if (isset($filter_name)) {
            $hotels = $hotels->where('name', 'LIKE', '%' . $filter_name . '%');
        }

        if (isset($filter_state)) {
            $hotels = $hotels->where('state', 'LIKE', '%' . $filter_state . '%');
        }

        if (isset($filter_city)) {
            $hotels = $hotels->where('city', 'LIKE', '%' . $filter_city . '%');
        }

        if (isset($filter_rating)) {
            $hotels = $hotels->where('rating', $filter_rating);
        }

        $hotels  = $hotels->get();       
        return view('hotels.list', compact('hotels', 'states', 'cities', 'filter_name', 'filter_state', 'filter_city', 'filter_rating'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $countries = Country::get('country');
        return view('hotels.create', compact('countries'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name'      => 'required',
            'person'    => 'required',
            'phone'     => 'required',
            'rating'    => 'required',
            'status'    => 'required',
            'address'   => 'required',
        ]);

        $hotel          = new Hotel;
        $hotel->name    = $request->name;
        $hotel->email   = $request->email;
        $hotel->person  = $request->person;
        $hotel->phone   = $request->phone;
        $hotel->state   = $request->state;
        $hotel->state   = $request->state;
        $hotel->country = $request->country;
        $hotel->rating  = $request->rating;
        $hotel->status  = $request->status;
        $hotel->address = $request->address;
        $hotel->save();

        // Save Hotel Images
        if ($request->hasfile('images')) {
            foreach ($request->file('images') as $image) {
                $name = $image->getClientOriginalName();
                $image->storeAs('uploads/hotels/' . $hotel->id . '/', $name, 'public');
                $hotel->images()->create([
                    'image' => $name
                ]);
            }
        }

        return redirect()->route('hotels.index')->with('success', 'Hotel created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $hotel  = Hotel::find($id);
        $hotel->load('images', 'rooms', 'rooms.services');
        foreach ($hotel->images as $image) {
            $image->path = asset('storage/uploads/hotels/' . $id . '/' . $image->image);
        }
        return view('hotels.show', compact('hotel'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $countries = Country::get('country');
        $hotel  = Hotel::find($id);
        $states = CountryState::where('country',$hotel->country)->get('state');
        $hotel->load('images');
        foreach ($hotel->images as $image) {
            $image->path = asset('storage/uploads/hotels/' . $id . '/' . $image->image);
        }
        return view('hotels.edit', compact('states', 'hotel','countries'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name'      => 'required',
            'person'    => 'required',
            'phone'     => 'required',
            'rating'    => 'required',
            'status'    => 'required',
            'address'   => 'required',
        ]);

        $hotel          = Hotel::find($id);
        $hotel->name    = $request->name;
        $hotel->email   = $request->email;
        $hotel->person  = $request->person;
        $hotel->phone   = $request->phone;
        $hotel->state   = $request->state;
        $hotel->city    = $request->city;
        $hotel->country = $request->country;
        $hotel->rating  = $request->rating;
        $hotel->status  = $request->status;
        $hotel->address = $request->address;
        $hotel->save();

        // Save Hotel Images
        if ($request->hasfile('images')) {
            foreach ($request->file('images') as $image) {
                $name = $image->getClientOriginalName();
                $image->storeAs('uploads/hotels/' . $hotel->id . '/', $name, 'public');
                $hotel->images()->create([
                    'image' => $name
                ]);
            }
        }

        return redirect()->route('hotels.index')->with('success', 'Hotel updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        HotelImage::where('hotel_id', $id)->delete();
        HotelRoom::where('hotel_id', $id)->delete();
        HotelRoomService::where('hotel_id', $id)->delete();
        Hotel::find($id)->delete();
        return redirect()->route('hotels.index')->with('success', 'Hotel deleted successfully');
    }

    public function deleteImage($id)
    {
        HotelImage::where('id', $id)->delete();
        return redirect()->back()->with('success', 'Hotel Image deleted successfully');
    }

    public function downloadImages($id)
    {
        $hotel = Hotel::find($id)->load('images');
        foreach ($hotel->images as $image) {
            $image->image_url = asset('storage/uploads/hotels/' . $id . '/' . $image->image);
        }
        // $pdf = Pdf::loadView('hotels.downloads', compact('hotel'))->setPaper('a4', 'landscape');
        $pdf = Pdf::loadView('hotels.download-images', compact('hotel'))->setPaper('a4', 'landscape');
        return $pdf->download('Images.pdf');
    }


    function getRooms(Request $request)
    {
        $rooms = HotelRoom::where('hotel_id', $request->hotel_id)->get();

        $output = '';
        $output .= '<option>Select Room</option>';
        foreach ($rooms as $room) {
            $output .= '<option value="' . $room->id . '">' . $room->room . '</option>';
        }
        return Response()->json($output);
    }

    function getServices(Request $request)
    {
        $services = HotelRoomService::where('room_id', $request->room_id)->get();

        $output = '';
        $output .= '<option>Select Service</option>';
        foreach ($services as $service) {
            $output .= '<option value="' . $service->id . '">' . $service->service . '</option>';
        }
        return Response()->json($output);
    }

    function getHotels(Request $request)
    {
        $hotels = Hotel::where('city', 'LIKE', '%' . $request->destination . '%')->get();

        $output = '';
        $output .= '<option></option>';
        foreach ($hotels as $hotel) {
            $output .= '<option value="' . $hotel->id . '">' . $hotel->name . '</option>';
        }
        return Response()->json($output);
    }

    // function calculateTotal(Request $request)
    // {

    //     $service        =  HotelRoomService::where('id',$request->service_id)->first();
    //     $room_charge    = $request->room * $service->price;
    //     $bed            = $request->bed;

    //     if($bed == 0){
    //     $total_charges      =  $room_charge * $request->days;
    //     }else{
    //         if($bed == $request->child){
    //             $total_charges     =  ($room_charge + ($service->extra_child_price * $request->child)) * $request->days;
    //         }elseif($bed > $request->child){
    //             $extra_adults = $bed - $request->child;
    //             $total_charges     =  ($room_charge + ($service->extra_child_price * $request->child) + ($service->extra_adult_price * $extra_adults)) * $request->days;
    //         }elseif($bed < $request->child){
    //         $total_charges     =  ($room_charge + ($service->extra_child_price * $bed)) * $request->days;
    //         }
    //     }
    //     return Response()->json($total_charges);
    // }



    function calculateTotal(Request $request)
    {

        $service        = HotelRoomService::where('id', $request->service_id)->first();
        if($request->checkin == $request->checkout){
            $same_date =  true;
        }else{
            $same_date =  false;
        }

        $dates          = $this->generateDateRange(Carbon::parse($request->checkin), Carbon::parse($request->checkout), $same_date);
        $bed            = $request->bed;
        $child          = $request->child;
        $total          = 0;
        $room_charge    = 0;

        foreach($dates as $date){

            $long_weekend_exists = LongWeekend::whereDate('start', '<=', $date)
            ->whereDate('end', '>=', $date)
            ->exists();

            if($long_weekend_exists){
                if($bed == 0){
                    $room_charge    += $request->room * $service->weekend_price;                   
                }else{
                    $room_charge    += $request->room * $service->weekend_price;
                    if($bed == $child){
                        $room_charge     +=  $service->extra_child_weekend_price * $child;
                    }elseif($bed > $child){
                        $extra_adults     = $bed - $child;
                        $room_charge     +=  ($service->extra_child_weekend_price * $child) + ($service->extra_adult_weekend_price * $extra_adults);
                    }elseif($bed < $child){
                        $room_charge     +=  $service->extra_child_weekend_price * $bed;
                    }
                }
            }else{
                if($bed == 0){
                    $room_charge    += $request->room * $service->price;
                }else{
                    $room_charge    += $request->room * $service->price;
                    if($bed == $child){
                        $room_charge     +=  $service->extra_child_price * $child;
                    }elseif($bed > $child){
                        $extra_adults = $bed - $child;
                        $room_charge     +=  ($service->extra_child_price * $child) + ($service->extra_adult_price * $extra_adults);
                    }elseif($bed < $child){
                        $room_charge     +=  $service->extra_child_price * $bed;
                    }
                }
            } 
                        
        }

        $total  = $room_charge;

        
        return Response()->json($total);
    }

    private function generateDateRange($start_date, $end_date , $same_date)
    {
        $dates = [];

        for ($date = $start_date->copy(); $date->lte($end_date); $date->addDay()) {
            $dates[] = $date->format('Y-m-d');
        }

        if(!$same_date){
            $remove = array_pop($dates); 
        }
         

        return $dates;
    }
}
