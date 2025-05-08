document.addEventListener('DOMContentLoaded', function() {
    // Scroll animations
    const animateOnScroll = () => {
        const elements = document.querySelectorAll('.post-card, .stat-card');
        
        elements.forEach(element => {
            const elementPosition = element.getBoundingClientRect().top;
            const screenPosition = window.innerHeight / 1.2;
            
            if (elementPosition < screenPosition) {
                element.style.opacity = '1';
                element.style.transform = 'translateY(0)';
            }
        });
    };
    
    // Set initial state for animation
    document.querySelectorAll('.post-card, .stat-card').forEach(el => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(20px)';
        el.style.transition = 'all 0.6s ease';
    });
    
    // Trigger on load and scroll
    animateOnScroll();
    window.addEventListener('scroll', animateOnScroll);
    
    // Hover effects for cards
    document.querySelectorAll('.post-card').forEach(card => {
        card.addEventListener('mouseenter', () => {
            card.style.transform = 'translateY(-10px)';
        });
        
        card.addEventListener('mouseleave', () => {
            card.style.transform = 'translateY(0)';
        });
    });
    
    const themeToggle = document.createElement('div');
    themeToggle.innerHTML = '<i class="fas fa-moon">&#9788;</i>';
    themeToggle.style.position = 'fixed';
    themeToggle.style.bottom = '80px';
    themeToggle.style.right = '20px';
    themeToggle.style.background = 'rgba(255,255,255,0.1)';
    themeToggle.style.width = '50px';
    themeToggle.style.height = '50px';
    themeToggle.style.borderRadius = '50%';
    themeToggle.style.display = 'flex';
    themeToggle.style.alignItems = 'center';
    themeToggle.style.justifyContent = 'center';
    themeToggle.style.cursor = 'pointer';
    themeToggle.style.zIndex = '90';
    themeToggle.style.fontSize = '1.2rem';
    document.body.appendChild(themeToggle);
    
    themeToggle.addEventListener('click', () => {
        document.body.classList.toggle('light-theme');
        if (document.body.classList.contains('light-theme')) {
            themeToggle.innerHTML = '<i class="fas fa-sun">&#9790;</i>';
            
        } else {
            themeToggle.innerHTML = '<i class="fas fa-moon">&#9788;</i>';
            themeToggle.style.color = 'rgb(37 37 37 / 70%)';
        }
    });
});