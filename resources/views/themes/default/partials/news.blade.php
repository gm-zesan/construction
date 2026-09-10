<!-- News / Insights Section -->
<section id="news"
    class="news-section relative py-16 sm:py-20 lg:py-24 bg-[#fbfbf9] text-slate-900 overflow-hidden border-t border-slate-200/70">

    <!-- Atmospheric Blueprint Matrix Grid Motif -->
    <div class="absolute inset-0 pointer-events-none overflow-hidden opacity-40">
        <div
            class="absolute inset-0 bg-[linear-gradient(to_right,#0b0f1708_1px,transparent_1px),linear-gradient(to_bottom,#0b0f1708_1px,transparent_1px)] bg-[size:4rem_4rem]">
        </div>
    </div>

    <!-- Container Fluid -->
    <div class="container-fluid relative z-10 max-w-[1520px] mx-auto px-4 sm:px-6 lg:px-8 xl:px-12">

        <!-- Section Header Row -->
        <div id="news-header-row"
            class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-12 sm:mb-16 will-change-transform">
            <!-- Left: Eyebrow + Headline -->
            <div class="max-w-2xl">
                <!-- Sub Heading / Eyebrow -->
                <div class="sub-heading flex items-center gap-2.5 mb-3 sm:mb-4">
                    <span class="line w-5 h-[2px] bg-[#f95716]"></span>
                    <span class="text-xs font-bold uppercase tracking-[0.2em] text-[#f95716]">
                        Field Logs &amp; Updates
                    </span>
                </div>

                <!-- Section Title -->
                <h2
                    class="section-title font-heading font-black uppercase text-slate-950 tracking-tight leading-[1.04] text-3xl sm:text-4xl lg:text-[44px] xl:text-[50px] m-0">
                    Jobsite Notes, Methods &amp; <br>
                    <span
                        class="font-sketch font-bold text-[#f95716] normal-case text-[1.12em] tracking-normal inline-block transform -rotate-1">Field</span>
                    Updates
                </h2>
            </div>

            <!-- Right: All Field Notes Pill CTA -->
            <div class="flex-shrink-0">
                <a href="#news"
                    class="group inline-flex items-center gap-2.5 px-6 sm:px-7 py-3 sm:py-3.5 rounded-full bg-slate-950 hover:bg-[#f95716] text-white text-xs sm:text-sm font-bold uppercase tracking-wider transition-all duration-300 shadow-md hover:shadow-lg hover:shadow-[#f95716]/25">
                    <span>All Field Notes</span>
                    <svg class="w-4 h-4 transition-transform duration-300 group-hover:translate-x-1 group-hover:-translate-y-1"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                            d="M7 17L17 7M17 7H7M17 7V17" />
                    </svg>
                </a>
            </div>
        </div>

        @php
            $frontendArticles = \App\Models\Article::with('category')->published()->ordered()->take(3)->get();
        @endphp

        <!-- 3-Column News / Insights Grid -->
        <div id="news-cards-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8 lg:gap-10">
            @forelse($frontendArticles as $article)
                <!-- Dynamic Article Card -->
                <article
                    class="news-card group bg-[#f4f3ef] rounded-2xl p-5 sm:p-6 border border-slate-200/80 flex flex-col justify-between transition-all duration-300 hover:border-slate-300/80 will-change-transform">
                    <div>
                        <!-- Card Image Wrapper -->
                        <div class="relative w-full aspect-[16/10] rounded-xl overflow-hidden mb-6 bg-slate-200">
                            <img src="{{ $article->image_url }}"
                                alt="{{ $article->title }}"
                                onerror="this.onerror=null;this.src='{{ asset('images/blog-1.jpg') }}';"
                                class="news-card-img w-full h-full object-cover object-center block transition-transform duration-700 ease-out group-hover:scale-105 will-change-transform"
                                loading="lazy" />
                            <div
                                class="absolute inset-0 bg-gradient-to-t from-black/20 via-transparent to-transparent pointer-events-none">
                            </div>
                        </div>

                        <!-- Meta: Date Badge & Category -->
                        <div class="flex items-center gap-3 mb-4">
                            <span
                                class="inline-block px-3 py-1 rounded-md bg-white text-slate-800 text-xs font-bold uppercase tracking-wider ring-1 ring-slate-900/5 shadow-sm">
                                {{ $article->published_at ? $article->published_at->format('M d, Y') : now()->format('M d, Y') }}
                            </span>
                            <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                {{ $article->category?->name ?? 'Field Note' }} • {{ $article->read_time ?? 3 }} min
                            </span>
                        </div>

                        <!-- Article Title -->
                        <h3
                            class="font-heading font-bold uppercase text-slate-950 text-xl sm:text-2xl tracking-tight leading-tight mb-3 transition-colors duration-200 group-hover:text-[#f95716]">
                            <a href="#news" class="focus:outline-none">
                                {{ $article->title }}
                            </a>
                        </h3>

                        <!-- Excerpt -->
                        <p class="text-slate-600 text-sm font-normal leading-relaxed m-0 mb-6 line-clamp-2">
                            {{ $article->summary ?: \Illuminate\Support\Str::limit(strip_tags($article->content), 120) }}
                        </p>
                    </div>

                    <!-- Read More Action Link -->
                    <div class="pt-4 border-t border-slate-200/70">
                        <a href="#news"
                            class="inline-flex items-center gap-2 text-xs sm:text-sm font-bold uppercase tracking-wider text-slate-900 group-hover:text-[#f95716] transition-colors duration-200">
                            <span>Read Article</span>
                            <svg class="w-4 h-4 text-[#f95716] transition-transform duration-300 group-hover:translate-x-1 group-hover:-translate-y-1"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M7 17L17 7M17 7H7M17 7V17" />
                            </svg>
                        </a>
                    </div>
                </article>
            @empty
                <!-- Fallback Static Cards if empty -->
                <article class="news-card group bg-[#f4f3ef] rounded-2xl p-5 sm:p-6 border border-slate-200/80 flex flex-col justify-between">
                    <div>
                        <div class="relative w-full aspect-[16/10] rounded-xl overflow-hidden mb-6 bg-slate-200">
                            <img src="{{ asset('images/blog-1.jpg') }}" alt="Site Progress Update" class="w-full h-full object-cover">
                        </div>
                        <div class="flex items-center gap-3 mb-4">
                            <span class="px-3 py-1 rounded-md bg-white text-slate-800 text-xs font-bold uppercase">Feb 18, 2026</span>
                            <span class="text-xs font-semibold text-slate-500 uppercase">Site Progress • 3 min</span>
                        </div>
                        <h3 class="font-heading font-bold uppercase text-slate-950 text-xl tracking-tight leading-tight mb-3">
                            <a href="#news">Site Progress Update — Metropolitan Commercial Tower</a>
                        </h3>
                        <p class="text-slate-600 text-sm leading-relaxed mb-6 line-clamp-2">
                            Core shear wall concrete pours reach level 24 with perimeter curtain wall installation progressing.
                        </p>
                    </div>
                </article>
            @endforelse
        </div>

    </div>
</section>