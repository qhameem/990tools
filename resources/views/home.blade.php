<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Approved Products</title>

    @vite('resources/css/app.css')
</head>

<body class="antialiased">
    <div class="container mx-auto p-6">
        <h1 class="text-2xl text-left font-semibold text-blue-900 mb-8">Top Products</h1>
        <div class="">
            @forelse ($products as $product)
            <div class="bg-whiterounded-lg p-6 flex items-start">

                <!-- Favicon -->
                <img src="https://www.google.com/s2/favicons?sz=32&domain={{ parse_url($product->url, PHP_URL_HOST) }}"
                    alt="Favicon" class="w-5 h-5 mr-3 mt-1">

                <!-- Product Details -->
                <div class="flex-1 flex items-top">
                    <!-- Product Name and Description -->
                    <div>
                        <h2 class="text-base font-semibold text-black">
                            <a href="{{ $product->url }}{{ strpos($product->url, '?') === false ? '?' : '&' }}ref=productslist"
                                target="_blank" class="hover:underline hover:text-blue-700">
                                {{ $product->name }}

                            </a>
                        </h2>
                        <p class="text-sm text-gray-800 mt-1">{{ $product->description }}</p>
                        <!-- Categories -->
                        <div class="mt-2">

                            @foreach ($product->category as $category)
                            <span
                                class="text-xs text-blue-700 bg-gray-100 px-2 py-1 rounded-full mr-2">{{ $category->name }}</span>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="text-center bg-white shadow-md rounded-lg p-6">
                <p class="text-gray-600">No approved products found.</p>
            </div>
            @endforelse
        </div>
    </div>
</body>

</html>