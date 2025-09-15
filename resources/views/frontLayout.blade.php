<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SOS - Social Organization System | Welcome</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <style>
        :root {
            --primary-color: #6a11cb;
            --secondary-color: #2575fc;
            --dark-color: #121224;
            --dark-grey: #1c1c2e;
            --light-color: #f8f9fa;
            --body-bg: #ffffff;
            --text-color: #495057;
            --text-light: #6c757d;
            --card-bg: #ffffff;
            --shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            --border-radius: 12px;
        }

        body {
            font-family: 'Poppins', sans-serif;
            color: var(--text-color);
            background-color: var(--body-bg);
            scroll-behavior: smooth;
        }

        h1, h2, h3, h4, h5, h6 {
            font-weight: 600;
            color: var(--dark-color);
        }

        .section {
            padding: 80px 0;
        }

        .section-title {
            text-align: center;
            margin-bottom: 60px;
        }
        .section-title h2 {
            font-size: 2.8rem;
            margin-bottom: 15px;
            position: relative;
            display: inline-block;
        }
        .section-title h2::after {
            content: '';
            width: 70px;
            height: 4px;
            background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
            position: absolute;
            bottom: -15px;
            left: 50%;
            transform: translateX(-50%);
            border-radius: 2px;
        }
        .section-title p {
            color: var(--text-light);
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }

        /* --- Navbar --- */
        .navbar {
            transition: all 0.4s ease;
            padding: 1rem 0;
        }
        .navbar.scrolled {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            padding: 0.75rem 0;
        }
        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            color: var(--primary-color) !important;
        }
        .nav-link {
            font-weight: 500;
            color: var(--dark-color) !important;
        }
        .navbar.scrolled .nav-link { color: var(--dark-color) !important; }

        /* --- Hero Section --- */
        .hero {
            position: relative;
            height: 100vh;
            background-image: url('https://images.unsplash.com/photo-1521737604893-d14cc237f11d?q=80&w=2084&auto=format&fit=crop');
            background-size: cover;
            background-position: center;
            color: #fff;
            display: flex;
            align-items: center;
        }
        .hero-overlay {
            position: absolute; top: 0; left: 0; width: 100%; height: 100%;
            background: linear-gradient(45deg, rgba(106, 17, 203, 0.8), rgba(37, 117, 252, 0.8));
        }
        .hero .container { position: relative; z-index: 2; }
        .hero h1 { font-size: 3.8rem; font-weight: 700; color: #fff; }
        .hero p { font-size: 1.2rem; font-weight: 300; color: rgba(255, 255, 255, 0.9); }
        .btn-primary {
            background-color: #fff;
            color: var(--primary-color);
            border: none;
            padding: 14px 32px;
            border-radius: 50px;
            font-weight: 600;
            box-shadow: var(--shadow);
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            transform: translateY(-5px);
            background-color: #fff;
            color: var(--secondary-color);
        }

        /* --- Base Card Style --- */
        .card {
            border: none;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            transition: all 0.3s ease;
            height: 100%;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
        }

        /* --- Impact Stats Section --- */
        .impact-section { background-color: var(--light-color); }
        .stat-item { text-align: center; }
        .stat-item .icon { font-size: 2.5rem; margin-bottom: 10px; color: var(--secondary-color); }
        .stat-item h3 { font-size: 2.5rem; }
        .stat-item p { color: var(--text-light); }

        /* --- Events & Tours Section --- */
        .event-card .card-img-top {
            border-radius: var(--border-radius) var(--border-radius) 0 0;
            aspect-ratio: 16/10;
            object-fit: cover;
        }
        .event-card .card-body { padding: 1.5rem; }
        .event-card .event-date {
            background: linear-gradient(45deg, var(--primary-color), var(--secondary-color));
            color: #fff;
            padding: 0.5rem 1rem;
            border-radius: 50px;
            font-size: 0.9rem;
            font-weight: 500;
            position: absolute;
            top: 1rem;
            left: 1rem;
        }

        /* --- Photo Gallery Section --- */
        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1rem;
        }
        .gallery-item {
            position: relative;
            overflow: hidden;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
        }
        .gallery-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.4s ease;
        }
        .gallery-item:hover img {
            transform: scale(1.1);
        }
        .gallery-overlay {
            position: absolute; top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0,0,0,0.5);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            opacity: 0;
            transition: opacity 0.4s ease;
        }
        .gallery-item:hover .gallery-overlay {
            opacity: 1;
        }

        /* --- Testimonials Section --- */
        .testimonials-section { background-color: var(--light-color); }
        .testimonial-card {
            background-color: var(--card-bg);
            padding: 2rem;
        }
        .testimonial-card .quote-icon {
            font-size: 2.5rem;
            color: var(--secondary-color);
            opacity: 0.5;
        }
        .testimonial-card p {
            font-style: italic;
            color: var(--text-light);
        }
        .testimonial-author {
            display: flex;
            align-items: center;
        }
        .testimonial-author img {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            margin-right: 1rem;
            object-fit: cover;
        }

        /* --- Blog Section --- */
        .blog-card .card-img-top {
            border-radius: var(--border-radius) var(--border-radius) 0 0;
            aspect-ratio: 16/10;
            object-fit: cover;
        }
        .blog-card .card-body { padding: 1.5rem; }
        .blog-card .category {
            color: var(--primary-color);
            font-weight: 600;
            font-size: 0.9rem;
        }
        .cta-section {
            background: linear-gradient(45deg, var(--primary-color), var(--secondary-color));
            color: #fff;
            padding: 80px 0;
            text-align: center;
        }
        .cta-section h2 { color: #fff; }
        .cta-section p { color: rgba(255,255,255,0.8); }
        .cta-section .btn-light {
            background-color: #fff;
            color: var(--primary-color);
            font-weight: 600;
        }

        .footer {
            background-color: var(--dark-grey);
            color: rgba(255,255,255,0.7);
            padding: 60px 0 20px 0;
        }
        .footer h5 { color: #fff; font-weight: 600; margin-bottom: 1.5rem; }
        .footer a { color: rgba(255,255,255,0.7); text-decoration: none; transition: color 0.3s; }
        .footer a:hover { color: #fff; }
        .footer .list-unstyled li { margin-bottom: 0.8rem; }
        .footer .social-icons a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: rgba(255,255,255,0.1);
            color: #fff;
            margin-right: 0.5rem;
        }
        .footer .social-icons a:hover {
            background-color: var(--secondary-color);
        }
        .footer-bottom {
            border-top: 1px solid rgba(255,255,255,0.1);
            padding-top: 20px;
            margin-top: 40px;
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg fixed-top navbar-light">
        <div class="container">
            <a class="navbar-brand" href="#">SOS</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="#home">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="#events">Events</a></li>
                    <li class="nav-item"><a class="nav-link" href="#gallery">Gallery</a></li>
                    <li class="nav-item"><a class="nav-link" href="#testimonials">Testimonials</a></li>
                    <li class="nav-item"><a class="nav-link" href="#blog">Blog</a></li>
                </ul>
            </div>
        </div>
    </nav>

    @yield('content')

    <footer class="footer">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4">
                    <h5>About SOS</h5>
                    <p>SOS is a premier platform dedicated to helping social organizations manage their communities effectively and create meaningful connections through events, tours, and shared resources.</p>
                </div>
                <div class="col-lg-2 offset-lg-1">
                    <h5>Quick Links</h5>
                    <ul class="list-unstyled">
                        <li><a href="#home">Home</a></li>
                        <li><a href="#events">Events</a></li>
                        <li><a href="#gallery">Gallery</a></li>
                        <li><a href="#blog">Blog</a></li>
                    </ul>
                </div>
                <div class="col-lg-2">
                    <h5>Support</h5>
                    <ul class="list-unstyled">
                        <li><a href="#">Contact Us</a></li>
                        <li><a href="#">FAQ</a></li>
                        <li><a href="#">Privacy Policy</a></li>
                    </ul>
                </div>
                <div class="col-lg-3">
                    <h5>Connect With Us</h5>
                    <div class="social-icons">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
            </div>
            <div class="footer-bottom text-center">
                <p>&copy; 2025 SOS - Social Organization System. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <script>

        AOS.init({
            duration: 800,
            once: true,
        });
        const navbar = document.querySelector('.navbar');
        window.onscroll = () => {
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        };
    </script>
</body>
</html>
