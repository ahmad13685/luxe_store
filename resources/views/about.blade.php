@extends('layouts.app')

@section('title', 'About Us | Luxe Store')

@section('content')

    <!-- ============================== ABOUT HERO ============================== -->
    <section class="about-hero">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 about-hero-content reveal">
                    <span class="eyebrow">About Us</span>
                    <h1>Your Trusted <em>Shopping</em> Destination</h1>
                    <p>
                        At Luxe Store, we believe in making premium products accessible
                        to everyone. From fashion to home decor — we bring you quality, style,
                        and convenience all in one place.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- ============================== OUR STORY ============================== -->
    <section class="section-padding">
        <div class="container">
            <div class="about-story-grid">
                <div class="about-story-image reveal">
                    <img src="https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?q=80&w=800&auto=format&fit=crop" alt="Our Story" loading="lazy">
                </div>
                <div class="about-story-text reveal">
                    <span class="eyebrow">Our Story</span>
                    <h2>Bringing You <em>Quality</em> Since 2019</h2>
                    <p>
                        What started as a small passion project has grown into a trusted
                        online shopping destination. We curate products that combine
                        craftsmanship, style, and value — because we believe everyone
                        deserves to own something beautiful.
                    </p>
                    <p>
                        Our team works tirelessly to source the best products, negotiate
                        the best prices, and deliver them to your doorstep with care.
                        We're not just a store — we're your shopping partner.
                    </p>
                    <a href="{{ url('/shop') }}" class="btn-primary-custom">Shop Our Collection</a>
                </div>
            </div>
        </div>
    </section>

    <!-- ============================== STATS ============================== -->
    <section class="section-padding bg-card">
        <div class="container">
            <div class="section-head reveal">
                <span class="eyebrow">By the Numbers</span>
                <h2>Our Impact</h2>
            </div>
            <div class="stats-grid">
                <div class="stat-card reveal">
                    <span class="stat-icon">🛍️</span>
                    <span class="stat-number" data-count="50000">0</span>
                    <span class="stat-label">Happy Customers</span>
                </div>
                <div class="stat-card reveal">
                    <span class="stat-icon">⭐</span>
                    <span class="stat-number" data-count="4.9">0</span>
                    <span class="stat-label">Average Rating</span>
                </div>
                <div class="stat-card reveal">
                    <span class="stat-icon">📦</span>
                    <span class="stat-number" data-count="500">0</span>
                    <span class="stat-label">Premium Products</span>
                </div>
                <div class="stat-card reveal">
                    <span class="stat-icon">🌍</span>
                    <span class="stat-number" data-count="100">0</span>
                    <span class="stat-label">% Authentic Products</span>
                </div>
            </div>
        </div>
    </section>

    <!-- ============================== OUR VALUES ============================== -->
    <section class="section-padding">
        <div class="container">
            <div class="section-head reveal">
                <span class="eyebrow">What We Believe</span>
                <h2>Our Values</h2>
            </div>
            <div class="values-grid">
                <div class="value-card reveal">
                    <div class="value-icon">🔍</div>
                    <h3>Quality First</h3>
                    <p>We never compromise on quality. Every product is carefully selected and tested before it reaches you.</p>
                </div>
                <div class="value-card reveal">
                    <div class="value-icon">🤝</div>
                    <h3>Trust &amp; Transparency</h3>
                    <p>Honest pricing, clear policies, and a commitment to doing right by our customers every single time.</p>
                </div>
                <div class="value-card reveal">
                    <div class="value-icon">🌱</div>
                    <h3>Sustainable Choices</h3>
                    <p>We're building a better future with eco-friendly packaging and sustainable product sourcing.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ============================== TESTIMONIALS ============================== -->
    <section class="section-padding testi-strip-about">
        <div class="container">
            <div class="section-head reveal">
                <span class="eyebrow">What Our Customers Say</span>
                <h2>Real Feedback</h2>
            </div>
            <div class="testi-grid-about">
                <div class="testi-card-about reveal">
                    <span class="stars">★★★★★</span>
                    <p>Amazing quality and super fast delivery! The leather bag I ordered exceeded all expectations. Will definitely shop again.</p>
                    <div class="testi-person-about">
                        <img src="https://images.unsplash.com/photo-1544005313-94ddf0286df2?q=80&w=100&auto=format&fit=crop" alt="Customer" loading="lazy">
                        <div><b>Amara K.</b><span>Verified Buyer</span></div>
                    </div>
                </div>
                <div class="testi-card-about reveal">
                    <span class="stars">★★★★★</span>
                    <p>I ordered a watch and it arrived beautifully packaged. The quality is premium and the customer service was top-notch.</p>
                    <div class="testi-person-about">
                        <img src="https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?q=80&w=100&auto=format&fit=crop" alt="Customer" loading="lazy">
                        <div><b>Danish M.</b><span>Verified Buyer</span></div>
                    </div>
                </div>
                <div class="testi-card-about reveal">
                    <span class="stars">★★★★★</span>
                    <p>Finally found a store that has everything I need in one place. From fashion to home decor — I'm a loyal customer now!</p>
                    <div class="testi-person-about">
                        <img src="https://images.unsplash.com/photo-1531123897727-8f129e1688ce?q=80&w=100&auto=format&fit=crop" alt="Customer" loading="lazy">
                        <div><b>Noor H.</b><span>Verified Buyer</span></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ============================== CTA BANNER ============================== -->
    <section class="section-padding">
        <div class="container">
            <div class="cta-banner reveal">
                <h2>Ready to Start Shopping?</h2>
                <p>Explore our curated collection of premium products and experience shopping like never before.</p>
                <a href="{{ url('/shop') }}" class="cta-btn">Shop Now →</a>
            </div>
        </div>
    </section>
    

@endsection
