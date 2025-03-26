<main>
    <div class="container">
        <h1>สร้างกิจกรรม</h1>
        <form action="create_event" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="event_name" class="form-label">ชื่อกิจกรรม</label>
                <input type="text" class="form-control" id="event_name" name="event_name" required>
            </div>
            <div class="mb-3">
                <label for="datetime" class="form-label">วันที่และเวลา</label>
                <input type="datetime-local" class="form-control" id="datetime" name="datetime" required>
            </div>
            <div class="mb-3">
                <label for="location" class="form-label">ที่ตั้ง</label>
                <input type="text" class="form-control" id="location" name="location" required>
            </div>
            <div class="mb-3">
                <label for="max_participants" class="form-label">จำนวนผู้เข้าร่วมสูงสุด</label>
                <input type="number" class="form-control" id="max_participants" name="max_participants" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">คำอธิบาย</label>
                <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
            </div>
            
            <div class="mb-3">
                <label for="images" class="form-label">รูป</label>
                <input type="file" class="form-control" id="images" name="images[]" accept="image/*" multiple onchange="previewImages()">
            </div>

            <!-- 🔹 ส่วนแสดงตัวอย่างรูปภาพ -->
            <div id="preview" class="d-flex flex-wrap"></div>

            <button type="submit" class="btn btn-primary">สร้าง</button>
        </form>
    </div>
</main>

<script>
function previewImages() {
    let preview = document.getElementById("preview");
    let files = document.getElementById("images").files;
    
    preview.innerHTML = ""; // ล้างรูปเก่า

    if (files.length > 0) {
        Array.from(files).forEach(file => {
            let reader = new FileReader();
            reader.onload = function(e) {
                let img = document.createElement("img");
                img.src = e.target.result;
                img.className = "m-2"; // เพิ่ม margin
                img.style.width = "120px"; 
                img.style.height = "120px";
                img.style.objectFit = "cover";
                img.style.border = "1px solid #ddd";
                img.style.borderRadius = "8px";
                preview.appendChild(img);
            };
            reader.readAsDataURL(file);
        });
    }
}
</script>
