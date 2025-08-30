// public/js/LandingPage.js

document.addEventListener('DOMContentLoaded', function() {
    // Check if the hero section exists before running the slider logic
    if (document.getElementById('hero-section')) {
        initializeHeroSlider();
    }

    // Check if the chat widget exists before running chat logic
    if (document.getElementById('chat-widget-container')) {
        initializeChatWidget();
    }
});

/**
 * Initializes the entire hero image slider functionality.
 */
function initializeHeroSlider() {
    // ... (Fungsi slider Anda tetap sama, tidak perlu diubah)
    // Elements for the slider
    const heroBg = document.querySelector('.hero-bg');
    const miniImages = document.querySelectorAll('.hero-mini-images img');
    const subtitleEl = document.querySelector('.hero-text > p:first-child');
    const titleEl = document.querySelector('.hero-text h1');
    const descriptionEl = document.querySelector('.hero-text > p:nth-child(3)');
    const heroSection = document.getElementById('hero-section');

    const imageData = [{
        mainImage: 'assets/img-2.jpg',
        title: 'Nagano Prefecture',
        subtitle: 'Japan Alps',
        description: 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolor, nobis officia. Aliquid officia quisquam, atque quidem ipsum magni architecto a?'
    }, {
        mainImage: 'assets/img-3.jpg',
        title: 'Ancient Temples',
        subtitle: 'Cultural Heritage',
        description: 'Discover the spiritual beauty of Japan\'s ancient temples and shrines, steeped in history and tradition.'
    }, {
        mainImage: 'assets/img-4.jpg',
        title: 'Modern Cities',
        subtitle: 'Urban Exploration',
        description: 'Experience the vibrant energy of Japan\'s modern cities, where tradition meets cutting-edge technology.'
    }, {
        mainImage: 'assets/img-1.jpg',
        title: 'Culinary Journey',
        subtitle: 'Gastronomic Adventure',
        description: 'Savor the exquisite flavors of Japanese cuisine, from sushi to ramen and everything in between.'
    }];
    
    let currentIndex = 0;
    let isTransitioning = false;
    let sliderInterval;
    let isPaused = false;
    
    const heroBgSecondary = heroBg.cloneNode();
    heroBgSecondary.style.cssText = 'position: absolute; top: 0; left: 0; opacity: 0; z-index: -2; width: 100%; height: 100%;';
    heroBg.parentNode.insertBefore(heroBgSecondary, heroBg);

    function smoothTransition(element, properties, duration = 400) {
        return new Promise((resolve) => {
            const easing = 'cubic-bezier(0.25, 0.46, 0.45, 0.94)';
            element.style.transition = `all ${duration}ms ${easing}`;
            Object.assign(element.style, properties);
            setTimeout(resolve, duration);
        });
    }

    function crossfadeImages(newImageSrc) {
        return new Promise((resolve) => {
            const tempImg = new Image();
            tempImg.onload = async () => {
                heroBgSecondary.src = newImageSrc;
                heroBgSecondary.style.zIndex = '-1';
                await smoothTransition(heroBgSecondary, { opacity: '1' }, 800);
                
                heroBg.src = newImageSrc;
                heroBgSecondary.style.opacity = '0';
                heroBgSecondary.style.zIndex = '-2';
                resolve();
            };
            tempImg.onerror = () => {
                console.warn('Image failed to load:', newImageSrc);
                resolve(); 
            };
            tempImg.src = newImageSrc;
        });
    }

    async function animateTextElements(index) {
        const data = imageData[index];
        const titleParts = data.title.split(' ');
        const newTitleHTML = `${titleParts[0]} <span>${titleParts.slice(1).join(' ')}</span>`;

        await Promise.all([
            smoothTransition(subtitleEl, { opacity: '0', transform: 'translateY(-15px)' }, 300),
            smoothTransition(titleEl, { opacity: '0', transform: 'translateY(-15px)' }, 300),
            smoothTransition(descriptionEl, { opacity: '0', transform: 'translateY(-15px)' }, 300)
        ]);
        
        subtitleEl.textContent = data.subtitle;
        titleEl.innerHTML = newTitleHTML;
        descriptionEl.textContent = data.description;
        
        subtitleEl.style.transform = 'translateY(15px)';
        titleEl.style.transform = 'translateY(15px)';
        descriptionEl.style.transform = 'translateY(15px)';
        
        await smoothTransition(subtitleEl, { opacity: '1', transform: 'translateY(0)' }, 400);
        await new Promise(res => setTimeout(res, 50));
        await smoothTransition(titleEl, { opacity: '1', transform: 'translateY(0)' }, 400);
        await new Promise(res => setTimeout(res, 50));
        await smoothTransition(descriptionEl, { opacity: '1', transform: 'translateY(0)' }, 400);
    }
    
    function updateMiniImageStates(activeIndex) {
        miniImages.forEach((img, i) => {
            const isActive = (i === activeIndex);
            img.classList.toggle('active', isActive);
            smoothTransition(img, {
                transform: isActive ? 'scale(1.1)' : 'scale(1)',
                opacity: isActive ? '1' : '0.7',
                filter: isActive ? 'brightness(1) saturate(1.2)' : 'brightness(0.8) saturate(0.8)'
            }, 400);
        });
    }

    async function updateHeroSection(index) {
        if (isTransitioning) return;
        isTransitioning = true;
        
        try {
            updateMiniImageStates(index);
            await Promise.all([
                crossfadeImages(imageData[index].mainImage),
                animateTextElements(index)
            ]);
            currentIndex = index;
        } catch (error) {
            console.warn('Animation error:', error);
        } finally {
            isTransitioning = false;
        }
    }

    function startSlider() {
        clearInterval(sliderInterval);
        sliderInterval = setInterval(() => {
            if (!isPaused) {
                const nextIndex = (currentIndex + 1) % imageData.length;
                updateHeroSection(nextIndex);
            }
        }, 5000);
    }

    function resetSlider() {
        clearInterval(sliderInterval);
        if (!isPaused) {
            startSlider();
        }
    }
    
    miniImages.forEach((img, index) => {
        img.addEventListener('click', () => {
            if (currentIndex !== index) {
                updateHeroSection(index);
                resetSlider();
            }
        });
    });

    heroSection.addEventListener('mouseenter', () => { isPaused = true; });
    heroSection.addEventListener('mouseleave', () => { isPaused = false; resetSlider(); });

    document.addEventListener('keydown', (e) => {
        if (e.key === 'ArrowLeft' || e.key === 'ArrowRight') {
            e.preventDefault();
            const direction = e.key === 'ArrowLeft' ? -1 : 1;
            const newIndex = (currentIndex + direction + imageData.length) % imageData.length;
            updateHeroSection(newIndex);
            resetSlider();
        }
    });

    (function initialLoad() {
        const data = imageData[0];
        const titleParts = data.title.split(' ');
        heroBg.src = data.mainImage;
        subtitleEl.textContent = data.subtitle;
        titleEl.innerHTML = `${titleParts[0]} <span>${titleParts.slice(1).join(' ')}</span>`;
        descriptionEl.textContent = data.description;
        updateMiniImageStates(0);
        startSlider();
    })();
}


/**
 * Initializes the chat widget functionality.
 */
function initializeChatWidget() {
    const chatBubble = document.getElementById('chat-bubble');
    const chatBox = document.getElementById('chat-box');
    const closeChatBtn = document.getElementById('close-chat');
    const chatForm = document.getElementById('chat-form');
    const chatInput = document.getElementById('chat-input');
    const chatMessages = document.getElementById('chat-messages');
    
    if (!chatBubble || !chatBox) return;

    // FLAG untuk memastikan riwayat hanya dimuat sekali per sesi
    let historyLoaded = false; 

    // Tampilkan/sembunyikan widget dan muat riwayat saat pertama kali dibuka
    chatBubble.addEventListener('click', async () => {
        const authUserMeta = document.querySelector('meta[name="user-id"]');
        
        if (authUserMeta && !historyLoaded) {
            const userId = authUserMeta.getAttribute('content');
            await loadUserChatHistory(userId);
            historyLoaded = true;
        } else if (!authUserMeta) {
            chatMessages.innerHTML = '<div class="message system">Silakan login untuk memulai percakapan.</div>';
        }
        
        chatBox.classList.remove('hidden');
        chatBubble.classList.add('hidden');
    });
    
    closeChatBtn.addEventListener('click', () => {
        chatBox.classList.add('hidden');
        chatBubble.classList.remove('hidden');
    });

    // Fungsi untuk menampilkan pesan di UI
    function appendMessage(message, sender) {
        const messageElement = document.createElement('div');
        // Tambahkan style berbeda untuk user dan agent (admin)
        if (sender === 'agent') {
            messageElement.className = 'message agent';
        } else if (sender === 'user') {
            messageElement.className = 'message user';
        } else {
            messageElement.className = 'message system';
        }
        messageElement.textContent = message;
        chatMessages.appendChild(messageElement);
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }

    // FUNGSI BARU: Mengambil dan menampilkan riwayat chat dari server
    async function loadUserChatHistory(userId) {
        appendMessage('Memuat riwayat percakapan...', 'system');
        try {
            const response = await fetch(`/chat/history/${userId}`);
            if (!response.ok) {
                throw new Error(`Server Error: ${response.status}`);
            }
            const history = await response.json();
            
            chatMessages.innerHTML = ''; // Hapus pesan loading

            if (history.length === 0) {
                appendMessage('Halo! Ada yang bisa kami bantu?', 'system');
            } else {
                history.forEach(chat => {
                    appendMessage(chat.message, chat.sender);
                });
            }
        } catch (error) {
            console.error("Gagal memuat riwayat chat:", error);
            chatMessages.innerHTML = '';
            appendMessage('Gagal memuat riwayat. Coba lagi nanti.', 'system');
        }
    }

    // Mengirim pesan ke server
    chatForm.addEventListener('submit', function(e) {
        e.preventDefault();
        const message = chatInput.value.trim();
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        const authUserMeta = document.querySelector('meta[name="user-id"]');

        if (!authUserMeta) {
            appendMessage("Anda harus login untuk mengirim pesan.", "system");
            return;
        }

        if (message && csrfToken) {
            appendMessage(message, 'user');

            fetch('/chat/send', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ message: message })
            }).catch(err => {
                console.error("Gagal mengirim pesan:", err);
                appendMessage("Maaf, pesan Anda gagal terkirim.", "system");
            });

            chatInput.value = '';
        }
    });

    // BAGIAN PENTING: Mendengarkan balasan admin secara real-time
    const authUserMeta = document.querySelector('meta[name="user-id"]');
    if (window.Echo && authUserMeta) {
        const authUserId = authUserMeta.getAttribute('content');
        if (authUserId) {
            window.Echo.private(`livechat.${authUserId}`)
                .listen('NewChatMessage', (e) => {
                    // Hanya tampilkan pesan jika pengirimnya bukan user itu sendiri
                    if (e.sender === 'agent') {
                        appendMessage(e.message, e.sender);
                    }
                });
        }
    }
}
// ==================== IMPROVED PARALLAX SCROLL EFFECTS ====================

class ParallaxController {
    constructor() {
        this.rafId = null;
        this.isScrolling = false;
        this.mouseX = 0;
        this.mouseY = 0;
        this.lastScrollY = window.pageYOffset;
        this.animationFrame = null;
        this.isEnabled = true;
        
        // Check if user prefers reduced motion
        this.prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
        
        this.init();
    }

    init() {
        if (this.prefersReducedMotion) {
            this.disableParallax();
            return;
        }
        
        this.setupElements();
        this.setupEventListeners();
        this.setupIntersectionObserver();
        
        // Start animation loop for floating elements
        this.animateFloatingElements();
        
        console.log('🎬 Parallax effects initialized!');
    }

    setupElements() {
        // Initialize parallax elements with more specific selectors
        this.parallaxElements = document.querySelectorAll('[data-parallax]:not(.parallax-element)');
        this.parallaxCards = document.querySelectorAll('.feature-card, .destination-card, .testimonial-card');
        this.floatingElements = document.querySelectorAll('.parallax-element');
        this.heroContent = document.querySelector('.hero-content');
        this.miniImages = document.querySelectorAll('.mini-image-container');
        this.navbar = document.querySelector('.navbar');
        
        // Create parallax layers if hero section exists
        const heroSection = document.getElementById('hero-section');
        if (heroSection && !document.querySelector('.parallax-layer')) {
            this.createParallaxLayers();
        }
    }

    createParallaxLayers() {
        const heroSection = document.getElementById('hero-section');
        if (!heroSection) return;

        // Add parallax background layers only if they don't exist
        if (!document.querySelector('.parallax-clouds')) {
            const cloudsLayer = document.createElement('div');
            cloudsLayer.className = 'parallax-layer parallax-clouds';
            heroSection.appendChild(cloudsLayer);
        }

        if (!document.querySelector('.parallax-birds')) {
            const birdsLayer = document.createElement('div');
            birdsLayer.className = 'parallax-layer parallax-birds';
            heroSection.appendChild(birdsLayer);
        }
    }

    setupEventListeners() {
        // Use passive event listeners for better performance
        window.addEventListener('scroll', this.handleScroll.bind(this), { passive: true });
        window.addEventListener('resize', this.handleResize.bind(this), { passive: true });
        
        // Mouse events for hero parallax
        const heroSection = document.getElementById('hero-section');
        if (heroSection) {
            heroSection.addEventListener('mousemove', this.handleMouseMove.bind(this), { passive: true });
            heroSection.addEventListener('mouseleave', this.resetMouseParallax.bind(this));
        }
        
        // Listen for changes in reduced motion preference
        window.matchMedia('(prefers-reduced-motion: reduce)').addEventListener('change', (e) => {
            this.prefersReducedMotion = e.matches;
            if (e.matches) {
                this.disableParallax();
            } else {
                this.enableParallax();
            }
        });
    }

    setupIntersectionObserver() {
        // Use a single observer for better performance
        this.observer = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('parallax-visible');
                    
                    // Add staggered animation for cards
                    if (entry.target.matches('.feature-card, .destination-card, .testimonial-card')) {
                        this.addStaggeredAnimation(entry.target);
                    }
                }
            });
        }, {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        });

        // Observe all animatable elements
        document.querySelectorAll('.section-title, .feature-card, .destination-card, .testimonial-card, .newsletter-form')
            .forEach(el => {
                el.classList.add('parallax-hidden');
                this.observer.observe(el);
            });
    }

    handleScroll = () => {
        if (!this.isEnabled || this.prefersReducedMotion) return;
        
        // Use requestAnimationFrame for smooth scrolling
        if (!this.isScrolling) {
            this.isScrolling = true;
            this.rafId = requestAnimationFrame(this.updateParallax);
        }
    }

    updateParallax = () => {
        const scrollY = window.pageYOffset;
        const scrollDelta = scrollY - this.lastScrollY;
        
        // Only update if scroll position has changed significantly
        if (Math.abs(scrollDelta) > 0.5) {
            this.applyScrollEffects(scrollY);
            this.lastScrollY = scrollY;
        }
        
        this.isScrolling = false;
    }

    applyScrollEffects(scrollY) {
        const windowHeight = window.innerHeight;
        
        // Hero background parallax with performance optimization
        const heroBg = document.querySelector('#hero-section img.hero-bg');
        if (heroBg && this.isElementInView(heroBg)) {
            const speed = 0.5;
            heroBg.style.transform = `translateZ(0) scale(1.1) translateY(${scrollY * speed}px)`;
        }

        // Floating elements parallax
        this.updateFloatingElements(scrollY);
        
        // Section background parallax
        this.updateSectionParallax(scrollY);
        
        // Update navbar on scroll
        this.updateNavbar(scrollY);
        
        // Parallax elements with different speeds
        this.parallaxElements.forEach(el => {
            if (this.isElementInView(el)) {
                const speed = parseFloat(el.dataset.parallax) || 0.5;
                const yPos = -(scrollY * speed);
                el.style.transform = `translateZ(0) translateY(${yPos}px)`;
            }
        });
    }

    isElementInView(el) {
        const rect = el.getBoundingClientRect();
        return rect.bottom >= 0 && rect.top <= window.innerHeight;
    }

    updateFloatingElements(scrollY) {
        // Batch DOM updates for better performance
        this.floatingElements.forEach(el => {
            if (this.isElementInView(el)) {
                const speed = parseFloat(el.dataset.parallax) || 0.3;
                const yPos = -(scrollY * speed);
                el.style.transform = `translateY(${yPos}px)`;
            }
        });
    }

    updateSectionParallax(scrollY) {
        // Optimized section parallax with early returns
        const sections = [
            { id: 'features', speed: 0.3 },
            { id: 'popular-destinations', speed: 0.2, invert: true },
            { id: 'testimonials', speed: 0.4 },
            { id: 'newsletter', speed: 0.1, invert: true }
        ];
        
        sections.forEach(({ id, speed, invert = false }) => {
            const section = document.getElementById(id);
            if (section && this.isElementInView(section)) {
                const parallaxValue = (scrollY - section.offsetTop) * speed;
                section.style.backgroundPosition = `center ${invert ? -parallaxValue : parallaxValue}px`;
            }
        });
    }

    updateNavbar(scrollY) {
        if (this.navbar) {
            if (scrollY > 100) {
                this.navbar.classList.add('scrolled');
            } else {
                this.navbar.classList.remove('scrolled');
            }
        }
    }

    handleMouseMove = (e) => {
        if (!this.isEnabled || window.innerWidth < 768) return;
        
        const { clientX, clientY } = e;
        this.mouseX = clientX;
        this.mouseY = clientY;
        
        const { innerWidth, innerHeight } = window;
        const x = (clientX - innerWidth / 2) / (innerWidth / 2);
        const y = (clientY - innerHeight / 2) / (innerHeight / 2);
        
        // Hero content parallax
        if (this.heroContent) {
            const moveX = x * 20;
            const moveY = y * 10;
            this.heroContent.style.transform = `translateY(-50%) translate(${moveX}px, ${moveY}px)`;
        }
        
        // Mini images tilt effect with performance optimization
        if (this.miniImages.length > 0) {
            this.miniImages.forEach((img, index) => {
                const intensity = (index + 1) * 0.5;
                const rotateX = y * intensity * 2;
                const rotateY = x * intensity * 2;
                const translateZ = Math.abs(x * y) * intensity * 10;
                
                img.style.transform = `
                    perspective(1000px) 
                    rotateX(${-rotateX}deg) 
                    rotateY(${rotateY}deg) 
                    translateZ(${translateZ}px)
                `;
            });
        }
    }

    // Animation loop for floating elements with performance optimization
    animateFloatingElements = () => {
        if (!this.isEnabled || this.floatingElements.length === 0) return;
        
        const now = Date.now() * 0.001;
        
        this.floatingElements.forEach(el => {
            // Only animate if element is in or near viewport
            if (this.isElementNearViewport(el)) {
                const amplitude = parseInt(el.dataset.amplitude) || 10;
                const speed = parseFloat(el.dataset.speed) || 1;
                const yOffset = Math.sin(now * speed) * amplitude;
                
                // Apply mouse parallax effect if mouse is moving
                let mouseOffsetX = 0;
                let mouseOffsetY = 0;
                
                if (this.mouseX > 0 && this.mouseY > 0) {
                    const mouseIntensity = parseFloat(el.dataset.mouseIntensity) || 0.5;
                    const centerX = window.innerWidth / 2;
                    const centerY = window.innerHeight / 2;
                    
                    mouseOffsetX = (this.mouseX - centerX) * mouseIntensity * 0.01;
                    mouseOffsetY = (this.mouseY - centerY) * mouseIntensity * 0.01;
                }
                
                // Get current scroll position from data attribute for better performance
                const scrollY = parseFloat(el.dataset.scrollY) || 0;
                
                el.style.transform = `translateY(${scrollY + yOffset + mouseOffsetY}px) translateX(${mouseOffsetX}px)`;
            }
        });
        
        this.animationFrame = requestAnimationFrame(this.animateFloatingElements);
    }

    isElementNearViewport(el) {
        const rect = el.getBoundingClientRect();
        const buffer = window.innerHeight * 0.5; // 50% viewport buffer
        return rect.bottom >= -buffer && rect.top <= window.innerHeight + buffer;
    }

    resetMouseParallax = () => {
        if (this.heroContent) {
            this.heroContent.style.transform = 'translateY(-50%)';
        }
        
        if (this.miniImages.length > 0) {
            this.miniImages.forEach(img => {
                img.style.transform = 'perspective(1000px) rotateX(0deg) rotateY(0deg) translateZ(0px)';
            });
        }
        
        // Reset mouse position
        this.mouseX = 0;
        this.mouseY = 0;
    }

    addStaggeredAnimation(element) {
        const elements = Array.from(this.parallaxCards);
        const index = elements.indexOf(element);
        const delay = index * 100;
        
        element.style.animationDelay = `${delay}ms`;
        element.classList.add('animate-in');
    }

    handleResize = () => {
        // Debounce resize handler for better performance
        clearTimeout(this.resizeTimeout);
        this.resizeTimeout = setTimeout(() => {
            this.resetTransforms();
            this.updateParallax();
        }, 100);
    }

    resetTransforms() {
        if (this.heroContent) {
            this.heroContent.style.transform = 'translateY(-50%)';
        }
        
        if (this.miniImages.length > 0) {
            this.miniImages.forEach(img => {
                img.style.transform = 'none';
            });
        }
    }

    disableParallax() {
        this.isEnabled = false;
        
        // Remove all parallax effects
        this.resetTransforms();
        
        this.parallaxElements.forEach(el => {
            el.style.transform = 'none';
        });
        
        this.floatingElements.forEach(el => {
            el.style.transform = 'none';
            el.style.animation = 'none';
        });
        
        // Remove scroll event listener
        window.removeEventListener('scroll', this.handleScroll);
        
        console.log('🚫 Parallax effects disabled');
    }

    enableParallax() {
        this.isEnabled = true;
        this.setupElements();
        this.setupEventListeners();
        this.animateFloatingElements();
        console.log('✅ Parallax effects enabled');
    }

    // Clean up method to remove event listeners
    destroy() {
        window.removeEventListener('scroll', this.handleScroll);
        window.removeEventListener('resize', this.handleResize);
        
        const heroSection = document.getElementById('hero-section');
        if (heroSection) {
            heroSection.removeEventListener('mousemove', this.handleMouseMove);
            heroSection.removeEventListener('mouseleave', this.resetMouseParallax);
        }
        
        if (this.rafId) {
            cancelAnimationFrame(this.rafId);
        }
        
        if (this.animationFrame) {
            cancelAnimationFrame(this.animationFrame);
        }
        
        if (this.observer) {
            this.observer.disconnect();
        }
        
        clearTimeout(this.resizeTimeout);
    }
}

// Initialize the parallax controller when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    // Only initialize if not on mobile and user doesn't prefer reduced motion
    const isMobile = window.innerWidth < 768;
    const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    
    if (!isMobile && !prefersReducedMotion) {
        window.parallaxController = new ParallaxController();
    }
});

// Add CSS styles for parallax effects
const parallaxStyles = `
/* Improved Parallax Styles with better performance */
.parallax-layer {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    pointer-events: none;
    will-change: transform;
    backface-visibility: hidden;
}

.parallax-clouds {
    background: url('images/clouds-layer.png') center center repeat-x;
    animation: clouds-move 60s linear infinite;
    opacity: 0.6;
    z-index: 2;
}

.parallax-birds {
    background: url('images/birds-layer.png') center center no-repeat;
    animation: birds-move 30s linear infinite;
    opacity: 0.4;
    z-index: 3;
}

@keyframes clouds-move {
    0% { background-position: 0% center; }
    100% { background-position: 100% center; }
}

@keyframes birds-move {
    0% { background-position: -100% 30%; }
    100% { background-position: 200% 70%; }
}

.parallax-element {
    position: absolute;
    z-index: 5;
    pointer-events: none;
    will-change: transform;
    backface-visibility: hidden;
    transform: translateZ(0);
}

.parallax-element img {
    width: 100%;
    height: auto;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .parallax-element {
        display: none;
    }
}

/* Reduced motion support */
@media (prefers-reduced-motion: reduce) {
    .parallax-layer,
    .parallax-element,
    [data-parallax] {
        animation: none !important;
        transition: none !important;
        transform: none !important;
    }
}
`;

// Inject styles into the document
if (!document.querySelector('style[data-parallax-styles]')) {
    const styleSheet = document.createElement('style');
    styleSheet.textContent = parallaxStyles;
    styleSheet.setAttribute('data-parallax-styles', 'true');
    document.head.appendChild(styleSheet);
}