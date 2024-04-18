<div class="flex w-full justify-evenly ">
    <div>
        <div class="font-bold mb-4 mt-6">Add Category</div>
        <form wire:submit='submitCategory' class="flex flex-col">
            @if (session()->has('success_category'))
            <span class="mb-2 bg-green-300 text-sm rounded-md p-2">{{session('success_category')}}</span>
            @endif
            <div class="flex flex-col w-72 mb-4">
                <label for="category_name">Category Name:</label>
                <input wire:model='category_name' class="bg-gray-200 rounded-md p-2" type="text" name='category_name'>
                @error('category_name')
                <span class="italic text-red-400 text-sm">Fill in the Category</span>
                @enderror
            </div>
            <div class="flex flex-col w-72 gap-1 mb-4">
                <label for="">Add Sizes: (Optional)</label>
                <input wire:model='small_size' class="bg-gray-200 rounded-md p-2" placeholder="small size (inches)" type="number" name='category_name'>
               
                <input wire:model='medium_size' class="bg-gray-200 rounded-md p-2" placeholder="medium size (inches)" type="number" name='category_name'>
               
                <input wire:model='large_size' class="bg-gray-200 rounded-md p-2" placeholder="large size (inches)" type="number" name='category_name'>

            </div>
            <button type="submit" class="w-fit hover:bg-gray-400 hover:text-black bg-gray-200 rounded-md p-2">Add
                Category</button>
        </form>
    </div>

    <hr>

    <div>
        <div class="font-bold mb-4 mt-6">Add Product</div>
        <form wire:submit='submitProduct' class="flex flex-col gap-3">
            @if (session()->has('success_product'))
            <span class="mb-2 bg-green-300 text-sm rounded-md p-2">{{session('success_product')}}</span>
            @endif
            <div class="flex flex-col">
                <label for="product_name">Product Name:</label>
                <input wire:model='product_name' class="bg-gray-200 rounded-md p-2" type="text" name='product_name'>
                @error('product_name')
                <span class="italic text-red-400 text-sm">Please input Product name</span>
                @enderror
            </div>


            <div class="flex flex-col">
                <label for="product_category">Category:</label>
                <select wire:model='product_category' class="bg-gray-200 rounded-md p-2" name="product_category">
                    @php
                    $category = DB::table('categories')->where('status', 'available')->get();

                    @endphp
                    <option value="">Select Category</option>
                    @if ((DB::table('categories')->where('status', 'available'))->count() != 0)
                    @foreach ($category as $categ )
                    <option value="{{ $categ->id }}">{{ $categ->category_name }}</option>
                    @endforeach

                    @endif
                </select>
                @error('product_category')
                <span class="italic text-red-400 text-sm">Choose Product category</span>
                @enderror
            </div>

            <div class="flex flex-col">
                <label for="product_pic">Product Picture:</label>
                <input wire:model='product_pic' class="bg-gray-200 rounded-md p-2 mb-3" type="file" name='product_pic'>
                @error('product_pic')
                <span class="italic text-red-400 text-sm">Product image is reuquired</span>
                @enderror
                @if ($product_pic)
                <img class=" rounded-md w-44 h-44" src="{{ $product_pic->temporaryUrl() }}" />
                @endif
            </div>

            <div class="flex flex-col">

                <label for="prod_description">Description:</label>
                <textarea wire:model='prod_description' class="bg-gray-200 rounded-md p-1 h-32" type="text"
                    name='prod_description'></textarea>
                @error('prod_description')
                <span class="italic text-red-400 text-sm">Description is required</span>
                @enderror

            </div>

            <div class="flex flex-col">
                <label for="product_price">Price:</label>
                <input wire:model='product_price' class="bg-gray-200 rounded-md p-2" type="text" name='product_price'>
                @error('product_price')
                <span class="italic text-red-400 text-sm">Please input the Price</span>
                @enderror

            </div>

            <button type="submit" class="bg-gray-200  hover:bg-gray-400 hover:text-black w-fit rounded-md p-2">Add
                Product</button>
        </form>
    </div>
</div>