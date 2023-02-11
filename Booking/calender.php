<?php
    require_once('../Database.php');
    require_once('../Utils.php');
    require_once('./Booking.php');

    $db = Database::dbConnect();
    $Booking = new Booking($db);
    $Bookings = $Booking->getDataForFullCalendar();
?>
<html lang='ja'>
  <head>
    <meta charset='utf-8' />
    <script src='https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.4/index.global.min.js'></script>
    <script src='https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid@6.1.4/index.global.min.js'></script>
    <script>
        var bookings = JSON.parse('<?php echo $Bookings; ?>');
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                events: bookings,
                eventClick: function(info) {
                    $('.modal').modal('show');
                    $('.modal-name').text(info.event.title);
                    $('.phone').text(info.event.extendedProps.phone);
                    $('.postal-code').text(info.event.extendedProps.postal_code);
                    $('.address').text(info.event.extendedProps.address);
                    $('.member').text(info.event.extendedProps.member);
                    $('.memo').text(info.event.extendedProps.memo);
                }
            });
            calendar.render();
        });
    </script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
  </head>
  <body>
    <div id='calendar'></div>
    <div class="modal fade" id="bookingModal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-name"></h4>
                    <button class="close btn-close" data-dismiss="modal"> &times; </button>
                </div>
                <div class="modal-body">
                    <p>電話番号：<span class="phone"></span></p>
                    <p>郵便番号：<span class="postal-code"></span></p>
                    <p>住所：<span class="address"></span></p>
                    <p>人数：<span class="member"></span></p>
                    <p>メモ：<span class="memo"></span></p>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
  </body>
</html>