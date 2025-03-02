<?php
if (isset($data['result']) && $data['result']->num_rows > 0) {
    echo '<div class="container">';
    echo '<div class="row">';

    while ($row = $data['result']->fetch_assoc()) { 
        echo '<div class="col-md-4 mb-4">';
        echo '<div class="card shadow-sm h-100">';

        $image_path = !empty($row['image']) ? '/' . htmlspecialchars($row['image']) : '/public/uploads/default.jpg';
        
        echo '<img src="' . $image_path . '" class="card-img-top" alt="Event Image" style="height: 200px; object-fit: cover;">';
        echo '<div class="card-body">';
        echo '<h5 class="card-title">' . htmlspecialchars($row['event_name']) . '</h5>';
        echo '<p class="card-text"><strong>Date:</strong> ' . htmlspecialchars($row['date']) . '</p>';
        echo '<p class="card-text"><strong>Location:</strong> ' . htmlspecialchars($row['location']) . '</p>';
        echo '<p class="card-text"><strong>Max Participants:</strong> ' . htmlspecialchars($row['max_participants']) . '</p>';
        echo '<p class="card-text"><strong>Description:</strong> ' . htmlspecialchars($row['description']) . '</p>';
        ?>
        <form action="event_register" method="POST">
            <input type="hidden" name="event_id" value="<?php echo htmlspecialchars($row['event_id']); ?>">
            
            <label for="status">Status:</label>
            <select name="status" class="form-select">
                <option value="pending">Approved</option>
                <option value="rejected">Rejected</option>
            </select>
            
            <button type="submit" class="btn btn-primary mt-2">Press</button>
        </form>

        <?php
        
        echo '</div>'; 
        echo '</div>'; 
        echo '</div>'; 
    }
    echo '</div>';
    echo '</div>'; 
} else {
    echo '<p class="text-center">No events found.</p>';
}

    // if ($result->num_rows > 0) {
    //     // แสดงข้อมูลกิจกรรม
    //     $row = $result->fetch_assoc();
    //     echo '<div class="container">';
    //     echo '<h1>' . $row['event_name'] . '</h1>';
    //     echo '<p><strong>Date:</strong> ' . $row['date'] . '</p>';
    //     echo '<p><strong>Location:</strong> ' . $row['location'] . '</p>';
    //     echo '<p><strong>Max Participants:</strong> ' . $row['max_participants'] . '</p>';
    //     echo '<p><strong>Description:</strong> ' . $row['description'] . '</p>';
    //     echo '<a href="event_register?event_id=' . htmlspecialchars($row['event_id']) . '" class="btn btn-primary">Register</a>';
    //     echo '</div>'; // container
    // } else {
    //     echo '<p>Event not found.</p>';
    // }


