<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    </head>
    <body>
    <section class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h1 class="card-title text-center mb-0">ลงชื่อเข้าใช้</h1>
                    </div>
                    <div class="card-body">
                        <form action="sign_in" method="post">
                            <div class="mb-3">
                                <label for="username" class="form-label">ชื่อ:</label>
                                <input type="text" id="username" name="username" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">อีเมล:</label>
                                <input type="email" id="email" name="email" class="form-control" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="password" class="form-label">รหัสผ่าน:</label>
                                <input type="password" id="password" name="password" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">ยืนยันรหัสผ่าน:</label>
                                <input type="password" id="confirm_password" name="confirm_password" class="form-control" required>
                            </div>

                            <!-- <div class="mb-3">
                                <label for="role" class="form-label">Role:</label>
                                <select id="role" name="role" class="form-select" required>
                                    <option value="participant">Participant</option>
                                    <option value="creator">Creator</option>
                                </select>
                            </div> -->
    
                            <div class="d-grid">
                                <button type="submit" class="btn btn-success">ลงชื่อเข้าใช้</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
</body>
</html>