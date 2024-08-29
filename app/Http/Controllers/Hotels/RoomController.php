<?php

namespace App\Http\Controllers\Hotels;

use App\Http\Controllers\Controller;
use App\Models\Hotel;
use App\Models\HotelRoom;
use App\Models\HotelRoomService;
use Illuminate\Http\Request;

class RoomController extends Controller
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
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $hotel = Hotel::find($request->id);
        return view('hotels.rooms.create', compact('hotel'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'room' => 'required'
        ]);

        $room = new HotelRoom;
        $room->hotel_id = $request->hotel_id;
        $room->room = $request->room;
        $room->save();

        if(!empty($request->service) && is_array($request->service)){
            foreach($request->service as $key => $value){
                $service                            =  new HotelRoomService;
                $service->room_id                   =  $room->id;
                $service->hotel_id                  =  $request->hotel_id;
                $service->service                   =  $value['service'];
                $service->price                     =  $value['price'];
                $service->extra_adult_price         =  $value['extra_adult_price'];
                $service->extra_child_price         =  $value['extra_child_price'];
                $service->weekend_price             =  $value['weekend_price'];
                $service->extra_adult_weekend_price =  $value['extra_adult_weekend_price'];
                $service->extra_child_weekend_price =  $value['extra_child_weekend_price'];
                $service->save();
            }
        }
        return redirect()->route('rooms.show', $request->hotel_id)->with('success', 'Room created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $hotel = Hotel::find($id)->load('rooms');
        return view('hotels.rooms.list', compact('hotel'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $room = HotelRoom::find($id)->load('services');
        $hotel = Hotel::find($room->hotel_id);
        return view('hotels.rooms.edit', compact('room', 'hotel'));
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
            'room' => 'required'
        ]);

        $room = HotelRoom::find($id);
        $room->hotel_id = $request->hotel_id;
        $room->room = $request->room;
        $room->save();

        $saved_values = HotelRoomService::where('room_id', $id)->pluck('id')->toArray();
        $requested_values =  array();

        if(!empty($request->service) && is_array($request->service)){
            foreach($request->service as $key => $value){

                array_push($requested_values, $value['service_id']);

                if(isset($value['service_id'])){

                    if(in_array($value['service_id'], $saved_values)){

                        $service                            =  HotelRoomService::find($value['service_id']);
                        $service->room_id                   =  $room->id;
                        $service->hotel_id                  =  $room->hotel_id;
                        $service->service                   =  $value['service'];
                        $service->price                     =  $value['price'];
                        $service->extra_adult_price         =  $value['extra_adult_price'];
                        $service->extra_child_price         =  $value['extra_child_price'];
                        $service->weekend_price             =  $value['weekend_price'];
                        $service->extra_adult_weekend_price =  $value['extra_adult_weekend_price'];
                        $service->extra_child_weekend_price =  $value['extra_child_weekend_price'];
                        $service->save();

                    }

                }else{

                    $service                            =  new HotelRoomService;
                    $service->room_id                   =  $room->id;
                    $service->hotel_id                  =  $room->hotel_id;
                    $service->service                   =  $value['service'];
                    $service->price                     =  $value['price'];
                    $service->extra_adult_price         =  $value['extra_adult_price'];
                    $service->extra_child_price         =  $value['extra_child_price'];
                    $service->weekend_price             =  $value['weekend_price'];
                    $service->extra_adult_weekend_price =  $value['extra_adult_weekend_price'];
                    $service->extra_child_weekend_price =  $value['extra_child_weekend_price'];
                    $service->save();

                }

            }

            $values_to_delete = array_diff($saved_values, $requested_values);

            foreach($values_to_delete as $value_to_delete){

             HotelRoomService::find($value_to_delete)->delete();
           }
        }

        return redirect()->route('rooms.show', $room->hotel_id)->with('success', 'Room deleted successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        HotelRoom::where('id', $id)->delete();
        HotelRoomService::where('room_id', $id)->delete();
        return redirect()->back()->with('success', 'Room deleted successfully');
    }
}
