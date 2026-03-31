<?php
require_once 'includes/header.php';
?>

<!-- Hero Section with Particle Background -->
<section class="premium-hero">
  <div id="particles-js"></div>
  <div class="hero-overlay"></div>
  <div class="container hero-content">
    <div class="row align-items-center min-vh-100">
      <div class="col-lg-7">
        <div class="hero-badge">
          <i class="fas fa-shield-alt"></i>
          <span>Official Crime Reporting Platform</span>
        </div>
        <h1 class="hero-title">
          Report Crime
          <span class="gradient-text">Anonymously</span>
          <br>
          <span class="hero-subtitle">Make Your Community Safer</span>
        </h1>
        <p class="hero-description">
          Join thousands of citizens who are making a difference. Your anonymous reports help authorities
          take action against crime and create safer neighborhoods for everyone.
        </p>
        <div class="hero-buttons">
          <a href="report-crime.php" class="btn-premium-primary">
            <span>Report Now</span>
            <i class="fas fa-arrow-right"></i>
          </a>
          <a href="track-report.php" class="btn-premium-secondary">
            <i class="fas fa-search"></i>
            <span>Track Report</span>
          </a>
        </div>
        <div class="hero-stats">
          <div class="stat-item">
            <div class="stat-number">
              <span class="counter" data-target="15247">0</span>
              <span>+</span>
            </div>
            <div class="stat-label">Reports Filed</div>
          </div>
          <div class="stat-item">
            <div class="stat-number">
              <span class="counter" data-target="89">0</span>
              <span>%</span>
            </div>
            <div class="stat-label">Response Rate</div>
          </div>
          <div class="stat-item">
            <div class="stat-number">
              <span class="counter" data-target="124">0</span>
              <span>+</span>
            </div>
            <div class="stat-label">Communities</div>
          </div>
        </div>
      </div>
      <div class="col-lg-5">
        <div class="hero-illustration">
          <div class="floating-card card-1">
            <i class="fas fa-flag-checkered"></i>
            <span>Case #CR2401</span>
            <p>Under Investigation</p>
          </div>
          <div class="floating-card card-2">
            <i class="fas fa-user-shield"></i>
            <span>Anonymous Report</span>
            <p>Identity Protected</p>
          </div>
          <div class="floating-card card-3">
            <i class="fas fa-chart-line"></i>
            <span>Quick Response</span>
            <p>24/7 Support</p>
          </div>
          <div class="floating-card card-4">
            <i class="fas fa-lock"></i>
            <span>Secure & Safe</span>
            <p>End-to-end Encrypted</p>
          </div>
          <div class="main-illustration">
            <svg viewBox="0 0 400 400" xmlns="http://www.w3.org/2000/svg">
              <circle cx="200" cy="200" r="180" fill="url(#gradient)" opacity="0.1" />
              <path d="M200,50 L250,100 L200,150 L150,100 Z" fill="url(#gradient)" stroke="white" stroke-width="2" />
              <circle cx="200" cy="200" r="40" fill="url(#gradient)" stroke="white" stroke-width="3" />
              <path d="M200,240 L200,320 M170,290 L230,290" stroke="white" stroke-width="3" stroke-linecap="round" />
              <defs>
                <linearGradient id="gradient" x1="0%" y1="0%" x2="100%" y2="100%">
                  <stop offset="0%" stop-color="#667eea" />
                  <stop offset="100%" stop-color="#764ba2" />
                </linearGradient>
              </defs>
            </svg>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="hero-wave">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
      <path fill="#ffffff" fill-opacity="1" d="M0,96L48,112C96,128,192,160,288,160C384,160,480,128,576,122.7C672,117,768,139,864,154.7C960,171,1056,181,1152,165.3C1248,149,1344,107,1392,85.3L1440,64L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
    </svg>
  </div>
</section>

<!-- Features Section with Advanced Cards -->
<section class="premium-features">
  <div class="container">
    <div class="section-header">
      <span class="section-badge">Why Choose Us</span>
      <h2 class="section-title">Advanced Features for <span class="gradient-text">Modern Safety</span></h2>
      <p class="section-subtitle">Experience the most comprehensive crime reporting platform with cutting-edge technology</p>
    </div>
    <div class="features-grid">
      <div class="feature-card-premium" data-aos="fade-up" data-aos-delay="100">
        <div class="feature-icon-wrapper">
          <div class="feature-icon-bg"></div>
          <i class="fas fa-user-secret"></i>
        </div>
        <h3>Complete Anonymity</h3>
        <p>Your identity is never revealed. Report crimes with full confidence and zero risk.</p>
        <div class="feature-link">
          <a href="report-crime.php">Learn More <i class="fas fa-arrow-right"></i></a>
        </div>
      </div>
      <div class="feature-card-premium" data-aos="fade-up" data-aos-delay="200">
        <div class="feature-icon-wrapper">
          <div class="feature-icon-bg"></div>
          <i class="fas fa-chart-line"></i>
        </div>
        <h3>Real-time Tracking</h3>
        <p>Monitor your report status instantly with our advanced tracking system.</p>
        <div class="feature-link">
          <a href="track-report.php">Learn More <i class="fas fa-arrow-right"></i></a>
        </div>
      </div>
      <div class="feature-card-premium" data-aos="fade-up" data-aos-delay="300">
        <div class="feature-icon-wrapper">
          <div class="feature-icon-bg"></div>
          <i class="fas fa-bolt"></i>
        </div>
        <h3>Instant SOS Alert</h3>
        <p>One-tap emergency notification system for immediate assistance.</p>
        <div class="feature-link">
          <a href="sos-emergency.php">Learn More <i class="fas fa-arrow-right"></i></a>
        </div>
      </div>
      <div class="feature-card-premium" data-aos="fade-up" data-aos-delay="400">
        <div class="feature-icon-wrapper">
          <div class="feature-icon-bg"></div>
          <i class="fas fa-shield-alt"></i>
        </div>
        <h3>Military-grade Security</h3>
        <p>Your data is protected with enterprise-level encryption and security protocols.</p>
        <div class="feature-link">
          <a href="#">Learn More <i class="fas fa-arrow-right"></i></a>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- How It Works Section -->
<section class="how-it-works">
  <div class="container">
    <div class="section-header">
      <span class="section-badge">Simple Process</span>
      <h2 class="section-title">How <span class="gradient-text">It Works</span></h2>
      <p class="section-subtitle">Three simple steps to report crime and ensure community safety</p>
    </div>
    <div class="steps-container">
      <div class="step-item" data-aos="fade-right">
        <div class="step-number">01</div>
        <div class="step-content">
          <div class="step-icon">
            <i class="fas fa-edit"></i>
          </div>
          <h3>Submit Report</h3>
          <p>Fill out our secure form with incident details, optionally staying anonymous.</p>
        </div>
      </div>
      <div class="step-connector"></div>
      <div class="step-item" data-aos="fade-up">
        <div class="step-number">02</div>
        <div class="step-content">
          <div class="step-icon">
            <i class="fas fa-search"></i>
          </div>
          <h3>Track Status</h3>
          <p>Get your unique Report ID and monitor the progress in real-time.</p>
        </div>
      </div>
      <div class="step-connector"></div>
      <div class="step-item" data-aos="fade-left">
        <div class="step-number">03</div>
        <div class="step-content">
          <div class="step-icon">
            <i class="fas fa-check-circle"></i>
          </div>
          <h3>Resolution</h3>
          <p>Receive updates when your case is investigated and resolved.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Stats Counter Section -->
<section class="stats-premium">
  <div class="container">
    <div class="stats-grid">
      <div class="stat-card-premium" data-aos="zoom-in">
        <div class="stat-icon">
          <i class="fas fa-flag-checkered"></i>
        </div>
        <div class="stat-number-wrapper">
          <span class="stat-number counter" data-target="1247">0</span>
          <span class="stat-suffix">+</span>
        </div>
        <div class="stat-label">Reports Processed</div>
      </div>
      <div class="stat-card-premium" data-aos="zoom-in" data-aos-delay="100">
        <div class="stat-icon">
          <i class="fas fa-user-check"></i>
        </div>
        <div class="stat-number-wrapper">
          <span class="stat-number counter" data-target="892">0</span>
          <span class="stat-suffix">+</span>
        </div>
        <div class="stat-label">Cases Resolved</div>
      </div>
      <div class="stat-card-premium" data-aos="zoom-in" data-aos-delay="200">
        <div class="stat-icon">
          <i class="fas fa-shield-alt"></i>
        </div>
        <div class="stat-number-wrapper">
          <span class="stat-number counter" data-target="98">0</span>
          <span class="stat-suffix">%</span>
        </div>
        <div class="stat-label">Success Rate</div>
      </div>
      <div class="stat-card-premium" data-aos="zoom-in" data-aos-delay="300">
        <div class="stat-icon">
          <i class="fas fa-users"></i>
        </div>
        <div class="stat-number-wrapper">
          <span class="stat-number counter" data-target="15247">0</span>
          <span class="stat-suffix">+</span>
        </div>
        <div class="stat-label">Active Users</div>
      </div>
    </div>
  </div>
</section>

<!-- Testimonials Section -->
<section class="testimonials">
  <div class="container">
    <div class="section-header">
      <span class="section-badge">Testimonials</span>
      <h2 class="section-title">What Our <span class="gradient-text">Users Say</span></h2>
      <p class="section-subtitle">Real stories from citizens who made a difference using our platform</p>
    </div>
    <div class="testimonials-slider">
      <div class="testimonial-card" data-aos="fade-right">
        <div class="testimonial-quote">
          <i class="fas fa-quote-left"></i>
        </div>
        <p class="testimonial-text">
          "This platform gave me the courage to report a crime I witnessed. The anonymous feature made me feel safe, and the police responded quickly."
        </p>
        <div class="testimonial-author">
          <div class="author-avatar">
            <img src="https://randomuser.me/api/portraits/women/1.jpg" alt="User">
          </div>
          <div class="author-info">
            <h4>Sarah Johnson</h4>
            <p>Verified User</p>
          </div>
        </div>
      </div>
      <div class="testimonial-card" data-aos="fade-up">
        <div class="testimonial-quote">
          <i class="fas fa-quote-left"></i>
        </div>
        <p class="testimonial-text">
          "The tracking feature is amazing! I could follow my report from submission to resolution. Great work by the team!"
        </p>
        <div class="testimonial-author">
          <div class="author-avatar">
            <img src="https://randomuser.me/api/portraits/men/2.jpg" alt="User">
          </div>
          <div class="author-info">
            <h4>Michael Chen</h4>
            <p>Verified User</p>
          </div>
        </div>
      </div>
      <div class="testimonial-card" data-aos="fade-left">
        <div class="testimonial-quote">
          <i class="fas fa-quote-left"></i>
        </div>
        <p class="testimonial-text">
          "SOS feature saved my friend. Quick response time and professional handling. Highly recommended for everyone."
        </p>
        <div class="testimonial-author">
          <div class="author-avatar">
            <img src="https://randomuser.me/api/portraits/women/3.jpg" alt="User">
          </div>
          <div class="author-info">
            <h4>Emily Rodriguez</h4>
            <p>Verified User</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- CTA Section -->
<section class="cta-section">
  <div class="container">
    <div class="cta-wrapper" data-aos="zoom-in">
      <div class="cta-content">
        <h2>Ready to Make a Difference?</h2>
        <p>Join thousands of citizens who are actively contributing to safer communities</p>
        <div class="cta-buttons">
          <a href="report-crime.php" class="btn-cta-primary">
            <span>Start Reporting Now</span>
            <i class="fas fa-arrow-right"></i>
          </a>
          <a href="track-report.php" class="btn-cta-secondary">
            <i class="fas fa-search"></i>
            <span>Track Existing Report</span>
          </a>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Latest News/Blog Section -->
<section class="latest-news">
  <div class="container">
    <div class="section-header">
      <span class="section-badge">Latest Updates</span>
      <h2 class="section-title">News & <span class="gradient-text">Announcements</span></h2>
      <p class="section-subtitle">Stay informed about platform updates and community safety tips</p>
    </div>
    <div class="news-grid">
      <div class="news-card" data-aos="fade-up">
        <div class="news-image">
          <i class="fas fa-shield-alt"></i>
        </div>
        <div class="news-date">
          <span>Mar 15, 2026</span>
        </div>
        <h3>New Security Features Added</h3>
        <p>We've implemented advanced encryption protocols to further protect your data and privacy.</p>
        <a href="#" class="read-more">Read More <i class="fas fa-arrow-right"></i></a>
      </div>
      <div class="news-card" data-aos="fade-up" data-aos-delay="100">
        <div class="news-image">
          <i class="fas fa-mobile-alt"></i>
        </div>
        <div class="news-date">
          <span>Mar 10, 2026</span>
        </div>
        <h3>Mobile App Coming Soon</h3>
        <p>Stay tuned for our mobile application launch, making reporting even easier on the go.</p>
        <a href="#" class="read-more">Read More <i class="fas fa-arrow-right"></i></a>
      </div>
      <div class="news-card" data-aos="fade-up" data-aos-delay="200">
        <div class="news-image">
          <i class="fas fa-chart-bar"></i>
        </div>
        <div class="news-date">
          <span>Mar 5, 2026</span>
        </div>
        <h3>2025 Annual Report Released</h3>
        <p>Check out our comprehensive annual report highlighting crime trends and platform impact.</p>
        <a href="#" class="read-more">Read More <i class="fas fa-arrow-right"></i></a>
      </div>
    </div>
  </div>
</section>

<!-- Partners Section -->
<section class="partners">
  <div class="container">
    <div class="section-header">
      <span class="section-badge">Trusted By</span>
      <h2 class="section-title">Our <span class="gradient-text">Partners</span></h2>
    </div>
    <div class="partners-grid">
      <div class="partner-logo" data-aos="fade-up">
        <i class="fas fa-building"></i>
        <span>National Police</span>
      </div>
      <div class="partner-logo" data-aos="fade-up" data-aos-delay="50">
        <i class="fas fa-gavel"></i>
        <span>Justice Dept</span>
      </div>
      <div class="partner-logo" data-aos="fade-up" data-aos-delay="100">
        <i class="fas fa-city"></i>
        <span>City Council</span>
      </div>
      <div class="partner-logo" data-aos="fade-up" data-aos-delay="150">
        <i class="fas fa-university"></i>
        <span>Security Org</span>
      </div>
    </div>
  </div>
</section>

<style>
  /* Premium Hero Section */
  .premium-hero {
    position: relative;
    min-height: 100vh;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    overflow: hidden;
  }

  #particles-js {
    position: absolute;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    z-index: 1;
  }

  .hero-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: radial-gradient(circle at 30% 50%, rgba(102, 126, 234, 0.3) 0%, rgba(118, 75, 162, 0.4) 100%);
    z-index: 2;
  }

  .hero-content {
    position: relative;
    z-index: 3;
  }

  .hero-badge {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    background: rgba(255, 255, 255, 0.15);
    backdrop-filter: blur(10px);
    padding: 8px 20px;
    border-radius: 50px;
    margin-bottom: 30px;
    animation: fadeInUp 0.8s ease;
  }

  .hero-badge i {
    font-size: 14px;
    color: #ffd700;
  }

  .hero-badge span {
    font-size: 14px;
    color: white;
    font-weight: 500;
  }

  .hero-title {
    font-size: 4rem;
    font-weight: 800;
    color: white;
    margin-bottom: 20px;
    line-height: 1.2;
    animation: fadeInUp 0.8s ease 0.1s both;
  }

  .gradient-text {
    background: linear-gradient(135deg, #ffd89b, #c7e9fb);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
  }

  .hero-subtitle {
    font-size: 1.5rem;
    font-weight: 500;
    color: rgba(255, 255, 255, 0.9);
    display: block;
    margin-top: 10px;
  }

  .hero-description {
    font-size: 1.1rem;
    color: rgba(255, 255, 255, 0.9);
    margin-bottom: 40px;
    line-height: 1.6;
    animation: fadeInUp 0.8s ease 0.2s both;
  }

  .hero-buttons {
    display: flex;
    gap: 20px;
    margin-bottom: 50px;
    animation: fadeInUp 0.8s ease 0.3s both;
  }

  .btn-premium-primary {
    display: inline-flex;
    align-items: center;
    gap: 12px;
    padding: 14px 32px;
    background: white;
    color: #667eea;
    border-radius: 50px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
  }

  .btn-premium-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
    color: #764ba2;
  }

  .btn-premium-secondary {
    display: inline-flex;
    align-items: center;
    gap: 12px;
    padding: 14px 32px;
    background: rgba(255, 255, 255, 0.2);
    backdrop-filter: blur(10px);
    color: white;
    border-radius: 50px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
    border: 1px solid rgba(255, 255, 255, 0.3);
  }

  .btn-premium-secondary:hover {
    background: rgba(255, 255, 255, 0.3);
    transform: translateY(-2px);
  }

  .hero-stats {
    display: flex;
    gap: 50px;
    animation: fadeInUp 0.8s ease 0.4s both;
  }

  .stat-item {
    text-align: left;
  }

  .stat-number {
    font-size: 2rem;
    font-weight: 800;
    color: white;
    display: flex;
    align-items: baseline;
    gap: 5px;
  }

  .stat-number span:first-child {
    font-size: 2rem;
  }

  .stat-number span:last-child {
    font-size: 1.5rem;
  }

  .stat-label {
    color: rgba(255, 255, 255, 0.8);
    font-size: 0.9rem;
  }

  /* Hero Illustration */
  .hero-illustration {
    position: relative;
    height: 500px;
    animation: float 6s ease-in-out infinite;
  }

  .main-illustration {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 300px;
    height: 300px;
  }

  .floating-card {
    position: absolute;
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    padding: 15px 20px;
    border-radius: 15px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
    display: flex;
    flex-direction: column;
    gap: 5px;
    animation: float 4s ease-in-out infinite;
  }

  .floating-card i {
    font-size: 24px;
    color: #667eea;
  }

  .floating-card span {
    font-weight: 600;
    color: #2d3748;
  }

  .floating-card p {
    margin: 0;
    font-size: 12px;
    color: #718096;
  }

  .card-1 {
    top: 20%;
    left: 0;
    animation-delay: 0s;
  }

  .card-2 {
    top: 50%;
    right: 0;
    animation-delay: 1s;
  }

  .card-3 {
    bottom: 20%;
    left: 10%;
    animation-delay: 2s;
  }

  .card-4 {
    bottom: 30%;
    right: 10%;
    animation-delay: 1.5s;
  }

  .hero-wave {
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    z-index: 2;
  }

  /* Features Section */
  .premium-features {
    padding: 100px 0;
    background: white;
  }

  .section-header {
    text-align: center;
    margin-bottom: 60px;
  }

  .section-badge {
    display: inline-block;
    padding: 5px 15px;
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.1), rgba(118, 75, 162, 0.1));
    color: #667eea;
    border-radius: 50px;
    font-size: 0.9rem;
    font-weight: 600;
    margin-bottom: 20px;
  }

  .section-title {
    font-size: 2.5rem;
    font-weight: 800;
    margin-bottom: 20px;
    color: #2d3748;
  }

  .section-subtitle {
    font-size: 1.1rem;
    color: #718096;
    max-width: 600px;
    margin: 0 auto;
  }

  .features-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 30px;
  }

  .feature-card-premium {
    background: white;
    padding: 40px 30px;
    border-radius: 20px;
    text-align: center;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
  }

  .feature-card-premium:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
  }

  .feature-icon-wrapper {
    position: relative;
    width: 80px;
    height: 80px;
    margin: 0 auto 25px;
  }

  .feature-icon-bg {
    position: absolute;
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, #667eea, #764ba2);
    border-radius: 50%;
    opacity: 0.1;
    transition: all 0.3s ease;
  }

  .feature-card-premium:hover .feature-icon-bg {
    transform: scale(1.2);
    opacity: 0.2;
  }

  .feature-icon-wrapper i {
    position: relative;
    font-size: 2.5rem;
    color: #667eea;
    line-height: 80px;
  }

  .feature-card-premium h3 {
    font-size: 1.5rem;
    margin-bottom: 15px;
    color: #2d3748;
  }

  .feature-card-premium p {
    color: #718096;
    line-height: 1.6;
    margin-bottom: 20px;
  }

  .feature-link a {
    color: #667eea;
    text-decoration: none;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: all 0.3s ease;
  }

  .feature-link a:hover {
    gap: 12px;
    color: #764ba2;
  }

  /* How It Works Section */
  .how-it-works {
    padding: 100px 0;
    background: linear-gradient(135deg, #f8f9ff, #f0f2ff);
  }

  .steps-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    position: relative;
  }

  .step-item {
    flex: 1;
    text-align: center;
    position: relative;
    padding: 30px;
  }

  .step-number {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    font-weight: 800;
    margin: 0 auto 20px;
    position: relative;
    z-index: 2;
  }

  .step-content {
    background: white;
    padding: 30px;
    border-radius: 20px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
    transition: all 0.3s ease;
  }

  .step-content:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
  }

  .step-icon {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.1), rgba(118, 75, 162, 0.1));
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 20px;
  }

  .step-icon i {
    font-size: 1.5rem;
    color: #667eea;
  }

  .step-content h3 {
    font-size: 1.3rem;
    margin-bottom: 10px;
    color: #2d3748;
  }

  .step-content p {
    color: #718096;
    line-height: 1.6;
  }

  .step-connector {
    width: 100px;
    height: 2px;
    background: linear-gradient(90deg, #667eea, #764ba2);
    position: relative;
  }

  /* Stats Premium Section */
  .stats-premium {
    padding: 100px 0;
    background: linear-gradient(135deg, #667eea, #764ba2);
    position: relative;
    overflow: hidden;
  }

  .stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 30px;
    position: relative;
    z-index: 2;
  }

  .stat-card-premium {
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    padding: 40px;
    border-radius: 20px;
    text-align: center;
    transition: all 0.3s ease;
  }

  .stat-card-premium:hover {
    transform: translateY(-5px);
    background: rgba(255, 255, 255, 0.15);
  }

  .stat-icon {
    font-size: 3rem;
    color: white;
    margin-bottom: 20px;
  }

  .stat-number-wrapper {
    display: flex;
    align-items: baseline;
    justify-content: center;
    gap: 5px;
    margin-bottom: 10px;
  }

  .stat-number {
    font-size: 2.5rem;
    font-weight: 800;
    color: white;
  }

  .stat-suffix {
    font-size: 1.5rem;
    font-weight: 600;
    color: rgba(255, 255, 255, 0.9);
  }

  .stat-label {
    color: rgba(255, 255, 255, 0.9);
    font-size: 1rem;
  }

  /* Testimonials Section */
  .testimonials {
    padding: 100px 0;
    background: white;
  }

  .testimonials-slider {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
    gap: 30px;
    margin-top: 40px;
  }

  .testimonial-card {
    background: white;
    padding: 30px;
    border-radius: 20px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
    transition: all 0.3s ease;
    position: relative;
  }

  .testimonial-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
  }

  .testimonial-quote {
    position: absolute;
    top: 20px;
    right: 30px;
    font-size: 3rem;
    color: rgba(102, 126, 234, 0.1);
  }

  .testimonial-text {
    font-size: 1rem;
    line-height: 1.6;
    color: #4a5568;
    margin-bottom: 25px;
    font-style: italic;
  }

  .testimonial-author {
    display: flex;
    align-items: center;
    gap: 15px;
  }

  .author-avatar {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    overflow: hidden;
  }

  .author-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }

  .author-info h4 {
    font-size: 1rem;
    margin-bottom: 5px;
    color: #2d3748;
  }

  .author-info p {
    font-size: 0.85rem;
    color: #718096;
    margin: 0;
  }

  /* CTA Section */
  .cta-section {
    padding: 100px 0;
    background: linear-gradient(135deg, #f8f9ff, #f0f2ff);
  }

  .cta-wrapper {
    background: linear-gradient(135deg, #667eea, #764ba2);
    border-radius: 30px;
    padding: 60px;
    text-align: center;
    position: relative;
    overflow: hidden;
  }

  .cta-wrapper::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -50%;
    width: 200%;
    height: 200%;
    background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 1%, transparent 1%);
    background-size: 50px 50px;
    animation: moveBackground 20s linear infinite;
  }

  .cta-content {
    position: relative;
    z-index: 2;
  }

  .cta-content h2 {
    font-size: 2.5rem;
    color: white;
    margin-bottom: 20px;
  }

  .cta-content p {
    font-size: 1.1rem;
    color: rgba(255, 255, 255, 0.9);
    margin-bottom: 40px;
  }

  .cta-buttons {
    display: flex;
    gap: 20px;
    justify-content: center;
    flex-wrap: wrap;
  }

  .btn-cta-primary {
    display: inline-flex;
    align-items: center;
    gap: 12px;
    padding: 14px 32px;
    background: white;
    color: #667eea;
    border-radius: 50px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
  }

  .btn-cta-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
  }

  .btn-cta-secondary {
    display: inline-flex;
    align-items: center;
    gap: 12px;
    padding: 14px 32px;
    background: rgba(255, 255, 255, 0.2);
    color: white;
    border-radius: 50px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
    border: 1px solid rgba(255, 255, 255, 0.3);
  }

  .btn-cta-secondary:hover {
    background: rgba(255, 255, 255, 0.3);
    transform: translateY(-2px);
  }

  /* Latest News Section */
  .latest-news {
    padding: 100px 0;
    background: white;
  }

  .news-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
    gap: 30px;
    margin-top: 40px;
  }

  .news-card {
    background: white;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
    transition: all 0.3s ease;
    padding: 30px;
    text-align: center;
  }

  .news-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
  }

  .news-image {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.1), rgba(118, 75, 162, 0.1));
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 20px;
  }

  .news-image i {
    font-size: 2rem;
    color: #667eea;
  }

  .news-date {
    margin-bottom: 15px;
  }

  .news-date span {
    font-size: 0.85rem;
    color: #667eea;
    font-weight: 600;
  }

  .news-card h3 {
    font-size: 1.3rem;
    margin-bottom: 15px;
    color: #2d3748;
  }

  .news-card p {
    color: #718096;
    line-height: 1.6;
    margin-bottom: 20px;
  }

  .read-more {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    color: #667eea;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s ease;
  }

  .read-more:hover {
    gap: 12px;
    color: #764ba2;
  }

  /* Partners Section */
  .partners {
    padding: 80px 0;
    background: linear-gradient(135deg, #f8f9ff, #f0f2ff);
  }

  .partners-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 40px;
    margin-top: 40px;
  }

  .partner-logo {
    text-align: center;
    padding: 30px;
    background: white;
    border-radius: 15px;
    transition: all 0.3s ease;
    cursor: pointer;
  }

  .partner-logo:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
  }

  .partner-logo i {
    font-size: 3rem;
    color: #667eea;
    margin-bottom: 15px;
  }

  .partner-logo span {
    display: block;
    font-weight: 600;
    color: #2d3748;
  }

  /* Animations */
  @keyframes fadeInUp {
    from {
      opacity: 0;
      transform: translateY(30px);
    }

    to {
      opacity: 1;
      transform: translateY(0);
    }
  }

  @keyframes float {

    0%,
    100% {
      transform: translateY(0px);
    }

    50% {
      transform: translateY(-20px);
    }
  }

  @keyframes moveBackground {
    from {
      transform: translate(0, 0);
    }

    to {
      transform: translate(100px, 100px);
    }
  }

  /* Responsive Design */
  @media (max-width: 768px) {
    .hero-title {
      font-size: 2rem;
    }

    .hero-subtitle {
      font-size: 1rem;
    }

    .hero-buttons {
      flex-direction: column;
    }

    .hero-stats {
      flex-direction: column;
      gap: 20px;
    }

    .steps-container {
      flex-direction: column;
    }

    .step-connector {
      width: 2px;
      height: 50px;
      margin: 0 auto;
    }

    .section-title {
      font-size: 1.8rem;
    }

    .cta-wrapper {
      padding: 40px 20px;
    }

    .cta-content h2 {
      font-size: 1.5rem;
    }

    .floating-card {
      display: none;
    }
  }
</style>

<script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
<script>
  // Initialize particles.js
  particlesJS('particles-js', {
    particles: {
      number: {
        value: 80,
        density: {
          enable: true,
          value_area: 800
        }
      },
      color: {
        value: '#ffffff'
      },
      shape: {
        type: 'circle'
      },
      opacity: {
        value: 0.5,
        random: false
      },
      size: {
        value: 3,
        random: true
      },
      line_linked: {
        enable: true,
        distance: 150,
        color: '#ffffff',
        opacity: 0.4,
        width: 1
      },
      move: {
        enable: true,
        speed: 2,
        direction: 'none',
        random: false,
        straight: false,
        out_mode: 'out',
        bounce: false
      }
    },
    interactivity: {
      detect_on: 'canvas',
      events: {
        onhover: {
          enable: true,
          mode: 'repulse'
        },
        onclick: {
          enable: true,
          mode: 'push'
        },
        resize: true
      }
    },
    retina_detect: true
  });

  // Intersection Observer for scroll animations
  const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -50px 0px'
  };

  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.style.opacity = '1';
        entry.target.style.transform = 'translateY(0)';
      }
    });
  }, observerOptions);

  document.querySelectorAll('[data-aos]').forEach(el => {
    el.style.opacity = '0';
    el.style.transform = 'translateY(30px)';
    el.style.transition = 'all 0.6s ease';
    observer.observe(el);
  });

  // Counter animation
  const counters = document.querySelectorAll('.counter');
  const speed = 200;

  const animateCounter = (counter) => {
    const target = parseInt(counter.getAttribute('data-target'));
    let count = 0;
    const increment = target / speed;

    const updateCount = () => {
      if (count < target) {
        count += increment;
        counter.innerText = Math.ceil(count);
        setTimeout(updateCount, 20);
      } else {
        counter.innerText = target;
      }
    };

    updateCount();
  };

  // Trigger counters when they come into view
  const counterObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        const counter = entry.target;
        animateCounter(counter);
        counterObserver.unobserve(counter);
      }
    });
  });

  counters.forEach(counter => {
    counterObserver.observe(counter);
  });
</script>

<?php require_once 'includes/footer.php'; ?>