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

    <!-- Popular Destinations Section -->
    <section id="popular-destinations">
        <h2 class="section-title" data-aos="fade-up">Popular Destinations</h2>
        <div class="destinations-container">
        <div class="destination-card">
            <img src="https://images.unsplash.com/photo-1537953773345-d172ccf13cf1?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1172&q=80" alt="Bali">
            <div class="destination-info">
                <h3>Bali, Indonesia</h3>
                <p>Island of Gods</p>
            </div>
            <a href="{{ route('tours.index') }}" class="book-btn">Book Now</a>
        </div>
        
        <div class="destination-card">
            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTgSw1kbboZth700TNmk5MKObpUUPvP9rd6MQ&s" alt="Jakarta">
            <div class="destination-info">
                <h3>Jakarta</h3>
                <p>Capital City Adventure</p>
            </div>
            <a href="{{ route('tours.index') }}" class="book-btn">Book Now</a>
        </div>
        
        <div class="destination-card">
            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ8HbG8HfuiJS_zRqo1BvKyoai1VGOU60ky_g&s" alt="Yogyakarta">
            <div class="destination-info">
                <h3>Yogyakarta</h3>
                <p>Cultural Heart of Java</p>
            </div>
            <a href="{{ route('tours.index') }}" class="book-btn">Book Now</a>
        </div>
    </div>
    </section>

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
</body>
</html>
