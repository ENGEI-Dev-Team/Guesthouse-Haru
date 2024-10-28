<?php
// AirbnbとGoogleカレンダーのイベントデータ取得
namespace App\DDD\Reservation;

use Google_Client;
use Google_Service_Calendar;
use Sabre\VObject\Reader;

class EventService
{
  // AirbnbとGoogleカレンダーのイベントデータを取得
  public function fetchEventData()
  {
    $airbnbData = $this->fetchAirbnbCalendar();
    $googleData = $this->listEvents();
    return array_merge($googleData, $airbnbData);
  }

  // iCalendar（Airbnb）データの処理
  private function fetchAirbnbCalendar()
  {
    $icalUrl = 'https://www.airbnb.com/calendar/ical/621103954521198794.ics?s=ba65365a8b8f49af5a006a240769d5bc&locale=ja';
    $icalContent = file_get_contents($icalUrl);
    $vcalendar = Reader::read($icalContent);

    return array_map(function ($event) {
      return [
        'title' => $event->SUMMARY ?? '',
        'start' => (new DateFormatter())->formatDateTime($event->DTSTART),
        'end' => (new DateFormatter())->formatDateTime($event->DTEND),
        'description' => '予約あり',
      ];
    }, $vcalendar->select('VEVENT'));
  }

  // Google Calendarデータの処理
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
        'start' => (new DateFormatter())->formatDateTime($event->getStart()),
        'end' => (new DateFormatter())->formatDateTime($event->getEnd()),
        'description' => '予約あり',
      ];
    }, $events->getItems());
  }
}
