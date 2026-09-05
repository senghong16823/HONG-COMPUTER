<!DOCTYPE html>
<html lang="km">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>HONG Computer</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
</head>

<body class="bg-gray-100 font-sans antialiased">

    <!-- Navbar ខាងលើ -->
    <nav class=sticky top-0 z-50 bg-white/90 backdrop-blur-md shadow-sm border-b border-gray-200 mb-8 transition-all duration-300>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex justify-between items-center">
            <a href="{{ route('shop.index') }}" class="text-xl font-bold text-blue-600"><i class="fa-solid fa-laptop text-amber-400 text-[30px] me-4"></i> HONG COMPUTER</a>
        <div>
            @auth
                <a href="{{ route('admin.dashboard') }}"
                    class="text-sm bg-blue-600 text-white px-4 py-2 rounded shadow hover:bg-blue-700 ">
                    ទៅកាន់ Admin Dashboard
                </a>
            @else
                <a href="{{ route('login') }}"
                    class="inline-block text-sm bg-blue-800 text-white px-4 py-2 rounded transition duration-200 ease-in-out hover:-translate-y-0.5 hover:scale-105 hover:bg-blue-700">
                    ចូលគណនី (Login)
                </a>

                <a href="{{ route('register') }}"
                    class="inline-block ml-3 text-sm bg-red-600 text-white px-4 py-2 rounded transition duration-200 ease-in-out hover:-translate-y-0.5 hover:scale-105 hover:bg-red-500">
                    ចុះឈ្មោះ
                </a>
            @endauth
        </div>
        </div>
    </nav>


    
    <div id="indicators-carousel" class="relative w-full" data-carousel="static">
        <!-- Carousel wrapper -->
        <div class="relative h-56 overflow-hidden rounded-base md:h-[70vh]">
            <!-- Item 1 -->
            <div class="hidden duration-700 ease-in-out" data-carousel-item="active">
                <img src="https://www.asus.com/campaign/powered-by-asus/upload/scenario/20231123114432_pic0.jpg"
                    class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="...">
            </div>
            <!-- Item 2 -->
            <div class="hidden duration-700 ease-in-out" data-carousel-item>
                <img src="https://press.asus.com/assets/w_5472,h_3648/30a70a9d-d394-417a-a503-aad2248010d9/1.%20ROG%20Event%20Product%20Lineup.jpg"
                    class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="...">
            </div>
            <!-- Item 3 -->
            <div class="hidden duration-700 ease-in-out" data-carousel-item>
                <img src="/docs/images/carousel/carousel-3.svg"
                    class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="...">
            </div>
            <!-- Item 4 -->
            <div class="hidden duration-700 ease-in-out" data-carousel-item>
                <img src="/docs/images/carousel/carousel-4.svg"
                    class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="...">
            </div>
            <!-- Item 5 -->
            <div class="hidden duration-700 ease-in-out" data-carousel-item>
                <img src="/docs/images/carousel/carousel-5.svg"
                    class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="...">
            </div>
        </div>
        <!-- Slider indicators -->
        <div class="absolute z-30 flex -translate-x-1/2 space-x-3 rtl:space-x-reverse bottom-5 left-1/2">
            <button type="button" class="w-3 h-3 rounded-base" aria-current="true" aria-label="Slide 1"
                data-carousel-slide-to="0"></button>
            <button type="button" class="w-3 h-3 rounded-base" aria-current="false" aria-label="Slide 2"
                data-carousel-slide-to="1"></button>
            <button type="button" class="w-3 h-3 rounded-base" aria-current="false" aria-label="Slide 3"
                data-carousel-slide-to="2"></button>
            <button type="button" class="w-3 h-3 rounded-base" aria-current="false" aria-label="Slide 4"
                data-carousel-slide-to="3"></button>
            <button type="button" class="w-3 h-3 rounded-base" aria-current="false" aria-label="Slide 5"
                data-carousel-slide-to="4"></button>
        </div>
        <!-- Slider controls -->
        <button type="button"
            class="absolute top-0 start-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none"
            data-carousel-prev>
            <span
                class="inline-flex items-center justify-center w-10 h-10 rounded-base bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                <svg class="w-5 h-5 text-white rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m15 19-7-7 7-7" />
                </svg>
                <span class="sr-only">Previous</span>
            </span>
        </button>
        <button type="button"
            class="absolute top-0 end-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none"
            data-carousel-next>
            <span
                class="inline-flex items-center justify-center w-10 h-10 rounded-base bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                <svg class="w-5 h-5 text-white rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m9 5 7 7-7 7" />
                </svg>
                <span class="sr-only">Next</span>
            </span>
        </button>
    </div>


    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 flex flex-col md:flex-row gap-8">

        <!-- Sidebar Filter តាម Category -->
    <div class="w-full md:w-1/4">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 relative z-30 font-['Kantumruy_Pro']">
           
            <!-- Header-->
            <div class="bg-gray-900 text-white flex items-center justify-between px-4 py-3.5">
                <div class="flex items-center gap-2.5">
                    <span class="flex items-center justify-center size-10 rounded-full bg-amber-500 text-gray-950 text-sm">
                        <i class="fa-solid fa-layer-group text-[20px]" style="color: rgb(255, 255, 255 );"></i>
                    </span>
                    <h3 class="font-bold text-sm tracking-wide uppercase">Categories</h3>
                </div>
                
            </div>
    
          
            <!-- Category Sidebar Navigation -->
            <div class="p-2 space-y-1.5 bg-slate-50/70 rounded-2xl border border-slate-200/60 shadow-xs relative">
            
                <!-- ១. ទំនិញទាំងអស់ (All Products) -->
                @php $isAllActive = !request('category_id'); @endphp
                <a href="{{ route('shop.index') }}"
                    class="group flex items-center justify-between px-3.5 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 {{ $isAllActive ? 'bg-blue-600 text-white shadow-md shadow-blue-500/20' : 'text-slate-600 hover:bg-white hover:text-blue-600 hover:shadow-sm' }}">
                    <div class="flex items-center gap-3">
                        <div
                            class="w-7 h-7 rounded-lg flex items-center justify-center transition-colors {{ $isAllActive ? 'bg-white/20 text-white' : 'bg-slate-200/60 text-slate-500 group-hover:bg-blue-50 group-hover:text-blue-600' }}">
                            <i class="fa-solid fa-border-all text-xs"></i>
                        </div>
                        <span>ទំនិញទាំងអស់</span>
                    </div>
                    <i
                        class="fa-solid fa-chevron-right text-[10px] transition-transform duration-200 group-hover:translate-x-0.5 {{ $isAllActive ? 'text-white' : 'text-slate-400 opacity-0 group-hover:opacity-100' }}"></i>
                </a>
            
                <div class="my-1 border-t border-slate-200/60"></div>
            
                <!-- ២. រង្វិលជុំ Category + Hover Flyout Brands Menu -->
                @foreach($categories as $category)
                    @php $isActive = request('category_id') == $category->id; @endphp

                    <!-- Parent Item (ត្រូវបន្ថែម relative និង group/item) -->
                    <div class="relative group/item">
                        <a href="{{ route('shop.index', ['category_id' => $category->id]) }}"
                            class="group flex items-center justify-between px-3.5 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 {{ $isActive ? 'bg-blue-600 text-white shadow-md shadow-blue-500/20' : 'text-slate-600 hover:bg-white hover:text-blue-600 hover:shadow-sm' }}">

                            <div class="flex items-center gap-3">
                                <div
                                    class="w-7 h-7 rounded-lg flex items-center justify-center transition-colors {{ $isActive ? 'bg-white/20 text-white' : 'bg-slate-100 text-slate-500 group-hover/item:bg-blue-50 group-hover/item:text-blue-600' }}">
                                    <i class="{{ $category->icon ?? 'fa-solid fa-laptop' }} text-xs"></i>
                                </div>
                                <span>{{ $category->name }}</span>
                            </div>

                            <div class="flex items-center gap-2">
                                @if(isset($category->products_count))
                                    <span
                                        class="text-[11px] font-semibold px-2 py-0.5 rounded-full transition-colors {{ $isActive ? 'bg-white/20 text-white' : 'bg-slate-200/70 text-slate-600 group-hover/item:bg-blue-100 group-hover/item:text-blue-700' }}">
                                        {{ $category->products_count }}
                                    </span>
                                @endif
                                <i
                                    class="fa-solid fa-chevron-right text-[10px] transition-transform duration-200 group-hover/item:translate-x-0.5 {{ $isActive ? 'text-white' : 'text-slate-400 opacity-0 group-hover/item:opacity-100' }}"></i>
                            </div>
                        </a>

                        <!-- 3. Desktop Hover Submenu (Brand Flyout Card) -->
                        <div
                            class="hidden lg:block invisible opacity-0 translate-x-2 group-hover/item:visible group-hover/item:opacity-100 group-hover/item:translate-x-0 transition-all duration-200 ease-out absolute left-full top-0 ml-2 w-56 bg-white border border-slate-200/80 rounded-2xl shadow-xl p-2 z-50">
                            <div
                                class="px-3 py-1.5 text-[11px] font-bold uppercase tracking-wider text-slate-400 border-b border-slate-100 mb-1 flex items-center gap-1.5">
                                <i class="fa-solid fa-tags text-[10px]"></i>
                                <span>ម៉ាកយីហោ (Brands)</span>
                            </div>

                            <div class="space-y-0.5">
                                {{-- ឧទាហរណ៍៖ ទាញ Brands ចេញពី Relationship $category->brands --}}
                                @forelse($category->brands ?? [] as $brand)
                                    <a href="{{ route('shop.index', ['category_id' => $category->id, 'brand_id' => $brand->id]) }}"
                                        class="flex items-center justify-between px-3 py-2 rounded-lg text-xs font-medium text-slate-600 hover:bg-slate-50 hover:text-blue-600 transition-colors">
                                        <span>{{ $brand->name }}</span>
                                        <i class="fa-solid fa-angle-right text-[10px] text-slate-300"></i>
                                    </a>
                                @empty
                                    {{-- ករណីគ្មាន Brand ក្នុង DB (Static Sample) --}}
                                    <a href="#"
                                        class="flex items-center justify-between px-3 py-2 rounded-lg text-xs font-medium text-slate-600 hover:bg-slate-50 hover:text-blue-600 transition-colors">
                                        <span>ASUS</span>
                                        <i class="fa-solid fa-angle-right text-[10px] text-slate-300"></i>
                                    </a>
                                    <a href="#"
                                        class="flex items-center justify-between px-3 py-2 rounded-lg text-xs font-medium text-slate-600 hover:bg-slate-50 hover:text-blue-600 transition-colors">
                                        <span>Dell</span>
                                        <i class="fa-solid fa-angle-right text-[10px] text-slate-300"></i>
                                    </a>
                                    <a href="#"
                                        class="flex items-center justify-between px-3 py-2 rounded-lg text-xs font-medium text-slate-600 hover:bg-slate-50 hover:text-blue-600 transition-colors">
                                        <span>MSI</span>
                                        <i class="fa-solid fa-angle-right text-[10px] text-slate-300"></i>
                                    </a>
                                    <a href="#"
                                        class="flex items-center justify-between px-3 py-2 rounded-lg text-xs font-medium text-slate-600 hover:bg-slate-50 hover:text-blue-600 transition-colors">
                                        <span>Apple (MacBook)</span>
                                        <i class="fa-solid fa-angle-right text-[10px] text-slate-300"></i>
                                    </a>
                                @endforelse
                            </div>
                        </div>

                    </div>
                @endforeach
            </div>
        </div>
    </div>

        <!-- Product Grid List -->
        <div class="w-full md:w-3/4">
            <form action="{{ route('shop.index') }}" method="GET" class="mb-6 flex gap-2">
                <!-- រក្សាទុក Category ចាស់ប្រសិនបើមានការជ្រើសរើស -->
                @if(request('category_id'))
                    <input type="hidden" name="category_id" value="{{ request('category_id') }}">
                @endif
            
                <input type="text" name="search" value="{{ request('search') }}" placeholder="ស្វែងរកម៉ូដែលកុំព្យូទ័រ..."
                    class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 p-2.5">
            
                <button type="submit"
                    class="bg-blue-600 text-white px-6 py-2.5 rounded-lg shadow hover:bg-blue-700 transition flex items-center gap-2 font-bold">
                    <i class="fa-solid fa-magnifying-glass"></i> ស្វែងរក
                </button>
            </form>
            @if($products->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($products as $product)
                        <div
                            class=" bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition">
                           
                        <!-- រូបភាពទំនិញ  -->
                        <div class="h-56 bg-white overflow-hidden flex items-center justify-center p-3 border-b border-gray-100">
                            @if($product->image)
                                <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="max-h-full max-w-full object-contain">
                            @else
                                <div class="flex items-center justify-center h-full text-gray-400">គ្មានរូបភាព</div>
                            @endif
                        </div>

                            <!-- ព័ត៌មានលម្អិត -->
                            <div class="p-4">
                                <span
                                    class="text-xs bg-blue-100 text-blue-800 px-2 py-1 rounded font-semibold">{{ $product->category->name ?? 'ផ្សេងៗ' }}</span>
                                <h3 class="font-bold text-lg text-gray-800 mt-2 truncate">{{ $product->name }}</h3>

                                <div class="text-sm text-gray-600 mt-1 space-y-1">
                                    @if($product->cpu)
                                    <div>CPU: {{ $product->cpu }}</div> @endif
                                    @if($product->ram)
                                    <div>RAM: {{ $product->ram }}</div> @endif
                                    @if($product->storage)
                                    <div>Storage: {{ $product->storage }}</div> @endif
                                </div>

                                <div class="mt-4 flex justify-between items-center">
                                    <span class="text-xl font-bold text-red-600">${{ number_format($product->price, 2) }}</span>
                                    <a href="{{ route('shop.show', $product->id) }}"
                                        class="bg-gray-900 text-white px-3 py-1.5 rounded text-sm hover:bg-blue-600 transition">
                                        លម្អិត
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-white p-8 text-center rounded-lg shadow-sm text-gray-500">
                    មិនមានទំនិញដាក់បង្ហាញនៅឡើយទេក្នុងប្រភេទនេះ។
                </div>
            @endif
        </div>

    </div>


    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const container = document.getElementById('slider-container');
            const prevBtn = document.getElementById('prev-btn');
            const nextBtn = document.getElementById('next-btn');

            let currentIndex = 0;
            const totalSlides = container.children.length;
            let slideInterval;

            function updateSlider(index) {
                container.style.transform = `translateX(-${index * 100}%)`;
            }

            function nextSlide() {
                currentIndex = (currentIndex + 1) % totalSlides;
                updateSlider(currentIndex);
            }

            function prevSlide() {
                currentIndex = (currentIndex - 1 + totalSlides) % totalSlides;
                updateSlider(currentIndex);
            }

            nextBtn.addEventListener('click', () => {
                nextSlide();
                resetAutoPlay();
            });

            prevBtn.addEventListener('click', () => {
                prevSlide();
                resetAutoPlay();
            });

            function startAutoPlay() {
                slideInterval = setInterval(nextSlide, 5000); // លោតរៀងរាល់ ៥វិនាទី
            }

            function resetAutoPlay() {
                clearInterval(slideInterval);
                startAutoPlay();
            }

            startAutoPlay();
        });


    
    window.addEventListener('scroll', () => {
        const header = document.querySelector('header');
        if (window.scrollY > 20) {
                    header.classList.add('py-1', 'shadow-md');
        } else {
                    header.classList.remove('py-1', 'shadow-md');
        }
    });
        
    </script>
@include('layouts.footer')
</body>

</html>