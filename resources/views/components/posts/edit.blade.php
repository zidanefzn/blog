<div class="relative p-4 bg-white rounded-lg border dark:bg-gray-800 sm:p-5">
    <div class="flex justify-between items-center pb-4 mb-4 rounded-t border-b sm:mb-5 dark:border-gray-600">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Edit Post</h3>
    </div>

    <form action="/dashboard/{{ $post->slug }}" method="POST">
        @csrf
        @method('PATCH')
        <div class="grid gap-4 mb-4 sm:grid-cols-2">
            <div>
                <label for="tittle" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Title</label>
                <input type="text" name="tittle" id="tittle" class="@error('tittle')
                    focus:ring-danger
                @enderror bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Title" autofocus value="{{ old('tittle') ?? $post->tittle }}">
                @error('tittle')
                    <p class="mt-2.5 text-sm text-fg-danger-strong">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="category" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Category</label>
                <select name="category_id" id="category" class="@error('category_id')
                    focus:ring-danger
                @enderror bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                    <option selected="" value="">Select category</option>
                    @foreach (App\Models\Category::get() as $category)
                        <option value="{{ $category->id }}" @selected((old('category_id') ?? $post->category->id) == $category->id)>{{ $category->name }}</option>
                    @endforeach
                </select>
                @error('category_id')
                    <p class="mt-2.5 text-sm text-fg-danger-strong">{{ $message }}</p>
                @enderror
            </div>
            <div class="sm:col-span-2">
                <label for="body" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Body</label>
                <textarea id="body" name="body" rows="4" class="@error('category_id')
                    focus:ring-danger
                @enderror block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Write post body here">{{ old('body') ?? $post->body }}</textarea>
                @error('body')
                    <p class="mt-2.5 text-sm text-fg-danger-strong">{{ $message }}</p>
                @enderror
            </div>
        </div>
        <button type="submit" class="text-white inline-flex items-center bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800 cursor-pointer">
            Edit Post
        </button>
    </form>
</div>