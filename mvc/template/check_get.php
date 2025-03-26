<?php

if (!empty($data['result']) && $data['result']->num_rows > 0) {
    $event = $data['result']->fetch_assoc();
    $event_id = $event['event_id'];
    $unique_id_count = getUniqueParticipantsCount($event_id);
    $max_participants = $event['max_participants'];
    $available_slots = $max_participants - $unique_id_count;

    echo '<h1 class="text-center">Event Details</h1>';
    echo '<div class="container">';
    echo '<div class="row justify-content-center">';
    echo '<div class="col-md-6 mb-4">';
    echo '<div class="card shadow-sm h-100">';

   
    // $image_path = !empty($event['image']) ? '/' . htmlspecialchars($event['image']) : '/public/uploads/default.jpg';
    // echo sprintf('<img src="%s" class="card-img-top" alt="Event Image" style="height: 200px; object-fit: cover;">', $image_path);
    $images = json_decode($event['image'], true); 
                if (!empty($images)) {
                    $first_image = $images[0];
                    $image_url =htmlspecialchars($first_image);
                } else {
                    $image_url = 'http://www.demoweb.lnw.mn/public/default_image.jpg';
                }
    echo '<img src="' . $image_url . '" class="card-img-top" alt="Event Image" style="height: 200px; object-fit: cover;">';
    // ข้อมูลกิจกรรม
    echo '<div class="card-body">';
    echo sprintf('<h2 class="card-title">%s</h2>', htmlspecialchars($event['event_name']));
    echo sprintf('<p class="card-text"><strong>Date:</strong> %s</p>', htmlspecialchars($event['date']));
    echo sprintf('<p class="card-text"><strong>Location:</strong> %s</p>', htmlspecialchars($event['location']));
    if ($available_slots > 0) {
        echo '<p class="card-text"><strong>Remaining Spots:</strong> ' .$unique_id_count.'/'.$available_slots . '</p>';
        echo '<p class="card-text"><strong>Perset:</strong> ' . floor(($unique_id_count/$available_slots)*100) . '%</p>';
        echo '<p class="card-text"><strong>Description:</strong> ' . $event['description'] . '</p>';
    } 
    else {
        echo '<p class="card-text"><strong>Remaining Spots:</strong> Full</p>';
        echo '<p class="card-text"><strong>Description:</strong> ' . $event['description'] . '</p>';
    }
    echo '</div>'; 

    
    echo '<div class="card-footer text-center">';
?>
    <main>
    <form action="check" method="POST">
        <input type="hidden" name="event_id" value="<?php echo htmlspecialchars($event['event_id']); ?>">

        <label for="status">Status:</label>
        <div class="radio-container">
            <input type="radio" id="checked-in" name="status" value="checked-in">
            <label for="checked-in">Check in</label>

            <input type="radio" id="not-checked-in" name="status" value="not checked-in" >
            <label for="not-checked-in">Check Out</label>
        </div>

        <button class="btn mt-3">Submit</button>
    </form>
</main>


<?php
    echo '</div>'; 

    echo '</div>'; 
    echo '</div>'; 
    echo '</div>'; 
    echo '</div>'; 



} else {
    echo '<p class="text-center">Event not found.</p>';
}
?>

<style>
    body {
        font-family: 'Arial', sans-serif;
        background-color: #f8f9fa;
        color: #333;
    }

    .container {
        margin-top: 50px;
    }

    .card {
        border: 1px solid #ddd;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .card-body {
        padding: 20px;
    }

    .card-img-top {
        border-radius: 8px;
        object-fit: cover;
        height: 200px;
    }

    .card-footer {
        background-color: #f8f9fa;
        padding: 10px;
        text-align: center;
        border-top: 1px solid #ddd;
    }

    .card-title {
        font-size: 24px;
        font-weight: bold;
        color: #343a40;
    }

    .card-text {
        font-size: 16px;
        color: #6c757d;
        margin-bottom: 10px;
    }

    .card-footer form {
        margin-top: 15px;
    }

    label {
        font-weight: bold;
        margin-bottom: 10px;
    }

    .form-select {
        width: 100%;
        padding: 8px;
        margin-bottom: 10px;
        border-radius: 5px;
        border: 1px solid #ddd;
    }

    .btn {
        background-color: #007bff;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .btn:hover {
        background-color: #0056b3;
    }

    .radio-container {
        display: flex;
        justify-content: center;
        gap: 20px;
    }

    .radio-container input[type="radio"] {
        display: none;
    }

    .radio-container label {
        display: inline-block;
        padding: 10px 20px;
        border-radius: 50px;
        background-color: #f8f9fa;
        border: 2px solid #007bff;
        font-size: 16px;
        cursor: pointer;
        transition: background-color 0.3s ease, border-color 0.3s ease;
    }

    .radio-container input[type="radio"]:checked + label {
        background-color: #007bff;
        color: white;
        border-color: #0056b3;
    }

    .radio-container label:hover {
        background-color: #007bff;
        color: white;
        border-color: #0056b3;
    }
</style>
