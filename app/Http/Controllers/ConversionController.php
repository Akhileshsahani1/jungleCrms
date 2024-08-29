<?php

namespace App\Http\Controllers;

use App\Models\Estimate;
use Illuminate\Http\Request;

class ConversionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function convert(Request $request)
    {
        $rules = [
            'conversion'          => 'required',
            'type'                => 'required',
        ];

        $messages = [
            'conversion.required'       => 'Please select Conversion Type.',
            'type.required'       => 'Please select Business / Estimate Type.',
        ];

        $this->validate($request, $rules, $messages);
        if($request->conversion == 'estimate'){
            switch ($request->type) {
                case 'cab':
                    return redirect()->route('cab-estimate.convert', $request->lead_id);
                    break;
                case 'hotel':
                    return redirect()->route('hotel-estimate.convert', $request->lead_id);
                    break;
                case 'safari':
                    return redirect()->route('safari-estimate.convert', $request->lead_id);
                    break;
                case 'tour':
                    return redirect()->route('tour-estimate.convert', $request->lead_id);
                    break;
                case 'package':
                    return redirect()->route('package-estimate.convert', $request->lead_id);
                    break;
            }
        }

        if($request->conversion == 'booking'){
            switch ($request->type) {
                case 'cab':
                    return redirect()->route('cab-booking.convert', $request->lead_id);
                    break;
                case 'hotel':
                    return redirect()->route('hotel-booking.convert', $request->lead_id);
                    break;
                case 'safari':
                    return redirect()->route('safari-booking.convert', $request->lead_id);
                    break;
                case 'tour':
                    return redirect()->route('tour-booking.convert', $request->lead_id);
                    break;
                case 'package':
                    return redirect()->route('package-booking.convert', $request->lead_id);
                    break;
            }
        }

        return redirect()->route('leads.index')->with('error', 'Something went wrong.');

    }

    public function convertEstimate($id)
    {
        $estimate = Estimate::find($id);
        switch ($estimate->type) {
            case 'cab':
                return redirect()->route('cab.convert-estimate', $id);
                break;
            case 'hotel':
                return redirect()->route('hotel.convert-estimate', $id);
                break;
            case 'safari':
                return redirect()->route('safari.convert-estimate', $id);
                break;
            case 'tour':
                return redirect()->route('tour.convert-estimate', $id);
                break;
            case 'package':
                return redirect()->route('package.convert-estimate', $id);
                break;
        }


        return redirect()->route('estimates.index')->with('error', 'Something went wrong.');
    }
}
