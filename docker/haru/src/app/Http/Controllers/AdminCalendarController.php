<?php

namespace App\Http\Controllers;

use Google_Client;
use Google_Service_Calendar;
use Illuminate\Http\Request;
use Sabre\VObject\Reader;

class AdminCalendarController extends Controller
{
    public function fetchEventData()
    {
        // Airbnbカレンダーから予約情報を取得
        $airbnbData = $this->fetchAirbnbCalendar();

        return $this->convertToAvailableEvents($airbnbData);
    }

    // Airbnbカレンダーを取得
    private function fetchAirbnbCalendar()
    {
        $icalUrl = 'https://www.airbnb.com/calendar/ical/621103954521198794.ics?s=ba65365a8b8f49af5a006a240769d5bc&locale=ja';
        $icalContent = file_get_contents($icalUrl);
        $vcalendar = Reader::read($icalContent);

        return array_filter(array_map(function ($event) {
            $summary = (string)$event->SUMMARY;
            // "Reserved"のSUMMARYを持つイベントだけを取得
            if ($summary === "Reserved") {
                $description = (string)$event->DESCRIPTION;
                // URLを抽出
                preg_match('/Reservation URL: (https[^"]+)/', $description, $matches);
                $url = $matches[1] ?? null;

                return [
                    'start' => $this->formatDateTime($event->DTSTART),
                    'end' => $this->formatDateTime($event->DTEND),
                    'url' => $url,
                    'description' => '予約あり',
                ];
            }
            return null; //
        }, $vcalendar->select('VEVENT')), function ($event) {
            return !is_null($event); 
        });
    }

    // 日付時間をフォーマット
    private function formatDateTime($dateTime)
    {
        return $dateTime instanceof \DateTimeInterface
            ? $dateTime->format('Y-m-d')
            : (new \DateTime($dateTime))->format('Y-m-d');
    }

    // 予約可能日をイベント形式に変換
    private function convertToAvailableEvents($airbnbData)
    {
        return array_map(function ($event) {
            return [
                'title' => '予約',
                'start' => $event['start'],
                'end' => $event['end'],
                'url' => $event['url'],
                'description' => $event['description'],
                'color' => '#3cb371',
                'clickable' => true,
            ];
        }, $airbnbData);
    }
}