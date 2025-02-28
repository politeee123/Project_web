<main>
    <h1>Event</h1>
    <form action="Event" method="get">
        <input type="text" name="keyword" />
        <button type="submit">Search</button>
    </form>
    <?php
    if (isset($data['result'])) {
        if ($data['result']->num_rows > 0) {
            echo '<table class="table">';
            echo '<thead class="table-dark">';
            echo '<tr>';
            echo '<th scope="col">Event ID</th>';
            echo '<th>Event Name</th>';
            echo '<th>Event Date And Times</th>';
            echo '<th>Location</th>';
            echo '<th>Description</th>';
            echo '<th>Max_participants</th>';
            echo '<th>Image</th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';
            while ($row = $data['result']->fetch_assoc()) {
                echo '<tr scope="row">';
                echo '<td >' . $row['event_id'] . '</td>';
                echo '<td >' . $row['event_name'] . '</td>';
                echo '<td >' . $row['date'] . '</td>';
                echo '<td >' . $row['location'] . '</td>';
                echo '<td >' . $row['description'] . '</td>';
                echo '<td >' . $row['max_participants'] . '</td>';
                echo '<td>' . $row['image'] . '</td>';
                echo '</tr>';
            }
            echo '</tbody>';
            echo '</table>';
        } else {
            echo '<p>No events found.</p>';
        }
    }
    ?>
</main>
