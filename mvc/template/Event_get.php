<main>
    <h1>Event</h1>
    <div class="container_event mt-3 mb-3">
        <div class="row">
            <div class="col-md-6">
                <form action="Event" method="get">
                    <input type="text" name="keyword" />
                    <button type="submit">Search</button>
                </form>
            </div>
            <div class="col-md-6 text-end">
                <form action="create_event" method="get">
                    <button type="submit">Create Event</button>
                </form>
            </div>
        </div>
    </div>
    <?php
    if (isset($data['result'])) {
        if ($data['result']->num_rows > 0) {
            echo '<div class="container">';
            echo '<div class="row">';
            while ($row = $data['result']->fetch_assoc()) {
                echo '<div class="col-md-4 mb-4">'; // 3 คอลัมต่อแถว
                echo '<div class="card shadow-sm h-100">'; // ใช้ Bootstrap Card
                echo '<img src="' . htmlspecialchars($row['image']) . '" class="card-img-top" alt="Event Image" style="height: 200px; object-fit: cover;">'; 
                echo '<div class="card-body">';
                echo '<h5 class="card-title">' . $row['event_name'] . '</h5>';
                echo '<p class="card-text"><strong>Date:</strong> ' . $row['date'] . '</p>';
                echo '<p class="card-text"><strong>Location:</strong> ' . $row['location'] . '</p>';
                echo '<p class="card-text"><strong>Max Participants:</strong> ' . $row['max_participants'] . '</p>';
                echo '<p class="card-text"><strong>Description:</strong> ' . $row['description'] . '</p>';
                echo '<a href="event_register?event_id=' . htmlspecialchars($row['event_id']) . '" class="btn btn-primary">Register</a>';
                echo '</div>';
                echo '</div>'; 
                echo '</div>'; 
            }
            echo '</div>'; 
            echo '</div>'; 
        } else {
            echo '<p class="text-center">No events found.</p>';
        }
    }
    ?>
</main>
