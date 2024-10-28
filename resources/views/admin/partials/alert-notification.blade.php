<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
{{-- <audio id="alertAudio">
    <source src="{{ asset('/assets/alert-109578.mp3')}}" type="audio/mpeg">
</audio> --}}
<script>
   
    var notificationQueue = [];

    // Add this function to check if a notification with a specific ID has already been shown
    function hasNotificationBeenShown(notificationId) {
        var shownNotifications = localStorage.getItem('shownNotifications');
        shownNotifications = shownNotifications ? JSON.parse(shownNotifications) : [];
        return shownNotifications.includes(notificationId);
    }

    function markNotificationAsShown(notificationId) {
        var shownNotifications = localStorage.getItem('shownNotifications');
        shownNotifications = shownNotifications ? JSON.parse(shownNotifications) : [];
        shownNotifications.push(notificationId);
        localStorage.setItem('shownNotifications', JSON.stringify(shownNotifications));
    }

    function showAlert(message,msgTitle,msgIcon,trip,primaryId) {

        if (!hasNotificationBeenShown(primaryId)) {

            markNotificationAsShown(primaryId);

            // console.log(arguments);
            var audio = document.getElementById("alertAudio");
            audio.play();

            var vehicle_no ='';
            var container_no = '';
            if(trip.container_details && trip.container_details!=undefined && trip.container_details!='') {
                if(trip.container_details.vehicle_no && trip.container_details.vehicle_no!=undefined && trip.container_details.vehicle_no!='') {
                    vehicle_no = trip.container_details.vehicle_no;
                }
            }
            
            if(trip.container_details && trip.container_details!=undefined && trip.container_details!='') {
                if(trip.container_details.container_no && trip.container_details.container_no!=undefined && trip.container_details.container_no!='') {
                    container_no = trip.container_details.container_no;
                }
            }
            
            // Constructing the HTML content for SweetAlert

            var color = '';
            var imagePath = '';
            //  marker.device_status='idle';
            if (trip.device_status == 'online') {
                color = 'green';
            } else if(trip.device_status == 'offline') {
                color = 'red';
            } else if(trip.device_status == 'idle') {
                color = 'orange';
            }

            let statusText;
            var colorLock = '';
            if (trip.lock == 'lock') {
                statusText = 'Lock';
                colorLock = 'green';
            } else {
                statusText = 'Unlock';
                colorLock = 'red';
            }

            const id = trip.id;

            var url = '{{ route("admin.device.live-tracking", ":id") }}';
            url = url.replace(':id',id);

            var htmlContent = `
                <div><h6 style="text-align: center;margin-bottom: 13px;font-size: 13px;color: red;">${message}</h6></div>

                <div class="" id="tripDetailsAlert" tabindex="-1" role="dialog" aria-labelledby="tripDetailsModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h6 class="modal-title" style="font-size: 13px;">TRIP DETAILS </h6>
                                <a href="${url}" class="float-right" style="font-size: 13px;">TRIP ID : ${trip.trip_id}</a>
                            </div>
                            
                            <div class="modal-body">
                                <hr style="margin: 0.5rem 0;">
                                <p class="mb-2"><strong>Device No: </strong> ${trip.device_id}</p>
                                <p class="mb-2"><strong>Vehicle No: </strong> ${vehicle_no}</p>
                                <p class="mb-2"><strong>Container No: </strong> ${container_no}</p>
                                <p class="mb-2"><strong>Trip Start Date: </strong> ${trip.trip_start_date_f}</p>
                                <p class="mb-2"><strong>Expected Arrival Time: </strong> ${trip.expected_arrival_time_f}</p>
                                <p class="mb-2"><strong>Address: </strong> Manter Wadi, Haveli, Pune, Maharashtra, 412308, India, Manter Wadi, Pune, Maharashtra, IN, 412308</p>
                            </div>
                        </div>
                    </div>
                </div>
            `;

            
            Swal.fire({
                title: msgTitle,
                text: message,
                iconHtml: '<img src="https://gpspackseal.in/assets/icon/unlock.gif" style="width: 40px;">',
                // imageUrl: '<img src="https://gpspackseal.in/assets/icon/unlock.gif" >',
                // icon: '<img src="https://gpspackseal.in/assets/icon/unlock.gif" >',
                html: htmlContent,
                width: '22em',
                customClass: {
                    container: 'ps-alert', // Add your custom class for additional styling
                    popup: 'custom-swal-popup', // Optional: Add custom class for the popup
                },
                // timer: 5000,
                // showConfirmButton: false,
            }).then(function () {
                // After the alert is closed, show the next one if available
                showNextAlert();
            });

        }
    }

    function showNextAlert() {
        if (notificationQueue.length > 0) {
            var notification = notificationQueue.shift(); // Get the next notification
            showAlert(notification.alert_message, notification.title, notification.icon,notification.trip,notification.id);
        }
    }

    // setInterval(function () {
    //     fetch("{{ route('admin.show-alert') }}")
    //         .then(response => response.json())
    //         .then(data => {
    //             showAlert(data.message);
    //         })
    //         .catch(error => console.error('Error:', error));
    // }, 10000);
    
    
    // function waitForMsg(){
    //     /* This requests the url "msgsrv.php"
    //     When it complete (or errors)*/
    //     $.ajax({
    //         type: "GET",
    //         url: "{{ route('admin.show-alert') }}",

    //         async: true, /* If set to non-async, browser shows page as "Loading.."*/
    //         cache: false,
    //         timeout:50000, /* Timeout in ms */

    //         success: function(data){ /* called when request to barge.php completes */
    //             const status = data.status;
    //             const icon = data.icon;
    //             if(status == true) {

    //                 showAlert(data.message,data.title,icon); /* Add response to a .msg div (with the "new" class)*/
    //             } else {
    //                 setTimeout(
    //                     waitForMsg, /* Request next message */
    //                     5000 /* ..after 1 seconds */
    //                 );
    //             }
               
    //         },
    //         error: function(XMLHttpRequest, textStatus, errorThrown){
    //             showAlert("error");
    //             setTimeout(
    //                 waitForMsg, /* Try again after.. */
    //                 15000); /* milliseconds (15seconds) */
    //         }
    //     });
    // };

    function waitForMsg() {
        $.ajax({
            type: "GET",
            url: "{{ route('admin.show-alert') }}",
            async: true,
            cache: false,
            timeout: 500000,
            success: function (data) {
                console.log(data);
                const notifications = data.alert_notification;
                if (notifications.length > 0) {
                    $('#event_notify').DataTable().ajax.reload();
                    // Loop through each notification in the array
                    notificationQueue = notificationQueue.concat(notifications);
                    if (notificationQueue.length === notifications.length) {
                        showNextAlert();
                    }
                }
                setTimeout(waitForMsg, 60000);
              //  setTimeout(waitForMsg, 6000000000);
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                showAlert("error");
                // Try again after 15 seconds in case of an error
                //setTimeout(waitForMsg, 60000000000);
                setTimeout(waitForMsg, 60000);
            }
        });
    }
    $(document).ready(function(){
        waitForMsg(); /* Start the inital request */
    });
  </script>