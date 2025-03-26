<?php


if (!empty($data['result']) && $data['result']->num_rows > 0) {

    $event = $data['result']->fetch_assoc();
    $images = json_decode($event['images'], true);
    if (!empty($images)) {
        $first_image = $images[0];
        $image_url = 'http://www.demoweb.lnw.mn/public/' . htmlspecialchars($first_image);
    } else {
        $image_url = 'http://www.demoweb.lnw.mn/public/default_image.jpg';
    }
    echo '<h1 class="text-center">Event Details</h1>';
    echo '<div class="container">';
    echo '<div class="row justify-content-center">';
    echo '<div class="col-md-6 mb-4">';
    echo '<div class="card shadow-sm h-100">';

   
    echo '<img src="' . $image_url . '" class="card-img-top" alt="Event Image" style="height: 200px; object-fit: cover;">';
  
    echo '<div class="card-body">';
    echo sprintf('<h2 class="card-title">%s</h2>', htmlspecialchars($event['event_name']));
    echo sprintf('<p class="card-text"><strong>Date:</strong> %s</p>', htmlspecialchars($event['date']));
    echo sprintf('<p class="card-text"><strong>Location:</strong> %s</p>', htmlspecialchars($event['location']));
    echo sprintf('<p class="card-text"><strong>Max Participants:</strong> %s</p>', htmlspecialchars($event['max_participants']));
    echo sprintf('<p class="card-text"><strong>Description:</strong> %s</p>', htmlspecialchars($event['description']));
    echo '</div>'; 

   
    echo '<div class="card-footer text-center">';
    echo sprintf(
        ' <a href="edit_event?event_id=%s" class="btn btn-info">Edit Event</a>',
        htmlspecialchars($event['event_id'])
    );
    // echo sprintf('<a href="edit_event?php?event_id=%s" class="btn btn-primary">Edit Event</a>', htmlspecialchars($event['event_id']));
    echo sprintf(
        ' <a href="check_status?event_id=%s" class="btn btn-info">Check Status</a>',
        htmlspecialchars($event['event_id'])
    );
    echo '</div>'; 

    echo '</div>'; 
    echo '</div>'; 
    echo '</div>'; 
    echo '</div>'; 



} else {
    echo '<p class="text-center">Event not found.</p>';
}
