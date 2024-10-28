<?php

namespace App\Http\Controllers;

use App\DDD\Reservation\EventService;
use App\DDD\Reservation\AvailabilityService;

class ReservationController extends Controller
{
    protected $eventService;
    protected $availabilityService;

    public function __construct(EventService $eventService, AvailabilityService $availabilityService)
    {
        $this->eventService = $eventService;
        $this->availabilityService = $availabilityService;
    }

    public function index()
    {
        $eventData = $this->eventService->fetchEventData();

        $availableDates = $this->availabilityService->getAvailableDates($eventData);

        $availableEvents = $this->convertToAvailableEvents($availableDates);

        // eventDataは非表示
        return view('user.reservation', [
            'eventData' => [], 
            'availableEvents' => $availableEvents
        ]);
    }

    private function convertToAvailableEvents($availableDates)
    {
        return array_map(function ($date) {
            return [
                'title' => '○',
                'start' => $date,
                'color' => '#3cb371',
                'clickable' => true,
            ];
        }, $availableDates);
    }
}
