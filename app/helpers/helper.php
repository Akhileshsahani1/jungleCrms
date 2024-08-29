<?php

use App\Models\Booking;
use App\Models\BookingCab;
use App\Models\BookingHotel;
use App\Models\BookingItem;
use App\Models\BookingSafari;
use App\Models\Estimate;
use App\Models\EstimateCab;
use App\Models\EstimateCabOption;
use App\Models\EstimateSafari;
use App\Models\EstimateHotel;
use App\Models\EstimateHotelDestination;
use App\Models\EstimateHotelDestinationOption;
use App\Models\EstimateHotelOption;
use App\Models\EstimateSafariOption;
use App\Models\EstimateFlight;
use App\Models\EstimateFlightOptions;
use App\Models\Hotel;
use App\Models\HotelRoom;
use App\Models\HotelRoomService;
use App\Models\LongWeekend;
use App\Models\Marquee;
use App\Models\PaymentMode;
use App\Models\Transaction;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Carbon\Carbon;
use Illuminate\Http\Request;

if (!function_exists('getHotelName')) {
    function getHotelName($id)
    {
        $name = Hotel::find($id)->name;
        return $name;
    }
}

if (!function_exists('get_note_by')) {
    function get_note_by($id)
    {
        if($id != 0){
        $name = User::find($id)->name;
        return $name;
        } else{
            return 'Customer';
        }
    }
}

if (!function_exists('AmountInWords')) {
    function AmountInWords(float $amount)
    {
        $amount_after_decimal = round($amount - ($num = floor($amount)), 2) * 100;
        // Check if there is any number after decimal
        $amt_hundred = null;
        $count_length = strlen($num);
        $x = 0;
        $string = array();
        $change_words = array(
            0 => '', 1 => 'One', 2 => 'Two',
            3 => 'Three', 4 => 'Four', 5 => 'Five', 6 => 'Six',
            7 => 'Seven', 8 => 'Eight', 9 => 'Nine',
            10 => 'Ten', 11 => 'Eleven', 12 => 'Twelve',
            13 => 'Thirteen', 14 => 'Fourteen', 15 => 'Fifteen',
            16 => 'Sixteen', 17 => 'Seventeen', 18 => 'Eighteen',
            19 => 'Nineteen', 20 => 'Twenty', 30 => 'Thirty',
            40 => 'Forty', 50 => 'Fifty', 60 => 'Sixty',
            70 => 'Seventy', 80 => 'Eighty', 90 => 'Ninety'
        );
        $here_digits = array('', 'Hundred', 'Thousand', 'Lakh', 'Crore');
        while ($x < $count_length) {
            $get_divider = ($x == 2) ? 10 : 100;
            $amount = floor($num % $get_divider);
            $num = floor($num / $get_divider);
            $x += $get_divider == 10 ? 1 : 2;
            if ($amount) {
                $add_plural = (($counter = count($string)) && $amount > 9) ? 's' : null;
                $amt_hundred = ($counter == 1 && $string[0]) ? ' and ' : null;
                $string[] = ($amount < 21) ? $change_words[$amount] . ' ' . $here_digits[$counter] . $add_plural . '
       ' . $amt_hundred : $change_words[floor($amount / 10) * 10] . ' ' . $change_words[$amount % 10] . '
       ' . $here_digits[$counter] . $add_plural . ' ' . $amt_hundred;
            } else $string[] = null;
        }
        $implode_to_Rupees = implode('', array_reverse($string));
        $get_paise = ($amount_after_decimal > 0) ? "And " . ($change_words[$amount_after_decimal / 10] . "
   " . $change_words[$amount_after_decimal % 10]) . ' Paise' : '';
        return ($implode_to_Rupees ? $implode_to_Rupees . 'Rupees ' : '') . $get_paise;
    }
}
if (!function_exists('estimateType')) {
    function estimateType($id)
    {
        $estimate_type = [];
        $cab_estimate_exists    = EstimateCab::where('estimate_id', $id)->exists();

        if ($cab_estimate_exists) {
            array_push($estimate_type, 'cab');
        }
        $safari_estimate_exists = EstimateSafari::where('estimate_id', $id)->exists();
        if ($safari_estimate_exists) {
            array_push($estimate_type, 'safari');
        }
        $hotel_estimate_exists  = EstimateHotel::where('estimate_id', $id)->exists();
        if ($hotel_estimate_exists) {
            array_push($estimate_type, 'hotel');
        }
         $flight_estimate_exists    = EstimateFlight::where('estimate_id', $id)->exists();

        if ($flight_estimate_exists) {
            array_push($estimate_type, 'flight');
        }

        return $estimate_type;
    }
}
if (!function_exists('bookingType')) {
    function bookingType($id)
    {
        $booking_type = [];
        $cab_booking_exists    = BookingCab::where('booking_id', $id)->exists();

        if ($cab_booking_exists) {
            array_push($booking_type, 'cab');
        }
        $safari_booking_exists = BookingSafari::where('booking_id', $id)->exists();
        if ($safari_booking_exists) {
            array_push($booking_type, 'safari');
        }
        $hotel_booking_exists  = BookingHotel::where('booking_id', $id)->exists();
        if ($hotel_booking_exists) {
            array_push($booking_type, 'hotel');
        }

        return $booking_type;
    }
}
if (!function_exists('tourOptionTotal')) {
    function tourOptionTotal($id, $estimate_id)
    {

        $amount                = EstimateHotelOption::where('id', $id)->value('amount');
        $discount              = EstimateHotelOption::where('id', $id)->value('discount');
        $safari_options        = EstimateSafariOption::where('estimate_id', $estimate_id)->get();
        $cab_options           = EstimateCabOption::where('estimate_id', $estimate_id)->get();
        foreach ($safari_options as $option) {
            $amount = $amount + $option->amount;
            $discount = $discount + $option->discount;
        }
        foreach ($cab_options as $option) {
            $amount = $amount + $option->amount;
            $discount = $discount + $option->discount;
        }

        $estimate               = Estimate::find($estimate_id);
        $total_without_gst      = $amount - $discount;
        $gst                    = round(($estimate->gst_filed / 100) * $total_without_gst);
        $total_with_gst         = $total_without_gst + $gst;
        $pg_charges             = round(($estimate->pg_charges_filed / 100) * $total_with_gst);
        $total                  = $total_with_gst + $pg_charges;

        return $total;
    }
}
if (!function_exists('tourOptionAmount')) {
    function tourOptionAmount($id, $estimate_id)
    {

        $amount                = EstimateHotelOption::where('id', $id)->value('amount');

        $safari_options        = EstimateSafariOption::where('estimate_id', $estimate_id)->get();
        $cab_options           = EstimateCabOption::where('estimate_id', $estimate_id)->get();
        foreach ($safari_options as $option) {
            $amount = $amount + $option->amount;
        }
        foreach ($cab_options as $option) {
            $amount = $amount + $option->amount;
        }

        $total = $amount;

        return $total;
    }
}
if (!function_exists('tourOptionDiscount')) {
    function tourOptionDiscount($id, $estimate_id)
    {

        $discount              = EstimateHotelOption::where('id', $id)->value('discount');
        $safari_options        = EstimateSafariOption::where('estimate_id', $estimate_id)->get();
        $cab_options           = EstimateCabOption::where('estimate_id', $estimate_id)->get();
        foreach ($safari_options as $option) {
            $discount = $discount + $option->discount;
        }
        foreach ($cab_options as $option) {
            $discount = $discount + $option->discount;
        }

        $total = $discount;

        return $total;
    }
}
if (!function_exists('tourTotal')) {
    function tourTotal($id)
    {

        $amount                = EstimateHotelOption::where('estimate_id', $id)->where('accepted', 'yes')->value('amount');
        $discount              = EstimateHotelOption::where('estimate_id', $id)->where('accepted', 'yes')->value('discount');
        $safari_options        = EstimateSafariOption::where('estimate_id', $id)->get();
        $cab_options           = EstimateCabOption::where('estimate_id', $id)->get();
        foreach ($safari_options as $option) {
            $amount = $amount + $option->amount;
            $discount = $discount + $option->discount;
        }
        foreach ($cab_options as $option) {
            $amount = $amount + $option->amount;
            $discount = $discount + $option->discount;
        }
        $estimate               = Estimate::find($id);


        $total_without_gst      = $amount - $discount;
        $gst                    = round(($estimate->gst_filed / 100) * $total_without_gst);
        $total_with_gst         = $total_without_gst + $gst;
        $pg_charges             = round(($estimate->pg_charges_filed / 100) * $total_with_gst);
        $total                  = $total_with_gst + $pg_charges;

        return $total;
    }
}
if (!function_exists('getRazorpayKey')) {
    function getRazorpayKey()
    {
        $mode = PaymentMode::where('mode', 'razorpay')->where('status', '1')->first();
        return $mode->details['razorpay_key'];
    }
}
if (!function_exists('getRazorpaySecretKey')) {
    function getRazorpaySecretKey()
    {
        $mode = PaymentMode::where('mode', 'razorpay')->where('status', '1')->first();
        return $mode->details['razorpay_secret_key'];
    }
}
if (!function_exists('bookingExists')) {
    function bookingExists($id)
    {
        $booking_exists = Booking::where('estimate_id', $id)->exists();
        return $booking_exists;
    }
}
if (!function_exists('cabTotal')) {
    function cabTotal($id)
    {

        $total = EstimateCabOption::where('estimate_id', $id)->where('accepted', 'yes')->value('total');
        return $total;
    }
}
if (!function_exists('hotelTotal')) {
    function hotelTotal($id)
    {

        $total = EstimateHotelOption::where('estimate_id', $id)->where('accepted', 'yes')->value('total');
        return $total;
    }
}
if (!function_exists('safariTotal')) {
    function safariTotal($id)
    {

        $total = EstimateSafariOption::where('estimate_id', $id)->where('accepted', 'yes')->value('total');
        return $total;
    }
}
if (!function_exists('getHotelsbyDestination')) {
    function getHotelsbyDestination($destination)
    {

        $hotels_list  = Hotel::where('city', 'LIKE', '%' . $destination . '%')->get();
        return $hotels_list;
    }
}

if (!function_exists('getRoomsbyHotel')) {
    function getRoomsbyHotel($id)
    {

        $rooms  = HotelRoom::where('hotel_id', $id)->get();
        return $rooms;
    }
}

if (!function_exists('getServicesbyRoom')) {
    function getServicesbyRoom($id)
    {

        $services  = HotelRoomService::where('room_id', $id)->get();
        return $services;
    }
}
if (!function_exists('packageTotal')) {
    function packageTotal($id)
    {
        $hotel_options         = EstimateHotelDestinationOption::where('estimate_id', $id)->get();

        $amount     = 0;
        $discount   = 0;

        foreach ($hotel_options as $option) {
            $amount             = $amount + $option->amount;
            $discount           = $discount + $option->discount;
        }

        $safari_options        = EstimateSafariOption::where('estimate_id', $id)->get();
        $cab_options           = EstimateCabOption::where('estimate_id', $id)->get();
        $flight_options        = EstimateFlightOptions::where('estimate_id', $id)->get();
        foreach ($safari_options as $option) {
            $amount = $amount + $option->amount;
            $discount = $discount + $option->discount;
        }
        foreach ($cab_options as $option) {
            $amount = $amount + $option->amount;
            $discount = $discount + $option->discount;
        }
         foreach ($flight_options as $option) {
            $amount = $amount + $option->price;
            $discount = $discount + $option->discount;
        }



        $estimate               = Estimate::find($id);


        $total_without_gst      = $amount - $discount;
        $gst                    = round(($estimate->gst_filed / 100) * $total_without_gst);
        $total_with_gst         = $total_without_gst + $gst;
        $pg_charges             = round(($estimate->pg_charges_filed / 100) * $total_with_gst);
        $total                  = $total_with_gst + $pg_charges;

        return $total;
    }
}
if (!function_exists('getBookingBalance')) {
    function getBookingBalance($id)
    {
        $booking = Booking::find($id);
        $balance = $booking->items->sum('amount') - $booking->transactions->sum('amount');
        return $balance;
    }
}
if (!function_exists('getTaxableAmount')) {
    function getTaxableAmount($id)
    {
        $taxable_amount = BookingItem::where('booking_id', $id)->where('rate', '!=', 0)->value('amount');
        return $taxable_amount;
    }
}
if (!function_exists('getNonTaxableAmount')) {
    function getNonTaxableAmount($id)
    {
        $booking        = Booking::find($id);
        $taxable_amount = BookingItem::where('booking_id', $id)->where('rate', '!=', 0)->value('amount');
        $permit_rate    = $booking->items->sum('amount') - $taxable_amount;
        return $permit_rate;
    }
}
if (!function_exists('checkFirstTransaction')) {
    function checkFirstTransaction($booking_id, $transaction_id)
    {
        $transaction        = Transaction::where('booking_id', $booking_id)->first();
        if ($transaction_id == $transaction->id) {
            return true;
        }

        return false;
    }
}
if (!function_exists('getPackageTotal')) {
    function getPackageTotal($id)
    {
        $amount = 0;
        $discount = 0;

        $hotel_options         = EstimateHotelDestinationOption::where('estimate_id', $id)->get();

        $amount     = 0;
        $discount   = 0;

        foreach ($hotel_options as $option) {
            $amount             = $amount + $option->amount;
            $discount           = $discount + $option->discount;
        }

        $safari_options        = EstimateSafariOption::where('estimate_id', $id)->get();
        $cab_options           = EstimateCabOption::where('estimate_id', $id)->get();
        $flight_options        = EstimateFlightOptions::where('estimate_id', $id)->get();

        foreach ($safari_options as $option) {
            $amount = $amount + $option->amount;
            $discount = $discount + $option->discount;
        }
        foreach ($cab_options as $option) {
            $amount = $amount + $option->amount;
            $discount = $discount + $option->discount;
        }
        foreach ($flight_options as $option) {
            $amount = $amount + $option->price;
            $discount = $discount + $option->discount;
        }

        $estimate               = Estimate::find($id);

        $total_without_gst      = $amount - $discount;
        
        return $total_without_gst;
    }
}
if (!function_exists('getLongWeekendDates')) {
    function getLongWeekendDates()
    {
        $weekends = LongWeekend::where('start', '>', Carbon::now())->where('end', '>', Carbon::now())->get();
        return $weekends;
    }
}
if (!function_exists('getMarquees')) {
    function getMarquees()
    {

       $marquees = Marquee::where('status', true)->get();
       $marquees = $marquees ? $marquees->toArray() : [];   
        // echo "<pre/>";print_r($marquees);
        
        $user = auth()->user(); 
        $user = User::find($user->id);
        $roleids =  $user->roles()->get(['roles.id']);
        $mq = [];
        foreach ($roleids as $key => $role) {
            $role_id[] = $role->id;
            
        }
        foreach ($marquees as $key => $marq) {
            $roleIDs = explode(",",$marq['roles']);
            $result=array_intersect($roleIDs,$role_id);
           if($result){
                $marqu = array_push($mq, $marq);
           }
        }
        return $mq;    
    }
}

if (!function_exists('getPackageTotalAmountWithoutDiscount')) {
    function getPackageTotalAmountWithoutDiscount($id)
    {
        $amount = 0;
        

        $hotel_options         = EstimateHotelDestinationOption::where('estimate_id', $id)->get();

        $amount     = 0;

        foreach ($hotel_options as $option) {
            $amount             = $amount + $option->amount;
           
        }

        $safari_options        = EstimateSafariOption::where('estimate_id', $id)->get();
        $cab_options           = EstimateCabOption::where('estimate_id', $id)->get();
        $flight_options        = EstimateFlightOptions::where('estimate_id', $id)->get();

        foreach ($safari_options as $option) {
            $amount = $amount + $option->amount;
           
        }
        foreach ($cab_options as $option) {
            $amount = $amount + $option->amount;
           
        }
        foreach ($flight_options as $option) {
            $amount = $amount + $option->price;
           
        }
        
        

        return $amount;
    }

    if (!function_exists('getPackageTotalDiscount')) {
        function getPackageTotalDiscount($id)
        {
            $discount = 0;
    
            $hotel_options         = EstimateHotelDestinationOption::where('estimate_id', $id)->get();
    
            $amount     = 0;
            $discount   = 0;
    
            foreach ($hotel_options as $option) {
               
                $discount           = $discount + $option->discount;
            }
    
            $safari_options        = EstimateSafariOption::where('estimate_id', $id)->get();
            $cab_options           = EstimateCabOption::where('estimate_id', $id)->get();
            $flight_options           = EstimateFlightOptions::where('estimate_id', $id)->get();
    
            foreach ($safari_options as $option) {
               
                $discount = $discount + $option->discount;
            }
            foreach ($cab_options as $option) {
               
                $discount = $discount + $option->discount;
            }
            foreach ($flight_options as $option) {
               
                $discount = $discount + $option->discount;
            }
            
    
            return $discount;
        }
    }
     if (!function_exists('getCancellationDays')) {
        function getCancellationDays($date)
        {
            $current_date = date('Y-m-d');
            $tomorrow = date("Y-m-d", strtotime('tomorrow'));
            
            if($date < $current_date){
                $days = 0;
            }elseif ($date == $current_date) {
               $days = 0;
            }elseif ($date == $tomorrow){
                 $days = 1;
            }else{
                $days = Carbon::parse($date)->diffInDays() + 1;
            }

            return $days;
        }
    }

    if (!function_exists('upi')) {
        function upi($amount,$merchant_upi,$merchant_name,$size){
    
            $googleChart = 'https://chart.googleapis.com/chart?cht=qr&choe=UTF-8';
            $upiData = 'upi://pay?pn='.$merchant_name.'&pa='.$merchant_upi.'&am='.$amount;
            return $googleChart.'&chs='.$size.'x'.$size.'&chl='.urlencode($upiData);
        }
    }
}