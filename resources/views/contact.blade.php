@extends('layouts.app')

@section('title', 'Contact Us | Luxe Store')

@section('content')

    <!-- ============================== CONTACT HERO ============================== -->
    <section class="contact-hero">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 contact-hero-content reveal">
                    <span class="eyebrow">Get in Touch</span>
                    <h1>We'd Love to <em>Hear</em> From You</h1>
                    <p>
                        Have a question, feedback, or just want to say hello? 
                        Reach out to us — our team is here to help you with 
                        anything you need.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- ============================== CONTACT INFO ============================== -->
    <section class="section-padding">
        <div class="container">
            <div class="contact-info-grid">
                <!-- Info 1: Email -->
                <div class="contact-info-card reveal">
                    <div class="info-icon">
                        <i class="bi bi-envelope"></i>
                    </div>
                    <h4>Email Us</h4>
                    <p><a href="mailto:support@luxestore.com">support@luxestore.com</a></p>
                    <p class="text-muted small">We reply within 24 hours</p>
                </div>

                <!-- Info 2: Phone -->
                <div class="contact-info-card reveal">
                    <div class="info-icon">
                        <i class="bi bi-telephone"></i>
                    </div>
                    <h4>Call Us</h4>
                    <p><a href="tel:+15550123456">+1 (555) 012-3456</a></p>
                    <p class="text-muted small">Mon-Fri 9AM to 6PM</p>
                </div>

                <!-- Info 3: Location -->
                <div class="contact-info-card reveal">
                    <div class="info-icon">
                        <i class="bi bi-geo-alt"></i>
                    </div>
                    <h4>Visit Us</h4>
                    <p>221B Baker Street, London, UK</p>
                    <p class="text-muted small">By appointment only</p>
                </div>
            </div>

            <!-- ============================== CONTACT FORM ============================== -->
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="contact-form-wrapper reveal">
                        <div class="row">
                            <div class="col-lg-6">
                                <h2 class="fw-bold mb-3" style="font-size:1.8rem;">Send Us a Message</h2>
                                <p class="text-muted mb-4">
                                    Fill in the form below and we'll get back to you as soon as possible.
                                </p>
                            </div>
                            <div class="col-lg-6 text-lg-end">
                                <span class="badge" style="background:var(--color-accent);color:#fff;padding:10px 20px;border-radius:50px;">
                                    <i class="bi bi-clock me-1"></i> Response time: 4-6 hours
                                </span>
                            </div>
                        </div>

                        <!-- Form -->
                        <form id="contactForm">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="contactName" class="form-label">Full Name</label>
                                    <input type="text" class="form-control" id="contactName" placeholder="Enter your full name" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="contactEmail" class="form-label">Email Address</label>
                                    <input type="email" class="form-control" id="contactEmail" placeholder="Enter your email" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="contactPhone" class="form-label">Phone Number</label>
                                    <input type="tel" class="form-control" id="contactPhone" placeholder="Enter your phone number">
                                </div>
                                <div class="col-md-6">
                                    <label for="contactSubject" class="form-label">Subject</label>
                                    <select class="form-control" id="contactSubject">
                                        <option value="General Inquiry">General Inquiry</option>
                                        <option value="Product Question">Product Question</option>
                                        <option value="Order Issue">Order Issue</option>
                                        <option value="Feedback">Feedback</option>
                                        <option value="Partnership">Partnership</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>
                                <div class="col-12">
                                    <label for="contactMessage" class="form-label">Message</label>
                                    <textarea class="form-control" id="contactMessage" placeholder="Write your message here..." required></textarea>
                                </div>
                                <div class="col-12">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="contactConsent" required>
                                        <label class="form-check-label small text-muted" for="contactConsent">
                                            I agree to the <a href="#" style="color:var(--color-accent);">Privacy Policy</a> and consent to being contacted.
                                        </label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn-submit">
                                        <i class="bi bi-send me-2"></i> Send Message
                                    </button>
                                </div>
                            </div>
                        </form>

                        <!-- Success Message -->
                        <div class="form-success" id="formSuccess">
                            <i class="bi bi-check-circle-fill"></i>
                            <h3>Message Sent!</h3>
                            <p>Thank you for reaching out. Our team will get back to you within 24 hours.</p>
                            <button class="btn-primary-custom mt-3" onclick="resetForm()">Send Another Message</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ============================== MAP ============================== -->
            <div class="map-wrapper reveal">
                <iframe 
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2483.029531892095!2d-0.15737088422914492!3d51.52376997963745!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x48761acef9a13d1b%3A0x4e39d5dbfbc13c63!2s221B%20Baker%20St%2C%20London%20NW1%206XE%2C%20UK!5e0!3m2!1sen!2sus!4v1700000000000" 
                    allowfullscreen="" 
                    loading="lazy" 
                    referrerpolicy="no-referrer-when-downgrade"
                    title="Luxe Store Location"
                ></iframe>
            </div>

        </div>
    </section>
    <!-- ============ FOOTER ============ -->
     

@endsection
