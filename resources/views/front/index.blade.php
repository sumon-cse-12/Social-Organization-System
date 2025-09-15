@extends('frontLayout')

@section('css')
@endsection
@section('content')

    <section id="home" class="hero">
        <div class="hero-overlay"></div>
        <div class="container">
            <div class="row">
                <div class="col-lg-8" data-aos="fade-up">
                    <h1>A Thriving Community Starts Here.</h1>
                    <p class="lead my-4">SOS is the ultimate platform for social organizations to manage members, coordinate events, and build lasting connections.</p>
                    <a href="#cta" class="btn btn-primary">Join Our Community</a>
                </div>
            </div>
        </div>
    </section>

    <section class="section impact-section">
        <div class="container">
            <div class="row text-center">
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="stat-item">
                        <div class="icon"><i class="fas fa-users"></i></div>
                        <h3>1,200+</h3>
                        <p>Active Members</p>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="stat-item">
                        <div class="icon"><i class="fas fa-calendar-check"></i></div>
                        <h3>150+</h3>
                        <p>Events Hosted</p>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="stat-item">
                        <div class="icon"><i class="fas fa-map-marked-alt"></i></div>
                        <h3>25+</h3>
                        <p>Successful Tours</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="events" class="section">
        <div class="container">
            <div class="section-title" data-aos="fade-up">
                <h2>Upcoming Events & Tours</h2>
                <p>Join us for our next adventure. Unforgettable experiences await you.</p>
            </div>
            <div class="row g-4">
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="card event-card">
                        <div class="event-date">Oct 25, 2025</div>
                        <img src="https://images.unsplash.com/photo-1519167758481-83f550bb49b3?q=80&w=2070&auto=format&fit=crop" class="card-img-top" alt="Annual Gala">
                        <div class="card-body">
                            <h5 class="card-title">Annual Charity Gala</h5>
                            <p class="card-text text-light">An elegant evening of dining and fundraising for our community projects.</p>
                            <a href="#" class="btn btn-outline-primary">Learn More</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
                    <div class="card event-card">
                        <div class="event-date">Nov 12, 2025</div>
                        <img src="https://images.unsplash.com/photo-1470240731273-7821a6e26163?q=80&w=2070&auto=format&fit=crop" class="card-img-top" alt="Mountain Tour">
                        <div class="card-body">
                            <h5 class="card-title">Himalayan Mountain Tour</h5>
                            <p class="card-text text-light">A 5-day trekking tour through breathtaking landscapes and serene nature.</p>
                            <a href="#" class="btn btn-outline-primary">Book Your Spot</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
                    <div class="card event-card">
                        <div class="event-date">Dec 05, 2025</div>
                        <img src="https://images.unsplash.com/photo-1524178232363-1fb2b075b655?q=80&w=2070&auto=format&fit=crop" class="card-img-top" alt="Tech Workshop">
                        <div class="card-body">
                            <h5 class="card-title">Leadership Workshop</h5>
                            <p class="card-text text-light">A full-day workshop on modern leadership skills with industry experts.</p>
                            <a href="#" class="btn btn-outline-primary">Register Now</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="gallery" class="section bg-light">
        <div class="container">
            <div class="section-title" data-aos="fade-up">
                <h2>Moments from Our Events</h2>
                <p>Explore the vibrant life of our community through photos from past events and tours.</p>
            </div>
            <div class="gallery-grid">
                <a href="#" class="gallery-item" data-aos="zoom-in" data-aos-delay="100">
                    <img src="https://images.unsplash.com/photo-1531058020387-3be344556be6?q=80&w=2070&auto=format&fit=crop" alt="Event 1">
                    <div class="gallery-overlay"><i class="fas fa-search-plus"></i></div>
                </a>
                <a href="#" class="gallery-item" data-aos="zoom-in" data-aos-delay="200">
                    <img src="https://images.unsplash.com/photo-1523580494863-6f3031224c94?q=80&w=2070&auto=format&fit=crop" alt="Event 2">
                    <div class="gallery-overlay"><i class="fas fa-search-plus"></i></div>
                </a>
                <a href="#" class="gallery-item" data-aos="zoom-in" data-aos-delay="300">
                    <img src="https://images.unsplash.com/photo-1511578314322-379afb476865?q=80&w=2070&auto=format&fit=crop" alt="Event 3">
                    <div class="gallery-overlay"><i class="fas fa-search-plus"></i></div>
                </a>
                <a href="#" class="gallery-item" data-aos="zoom-in" data-aos-delay="400">
                    <img src="https://images.unsplash.com/photo-1495147466023-ac5c588e2e94?q=80&w=1887&auto=format&fit=crop" alt="Event 4">
                    <div class="gallery-overlay"><i class="fas fa-search-plus"></i></div>
                </a>
            </div>
        </div>
    </section>

    <section id="testimonials" class="section">
        <div class="container">
            <div class="section-title" data-aos="fade-up">
                <h2>What Our Members Say</h2>
                <p>Real stories from the heart of our community. Their experiences define our success.</p>
            </div>
            <div class="row g-4">
                <div class="col-lg-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="card testimonial-card">
                        <i class="fas fa-quote-left quote-icon"></i>
                        <p class="my-3">"Joining SOS was the best decision I've made. The community is incredibly welcoming, and the events are always top-notch. I've made lifelong friends here."</p>
                        <div class="testimonial-author">
                            <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330" alt="Author 1">
                            <div>
                                <h5>Jessica Miller</h5>
                                <small class="text-light">Member since 2022</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6" data-aos="fade-up" data-aos-delay="200">
                    <div class="card testimonial-card">
                        <i class="fas fa-quote-left quote-icon"></i>
                        <p class="my-3">"The mountain tour organized by SOS was a life-changing experience. Everything was perfectly planned, allowing us to just enjoy the moment. Highly recommended!"</p>
                        <div class="testimonial-author">
                            <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d" alt="Author 2">
                            <div>
                                <h5>David Chen</h5>
                                <small class="text-light">Event Attendee</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="blog" class="section bg-light">
        <div class="container">
            <div class="section-title" data-aos="fade-up">
                <h2>From Our Blog</h2>
                <p>Stay updated with our latest news, stories, and articles from the community.</p>
            </div>
            <div class="row g-4">
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="card blog-card">
                        <img src="https://images.unsplash.com/photo-1486312338219-ce68d2c6f44d?q=80&w=2072&auto=format&fit=crop" class="card-img-top" alt="Blog 1">
                        <div class="card-body">
                            <p class="category">Community</p>
                            <h5 class="card-title">5 Ways to Build a Stronger Community Online</h5>
                            <a href="#" class="btn-link">Read More <i class="fas fa-arrow-right ms-1"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
                    <div class="card blog-card">
                        <img src="https://images.unsplash.com/photo-1517048676732-d65bc937f952?q=80&w=2070&auto=format&fit=crop" class="card-img-top" alt="Blog 2">
                        <div class="card-body">
                            <p class="category">Events</p>
                            <h5 class="card-title">Recap: Our Most Successful Charity Gala Yet!</h5>
                            <a href="#" class="btn-link">Read More <i class="fas fa-arrow-right ms-1"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
                    <div class="card blog-card">
                        <img src="https://images.unsplash.com/photo-1521401411933-4e5a034a044c?q=80&w=1925&auto=format&fit=crop" class="card-img-top" alt="Blog 3">
                        <div class="card-body">
                            <p class="category">Travel</p>
                            <h5 class="card-title">A Traveler's Guide to Our Upcoming Himalayan Tour</h5>
                            <a href="#" class="btn-link">Read More <i class="fas fa-arrow-right ms-1"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="cta" class="cta-section">
        <div class="container" data-aos="fade-up">
            <h2>Ready to Be Part of Something Bigger?</h2>
            <p class="lead my-4">Join the SOS community today and start connecting with like-minded people. Your next great experience is just a click away.</p>
            <a href="#" class="btn btn-light btn-lg">Become a Member</a>
        </div>
    </section>

@endsection

