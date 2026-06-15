<?php 
session_start();
include 'db_config.php'; 
include 'header.php'; 

// Fetch the 15 most recent upcoming events for the slideshow
try {
    // UPDATED: Added event_id and ensured we are selecting the correct column
    $stmt_slides = $pdo->prepare("SELECT event_id, title, banner_path FROM events WHERE event_date >= CURDATE() ORDER BY created_at DESC LIMIT 15");
    $stmt_slides->execute();
    $dynamic_slides = $stmt_slides->fetchAll();
} catch (Exception $e) {
    $dynamic_slides = []; 
}
?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/11.0.5/swiper-bundle.min.css" />

<style>
    @import url('https://fonts.googleapis.com/css2?family=Syne:wght@800&family=Inter:wght@400;600;700&display=swap');
    
    body { 
        font-family: 'Inter', sans-serif; 
        background-color: #000; 
        color: white; 
        overflow-x: hidden;
        background-image: linear-gradient(rgba(0, 0, 0, 0.75), rgba(0, 0, 0, 0.9)), url('bg.jpg');
        background-attachment: fixed;
        background-size: cover;
        background-position: center;
    }
    
    .hero-glow {
        background: radial-gradient(circle at 50% 50%, #9333ea15 0%, transparent 80%);
    }

    .welcome-text {
        font-family: 'Syne', sans-serif;
        text-transform: uppercase;
        letter-spacing: -2px;
        line-height: 0.9;
    }

    .brand-gradient {
        background: linear-gradient(to bottom, #ffffff 30%, #9333ea 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .stand-out-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 20px;
        max-width: 1100px;
        margin: 50px auto;
    }

    .quality-card {
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid rgba(255, 255, 255, 0.08);
        backdrop-filter: blur(15px);
        padding: 40px 30px;
        border-radius: 40px;
        text-align: left;
    }

    .hook-container {
        max-width: 1000px;
        margin: 120px auto;
        padding: 80px 20px;
        border-top: 1px solid rgba(147, 51, 234, 0.2);
    }

    .hook-title {
        font-family: 'Syne', sans-serif;
        font-size: clamp(2.5rem, 8vw, 6rem);
        line-height: 1;
        text-transform: uppercase;
        margin-bottom: 30px;
    }

    .highlight-purple {
        color: #9333ea;
        text-shadow: 0 0 40px rgba(147, 51, 234, 0.5);
    }

    .swiper { width: 100%; padding: 40px 0; overflow: visible !important; }
    .swiper-slide {
        width: 300px;
        height: 420px;
        border-radius: 35px;
        filter: blur(2px) brightness(0.5);
        transition: all 0.5s ease;
        overflow: hidden;
        background: #111;
        position: relative;
    }
    .swiper-slide img { width: 100%; height: 100%; object-fit: cover; }
    .swiper-slide-active {
        filter: blur(0) brightness(1.1);
        transform: scale(1.12);
        border: 2px solid #9333ea;
    }
    
    .slide-info {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        padding: 20px;
        background: linear-gradient(to top, rgba(0,0,0,0.9), transparent);
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    .swiper-slide-active .slide-info {
        opacity: 1;
    }
</style>

<header class="fixed top-0 w-full z-[100] bg-black/60 backdrop-blur-xl border-b border-white/5">
    <div class="max-w-7xl mx-auto flex justify-between items-center px-6 py-5">
        <h1 class="text-2xl font-black italic tracking-tighter text-white">PARTYPASS <span class="text-purple-500">SL</span></h1>
        <div class="flex items-center space-x-6">
            <a href="login.php" class="text-xs font-bold uppercase tracking-widest text-gray-400 hover:text-white transition">Log-in</a>
            <a href="register.php" class="bg-purple-600 hover:bg-purple-700 px-6 py-2.5 rounded-xl text-xs font-black uppercase tracking-widest text-white transition">Sign-up</a>
        </div>
    </div>
</header>

<main class="hero-glow min-h-screen pt-40 px-6">
    <div class="text-center">
        <h2 class="welcome-text text-7xl md:text-9xl mb-14">
            WELCOME TO <br> <span class="brand-gradient">PARTYPASS.</span>
        </h2>

        <div class="swiper mySwiper">
            <div class="swiper-wrapper">
                <?php if (!empty($dynamic_slides)): ?>
                    <?php foreach ($dynamic_slides as $slide): 
                        // Logic to check if the path is stored with or without the folder name
                        $img_path = $slide['banner_path'];
                        if (strpos($img_path, 'assets/') === false && strpos($img_path, 'uploads/') === false) {
                            $img_path = 'uploads/events/' . $img_path;
                        }
                    ?>
                        <div class="swiper-slide">
                            <a href="purchase_ticket.php?id=<?php echo $slide['event_id']; ?>">
                                <img src="<?php echo htmlspecialchars($img_path); ?>" 
                                     alt="<?php echo htmlspecialchars($slide['title']); ?>"
                                     onerror="this.src='assets/flyers/placeholder.jpg'">
                                
                                <div class="slide-info">
                                    <p class="text-white font-black italic uppercase text-xs tracking-tighter">
                                        <?php echo htmlspecialchars($slide['title']); ?>
                                    </p>
                                </div>
                            </a>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="swiper-slide"><img src="assets/flyers/gbangbaode.jpg"></div>
                    <div class="swiper-slide"><img src="assets/flyers/madengn.jpg"></div>
                    <div class="swiper-slide"><img src="assets/flyers/ecofest.jpg"></div>
                    <div class="swiper-slide"><img src="assets/flyers/drift.jpg"></div>
                    <div class="swiper-slide"><img src="assets/flyers/kojumakoju.jpg"></div>
                <?php endif; ?>
            </div>
            <div class="swiper-pagination"></div>
        </div>

        <section class="py-24">
            <h3 class="welcome-text text-4xl mb-4">What Makes Us Stand Out</h3>
            <div class="stand-out-grid">
                <div class="quality-card">
                    <h4 class="text-xl font-bold mb-3 uppercase">Instant Access</h4>
                    <p class="text-gray-400 text-sm">One-click purchasing. Your pass lands in your inbox instantly.</p>
                </div>
                <div class="quality-card">
                    <h4 class="text-xl font-bold mb-3 uppercase">Anti-Fraud DNA</h4>
                    <p class="text-gray-400 text-sm">Every ticket is encrypted with a unique QR code. Fraud is impossible.</p>
                </div>
                <div class="quality-card">
                    <h4 class="text-xl font-bold mb-3 uppercase">Verified Vetting</h4>
                    <p class="text-gray-400 text-sm">Only verified organizers can sell, keeping your money safe.</p>
                </div>
            </div>
        </section>

        <section class="hook-container">
            <h2 class="hook-title">
                Sell <span class="highlight-purple">More.</span> <br>
                Lose <span class="highlight-purple">Less.</span> <br>
                Go <span class="highlight-purple">Digital.</span>
            </h2>
            <p class="text-gray-300 max-w-2xl mx-auto text-lg mb-12 leading-relaxed font-medium">
                With our <strong>encrypted QR technology</strong>, your entry is as secure as a bank vault and simple with just a <strong>single tap.</strong>
            </p>
            <a href="login.php" class="bg-white text-black px-16 py-6 rounded-full font-black uppercase tracking-widest text-sm hover:scale-110 transition-all">
                Secure Your Moment
            </a>
        </section>
    </div>
</main>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/11.0.5/swiper-bundle.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        new Swiper(".mySwiper", {
            effect: "coverflow",
            centeredSlides: true,
            slidesPerView: "auto",
            loop: <?php echo (count($dynamic_slides) > 1 || empty($dynamic_slides)) ? 'true' : 'false'; ?>,
            autoplay: { 
                delay: 3000, 
                disableOnInteraction: false 
            },
            coverflowEffect: { 
                rotate: 5, 
                stretch: 0, 
                depth: 100, 
                modifier: 1, 
                slideShadows: false 
            },
            keyboard: { enabled: true },
        });
    });
</script>