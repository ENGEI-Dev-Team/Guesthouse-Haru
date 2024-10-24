<?php

namespace App\Http\Controllers;

use Google_Client;
use Google_Service_Calendar;
use Illuminate\Http\Request;
use Sabre\VObject\Reader;

class ReservationController extends Controller
{
    public function index()
    {
        // AirbnbデータとGoogle Calendarのイベントデータを取得
        $eventData = $this->fetchEventData();

        // 予約可能日を取得
        $availableDates = $this->getAvailableDates($eventData);

        // 予約可能日をイベント形式に変換
        $availableEvents = $this->convertToAvailableEvents($availableDates);

        // eventDataは非表示
        return view('user.reservation', [
            'eventData' => [], 
            'availableEvents' => $availableEvents
        ]);
    }

    // AirbnbとGoogle Calendarのイベントデータを取得するメソッド
    private function fetchEventData()
    {
        $airbnbData = $this->fetchAirbnbCalendar();
        $googleData = $this->listEvents();
        return array_merge($googleData, $airbnbData);
    }

    // 予約可能日を取得するメソッド
    private function getAvailableDates($eventData)
    {
        $eventRanges = $this->getEventRanges($eventData);
        return $this->checkAvailability($eventRanges);
    }

    // イベント範囲を取得するメソッド
    private function getEventRanges($eventData)
    {
        return array_map(function ($event) {
            return [
                new \DateTime($event['start']),
                new \DateTime($event['end'])
            ];
        }, $eventData);
    }

    // 日付の予約可能性をチェックするメソッド
    private function checkAvailability($eventRanges)
    {
        $availableDates = [];
        $startDate = new \DateTime('now'); 
        $endDate = (new \DateTime('now'))->modify('+3 months');

        for ($date = $startDate; $date <= $endDate; $date->modify('+1 day')) {
            $formattedDate = $date->format('Y-m-d');
            if ($this->isDateAvailable($date, $eventRanges)) {
                $availableDates[] = $formattedDate;
            }
        }

        return $availableDates;
    }

    // 日付が予約可能か確認するメソッド
    private function isDateAvailable($date, $eventRanges)
    {
        foreach ($eventRanges as [$eventStart, $eventEnd]) {
            if ($date >= $eventStart && $date <= $eventEnd) {
                return false; // イベント範囲内であれば、予約不可
            }
        }
        return true; // 予約可能
    }

    // 予約可能日をイベント形式に変換するメソッド
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

    // Airbnbカレンダーを取得するメソッド
    private function fetchAirbnbCalendar()
    {
        $icalUrl = 'https://www.airbnb.com/calendar/ical/621103954521198794.ics?s=ba65365a8b8f49af5a006a240769d5bc&locale=ja';
        $icalContent = file_get_contents($icalUrl);
        $vcalendar = Reader::read($icalContent);

        return array_map(function ($event) {
            return [
                'title' => $event->SUMMARY ?? '',
                'start' => $this->formatDateTime($event->DTSTART),
                'end' => $this->formatDateTime($event->DTEND),
                'description' => '予約あり',
            ];
        }, $vcalendar->select('VEVENT'));
    }

    // 日付時間をフォーマット
    private function formatDateTime($dateTime)
    {
        return $dateTime instanceof \DateTimeInterface
            ? $dateTime->format('Y-m-d')
            : (new \DateTime($dateTime))->format('Y-m-d');
    }

    // Google Calendarからイベントをリストするメソッド
    private function listEvents()
    {
        $client = new Google_Client();
        $client->setApplicationName('haru'); 
        $client->setAuthConfig(env('GOOGLE_SERVICE_ACCOUNT_JSON')); 
        $client->addScope(Google_Service_Calendar::CALENDAR_READONLY);

        $service = new Google_Service_Calendar($client);
        $calendarId = env('GOOGLE_CALENDAR_ID');
        $events = $service->events->listEvents($calendarId);

        return array_map(function ($event) {
            return [
                'title' => $event->getSummary(),
                'start' => $this->formatDateTime($event->getStart()),
                'end' => $this->formatDateTime($event->getEnd()),
                'description' => '予約あり',
            ];
        }, $events->getItems());
    }
}