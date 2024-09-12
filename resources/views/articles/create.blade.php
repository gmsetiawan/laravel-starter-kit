<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <form action="{{ route('articles.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="title"
                            class="block text-gray-700 dark:text-gray-100 text-sm font-bold mb-2">Title</label>
                        <input type="text" name="title" id="title" value="{{ old('title') }}"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-900 leading-tight focus:outline-none focus:shadow-outline">
                        @error('title')
                            <small class="alert alert-danger text-red-600 dark:text-red-400">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="excerpt"
                            class="block text-gray-700 dark:text-gray-100 text-sm font-bold mb-2">Excerpt</label>
                        <textarea name="excerpt" id="excerpt" rows="3"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-900 leading-tight focus:outline-none focus:shadow-outline">{!! nl2br(old('excerpt')) !!}</textarea>
                        @error('excerpt')
                            <small class="alert alert-danger text-red-600 dark:text-red-400">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="message"
                            class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Search</label>
                        <div class="relative">
                            <input type="text" id="message" name="message"
                                class="block w-full p-4 ps-4 text-sm text-gray-900 border border-gray-300 rounded bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="What your idea..." />
                            <button id="btn-generate"
                                class="text-white absolute end-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Generate</button>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="content"
                            class="block text-gray-700 dark:text-gray-100 text-sm font-bold mb-2">Content</label>
                        <textarea name="content" id="content" rows="10"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-900 leading-tight focus:outline-none focus:shadow-outline">{!! old('content') !!}</textarea>
                        @error('content')
                            <small class="alert alert-danger text-red-600 dark:text-red-400">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="category_id"
                            class="block text-gray-700 dark:text-gray-100 text-sm font-bold mb-2">Category</label>
                        <select name="category_id" id="category_id"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-900 leading-tight focus:outline-none focus:shadow-outline">
                            <option value="">Select a category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="status"
                            class="block text-gray-700 dark:text-gray-100 text-sm font-bold mb-2">Status</label>
                        <select name="status" id="status"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-900 leading-tight focus:outline-none focus:shadow-outline">
                            <option value="draft">Draft</option>
                            <option value="published">Published</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="meta_description"
                            class="block text-gray-700 dark:text-gray-100 text-sm font-bold mb-2">Meta
                            Description</label>
                        <textarea name="meta_description" id="meta_description" rows="2"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-900 leading-tight focus:outline-none focus:shadow-outline">{!! nl2br(old('meta_description')) !!}</textarea>
                        @error('meta_description')
                            <small class="alert alert-danger text-red-600 dark:text-red-400">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="meta_keywords"
                            class="block text-gray-700 dark:text-gray-100 text-sm font-bold mb-2">Meta
                            Keywords</label>
                        <input type="text" name="meta_keywords" id="meta_keywords" value="{{ old('meta_keywords') }}"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-900 leading-tight focus:outline-none focus:shadow-outline">
                        @error('meta_keywords')
                            <small class="alert alert-danger text-red-600 dark:text-red-400">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="flex items-center justify-between">
                        <button type="submit"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            Create Article
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script type="module">
        $(document).ready(function() {
            $('#btn-generate').click(function(e) {
                e.preventDefault();
                var message = $('#message').val();
                var $button = $(this);
                var $content = $('#content');
                var oldContent = $content.val();

                if (message) {
                    $button.prop('disabled', true).text('Progress...');
                    if (!oldContent) {
                        $content.val('Generating content, please wait...').prop('disabled', true);
                    }

                    $.ajax({
                        url: "{{ route('chat.chat') }}",
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            message: message
                        },
                        beforeSend: function() {
                            $('#btn-generate').prop('disabled', true).text('Progress...');
                        },
                        success: function(response) {
                            console.log(response)
                            $('#content').val(response);
                            oldContent = response.message;
                        },
                        error: function(xhr, status, error) {
                            console.error(error);
                            if (!oldContent) {
                                $content.val('An error occurred while generating content.');
                            }
                        },
                        complete: function() {
                            $('#btn-generate').prop('disabled', false).text('Generate');
                            $content.prop('disabled', false);
                        }
                    })
                }
            })
        });
    </script>
</x-app-layout>
