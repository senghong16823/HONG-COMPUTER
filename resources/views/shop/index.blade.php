<x-storefront-layout title="HONG COMPUTER">

    <!-- 1. HERO SECTION & PROMOTIONAL BANNERS -->
    @if(!request()->anyFilled(['category_id', 'brand_id', 'search', 'min_price', 'max_price', 'in_stock']))
        <div class="bg-gradient-to-r  from-slate-900 via-blue-950 to-slate-900 text-white py-12 px-4 relative overflow-hidden">
            <!-- Ambient decorative shapes -->
            <div class="absolute -top-24 -right-24 w-96 h-96 bg-blue-500/10 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute -bottom-24 -left-24 w-96 h-96 bg-amber-500/10 rounded-full blur-3xl pointer-events-none"></div>

            <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-12 gap-8 items-center relative z-10">

                <!-- Left Hero Text -->
                <div class="lg:col-span-7 space-y-5">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-500/20 border border-blue-400/30 text-blue-300 text-xs font-semibold">
                        <i class="fa-solid fa-bolt text-amber-400"></i> រដូវកាលលក់បញ្ចុះតម្លៃពិសេស
                    </div>
                    <h1 class="text-3xl sm:text-5xl font-extrabold tracking-tight leading-tight">
                        ស្វែងរកកុំព្យូទ័រក្នុងក្តីស្រមៃ <br><br>
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 via-sky-300 to-amber-300">
                            កម្លាំងខ្លាំង តម្លៃសមរម្យ
                        </span>
                    </h1>
                    <p class="text-sm sm:text-base text-slate-300 max-w-xl font-normal leading-relaxed">
                        មានស្តុក Laptop, Gaming, Ultrabook និងគ្រឿងបន្លាស់កុំព្យូទ័រម៉ាកល្បីៗជាច្រើន <span>ជាមួយការធានាផ្លូវការ និងសេវាដឹកជញ្ជូនរហ័សដល់ផ្ទះ។</span>
                    </p>

                    <!-- Action CTA & Active Coupons Ticker -->
                    <div class="flex flex-wrap items-center gap-4 pt-2">
                        <a href="#catalog" class="px-6 py-3 bg-blue-600 hover:bg-blue-500 text-white font-bold rounded-2xl shadow-lg shadow-blue-500/30 transition transform hover:-translate-y-0.5 flex items-center gap-2 text-sm">
                            <i class="fa-solid fa-basket-shopping"></i> ទិញទំនិញឥឡូវនេះ
                        </a>
                        <a href="{{ route('order.track') }}" class="px-6 py-3 bg-slate-800/80 hover:bg-slate-700 text-slate-200 font-semibold rounded-2xl border border-slate-700 transition text-sm flex items-center gap-2">
                            <i class="fa-solid fa-route text-amber-400"></i> តាមដានការបញ្ជាទិញ
                        </a>
                    </div>

                    <!-- Active Promo Coupons Badge Strip -->
                    @if($activeCoupons->count() > 0)
                        <div class="pt-4 flex items-center gap-3 flex-wrap">
                            <span class="text-xs text-slate-400 font-medium">គូប៉ុងពិសេសថ្ងៃនេះ៖</span>
                            @foreach($activeCoupons as $c)
                                <div class="inline-flex items-center gap-2 px-3 py-1 bg-amber-400/10 border border-amber-400/30 rounded-xl text-amber-300 text-xs font-mono font-bold">
                                    <i class="fa-solid fa-tag text-[10px]"></i>
                                    <span>{{ $c->code }}</span>
                                    <span class="text-[10px] text-amber-200/80 font-sans">
                                        ({{ ($c->type === 'percentage' || $c->type === 'percent') ? $c->value . '%' : '$' . $c->value }} OFF)
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- Right Hero Image Showcase -->
                <div class="lg:col-span-5 relative h-full w-full lg:mt-0">
                    <!-- លុប max-w-lg និង flex ធ្វើឱ្យកណ្តាលចេញ ដើម្បីឱ្យវាលាតពេញ -->
                    <div class="relative h-full w-full animate-hero-float">

                        <!-- Soft Ambient Glow behind image -->
                        <div
                            class="absolute inset-0 bg-gradient-to-r from-blue-600/40 via-sky-400/20 rounded-full blur-3xl pointer-events-none">
                        </div>

                        <!-- Image Container -->
                        <div class="relative h-full w-full overflow-hidden rounded-r-lg">
                            <img src="{{ asset('uploads/products/Strix_G18_KV_16x9_p-2000-removebg-preview.png') }}" alt="ROG 2026"
                                class="relative w-full h-full object-cover drop-shadow-2xl hover:scale-105 transition-transform duration-500 cursor-pointer">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- 2. BRAND SHOWCASE TICKER -->
    {{-- @if($brands->count() > 0)
        <div class="bg-white border-b border-slate-200 py-4 shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center gap-6 overflow-x-auto no-scrollbar py-1">
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider shrink-0 flex items-center gap-1.5">
                        <i class="fa-solid fa-award text-blue-600"></i> ម៉ាកយីហោ៖
                    </span>
                    <a href="{{ route('shop.index') }}"
                       class="shrink-0 px-3.5 py-1.5 rounded-xl text-xs font-semibold transition {{ !request('brand_id') ? 'bg-slate-900 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                        ទាំងអស់
                    </a>
                    @foreach($brands as $b)
                        <a href="{{ route('shop.index', array_merge(request()->query(), ['brand_id' => $b->id])) }}"
                           class="shrink-0 px-3.5 py-1.5 rounded-xl text-xs font-semibold transition flex items-center gap-2 {{ request('brand_id') == $b->id ? 'bg-blue-600 text-white shadow-sm' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                            @if($b->logo)
                                <img src="{{ asset($b->logo) }}" alt="{{ $b->name }}" class="w-4 h-4 object-contain">
                            @endif
                            <span>{{ $b->name }}</span>
                            <span class="text-[10px] opacity-70">({{ $b->products_count }})</span>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    @endif --}}

    <!-- 3. MAIN CATALOG CONTAINER -->
    <div id="catalog" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="flex flex-col lg:flex-row gap-8">

            <!-- A. FILTER SIDEBAR (Desktop & Mobile) -->
            <aside class="w-full lg:w-72 shrink-0 space-y-6">

                <!-- Filter Card -->
                <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm p-5 space-y-6">
                    <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                        <h3 class="font-bold text-lg text-blue-800 flex items-center gap-2">
                            <i class="fa-solid fa-sliders text-amber-600"></i>
                            <span>ស្វែងរក (Filters)</span>
                        </h3>
                        @if(request()->anyFilled(['category_id', 'brand_id', 'search', 'min_price', 'max_price', 'in_stock']))
                            <a href="{{ route('shop.index') }}" class="text-xs font-bold text-rose-600 hover:text-rose-700 flex items-center gap-1 bg-rose-50 px-2.5 py-1 rounded-lg transition" title="បង្ហាញទំនិញទាំងអស់">
                                {{-- <i class="fa-solid fa-rotate-left text-[10px]"></i> បង្ហាញទាំងអស់ --}}
                            </a>
                        @endif
                    </div>

                    <form action="{{ route('shop.index') }}" method="GET" class="space-y-6" id="filterForm">
                        @if(request('search'))
                            <input type="hidden" name="search" value="{{ request('search') }}">
                        @endif
                        @if(request('sort'))
                            <input type="hidden" name="sort" value="{{ request('sort') }}">
                        @endif

                        <!-- Filter 1: Categories -->
                        <div>
                            <div class="flex items-center justify-between mb-3">
                                <label class="block text-[15px] font-bold text-slate-700 uppercase tracking-wider">
                                    ប្រភេទកុំព្យូទ័រ
                                </label>
                                @if(request('category_id'))
                                    <a href="{{ route('shop.index', request()->except(['category_id', 'page'])) }}"
                                       class="text-xs font-bold text-rose-600 hover:text-rose-700 flex items-center gap-1 bg-rose-50 px-2 py-0.5 rounded-lg transition"
                                       title="ដកប្រភេទចេញ">
                                        <i class="fa-solid fa-xmark text-[10px]"></i> ដកចេញ
                                    </a>
                                @endif
                            </div>
                            <div class="space-y-1">
                                <!-- ទាំងអស់ (All Categories) - ចុចទៅបង្ហាញកុំព្យូទ័រទាំងអស់មកវិញ -->
                                <a href="{{ route('shop.index') }}"
                                   class="flex items-center justify-between px-3 py-2 rounded-xl text-[14px] font-semibold transition {{ !request('category_id') && !request('brand_id') ? 'bg-blue-50 text-blue-700 font-bold' : 'text-slate-600 hover:bg-slate-50' }}">
                                    <div class="flex items-center gap-2">
                                        <i class="fa-solid fa-border-all text-[12px] text-blue-600"></i>
                                        <span>ទាំងអស់ (All Categories)</span>
                                    </div>
                                    
                                </a>
                                @foreach($categories as $cat)
                                    <a href="{{ request('category_id') == $cat->id ? route('shop.index', request()->except(['category_id', 'page'])) : route('shop.index', array_merge(request()->except('page'), ['category_id' => $cat->id])) }}"
                                       class="flex items-center justify-between px-3 py-2 rounded-xl text-[14px] font-semibold transition {{ request('category_id') == $cat->id ? 'bg-blue-50 text-blue-700 font-bold' : 'text-slate-600 hover:bg-slate-50' }}">
                                        <div class="flex items-center gap-2">
                                            <i class="{{ $cat->icon ?? 'fa-solid fa-laptop' }} text-[11px] text-slate-400"></i>
                                            <span>{{ $cat->name }}</span>
                                        </div>
                                        @if(request('category_id') == $cat->id)
                                            <i class="fa-solid fa-circle-check text-xs text-blue-600"></i>
                                        @endif
                                    </a>
                                @endforeach
                            </div>
                        </div>

                        <!-- Filter 2: Brands -->
                        @if($brands->count() > 0)
                            <div class="pt-4 border-t border-slate-100">
                                <div class="flex items-center justify-between mb-3">
                                    <label class="block text-[15px] font-bold text-blue-800 uppercase tracking-wider">
                                        ម៉ាកយីហោ (Brands)
                                    </label>
                                    @if(request('brand_id'))
                                        <a href="{{ route('shop.index', request()->except(['brand_id', 'page'])) }}"
                                           class="text-xs font-bold text-rose-600 hover:text-rose-700 flex items-center gap-1 bg-rose-50 px-2 py-0.5 rounded-lg transition"
                                           title="ដកម៉ាកយីហោចេញ">
                                            <i class="fa-solid fa-xmark text-[10px]"></i> ដកម៉ាកចេញ
                                        </a>
                                    @endif
                                </div>
                                <div class="space-y-1.5 max-h-52 overflow-y-auto pr-1">
                                    <!-- ជម្រើស: ម៉ាកទាំងអស់ (All Brands) -->
                                    <label class="flex items-center justify-between p-2 rounded-xl hover:bg-slate-50 cursor-pointer text-[14px]">
                                        <div class="flex items-center gap-2">
                                            <input type="radio" name="brand_id" value=""
                                                   {{ !request('brand_id') ? 'checked' : '' }}
                                                   onchange="this.form.submit()"
                                                   class="w-4 h-4 text-blue-600 border-slate-300 focus:ring-blue-500 cursor-pointer">
                                            <span class="font-medium {{ !request('brand_id') ? 'text-blue-700 font-bold' : 'text-slate-700' }}">
                                                ម៉ាកទាំងអស់ (All Brands)
                                            </span>
                                        </div>
                                    </label>

                                    <!-- បញ្ជីម៉ាកយីហោនីមួយៗ (អាចដកវិញបានពេលចុចម្ដងទៀត) -->
                                    @foreach($brands as $br)
                                        <label class="flex items-center justify-between p-2 rounded-xl hover:bg-slate-50 cursor-pointer text-[14px]">
                                            <div class="flex items-center gap-2">
                                                <input type="radio" name="brand_id" value="{{ $br->id }}"
                                                       {{ request('brand_id') == $br->id ? 'checked' : '' }}
                                                       data-was-checked="{{ request('brand_id') == $br->id ? 'true' : 'false' }}"
                                                       onclick="toggleBrandRadio(this)"
                                                       class="w-4 h-4 text-blue-600 border-slate-300 focus:ring-blue-500 cursor-pointer">
                                                <span class="font-medium {{ request('brand_id') == $br->id ? 'text-blue-700 font-bold' : 'text-slate-700' }}">
                                                    {{ $br->name }}
                                                </span>
                                            </div>
                                            @if($br->products_count > 0)
                                                <span class="text-[12px] text-slate-400">({{ $br->products_count }})</span>
                                            @endif
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Filter 3: Price Range -->
                        <div class="pt-4 border-t border-slate-100">
                            <label class="block text-xs font-bold text-amber-600 uppercase tracking-wider mb-3">
                                ចន្លោះតម្លៃ ($)
                            </label>
                            <div class="grid grid-cols-2 gap-2">
                                <div>
                                    <input type="number" name="min_price" value="{{ request('min_price') }}" placeholder="Min $"
                                           class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none focus:ring-2 focus:ring-blue-500">
                                </div>
                                <div>
                                    <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="Max $"
                                           class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none focus:ring-2 focus:ring-blue-500">
                                </div>
                            </div>
                        </div>

                        <!-- Filter 4: Stock Toggle -->
                        <div class="pt-4 border-t border-slate-100">
                            <label class="flex items-center gap-2 cursor-pointer text-xs font-semibold text-slate-700">
                                <input type="checkbox" name="in_stock" value="1" {{ request('in_stock') ? 'checked' : '' }}
                                       onchange="this.form.submit()"
                                       class="w-4 h-4 text-blue-600 border-slate-300 rounded focus:ring-blue-500">
                                <span>បង្ហាញតែទំនិញមានក្នុងស្តុក (In Stock Only)</span>
                            </label>
                        </div>

                        <button type="submit" class="w-full py-2.5 bg-gradient-to-br bg-blue-800 hover:bg-blue-900 text-white rounded-xl text-xs font-bold transition flex items-center justify-center gap-1.5 shadow-sm">
                            <i class="fa-solid fa-filter"></i> អនុវត្តតម្រង (Apply)
                        </button>
                    </form>
                </div>

                <!-- Support Banner -->
                <div class="bg-gradient-to-br from-blue-600 to-indigo-700 text-white p-6 rounded-3xl shadow-md space-y-3">
                    <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center text-lg">
                        <i class="fa-solid fa-headset text-amber-300"></i>
                    </div>
                    <h4 class="font-bold text-sm">ត្រូវការជំនួយក្នុងការជ្រើសរើស?</h4>
                    <p class="text-xs text-blue-100 leading-relaxed">
                        ក្រុមការងារបច្ចេកទេសរបស់យើងត្រៀមខ្លួនជួយលោកអ្នកក្នុងការជ្រើសរើសកុំព្យូទ័រដែលស័ក្តិសមបំផុត។
                    </p>
                    <a href="https://t.me/SENGHONG_SH" target="_blank"
                       class="inline-block px-4 py-2 bg-white text-blue-700 text-xs font-bold rounded-xl hover:bg-blue-50 transition shadow-sm">
                        <i class="fa-brands fa-telegram animate-bounce"></i> ជជែកតាម Telegram
                    </a>
                </div>

            </aside>

            <!-- B. MAIN PRODUCT CATALOG -->
            <div class="flex-1 space-y-6">

                <!-- Top Sort & Controls Bar -->
                <div class="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-sm space-y-3">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                        <div>
                            <p class="text-xs text-slate-500">
                                បានរកឃើញ <span class="font-bold text-slate-900">{{ $products->total() }}</span> ផលិតផល
                                @if(request('search')) សម្រាប់ពាក្យ "<span class="text-blue-600 font-bold">{{ request('search') }}</span>" @endif
                            </p>
                        </div>

                        <!-- Sorting Dropdown -->
                        <div class="flex items-center gap-2 text-xs w-full sm:w-auto justify-end">
                            <span class="text-slate-400 shrink-0">តម្រៀបតាម៖</span>
                            <form method="GET" action="{{ route('shop.index') }}" class="flex items-center">
                                @foreach(request()->except('sort') as $k => $v)
                                    <input type="hidden" name="{{ $k }}" value="{{ $v }}">
                                @endforeach
                                <select name="sort" onchange="this.form.submit()"
                                        class="px-3 py-1.5 bg-green-700 border border-slate-200 rounded-xl text-xs font-semibold text-white outline-none focus:ring-2 focus:ring-blue-500 shadow-sm cursor-pointer">
                                    <option value="latest" {{ $sort === 'latest' ? 'selected' : '' }}>ថ្មីបំផុត (Latest)</option>
                                    <option value="price_asc" {{ $sort === 'price_asc' ? 'selected' : '' }}>តម្លៃទាប ទៅ ខ្ពស់</option>
                                    <option value="price_desc" {{ $sort === 'price_desc' ? 'selected' : '' }}>តម្លៃខ្ពស់ ទៅ ទាប</option>
                                    <option value="name_asc" {{ $sort === 'name_asc' ? 'selected' : '' }}>ឈ្មោះ (A - Z)</option>
                                </select>
                            </form>
                        </div>
                    </div>

                    <!-- Active Filter Chips (ចុចដកតម្រងនីមួយៗ ឬលុបទាំងអស់) -->
                    @if(request()->anyFilled(['category_id', 'brand_id', 'min_price', 'max_price', 'in_stock']))
                        <div class="flex flex-wrap items-center gap-2 pt-2 border-t border-slate-100">
                            <span class="text-xs text-slate-400 font-medium">តម្រងសកម្ម៖</span>
                            @if(request('category_id') && $categories->firstWhere('id', request('category_id')))
                                <a href="{{ route('shop.index', request()->except(['category_id', 'page'])) }}"
                                   class="inline-flex items-center gap-1.5 px-3 py-1 bg-blue-50 text-blue-700 border border-blue-200 rounded-full text-xs font-semibold hover:bg-rose-50 hover:text-rose-600 hover:border-rose-200 transition"
                                   title="ចុចដើម្បីដកប្រភេទនេះ">
                                    <span>ប្រភេទ៖ {{ $categories->firstWhere('id', request('category_id'))->name }}</span>
                                    <i class="fa-solid fa-xmark text-[10px]"></i>
                                </a>
                            @endif

                            @if(request('brand_id') && $brands->firstWhere('id', request('brand_id')))
                                <a href="{{ route('shop.index', request()->except(['brand_id', 'page'])) }}"
                                   class="inline-flex items-center gap-1.5 px-3 py-1 bg-amber-50 text-amber-800 border border-amber-200 rounded-full text-xs font-semibold hover:bg-rose-50 hover:text-rose-600 hover:border-rose-200 transition"
                                   title="ចុចដើម្បីដកម៉ាកនេះ">
                                    <span>ម៉ាក៖ {{ $brands->firstWhere('id', request('brand_id'))->name }}</span>
                                    <i class="fa-solid fa-xmark text-[10px]"></i>
                                </a>
                            @endif

                            @if(request('min_price') || request('max_price'))
                                <a href="{{ route('shop.index', request()->except(['min_price', 'max_price', 'page'])) }}"
                                   class="inline-flex items-center gap-1.5 px-3 py-1 bg-slate-100 text-slate-700 border border-slate-200 rounded-full text-xs font-semibold hover:bg-rose-50 hover:text-rose-600 hover:border-rose-200 transition"
                                   title="ចុចដើម្បីដកចន្លោះតម្លៃ">
                                    <span>តម្លៃ៖ ${{ request('min_price', 0) }} - ${{ request('max_price', 'Max') }}</span>
                                    <i class="fa-solid fa-xmark text-[10px]"></i>
                                </a>
                            @endif

                            @if(request('in_stock'))
                                <a href="{{ route('shop.index', request()->except(['in_stock', 'page'])) }}"
                                   class="inline-flex items-center gap-1.5 px-3 py-1 bg-emerald-50 text-emerald-700 border border-emerald-200 rounded-full text-xs font-semibold hover:bg-rose-50 hover:text-rose-600 hover:border-rose-200 transition">
                                    <span>មានក្នុងស្តុក</span>
                                    <i class="fa-solid fa-xmark text-[10px]"></i>
                                </a>
                            @endif

                            <a href="{{ route('shop.index') }}"
                               class="text-xs font-bold text-rose-600 hover:text-rose-700 hover:underline ml-1">
                                បង្ហាញកុំព្យូទ័រទាំងអស់ឡើងវិញ
                            </a>
                        </div>
                    @endif
                </div>

                <!-- Products Grid -->
                @if($products->count() > 0)
                    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6">
                        @foreach($products as $product)
                            <div class="bg-white rounded-3xl border border-slate-200/80 hover:border-blue-400 overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col group">
                                
                                <!-- Product Image & Badges -->
                                <div class="relative h-60 bg-slate-50 overflow-hidden flex items-center justify-center p-6 border-b border-slate-100 group-hover:bg-slate-100/50 transition">
                                    @if($product->image)
                                        <img src="{{ asset($product->image) }}" alt="{{ $product->name }}"
                                             class="max-h-full max-w-full object-contain group-hover:scale-105 transition-transform duration-300">
                                    @else
                                        <div class="flex flex-col items-center justify-center text-slate-300 gap-2">
                                            <i class="fa-solid fa-laptop text-4xl"></i>
                                            <span class="text-xs">គ្មានរូបភាព</span>
                                        </div>
                                    @endif

                                    <!-- Top Badges -->
                                    <div class="absolute top-3 left-3 flex flex-col gap-1 items-start">
                                        @if($product->brand)
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-lg text-[10px] font-bold bg-slate-900/90 text-white backdrop-blur-sm shadow-sm">
                                                {{ $product->brand->name }}
                                            </span>
                                        @endif
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-lg text-[10px] font-medium bg-blue-50 text-blue-700 border border-blue-100">
                                            {{ $product->category->name ?? 'កុំព្យូទ័រ' }}
                                        </span>
                                    </div>

                                    <!-- Stock Status Badge -->
                                    <div class="absolute top-3 right-3">
                                        @if($product->stock > 5)
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">
                                                មានស្តុក
                                            </span>
                                        @elseif($product->stock > 0)
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-100 text-amber-800">
                                                នៅសល់ {{ $product->stock }} គ្រឿង
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-rose-100 text-rose-800">
                                                អស់ស្តុក
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <!-- Product Info Body -->
                                <div class="p-5 flex-1 flex flex-col justify-between space-y-4">
                                    <div class="space-y-2">
                                        <!-- Rating -->
                                        @php $rating = $product->reviews->avg('rating') ?? 5; @endphp
                                        <div class="flex items-center gap-1 text-amber-400 text-xs">
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="fa-solid fa-star text-[10px] {{ $i <= round($rating) ? 'text-amber-400' : 'text-slate-200' }}"></i>
                                            @endfor
                                            <span class="text-slate-400 text-[10px] ml-1">({{ $product->reviews->count() }})</span>
                                        </div>

                                        <!-- Title -->
                                        <h3 class="font-bold text-sm text-slate-800 line-clamp-2 hover:text-blue-600 transition leading-snug">
                                            <a href="{{ route('shop.show', $product) }}">
                                                {{ $product->name }}
                                            </a>
                                        </h3>

                                        <!-- Specs Tags -->
                                        <div class="flex flex-wrap gap-1 text-[11px] text-slate-500 pt-1">
                                            @if($product->cpu)
                                                <span class="px-2 py-0.5 bg-slate-100 rounded text-[10px] font-mono"><i class="fa-solid fa-microchip text-[9px] text-slate-400"></i> {{ $product->cpu }}</span>
                                            @endif
                                            @if($product->ram)
                                                <span class="px-2 py-0.5 bg-slate-100 rounded text-[10px] font-mono"><i class="fa-solid fa-memory text-[9px] text-slate-400"></i> {{ $product->ram }}</span>
                                            @endif
                                            @if($product->storage)
                                                <span class="px-2 py-0.5 bg-slate-100 rounded text-[10px] font-mono"><i class="fa-solid fa-hard-drive text-[9px] text-slate-400"></i> {{ $product->storage }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Price & Add To Cart Button -->
                                    <div class="pt-4 border-t border-slate-100 flex items-center justify-between gap-3">
                                        <div>
                                            <p class="text-[10px] text-slate-400">តម្លៃពិសេស</p>
                                            <p class="text-xl font-extrabold text-red-600">
                                                ${{ number_format($product->price, 2) }}
                                            </p>
                                        </div>

                                        <div class="flex items-center gap-2">
                                            <a href="{{ route('shop.show', $product) }}"
                                               class="w-9 h-9 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 flex items-center justify-center text-xs transition"
                                               title="មើលលម្អិត">
                                                <i class="fa-solid fa-eye"></i>
                                            </a>

                                            @if($product->stock > 0)
                                                <button type="button"
                                                        @click="addToCart({{ $product->id }}, 1)"
                                                        class="px-3.5 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-bold transition flex items-center gap-1.5 shadow-sm hover:shadow active:scale-95 cursor-pointer">
                                                    <i class="fa-solid fa-cart-plus"></i>
                                                    <span class="hidden sm:inline">ដាក់កន្ត្រក</span>
                                                </button>
                                            @else
                                                <button disabled class="px-3 py-2 bg-slate-100 text-slate-400 rounded-xl text-xs font-bold cursor-not-allowed">
                                                    អស់ពីស្តុក
                                                </button>
                                            @endif
                                        </div>
                                    </div>

                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="pt-6">
                        {{ $products->links() }}
                    </div>
                @else
                    <!-- Empty State -->
                    <div class="bg-white rounded-3xl border border-slate-200 p-12 text-center space-y-4 shadow-sm">
                        <div class="w-16 h-16 rounded-2xl bg-blue-50 text-blue-500 mx-auto flex items-center justify-center text-2xl">
                            <i class="fa-solid fa-box-open"></i>
                        </div>
                        <h4 class="text-lg font-bold text-slate-800">មិនមានទំនិញដែលត្រូវនឹងការស្វែងរកទេ</h4>
                        <p class="text-xs text-slate-400 max-w-md mx-auto">
                            សូមសាកល្បងផ្លាស់ប្តូរពាក្យគន្លឹះស្វែងរក ឬដកតម្រងប្រភេទ និងម៉ាកយីហោចេញដើម្បីមើលទំនិញផ្សេងទៀត។
                        </p>
                        <a href="{{ route('shop.index') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-blue-600 text-white rounded-xl text-xs font-bold hover:bg-blue-700 transition">
                            <i class="fa-solid fa-rotate-left"></i> មើលទំនិញទាំងអស់ឡើងវិញ
                        </a>
                    </div>
                @endif

            </div>
        </div>
    </div>

    <script>
        function toggleBrandRadio(radio) {
            if (radio.dataset.wasChecked === 'true') {
                // Radio was already checked: clicking it again unchecks it!
                radio.checked = false;
                radio.dataset.wasChecked = 'false';
                radio.value = '';
                radio.form.submit();
            } else {
                radio.form.submit();
            }
        }
    </script>
</x-storefront-layout>