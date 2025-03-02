<?php
$event = $data['result']->fetch_assoc();
?>
<main>
    <div class="container mt-4">
        <h1>Edit Event</h1>
        <form action="edit_event" method="post" enctype="multipart/form-data">
            <input type="hidden" name="event_id" value="<?php echo htmlspecialchars($event['event_id']); ?>">

            <div class="mb-3">
                <label for="event_name" class="form-label">Event Name</label>
                <input type="text" class="form-control" id="event_name" name="event_name" value="<?php echo htmlspecialchars($event['event_name']); ?>" required>
            </div>

            <div class="mb-3">
                <label for="datetime" class="form-label">Date & Time</label>
                <input type="datetime-local" class="form-control" id="datetime" name="datetime" value="<?php echo htmlspecialchars($event['date']); ?> required>

            </div>

            <div class="mb-3">
                <label for="location" class="form-label">Location</label>
                <input type="text" class="form-control" id="location" name="location" value="<?php echo htmlspecialchars($event['location']); ?>" required>
            </div>

            <div class="mb-3">
                <label for="max_participants" class="form-label">Max Participants</label>
                <input type="number" class="form-control" id="max_participants" name="max_participants" value="<?php echo htmlspecialchars($event['max_participants']); ?>" required>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description" rows="3" required><?php echo htmlspecialchars($event['description']); ?></textarea>
            </div>

            <div class="mb-3">
                <label for="image" class="form-label">Image</label>
                <input type="file" class="form-control" id="image" name="image" accept="image/*" >

                <?php if (!empty($event['image'])): ?>
                    <p>Current Image:</p>
                    <img src="<?= htmlspecialchars($event['image']) ?>" alt="Event Image" style="width: 150px;">
                <?php endif; ?>
            </div>

            <button type="submit" class="btn btn-success">Update Event</button>
            <a href="event_view?event_id=<?php echo htmlspecialchars($event['event_id']); ?>" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</main>