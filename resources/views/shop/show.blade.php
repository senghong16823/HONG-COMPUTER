<!DOCTYPE html>
<html lang="km">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $product->name }} - ព័ត៌មានលម្អិត</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- បញ្ចូល FontAwesome សម្រាប់ Icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-gray-50 font-sans antialiased">

    <!-- Navbar -->

<nav id="main-nav"
    class="sticky top-0 z-50 bg-white/90 backdrop-blur-md shadow-sm border-b border-gray-200 mb-8 transition-all duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex justify-between items-center">
        <a href="{{ route('shop.index') }}" class="text-xl font-bold text-blue-600 flex items-center gap-2">
            <i class="fa-solid fa-laptop text-amber-400 text-[30px] me-4"></i> HONG COMPUTER
        </a>
        <a href="{{ route('shop.index') }}" class="inline-block ml-3 text-sm bg-red-600 text-white px-4 py-2 rounded transition duration-200 ease-in-out hover:-translate-y-0.5 hover:scale-105 hover:bg-red-500">
            <i class="fa-solid fa-arrow-left"></i> ត្រឡប់ក្រោយ
        </a>
    </div>
</nav>

    <div class="max-w-7xl mx-auto px-4 pb-12">
        <div class="bg-white p-6 md:p-10 grid grid-cols-1 md:grid-cols-2 gap-10">

            <!--  (Image Gallery) -->
            <div>
                <!-- រូបភាពធំ -->
                <div class="border border-gray-200 rounded p-4 flex justify-center items-center h-[400px] mb-4">
                    @if($product->image)
                        <img src="{{ asset($product->image) }}" alt="{{ $product->name }}"
                            class="max-h-full max-w-full object-contain">
                    @else
                        <span class="text-gray-400">គ្មានរូបភាព</span>
                    @endif
                </div>
                <!-- (Thumbnails Placeholder) -->
                <div class="flex gap-2 overflow-x-auto">
                    @if($product->image)
                        <div class="border-2 border-orange-500 w-20 h-20 p-1 cursor-pointer">
                            <img src="{{ asset($product->image) }}" class="h-full w-full object-contain">
                        </div>
                    @endif
                    <!-- ប្រអប់តំណាងរូបភាពផ្សេងទៀត (បើមានថ្ងៃក្រោយ) -->
                    <div
                        class="border border-gray-200 w-20 h-20 flex justify-center items-center text-xs text-gray-400 cursor-pointer hover:border-gray-400">
                        រូបទី២</div>
                    <div
                        class="border border-gray-200 w-20 h-20 flex justify-center items-center text-xs text-gray-400 cursor-pointer hover:border-gray-400">
                        រូបទី៣</div>
                </div>
            </div>

            <!-- (Product Info) -->
            <div>
                <!-- ផ្កាយ Review (Placeholder) -->
                
                <div class="text-gray-400 text-sm mb-2 flex items-center gap-1">
                    @php
$avgRating = $product->reviews->avg('rating') ?? 0;
                    @endphp
                
                    <div class="text-yellow-400">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= round($avgRating))
                                <i class="fa-solid fa-star"></i>
                            @else
                                <i class="fa-solid fa-star text-gray-300"></i>
                            @endif
                        @endfor
                    </div>
                    <span class="ml-2 text-blue-600 hover:underline cursor-pointer font-semibold">
                        ({{ $product->reviews->count() }} reviews)
                    </span>
                </div>

                <!-- ឈ្មោះកុំព្យូទ័រ -->
                <h1 class="text-2xl font-bold text-gray-900 mb-4 leading-tight">{{ $product->name }}</h1>

                <!-- SKU & Brand -->
                <div class="flex items-center gap-4 text-sm mb-6 pb-4 border-b border-gray-200">
                    <div><span class="text-gray-500">HC:</span> <strong
                            class="text-gray-800">COM-00{{ $product->id }}</strong></div>
                    <span
                        class="bg-red-50 text-red-600 px-3 py-1 rounded text-xs font-semibold cursor-pointer hover:bg-red-100">Message
                        Seller</span>
                    <span class="text-green-600 font-bold italic">{{ $product->category->name ?? 'BRAND' }}</span>
                </div>

                <!-- លក្ខណៈបច្ចេកទេស (Specs List) -->
                <div class="text-sm text-gray-800 space-y-1.5 mb-6">
                    <div>- CPU: {{ $product->cpu ?? 'មិនបានបញ្ជាក់' }}</div>
                    <div>- RAM: {{ $product->ram ?? 'មិនបានបញ្ជាក់' }}</div>
                    <div>- Storage: {{ $product->storage ?? 'មិនបានបញ្ជាក់' }}</div>
                    <div>- OS: DOS (No operating system)</div>
                    <div>- Graphic: Intel Graphics (Onboard)</div>
                    <div>- Display: 15.6" IPS (1920 x 1080)</div>
                    <div>- Warranty: 1 Year</div>
                </div>


                <!-- តម្លៃ និង ចំនួន (បានកែសម្រួលបន្ថែម ID) -->
                <div class="space-y-4 mb-6">
                    <div class="flex items-center">
                        <span class="w-24 text-gray-500 text-sm">Price:</span>
                        <!-- បន្ថែម id="unit-price" និង data-price សម្រាប់ទុកតម្លៃដើម -->
                        <span id="unit-price" data-price="{{ $product->price }}"
                            class="text-3xl font-extrabold text-gray-900">${{ number_format($product->price, 2) }}</span>
                        <span class="text-sm text-gray-500 ml-1">/Pc</span>
                    </div>
                
                    <div class="flex items-center">
                        <span class="w-24 text-gray-500 text-sm">Quantity:</span>
                        <div class="flex border border-gray-300 rounded w-28 h-9 overflow-hidden">
                            <!-- បន្ថែម id="btn-minus" -->
                            <button id="btn-minus" type="button"
                                class="w-8 text-gray-600 bg-gray-50 hover:bg-gray-200 focus:outline-none">-</button>
                
                            <!-- បន្ថែម id="quantity-input" និងដាក់ readonly កុំឲ្យគេវាយអក្សរចូលបាន -->
                            <input id="quantity-input" type="text" value="1" readonly
                                class="w-full text-center border-none p-0 focus:ring-0 text-sm font-semibold bg-white">
                
                            
                            <button id="btn-plus" type="button"
                                class="w-8 text-gray-600 bg-gray-50 hover:bg-gray-200 focus:outline-none">+</button>
                        </div>
                    </div>
                
                    <div class="flex items-center">
                        <span class="w-24 text-gray-500 text-sm">Total Price:</span>
                        <!-- បន្ថែម id="total-price" សម្រាប់បង្ហាញលទ្ធផលតម្លៃសរុប -->
                        <span id="total-price"
                            class="text-xl font-extrabold text-gray-900">${{ number_format($product->price, 2) }}</span>
                    </div>
                </div>

                <!-- លក្ខខណ្ឌបង់រំលស់ -->
                <div class="mb-8">
                    <div class="text-green-600 font-bold text-sm mb-2">លក្ខខណ្ឌនៃការបង់រំលស់</div>
                    <div class="flex items-center gap-3 text-sm">
                        <div class="flex items-center justify-center bg-white border border-gray-200 px-1 py-0.5 rounded shadow-sm">
                            <img src="{{ asset('https://www.aeon.com.kh/wp-content/uploads/2019/12/AEONSPB-logo.png') }}" alt="AEON Logo" class="h-4 w-auto object-contain">
                        </div>
                        <span>ក្នុងមួយខែបង់ត្រឹមតែ <strong
                                class="text-red-600">${{ number_format($product->price / 12, 2) }}</strong></span>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex gap-4 mb-6">
                    <button onclick="alert('បានបន្ថែមចូលកន្ត្រក!');"
                        class="flex-1 bg-[#ffd814] hover:bg-[#f7ca00] hover:text-white text-gray-900 font-bold py-3 px-4 rounded shadow-sm transition">
                        ADD TO CART
                    </button>
                    {{-- <button onclick="alert('កំពុងបន្តទៅកាន់ការទូទាត់ប្រាក់!');"
                        class="flex-1 bg-[#ffa41c] hover:bg-[#fa8900] hover:text-white text-gray-900 font-bold py-3 px-4 rounded shadow-sm transition">
                        BUY NOW
                    </button> --}}
                    <button type="button" onclick="openRegisterModal()"
                        class="flex-1 bg-[#ffa41c] hover:bg-[#fa8900] text-gray-900 font-bold py-3 px-4 rounded shadow-sm transition duration-150 ease-in-out">
                        BUY NOW
                    </button>
                </div>

                <!-- Wishlist & Compare -->
                <div class="flex gap-4 mb-6">
                    <button
                        class="w-[150px] border border-teal-400 text-teal-600 py-2 rounded text-sm hover:bg-teal-600 hover:text-white transition flex items-center justify-center gap-2">
                        <i class="fa-solid fa-heart"></i> Add to wishlist
                    </button>
                    <button
                        class="w-[150px] border border-blue-400 text-blue-600 py-2 rounded text-sm hover:bg-blue-600 hover:text-white transition flex items-center justify-center gap-2">
                        <i class="fa-solid fa-arrow-turn-up"></i> Add to compare
                    </button>
                </div>

                <!-- Share Social Media -->
                <div class="flex items-center gap-3 text-sm">
                    <span class="text-gray-500">Share:</span>
                    <a href="#"
                        class="bg-[#3b5998] text-white w-7 h-7 flex items-center justify-center rounded hover:opacity-80"><i
                            class="fa-brands fa-facebook-f"></i></a>
                    <a href="#"
                        class="bg-[#007bb5] text-white w-7 h-7 flex items-center justify-center rounded hover:opacity-80"><i
                            class="fa-brands fa-linkedin-in"></i></a>
                    <a href="#"
                        class="bg-[#00aced] text-white w-7 h-7 flex items-center justify-center rounded hover:opacity-80"><i
                            class="fa-brands fa-telegram"></i></a>
                </div>

            </div>
        </div>
    </div>


<!-- ផ្នែកខាងក្រោម៖ Sidebar & Main Content -->
<div class="max-w-7xl mx-auto px-4 pb-12 mt-8">
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">

        <!-- ================= ខាងឆ្វេង៖ Top Selling Products ================= -->
        <div class="lg:col-span-1 bg-white p-6 rounded-lg border border-gray-100 shadow-sm h-fit">
            <h3 class="font-bold text-gray-900 mb-6 text-lg">Top Selling Products</h3>
            <div class="space-y-6">

                <!-- ផលិតផលទី១ (Placeholder) -->
                <div class="flex gap-4 items-start cursor-pointer hover:bg-gray-50 p-2 -mx-2 rounded transition">
                    <div
                        class="w-20 h-20 bg-white border border-gray-200 flex-shrink-0 flex items-center justify-center p-1 rounded">
                        <!-- បើមានរូបពិត ដាក់ <img> ទីនេះ -->
                        <i class="fa-solid fa-print text-gray-300 text-2xl"></i>
                    </div>
                    <div>
                        <h4 class="text-xs text-gray-800 font-semibold line-clamp-2 mb-1 leading-snug">Printer Epson
                            EcoTank L3210 A4 Color</h4>
                        <div class="text-yellow-400 text-[10px] mb-1"><i class="fa-solid fa-star"></i><i
                                class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i
                                class="fa-solid fa-star"></i><i class="fa-solid fa-star text-gray-300"></i></div>
                        <div class="text-xs text-gray-500 mb-1">PRE-L3210</div>
                        <div class="font-bold text-gray-900 text-sm">$125</div>
                    </div>
                </div>

                <!-- ផលិតផលទី២ -->
                <div class="flex gap-4 items-start cursor-pointer hover:bg-gray-50 p-2 -mx-2 rounded transition">
                    <div
                        class="w-20 h-20 bg-white border border-gray-200 flex-shrink-0 flex items-center justify-center p-1 rounded">
                        <i class="fa-solid fa-laptop text-gray-300 text-2xl"></i>
                    </div>
                    <div>
                        <h4 class="text-xs text-gray-800 font-semibold line-clamp-2 mb-1 leading-snug">Acer Aspire Lite
                            AL15-32P-C5CE-N4500</h4>
                        <div class="text-yellow-400 text-[10px] mb-1"><i class="fa-solid fa-star"></i><i
                                class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i
                                class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div>
                        <div class="text-xs text-gray-500 mb-1">LAL-0027</div>
                        <div class="font-bold text-gray-900 text-sm">$369</div>
                    </div>
                </div>

            </div>
        </div>


        <!-- ================= ខាងស្តាំ៖ Tabs, Description & Related Products ================= -->
        <div class="lg:col-span-3">

            <!-- Tabs Navigation -->
            <div class="flex border-b border-gray-200 mb-6 gap-8">
                <button id="btn-tab-desc"
                    class="pb-3 font-bold text-gray-900 border-b-2 border-gray-900 focus:outline-none">Description</button>
                <button id="btn-tab-reviews"
                    class="pb-3 font-bold text-gray-500 border-b-2 border-transparent hover:text-gray-900 focus:outline-none">Reviews
                    ({{ $product->reviews->count() }})</button>
            </div>


            <!-- Tab 1: Description Content -->
            <div id="content-desc" class="text-sm text-gray-800 leading-loose mb-8">
                <div class="bg-gray-50 p-6 rounded-lg border border-gray-100 shadow-inner">
                    @if($product->description)
                        <!-- ប្រើ nl2br ដើម្បីបំប្លែងការចុះបន្ទាត់ពី Database ទៅជា <br> របស់ HTML -->
                        {!! nl2br(e($product->description)) !!}
                    @else
                        <span class="text-gray-500 italic">No additional description is available for this model.</span>
                    @endif
                </div>
            </div>

            <!-- Tab 2: Reviews Content (លាក់ទុកជាស្រេច Hidden) -->
            <div id="content-reviews" class="hidden mb-8">
            <!-- ផ្នែកបង្ហាញ និងបញ្ចូលមតិយោបល់ (Reviews Section) -->
            <div class="mt-8 bg-white p-6 md:p-10 border border-gray-200">
                <h2 class="text-2xl font-bold text-gray-900 mb-6 border-b pb-4">Customer Reviews</h2>
            
                <!-- កន្លែងបង្ហាញសារជោគជ័យពេល Submit រួច -->
                @if(session('success'))
                    <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                        <p class="font-bold">Successfully!</p>
                        <p>{{ session('success') }}</p>
                    </div>
                @endif
            
                <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
            
                    <!-- ខាងឆ្វេង៖ Form សម្រាប់បញ្ចូល Review ថ្មី -->
                    <div class="bg-gray-50 p-6 rounded border border-gray-200 h-fit">
                        <h3 class="text-lg font-bold mb-4">សរសេរមតិយោបល់របស់អ្នកទីនេះ</h3>
                        <form action="{{ route('reviews.store', $product->id) }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <label class="block text-sm font-bold text-gray-700 mb-2">ឈ្មោះរបស់អ្នក <span
                                        class="text-red-500">*</span></label>
                                <input type="text" name="name" required placeholder="ឧ. សុខ សាន្ត"
                                    class="w-full border-gray-300 rounded focus:ring-blue-500 px-4 py-2">
                            </div>
                            <div class="mb-4">
                                <label class="block text-sm font-bold text-gray-700 mb-2">ពិន្ទុផ្កាយ <span
                                        class="text-red-500">*</span></label>
                                <select name="rating" required
                                    class="w-full border-gray-300 rounded focus:ring-blue-500 px-4 py-2 text-yellow-500 font-bold bg-white">
                                    <option value="5">⭐⭐⭐⭐⭐ (5 ផ្កាយ - ល្អឥតខ្ចោះ)</option>
                                    <option value="4">⭐⭐⭐⭐ (4 ផ្កាយ - ល្អណាស់)</option>
                                    <option value="3">⭐⭐⭐ (3 ផ្កាយ - ល្អបង្គួរ)</option>
                                    <option value="2">⭐⭐ (2 ផ្កាយ - ធម្មតា)</option>
                                    <option value="1">⭐ (1 ផ្កាយ - ត្រូវកែលម្អ)</option>
                                </select>
                            </div>
                            <div class="mb-6">
                                <label class="block text-sm font-bold text-gray-700 mb-2">មតិយោបល់ <span
                                        class="text-red-500">*</span></label>
                                <textarea name="comment" rows="3" required placeholder="តើលោកអ្នកយល់យ៉ាងណាដែរចំពោះកុំព្យូទ័រនេះ?"
                                    class="w-full border-gray-300 rounded focus:ring-blue-500 px-4 py-2"></textarea>
                            </div>
                            <button type="submit"
                                class="w-full bg-blue-600 text-white font-bold py-3 rounded shadow hover:bg-blue-700 transition">
                                <i class="fa-solid fa-paper-plane mr-2"></i> បញ្ជូនការវាយតម្លៃ
                            </button>
                        </form>
                    </div>
            
                    <!-- ខាងស្តាំ៖ បញ្ជី Reviews ដែលអតិថិជនបានវាយតម្លៃរួច -->
                    <div>
                        <h3 class="text-lg font-bold mb-4">ការវាយតម្លៃសរុប ({{ $product->reviews->count() }})</h3>
            
                        @if($product->reviews->count() > 0)
                            <div class="space-y-6 max-h-[500px] overflow-y-auto pr-2">
                                @foreach($product->reviews()->latest()->get() as $review)
                                    <div class="border-b border-gray-100 pb-4">
                                        <div class="flex justify-between items-center mb-2">
                                            <div class="font-bold text-gray-800 flex items-center gap-2">
                                                <div
                                                    class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center text-gray-600">
                                                    <i class="fa-solid fa-user"></i>
                                                </div>
                                                {{ $review->name }}
                                            </div>
                                            <div class="text-xs text-gray-400">{{ $review->created_at->diffForHumans() }}</div>
                                        </div>
                                        <!-- បង្ហាញផ្កាយតាមចំនួនពិន្ទុដែលគាត់បានឲ្យ -->
                                        <div class="text-yellow-400 text-sm mb-2 ml-10">
                                            @for($i = 1; $i <= 5; $i++)
                                                @if($i <= $review->rating)
                                                    <i class="fa-solid fa-star"></i>
                                                @else
                                                    <i class="fa-solid fa-star text-gray-300"></i>
                                                @endif
                                            @endfor
                                        </div>
                                        <p class="text-gray-600 text-sm ml-10">{{ $review->comment }}</p>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="bg-gray-50 border border-dashed border-gray-300 rounded p-8 text-center">
                                <div class="text-4xl text-gray-300 mb-2"><i class="fa-regular fa-comment-dots"></i></div>
                                <p class="text-gray-500 text-sm">
                                    មិនទាន់មានការវាយតម្លៃនៅឡើយទេ។<br>ក្លាយជាអ្នកដំបូងដែលវាយតម្លៃកុំព្យូទ័រនេះ!</p>
                            </div>
                        @endif
                    </div>
            
                </div>
            </div>
            </div>

            <!-- Additional Details (Accordion ទម្លាក់ចុះ) -->
            <div class="border-t border-gray-200">
                <details class="group">
                    <summary
                        class="flex justify-between items-center font-bold text-gray-900 cursor-pointer list-none py-4 outline-none hover:text-blue-600 transition">
                        Additional details
                        <span class="transition group-open:rotate-180"><i
                                class="fa-solid fa-chevron-down text-sm"></i></span>
                    </summary>
                    {{-- <div class="text-gray-600 text-sm pb-4 px-2">
                        - ទម្ងន់ (Weight): 1.63 kg (3.59 lbs)<br>
                        - ពណ៌ (Color): Black / Silver / Grey<br>
                        - Camera: HD 720p with Privacy Shutter<br>
                        - Keyboard: Backlit, English
                    </div> --}}
                </details>
            </div>
            <div class="border-t border-gray-200 mb-12"></div>

           
            <!-- Related Products Grid -->
            <div>
                <h3 class="font-bold text-gray-900 mb-6 text-lg">Related products</h3>
            
                @if($relatedProducts->count() > 0)
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">

                        
                        @foreach($relatedProducts as $related)
                            <a href="{{ route('shop.show', $related->id) }}"
                                class="bg-white p-4 rounded hover:shadow-lg transition border border-gray-100 cursor-pointer group block">

                                <!-- រូបភាពកុំព្យូទ័រ -->
                                <div class="h-32 bg-white flex items-center justify-center mb-4 overflow-hidden">
                                    @if($related->image)
                                        <img src="{{ asset($related->image) }}" alt="{{ $related->name }}"
                                            class="max-h-full max-w-full object-contain group-hover:scale-110 transition duration-300">
                                    @else
                                        <i class="fa-solid fa-laptop text-gray-300 text-5xl group-hover:scale-110 transition duration-300"></i>
                                    @endif
                                </div>

                                <!-- លេខកូដ និងឈ្មោះ -->
                                <div class="text-[11px] text-gray-500 mb-1">HC-00{{ $related->id }}</div>
                                <h4 class="text-xs font-semibold text-gray-800 line-clamp-2 mb-2 leading-snug group-hover:text-blue-600">
                                    {{ $related->name }}
                                </h4>

                                <!-- ផ្កាយ (ទុកជាគំរូសិន ព្រោះត្រូវគណនា Review ដូចខាងលើ) -->
                                <div class="flex justify-between items-center mb-1">
                                    <div class="text-yellow-400 text-[10px]">
                                        <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                                    </div>
                                </div>

                                <!-- តម្លៃ -->
                                <div class="font-bold text-gray-900 text-sm">${{ number_format($related->price, 2) }}</div>
                            </a>
                        @endforeach

                    </div>
                @else
                    <!-- ប្រសិនបើគ្មានផលិតផលពាក់ព័ន្ធទេ -->
                    <div class="text-gray-500 text-sm italic border border-dashed border-gray-300 rounded p-4 text-center">
                        មិនមានផលិតផលផ្សេងទៀតនៅក្នុងប្រភេទនេះទេ។
                    </div>
                @endif
            </div>

        </div>
    </div>
</div>


<!-- កូដ JavaScript សម្រាប់គណនាចំនួន និងតម្លៃ -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // ចាប់យក Element តាមរយៈ ID ដែលយើងបានដាក់អម្បាញ់មិញ
        const btnMinus = document.getElementById('btn-minus');
        const btnPlus = document.getElementById('btn-plus');
        const qtyInput = document.getElementById('quantity-input');
        const totalPriceEl = document.getElementById('total-price');

        // ទាញយកតម្លៃដើមរបស់កុំព្យូទ័រ (Unit Price)
        const unitPrice = parseFloat(document.getElementById('unit-price').getAttribute('data-price'));

        // អនុគមន៍សម្រាប់គណនា និងបង្ហាញតម្លៃសរុប
        function updateTotalPrice(qty) {
            const total = unitPrice * qty;
            // Format លេខឱ្យមានក្បៀស និងកន្ទុយទសភាគពីរខ្ទង់
            totalPriceEl.innerText = '$' + total.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
        }

        // ពេលចុចប៊ូតុងបូក (+)
        btnPlus.addEventListener('click', function () {
            let currentQty = parseInt(qtyInput.value);
            currentQty++; // បូកមួយ
            qtyInput.value = currentQty; // បង្ហាញលេខថ្មីក្នុងប្រអប់
            updateTotalPrice(currentQty); // គណនាតម្លៃថ្មី
        });

        // ពេលចុចប៊ូតុងដក (-)
        btnMinus.addEventListener('click', function () {
            let currentQty = parseInt(qtyInput.value);
            if (currentQty > 1) { // ការពារកុំឱ្យដកទៅដល់លេខសូន្យ ឬអវិជ្ជមាន
                currentQty--; // ដកមួយ
                qtyInput.value = currentQty;
                updateTotalPrice(currentQty);
            }
        });
    });
</script>


<script>
    document.addEventListener('DOMContentLoaded', function () {
        const btnDesc = document.getElementById('btn-tab-desc');
        const btnRev = document.getElementById('btn-tab-reviews');
        const contentDesc = document.getElementById('content-desc');
        const contentRev = document.getElementById('content-reviews');

       
        btnDesc.addEventListener('click', function () {
            // ដូរពណ៌បន្ទាត់ និងអក្សរ
            btnDesc.classList.add('border-gray-900', 'text-gray-900');
            btnDesc.classList.remove('border-transparent', 'text-gray-500');
            btnRev.classList.remove('border-gray-900', 'text-gray-900');
            btnRev.classList.add('border-transparent', 'text-gray-500');
            // បង្ហាញ ឬ លាក់អត្ថបទ
            contentDesc.classList.remove('hidden');
            contentRev.classList.add('hidden');
        });

        // ពេលចុចលើ Tab Reviews
        btnRev.addEventListener('click', function () {
            btnRev.classList.add('border-gray-900', 'text-gray-900');
            btnRev.classList.remove('border-transparent', 'text-gray-500');
            btnDesc.classList.remove('border-gray-900', 'text-gray-900');
            btnDesc.classList.add('border-transparent', 'text-gray-500');
            contentRev.classList.remove('hidden');
            contentDesc.classList.add('hidden');
        });
    });


    window.addEventListener('scroll', () => {
            const navbar = document.getElementById('main-nav');
            if (navbar) {
                if (window.scrollY > 20) {
                    navbar.classList.add('shadow-md');
                } else {
                    navbar.classList.remove('shadow-md');
                }
            }
        });
    
</script>
@include('layouts.footer')
</body>

</html>