// landingPage.js
document.addEventListener('DOMContentLoaded', function() {
    // Elements
    const heroBg = document.querySelector('.hero-bg');
    const miniImages = document.querySelectorAll('.hero-mini-images img');
    const heroText = document.querySelector('.hero-text');
    const subtitleEl = document.querySelector('.hero-text > p:first-child');
    const titleEl = document.querySelector('.hero-text h1');
    const descriptionEl = document.querySelector('.hero-text > p:nth-child(3)');
    
    // Image data - you can replace these with your actual image paths
    const imageData = [
        {
            mainImage: 'assets/img-2.jpg',
            title: 'Nagano Perfecture',
            subtitle: 'Japan Alps',
            description: 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolor, nobis officia. Aliquid officia quisquam, atque quidem ipsum magni architecto a?'
        },
        {
            mainImage: 'assets/img-3.jpg',
            title: 'Ancient Temples',
            subtitle: 'Cultural Heritage',
            description: 'Discover the spiritual beauty of Japan\'s ancient temples and shrines, steeped in history and tradition.'
        },
        {
            mainImage: 'assets/img-4.jpg',
            title: 'Modern Cities',
            subtitle: 'Urban Exploration',
            description: 'Experience the vibrant energy of Japan\'s modern cities, where tradition meets cutting-edge technology.'
        },
        {
            mainImage: 'assets/img-1.jpg',
            title: 'Culinary Journey',
            subtitle: 'Gastronomic Adventure',
            description: 'Savor the exquisite flavors of Japanese cuisine, from sushi to ramen and everything in between.'
        }
    ];
    
    // Set initial active image
    let currentIndex = 0;
    let isTransitioning = false;
    let sliderInterval;
    let isPaused = false;
    let animationQueue = [];
    
    // Create a secondary image for crossfade effect
    const heroBgSecondary = heroBg.cloneNode();
    heroBgSecondary.style.position = 'absolute';
    heroBgSecondary.style.top = '0';
    heroBgSecondary.style.left = '0';
    heroBgSecondary.style.opacity = '0';
    heroBgSecondary.style.zIndex = '-2';
    heroBgSecondary.style.width = '100%';
    heroBgSecondary.style.height = '100%';
    heroBg.parentNode.insertBefore(heroBgSecondary, heroBg);
    
    // Smooth transition with better promise handling
    function smoothTransition(element, properties, duration = 600, easing = 'cubic-bezier(0.25, 0.46, 0.45, 0.94)') {
        return new Promise((resolve) => {
            // Set transition
            const transitionString = Object.keys(properties).map(prop => `${prop} ${duration}ms ${easing}`).join(', ');
            element.style.transition = transitionString;
            
            // Apply properties
            Object.keys(properties).forEach(prop => {
                element.style[prop] = properties[prop];
            });
            
            // Wait for transition to complete
            setTimeout(() => {
                resolve();
            }, duration + 50); // Small buffer to ensure completion
        });
    }
    
    // Enhanced crossfade with better synchronization
    function crossfadeImages(newImageSrc) {
        return new Promise((resolve) => {
            // Preload the new image
            const tempImg = new Image();
            tempImg.onload = async () => {
                try {
                    // Setup secondary image
                    heroBgSecondary.src = newImageSrc;
                    heroBgSecondary.style.opacity = '0';
                    heroBgSecondary.style.zIndex = parseInt(getComputedStyle(heroBg).zIndex || '0') + 1;
                    
                    // Synchronized crossfade
                    await smoothTransition(heroBgSecondary, { opacity: '1' }, 800);
                    
                    // Swap images instantly after fade completes
                    heroBg.src = newImageSrc;
                    heroBg.style.opacity = '1';
                    heroBgSecondary.style.opacity = '0';
                    heroBgSecondary.style.zIndex = '-2';
                    
                    resolve();
                } catch (error) {
                    console.warn('Crossfade error:', error);
                    resolve();
                }
            };
            
            tempImg.onerror = () => {
                console.warn('Image failed to load:', newImageSrc);
                resolve();
            };
            
            tempImg.src = newImageSrc;
        });
    }
    
    // Synchronized text animation
    async function animateTextElements(index, isInitial = false) {
        if (isInitial) {
            // Initial setup without animation
            subtitleEl.textContent = imageData[index].subtitle;
            titleEl.innerHTML = imageData[index].title.split(' ')[0] + ' <span>' + imageData[index].title.split(' ').slice(1).join(' ') + '</span>';
            descriptionEl.textContent = imageData[index].description;
            
            await smoothTransition(subtitleEl, { opacity: '1', transform: 'translateY(0)' }, 400);
            await smoothTransition(titleEl, { opacity: '1', transform: 'translateY(0)' }, 400);
            await smoothTransition(descriptionEl, { opacity: '1', transform: 'translateY(0)' }, 400);
            return;
        }
        
        try {
            // Phase 1: Fade out all text simultaneously
            await Promise.all([
                smoothTransition(subtitleEl, { opacity: '0', transform: 'translateY(-15px)' }, 300),
                smoothTransition(titleEl, { opacity: '0', transform: 'translateY(-15px)' }, 300),
                smoothTransition(descriptionEl, { opacity: '0', transform: 'translateY(-15px)' }, 300)
            ]);
            
            // Phase 2: Update content during invisible state
            subtitleEl.textContent = imageData[index].subtitle;
            titleEl.innerHTML = imageData[index].title.split(' ')[0] + ' <span>' + imageData[index].title.split(' ').slice(1).join(' ') + '</span>';
            descriptionEl.textContent = imageData[index].description;
            
            // Reset positions
            subtitleEl.style.transform = 'translateY(15px)';
            titleEl.style.transform = 'translateY(15px)';
            descriptionEl.style.transform = 'translateY(15px)';
            
            // Small delay to ensure content is updated
            await new Promise(resolve => setTimeout(resolve, 50));
            
            // Phase 3: Staggered fade in
            await smoothTransition(subtitleEl, { opacity: '1', transform: 'translateY(0)' }, 400);
            
            await new Promise(resolve => setTimeout(resolve, 100));
            await smoothTransition(titleEl, { opacity: '1', transform: 'translateY(0)' }, 400);
            
            await new Promise(resolve => setTimeout(resolve, 100));
            await smoothTransition(descriptionEl, { opacity: '1', transform: 'translateY(0)' }, 400);
            
        } catch (error) {
            console.warn('Text animation error:', error);
        }
    }
    
    // Smooth mini image transitions
    function updateMiniImageStates(activeIndex) {
        miniImages.forEach((img, i) => {
            const isActive = i === activeIndex;
            
            smoothTransition(img, {
                transform: isActive ? 'scale(1.1)' : 'scale(1)',
                opacity: isActive ? '1' : '0.7',
                filter: isActive ? 'brightness(1) saturate(1.2)' : 'brightness(0.8) saturate(0.8)'
            }, 400);
            
            if (isActive) {
                img.classList.add('active');
            } else {
                img.classList.remove('active');
            }
        });
    }
    
    // Queue-based animation system to prevent conflicts
    async function processAnimationQueue() {
        if (animationQueue.length === 0) return;
        
        const nextAnimation = animationQueue.shift();
        if (nextAnimation) {
            await nextAnimation();
            // Process next animation in queue
            setTimeout(processAnimationQueue, 100);
        }
    }
    
    // Main update function with queue system
    function updateHeroSection(index, isInitial = false) {
        // Add to queue to prevent conflicts
        animationQueue.push(async () => {
            if (isTransitioning && !isInitial) return;
            
            isTransitioning = true;
            
            try {
                // Start mini image state update immediately
                updateMiniImageStates(index);
                
                // Run image and text animations in parallel but properly synchronized
                const animations = [];
                
                if (!isInitial) {
                    animations.push(crossfadeImages(imageData[index].mainImage));
                } else {
                    heroBg.src = imageData[index].mainImage;
                    heroBg.alt = imageData[index].title;
                    heroBg.style.opacity = '1';
                }
                
                animations.push(animateTextElements(index, isInitial));
                
                // Wait for all animations to complete
                await Promise.all(animations);
                
                currentIndex = index;
                
            } catch (error) {
                console.warn('Animation error:', error);
            } finally {
                isTransitioning = false;
            }
        });
        
        // Process queue if not already processing
        if (animationQueue.length === 1) {
            processAnimationQueue();
        }
    }
    
    // Enhanced click handlers
    miniImages.forEach((img, index) => {
        // Hover effects
        img.addEventListener('mouseenter', () => {
            if (!img.classList.contains('active')) {
                smoothTransition(img, {
                    transform: 'scale(1.05)',
                    opacity: '0.9'
                }, 200);
            }
        });
        
        img.addEventListener('mouseleave', () => {
            if (!img.classList.contains('active')) {
                smoothTransition(img, {
                    transform: 'scale(1)',
                    opacity: '0.7'
                }, 200);
            }
        });
        
        // Click handler
        img.addEventListener('click', () => {
            if (currentIndex !== index && !isTransitioning) {
                updateHeroSection(index);
                resetSlider();
            }
        });
    });
    
    // Auto slider functions
    function startSlider() {
        clearInterval(sliderInterval);
        sliderInterval = setInterval(() => {
            if (!isTransitioning && !isPaused) {
                const nextIndex = (currentIndex + 1) % imageData.length;
                updateHeroSection(nextIndex);
            }
        }, 5000); // 5 seconds
    }
    
    function resetSlider() {
        clearInterval(sliderInterval);
        if (!isPaused) {
            startSlider();
        }
    }
    
    // Hover pause functionality
    const heroSection = document.getElementById('hero-section');
    
    if (heroSection) {
        heroSection.addEventListener('mouseenter', () => {
            isPaused = true;
            clearInterval(sliderInterval);
        });
        
        heroSection.addEventListener('mouseleave', () => {
            isPaused = false;
            startSlider();
        });
    }
    
    // Keyboard navigation
    document.addEventListener('keydown', (e) => {
        if (!isTransitioning) {
            if (e.key === 'ArrowLeft') {
                e.preventDefault();
                const prevIndex = (currentIndex - 1 + imageData.length) % imageData.length;
                updateHeroSection(prevIndex);
                resetSlider();
            } else if (e.key === 'ArrowRight') {
                e.preventDefault();
                const nextIndex = (currentIndex + 1) % imageData.length;
                updateHeroSection(nextIndex);
                resetSlider();
            }
        }
    });
    
    // Initialize
    setTimeout(() => {
        updateHeroSection(0, true);
        // Start auto-slider after initial load
        setTimeout(() => {
            startSlider();
        }, 1000);
    }, 100);
});