<?php
// 日付フォーマット
namespace App\DDD\Reservation;

class DateFormatter
{
    // 'Y-m-d'形式に変換
    public function formatDateTime($dateTime)
    {
        return $dateTime instanceof \DateTimeInterface
            ? $dateTime->format('Y-m-d')
            : (new \DateTime($dateTime))->format('Y-m-d');
    }
}
