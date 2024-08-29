<?php

namespace Database\Seeders;

use App\Models\HotelRoomService;
use Illuminate\Database\Seeder;

class HotelRoomServiceSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        HotelRoomService::create( [
            'id'=>1,
            'room_id'=>1,
            'hotel_id'=>1,
            'service'=>'Room with Breakfast',
            'price'=>'1000',
            'extra_adult_price'=>'400',
            'extra_child_price'=>'200',
            'weekend_price'=>'1100',
            'extra_adult_weekend_price'=>'500',
            'extra_child_weekend_price'=>'300',
            'created_at'=>'2022-04-26 06:49:19',
            'updated_at'=>'2022-04-26 06:49:19'
            ] );



            HotelRoomService::create( [
            'id'=>2,
            'room_id'=>1,
            'hotel_id'=>1,
            'service'=>'Room with Breakfast and Dinner',
            'price'=>'1200',
            'extra_adult_price'=>'500',
            'extra_child_price'=>'300',
            'weekend_price'=>'1300',
            'extra_adult_weekend_price'=>'600',
            'extra_child_weekend_price'=>'400',
            'created_at'=>'2022-04-26 06:49:19',
            'updated_at'=>'2022-04-26 06:49:19'
            ] );



            HotelRoomService::create( [
            'id'=>3,
            'room_id'=>1,
            'hotel_id'=>1,
            'service'=>'Room with Breakfast, Lunch and Dinner',
            'price'=>'1500',
            'extra_adult_price'=>'600',
            'extra_child_price'=>'400',
            'weekend_price'=>'1600',
            'extra_adult_weekend_price'=>'700',
            'extra_child_weekend_price'=>'500',
            'created_at'=>'2022-04-26 06:49:19',
            'updated_at'=>'2022-04-26 06:49:19'
            ] );



            HotelRoomService::create( [
            'id'=>4,
            'room_id'=>2,
            'hotel_id'=>2,
            'service'=>'Room with Breakfast',
            'price'=>'1200',
            'extra_adult_price'=>'600',
            'extra_child_price'=>'300',
            'weekend_price'=>'1300',
            'extra_adult_weekend_price'=>'700',
            'extra_child_weekend_price'=>'400',
            'created_at'=>'2022-04-26 06:49:19',
            'updated_at'=>'2022-04-26 06:49:19'
            ] );



            HotelRoomService::create( [
            'id'=>5,
            'room_id'=>2,
            'hotel_id'=>2,
            'service'=>'Room with Breakfast and Dinner',
            'price'=>'1500',
            'extra_adult_price'=>'750',
            'extra_child_price'=>'400',
            'weekend_price'=>'1600',
            'extra_adult_weekend_price'=>'850',
            'extra_child_weekend_price'=>'500',
            'created_at'=>'2022-04-26 06:49:19',
            'updated_at'=>'2022-04-26 06:49:19'
            ] );



            HotelRoomService::create( [
            'id'=>6,
            'room_id'=>2,
            'hotel_id'=>2,
            'service'=>'Room with Breakfast, Lunch and Dinner',
            'price'=>'1800',
            'extra_adult_price'=>'900',
            'extra_child_price'=>'500',
            'weekend_price'=>'1900',
            'extra_adult_weekend_price'=>'1000',
            'extra_child_weekend_price'=>'600',
            'created_at'=>'2022-04-26 06:49:19',
            'updated_at'=>'2022-04-26 06:49:19'
            ] );



            HotelRoomService::create( [
            'id'=>7,
            'room_id'=>3,
            'hotel_id'=>3,
            'service'=>'Room with Breakfast',
            'price'=>'1200',
            'extra_adult_price'=>'600',
            'extra_child_price'=>'300',
            'weekend_price'=>'1300',
            'extra_adult_weekend_price'=>'700',
            'extra_child_weekend_price'=>'400',
            'created_at'=>'2022-04-26 06:49:19',
            'updated_at'=>'2022-04-26 06:49:19'
            ] );



            HotelRoomService::create( [
            'id'=>8,
            'room_id'=>3,
            'hotel_id'=>3,
            'service'=>'Room with Breakfast and Dinner',
            'price'=>'1500',
            'extra_adult_price'=>'750',
            'extra_child_price'=>'400',
            'weekend_price'=>'1600',
            'extra_adult_weekend_price'=>'850',
            'extra_child_weekend_price'=>'500',
            'created_at'=>'2022-04-26 06:49:19',
            'updated_at'=>'2022-04-26 06:49:19'
            ] );



            HotelRoomService::create( [
            'id'=>9,
            'room_id'=>3,
            'hotel_id'=>3,
            'service'=>'Room with Breakfast, Lunch and Dinner',
            'price'=>'1800',
            'extra_adult_price'=>'900',
            'extra_child_price'=>'500',
            'weekend_price'=>'1900',
            'extra_adult_weekend_price'=>'1000',
            'extra_child_weekend_price'=>'600',
            'created_at'=>'2022-04-26 06:49:19',
            'updated_at'=>'2022-04-26 06:49:19'
            ] );



            HotelRoomService::create( [
            'id'=>10,
            'room_id'=>4,
            'hotel_id'=>4,
            'service'=>'Room with Breakfast',
            'price'=>'1200',
            'extra_adult_price'=>'500',
            'extra_child_price'=>'250',
            'weekend_price'=>'1300',
            'extra_adult_weekend_price'=>'600',
            'extra_child_weekend_price'=>'350',
            'created_at'=>'2022-04-26 06:49:19',
            'updated_at'=>'2022-04-26 06:49:19'
            ] );



            HotelRoomService::create( [
            'id'=>11,
            'room_id'=>4,
            'hotel_id'=>4,
            'service'=>'Room with Breakfast and Dinner',
            'price'=>'1600',
            'extra_adult_price'=>'1000',
            'extra_child_price'=>'500',
            'weekend_price'=>'1700',
            'extra_adult_weekend_price'=>'1100',
            'extra_child_weekend_price'=>'500',
            'created_at'=>'2022-04-26 06:49:19',
            'updated_at'=>'2022-04-26 06:49:19'
            ] );



            HotelRoomService::create( [
            'id'=>12,
            'room_id'=>4,
            'hotel_id'=>4,
            'service'=>'Room with Breakfast, Lunch and Dinner',
            'price'=>'2000',
            'extra_adult_price'=>'1500',
            'extra_child_price'=>'750',
            'weekend_price'=>'2100',
            'extra_adult_weekend_price'=>'1600',
            'extra_child_weekend_price'=>'850',
            'created_at'=>'2022-04-26 06:49:19',
            'updated_at'=>'2022-04-26 06:49:19'
            ] );



            HotelRoomService::create( [
            'id'=>13,
            'room_id'=>5,
            'hotel_id'=>5,
            'service'=>'Room with Breakfast',
            'price'=>'900',
            'extra_adult_price'=>'450',
            'extra_child_price'=>'250',
            'weekend_price'=>'1000',
            'extra_adult_weekend_price'=>'550',
            'extra_child_weekend_price'=>'350',
            'created_at'=>'2022-04-26 06:49:19',
            'updated_at'=>'2022-04-26 06:49:19'
            ] );



            HotelRoomService::create( [
            'id'=>14,
            'room_id'=>5,
            'hotel_id'=>5,
            'service'=>'Room with Breakfast and Dinner',
            'price'=>'1300',
            'extra_adult_price'=>'650',
            'extra_child_price'=>'450',
            'weekend_price'=>'1400',
            'extra_adult_weekend_price'=>'750',
            'extra_child_weekend_price'=>'450',
            'created_at'=>'2022-04-26 06:49:19',
            'updated_at'=>'2022-04-26 06:49:19'
            ] );



            HotelRoomService::create( [
            'id'=>15,
            'room_id'=>5,
            'hotel_id'=>5,
            'service'=>'Room with Breakfast, Lunch and Dinner',
            'price'=>'1700',
            'extra_adult_price'=>'850',
            'extra_child_price'=>'650',
            'weekend_price'=>'6300',
            'extra_adult_weekend_price'=>'2105',
            'extra_child_weekend_price'=>'1575',
            'created_at'=>'2022-04-26 06:49:19',
            'updated_at'=>'2022-04-26 06:49:19'
            ] );



            HotelRoomService::create( [
            'id'=>16,
            'room_id'=>6,
            'hotel_id'=>6,
            'service'=>'Room with Breakfast',
            'price'=>'900',
            'extra_adult_price'=>'450',
            'extra_child_price'=>'250',
            'weekend_price'=>'6300',
            'extra_adult_weekend_price'=>'2105',
            'extra_child_weekend_price'=>'1575',
            'created_at'=>'2022-04-26 06:49:19',
            'updated_at'=>'2022-04-26 06:49:19'
            ] );



            HotelRoomService::create( [
            'id'=>17,
            'room_id'=>6,
            'hotel_id'=>6,
            'service'=>'Room with Breakfast and Dinner',
            'price'=>'1300',
            'extra_adult_price'=>'650',
            'extra_child_price'=>'450',
            'weekend_price'=>'6300',
            'extra_adult_weekend_price'=>'2105',
            'extra_child_weekend_price'=>'1575',
            'created_at'=>'2022-04-26 06:49:19',
            'updated_at'=>'2022-04-26 06:49:19'
            ] );



            HotelRoomService::create( [
            'id'=>18,
            'room_id'=>6,
            'hotel_id'=>6,
            'service'=>'Room with Breakfast, Lunch and Dinner',
            'price'=>'1700',
            'extra_adult_price'=>'850',
            'extra_child_price'=>'650',
            'weekend_price'=>'6300',
            'extra_adult_weekend_price'=>'2105',
            'extra_child_weekend_price'=>'1575',
            'created_at'=>'2022-04-26 06:49:19',
            'updated_at'=>'2022-04-26 06:49:19'
            ] );



            HotelRoomService::create( [
            'id'=>19,
            'room_id'=>7,
            'hotel_id'=>7,
            'service'=>'Room with Breakfast',
            'price'=>'900',
            'extra_adult_price'=>'450',
            'extra_child_price'=>'250',
            'weekend_price'=>'6300',
            'extra_adult_weekend_price'=>'2105',
            'extra_child_weekend_price'=>'1575',
            'created_at'=>'2022-04-26 06:49:19',
            'updated_at'=>'2022-04-26 06:49:19'
            ] );



            HotelRoomService::create( [
            'id'=>20,
            'room_id'=>7,
            'hotel_id'=>7,
            'service'=>'Room with Breakfast and Dinner',
            'price'=>'1300',
            'extra_adult_price'=>'650',
            'extra_child_price'=>'450',
            'weekend_price'=>'6300',
            'extra_adult_weekend_price'=>'2105',
            'extra_child_weekend_price'=>'1575',
            'created_at'=>'2022-04-26 06:49:19',
            'updated_at'=>'2022-04-26 06:49:19'
            ] );



            HotelRoomService::create( [
            'id'=>21,
            'room_id'=>7,
            'hotel_id'=>7,
            'service'=>'Room with Breakfast, Lunch and Dinner',
            'price'=>'1700',
            'extra_adult_price'=>'850',
            'extra_child_price'=>'650',
            'weekend_price'=>'6300',
            'extra_adult_weekend_price'=>'2105',
            'extra_child_weekend_price'=>'1575',
            'created_at'=>'2022-04-26 06:49:19',
            'updated_at'=>'2022-04-26 06:49:19'
            ] );



            HotelRoomService::create( [
            'id'=>22,
            'room_id'=>8,
            'hotel_id'=>8,
            'service'=>'Room with Breakfast',
            'price'=>'900',
            'extra_adult_price'=>'450',
            'extra_child_price'=>'250',
            'weekend_price'=>'6300',
            'extra_adult_weekend_price'=>'2105',
            'extra_child_weekend_price'=>'1575',
            'created_at'=>'2022-04-26 06:49:19',
            'updated_at'=>'2022-04-26 06:49:19'
            ] );



            HotelRoomService::create( [
            'id'=>23,
            'room_id'=>8,
            'hotel_id'=>8,
            'service'=>'Room with Breakfast and Dinner',
            'price'=>'1300',
            'extra_adult_price'=>'650',
            'extra_child_price'=>'450',
            'weekend_price'=>'6300',
            'extra_adult_weekend_price'=>'2105',
            'extra_child_weekend_price'=>'1575',
            'created_at'=>'2022-04-26 06:49:19',
            'updated_at'=>'2022-04-26 06:49:19'
            ] );



            HotelRoomService::create( [
            'id'=>24,
            'room_id'=>8,
            'hotel_id'=>8,
            'service'=>'Room with Breakfast, Lunch and Dinner',
            'price'=>'1700',
            'extra_adult_price'=>'850',
            'extra_child_price'=>'650',
            'weekend_price'=>'6300',
            'extra_adult_weekend_price'=>'2105',
            'extra_child_weekend_price'=>'1575',
            'created_at'=>'2022-04-26 06:49:19',
            'updated_at'=>'2022-04-26 06:49:19'
            ] );



            HotelRoomService::create( [
            'id'=>25,
            'room_id'=>9,
            'hotel_id'=>9,
            'service'=>'Room with Breakfast',
            'price'=>'900',
            'extra_adult_price'=>'450',
            'extra_child_price'=>'250',
            'weekend_price'=>'6300',
            'extra_adult_weekend_price'=>'2105',
            'extra_child_weekend_price'=>'1575',
            'created_at'=>'2022-04-26 06:49:19',
            'updated_at'=>'2022-04-26 06:49:19'
            ] );



            HotelRoomService::create( [
            'id'=>26,
            'room_id'=>9,
            'hotel_id'=>9,
            'service'=>'Room with Breakfast and Dinner',
            'price'=>'1300',
            'extra_adult_price'=>'650',
            'extra_child_price'=>'450',
            'weekend_price'=>'6300',
            'extra_adult_weekend_price'=>'2105',
            'extra_child_weekend_price'=>'1575',
            'created_at'=>'2022-04-26 06:49:19',
            'updated_at'=>'2022-04-26 06:49:19'
            ] );



            HotelRoomService::create( [
            'id'=>27,
            'room_id'=>9,
            'hotel_id'=>9,
            'service'=>'Room with Breakfast, Lunch and Dinner',
            'price'=>'1700',
            'extra_adult_price'=>'850',
            'extra_child_price'=>'650',
            'weekend_price'=>'6300',
            'extra_adult_weekend_price'=>'2105',
            'extra_child_weekend_price'=>'1575',
            'created_at'=>'2022-04-26 06:49:19',
            'updated_at'=>'2022-04-26 06:49:19'
            ] );



            HotelRoomService::create( [
            'id'=>28,
            'room_id'=>10,
            'hotel_id'=>11,
            'service'=>'Room with Breakfast',
            'price'=>'900',
            'extra_adult_price'=>'450',
            'extra_child_price'=>'250',
            'weekend_price'=>'6300',
            'extra_adult_weekend_price'=>'2105',
            'extra_child_weekend_price'=>'1575',
            'created_at'=>'2022-04-26 06:49:19',
            'updated_at'=>'2022-04-26 06:49:19'
            ] );



            HotelRoomService::create( [
            'id'=>29,
            'room_id'=>10,
            'hotel_id'=>11,
            'service'=>'Room with Breakfast and Dinner',
            'price'=>'1300',
            'extra_adult_price'=>'650',
            'extra_child_price'=>'450',
            'weekend_price'=>'6300',
            'extra_adult_weekend_price'=>'2105',
            'extra_child_weekend_price'=>'1575',
            'created_at'=>'2022-04-26 06:49:19',
            'updated_at'=>'2022-04-26 06:49:19'
            ] );



            HotelRoomService::create( [
            'id'=>30,
            'room_id'=>10,
            'hotel_id'=>11,
            'service'=>'Room with Breakfast, Lunch and Dinner',
            'price'=>'1700',
            'extra_adult_price'=>'850',
            'extra_child_price'=>'650',
            'weekend_price'=>'6300',
            'extra_adult_weekend_price'=>'2105',
            'extra_child_weekend_price'=>'1575',
            'created_at'=>'2022-04-26 06:49:19',
            'updated_at'=>'2022-04-26 06:49:19'
            ] );



            HotelRoomService::create( [
            'id'=>31,
            'room_id'=>12,
            'hotel_id'=>13,
            'service'=>'Room with Breakfast',
            'price'=>'900',
            'extra_adult_price'=>'450',
            'extra_child_price'=>'250',
            'weekend_price'=>'6300',
            'extra_adult_weekend_price'=>'2105',
            'extra_child_weekend_price'=>'1575',
            'created_at'=>'2022-04-26 06:49:19',
            'updated_at'=>'2022-04-26 06:49:19'
            ] );



            HotelRoomService::create( [
            'id'=>32,
            'room_id'=>12,
            'hotel_id'=>13,
            'service'=>'Room with Breakfast and Dinner',
            'price'=>'1300',
            'extra_adult_price'=>'650',
            'extra_child_price'=>'450',
            'weekend_price'=>'6300',
            'extra_adult_weekend_price'=>'2105',
            'extra_child_weekend_price'=>'1575',
            'created_at'=>'2022-04-26 06:49:19',
            'updated_at'=>'2022-04-26 06:49:19'
            ] );



            HotelRoomService::create( [
            'id'=>33,
            'room_id'=>12,
            'hotel_id'=>13,
            'service'=>'Room with Breakfast, Lunch and Dinner',
            'price'=>'1700',
            'extra_adult_price'=>'850',
            'extra_child_price'=>'650',
            'weekend_price'=>'6300',
            'extra_adult_weekend_price'=>'2105',
            'extra_child_weekend_price'=>'1575',
            'created_at'=>'2022-04-26 06:49:19',
            'updated_at'=>'2022-04-26 06:49:19'
            ] );



            HotelRoomService::create( [
            'id'=>34,
            'room_id'=>13,
            'hotel_id'=>14,
            'service'=>'Room with Breakfast',
            'price'=>'900',
            'extra_adult_price'=>'450',
            'extra_child_price'=>'250',
            'weekend_price'=>'6300',
            'extra_adult_weekend_price'=>'2105',
            'extra_child_weekend_price'=>'1575',
            'created_at'=>'2022-04-26 06:49:19',
            'updated_at'=>'2022-04-26 06:49:19'
            ] );



            HotelRoomService::create( [
            'id'=>35,
            'room_id'=>13,
            'hotel_id'=>14,
            'service'=>'Room with Breakfast and Dinner',
            'price'=>'1300',
            'extra_adult_price'=>'650',
            'extra_child_price'=>'450',
            'weekend_price'=>'6300',
            'extra_adult_weekend_price'=>'2105',
            'extra_child_weekend_price'=>'1575',
            'created_at'=>'2022-04-26 06:49:19',
            'updated_at'=>'2022-04-26 06:49:19'
            ] );



            HotelRoomService::create( [
            'id'=>36,
            'room_id'=>13,
            'hotel_id'=>14,
            'service'=>'Room with Breakfast, Lunch and Dinner',
            'price'=>'1700',
            'extra_adult_price'=>'850',
            'extra_child_price'=>'650',
            'weekend_price'=>'6300',
            'extra_adult_weekend_price'=>'2105',
            'extra_child_weekend_price'=>'1575',
            'created_at'=>'2022-04-26 06:49:19',
            'updated_at'=>'2022-04-26 06:49:19'
            ] );



            HotelRoomService::create( [
            'id'=>37,
            'room_id'=>14,
            'hotel_id'=>19,
            'service'=>'Room with Breakfast',
            'price'=>'3200',
            'extra_adult_price'=>'1120',
            'extra_child_price'=>'800',
            'weekend_price'=>'6300',
            'extra_adult_weekend_price'=>'2105',
            'extra_child_weekend_price'=>'1575',
            'created_at'=>'2022-04-26 06:49:19',
            'updated_at'=>'2022-04-26 06:49:19'
            ] );



            HotelRoomService::create( [
            'id'=>38,
            'room_id'=>14,
            'hotel_id'=>19,
            'service'=>'Room with Breakfast and Dinner',
            'price'=>'3500',
            'extra_adult_price'=>'1225',
            'extra_child_price'=>'875',
            'weekend_price'=>'6300',
            'extra_adult_weekend_price'=>'2105',
            'extra_child_weekend_price'=>'1575',
            'created_at'=>'2022-04-26 06:49:19',
            'updated_at'=>'2022-04-26 06:49:19'
            ] );



            HotelRoomService::create( [
            'id'=>39,
            'room_id'=>14,
            'hotel_id'=>19,
            'service'=>'Room with Breakfast, Lunch and Dinner',
            'price'=>'3800',
            'extra_adult_price'=>'1680',
            'extra_child_price'=>'1200',
            'weekend_price'=>'6300',
            'extra_adult_weekend_price'=>'2105',
            'extra_child_weekend_price'=>'1575',
            'created_at'=>'2022-04-26 06:49:19',
            'updated_at'=>'2022-04-26 06:49:19'
            ] );



            HotelRoomService::create( [
            'id'=>40,
            'room_id'=>15,
            'hotel_id'=>20,
            'service'=>'Room with Breakfast',
            'price'=>'900',
            'extra_adult_price'=>'450',
            'extra_child_price'=>'250',
            'weekend_price'=>'6300',
            'extra_adult_weekend_price'=>'2105',
            'extra_child_weekend_price'=>'1575',
            'created_at'=>'2022-04-26 06:49:19',
            'updated_at'=>'2022-04-26 06:49:19'
            ] );



            HotelRoomService::create( [
            'id'=>41,
            'room_id'=>15,
            'hotel_id'=>20,
            'service'=>'Room with Breakfast and Dinner',
            'price'=>'1300',
            'extra_adult_price'=>'650',
            'extra_child_price'=>'450',
            'weekend_price'=>'6300',
            'extra_adult_weekend_price'=>'2105',
            'extra_child_weekend_price'=>'1575',
            'created_at'=>'2022-04-26 06:49:19',
            'updated_at'=>'2022-04-26 06:49:19'
            ] );



            HotelRoomService::create( [
            'id'=>42,
            'room_id'=>15,
            'hotel_id'=>20,
            'service'=>'Room with Breakfast, Lunch and Dinner',
            'price'=>'1700',
            'extra_adult_price'=>'850',
            'extra_child_price'=>'650',
            'weekend_price'=>'6300',
            'extra_adult_weekend_price'=>'2105',
            'extra_child_weekend_price'=>'1575',
            'created_at'=>'2022-04-26 06:49:19',
            'updated_at'=>'2022-04-26 06:49:19'
            ] );



            HotelRoomService::create( [
            'id'=>43,
            'room_id'=>16,
            'hotel_id'=>21,
            'service'=>'Room with Breakfast',
            'price'=>'3500',
            'extra_adult_price'=>'1225',
            'extra_child_price'=>'875',
            'weekend_price'=>'6300',
            'extra_adult_weekend_price'=>'2105',
            'extra_child_weekend_price'=>'1575',
            'created_at'=>'2022-04-26 06:49:19',
            'updated_at'=>'2022-04-26 06:49:19'
            ] );



            HotelRoomService::create( [
            'id'=>44,
            'room_id'=>16,
            'hotel_id'=>21,
            'service'=>'Room with Breakfast and Dinner',
            'price'=>'4100',
            'extra_adult_price'=>'1435',
            'extra_child_price'=>'1025',
            'weekend_price'=>'6300',
            'extra_adult_weekend_price'=>'2105',
            'extra_child_weekend_price'=>'1575',
            'created_at'=>'2022-04-26 06:49:19',
            'updated_at'=>'2022-04-26 06:49:19'
            ] );



            HotelRoomService::create( [
            'id'=>45,
            'room_id'=>16,
            'hotel_id'=>21,
            'service'=>'Room with Breakfast, Lunch and Dinner',
            'price'=>'4400',
            'extra_adult_price'=>'1540',
            'extra_child_price'=>'1100',
            'weekend_price'=>'6300',
            'extra_adult_weekend_price'=>'2105',
            'extra_child_weekend_price'=>'1575',
            'created_at'=>'2022-04-26 06:49:19',
            'updated_at'=>'2022-04-26 06:49:19'
            ] );



            HotelRoomService::create( [
            'id'=>46,
            'room_id'=>17,
            'hotel_id'=>22,
            'service'=>'Room with Breakfast',
            'price'=>'3900',
            'extra_adult_price'=>'1365',
            'extra_child_price'=>'975',
            'weekend_price'=>'6300',
            'extra_adult_weekend_price'=>'2105',
            'extra_child_weekend_price'=>'1575',
            'created_at'=>'2022-04-26 06:49:19',
            'updated_at'=>'2022-04-26 06:49:19'
            ] );



            HotelRoomService::create( [
            'id'=>47,
            'room_id'=>17,
            'hotel_id'=>22,
            'service'=>'Room with Breakfast and Dinner',
            'price'=>'4200',
            'extra_adult_price'=>'1470',
            'extra_child_price'=>'1050',
            'weekend_price'=>'6300',
            'extra_adult_weekend_price'=>'2105',
            'extra_child_weekend_price'=>'1575',
            'created_at'=>'2022-04-26 06:49:19',
            'updated_at'=>'2022-04-26 06:49:19'
            ] );



            HotelRoomService::create( [
            'id'=>48,
            'room_id'=>17,
            'hotel_id'=>22,
            'service'=>'Room with Breakfast, Lunch and Dinner',
            'price'=>'4500',
            'extra_adult_price'=>'1575',
            'extra_child_price'=>'1125',
            'weekend_price'=>'6300',
            'extra_adult_weekend_price'=>'2105',
            'extra_child_weekend_price'=>'1575',
            'created_at'=>'2022-04-26 06:49:19',
            'updated_at'=>'2022-04-26 06:49:19'
            ] );



            HotelRoomService::create( [
            'id'=>49,
            'room_id'=>18,
            'hotel_id'=>24,
            'service'=>'Room with Breakfast',
            'price'=>'4200',
            'extra_adult_price'=>'1470',
            'extra_child_price'=>'1050',
            'weekend_price'=>'6300',
            'extra_adult_weekend_price'=>'2105',
            'extra_child_weekend_price'=>'1575',
            'created_at'=>'2022-04-26 06:49:19',
            'updated_at'=>'2022-04-26 06:49:19'
            ] );



            HotelRoomService::create( [
            'id'=>50,
            'room_id'=>18,
            'hotel_id'=>24,
            'service'=>'Room with Breakfast and Dinner',
            'price'=>'4500',
            'extra_adult_price'=>'1575',
            'extra_child_price'=>'1125',
            'weekend_price'=>'6300',
            'extra_adult_weekend_price'=>'2105',
            'extra_child_weekend_price'=>'1575',
            'created_at'=>'2022-04-26 06:49:19',
            'updated_at'=>'2022-04-26 06:49:19'
            ] );



            HotelRoomService::create( [
            'id'=>51,
            'room_id'=>18,
            'hotel_id'=>24,
            'service'=>'Room with Breakfast, Lunch and Dinner',
            'price'=>'4800',
            'extra_adult_price'=>'1680',
            'extra_child_price'=>'1200',
            'weekend_price'=>'6300',
            'extra_adult_weekend_price'=>'2105',
            'extra_child_weekend_price'=>'1575',
            'created_at'=>'2022-04-26 06:49:19',
            'updated_at'=>'2022-04-26 06:49:19'
            ] );



            HotelRoomService::create( [
            'id'=>52,
            'room_id'=>19,
            'hotel_id'=>25,
            'service'=>'Room with Breakfast',
            'price'=>'4200',
            'extra_adult_price'=>'1470',
            'extra_child_price'=>'1050',
            'weekend_price'=>'6300',
            'extra_adult_weekend_price'=>'2105',
            'extra_child_weekend_price'=>'1575',
            'created_at'=>'2022-04-26 06:49:19',
            'updated_at'=>'2022-04-26 06:49:19'
            ] );



            HotelRoomService::create( [
            'id'=>53,
            'room_id'=>19,
            'hotel_id'=>25,
            'service'=>'Room with Breakfast and Dinner',
            'price'=>'4500',
            'extra_adult_price'=>'1575',
            'extra_child_price'=>'1125',
            'weekend_price'=>'6300',
            'extra_adult_weekend_price'=>'2105',
            'extra_child_weekend_price'=>'1575',
            'created_at'=>'2022-04-26 06:49:19',
            'updated_at'=>'2022-04-26 06:49:19'
            ] );



            HotelRoomService::create( [
            'id'=>54,
            'room_id'=>19,
            'hotel_id'=>25,
            'service'=>'Room with Breakfast, Lunch and Dinner',
            'price'=>'4800',
            'extra_adult_price'=>'1680',
            'extra_child_price'=>'1200',
            'weekend_price'=>'6300',
            'extra_adult_weekend_price'=>'2105',
            'extra_child_weekend_price'=>'1575',
            'created_at'=>'2022-04-26 06:49:19',
            'updated_at'=>'2022-04-26 06:49:19'
            ] );



            HotelRoomService::create( [
            'id'=>55,
            'room_id'=>20,
            'hotel_id'=>25,
            'service'=>'Room with Breakfast',
            'price'=>'3600',
            'extra_adult_price'=>'1260',
            'extra_child_price'=>'900',
            'weekend_price'=>'6300',
            'extra_adult_weekend_price'=>'2105',
            'extra_child_weekend_price'=>'1575',
            'created_at'=>'2022-04-26 06:49:19',
            'updated_at'=>'2022-04-26 06:49:19'
            ] );



            HotelRoomService::create( [
            'id'=>56,
            'room_id'=>20,
            'hotel_id'=>25,
            'service'=>'Room with Breakfast and Dinner',
            'price'=>'3900',
            'extra_adult_price'=>'1365',
            'extra_child_price'=>'975',
            'weekend_price'=>'6300',
            'extra_adult_weekend_price'=>'2105',
            'extra_child_weekend_price'=>'1575',
            'created_at'=>'2022-04-26 06:49:19',
            'updated_at'=>'2022-04-26 06:49:19'
            ] );



            HotelRoomService::create( [
            'id'=>57,
            'room_id'=>20,
            'hotel_id'=>25,
            'service'=>'Room with Breakfast, Lunch and Dinner',
            'price'=>'4200',
            'extra_adult_price'=>'1470',
            'extra_child_price'=>'1050',
            'weekend_price'=>'6300',
            'extra_adult_weekend_price'=>'2105',
            'extra_child_weekend_price'=>'1575',
            'created_at'=>'2022-04-26 06:49:19',
            'updated_at'=>'2022-04-26 06:49:19'
            ] );



            HotelRoomService::create( [
            'id'=>58,
            'room_id'=>21,
            'hotel_id'=>26,
            'service'=>'Room with Breakfast',
            'price'=>'3900',
            'extra_adult_price'=>'1365',
            'extra_child_price'=>'975',
            'weekend_price'=>'6300',
            'extra_adult_weekend_price'=>'2105',
            'extra_child_weekend_price'=>'1575',
            'created_at'=>'2022-04-26 06:49:19',
            'updated_at'=>'2022-04-26 06:49:19'
            ] );



            HotelRoomService::create( [
            'id'=>59,
            'room_id'=>21,
            'hotel_id'=>26,
            'service'=>'Room with Breakfast and Dinner',
            'price'=>'4200',
            'extra_adult_price'=>'1470',
            'extra_child_price'=>'1050',
            'weekend_price'=>'6300',
            'extra_adult_weekend_price'=>'2105',
            'extra_child_weekend_price'=>'1575',
            'created_at'=>'2022-04-26 06:49:19',
            'updated_at'=>'2022-04-26 06:49:19'
            ] );



            HotelRoomService::create( [
            'id'=>60,
            'room_id'=>21,
            'hotel_id'=>26,
            'service'=>'Room with Breakfast, Lunch and Dinner',
            'price'=>'4500',
            'extra_adult_price'=>'1575',
            'extra_child_price'=>'1125',
            'weekend_price'=>'6300',
            'extra_adult_weekend_price'=>'2105',
            'extra_child_weekend_price'=>'1575',
            'created_at'=>'2022-04-26 06:49:19',
            'updated_at'=>'2022-04-26 06:49:19'
            ] );



            HotelRoomService::create( [
            'id'=>61,
            'room_id'=>22,
            'hotel_id'=>26,
            'service'=>'Room with Breakfast',
            'price'=>'4400',
            'extra_adult_price'=>'1540',
            'extra_child_price'=>'1100',
            'weekend_price'=>'6300',
            'extra_adult_weekend_price'=>'2105',
            'extra_child_weekend_price'=>'1575',
            'created_at'=>'2022-04-26 06:49:19',
            'updated_at'=>'2022-04-26 06:49:19'
            ] );



            HotelRoomService::create( [
            'id'=>62,
            'room_id'=>22,
            'hotel_id'=>26,
            'service'=>'Room with Breakfast and Dinner',
            'price'=>'4700',
            'extra_adult_price'=>'1645',
            'extra_child_price'=>'1175',
            'weekend_price'=>'6300',
            'extra_adult_weekend_price'=>'2105',
            'extra_child_weekend_price'=>'1575',
            'created_at'=>'2022-04-26 06:49:19',
            'updated_at'=>'2022-04-26 06:49:19'
            ] );



            HotelRoomService::create( [
            'id'=>63,
            'room_id'=>22,
            'hotel_id'=>26,
            'service'=>'Room with Breakfast, Lunch and Dinner',
            'price'=>'5000',
            'extra_adult_price'=>'1750',
            'extra_child_price'=>'1250',
            'weekend_price'=>'6300',
            'extra_adult_weekend_price'=>'2105',
            'extra_child_weekend_price'=>'1575',
            'created_at'=>'2022-04-26 06:49:19',
            'updated_at'=>'2022-04-26 06:49:19'
            ] );



            HotelRoomService::create( [
            'id'=>64,
            'room_id'=>23,
            'hotel_id'=>28,
            'service'=>'Room with Breakfast',
            'price'=>'8900',
            'extra_adult_price'=>'3115',
            'extra_child_price'=>'2225',
            'weekend_price'=>'6300',
            'extra_adult_weekend_price'=>'2105',
            'extra_child_weekend_price'=>'1575',
            'created_at'=>'2022-04-26 06:49:19',
            'updated_at'=>'2022-04-26 06:49:19'
            ] );



            HotelRoomService::create( [
            'id'=>65,
            'room_id'=>23,
            'hotel_id'=>28,
            'service'=>'Room with Breakfast and Dinner',
            'price'=>'9200',
            'extra_adult_price'=>'3220',
            'extra_child_price'=>'2300',
            'weekend_price'=>'9300',
            'extra_adult_weekend_price'=>'3320',
            'extra_child_weekend_price'=>'2400',
            'created_at'=>'2022-04-26 06:49:19',
            'updated_at'=>'2022-04-26 06:49:19'
            ] );



            HotelRoomService::create( [
            'id'=>66,
            'room_id'=>23,
            'hotel_id'=>28,
            'service'=>'Room with Breakfast, Lunch and Dinner',
            'price'=>'9500',
            'extra_adult_price'=>'3325',
            'extra_child_price'=>'2375',
            'weekend_price'=>'9600',
            'extra_adult_weekend_price'=>'3425',
            'extra_child_weekend_price'=>'2475',
            'created_at'=>'2022-04-26 06:49:19',
            'updated_at'=>'2022-04-26 06:49:19'
            ] );



            HotelRoomService::create( [
            'id'=>67,
            'room_id'=>24,
            'hotel_id'=>28,
            'service'=>'Room with Breakfast',
            'price'=>'5400',
            'extra_adult_price'=>'1890',
            'extra_child_price'=>'1350',
            'weekend_price'=>'5500',
            'extra_adult_weekend_price'=>'1990',
            'extra_child_weekend_price'=>'1450',
            'created_at'=>'2022-04-26 06:49:19',
            'updated_at'=>'2022-04-26 06:49:19'
            ] );



            HotelRoomService::create( [
            'id'=>68,
            'room_id'=>24,
            'hotel_id'=>28,
            'service'=>'Room with Breakfast and Dinner',
            'price'=>'5700',
            'extra_adult_price'=>'1995',
            'extra_child_price'=>'1425',
            'weekend_price'=>'5800',
            'extra_adult_weekend_price'=>'2995',
            'extra_child_weekend_price'=>'1525',
            'created_at'=>'2022-04-26 06:49:19',
            'updated_at'=>'2022-04-26 06:49:19'
            ] );



            HotelRoomService::create( [
            'id'=>69,
            'room_id'=>24,
            'hotel_id'=>28,
            'service'=>'Room with Breakfast, Lunch and Dinner',
            'price'=>'6000',
            'extra_adult_price'=>'2110',
            'extra_child_price'=>'1500',
            'weekend_price'=>'6100',
            'extra_adult_weekend_price'=>'2210',
            'extra_child_weekend_price'=>'1600',
            'created_at'=>'2022-04-26 06:49:19',
            'updated_at'=>'2022-04-26 06:49:19'
            ] );



            HotelRoomService::create( [
            'id'=>70,
            'room_id'=>25,
            'hotel_id'=>29,
            'service'=>'Room with Breakfast',
            'price'=>'5700',
            'extra_adult_price'=>'1645',
            'extra_child_price'=>'1175',
            'weekend_price'=>'5700',
            'extra_adult_weekend_price'=>'1745',
            'extra_child_weekend_price'=>'1275',
            'created_at'=>'2022-04-26 06:49:19',
            'updated_at'=>'2022-04-26 06:49:19'
            ] );



            HotelRoomService::create( [
            'id'=>71,
            'room_id'=>25,
            'hotel_id'=>29,
            'service'=>'Room with Breakfast and Dinner',
            'price'=>'6000',
            'extra_adult_price'=>'2100',
            'extra_child_price'=>'1500',
            'weekend_price'=>'6100',
            'extra_adult_weekend_price'=>'2200',
            'extra_child_weekend_price'=>'1600',
            'created_at'=>'2022-04-26 06:49:19',
            'updated_at'=>'2022-04-26 06:49:19'
            ] );



            HotelRoomService::create( [
            'id'=>72,
            'room_id'=>25,
            'hotel_id'=>29,
            'service'=>'Room with Breakfast, Lunch and Dinner',
            'price'=>'6300',
            'extra_adult_price'=>'2105',
            'extra_child_price'=>'1575',
            'weekend_price'=>'6400',
            'extra_adult_weekend_price'=>'2205',
            'extra_child_weekend_price'=>'1675',
            'created_at'=>'2022-04-26 06:49:19',
            'updated_at'=>'2022-04-26 06:49:19'
            ] );

            HotelRoomService::create( [
                'id'=>73,
                'room_id'=>26,
                'hotel_id'=>27,
                'service'=>'Room with Breakfast',
                'price'=>'5700',
                'extra_adult_price'=>'1645',
                'extra_child_price'=>'1175',
                'weekend_price'=>'5700',
                'extra_adult_weekend_price'=>'1745',
                'extra_child_weekend_price'=>'1275',
                'created_at'=>'2022-04-26 06:49:19',
                'updated_at'=>'2022-04-26 06:49:19'
                ] );
    
    
    
                HotelRoomService::create( [
                'id'=>74,
                'room_id'=>26,
                'hotel_id'=>27,
                'service'=>'Room with Breakfast and Dinner',
                'price'=>'6000',
                'extra_adult_price'=>'2100',
                'extra_child_price'=>'1500',
                'weekend_price'=>'6100',
                'extra_adult_weekend_price'=>'2200',
                'extra_child_weekend_price'=>'1600',
                'created_at'=>'2022-04-26 06:49:19',
                'updated_at'=>'2022-04-26 06:49:19'
                ] );
    
    
    
                HotelRoomService::create( [
                'id'=>75,
                'room_id'=>26,
                'hotel_id'=>27,
                'service'=>'Room with Breakfast, Lunch and Dinner',
                'price'=>'6300',
                'extra_adult_price'=>'2105',
                'extra_child_price'=>'1575',
                'weekend_price'=>'6400',
                'extra_adult_weekend_price'=>'2205',
                'extra_child_weekend_price'=>'1675',
                'created_at'=>'2022-04-26 06:49:19',
                'updated_at'=>'2022-04-26 06:49:19'
                ] );

                HotelRoomService::create( [
                    'id'=>76,
                    'room_id'=>11,
                    'hotel_id'=>12,
                    'service'=>'Room with Breakfast',
                    'price'=>'5700',
                    'extra_adult_price'=>'1645',
                    'extra_child_price'=>'1175',
                    'weekend_price'=>'5700',
                    'extra_adult_weekend_price'=>'1745',
                    'extra_child_weekend_price'=>'1275',
                    'created_at'=>'2022-04-26 06:49:19',
                    'updated_at'=>'2022-04-26 06:49:19'
                    ] );
        
        
        
                    HotelRoomService::create( [
                    'id'=>77,
                    'room_id'=>11,
                    'hotel_id'=>12,
                    'service'=>'Room with Breakfast and Dinner',
                    'price'=>'6000',
                    'extra_adult_price'=>'2100',
                    'extra_child_price'=>'1500',
                    'weekend_price'=>'6100',
                    'extra_adult_weekend_price'=>'2200',
                    'extra_child_weekend_price'=>'1600',
                    'created_at'=>'2022-04-26 06:49:19',
                    'updated_at'=>'2022-04-26 06:49:19'
                    ] );
        
        
        
                    HotelRoomService::create( [
                    'id'=>78,
                    'room_id'=>11,
                    'hotel_id'=>12,
                    'service'=>'Room with Breakfast, Lunch and Dinner',
                    'price'=>'6300',
                    'extra_adult_price'=>'2105',
                    'extra_child_price'=>'1575',
                    'weekend_price'=>'6400',
                    'extra_adult_weekend_price'=>'2205',
                    'extra_child_weekend_price'=>'1675',
                    'created_at'=>'2022-04-26 06:49:19',
                    'updated_at'=>'2022-04-26 06:49:19'
                    ] );


    }
}
