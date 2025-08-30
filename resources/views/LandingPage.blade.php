<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>NusaTripNow - Jelajahi Nusantara Sekarang</title>
    <link rel="stylesheet" href="{{ asset('css/LandingPage.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.0/css/all.min.css" xintegrity="sha512-DxV+EoADOkOygM4IR9yXP8Sb2qwgidEmeqAEmDKIOfPRQZOWbXCzLC6vjbZyy0vPisbH2SyW27+ddLVCN+OMzQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
</head>
<body>
      <a href="#hero-section" id="back-to-top-btn" title="Go to top">
        <i class="fas fa-arrow-up"></i>
    </a>
      @include('partials.chat-widget')
     <meta name="csrf-token" content="{{ csrf_token() }}">

    @auth
        <meta name="user-id" content="{{ Auth::id() }}">
    @endauth
     @if (session('alert'))
        <div id="alert-message" class="fixed top-5 right-5 bg-green-500 text-white py-3 px-5 rounded-lg shadow-lg z-50 animate-fade-in-down">
            {{ session('alert') }}
        </div>
        <script>
            setTimeout(function() {
                document.getElementById('alert-message').style.display = 'none';
            }, 5000); // Alert akan hilang setelah 5 detik
        </script>
    @endif
    <section id="hero-section">
        <img src="assets/img-1.jpg" alt="Japan Alps" class="hero-bg">
    
          <div class="parallax-element plane" data-parallax="0.3">
            <img src="assets/plane.png" alt="Plane">
        </div>
        <div class="parallax-element ship" data-parallax="0.2">
            <img src="assets/ship.png" alt="Ship">
        </div>
        <div class="parallax-element hot-air-balloon" data-parallax="0.4">
            <img src="assets/hot-air-balloon.png" alt="Hot Air Balloon">
        </div>
        <div class="parallax-element mountains" data-parallax="0.1">
            <img src="assets/mountains.png" alt="Mountains">
        </div>
        <div class="parallax-element birds" data-parallax="0.5">
            <img src="assets/birds.png" alt="Birds">
        </div>

        <div class="navbar">
            <div class="left-text">
                <h1>NusaTripNow</h1>
            </div>
            <ul>
                <li><a href="#">Home</a></li>
                <li><a href="#">About Us</a></li>
                <li><a href="{{ route('tours.index') }}">Destinations</a></li>
                <li><a href="#">Contact</a></li>
                <li><a href="#"><i class="fa fa-search"></i></a></li>
                <li><a href="{{ route('login') }}"><i class="fa fa-user-circle"></i></a></li>
            </ul>
        </div>
        
        <div class="hero-content">
            <div class="hero-text">
                <p>Japan Alps</p>
                <h1>Nagano <span>Perfecture</span></h1>
                <p style="font-size: 1.1em; padding-right:10px;">Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolor, nobis officia. Aliquid officia quisquam, atque quidem ipsum magni architecto a?</p>
                <div class="hero-actions">
                    <a href="" class="heart-btn"><i class="fa fa-heart"></i></a>
                    <!-- PERBAIKAN DI SINI: Menghapus variabel $tour yang tidak perlu -->
                    <button class="explore-btn" onclick="location.href='{{ route('tours.index') }}'">Explore Now</button>
                </div>
            </div>
            
            <div class="hero-mini-images">
                <div class="mini-image-container">
                    <img src="assets/img-2.jpg" alt="Japanese Temple">
                    <div class="mini-image-text">
                        <h3>Ancient Temples</h3>
                        <p>Cultural Heritage</p>
                    </div>
                </div>
                <div class="mini-image-container">
                    <img src="assets/img-3.jpg" alt="Japanese Mountain">
                    <div class="mini-image-text">
                        <h3>Majestic Mountains</h3>
                        <p>Natural Wonders</p>
                    </div>
                </div>
                <div class="mini-image-container">
                    <img src="assets/img-4.jpg" alt="Japanese City">
                    <div class="mini-image-text">
                        <h3>Modern Cities</h3>
                        <p>Urban Exploration</p>
                    </div>
                </div>
                <div class="mini-image-container">
                    <img src="assets/img-1.jpg" alt="Japanese Food">
                    <div class="mini-image-text">
                        <h3>Culinary Journey</h3>
                        <p>Gastronomic Adventure</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features">
        <h2 class="section-title" data-aos="fade-up">Why Choose Us</h2>
        <div class="features-container">
            <div class="feature-card" data-aos="fade-up" data-aos-delay="100">
                <div class="feature-icon">
                    <i class="fas fa-map-marked-alt"></i>
                </div>
                <h3>24/7 Support</h3>
                <p>Discover handpicked locations that showcase the true beauty and culture of each region.</p>
            </div>
            <div class="feature-card" data-aos="fade-up" data-aos-delay="200">
                <div class="feature-icon">
                    <i class="fas fa-wallet"></i>
                </div>
                <h3>Best Price Guarantee</h3>
                <p>We offer the most competitive prices without compromising on quality and experience.</p>
            </div>
            <div class="feature-card" data-aos="fade-up" data-aos-delay="300">
                <div class="feature-icon">
                    <i class="fas fa-headset"></i>
                </div>
                <h3>Travel Expert Assistance</h3>
                <p>Our travel experts are available around the clock to assist you with any needs.</p>
            </div>
            <div class="feature-card" data-aos="fade-up" data-aos-delay="400">
                <div class="feature-icon">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <h3>Safety and Security</h3>
                <p>Your safety and security are our top priorities throughout your journey.</p>
            </div>
        </div>
    </section>

        <section id="about-us">
        <div class="container">
            <div class="about-content">
                <div class="about-text" data-aos="fade-right">
                    <h2 class="section-title">About NusaTripNow</h2>
                    <p class="about-subtitle">Your Trusted Travel Companion Since 2015</p>
                    <div class="about-description">
                        <p>NusaTripNow was born from a passion to showcase the breathtaking beauty of the Indonesian archipelago to the world. With over 8 years of experience, we've helped thousands of travelers discover hidden gems and create unforgettable memories.</p>
                        <p>Our team of local experts carefully curates each itinerary to ensure authentic experiences that respect local cultures and environments.</p>
                    </div>
                    <div class="about-stats">
                        <div class="stat-item">
                            <h3>50,000+</h3>
                            <p>Happy Travelers</p>
                        </div>
                        <div class="stat-item">
                            <h3>150+</h3>
                            <p>Destinations</p>
                        </div>
                        <div class="stat-item">
                            <h3>98%</h3>
                            <p>Satisfaction Rate</p>
                        </div>
                    </div>
                    <button class="cta-button">Learn More About Us</button>
                </div>
                <div class="about-image" data-aos="fade-left">
                    <img src="https://images.unsplash.com/photo-1530789257038-e9e2b317c037?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Our Team">
                    <div class="experience-badge">
                        <span>8+ Years</span>
                        <small>Of Excellence</small>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ==================== HOW IT WORKS SECTION ==================== -->
    <section id="how-it-works">
        <div class="container">
            <h2 class="section-title" data-aos="fade-up">How It Works</h2>
            <p class="section-subtitle" data-aos="fade-up" data-aos-delay="100">Plan Your Dream Vacation in 4 Easy Steps</p>
            
            <div class="process-steps">
                <div class="step" data-aos="fade-up" data-aos-delay="200">
                    <div class="step-icon">
                        <i class="fas fa-search"></i>
                        <div class="step-number">1</div>
                    </div>
                    <h3>Explore Destinations</h3>
                    <p>Browse through our curated collection of amazing destinations and find your perfect getaway.</p>
                </div>
                
                <div class="step" data-aos="fade-up" data-aos-delay="300">
                    <div class="step-icon">
                        <i class="fas fa-calendar-check"></i>
                        <div class="step-number">2</div>
                    </div>
                    <h3>Book & Customize</h3>
                    <p>Select your preferred dates and customize your itinerary with our travel experts.</p>
                </div>
                
                <div class="step" data-aos="fade-up" data-aos-delay="400">
                    <div class="step-icon">
                        <i class="fas fa-credit-card"></i>
                        <div class="step-number">3</div>
                    </div>
                    <h3>Secure Payment</h3>
                    <p>Complete your booking with our secure payment system and get instant confirmation.</p>
                </div>
                
                <div class="step" data-aos="fade-up" data-aos-delay="500">
                    <div class="step-icon">
                        <i class="fas fa-plane-departure"></i>
                        <div class="step-number">4</div>
                    </div>
                    <h3>Travel & Enjoy</h3>
                    <p>Embark on your journey and create unforgettable memories with our support 24/7.</p>
                </div>
            </div>
            
            <div class="process-connector"></div>
        </div>
    </section>

    <!-- ==================== SPECIAL OFFERS SECTION ==================== -->
    <section id="special-offers">
        <div class="container">
            <h2 class="section-title" data-aos="fade-up">Special Offers</h2>
            <p class="section-subtitle" data-aos="fade-up" data-aos-delay="100">Limited Time Deals You Don't Want to Miss</p>
            
            <div class="offers-grid">
                <div class="offer-card" data-aos="fade-up" data-aos-delay="200">
                    <div class="offer-badge">30% OFF</div>
                    <img src="https://images.unsplash.com/photo-1518548419970-58e3b4079ab2?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Bali Package">
                    <div class="offer-content">
                        <h3>Bali Paradise Package</h3>
                        <p class="offer-desc">5 Days 4 Nights - All Inclusive</p>
                        <div class="offer-price">
                            <span class="old-price">$899</span>
                            <span class="new-price">$629</span>
                        </div>
                        <div class="offer-details">
                            <p><i class="fas fa-hotel"></i> 4-Star Accommodation</p>
                            <p><i class="fas fa-utensils"></i> Breakfast Included</p>
                            <p><i class="fas fa-ticket-alt"></i> Tour Activities</p>
                        </div>
                        <button class="offer-cta">Book Now</button>
                    </div>
                    <div class="time-left">
                        <i class="fas fa-clock"></i>
                        <span>5 days left</span>
                    </div>
                </div>
                
                <div class="offer-card" data-aos="fade-up" data-aos-delay="300">
                    <div class="offer-badge">EARLY BIRD</div>
                    <img src="https://images.unsplash.com/photo-1580548254596-1efd3777f5ef?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Lombok Package">
                    <div class="offer-content">
                        <h3>Lombok Adventure</h3>
                        <p class="offer-desc">4 Days 3 Nights - Group Tour</p>
                        <div class="offer-price">
                            <span class="old-price">$650</span>
                            <span class="new-price">$520</span>
                        </div>
                        <div class="offer-details">
                            <p><i class="fas fa-hotel"></i> Beachfront Villa</p>
                            <p><i class="fas fa-ship"></i> Island Hopping</p>
                            <p><i class="fas fa-hiking"></i> Rinjani Trekking</p>
                        </div>
                        <button class="offer-cta">Book Now</button>
                    </div>
                    <div class="time-left">
                        <i class="fas fa-clock"></i>
                        <span>7 days left</span>
                    </div>
                </div>
                
                <div class="offer-card" data-aos="fade-up" data-aos-delay="400">
                    <div class="offer-badge">FLASH SALE</div>
                    <img src="https://images.unsplash.com/photo-1564574660022-53a0ad63f0ab?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Java Culture">
                    <div class="offer-content">
                        <h3>Java Cultural Journey</h3>
                        <p class="offer-desc">6 Days 5 Nights - Cultural Immersion</p>
                        <div class="offer-price">
                            <span class="old-price">$780</span>
                            <span class="new-price">$624</span>
                        </div>
                        <div class="offer-details">
                            <p><i class="fas fa-hotel"></i> Heritage Stays</p>
                            <p><i class="fas fa-theater-masks"></i> Cultural Shows</p>
                            <p><i class="fas fa-monument"></i> Temple Tours</p>
                        </div>
                        <button class="offer-cta">Book Now</button>
                    </div>
                    <div class="time-left">
                        <i class="fas fa-clock"></i>
                        <span>2 days left</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ==================== TRAVEL GUIDES SECTION ==================== -->
    <section id="travel-guides">
        <div class="container">
            <h2 class="section-title" data-aos="fade-up">Travel Guides & Tips</h2>
            <p class="section-subtitle" data-aos="fade-up" data-aos-delay="100">Expert Advice for Your Next Adventure</p>
            
            <div class="guides-grid">
                <article class="guide-card" data-aos="fade-up" data-aos-delay="200">
                    <img src="https://images.unsplash.com/photo-1537953773345-d172ccf13cf1?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Bali Guide">
                    <div class="guide-content">
                        <div class="guide-meta">
                            <span class="guide-category">Destination Guide</span>
                            <span class="guide-date"><i class="far fa-clock"></i> 5 min read</span>
                        </div>
                        <h3>Ultimate Bali Travel Guide 2024</h3>
                        <p>Discover the best places to visit, eat, and stay in the Island of Gods. From hidden beaches to cultural landmarks.</p>
                        <a href="#" class="guide-link">Read More <i class="fas fa-arrow-right"></i></a>
                    </div>
                </article>
                
                <article class="guide-card" data-aos="fade-up" data-aos-delay="300">
                    <img src="https://images.unsplash.com/photo-1580548254596-1efd3777f5ef?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Packing Tips">
                    <div class="guide-content">
                        <div class="guide-meta">
                            <span class="guide-category">Travel Tips</span>
                            <span class="guide-date"><i class="far fa-clock"></i> 3 min read</span>
                        </div>
                        <h3>10 Essential Packing Tips for Tropical Climates</h3>
                        <p>Learn how to pack smart for your tropical vacation. What to bring and what to leave behind.</p>
                        <a href="#" class="guide-link">Read More <i class="fas fa-arrow-right"></i></a>
                    </div>
                </article>
                
                <article class="guide-card" data-aos="fade-up" data-aos-delay="400">
                    <img src="https://images.unsplash.com/photo-1469474968028-56623f02e42e?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Photography">
                    <div class="guide-content">
                        <div class="guide-meta">
                            <span class="guide-category">Photography</span>
                            <span class="guide-date"><i class="far fa-clock"></i> 7 min read</span>
                        </div>
                        <h3>How to Take Stunning Travel Photos</h3>
                        <p>Professional tips and tricks to capture amazing travel memories with any camera.</p>
                        <a href="#" class="guide-link">Read More <i class="fas fa-arrow-right"></i></a>
                    </div>
                </article>
            </div>
            
            <div class="guides-cta" data-aos="fade-up" data-aos-delay="500">
                <a href="#" class="view-all-guides">View All Guides <i class="fas fa-arrow-right"></i></a>
            </div>
        </div>
    </section>

    <!-- ==================== GALLERY SECTION ==================== -->
    <section id="gallery">
        <div class="container">
            <h2 class="section-title" data-aos="fade-up">Travel Gallery</h2>
            <p class="section-subtitle" data-aos="fade-up" data-aos-delay="100">Moments Captured by Our Travelers</p>
            
            <div class="gallery-grid">
                <div class="gallery-item" data-aos="zoom-in" data-aos-delay="200">
                    <img src="https://images.unsplash.com/photo-1537953773345-d172ccf13cf1?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Gallery 1">
                    <div class="gallery-overlay">
                        <div class="gallery-info">
                            <h4>Bali Sunset</h4>
                            <p>By: Sarah J.</p>
                        </div>
                    </div>
                </div>
                
                <div class="gallery-item" data-aos="zoom-in" data-aos-delay="250">
                    <img src="https://images.unsplash.com/photo-1580548254596-1efd3777f5ef?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Gallery 2">
                    <div class="gallery-overlay">
                        <div class="gallery-info">
                            <h4>Lombok Beaches</h4>
                            <p>By: Mike T.</p>
                        </div>
                    </div>
                </div>
                
                <div class="gallery-item" data-aos="zoom-in" data-aos-delay="300">
                    <img src="https://images.unsplash.com/photo-1564574660022-53a0ad63f0ab?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Gallery 3">
                    <div class="gallery-overlay">
                        <div class="gallery-info">
                            <h4>Borobudur Temple</h4>
                            <p>By: Anna L.</p>
                        </div>
                    </div>
                </div>
                
                <div class="gallery-item" data-aos="zoom-in" data-aos-delay="350">
                    <img src="https://images.unsplash.com/photo-1469474968028-56623f02e42e?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Gallery 4">
                    <div class="gallery-overlay">
                        <div class="gallery-info">
                            <h4>Komodo Island</h4>
                            <p>By: David K.</p>
                        </div>
                    </div>
                </div>
                
                <div class="gallery-item" data-aos="zoom-in" data-aos-delay="400">
                    <img src="https://images.unsplash.com/photo-1518548419970-58e3b4079ab2?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Gallery 5">
                    <div class="gallery-overlay">
                        <div class="gallery-info">
                            <h4>Ubud Rice Terraces</h4>
                            <p>By: Maria S.</p>
                        </div>
                    </div>
                </div>
                
                <div class="gallery-item" data-aos="zoom-in" data-aos-delay="450">
                    <img src="https://images.unsplash.com/photo-1530789257038-e9e2b317c037?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Gallery 6">
                    <div class="gallery-overlay">
                        <div class="gallery-info">
                            <h4>Raja Ampat Diving</h4>
                            <p>By: John D.</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="gallery-cta" data-aos="fade-up" data-aos-delay="500">
                <p>Share your travel moments with us!</p>
                <a href="#" class="share-photos-btn">Share Your Photos</a>
            </div>
        </div>
    </section>

    <!-- ==================== STATISTICS SECTION ==================== -->
    <section id="statistics">
        <div class="container">
            <div class="stats-grid">
                <div class="stat" data-aos="fade-up" data-aos-delay="200">
                    <div class="stat-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <h3 data-count="50000">0</h3>
                    <p>Happy Travelers</p>
                </div>
                
                <div class="stat" data-aos="fade-up" data-aos-delay="300">
                    <div class="stat-icon">
                        <i class="fas fa-globe-asia"></i>
                    </div>
                    <h3 data-count="150">0</h3>
                    <p>Destinations</p>
                </div>
                
                <div class="stat" data-aos="fade-up" data-aos-delay="400">
                    <div class="stat-icon">
                        <i class="fas fa-plane"></i>
                    </div>
                    <h3 data-count="1000">0</h3>
                    <p>Tours Completed</p>
                </div>
                
                <div class="stat" data-aos="fade-up" data-aos-delay="500">
                    <div class="stat-icon">
                        <i class="fas fa-award"></i>
                    </div>
                    <h3 data-count="12">0</h3>
                    <p>Awards Won</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ==================== FAQ SECTION ==================== -->
    <section id="faq">
        <div class="container">
            <h2 class="section-title" data-aos="fade-up">Frequently Asked Questions</h2>
            <p class="section-subtitle" data-aos="fade-up" data-aos-delay="100">Find answers to common questions about our services</p>
            
            <div class="faq-container">
                <div class="faq-item" data-aos="fade-up" data-aos-delay="200">
                    <button class="faq-question">
                        How far in advance should I book my trip?
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="faq-answer">
                        <p>We recommend booking at least 2-3 months in advance for international trips and 1-2 months for domestic travel. For peak seasons (June-August and December), we suggest booking 4-6 months ahead to secure the best accommodations and flights.</p>
                    </div>
                </div>
                
                <div class="faq-item" data-aos="fade-up" data-aos-delay="250">
                    <button class="faq-question">
                        What is included in the tour package price?
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="faq-answer">
                        <p>Our tour packages typically include accommodation, transportation during the tour, guided activities, and some meals as specified. Flights, travel insurance, personal expenses, and optional activities are usually not included. Each package has a detailed inclusion list.</p>
                    </div>
                </div>
                
                <div class="faq-item" data-aos="fade-up" data-aos-delay="300">
                    <button class="faq-question">
                        Do you offer customized itineraries?
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="faq-answer">
                        <p>Yes! We specialize in creating personalized itineraries based on your preferences, budget, and travel style. Contact our travel consultants, and we'll craft the perfect journey just for you.</p>
                    </div>
                </div>
                
                <div class="faq-item" data-aos="fade-up" data-aos-delay="350">
                    <button class="faq-question">
                        What is your cancellation policy?
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="faq-answer">
                        <p>Our cancellation policy varies depending on the package and timing. Generally, cancellations made 30+ days before departure receive a full refund minus a processing fee. For details, please refer to our Terms & Conditions or contact our support team.</p>
                    </div>
                </div>
                
                <div class="faq-item" data-aos="fade-up" data-aos-delay="400">
                    <button class="faq-question">
                        Do you provide travel insurance?
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="faq-answer">
                        <p>While we strongly recommend travel insurance, it is not automatically included in our packages. We can help you arrange comprehensive travel insurance through our trusted partners to ensure you're covered during your journey.</p>
                    </div>
                </div>
            </div>
            
            <div class="faq-cta" data-aos="fade-up" data-aos-delay="500">
                <p>Still have questions? We're here to help!</p>
                <a href="#" class="contact-support-btn">Contact Support</a>
            </div>
        </div>
    </section>

    <!-- Popular Destinations Section -->

    <!-- Testimonials Section -->
    <section id="testimonials">
        <h2 class="section-title" data-aos="fade-up">What Travelers Say</h2>
        <div class="testimonials-container">
            <div class="testimonial-card" data-aos="fade-up" data-aos-delay="100">
                <p class="testimonial-text">"My trip to Nagano was absolutely magical. The arrangements were perfect, and the guides were knowledgeable and friendly. I'll definitely use NusaTripNow again!"</p>
                <div class="testimonial-author">
                    <img src="assets/user1.jpg" alt="Sarah Johnson">
                    <div>
                        <h4>Sarah Johnson</h4>
                        <p>Adventure Traveler</p>
                    </div>
                </div>
            </div>
            <div class="testimonial-card" data-aos="fade-up" data-aos-delay="200">
                <p class="testimonial-text">"The attention to detail and personalized itinerary made our honeymoon truly special. Thank you for creating such wonderful memories for us!"</p>
                <div class="testimonial-author">
                    <img src="assets/user2.jpg" alt="Michael Chen">
                    <div>
                        <h4>Michael Chen</h4>
                        <p>Honeymooner</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Newsletter Section -->
    <section id="newsletter">
        <h2 class="section-title" data-aos="fade-up">Stay Updated</h2>
        <p data-aos="fade-up" data-aos-delay="100">Subscribe to our newsletter for exclusive deals and travel inspiration</p>
        <form class="newsletter-form" data-aos="fade-up" data-aos-delay="200">
            <input type="email" placeholder="Enter your email address" required>
            <button type="submit">Subscribe</button>
        </form>
    </section>

    <!-- Footer -->
    <footer>
        <div class="footer-container">
            <div class="footer-section">
                <h3>NusaTripNow</h3>
                <p>Your gateway to unforgettable experiences across the Indonesian archipelago and beyond.</p>
                <div class="social-links">
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>
            <div class="footer-section">
                <h3>Quick Links</h3>
                <ul>
                    <li><a href="#">Home</a></li>
                    <li><a href="#">About Us</a></li>
                    <li><a href="#">Destinations</a></li>
                    <li><a href="#">Special Offers</a></li>
                    <li><a href="#">Travel Guides</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h3>Support</h3>
                <ul>
                    <li><a href="#">FAQ</a></li>
                    <li><a href="#">Terms & Conditions</a></li>
                    <li><a href="#">Privacy Policy</a></li>
                    <li><a href="#">Contact Us</a></li>
                    <li><a href="#">Booking Info</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h3>Contact Info</h3>
                <ul>
                    <li><i class="fas fa-map-marker-alt"></i> 123 Travel Street, Jakarta</li>
                    <li><i class="fas fa-phone"></i> +62 21 1234 5678</li>
                    <li><i class="fas fa-envelope"></i> info@nusatripnow.com</li>
                </ul>
            </div>
        </div>
        <div class="copyright">
            <p>&copy; 2023 NusaTripNow. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="{{ asset('js/LandingPage.js') }}"></script>
    <script>
        // Initialize AOS
        AOS.init({
            duration: 1000,
            once: false,
            offset: 100
        });
        
        // Additional JavaScript for interactive elements
        document.addEventListener('DOMContentLoaded', function() {
            // Smooth scrolling for navigation links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    const targetId = this.getAttribute('href');
                    if (targetId === '#') return;
                    
                    const targetElement = document.querySelector(targetId);
                    if (targetElement) {
                        window.scrollTo({
                            top: targetElement.offsetTop - 80,
                            behavior: 'smooth'
                        });
                    }
                });
            });

            const backToTopBtn = document.getElementById('back-to-top-btn');

    // Tampilkan/sembunyikan tombol berdasarkan posisi scroll
    window.addEventListener('scroll', () => {
        if (window.scrollY > 400) { // Muncul setelah scroll 400px
            backToTopBtn.classList.add('visible');
        } else {
            backToTopBtn.classList.remove('visible');
        }
    });

    // Efek smooth scroll saat tombol diklik
    backToTopBtn.addEventListener('click', (e) => {
        e.preventDefault();
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });
            
            // Newsletter form submission
            const newsletterForm = document.querySelector('.newsletter-form');
            if (newsletterForm) {
                newsletterForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    const email = this.querySelector('input[type="email"]').value;
                    alert(`Thank you for subscribing with: ${email}`);
                    this.reset();
                });
            }
        });
          document.addEventListener('DOMContentLoaded', function() {
            // FAQ Accordion
            const faqItems = document.querySelectorAll('.faq-item');
            
            faqItems.forEach(item => {
                const question = item.querySelector('.faq-question');
                
                question.addEventListener('click', () => {
                    // Close other open items
                    faqItems.forEach(otherItem => {
                        if (otherItem !== item && otherItem.classList.contains('active')) {
                            otherItem.classList.remove('active');
                        }
                    });
                    
                    // Toggle current item
                    item.classList.toggle('active');
                });
            });
            
            // Animated counter for statistics
            const statsSection = document.getElementById('statistics');
            const stats = document.querySelectorAll('.stat h3');
            let counted = false;
            
            function startCounters() {
                if (counted) return;
                
                stats.forEach(stat => {
                    const target = parseInt(stat.getAttribute('data-count'));
                    const duration = 2000; // 2 seconds
                    const increment = target / (duration / 16); // 60fps
                    let current = 0;
                    
                    const timer = setInterval(() => {
                        current += increment;
                        if (current >= target) {
                            stat.textContent = target.toLocaleString();
                            clearInterval(timer);
                        } else {
                            stat.textContent = Math.floor(current).toLocaleString();
                        }
                    }, 16);
                });
                
                counted = true;
            }
            
            // Intersection Observer for counter animation
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        startCounters();
                    }
                });
            }, { threshold: 0.5 });
            
            if (statsSection) {
                observer.observe(statsSection);
            }
        });
    </script>
</body>
</html>
