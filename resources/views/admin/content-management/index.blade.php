@extends('admin.app')

@section('title')
    Content Management
@endsection

@push('custom-style')
    <style>
        .cms-group-btn {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 9px 12px;
            background: transparent;
            border: none;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 600;
            color: #1e293b;
            cursor: pointer;
            transition: all 0.2s ease;
            text-align: left;
            margin-bottom: 2px;
        }

        .cms-group-btn:hover {
            background-color: #f1f5f9;
            color: #0f172a;
        }

        .cms-chevron {
            transition: transform 0.2s ease;
            font-size: 16px;
            color: #64748b;
        }

        .cms-group-btn:not(.collapsed) .cms-chevron {
            transform: rotate(180deg);
        }

        .cms-nav-link {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 8px 12px 8px 24px;
            border-radius: 6px;
            color: #475569;
            font-size: 12.5px;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.15s ease;
            cursor: pointer;
            margin-bottom: 2px;
        }

        .cms-nav-link:hover {
            background-color: #f1f5f9;
            color: #0f172a;
        }

        .cms-nav-link.active {
            background-color: #fff3ee;
            color: #f95716;
            font-weight: 600;
        }

        .cms-nav-link.active i {
            color: #f95716 !important;
        }

        .dropzone-box {
            border: 2px dashed #cbd5e1;
            border-radius: 8px;
            background-color: #f8fafc;
            padding: 20px 16px;
            text-align: center;
            cursor: pointer;
            transition: all 0.2s ease;
            position: relative;
        }

        .dropzone-box:hover,
        .dropzone-box.dragover {
            border-color: #f95716;
            background-color: #fff7ed;
        }

        .dropzone-icon {
            width: 44px;
            height: 44px;
            line-height: 44px;
            border-radius: 50%;
            background-color: rgba(249, 87, 22, 0.1);
            color: #f95716;
            font-size: 22px;
            margin: 0 auto 8px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid my-3">
        <div class="row g-3">

            {{-- Left Column: Sections Navigation --}}
            <div class="col-lg-3 col-md-4 col-12">
                <div class="card table-card sticky-top" style="top: 75px; z-index: 10;">
                    <div class="card-header table-header d-flex justify-content-between align-items-center">
                        <div class="table-title">Content Sections</div>
                        <span class="badge bg-light text-dark border" style="font-size: 11px;">CMS</span>
                    </div>
                    <div class="card-body p-2" id="cmsAccordionParent" style="max-height: calc(100vh - 160px); overflow-y: auto;">
                        
                        {{-- Group 1: Homepage --}}
                        <div class="cms-accordion-group mb-1">
                            <button class="cms-group-btn collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#group-homepage" aria-expanded="false">
                                <span class="d-flex align-items-center"><i class="ri-home-4-line me-2 text-primary"></i> Homepage</span>
                                <i class="ri-arrow-down-s-line cms-chevron"></i>
                            </button>
                            <div class="collapse" id="group-homepage" data-bs-parent="#cmsAccordionParent">
                                <div class="cms-group-body py-1">
                                    <a class="cms-nav-link active" data-target="home-hero" data-breadcrumb-page="Homepage" data-breadcrumb-section="Hero Banner">
                                        <span><i class="ri-tv-line me-2 text-muted"></i>Hero Banner</span>
                                        <i class="ri-arrow-right-s-line text-muted"></i>
                                    </a>
                                    <a class="cms-nav-link" data-target="home-about" data-breadcrumb-page="Homepage" data-breadcrumb-section="About Section">
                                        <span><i class="ri-file-user-line me-2 text-muted"></i>About Section</span>
                                        <i class="ri-arrow-right-s-line text-muted"></i>
                                    </a>
                                    <a class="cms-nav-link" data-target="home-services" data-breadcrumb-page="Homepage" data-breadcrumb-section="Services Section">
                                        <span><i class="ri-hammer-line me-2 text-muted"></i>Services Section</span>
                                        <i class="ri-arrow-right-s-line text-muted"></i>
                                    </a>
                                    <a class="cms-nav-link" data-target="home-projects" data-breadcrumb-page="Homepage" data-breadcrumb-section="Projects Section">
                                        <span><i class="ri-community-line me-2 text-muted"></i>Projects Section</span>
                                        <i class="ri-arrow-right-s-line text-muted"></i>
                                    </a>
                                    <a class="cms-nav-link" data-target="home-why-choose" data-breadcrumb-page="Homepage" data-breadcrumb-section="Why Choose Us">
                                        <span><i class="ri-shield-check-line me-2 text-muted"></i>Why Choose Us</span>
                                        <i class="ri-arrow-right-s-line text-muted"></i>
                                    </a>
                                    <a class="cms-nav-link" data-target="home-stats" data-breadcrumb-page="Homepage" data-breadcrumb-section="Statistics & Counters">
                                        <span><i class="ri-bar-chart-box-line me-2 text-muted"></i>Statistics</span>
                                        <i class="ri-arrow-right-s-line text-muted"></i>
                                    </a>
                                    <a class="cms-nav-link" data-target="home-reviews" data-breadcrumb-page="Homepage" data-breadcrumb-section="Client Reviews">
                                        <span><i class="ri-feedback-line me-2 text-muted"></i>Client Reviews</span>
                                        <i class="ri-arrow-right-s-line text-muted"></i>
                                    </a>
                                    <a class="cms-nav-link" data-target="home-cta" data-breadcrumb-page="Homepage" data-breadcrumb-section="CTA Banner">
                                        <span><i class="ri-megaphone-line me-2 text-muted"></i>CTA Banner</span>
                                        <i class="ri-arrow-right-s-line text-muted"></i>
                                    </a>
                                </div>
                            </div>
                        </div>

                        {{-- Group 2: About Us Page --}}
                        <div class="cms-accordion-group mb-1">
                            <button class="cms-group-btn collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#group-about" aria-expanded="false">
                                <span class="d-flex align-items-center"><i class="ri-building-line me-2 text-info"></i> About Us Page</span>
                                <i class="ri-arrow-down-s-line cms-chevron"></i>
                            </button>
                            <div class="collapse" id="group-about" data-bs-parent="#cmsAccordionParent">
                                <div class="cms-group-body py-1">
                                    <a class="cms-nav-link" data-target="about-overview" data-breadcrumb-page="About Us" data-breadcrumb-section="Overview">
                                        <span><i class="ri-information-line me-2 text-muted"></i>Overview</span>
                                        <i class="ri-arrow-right-s-line text-muted"></i>
                                    </a>
                                    <a class="cms-nav-link" data-target="about-mission-vision" data-breadcrumb-page="About Us" data-breadcrumb-section="Mission & Vision">
                                        <span><i class="ri-focus-3-line me-2 text-muted"></i>Mission &amp; Vision</span>
                                        <i class="ri-arrow-right-s-line text-muted"></i>
                                    </a>
                                    <a class="cms-nav-link" data-target="about-values" data-breadcrumb-page="About Us" data-breadcrumb-section="Core Values">
                                        <span><i class="ri-heart-pulse-line me-2 text-muted"></i>Core Values</span>
                                        <i class="ri-arrow-right-s-line text-muted"></i>
                                    </a>
                                    <a class="cms-nav-link" data-target="about-history" data-breadcrumb-page="About Us" data-breadcrumb-section="Company History">
                                        <span><i class="ri-history-line me-2 text-muted"></i>Company History</span>
                                        <i class="ri-arrow-right-s-line text-muted"></i>
                                    </a>
                                </div>
                            </div>
                        </div>

                        {{-- Group 3: Contact Page --}}
                        <div class="cms-accordion-group mb-1">
                            <button class="cms-group-btn collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#group-contact" aria-expanded="false">
                                <span class="d-flex align-items-center"><i class="ri-phone-line me-2 text-success"></i> Contact Page</span>
                                <i class="ri-arrow-down-s-line cms-chevron"></i>
                            </button>
                            <div class="collapse" id="group-contact" data-bs-parent="#cmsAccordionParent">
                                <div class="cms-group-body py-1">
                                    <a class="cms-nav-link" data-target="contact-info" data-breadcrumb-page="Contact" data-breadcrumb-section="Contact Information">
                                        <span><i class="ri-contacts-line me-2 text-muted"></i>Contact Info</span>
                                        <i class="ri-arrow-right-s-line text-muted"></i>
                                    </a>
                                    <a class="cms-nav-link" data-target="contact-office" data-breadcrumb-page="Contact" data-breadcrumb-section="Office & Map">
                                        <span><i class="ri-map-pin-2-line me-2 text-muted"></i>Office &amp; Map</span>
                                        <i class="ri-arrow-right-s-line text-muted"></i>
                                    </a>
                                    <a class="cms-nav-link" data-target="contact-social" data-breadcrumb-page="Contact" data-breadcrumb-section="Social Media">
                                        <span><i class="ri-share-line me-2 text-muted"></i>Social Links</span>
                                        <i class="ri-arrow-right-s-line text-muted"></i>
                                    </a>
                                </div>
                            </div>
                        </div>

                        {{-- Group 4: Footer --}}
                        <div class="cms-accordion-group mb-1">
                            <button class="cms-group-btn collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#group-footer" aria-expanded="false">
                                <span class="d-flex align-items-center"><i class="ri-layout-bottom-line me-2 text-warning"></i> Footer &amp; Global</span>
                                <i class="ri-arrow-down-s-line cms-chevron"></i>
                            </button>
                            <div class="collapse" id="group-footer" data-bs-parent="#cmsAccordionParent">
                                <div class="cms-group-body py-1">
                                    <a class="cms-nav-link" data-target="footer-content" data-breadcrumb-page="Footer" data-breadcrumb-section="Footer Content & Links">
                                        <span><i class="ri-layout-bottom-line me-2 text-muted"></i>Footer &amp; Links</span>
                                        <i class="ri-arrow-right-s-line text-muted"></i>
                                    </a>
                                </div>
                            </div>
                        </div>

                        {{-- Group 5: SEO --}}
                        <div class="cms-accordion-group mb-1">
                            <button class="cms-group-btn collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#group-seo" aria-expanded="false">
                                <span class="d-flex align-items-center"><i class="ri-search-eye-line me-2 text-danger"></i> SEO &amp; Meta</span>
                                <i class="ri-arrow-down-s-line cms-chevron"></i>
                            </button>
                            <div class="collapse" id="group-seo" data-bs-parent="#cmsAccordionParent">
                                <div class="cms-group-body py-1">
                                    <a class="cms-nav-link" data-target="seo-settings" data-breadcrumb-page="SEO" data-breadcrumb-section="Page Meta Settings">
                                        <span><i class="ri-search-eye-line me-2 text-muted"></i>SEO Settings</span>
                                        <i class="ri-arrow-right-s-line text-muted"></i>
                                    </a>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            {{-- Right Column: Active Content Section Form --}}
            <div class="col-lg-9 col-md-8 col-12">
                <div class="card table-card mb-4">
                    <div class="card-header table-header d-flex justify-content-between align-items-center">
                        <div class="title-with-breadcrumb">
                            <div class="table-title" id="activeSectionTitle">Hero Banner Section</div>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb mb-0">
                                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                                    <li class="breadcrumb-item" id="breadcrumbPage">Homepage</li>
                                    <li class="breadcrumb-item active" id="breadcrumbSection" aria-current="page">Hero Banner</li>
                                </ol>
                            </nav>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <a href="{{ route('home') }}" target="_blank" class="add-new">
                                <i class="ri-external-link-line me-1"></i> View Live Site
                            </a>
                        </div>
                    </div>

                    <div class="card-body custom-form">

                        {{-- PANE 1: Homepage - Hero Section --}}
                        <div class="cms-section-pane" id="pane-home-hero">
                            <div class="row g-3">
                                <div class="col-md-6 col-12">
                                    <label class="form-label custom-label">Hero Badge / Tagline</label>
                                    <input type="text" class="form-control custom-input" value="BUILDING TOMORROW'S LANDMARKS">
                                </div>
                                <div class="col-md-6 col-12">
                                    <label class="form-label custom-label">Main Headline <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control custom-input" value="Architectural Precision, Industrial Strength">
                                </div>
                                <div class="col-12">
                                    <label class="form-label custom-label">Subheadline / Description</label>
                                    <textarea class="form-control custom-input" rows="3">Delivering landmark commercial complexes, transit hubs, and heavy industrial infrastructures with uncompromising structural integrity and sustainable engineering.</textarea>
                                </div>
                                <div class="col-md-6 col-12">
                                    <label class="form-label custom-label">Primary Button Label</label>
                                    <input type="text" class="form-control custom-input" value="Explore Projects">
                                </div>
                                <div class="col-md-6 col-12">
                                    <label class="form-label custom-label">Primary Button URL</label>
                                    <input type="text" class="form-control custom-input" value="#projects">
                                </div>
                                <div class="col-md-6 col-12">
                                    <label class="form-label custom-label">Secondary Button Label</label>
                                    <input type="text" class="form-control custom-input" value="Get Free Consultation">
                                </div>
                                <div class="col-md-6 col-12">
                                    <label class="form-label custom-label">Secondary Button URL</label>
                                    <input type="text" class="form-control custom-input" value="#contact">
                                </div>
                                <div class="col-12">
                                    <label class="form-label custom-label">Hero Background Image</label>
                                    <input type="file" id="hero_background_input" class="d-none" accept="image/png,image/jpeg,image/webp,image/jpg">
                                    
                                    <div id="hero_dropzone_box" class="dropzone-box">
                                        <div id="hero_empty_state">
                                            <div class="dropzone-icon">
                                                <i class="ri-image-add-line"></i>
                                            </div>
                                            <div class="fw-semibold text-dark mt-1" style="font-size: 13.5px;">Click to upload or drag &amp; drop background image</div>
                                            <div class="text-muted" style="font-size: 11.5px;">Recommended size: 1920x1080 (PNG, JPG, WebP up to 10MB)</div>
                                        </div>

                                        <div id="hero_preview_state" class="d-none">
                                            <div class="position-relative d-inline-block rounded overflow-hidden border mb-2" style="max-width: 100%; max-height: 240px; background: #0f172a;">
                                                <img id="hero_preview_img" src="" alt="Hero Preview" style="max-height: 220px; width: auto; max-width: 100%; object-fit: contain; display: block;">
                                            </div>
                                            <div class="d-flex align-items-center justify-content-center gap-2 mt-1">
                                                <span id="hero_filename" class="text-dark fw-semibold" style="font-size: 12px;"></span>
                                                <button type="button" class="btn btn-sm btn-outline-danger py-0 px-2" id="hero_remove_btn" style="font-size: 11px;">
                                                    <i class="ri-delete-bin-line me-1"></i> Remove
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- PANE 2: Homepage - About Section --}}
                        <div class="cms-section-pane d-none" id="pane-home-about">
                            <div class="row g-3">
                                <div class="col-md-6 col-12">
                                    <label class="form-label custom-label">Section Tag / Badge</label>
                                    <input type="text" class="form-control custom-input" value="About Our Company">
                                </div>
                                <div class="col-md-6 col-12">
                                    <label class="form-label custom-label">Years of Experience</label>
                                    <input type="text" class="form-control custom-input" value="25+">
                                </div>
                                <div class="col-12">
                                    <label class="form-label custom-label">Section Title</label>
                                    <input type="text" class="form-control custom-input" value="Crafting Heavy-Duty Landmarks That Stand For Generations">
                                </div>
                                <div class="col-12">
                                    <label class="form-label custom-label">Story & Description</label>
                                    <textarea class="form-control custom-input" rows="4">With over two decades of engineering excellence, Building & Co. leads the industry in delivering mega infrastructure, commercial towers, and industrial logistics facilities with rigorous safety standards and BIM-enabled precision.</textarea>
                                </div>
                            </div>
                        </div>

                        {{-- PANE 3: Homepage - Services Section --}}
                        <div class="cms-section-pane d-none" id="pane-home-services">
                            <div class="row g-3">
                                <div class="col-md-6 col-12">
                                    <label class="form-label custom-label">Section Tag</label>
                                    <input type="text" class="form-control custom-input" value="Engineering Specialties">
                                </div>
                                <div class="col-md-6 col-12">
                                    <label class="form-label custom-label">Section Title</label>
                                    <input type="text" class="form-control custom-input" value="Comprehensive Construction & Structural Solutions">
                                </div>
                                <div class="col-12">
                                    <label class="form-label custom-label">Section Intro Text</label>
                                    <textarea class="form-control custom-input" rows="3">From turnkey general contracting to seismic structural engineering and MEP systems, we handle complex builds from conception to commissioning.</textarea>
                                </div>
                                <div class="col-12">
                                    <div class="alert alert-info py-2 px-3 mb-0" style="font-size: 12.5px;">
                                        <i class="ri-information-line me-1"></i> Individual service cards and details are managed directly in the <a href="{{ route('services.index') }}" class="fw-bold text-primary">Core Services</a> module.
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- PANE 4: Homepage - Projects Section --}}
                        <div class="cms-section-pane d-none" id="pane-home-projects">
                            <div class="row g-3">
                                <div class="col-md-6 col-12">
                                    <label class="form-label custom-label">Section Tag</label>
                                    <input type="text" class="form-control custom-input" value="Featured Portfolio">
                                </div>
                                <div class="col-md-6 col-12">
                                    <label class="form-label custom-label">Section Title</label>
                                    <input type="text" class="form-control custom-input" value="Landmark Developments Built to Last">
                                </div>
                                <div class="col-12">
                                    <div class="alert alert-info py-2 px-3 mb-0" style="font-size: 12.5px;">
                                        <i class="ri-information-line me-1"></i> Project items and gallery photos are managed in the <a href="{{ route('projects.index') }}" class="fw-bold text-primary">Project Portfolio</a> module.
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- PANE 5: Homepage - Why Choose Us --}}
                        <div class="cms-section-pane d-none" id="pane-home-why-choose">
                            <div class="row g-3">
                                <div class="col-md-6 col-12">
                                    <label class="form-label custom-label">Section Badge</label>
                                    <input type="text" class="form-control custom-input" value="Why Choose Building & Co.">
                                </div>
                                <div class="col-md-6 col-12">
                                    <label class="form-label custom-label">Section Headline</label>
                                    <input type="text" class="form-control custom-input" value="Precision Engineering, Uncompromising Safety & On-Time Delivery">
                                </div>
                            </div>
                        </div>

                        {{-- PANE 6: Homepage - Statistics --}}
                        <div class="cms-section-pane d-none" id="pane-home-stats">
                            <div class="row g-3">
                                <div class="col-md-6 col-12">
                                    <label class="form-label custom-label">Stat 1: Number & Suffix</label>
                                    <input type="text" class="form-control custom-input mb-1" value="350+">
                                    <label class="form-label custom-label">Stat 1: Label</label>
                                    <input type="text" class="form-control custom-input" value="Completed Builds">
                                </div>
                                <div class="col-md-6 col-12">
                                    <label class="form-label custom-label">Stat 2: Number & Suffix</label>
                                    <input type="text" class="form-control custom-input mb-1" value="99.8%">
                                    <label class="form-label custom-label">Stat 2: Label</label>
                                    <input type="text" class="form-control custom-input" value="Safety Record">
                                </div>
                            </div>
                        </div>

                        {{-- PANE 7: Homepage - Client Reviews --}}
                        <div class="cms-section-pane d-none" id="pane-home-reviews">
                            <div class="row g-3">
                                <div class="col-md-6 col-12">
                                    <label class="form-label custom-label">Section Tag</label>
                                    <input type="text" class="form-control custom-input" value="Client Testimonials">
                                </div>
                                <div class="col-md-6 col-12">
                                    <label class="form-label custom-label">Headline</label>
                                    <input type="text" class="form-control custom-input" value="Trusted by Global Developers & Institutional Investors">
                                </div>
                                <div class="col-12">
                                    <div class="alert alert-info py-2 px-3 mb-0" style="font-size: 12.5px;">
                                        <i class="ri-information-line me-1"></i> Reviews are managed and featured in the <a href="{{ route('client-reviews.index') }}" class="fw-bold text-primary">Client Reviews</a> module.
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- PANE 8: Homepage - CTA --}}
                        <div class="cms-section-pane d-none" id="pane-home-cta">
                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="form-label custom-label">CTA Heading <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control custom-input" value="Ready to Construct Your Next Landmark?">
                                </div>
                                <div class="col-12">
                                    <label class="form-label custom-label">CTA Paragraph</label>
                                    <textarea class="form-control custom-input" rows="3">Consult with our licensed civil engineers and project directors for feasibility studies, pre-construction estimates, and turnkey construction planning.</textarea>
                                </div>
                            </div>
                        </div>

                        {{-- PANE 9: About Us - Overview --}}
                        <div class="cms-section-pane d-none" id="pane-about-overview">
                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="form-label custom-label">Page Title</label>
                                    <input type="text" class="form-control custom-input" value="Engineering the Future of Infrastructure & Commercial Spaces">
                                </div>
                                <div class="col-12">
                                    <label class="form-label custom-label">Company Overview</label>
                                    <textarea class="form-control custom-input" rows="4">Founded with a vision to redefine commercial and heavy infrastructure construction, Building & Co. has grown into a premier multi-disciplinary general contractor trusted across North America.</textarea>
                                </div>
                            </div>
                        </div>

                        {{-- PANE 10: About Us - Mission & Vision --}}
                        <div class="cms-section-pane d-none" id="pane-about-mission-vision">
                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="form-label custom-label">Mission Statement</label>
                                    <textarea class="form-control custom-input" rows="3">Our mission is to construct resilient, sustainable, and technologically superior physical environments that enrich communities, foster economic growth, and ensure maximum safety for our workforce.</textarea>
                                </div>
                                <div class="col-12">
                                    <label class="form-label custom-label">Vision Statement</label>
                                    <textarea class="form-control custom-input" rows="3">To lead the construction industry into an era of zero carbon footprint, automated digital twins, and zero incident worksites across all global projects.</textarea>
                                </div>
                            </div>
                        </div>

                        {{-- PANE 11: About Us - Core Values --}}
                        <div class="cms-section-pane d-none" id="pane-about-values">
                            <div class="row g-3">
                                <div class="col-md-6 col-12">
                                    <label class="form-label custom-label">Value 1</label>
                                    <input type="text" class="form-control custom-input mb-1" value="Uncompromising Structural Safety">
                                    <input type="text" class="form-control custom-input" value="Every life on our job site matters above all else.">
                                </div>
                                <div class="col-md-6 col-12">
                                    <label class="form-label custom-label">Value 2</label>
                                    <input type="text" class="form-control custom-input mb-1" value="BIM-Driven Precision">
                                    <input type="text" class="form-control custom-input" value="Eliminating tolerances through digital engineering modeling.">
                                </div>
                            </div>
                        </div>

                        {{-- PANE 12: About Us - Company History --}}
                        <div class="cms-section-pane d-none" id="pane-about-history">
                            <div class="row g-3">
                                <div class="col-md-4 col-12">
                                    <label class="form-label custom-label">Year 1999</label>
                                    <input type="text" class="form-control custom-input" value="Company Founded in Seattle, WA">
                                </div>
                                <div class="col-md-4 col-12">
                                    <label class="form-label custom-label">Year 2010</label>
                                    <input type="text" class="form-control custom-input" value="Completed 100th High-Rise Project">
                                </div>
                            </div>
                        </div>

                        {{-- PANE 13: Contact - Contact Information --}}
                        <div class="cms-section-pane d-none" id="pane-contact-info">
                            <div class="row g-3">
                                <div class="col-md-6 col-12">
                                    <label class="form-label custom-label">Primary Office Phone</label>
                                    <input type="text" class="form-control custom-input" value="+1 (800) 555-0199">
                                </div>
                                <div class="col-md-6 col-12">
                                    <label class="form-label custom-label">Direct Project Hotline</label>
                                    <input type="text" class="form-control custom-input" value="+1 (206) 555-8822">
                                </div>
                                <div class="col-md-6 col-12">
                                    <label class="form-label custom-label">Inquiry Email</label>
                                    <input type="email" class="form-control custom-input" value="bids@buildingco-construct.com">
                                </div>
                                <div class="col-md-6 col-12">
                                    <label class="form-label custom-label">Support Email</label>
                                    <input type="email" class="form-control custom-input" value="info@buildingco-construct.com">
                                </div>
                            </div>
                        </div>

                        {{-- PANE 14: Contact - Office & Map --}}
                        <div class="cms-section-pane d-none" id="pane-contact-office">
                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="form-label custom-label">Headquarters Physical Address</label>
                                    <input type="text" class="form-control custom-input" value="742 Evergreen Terrace, Industrial Park Suite 400, Seattle, WA 98101">
                                </div>
                                <div class="col-md-6 col-12">
                                    <label class="form-label custom-label">Monday - Friday Hours</label>
                                    <input type="text" class="form-control custom-input" value="07:00 AM - 06:00 PM PST">
                                </div>
                                <div class="col-md-6 col-12">
                                    <label class="form-label custom-label">Saturday Hours</label>
                                    <input type="text" class="form-control custom-input" value="08:00 AM - 02:00 PM PST">
                                </div>
                                <div class="col-12">
                                    <label class="form-label custom-label">Google Maps Embed URL</label>
                                    <input type="text" class="form-control custom-input" value="https://maps.google.com/embed?pb=...">
                                </div>
                            </div>
                        </div>

                        {{-- PANE 15: Contact - Social Links --}}
                        <div class="cms-section-pane d-none" id="pane-contact-social">
                            <div class="row g-3">
                                <div class="col-md-6 col-12">
                                    <label class="form-label custom-label">LinkedIn</label>
                                    <input type="url" class="form-control custom-input" value="https://linkedin.com/company/buildingco">
                                </div>
                                <div class="col-md-6 col-12">
                                    <label class="form-label custom-label">Facebook</label>
                                    <input type="url" class="form-control custom-input" value="https://facebook.com/buildingco">
                                </div>
                                <div class="col-md-6 col-12">
                                    <label class="form-label custom-label">Twitter / X</label>
                                    <input type="url" class="form-control custom-input" value="https://x.com/buildingco">
                                </div>
                                <div class="col-md-6 col-12">
                                    <label class="form-label custom-label">Instagram</label>
                                    <input type="url" class="form-control custom-input" value="https://instagram.com/buildingco">
                                </div>
                            </div>
                        </div>

                        {{-- PANE 16: Footer - Content & Links --}}
                        <div class="cms-section-pane d-none" id="pane-footer-content">
                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="form-label custom-label">Footer Brand Bio</label>
                                    <textarea class="form-control custom-input" rows="3">A premier civil engineering and general contracting firm executing heavy commercial, residential, and transit projects with state-of-the-art precision.</textarea>
                                </div>
                                <div class="col-md-6 col-12">
                                    <label class="form-label custom-label">Copyright Text</label>
                                    <input type="text" class="form-control custom-input" value="© 2026 Building & Co. Construction. All Rights Reserved.">
                                </div>
                                <div class="col-md-6 col-12">
                                    <label class="form-label custom-label">License & Registration</label>
                                    <input type="text" class="form-control custom-input" value="State GC License: #WA-CON-8849201">
                                </div>
                            </div>
                        </div>

                        {{-- PANE 17: SEO Settings --}}
                        <div class="cms-section-pane d-none" id="pane-seo-settings">
                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="form-label custom-label">Homepage Meta Title</label>
                                    <input type="text" class="form-control custom-input" value="Building & Co. | Premier Commercial & Civil Engineering Construction">
                                </div>
                                <div class="col-12">
                                    <label class="form-label custom-label">Homepage Meta Description</label>
                                    <textarea class="form-control custom-input" rows="3">Leading general contractor delivering mega commercial complexes, transit infrastructure, and heavy industrial facilities with certified engineering precision.</textarea>
                                </div>
                                <div class="col-12">
                                    <label class="form-label custom-label">Meta Keywords</label>
                                    <input type="text" class="form-control custom-input" value="commercial construction, civil engineering, general contractor, heavy infrastructure">
                                </div>
                            </div>
                        </div>

                        {{-- Action Buttons --}}
                        <div class="row mt-4 pt-3 border-top">
                            <div class="col-12 d-flex align-items-center">
                                <button type="button" class="btn submit-button me-2" onclick="handleMockSave()">
                                    <i class="ri-check-line me-1"></i> Save Changes
                                </button>
                                <a href="{{ route('dashboard') }}" class="btn leave-button">
                                    <i class="ri-arrow-left-line me-1"></i> Dashboard
                                </a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@push('custom-script')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Automatically collapse main sidebar on page open
            const mainSidebar = document.querySelector('.sidebar');
            if (mainSidebar && mainSidebar.classList.contains('active')) {
                mainSidebar.classList.remove('active');
            }

            const navLinks = document.querySelectorAll('.cms-nav-link');
            const panes = document.querySelectorAll('.cms-section-pane');
            const titleElement = document.getElementById('activeSectionTitle');
            const breadcrumbPage = document.getElementById('breadcrumbPage');
            const breadcrumbSection = document.getElementById('breadcrumbSection');

            navLinks.forEach(link => {
                link.addEventListener('click', function (e) {
                    e.preventDefault();

                    // Switch active link
                    navLinks.forEach(l => l.classList.remove('active'));
                    this.classList.add('active');

                    // Update titles & breadcrumbs
                    const pageName = this.getAttribute('data-breadcrumb-page') || 'Homepage';
                    const sectionName = this.getAttribute('data-breadcrumb-section') || 'Section';

                    if (titleElement) titleElement.textContent = sectionName;
                    if (breadcrumbPage) breadcrumbPage.textContent = pageName;
                    if (breadcrumbSection) breadcrumbSection.textContent = sectionName;

                    // Show target pane
                    const targetId = 'pane-' + this.getAttribute('data-target');
                    panes.forEach(pane => {
                        if (pane.id === targetId) {
                            pane.classList.remove('d-none');
                        } else {
                            pane.classList.add('d-none');
                        }
                    });
                });
            });

            // Hero Background Image Interactive Dropzone
            const heroInput = document.getElementById('hero_background_input');
            const heroDropzone = document.getElementById('hero_dropzone_box');
            const heroEmptyState = document.getElementById('hero_empty_state');
            const heroPreviewState = document.getElementById('hero_preview_state');
            const heroPreviewImg = document.getElementById('hero_preview_img');
            const heroFilename = document.getElementById('hero_filename');
            const heroRemoveBtn = document.getElementById('hero_remove_btn');

            if (heroDropzone && heroInput) {
                heroDropzone.addEventListener('click', function (e) {
                    if (e.target.closest('#hero_remove_btn')) return;
                    heroInput.click();
                });

                heroInput.addEventListener('change', function () {
                    if (this.files && this.files[0]) {
                        handleHeroFile(this.files[0]);
                    }
                });

                heroDropzone.addEventListener('dragover', function (e) {
                    e.preventDefault();
                    this.classList.add('dragover');
                });

                heroDropzone.addEventListener('dragleave', function (e) {
                    e.preventDefault();
                    this.classList.remove('dragover');
                });

                heroDropzone.addEventListener('drop', function (e) {
                    e.preventDefault();
                    this.classList.remove('dragover');
                    if (e.dataTransfer.files && e.dataTransfer.files[0]) {
                        heroInput.files = e.dataTransfer.files;
                        handleHeroFile(e.dataTransfer.files[0]);
                    }
                });

                function handleHeroFile(file) {
                    if (!file.type.match('image.*')) {
                        if (typeof toastr !== 'undefined') toastr.error('Please select an image file (PNG, JPG, WebP)');
                        return;
                    }
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        heroPreviewImg.src = e.target.result;
                        if (heroFilename) heroFilename.textContent = file.name + ' (' + (file.size / 1024 / 1024).toFixed(2) + ' MB)';
                        heroEmptyState.classList.add('d-none');
                        heroPreviewState.classList.remove('d-none');
                        if (typeof toastr !== 'undefined') toastr.success('Hero image selected: ' + file.name);
                    };
                    reader.readAsDataURL(file);
                }

                if (heroRemoveBtn) {
                    heroRemoveBtn.addEventListener('click', function (e) {
                        e.stopPropagation();
                        heroInput.value = '';
                        heroPreviewImg.src = '';
                        heroEmptyState.classList.remove('d-none');
                        heroPreviewState.classList.add('d-none');
                    });
                }
            }
        });

        function handleMockSave() {
            if (typeof toastr !== 'undefined') {
                toastr.success('Content Management changes ready for saving.', 'Success');
            } else {
                alert('Content Management changes ready for saving.');
            }
        }
    </script>
@endpush