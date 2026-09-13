<!-- Footer for Apex Architectural Dark Theme (Wilmer Style) -->
<footer class="bg-[#050912] border-t border-white/[0.08] relative overflow-hidden text-slate-400">
    <!-- Accent Callout Banner / Pre-Footer -->
    <div class="bg-[#DFFE40] text-slate-950 py-10 px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row items-center justify-between gap-6">
            <div>
                <span class="text-xs font-['Barlow_Condensed'] font-bold uppercase tracking-[0.25em] text-slate-800 block mb-1">
                    {{ get_content('footer', 'cta', 'subtitle', 'Start Your Architectural Project With Us') }}
                </span>
                <h3 class="font-['Barlow_Condensed'] font-black text-2xl sm:text-4xl uppercase tracking-wider text-slate-950">
                    {{ get_content('footer', 'cta', 'title', 'LOOKING FOR A RELIABLE & LICENSED ARCHITECTURAL BUILDER?') }}
                </h3>
            </div>
            <a href="{{ route('contact') }}" class="px-8 py-4 bg-[#080e1a] hover:bg-[#050912] text-white font-['Barlow_Condensed'] font-black text-sm uppercase tracking-widest transition-all shrink-0 shadow-2xl flex items-center gap-3">
                <span>{{ get_content('footer', 'cta', 'btn_text', 'GET A FREE QUOTE') }}</span>
                <i class="ri-arrow-right-line text-lg text-[#DFFE40]"></i>
            </a>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-16 pb-12">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 pb-14 border-b border-white/[0.06]">
            <!-- Column 1: Brand & Bio -->
            <div class="space-y-5">
                <a href="{{ route('home') }}" class="flex items-center gap-3.5">
                    <div class="w-10 h-10 bg-[#DFFE40] flex items-center justify-center text-slate-950 font-['Barlow_Condensed'] font-black text-2xl">
                        A
                    </div>
                    <div class="flex flex-col">
                        <span class="font-['Barlow_Condensed'] font-black text-2xl tracking-wider text-white uppercase leading-none">{{ get_setting('company_name', 'APEX') }}</span>
                        <span class="text-[10px] uppercase font-['Barlow_Condensed'] font-bold tracking-[0.2em] text-[#DFFE40] mt-1">Architecture & Build</span>
                    </div>
                </a>
                <p class="text-sm leading-relaxed text-slate-400 font-light">
                    {!! get_content('footer', 'about', 'description', 'Delivering iconic commercial, industrial, and civil infrastructure with cutting-edge engineering precision.') !!}
                </p>
                <div class="flex items-center gap-2 pt-2">
                    @if(!empty(get_setting('social_facebook')))
                        <a href="{{ get_setting('social_facebook') }}" target="_blank" class="w-9 h-9 bg-white/5 hover:bg-[#DFFE40] hover:text-slate-950 text-slate-300 flex items-center justify-center transition-all">
                            <i class="ri-facebook-fill text-sm"></i>
                        </a>
                    @endif
                    @if(!empty(get_setting('social_linkedin')))
                        <a href="{{ get_setting('social_linkedin') }}" target="_blank" class="w-9 h-9 bg-white/5 hover:bg-[#DFFE40] hover:text-slate-950 text-slate-300 flex items-center justify-center transition-all">
                            <i class="ri-linkedin-fill text-sm"></i>
                        </a>
                    @endif
                    @if(!empty(get_setting('social_twitter')))
                        <a href="{{ get_setting('social_twitter') }}" target="_blank" class="w-9 h-9 bg-white/5 hover:bg-[#DFFE40] hover:text-slate-950 text-slate-300 flex items-center justify-center transition-all">
                            <i class="ri-twitter-x-fill text-sm"></i>
                        </a>
                    @endif
                    @if(!empty(get_setting('social_instagram')))
                        <a href="{{ get_setting('social_instagram') }}" target="_blank" class="w-9 h-9 bg-white/5 hover:bg-[#DFFE40] hover:text-slate-950 text-slate-300 flex items-center justify-center transition-all">
                            <i class="ri-instagram-line text-sm"></i>
                        </a>
                    @endif
                </div>
            </div>

            <!-- Column 2: Quick Links -->
            <div>
                <h4 class="font-['Barlow_Condensed'] font-black text-white text-lg tracking-wider uppercase mb-5 flex items-center gap-2">
                    <span class="w-2 h-2 bg-[#DFFE40]"></span>
                    Quick Navigation
                </h4>
                <ul class="space-y-3 text-sm font-medium">
                    <li><a href="{{ route('home') }}" class="hover:text-[#DFFE40] transition-colors flex items-center gap-2"><i class="ri-arrow-right-s-line text-[#DFFE40]"></i> Home Overview</a></li>
                    <li><a href="{{ route('about') }}" class="hover:text-[#DFFE40] transition-colors flex items-center gap-2"><i class="ri-arrow-right-s-line text-[#DFFE40]"></i> About Firm</a></li>
                    <li><a href="{{ route('public.projects.index') }}" class="hover:text-[#DFFE40] transition-colors flex items-center gap-2"><i class="ri-arrow-right-s-line text-[#DFFE40]"></i> Landmark Projects</a></li>
                    <li><a href="{{ route('team') }}" class="hover:text-[#DFFE40] transition-colors flex items-center gap-2"><i class="ri-arrow-right-s-line text-[#DFFE40]"></i> Technical Directorate</a></li>
                    <li><a href="{{ route('public.articles.index') }}" class="hover:text-[#DFFE40] transition-colors flex items-center gap-2"><i class="ri-arrow-right-s-line text-[#DFFE40]"></i> Research & News</a></li>
                    <li><a href="{{ route('contact') }}" class="hover:text-[#DFFE40] transition-colors flex items-center gap-2"><i class="ri-arrow-right-s-line text-[#DFFE40]"></i> Contact Desk</a></li>
                </ul>
            </div>

            <!-- Column 3: Disciplines -->
            <div>
                <h4 class="font-['Barlow_Condensed'] font-black text-white text-lg tracking-wider uppercase mb-5 flex items-center gap-2">
                    <span class="w-2 h-2 bg-[#DFFE40]"></span>
                    Our Disciplines
                </h4>
                <ul class="space-y-3 text-sm font-medium">
                    <li class="hover:text-[#DFFE40] transition-colors flex items-center gap-2"><i class="ri-checkbox-blank-fill text-[8px] text-[#DFFE40]"></i> Parametric BIM Modeling</li>
                    <li class="hover:text-[#DFFE40] transition-colors flex items-center gap-2"><i class="ri-checkbox-blank-fill text-[8px] text-[#DFFE40]"></i> Commercial Superstructures</li>
                    <li class="hover:text-[#DFFE40] transition-colors flex items-center gap-2"><i class="ri-checkbox-blank-fill text-[8px] text-[#DFFE40]"></i> Eco-Concrete Engineering</li>
                    <li class="hover:text-[#DFFE40] transition-colors flex items-center gap-2"><i class="ri-checkbox-blank-fill text-[8px] text-[#DFFE40]"></i> Seismic Retrofitting</li>
                    <li class="hover:text-[#DFFE40] transition-colors flex items-center gap-2"><i class="ri-checkbox-blank-fill text-[8px] text-[#DFFE40]"></i> Turnkey Construction</li>
                </ul>
            </div>

            <!-- Column 4: Contact Info & Desk -->
            <div>
                <h4 class="font-['Barlow_Condensed'] font-black text-white text-lg tracking-wider uppercase mb-5 flex items-center gap-2">
                    <span class="w-2 h-2 bg-[#DFFE40]"></span>
                    Headquarters
                </h4>
                <ul class="space-y-4 text-sm">
                    <li class="flex items-start gap-3">
                        <i class="ri-map-pin-2-fill text-[#DFFE40] text-lg shrink-0 mt-0.5"></i>
                        <span>{{ get_setting('contact_address', '100 Architectural Plaza, Level 24, New York, NY 10001') }}</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <i class="ri-phone-fill text-[#DFFE40] text-lg shrink-0"></i>
                        <span>{{ get_setting('contact_phone', '+1 (555) 234-5678') }}</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <i class="ri-mail-send-fill text-[#DFFE40] text-lg shrink-0"></i>
                        <span>{{ get_setting('contact_email', 'contact@apexbuild.com') }}</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <i class="ri-time-fill text-[#DFFE40] text-lg shrink-0"></i>
                        <span>{{ get_setting('business_hours', 'Mon - Sat: 8:00 AM - 6:00 PM') }}</span>
                    </li>
                </ul>
            </div>
        </div>

        <div class="pt-8 flex flex-col sm:flex-row justify-between items-center gap-4 text-xs text-slate-500 font-['Barlow_Condensed'] tracking-wider uppercase">
            <p>© {{ date('Y') }} {{ get_setting('company_name', 'Apex Architecture & Build') }}. ALL RIGHTS RESERVED.</p>
            <div class="flex items-center gap-6">
                <a href="#" class="hover:text-[#DFFE40] transition-colors">Privacy Policy</a>
                <span class="text-slate-800">/</span>
                <a href="#" class="hover:text-[#DFFE40] transition-colors">Terms of Build</a>
                <span class="text-slate-800">/</span>
                <a href="#" class="hover:text-[#DFFE40] transition-colors">Safety Standards</a>
            </div>
        </div>
    </div>
</footer>
