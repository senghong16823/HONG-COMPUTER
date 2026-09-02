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
    <nav class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex justify-between items-center">
            <a href="{{ route('shop.index') }}" class="text-xl font-bold text-blue-600"><i class="fa-solid fa-laptop-code"></i>HONG Computer Shop</a>
            <div>
                @auth
                    <a href="{{ route('admin.dashboard') }}"
                        class="text-sm bg-blue-600 text-white px-4 py-2 rounded shadow hover:bg-blue-700">ទៅកាន់ Admin
                        Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="text-sm text-gray-700 hover:text-blue-600 mr-4">ចូលគណនី
                        (Login)</a>
                    <a href="{{ route('register') }}"
                        class="text-sm bg-gray-800 text-white px-4 py-2 rounded shadow hover:bg-gray-900">ចុះឈ្មោះ</a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Header Banner -->
    {{-- <div class="bg-blue-600 text-white py-12 text-center">
        <h1 class="text-3xl font-bold mb-2">ស្វាគមន៍មកកាន់ហាងលក់កុំព្យូទ័រទំនើប</h1>
        <p class="text-blue-100">ជម្រើសដ៏សម្បូរបែប គុណភាពខ្ពស់ និងតម្លៃសមរម្យសម្រាប់លោកអ្នក</p>
    </div> --}}
    
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
            <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-200">
                <h3 class="font-bold text-gray-800 mb-3 pb-2 border-b">ប្រភេទទំនិញ</h3>
                <ul class="space-y-2">
                    <li>
                        <a href="{{ route('shop.index') }}"
                            class="block px-3 py-2 rounded {{ request('category_id') ? 'text-gray-700 hover:bg-gray-100' : 'bg-blue-600 text-white font-bold' }}">
                            ទំនិញទាំងអស់
                        </a>
                    </li>
                    @foreach($categories as $category)
                        <li>
                            <a href="{{ route('shop.index', ['category_id' => $category->id]) }}"
                                class="block px-3 py-2 rounded {{ request('category_id') == $category->id ? 'bg-blue-600 text-white font-bold' : 'text-gray-700 hover:bg-gray-100' }}">
                                {{ $category->name }}
                            </a>
                        </li>
                    @endforeach
                </ul>
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
                            <!-- រូបភាពទំនិញ -->
                        <!-- រូបភាពទំនិញ (កូដថ្មីដែលបានកែសម្រួល) -->
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
    </script>

</body>

</html>