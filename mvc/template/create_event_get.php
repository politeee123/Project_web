<main>
    <div class="container">
        <h1>Create Event</h1>
        <form action="create_event" method="post"enctype="multipart/form-data">
            <div class="mb-3">
                <label for="event_name" class="form-label">Event Name</label>
                <input type="text" class="form-control" id="event_name" name="event_name" required>
            </div>
            <div class="mb-3">
                <!-- <label for="date" class="form-label">Date</label>
                <input type="date" class="form-control" id="date" name="date" required> -->
                <label for="datetime" class="form-label">Date & Time</label>
                <input type="datetime-local" class="form-control" id="datetime" name="datetime" required>
                
            </div>
            <div class="mb-3">
                <label for="location" class="form-label">Location</label>
                <input type="text" class="form-control" id="location" name="location" required>
            </div>
            <div class="mb-3">
                <label for="max_participants" class="form-label">Max Participants</label>
                <input type="number" class="form-control" id="max_participants" name="max_participants" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Image</label>
                <input type="file" class="form-control" id="image" name="image" accept="image/*" >
            </div>
            <button type="submit" class="btn btn-primary">Create</button>
        </form>
    </div>
</main>
