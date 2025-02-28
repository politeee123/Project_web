<section>
    <h1>Sign In</h1>
    <form action="sign_in" method="post">
        <label for="username">Username:</label><br>
        <input type="text" id="username" name="username" required><br><br>

        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" required><br><br>
        
        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" required><br><br>
        
        <label for="role">Role:</label><br>
        <select id="role" name="role" required>
            <option value="participant">Participant</option>
            <option value="creator">Creator</option>
        </select><br><br>

        <input type="submit" value="Sign In">
    </form>
</section>
