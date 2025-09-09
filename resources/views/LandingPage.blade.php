@extends('layouts.app')

@section('title', 'NusaTripNow - Jelajahi Nusantara Sekarang')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/LandingPage.css') }}">
@endpush

@section('content')
<section id="hero-section" data-aos="fade-in">
    <div class="hero-bg-container">
        <img class="hero-bg active" src="assets/img-1.jpg" alt="Scenic view 1">
        <img class="hero-bg" src="assets/img-2.jpg" alt="Scenic view 2">
        <img class="hero-bg" src="assets/img-3.jpg" alt="Scenic view 3">
        <img class="hero-bg" src="assets/img-4.jpg" alt="Scenic view 4">

    <div class="hero-content">
        <div class="hero-text">
            <p>Japan Alps</p>
            <h1>Nagano <span>Perfecture</span></h1>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolor, nobis officia. Aliquid officia quisquam, atque quidem ipsum magni architecto a?</p>
            <div class="hero-actions">
                <a href="#" class="heart-btn"><i class="fa fa-heart"></i></a>
                <button class="explore-btn" onclick="location.href='{{ route('tours.index') }}'">Explore Now</button>
            </div>
        </div>

        <div class="hero-mini-images">
            <div class="mini-image-container">
                <img src="https://upload.wikimedia.org/wikipedia/commons/7/7d/Mount_Bromo_at_sunrise%2C_showing_its_volcanoes_and_Mount_Semeru_%28background%29.jpg" alt="Japanese Temple">
                <div class="mini-image-text">
                    <h3>Gunung Bromo</h3>
                    <p>Cultural Heritage</p>
                </div>
            </div>
            <div class="mini-image-container">
                <img src="https://www.papuaexplorers.com/wp-content/uploads/2016/07/wayag2_home2.jpg" alt="Japanese Mountain">
                <div class="mini-image-text">
                    <h3>Raja Ampat</h3>
                    <p>Natural Wonders</p>
                </div>
            </div>
            <div class="mini-image-container">
                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/c/c4/Lake_Toba_and_the_surrounding_hills.jpg/1200px-Lake_Toba_and_the_surrounding_hills.jpg" alt="Japanese City">
                <div class="mini-image-text">
                    <h3>Danau Toba</h3>
                    <p>Urban Exploration</p>
                </div>
            </div>
            <div class="mini-image-container">
                <img src="https://mimbar.co.id/wp-content/uploads/2018/02/ngarai-sianok.jpg" alt="Japanese Food">
                <div class="mini-image-text">
                    <h3>Ngarai Sianok</h3>
                    <p>Gastronomic Adventure</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="about-us" data-aos="fade-up">
    <h2 class="section-title">About NusaTripNow</h2>
    <div class="about-content">
        <div class="about-text">
            <p>Your gateway to unforgettable experiences across the Indonesian archipelago and beyond. We specialize in creating personalized travel experiences that showcase the true beauty and culture of each destination.</p>
            <p>With over 10 years of experience, we've helped thousands of travelers discover the magic of Indonesia's diverse landscapes, from pristine beaches to majestic mountains, vibrant cities to ancient temples.</p>
        </div>
        <div class="about-image">
            <img src="https://images.unsplash.com/photo-1469474968028-56623f02e42e?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Indonesian Landscape">
        </div>
    </div>
</section>

<section id="features" data-aos="fade-up">
    <h2 class="section-title">Why Choose Us</h2>
    <div class="features-container">
        <div class="feature-card" data-aos="zoom-in" data-aos-delay="100">
            <div class="feature-icon">
                <i class="fas fa-map-marked-alt"></i>
            </div>
            <h3>Expert Local Guides</h3>
            <p>Discover handpicked locations that showcase the true beauty and culture of each region.</p>
        </div>
        <div class="feature-card" data-aos="zoom-in" data-aos-delay="200">
            <div class="feature-icon">
                <i class="fas fa-wallet"></i>
            </div>
            <h3>Best Price Guarantee</h3>
            <p>We offer the most competitive prices without compromising on quality and experience.</p>
        </div>
        <div class="feature-card" data-aos="zoom-in" data-aos-delay="300">
            <div class="feature-icon">
                <i class="fas fa-headset"></i>
            </div>
            <h3>24/7 Support</h3>
            <p>Our travel experts are available around the clock to assist you with any needs.</p>
        </div>
        <div class="feature-card" data-aos="zoom-in" data-aos-delay="400">
            <div class="feature-icon">
                <i class="fas fa-shield-alt"></i>
            </div>
            <h3>Safety & Security</h3>
            <p>Your safety and security are our top priorities throughout your journey.</p>
        </div>
    </div>
</section>

<section id="popular-destinations" data-aos="fade-up">
    <h2 class="section-title">Popular Destinations</h2>
    <div class="destinations-container">
        <a href="#" class="destination-card" data-aos="flip-left" data-aos-delay="100">
            <img src="https://images.unsplash.com/photo-1537953773345-d172ccf13cf1?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Bali">
            <div class="destination-info">
                <h3>Bali</h3>
                <p>The Island of Gods</p>
            </div>
            <div class="book-btn">Book Now</div>
        </a>
        <a href="#" class="destination-card" data-aos="flip-left" data-aos-delay="200">
            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRuHsdgS2qB25033kA2ntKScK27Yns0SXjIPA&s" alt="Lombok">
            <div class="destination-info">
                <h3>Lombok</h3>
                <p>Paradise Island</p>
            </div>
            <div class="book-btn">Book Now</div>
        </a>
        <a href="#" class="destination-card" data-aos="flip-left" data-aos-delay="300">
            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS2hs5b_jfozSJYx57YO_S6TuU15AHtf4TvYA&s" alt="Yogyakarta">
            <div class="destination-info">
                <h3>Yogyakarta</h3>
                <p>Cultural Heart</p>
            </div>
            <div class="book-btn">Book Now</div>
        </a>
    </div>
</section>

<section id="testimonials" data-aos="fade-up">
    <h2 class="section-title">What Travelers Say</h2>
    <div class="testimonials-container">
        <div class="testimonial-card" data-aos="slide-right" data-aos-delay="100">
            <p class="testimonial-text">"My trip to Nagano was absolutely magical. The arrangements were perfect, and the guides were knowledgeable and friendly. I'll definitely use NusaTripNow again!"</p>
            <div class="testimonial-author">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQzHMDlwRCHOHZP_tX7jRYNxV8W8MpNEog45w&s" alt="Sarah Johnson">
                <div>
                    <h4>Sarah Johnson</h4>
                    <p>Adventure Traveler</p>
                </div>
            </div>
        </div>
        <div class="testimonial-card" data-aos="slide-right" data-aos-delay="200">
            <p class="testimonial-text">"The attention to detail and personalized itinerary made our honeymoon truly special. Thank you for creating such wonderful memories for us!"</p>
            <div class="testimonial-author">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSTNjkaQHLXfokbl1GiKnXl6v7GNgnG8rb3JA&s" alt="Michael Chen">
                <div>
                    <h4>Michael Chen</h4>
                    <p>Honeymooner</p>
                </div>
            </div>
        </div>
        <div class="testimonial-card" data-aos="slide-right" data-aos-delay="300">
            <p class="testimonial-text">"Excellent service from start to finish. The team at NusaTripNow made our family vacation stress-free and memorable."</p>
            <div class="testimonial-author">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQNfTkosk_XISYGUe8YAUWMrv0kcP5a4YMcVQ&s" alt="David Wilson">
                <div>
                    <h4>David Wilson</h4>
                    <p>Family Traveler</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="newsletter" data-aos="fade-up">
    <h2 class="section-title">Stay Updated</h2>
    <p>Subscribe to our newsletter for exclusive deals and travel inspiration</p>
    <form class="newsletter-form">
        <input type="email" placeholder="Enter your email address" required>
        <button type="submit">Subscribe</button>
    </form>
</section>

<section id="contact" data-aos="fade-up">
    <h2 class="section-title">Contact Us</h2>
    <div class="contact-content">
        <div class="contact-info">
            <div class="contact-item">
                <i class="fas fa-map-marker-alt"></i>
                <div>
                    <h4>Address</h4>
                    <p>123 Travel Street, Jakarta, Indonesia</p>
                </div>
            </div>
            <div class="contact-item">
                <i class="fas fa-phone"></i>
                <div>
                    <h4>Phone</h4>
                    <p>+62 21 1234 5678</p>
                </div>
            </div>
            <div class="contact-item">
                <i class="fas fa-envelope"></i>
                <div>
                    <h4>Email</h4>
                    <p>info@nusatripnow.com</p>
                </div>
            </div>
        </div>
        <form class="contact-form">
            <input type="text" placeholder="Your Name" required>
            <input type="email" placeholder="Your Email" required>
            <textarea placeholder="Your Message" rows="5" required></textarea>
            <button type="submit">Send Message</button>
        </form>
    </div>
</section>

@endsection

@push('scripts')
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset('js/LandingPage.js') }}"></script>

<!-- Include Chat Widget -->
@include('partials.chat-widget')

<script>
    // Initialize AOS
    AOS.init({
        duration: 1000,
        once: false,
        offset: 100
    });

    // Check for flash messages and show SweetAlert
    @if(session('alert'))
        Swal.fire({
            title: 'Pembayaran Berhasil!',
            text: '{{ session("alert") }}',
            icon: 'success',
            confirmButtonText: 'OK',
            confirmButtonColor: '#3085d6'
        });
    @endif

    @if(session('payment_approved'))
        Swal.fire({
            title: 'Pembayaran Diterima!',
            text: '{{ session("payment_approved") }}',
            icon: 'success',
            confirmButtonText: 'OK',
            confirmButtonColor: '#28a745'
        });
    @endif

    // Smooth scrolling for navigation links
    document.addEventListener('DOMContentLoaded', function() {
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
</script>
@endpush
