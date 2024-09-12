<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h1 class="text-gray-900 dark:text-gray-100 font-semibold capitalize text-xl">{{ $article->title }}</h1>
            <h1 class="text-gray-900 dark:text-gray-100 mb-4">{{ $article->excerpt }}</h1>
            <p class="text-gray-900 dark:text-gray-100 text-justify">{!! nl2br($article->content) !!}</p>
            <pre>
            </pre>
        </div>
    </div>
</x-app-layout>
