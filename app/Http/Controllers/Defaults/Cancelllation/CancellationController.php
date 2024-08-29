<?php

namespace App\Http\Controllers\Defaults\Cancelllation;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\EstimateDestination;
use App\Models\BookingCancellationCharges;
use App\Models\CancellationCharges;

class CancellationController extends Controller
{
    public function index(Request $request){

         $type = 'cab';
        if(isset($request->type)){
            $type = $request->type;
        }
        $cab                      = BookingCancellationCharges::with('cancellationcharges')->where('type', 'cab')->first();
        $hotel                      = BookingCancellationCharges::with('cancellationcharges')->where('type', 'hotel')->first();
        $safari                      = BookingCancellationCharges::with('cancellationcharges')->where('type', 'safari')->first();
        $tour                      = BookingCancellationCharges::with('cancellationcharges')->where('type', 'tour')->first();
        $package                      = BookingCancellationCharges::with('cancellationcharges')->where('type', 'package')->first();
        $destinations                = EstimateDestination::all();
       
        return view('defaults.cancellation.list', compact('type','cab','hotel','safari','tour','package','destinations'));
    }
    public function cabStore(Request $request){
         
        $cancellation_exists = BookingCancellationCharges::where('type', 'cab')->exists();
        if($cancellation_exists) {
           $id                = BookingCancellationCharges::where('type', 'cab')->value('id');
           $cancellation           = BookingCancellationCharges::find($id);
            $cancellation->type     = 'cab';
            $cancellation->content  = $request->content;
            $cancellation->save();

            CancellationCharges::Where('booking_cancellation_charge_id',$id)->delete();

        }else{
            $cancellation           = new BookingCancellationCharges;
            $cancellation->type     = 'cab';
            $cancellation->content  = $request->content;
            $cancellation->save();
        }

        if(!empty($request->item) && is_array($request->item)){
            foreach($request->item as $key => $value){
               $item                  = new CancellationCharges;
               $item->booking_cancellation_charge_id      = $cancellation->id;
               $item->min_day      = $value['min_day'];
               $item->max_day      = $value['max_day'];
               $item->charge       = $value['charge'];
               $item->save();
            }
        }  


        return redirect()->route('chancellation-charges.index',['type'=>'cab'])->with('success', 'Cancellation Charges created successfully');
    }
     public function hotelStore(Request $request){
         
        $cancellation_exists = BookingCancellationCharges::where('type', 'hotel')->exists();
        if($cancellation_exists) {
            $id                = BookingCancellationCharges::where('type', 'hotel')->value('id');
            $cancellation           = BookingCancellationCharges::find($id);
            $cancellation->type     = 'hotel';
            $cancellation->content  = $request->content;
            $cancellation->save();

            CancellationCharges::Where('booking_cancellation_charge_id',$id)->delete();

        }else{
            $cancellation           = new BookingCancellationCharges;
            $cancellation->type     = 'hotel';
            $cancellation->content  = $request->content;
            $cancellation->save();
        }

        if(!empty($request->item) && is_array($request->item)){
            foreach($request->item as $key => $value){
               $item               = new CancellationCharges;
               $item->booking_cancellation_charge_id      = $cancellation->id;
               $item->min_day      = $value['min_day'];
               $item->max_day      = $value['max_day'];
               $item->charge       = $value['charge'];
               $item->save();
            }
        }  


        return redirect()->route('chancellation-charges.index',['type'=>'hotel'])->with('success', 'Cancellation Charges created successfully');
    }
    public function safariCreate(Request $request){
       $safari = BookingCancellationCharges::where('type', 'safari')->where('destination', $request->destination)->first();
       $destination = $request->destination;

      return view('defaults.cancellation.safari', compact('safari','destination'));
    }
    public function safariStore(Request $request){
         
        $cancellation_exists = BookingCancellationCharges::where('type', 'safari')->where('destination', $request->destination)->exists();
        if($cancellation_exists) {
            $id                = BookingCancellationCharges::where('type', 'safari')->where('destination', $request->destination)->value('id');
            $cancellation           = BookingCancellationCharges::find($id);
            $cancellation->type     = 'safari';
            $cancellation->content  = $request->content;
            $cancellation->save();

            CancellationCharges::Where('booking_cancellation_charge_id',$id)->delete();

        }else{
            $cancellation           = new BookingCancellationCharges;
            $cancellation->type     = 'safari';
            $cancellation->destination  = $request->destination;
            $cancellation->content  = $request->content;
            $cancellation->save();
        }

        if(!empty($request->item) && is_array($request->item)){
            foreach($request->item as $key => $value){
               $item               = new CancellationCharges;
               $item->booking_cancellation_charge_id      = $cancellation->id;
               $item->min_day      = $value['min_day'];
               $item->max_day      = $value['max_day'];
               $item->charge       = $value['charge'];
               $item->save();
            }
        }  


        return redirect()->route('chancellation-charges.index',['type'=>'safari'])->with('success', 'Cancellation Charges created successfully');
    }
    public function tourCreate(Request $request){

      $tour = BookingCancellationCharges::where('type', 'tour')->where('destination', $request->destination)->first();
      $destination = $request->destination;

      return view('defaults.cancellation.tour', compact('tour','destination'));
    }
    public function tourStore(Request $request){
         
        $cancellation_exists = BookingCancellationCharges::where('type', 'tour')->where('destination', $request->destination)->exists();
        if($cancellation_exists) {
            $id                = BookingCancellationCharges::where('type', 'tour')->where('destination', $request->destination)->value('id');
            $cancellation           = BookingCancellationCharges::find($id);
            $cancellation->type     = 'tour';
            $cancellation->content  = $request->content;
            $cancellation->save();

            CancellationCharges::Where('booking_cancellation_charge_id',$id)->delete();

        }else{
            $cancellation               = new BookingCancellationCharges;
            $cancellation->type         = 'tour';
            $cancellation->destination  = $request->destination;
            $cancellation->content      = $request->content;
            $cancellation->save();
        }

        if(!empty($request->item) && is_array($request->item)){
            foreach($request->item as $key => $value){
               $item               = new CancellationCharges;
               $item->booking_cancellation_charge_id      = $cancellation->id;
               $item->min_day      = $value['min_day'];
               $item->max_day      = $value['max_day'];
               $item->charge       = $value['charge'];
               $item->save();
            }
        }  


        return redirect()->route('chancellation-charges.index',['type'=>'tour'])->with('success', 'Cancellation Charges created successfully');
    }
    public function packageCreate(Request $request){

        $package = BookingCancellationCharges::where('type', 'package')->where('destination', $request->destination)->first();
        $destination = $request->destination;

        return view('defaults.cancellation.package', compact('package','destination'));
    }

    public function packageStore(Request $request){
         
        $cancellation_exists = BookingCancellationCharges::where('type', 'package')->where('destination', $request->destination)->exists();
        if($cancellation_exists) {
            $id                = BookingCancellationCharges::where('type', 'package')->where('destination', $request->destination)->value('id');
            $cancellation           = BookingCancellationCharges::find($id);
            $cancellation->type     = 'package';
            $cancellation->content  = $request->content;
            $cancellation->save();

            CancellationCharges::Where('booking_cancellation_charge_id',$id)->delete();

        }else{
            $cancellation               = new BookingCancellationCharges;
            $cancellation->type         = 'package';
            $cancellation->destination  = $request->destination;
            $cancellation->content      = $request->content;
            $cancellation->save();
        }

        if(!empty($request->item) && is_array($request->item)){
            foreach($request->item as $key => $value){
               $item               = new CancellationCharges;
               $item->booking_cancellation_charge_id      = $cancellation->id;
               $item->min_day      = $value['min_day'];
               $item->max_day      = $value['max_day'];
               $item->charge       = $value['charge'];
               $item->save();
            }
        }  


        return redirect()->route('chancellation-charges.index',['type'=>'package'])->with('success', 'Cancellation Charges created successfully');
    }
}
