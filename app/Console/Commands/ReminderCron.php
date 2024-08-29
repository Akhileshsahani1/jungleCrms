<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Models\Booking;
use App\Models\BookingReminder;
use Mail;

class ReminderCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reminder:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // \Log::info("Cron is working fine!");
        $reminders = BookingReminder::whereDate('date',Carbon::today())->get();
         
        foreach($reminders as $reminder){
        $booking = Booking::find($reminder->booking_id)->load('customer','lead');

        $name = @$booking->lead->user->name;
        $mobile = @$booking->lead->user->phone;
        $ch = curl_init();

        $mobile_no = $booking->customer->mobile;

        if($booking->safari->sanctuary == 'gir'){
            $safari = 'Gir National Park booking INR '. $reminder->amount;
        }elseif($booking->safari->sanctuary == 'jim'){
            $safari = 'Jim Corbett National Park booking INR '. $reminder->amount;
        }elseif($booking->safari->sanctuary == 'ranthambore'){
            $safari = 'Ranthambore National Park booking INR '. $reminder->amount;
        }elseif($booking->safari->sanctuary == 'tadoba'){
            $safari = 'Tadoba National Park booking INR '. $reminder->amount;
        }
        
            $data =array(
            'name' => $booking->customer->name,
            'email'=>$booking->customer->email,
            'due'  => $reminder->amount,
            'safari'=>$safari,
            'date'  => $booking->date
            );
            

      
        $params = [
            "messaging_product" => "whatsapp", 
            "recipient_type" => "individual", 
            "to" => (strlen($mobile_no) <=10) ? '91'.$mobile_no : $mobile_no,
            "type" => "template", 
            "template" => [
                "name" => "due_payment", 
                "language" => [
                    "code" => "en_US"
                ], 
                "components" => [
                    [
                        "type" => "header", 
                        "parameters" => [
                            [
                                "type" => "text", 
                                "text" => @$booking->customer->name 
                            ] 
                        ]
                    ],
                    [
                        "type" => "body", 
                        "parameters" => [
                            [
                                "type" => "text", 
                                "text" => @$safari
                            ],  
                            [
                                "type" => "text", 
                                "text" => @$booking->date
                            ],                   
                            [
                                "type" => "text", 
                                "text" => @$name ?? 'Abhishek'
                            ],
                            [
                                "type" => "text", 
                                "text" => @$mobile ?? "919971717045"
                            ],
                        ] 
                    ],
                ] 
            ] 
        ]; 
         
        curl_setopt($ch, CURLOPT_URL, 'https://graph.facebook.com/v16.0/'.env('WHATSAPP_API_CODE').'/messages');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));

        $headers = array();
        $headers[] = 'Authorization: Bearer '.env('WHATSAPP_API_SECRET');
        $headers[] = 'Content-Type: application/json';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        $data = json_decode($result, 1);
        curl_close($ch);
        }
    }
}
