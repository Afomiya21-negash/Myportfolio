<?php
require_once 'connection/db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Dynamic Portfolio</title>
    <link rel="stylesheet" href="home.css">
</head>
<body>
<nav>
        <ul class="side">
            <li onclick = "hideSideBar()"><a href="#"><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#5f6368"><path d="m256-200-56-56 224-224-224-224 56-56 224 224 224-224 56 56-224 224 224 224-56 56-224-224-224 224Z"/></svg></a></li>
            <li><a href="#about">About</a></li>
            <li><a href="#experience">Experience</a></li>
            <li><a href="#projects">Projects</a></li>
            <li><a href="#contact">Contact</a></li>
        </ul>
        <ul>
            <h3><span style="color: #3b6d91;">A</span>fomiya</h3>
            <li class="hide"><a href="#about">About</a></li>
            <li class="hide"><a href="#experience">Experince</a></li>
            <li class="hide"><a href="#projects">Projects</a></li>
            <li class="hide"><a href="#contact">contact</a></li>
            <li onclick = "showSideBar()" class="menu"><a href="#"><svg xmlns="http://www.w3.org/2000/svg" height="26px" viewBox="0 -960 960 960" width="26px" fill="#5f6368"><path d="M120-240v-80h720v80H120Zm0-200v-80h720v80H120Zm0-200v-80h720v80H120Z"/></svg></a></li>

        </ul>
    </nav>

<!-- Hero Section (Dynamic) -->
<header class="hero">
    <div class="profile-container">
        <?php
        $hero = $db->getContentBySection('hero')->fetch_assoc();
        ?>
        <img src="<?= htmlspecialchars($hero['image_url']); ?>" alt="Profile Picture">
    </div>
    <div class="header-content">
        <h1>Hello, I'm <span style="color: #3b6d91;"><?= htmlspecialchars($hero['title']); ?></span></h1>
        <div class="btn-container">  
            <button><a href="#contact">Contact Info</a></button>
        </div>
    </div>
</header>

<!-- About Section -->
<section id="about" class="about-section">
    <h2>About Me</h2>
    <div id="about-content">
        <?php
        $result = $db->getContentBySection('about');
        while ($row = $result->fetch_assoc()) {
            echo "<div class='about-content'>
                    <h3>{$row['title']}</h3>
                    <p>{$row['description']}</p>
                    <img src='{$row['image_url']}' alt='{$row['title']}'>
                  </div>";
        }
        ?>
    </div>
</section>

<!-- Experience Section -->
<section id="experience" class="experience-section">
    <h2>Experience</h2>
    <div id="experience-content">
        <?php
        $result = $db->getContentBySection('experience');
        while ($row = $result->fetch_assoc()) {
            echo "<div class='experience-item'>
                    <h3>{$row['title']}</h3>
                    <p>{$row['description']}</p>
                  </div>";
        }
        ?>
    </div>
</section>

<!-- Projects Section -->
<section id="projects" class="projects-section">
    <h2>Projects</h2>
    <div id="projects-content">
        <?php
        $result = $db->getContentBySection('projects');
        while ($row = $result->fetch_assoc()) {
            echo "<div class='project-card'>
                    <img src='{$row['image_url']}' alt='{$row['title']}'>
                    <h3>{$row['title']}</h3>
                    <p>{$row['description']}</p>
                    <a href='{$row['project_link']}' target='_blank'>View Project</a>
                  </div>";
        }
        ?>
    </div>
</section>

<!-- Contact Section -->
<section id="contact" class="contact-section">
    <h2>Contact Me</h2>
    <div class="contact-links">
        <a href="mailto:afomiyamesfin@gmail.com">
            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#5f6368"><path d="M160-160q-33 0-56.5-23.5T80-240v-480q0-33 23.5-56.5T160-800h640q33 0 56.5 23.5T880-720v480q0 33-23.5 56.5T800-160H160Zm320-280L160-640v400h640v-400L480-440Zm0-80 320-200H160l320 200ZM160-640v-80 480-400Z"/></svg>
            afomiyamesfin@gmail.com
        </a>

        <a href="https://www.linkedinmobileapp.com/\?trk\=qrcode-onboarding" target="_parent">
            <img src="linkedin.png">
            LinkedIn 
        </a>
    </div>
</section>

<footer class="footer">
    <ul class="top-nav">
        <li><a href="#about">About</a></li>
        <li><a href="#experience">Experience</a></li>
        <li><a href="#projects">Projects</a></li>
        <li><a href="#contact">Contact</a></li>
    </ul>
</footer>
<div class="footer">
    &copy; 2024 Afomiya Mesfin. All rights reserved.
</div>

    <script src="home.js"></script>
</body>
</html>
