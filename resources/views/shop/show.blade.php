<x-storefront-layout :title="$product->name">

    <!-- Breadcrumbs -->
    <div class="bg-white border-b border-slate-200 py-3">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <nav class="flex items-center gap-2 text-xs text-slate-500 font-medium">
                <a href="{{ route('shop.index') }}" class="hover:text-blue-600 transition flex items-center gap-1">
                    <i class="fa-solid fa-house text-[10px]"></i> ទំព័រដើម
                </a>
                <i class="fa-solid fa-angle-right text-[10px] text-slate-300"></i>
                <a href="{{ route('shop.index', ['category_id' => $product->category_id]) }}" class="hover:text-blue-600 transition">
                    {{ $product->category->name ?? 'កុំព្យូទ័រ' }}
                </a>
                @if($product->brand)
                    <i class="fa-solid fa-angle-right text-[10px] text-slate-300"></i>
                    <a href="{{ route('shop.index', ['brand_id' => $product->brand_id]) }}" class="hover:text-blue-600 transition">
                        {{ $product->brand->name }}
                    </a>
                @endif
                <i class="fa-solid fa-angle-right text-[10px] text-slate-300"></i>
                <span class="text-slate-800 font-bold truncate max-w-xs">{{ $product->name }}</span>
            </nav>
        </div>
    </div>

    <!-- Product Details Main Area -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10" x-data="{ quantity: 1, maxStock: {{ $product->stock }} }">
        <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden p-6 sm:p-10 grid grid-cols-1 lg:grid-cols-12 gap-10">

            <!-- 1. Left Gallery (Col 5) -->
            <div class="lg:col-span-5 space-y-4">
                <div class="h-80 sm:h-96 rounded-2xl bg-slate-50 border border-slate-100 flex items-center justify-center p-6 overflow-hidden relative group">
                    @if($product->image)
                        <img src="{{ asset($product->image) }}" alt="{{ $product->name }}"
                             class="max-h-full max-w-full object-contain group-hover:scale-110 transition duration-300">
                    @else
                        <div class="text-center text-slate-300">
                            <i class="fa-solid fa-laptop text-6xl mb-2"></i>
                            <p class="text-xs">គ្មានរូបភាព</p>
                        </div>
                    @endif

                    @if($product->stock > 0)
                        <span class="absolute top-4 left-4 px-3 py-1 bg-emerald-500 text-white rounded-xl text-xs font-bold shadow-sm">
                            <i class="fa-solid fa-check"></i> មានក្នុងស្តុក
                        </span>
                    @else
                        <span class="absolute top-4 left-4 px-3 py-1 bg-rose-500 text-white rounded-xl text-xs font-bold shadow-sm">
                            អស់ពីស្តុក
                        </span>
                    @endif
                </div>

                <!-- Guarantee Badges -->
                <div class="grid grid-cols-3 gap-3 text-center pt-2">
                    <div class="p-3 bg-slate-50 rounded-2xl border border-slate-100">
                        <i class="fa-solid fa-shield-halved text-blue-600 text-base mb-1"></i>
                        <p class="text-[11px] font-bold text-slate-800">ធានាផ្លូវការ</p>
                        <p class="text-[10px] text-slate-400">១ ឆ្នាំពេញ</p>
                    </div>
                    <div class="p-3 bg-slate-50 rounded-2xl border border-slate-100">
                        <i class="fa-solid fa-truck-fast text-emerald-600 text-base mb-1"></i>
                        <p class="text-[11px] font-bold text-slate-800">ដឹកជញ្ជូនរហ័ស</p>
                        <p class="text-[10px] text-slate-400">២៥ ខេត្ត-ក្រុង</p>
                    </div>
                    <div class="p-3 bg-slate-50 rounded-2xl border border-slate-100">
                        <i class="fa-solid fa-rotate-left text-amber-500 text-base mb-1"></i>
                        <p class="text-[11px] font-bold text-slate-800">ប្តូរទំនិញថ្មី</p>
                        <p class="text-[10px] text-slate-400">ក្នុងរយៈពេល ៧ថ្ងៃ</p>
                    </div>
                </div>
            </div>

            <!-- 2. Right Product Info & Actions (Col 7) -->
            <div class="lg:col-span-7 flex flex-col justify-between space-y-6">
                <div class="space-y-4">
                    <!-- Brand & Category Strip -->
                    <div class="flex items-center gap-3">
                        @if($product->brand)
                            <a href="{{ route('shop.index', ['brand_id' => $product->brand_id]) }}"
                               class="inline-flex items-center gap-1.5 px-3 py-1 rounded-xl bg-slate-900 text-white text-xs font-bold shadow-sm hover:bg-slate-800 transition">
                                <i class="fa-solid fa-award text-amber-400 text-[10px]"></i>
                                <span>{{ $product->brand->name }}</span>
                            </a>
                        @endif
                        <span class="inline-flex items-center px-3 py-1 rounded-xl bg-blue-50 text-blue-700 text-xs font-semibold border border-blue-100">
                            {{ $product->category->name ?? 'កុំព្យូទ័រ' }}
                        </span>
                        <span class="text-xs text-slate-400">
                            កូដសម្គាល់៖ <strong class="text-slate-700 font-mono">HC-{{ str_pad($product->id, 4, '0', STR_PAD_LEFT) }}</strong>
                        </span>
                    </div>

                    <!-- Title -->
                    <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 leading-tight">
                        {{ $product->name }}
                    </h1>

                    <!-- Rating Summary -->
                    @php $avgRating = $product->reviews->avg('rating') ?? 5; @endphp
                    <div class="flex items-center gap-2 text-xs">
                        <div class="flex items-center gap-1 text-amber-400">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fa-solid fa-star text-xs {{ $i <= round($avgRating) ? 'text-amber-400' : 'text-slate-200' }}"></i>
                            @endfor
                        </div>
                        <span class="font-bold text-slate-700">{{ number_format($avgRating, 1) }}</span>
                        <span class="text-slate-400">|</span>
                        <a href="#reviews" class="text-blue-600 hover:underline font-medium">
                            {{ $product->reviews->count() }} ការវាយតម្លៃ (Reviews)
                        </a>
                    </div>

                    <!-- Price Section -->
                    <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100 flex items-center justify-between">
                        <div>
                            <span class="text-xs text-slate-400 font-medium">តម្លៃលក់ជូនពិសេស</span>
                            <div class="flex items-baseline gap-2">
                                <span class="text-3xl font-extrabold text-red-600">
                                    ${{ number_format($product->price, 2) }}
                                </span>
                                <span class="text-xs text-slate-400">/ គ្រឿង</span>
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="text-xs text-slate-500 font-medium">ចំនួនស្តុកនៅសល់</span>
                            <p class="text-sm font-bold {{ $product->stock > 0 ? 'text-emerald-600' : 'text-rose-600' }}">
                                {{ $product->stock > 0 ? $product->stock . ' គ្រឿង' : 'អស់ពីស្តុក' }}
                            </p>
                        </div>
                    </div>

                    <!-- Quick Technical Highlights -->
                    <div class="space-y-2 text-xs text-slate-600 pt-2">
                        <p class="font-bold text-slate-800 uppercase tracking-wider text-[11px]">លក្ខណៈបច្ចេកទេសសង្ខេប៖</p>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-2">
                            <div class="p-2.5 bg-slate-50 rounded-xl border border-slate-100">
                                <p class="text-[10px] text-slate-400">អង្គប្រតិបត្តិការ (CPU)</p>
                                <p class="font-bold text-slate-800 font-mono text-xs truncate">{{ $product->cpu ?? 'មិនបានបញ្ជាក់' }}</p>
                            </div>
                            <div class="p-2.5 bg-slate-50 rounded-xl border border-slate-100">
                                <p class="text-[10px] text-slate-400">អង្គចងចាំ (RAM)</p>
                                <p class="font-bold text-slate-800 font-mono text-xs truncate">{{ $product->ram ?? 'មិនបានបញ្ជាក់' }}</p>
                            </div>
                            <div class="p-2.5 bg-slate-50 rounded-xl border border-slate-100">
                                <p class="text-[10px] text-slate-400">ទំហំផ្ទុក (Storage)</p>
                                <p class="font-bold text-slate-800 font-mono text-xs truncate">{{ $product->storage ?? 'មិនបានបញ្ជាក់' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quantity Modifier & Action Buttons -->
                <div class="space-y-5 pt-4 border-t border-slate-100">
                    @if($product->stock > 0)
                        <div class="flex items-center gap-4">
                            <span class="text-xs font-bold text-slate-700">ចំនួនទិញ៖</span>
                            <div class="flex items-center border border-slate-200 rounded-xl overflow-hidden bg-white shadow-sm">
                                <button type="button" @click="if (quantity > 1) quantity--"
                                        class="w-9 h-9 flex items-center justify-center bg-slate-50 hover:bg-slate-100 text-slate-600 transition">
                                    <i class="fa-solid fa-minus text-xs"></i>
                                </button>
                                <input type="number" x-model.number="quantity" readonly
                                       class="w-14 text-center border-none p-0 focus:ring-0 text-sm font-bold text-slate-900 bg-white">
                                <button type="button" @click="if (quantity < maxStock) quantity++"
                                        class="w-9 h-9 flex items-center justify-center bg-slate-50 hover:bg-slate-100 text-slate-600 transition">
                                    <i class="fa-solid fa-plus text-xs"></i>
                                </button>
                            </div>
                            <span class="text-xs text-slate-400">
                                សរុប៖ <strong class="text-slate-900 font-bold" x-text="'$' + (quantity * {{ $product->price }}).toFixed(2)">${{ number_format($product->price, 2) }}</strong>
                            </span>
                        </div>

                        <!-- Add to Cart & Buy Now Buttons -->
                        <div class="flex flex-col sm:flex-row gap-3">
                            <!-- Add to Cart (AJAX) -->
                            <button type="button"
                                    @click="addToCart({{ $product->id }}, quantity)"
                                    class="flex-1 py-3.5 px-6 bg-blue-50 hover:bg-blue-100 text-blue-700 rounded-2xl font-bold text-sm transition flex items-center justify-center gap-2 border border-blue-200 active:scale-95 cursor-pointer">
                                <i class="fa-solid fa-cart-plus text-base"></i>
                                <span>បន្ថែមចូលកន្ត្រក (Add to Cart)</span>
                            </button>

                            <!-- Buy Now (Direct Checkout) -->
                            <form method="POST" action="{{ route('cart.add') }}" class="flex-1">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <input type="hidden" name="quantity" :value="quantity">
                                <button type="submit"
                                        class="w-full py-3.5 px-6 bg-blue-600 hover:bg-blue-700 text-white rounded-2xl font-bold text-sm transition shadow-lg shadow-blue-500/30 flex items-center justify-center gap-2 active:scale-95 cursor-pointer">
                                    <i class="fa-solid fa-bolt text-amber-300"></i>
                                    <span>ទិញឥឡូវនេះ (Buy Now)</span>
                                </button>
                            </form>
                        </div>
                    @else
                        <div class="p-4 bg-rose-50 border border-rose-100 rounded-2xl text-center space-y-2">
                            <p class="text-sm font-bold text-rose-700">ទំនិញនេះបានអស់ពីស្តុកបណ្តោះអាសន្ន!</p>
                            <p class="text-xs text-rose-500">លោកអ្នកអាចទាក់ទងមកកាន់យើងខ្ញុំដើម្បីកក់ទុកមុនតាមរយៈ Telegram។</p>
                            <a href="https://t.me/{{ ltrim(\App\Models\Setting::get('telegram_number', '093757079'), '0') }}" target="_blank"
                               class="inline-flex items-center gap-2 px-4 py-2 bg-sky-500 text-white rounded-xl text-xs font-bold shadow-sm">
                                <i class="fa-brands fa-telegram"></i> ទាក់ទងកក់ទំនិញ
                            </a>
                        </div>
                    @endif
                </div>

            </div>
        </div>

        <!-- 3. Description & Specs Section -->
        <div class="mt-10 bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden p-6 sm:p-10 space-y-8">
            <div>
                <h3 class="text-lg font-bold text-slate-900 border-b border-slate-100 pb-3 flex items-center gap-2">
                    <i class="fa-solid fa-circle-info text-blue-600"></i>
                    <span>ការពិពណ៌នាលម្អិតពីទំនិញ</span>
                </h3>
                <div class="mt-4 text-sm text-slate-700 leading-relaxed space-y-4">
                    @if($product->description)
                        <p class="whitespace-pre-line">{{ $product->description }}</p>
                    @else
                        <p class="text-slate-400 italic">មិនមានការពិពណ៌នាបន្ថែមសម្រាប់ម៉ូឌែលនេះទេ។</p>
                    @endif
                </div>
            </div>

            <!-- Full Specifications Table -->
            <div>
                <h3 class="text-lg font-bold text-slate-900 border-b border-slate-100 pb-3 flex items-center gap-2">
                    <i class="fa-solid fa-list-check text-blue-600"></i>
                    <span>លក្ខណៈបច្ចេកទេសពេញលេញ (Specifications)</span>
                </h3>
                <div class="mt-4 overflow-x-auto">
                    <table class="w-full text-left text-xs text-slate-700 border-collapse">
                        <tbody class="divide-y divide-slate-100">
                            <tr class="hover:bg-slate-50">
                                <td class="py-3 px-4 font-bold text-slate-500 w-1/3 bg-slate-50/50">ម៉ូឌែលកុំព្យូទ័រ</td>
                                <td class="py-3 px-4 font-semibold text-slate-800">{{ $product->name }}</td>
                            </tr>
                            <tr class="hover:bg-slate-50">
                                <td class="py-3 px-4 font-bold text-slate-500 bg-slate-50/50">ម៉ាកយីហោ (Brand)</td>
                                <td class="py-3 px-4">{{ $product->brand->name ?? 'មិនបានបញ្ជាក់' }}</td>
                            </tr>
                            <tr class="hover:bg-slate-50">
                                <td class="py-3 px-4 font-bold text-slate-500 bg-slate-50/50">ប្រភេទ (Category)</td>
                                <td class="py-3 px-4">{{ $product->category->name ?? 'មិនបានបញ្ជាក់' }}</td>
                            </tr>
                            <tr class="hover:bg-slate-50">
                                <td class="py-3 px-4 font-bold text-slate-500 bg-slate-50/50">អង្គប្រតិបត្តិការ (CPU)</td>
                                <td class="py-3 px-4 font-mono">{{ $product->cpu ?? 'N/A' }}</td>
                            </tr>
                            <tr class="hover:bg-slate-50">
                                <td class="py-3 px-4 font-bold text-slate-500 bg-slate-50/50">អង្គចងចាំ (RAM)</td>
                                <td class="py-3 px-4 font-mono">{{ $product->ram ?? 'N/A' }}</td>
                            </tr>
                            <tr class="hover:bg-slate-50">
                                <td class="py-3 px-4 font-bold text-slate-500 bg-slate-50/50">ទំហំផ្ទុកទិន្នន័យ (Storage)</td>
                                <td class="py-3 px-4 font-mono">{{ $product->storage ?? 'N/A' }}</td>
                            </tr>
                            <tr class="hover:bg-slate-50">
                                <td class="py-3 px-4 font-bold text-slate-500 bg-slate-50/50">ការធានា (Warranty)</td>
                                <td class="py-3 px-4 text-emerald-700 font-semibold">១ ឆ្នាំពេញ ពីក្រុមហ៊ុនផ្លូវការ</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- 4. Customer Reviews Section -->
        <div id="reviews" class="mt-10 bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden p-6 sm:p-10 space-y-8">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 border-b border-slate-100 pb-4">
                <div>
                    <h3 class="text-lg font-bold text-slate-900 flex items-center gap-2">
                        <i class="fa-solid fa-comments text-blue-600"></i>
                        <span>ការវាយតម្លៃរបស់អតិថិជន ({{ $product->reviews->count() }})</span>
                    </h3>
                    <p class="text-xs text-slate-400">មតិយោបល់ពិតប្រាកដពីអតិថិជនដែលបានប្រើប្រាស់ផលិតផលនេះ</p>
                </div>

                <div class="flex items-center gap-3">
                    <span class="text-3xl font-extrabold text-slate-900">{{ number_format($avgRating, 1) }}</span>
                    <div>
                        <div class="flex items-center gap-0.5 text-amber-400 text-xs">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fa-solid fa-star {{ $i <= round($avgRating) ? 'text-amber-400' : 'text-slate-200' }}"></i>
                            @endfor
                        </div>
                        <p class="text-[10px] text-slate-400">ពិន្ទុសរុបជាមធ្យម</p>
                    </div>
                </div>
            </div>

            <!-- Form to Submit Review -->
            <div class="p-6 bg-slate-50 rounded-2xl border border-slate-100">
                <h4 class="font-bold text-sm text-slate-900 mb-3 flex items-center gap-2">
                    <i class="fa-solid fa-pen text-blue-600 text-xs"></i>
                    <span>សរសេរការវាយតម្លៃរបស់អ្នក</span>
                </h4>

                <form action="{{ route('reviews.store', $product) }}" method="POST" class="space-y-4" x-data="{ ratingVal: 5 }">
                    @csrf
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">ឈ្មោះរបស់អ្នក *</label>
                            <input type="text" name="name" required value="{{ auth()->user()?->name ?? old('name') }}"
                                   placeholder="ឧ. សុខ ដារ៉ា"
                                   class="w-full px-3.5 py-2 bg-white border border-slate-200 rounded-xl text-xs outline-none focus:ring-2 focus:ring-blue-500">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">ផ្តល់ពិន្ទុផ្កាយ *</label>
                            <div class="flex items-center gap-2 pt-1">
                                <input type="hidden" name="rating" :value="ratingVal">
                                <template x-for="star in [1, 2, 3, 4, 5]" :key="star">
                                    <button type="button" @click="ratingVal = star"
                                            class="text-lg transition"
                                            :class="star <= ratingVal ? 'text-amber-400 scale-110' : 'text-slate-300'">
                                        <i class="fa-solid fa-star"></i>
                                    </button>
                                </template>
                                <span class="text-xs text-slate-500 font-bold ml-2" x-text="ratingVal + ' / 5 ផ្កាយ'"></span>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">មតិយោបល់ ឬចំណាប់អារម្មណ៍</label>
                        <textarea name="comment" rows="3" placeholder="ចែករំលែកបទពិសោធន៍ប្រើប្រាស់របស់អ្នកចំពោះកុំព្យូទ័រនេះ..."
                                  class="w-full px-3.5 py-2 bg-white border border-slate-200 rounded-xl text-xs outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                    </div>

                    <button type="submit"
                            class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-bold transition shadow-sm flex items-center gap-2">
                        <i class="fa-solid fa-paper-plane"></i> ផ្ញើការវាយតម្លៃ
                    </button>
                </form>
            </div>

            <!-- Existing Reviews List -->
            @if($product->reviews->count() > 0)
                <div class="space-y-4 divide-y divide-slate-100">
                    @foreach($product->reviews as $rev)
                        <div class="pt-4 space-y-1.5">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-700 font-bold text-xs flex items-center justify-center">
                                        {{ substr($rev->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="text-xs font-bold text-slate-900">{{ $rev->name }}</p>
                                        <div class="flex items-center gap-0.5 text-amber-400 text-[10px]">
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="fa-solid fa-star {{ $i <= $rev->rating ? 'text-amber-400' : 'text-slate-200' }}"></i>
                                            @endfor
                                        </div>
                                    </div>
                                </div>
                                <span class="text-[10px] text-slate-400">{{ $rev->created_at->diffForHumans() }}</span>
                            </div>
                            @if($rev->comment)
                                <p class="text-xs text-slate-600 pl-10">{{ $rev->comment }}</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- 5. Related Products Grid -->
        @if($relatedProducts->count() > 0)
            <div class="mt-12 space-y-6">
                <div class="flex justify-between items-center">
                    <h3 class="text-xl font-bold text-slate-900 flex items-center gap-2">
                        <i class="fa-solid fa-layer-group text-blue-600"></i>
                        <span>ផលិតផលស្រដៀងគ្នា (Related Products)</span>
                    </h3>
                    <a href="{{ route('shop.index', ['category_id' => $product->category_id]) }}" class="text-xs font-bold text-blue-600 hover:underline">
                        មើលបន្ថែម <i class="fa-solid fa-arrow-right text-[10px]"></i>
                    </a>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($relatedProducts as $rel)
                        <div class="bg-white rounded-3xl border border-slate-200/80 hover:border-blue-400 overflow-hidden shadow-sm hover:shadow-lg transition flex flex-col justify-between group">
                            <div class="h-48 bg-slate-50 p-4 flex items-center justify-center overflow-hidden">
                                @if($rel->image)
                                    <img src="{{ asset($rel->image) }}" alt="{{ $rel->name }}" class="max-h-full max-w-full object-contain group-hover:scale-105 transition">
                                @else
                                    <i class="fa-solid fa-laptop text-3xl text-slate-300"></i>
                                @endif
                            </div>
                            <div class="p-4 space-y-2">
                                <span class="text-[10px] font-bold text-blue-600 bg-blue-50 px-2 py-0.5 rounded">{{ $rel->brand->name ?? 'Computer' }}</span>
                                <h4 class="text-xs font-bold text-slate-800 truncate">
                                    <a href="{{ route('shop.show', $rel) }}" class="hover:text-blue-600 transition">{{ $rel->name }}</a>
                                </h4>
                                <p class="text-base font-extrabold text-red-600">${{ number_format($rel->price, 2) }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

    </div>

</x-storefront-layout>