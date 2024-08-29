<?php

namespace App\Console\Commands;

use App\Models\BookingCancellationRequest;
use App\Models\RefundHistory;
use Carbon\Carbon;
use Illuminate\Console\Command;

class RefundCheck extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'refund:check';

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
        $cancels = BookingCancellationRequest::where('approval_amount' ,'!=',null)->where('approval_status','=',0)->get();
 
        if(count($cancels) > 0){

            foreach( $cancels as $c){

                $up = Carbon::parse($c->updated_at);
                $now = Carbon::now();
                $time = $now->diffInHours($up);
                if($time > 24){

                    BookingCancellationRequest::where('id',$c->id)->update(['approval_status'=>3]);

                    RefundHistory::create([

                        'booking_id'      => $c->booking_id,
                        'customer_id'     => $c->customer_id,
                        'admin_id'        => 0,
                        'cancellation_id' => $c->id,
                        'note'            => 'Sorry, 24 hours passed to generated, Now the request is expired automatically.',
                        'amount'          => $c->approval_amount,
                        'status'          => 'Expired',
        
                    ]);
                }
            }
        }
    }
}
