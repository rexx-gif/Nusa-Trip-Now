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
                <li><a href="{{ route('home') }}">Home</a></li>
                <li><a href="#about-us">About Us</a></li>
                <li><a href="{{ route('tours.index') }}">Destinations</a></li>
                <li><a href="#contact">Contact</a></li>
            </ul>
        </div>
        <div class="footer-section">
            <h3>Support</h3>
            <ul>
                <li><a href="#">FAQ</a></li>
                <li><a href="#">Terms & Conditions</a></li>
                <li><a href="#">Privacy Policy</a></li>
                <li><a href="#">Contact Us</a></li>
            </ul>
        </div>
        <div class="footer-section">
            <h3>Contact Info</h3>
            <ul>
                <li><i class="fas fa-map-marker-alt"></i> Jakarta, Indonesia</li>
                <li><i class="fas fa-phone"></i> +62 21 1234 5678</li>
                <li><i class="fas fa-envelope"></i> info@nusatripnow.com</li>
            </ul>
        </div>
    </div>
    <div class="copyright">
        <p>&copy; {{ date('Y') }} NusaTripNow. All rights reserved.</p>
    </div>
</footer>
