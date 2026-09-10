<!-- Footer for Apex Architectural Dark Theme -->
<footer class="bg-[#05070d] border-t border-white/[0.08] pt-16 pb-12 relative overflow-hidden text-slate-400">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-10 pb-12 border-b border-white/[0.06]">
            <!-- Column 1: Brand & Bio -->
            <div class="lg:col-span-2 space-y-4">
                <a href="{{ route('home') }}" class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-amber-400 flex items-center justify-center text-slate-950 font-syne font-black text-xl">
                        A
                    </div>
                    <div>
                        <span class="font-syne font-black text-xl text-white">{{ get_setting('company_name', 'APEX') }}</span>
                        <span class="block text-[10px] uppercase font-bold tracking-widest text-amber-400">Architecture & Build</span>
                    </div>
                </a>
                <p class="text-sm leading-relaxed text-slate-400 max-w-sm">
                    {!! get_content('footer', 'about', 'description', 'Delivering iconic commercial, industrial, and civil infrastructure with cutting-edge engineering precision.') !!}
                </p>
                <div class="flex items-center gap-3 pt-2">
                    @if(!empty(get_setting('social_facebook')))
                        <a href="{{ get_setting('social_facebook') }}" target="_blank" class="w-9 h-9 rounded-lg bg-white/5 hover:bg-amber-400 hover:text-slate-950 flex items-center justify-center transition-colors">
                            <span class="font-bold text-xs">Fb</span>
                        </a>
                    @endif
                    @if(!empty(get_setting('social_linkedin')))
                        <a href="{{ get_setting('social_linkedin') }}" target="_blank" class="w-9 h-9 rounded-lg bg-white/5 hover:bg-amber-400 hover:text-slate-950 flex items-center justify-center transition-colors">
                            <span class="font-bold text-xs">In</span>
                        </a>
                    @endif
                    @if(!empty(get_setting('social_twitter')))
                        <a href="{{ get_setting('social_twitter') }}" target="_blank" class="w-9 h-9 rounded-lg bg-white/5 hover:bg-amber-400 hover:text-slate-950 flex items-center justify-center transition-colors">
                            <span class="font-bold text-xs">X</span>
                        </a>
                    @endif
                </div>
            </div>

            <!-- Column 2: Navigation -->
            <div>
                <h4 class="font-syne font-bold text-white text-sm tracking-wider uppercase mb-4">Quick Links</h4>
                <ul class="space-y-2.5 text-sm">
                    <li><a href="{{ route('home') }}" class="hover:text-amber-400 transition-colors">Home</a></li>
                    <li><a href="{{ route('about') }}" class="hover:text-amber-400 transition-colors">About Firm</a></li>
                    <li><a href="{{ route('public.projects.index') }}" class="hover:text-amber-400 transition-colors">Portfolio</a></li>
                    <li><a href="{{ route('team') }}" class="hover:text-amber-400 transition-colors">Executive Team</a></li>
                    <li><a href="{{ route('public.articles.index') }}" class="hover:text-amber-400 transition-colors">Industry News</a></li>
                    <li><a href="{{ route('contact') }}" class="hover:text-amber-400 transition-colors">Contact</a></li>
                </ul>
            </div>

            <!-- Column 3: Contact Info -->
            <div class="lg:col-span-2">
                <h4 class="font-syne font-bold text-white text-sm tracking-wider uppercase mb-4">Headquarters</h4>
                <ul class="space-y-3 text-sm">
                    <li class="flex items-start gap-3">
                        <span class="text-amber-400">📍</span>
                        <span>{{ get_setting('contact_address', '100 Construction Blvd, Suite 400, New York, NY 10001') }}</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <span class="text-amber-400">📞</span>
                        <span>{{ get_setting('contact_phone', '+1 (555) 234-5678') }}</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <span class="text-amber-400">✉️</span>
                        <span>{{ get_setting('contact_email', 'contact@construct.com') }}</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <span class="text-amber-400">⏰</span>
                        <span>{{ get_setting('business_hours', 'Mon - Sat: 8:00 AM - 6:00 PM') }}</span>
                    </li>
                </ul>
            </div>
        </div>

        <div class="pt-8 flex flex-col sm:flex-row justify-between items-center gap-4 text-xs text-slate-500">
            <p>© {{ date('Y') }} {{ get_setting('company_name', 'Apex Construction') }}. All rights reserved.</p>
            <div class="flex items-center gap-6">
                <a href="#" class="hover:text-slate-300">Privacy Policy</a>
                <a href="#" class="hover:text-slate-300">Terms of Service</a>
                <a href="#" class="hover:text-slate-300">Safety Compliance</a>
            </div>
        </div>
    </div>
</footer>
