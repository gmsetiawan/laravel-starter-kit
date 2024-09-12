<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <a href="{{ route('articles.create') }}">Create</a>
                <div class="mt-4 flex flex-col gap-2">
                    @forelse ($articles as $article)
                        <a href="{{ route('articles.show', $article) }}"
                            class="p-2 border border-gray-400 dark:border-gray-600 rounded hover:bg-gray-400 dark:hover:bg-gray-600">
                            <h1>{{ $article->title }}</h1>
                            <p>{{ $article->excerpt }}</p>
                        </a>
                    @empty
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
