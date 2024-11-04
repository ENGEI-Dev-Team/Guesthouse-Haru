<?php
// 予約可能日チェック
namespace App\DDD\Reservation;

class AvailabilityService
{
  // 予約可能な日付を取得
  public function getAvailableDates($eventData)
  {
    $eventRanges = $this->getEventRanges($eventData);
    return $this->checkAvailability($eventRanges);
  }

  // イベントの開始日と終了日を取得
  private function getEventRanges($eventData)
  {
    return array_map(function ($event) {
      return [
        new \DateTime($event['start']),
        new \DateTime($event['end'])
      ];
    }, $eventData);
  }

  // 指定された期間内の予約可能日を取得
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

  // イベント期間内に含まれているか確認
  private function isDateAvailable($date, $eventRanges)
  {
    foreach ($eventRanges as [$eventStart, $eventEnd]) {
      if ($date >= $eventStart && $date <= $eventEnd) {
        return false; // イベント範囲内は予約不可
      }
    }
    return true; // 予約可能
  }
}
