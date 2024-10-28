<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Room;
use App\Models\Hall;
use Carbon\Carbon;
use App\Models\LinkBookingRequest;


class EnableRoomsAndHalls extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'enable:rooms-and-halls';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Enable rooms or halls based on link booking requests';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $tenMinutesAgo = Carbon::now()->subMinutes(10);

        $bookings = LinkBookingRequest::where('link_booking_requests.created_at', '<=', $tenMinutesAgo)->get();

        
        foreach ($bookings as $key => $booking) {
            $primary_id  = $booking->id;
            $room_id_data = $booking->room_id;
            $booking_type = $booking->booking_type;
            $roomId    = explode('-', $room_id_data)[0];

            if ($booking_type =='room') {
                
                if ($roomId) {
                    Room::where('id', $roomId)->update(['status' => '1']);
                    $room = Room::find($roomId);
                }
            } 

            if ($booking_type =='hall') {
                $room = Hall::where('id', $roomId)->update(['status' => '1']);
            }

            if($primary_id) {
                LinkBookingRequest::where('id',$primary_id)->delete();
            }
        }
        $this->info('Rooms and Halls enabled successfully.');
    }
}
