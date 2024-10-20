@extends('layouts.user_layout')

@section('title', '予約ページ')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/reservation.css') }}">
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js'></script>
@endsection

@section('content')
<section class="top-section">
  <img src="{{ asset('images/teshima5.jpg') }}" alt="豊島の風景" class="top-image">
  <div class="top-texts">
    <h3 class="top-title animated-text">Welcome to Haru.</h3>
  </div>
</section>

<section class="reservation-calendar">
  <div class="inner">
    <h2 class="section-title calendar-text">Available day</h2>
    <div id="calendar"></div>
    <p class="calendar-description">*Please select the dates you wish to book and check the details on each booking site (Airbnb, vacationSTAY).</p>
  </div>
</section>

<section class="booking-detail">
  <div class="inner">
    <h2 class="section-title">Pricing & Booking Information</h2>

    <div class="detail-group">
      <div class="detail-head">
        <p>Basic price</p>
      </div>
      <div class="detail-text">
        <p>¥25,000 per room (excluding tax)</p>
      </div>
    </div>

    <div class="detail-group">
      <div class="detail-head">
        <p>Additional charges per person</p>
      </div>
      <div class="detail-text">
        <p>Additional charge from 3 guests: ¥8,000 per person per night (excluding tax)</p>
        <p>Elementary school students: ¥4,000 per night (excluding tax)</p>
        <p>Children under 6 years old (pre-school age): Free</p>
      </div>
    </div>

    <div class="detail-group">
      <div class="detail-head">
        <p>Check-in / out</p>
      </div>
      <div class="detail-text">
        <p>15:00 ~ / ~ 10:00</p>
      </div>
    </div>
  </div>
</section>
@endsection

@section('scripts')
<script src='https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.5/main.min.js'></script>
<script src='https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid@6.1.5/main.min.js'></script>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var events = @json($availableEvents);

    var calendar = new FullCalendar.Calendar(calendarEl, {
      initialView: 'dayGridMonth',
      events: events,
      eventClick: function(info) {
        alert('Available date clicked: ' + info.event.start.toISOString().slice(0, 10));
      },
    });

    calendar.render();
  });
</script>
@endsection