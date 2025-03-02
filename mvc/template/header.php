<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="mvc\template\css.css" rel="stylesheet">                   
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="/">Home</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <!-- <li class="nav-item">
                            <a class="nav-link" href="/">Home</a>
                        </li> -->
                        <li class="nav-item">
                            <a class="nav-link" href="/Event">Events</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/event_manage">Event Management</a>
                        </li>
                        <!-- <li class="nav-item">
                            <a class="nav-link" href="/create_event">Create</a>
                        </li> -->
                    </ul>
                    <ul class="navbar-nav ms-auto">
                    <?php
                        if (isset($_SESSION['user_id'])) {
                            echo '<li class="nav-item">';
                            echo '<span class="nav-link">Welcome, ' . $_SESSION['username'] . '</span>';
                            echo '</li>';
                            echo '<li class="nav-item">';
                            echo '<a class="btn btn-primary" href="/log_out">Log out</a>';
                            echo '</li>';
                        } else {
                            echo '<li class="nav-item">';
                            echo '<a class="btn btn-primary me-2" href="/login">Login</a>';
                            echo '</li>';
                            echo '<li class="nav-item">';
                            echo '<a class="btn btn-secondary" href="/sign_in">Sign In</a>';
                            echo '</li>';
                        }
                        ?>
                        
                        
                        <!-- <li class="nav-item">
                            <a class="btn btn-primary" href="/login">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-primary" href="/sign_in">sign in</a>
                        </li> -->
                    </ul>
                </div>
            </div>
        </nav>
    </header>