{{--
═══════════════════════════════════════════════════════════════
REVIEWS SECTION - AJAX ENABLED
Logic: Submit form via Fetch API -> Show Success -> Auto Refresh
═══════════════════════════════════════════════════════════════
--}}
<section class="border-t border-neutral-100 py-16 lg:py-24 bg-neutral-50/30" id="reviews">
    <div class="max-w-[1400px] mx-auto px-6 grid lg:grid-cols-12 gap-12">

        {{-- LEFT COLUMN: Summary & Form --}}
        <div class="lg:col-span-4">
            <h2 class="text-2xl font-bold mb-4 tracking-tight">Reviews</h2>

            {{-- Rating Summary --}}
            <div class="flex items-baseline gap-4 mb-6">
                <span class="text-5xl font-bold tracking-tighter">{{ number_format($product->avg_rating, 1)
                    }}</span>
                <div class="flex flex-col">
                    <div class="flex text-black text-xs">
                        @for($i=1; $i<=5; $i++) <svg
                            class="w-4 h-4 {{ $i <= round($product->avg_rating) ? 'fill-black' : 'text-neutral-300 fill-none' }}"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                            </svg>
                            @endfor
                    </div>
                    <span class="text-xs text-neutral-500 mt-1 font-medium">{{ $product->reviews_count }}
                        reviews</span>
                </div>
            </div>

            {{-- Review Form Area (AlpineJS Logic) --}}
            <div x-data="{ 
                        open: false, 
                        submitting: false, 
                        success: false,
                        rating: 5, 
                        hoverRating: 0,
                        fit: 3,
                        
                        submitReview(e) {
                            this.submitting = true;
                            const formData = new FormData(e.target);
                            
                            fetch(e.target.action, {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                                    'Accept': 'application/json'
                                },
                                body: formData
                            })
                            .then(response => {
                                if (!response.ok) throw response;
                                return response.json();
                            })
                            .then(data => {
                                this.success = true;
                                this.submitting = false;
                                this.open = false;
                                // Tự động reload trang sau 1.5s để hiện review mới
                                setTimeout(() => {
                                    window.location.reload(); 
                                }, 1500);
                            })
                            .catch(err => {
                                this.submitting = false;
                                alert('Please check your inputs and try again.');
                                console.error(err);
                            });
                        }
                    }">
                @auth
                <button @click="open = !open" x-show="!success"
                    class="w-full py-4 border border-black text-black text-xs font-bold uppercase tracking-widest hover:bg-black hover:text-white transition duration-300">
                    <span x-text="open ? 'Close' : 'Write a Review'"></span>
                </button>

                {{-- Success Message --}}
                <div x-show="success" x-transition
                    class="p-4 bg-green-50 border border-green-100 text-green-800 text-center text-sm mb-4">
                    <p class="font-bold">Thank you!</p>
                    <p class="text-xs mt-1">Your review has been submitted.</p>
                </div>

                {{-- Form --}}
                <div x-show="open && !success" x-collapse class="mt-6">
                    <form action="{{ route('reviews.store', $product->id) }}" method="POST"
                        enctype="multipart/form-data" @submit.prevent="submitReview">

                        {{-- Star Rating --}}
                        <div class="mb-5">
                            <label
                                class="block text-[10px] font-bold uppercase tracking-widest mb-2 text-neutral-500">Rating</label>
                            <div class="flex gap-1 cursor-pointer" @mouseleave="hoverRating = 0">
                                <template x-for="i in 5">
                                    <svg @click="rating = i" @mouseover="hoverRating = i"
                                        class="w-6 h-6 transition-colors duration-200"
                                        :class="(hoverRating || rating) >= i ? 'fill-black text-black' : 'text-neutral-200 fill-none'"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                    </svg>
                                </template>
                            </div>
                            <input type="hidden" name="rating" :value="rating">
                        </div>

                        {{-- Fit Slider --}}
                        <div class="mb-5">
                            <label
                                class="block text-[10px] font-bold uppercase tracking-widest mb-3 text-neutral-500">How's
                                the fit?</label>
                            <input type="range" name="fit_rating" min="1" max="5" step="1" x-model="fit"
                                class="w-full h-1 bg-neutral-200 rounded-lg appearance-none cursor-pointer accent-black">
                            <div
                                class="flex justify-between text-[9px] text-neutral-400 uppercase mt-2 font-bold tracking-wider">
                                <span :class="fit == 1 ? 'text-black' : ''">Tight</span>
                                <span :class="fit == 3 ? 'text-black' : ''">True</span>
                                <span :class="fit == 5 ? 'text-black' : ''">Loose</span>
                            </div>
                        </div>

                        {{-- Comment --}}
                        <div class="mb-5">
                            <label
                                class="block text-[10px] font-bold uppercase tracking-widest mb-2 text-neutral-500">Your
                                Review</label>
                            <textarea name="comment" rows="4" required
                                placeholder="Tell us about the quality, fit, and style..."
                                class="w-full bg-neutral-50 border border-transparent p-4 text-sm focus:bg-white focus:border-black focus:ring-0 transition duration-300 resize-none placeholder-neutral-400"></textarea>
                        </div>

                        {{-- Image --}}
                        <div class="mb-6">
                            <label
                                class="block text-[10px] font-bold uppercase tracking-widest mb-2 text-neutral-500">Add
                                a Photo (Optional)</label>
                            <input type="file" name="image" accept="image/*"
                                class="block w-full text-xs text-neutral-500 file:mr-4 file:py-2.5 file:px-4 file:border-0 file:text-[10px] file:font-bold file:uppercase file:bg-neutral-900 file:text-white hover:file:bg-black transition cursor-pointer">
                        </div>

                        <button type="submit" :disabled="submitting"
                            class="w-full py-4 bg-black text-white text-xs font-bold uppercase tracking-widest hover:bg-neutral-800 transition disabled:opacity-50">
                            <span x-text="submitting ? 'Submitting...' : 'Post Review'"></span>
                        </button>
                    </form>
                </div>
                @else
                <div class="bg-neutral-50 p-6 text-center border border-neutral-100">
                    <p class="text-xs text-neutral-500 mb-3">Please login to write a review</p>
                    <a href="{{ route('login') }}"
                        class="inline-block border-b border-black text-xs font-bold uppercase tracking-widest pb-0.5 hover:text-neutral-600 transition">Login
                        Here</a>
                </div>
                @endauth
            </div>
        </div>

        {{-- RIGHT COLUMN: Reviews List --}}
        <div class="lg:col-span-8 space-y-10">

            {{-- SỬA: Đổi $product->reviews thành $reviews --}}
            @forelse($reviews as $review)
            <div class="border-b border-neutral-200 pb-8 last:border-0 last:pb-0">
                {{-- (Giữ nguyên code hiển thị từng review của bà ở đây) --}}
                <div class="flex items-start justify-between mb-4">
                    <div class="flex items-center gap-4">
                        <div
                            class="w-10 h-10 rounded-full bg-neutral-100 flex items-center justify-center text-xs font-bold text-neutral-900 uppercase tracking-widest border border-neutral-200">
                            {{ substr($review->user->name, 0, 1) }}
                        </div>
                        <div>
                            <h4 class="text-sm font-bold text-neutral-900">{{ $review->user->name }}</h4>
                            <span class="text-[10px] text-neutral-400 uppercase tracking-wider font-medium">{{
                                $review->created_at->format('M d, Y') }}</span>
                        </div>
                    </div>

                    {{-- Stars Display --}}
                    <div class="flex gap-0.5">
                        @for($i=1; $i<=5; $i++) <svg
                            class="w-3.5 h-3.5 {{ $i <= $review->rating ? 'fill-black' : 'text-neutral-200 fill-none' }}"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                            </svg>
                            @endfor
                    </div>
                </div>

                <div class="pl-14">
                    {{-- Fit Badge --}}
                    @php
                    $fitLabel = match($review->fit_rating) {
                    1 => 'Runs Small', 2 => 'Slightly Small', 3 => 'True to Size', 4 => 'Slightly Large', 5 =>
                    'Runs Large', default => 'True to Size'
                    };
                    @endphp
                    @if($product->category->slug === 'fashion' || !empty($product->sizes))
                    <div class="mb-3">
                        <span
                            class="inline-block text-[9px] font-bold uppercase tracking-widest border border-neutral-200 px-2 py-1 bg-white text-neutral-600">
                            Fit: {{ $fitLabel }}
                        </span>
                    </div>
                    @endif

                    <p class="text-sm text-neutral-700 leading-relaxed font-light mb-4">
                        {!! nl2br(e($review->comment)) !!}
                    </p>

                    @if($review->image)
                    <div class="mt-4">
                        <img src="{{ Storage::url($review->image) }}"
                            class="w-24 h-24 object-cover cursor-zoom-in grayscale hover:grayscale-0 transition duration-500 border border-neutral-100"
                            onclick="window.open(this.src)">
                    </div>
                    @endif
                </div>
            </div>
            @empty
            <div class="py-16 text-center border border-dashed border-neutral-200 rounded-lg">
                <p class="text-neutral-400 font-light text-sm italic">No reviews yet.</p>
            </div>
            @endforelse

            {{-- PHẦN MỚI THÊM: Pagination Links --}}
            {{-- fragment('reviews'): Giúp trình duyệt tự cuộn xuống #reviews sau khi bấm trang mới --}}
            <div class="mt-8">
                {{ $reviews->fragment('reviews')->links() }}
            </div>

        </div>
</section>

{{--
========================================================
5. CURATED FOR YOU (LV / EDITORIAL STYLE)
Layout: Bento Grid (1 Large Left + 4 Small Grid Right)
========================================================
--}}
@if(isset($relatedProducts) && $relatedProducts->count() > 0)
<section class="border-t border-black py-20 lg:py-24 bg-white">
    <div class="max-w-[1400px] mx-auto px-6">

        {{-- Typography Heading --}}
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-12">
            <h2 class="text-4xl md:text-6xl font-light tracking-tighter leading-none text-neutral-900">
                Curated <br> <span class="font-serif italic text-neutral-400 pl-16">for you.</span>
            </h2>
            <a href="{{ route('products.index') }}"
                class="mt-6 md:mt-0 text-xs font-bold uppercase tracking-widest border-b border-black pb-1 hover:text-neutral-600 hover:border-neutral-600 transition">View
                Collection</a>
        </div>

        {{-- BENTO GRID LAYOUT --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 h-auto md:h-[600px]">

            @foreach($relatedProducts->take(5) as $index => $related)
            @php
            $imgUrl = $related->image ? Storage::url('products/' . $related->image) :
            'https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?auto=format&fit=crop&q=80&w=800';

            // LOGIC QUAN TRỌNG:
            // Item đầu tiên (index 0): Chiếm 2 cột, 2 dòng (To bự bên trái)
            // Các item còn lại: Chiếm 1 cột, 1 dòng (Vuông nhỏ bên phải)
            $classes = ($index === 0)
            ? 'col-span-2 row-span-2 md:h-full relative group'
            : 'col-span-1 row-span-1 relative group';
            @endphp

            <div class="{{ $classes }} overflow-hidden bg-neutral-100">
                {{-- Ảnh --}}
                <img src="{{ $imgUrl }}"
                    class="w-full h-full object-cover transition duration-[1.5s] ease-out group-hover:scale-105"
                    loading="lazy">

                {{-- Badges --}}
                @if($index === 0)
                <div class="absolute top-4 left-4 bg-black text-white text-[10px] font-bold uppercase px-3 py-1.5 z-10">
                    New Drop</div>
                @elseif($related->is_new)
                <div class="absolute top-2 left-2 w-2 h-2 bg-red-500 rounded-full z-10"></div>
                @endif

                {{-- Info Overlay (Hiệu ứng mờ dần từ dưới lên) --}}
                <div
                    class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 flex flex-col justify-end p-6">
                    <div class="translate-y-4 group-hover:translate-y-0 transition-transform duration-500 text-white">
                        <h3 class="text-sm md:text-lg font-bold uppercase tracking-widest">{{ $related->name }}
                        </h3>
                        <p class="text-xs md:text-sm font-light mt-1 opacity-90">₫{{
                            number_format($related->price, 0, ',', '.') }}</p>
                        <a href="{{ route('products.show', $related->id) }}"
                            class="inline-block mt-3 text-[10px] font-bold uppercase border-b border-white pb-0.5">Shop
                            Now</a>
                    </div>
                </div>

                {{-- Link bao trùm --}}
                <a href="{{ route('products.show', $related->id) }}" class="absolute inset-0 z-20"></a>
            </div>
            @endforeach

        </div>
    </div>
</section>
@endif