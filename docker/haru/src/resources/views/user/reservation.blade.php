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
    <h2 class="section-title">Pricing & House Information</h2>

    <div class="detail-group">
      <div class="detail-head">
        <p>Basic price (7 guests maximum)</p>
      </div>
      <div class="detail-text">
        <p>¥25,000 per room </p>
      </div>
    </div>

    <div class="detail-group">
      <div class="detail-head">
        <p>Additional charge from 3 guests</p>
      </div>
      <div class="detail-text">
        <p> ¥8,000 per person (Adult) </p>
        <p>¥4,000 per night (Elementary school students)</p>
        <p>Free (Under 6 years old)</p>
      </div>
    </div>

    <div class="detail-group">
      <div class="detail-head">
        <p>Check-in</p>
      </div>
      <div class="detail-text">
        <p>15:00～18:00</p>
      </div>
    </div>

    <div class="detail-group">
      <div class="detail-head">
        <p>Check-out</p>
      </div>
      <div class="detail-text">
        <p>~ 10:00</p>
      </div>
    </div>

    <div class="detail-group">
      <div class="detail-head">
        <p>Meals</p>
      </div>
      <div class="detail-text">
        <p>¥800 for Breakfast at the guesthouse. If you would like to have breakfast, please let us know when making your reservation.</p>
      </div>
    </div>

    <div class="detail-group">
      <div class="detail-head">
        <p>Adrress</p>
      </div>
      <div class="detail-text">
        <p>2488 Karato, Tonosho-cho, Shodoshima District, Kagawa, Japan</p>
      </div>
    </div>
  </div>
</section>


<div id="overlay" class="overlay"></div>
<div id="infoModal" class="modal">
  <div class="modal-content">
    <button id="closeModal" class="close-button" aria-label="Close modal">&times;</button>
    <h2 class="modal-title">House Rules and Important Information</h2>

    <p class="modal-text"><strong>1.</strong> Please minimize noise during nighttime hours from 9:00 PM.</p>

    <p class="modal-text"><strong>2.</strong> The entire facility is non-smoking. Please use designated areas for smoking, including heated tobacco products.</p>

    <p class="modal-text"><strong>3.</strong> During the Setouchi Triennale, traffic may be heavy, with many elderly drivers on the island. Please drive carefully and observe traffic manners.</p>

    <p class="modal-text"><strong>4.</strong> There are no convenience stores and ATMs are limited to Japan Post Bank and JA Bank. Most transactions are cash-based, so please ensure you have sufficient cash and necessary items before your visit.</p>

    <p class="modal-text"><strong>5.</strong> Access to the house is restricted to registered guests only; non-guests are not allowed to enter.</p>

    <p class="modal-text"><strong>6.</strong> Guests will be held responsible for any damage or destruction of the facility caused by negligence. Lost keys will also incur a compensation fee.</p>

    <p class="modal-text"><strong>7.</strong> In the event of a medical emergency, there are no hospitals on the island. You will need to arrange and pay for a sea taxi to go to hospital in Uno or Takamatsu.</p>

    <p class="modal-text"><strong>Important:</strong> 
    After your reservation is confirmed, we will send you a Google Form to confirm details. We appreciate your cooperation in providing responses to ensure a more comfortable stay.</p>

    <div class="modal-confirm">
      <label>
        <input type="checkbox" id="confirm-check" required>
        I have read and understood the rules.
      </label>
    </div>

    <div class="modal-buttons">
      <button id="airbnbButton" disabled>Book from Airbnb</button>
      <button id="vacationStayButton" disabled>Book from VacationSTAY</button>
    </div>
  </div>
</div>


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
        if (info.event.extendedProps.clickable) {
          showModal();
        }
      },
      eventContent: function(info) {
        return {
          html: '<span>' + info.event.title + '</span>'
        };
      }
    });

    calendar.render();

    function showModal() {
      const closeButton = document.getElementById('closeModal');
      const modal = document.getElementById('infoModal');
      const confirmCheck = document.getElementById('confirm-check');
      const airbnbButton = document.getElementById('airbnbButton');
      const vacationStayButton = document.getElementById('vacationStayButton');

      overlay.style.display = 'flex'; 
      modal.style.display = 'flex';

      closeButton.addEventListener('click',closeModal); 
      overlay.addEventListener('click', closeModal);


      confirmCheck.addEventListener('change', function() {
        if (confirmCheck.checked) {
          airbnbButton.disabled = false;
          vacationStayButton.disabled = false;
        } else {
          airbnbButton.disabled = true;
          vacationStayButton.disabled = true;
        }
      });

      airbnbButton.addEventListener('click', function() {
        window.location.href = 'https://www.airbnb.com/h/shimayado-haru';
      });

      vacationStayButton.addEventListener('click', function() {
        window.location.href = 'https://vacation-stay.jp/listings/266521';
      });

      function closeModal() {
        confirmCheck.checked = false;
        airbnbButton.disabled = true;
        vacationStayButton.disabled = true;

        modal.style.display = 'none';
        overlay.style.display = 'none'; 
      }
    }
  });
</script>
@endsection