@props(['label' => '', 'error' => '', 'class' => ''])

<div class="mb-5 {{ $class }}">
    @if ($label)
        <label class="block text-sm font-medium text-gray-700 mb-1">
            {{ $label }}
        </label>
    @endif
    <input
        {{ $attributes->merge(['class' => 'w-full px-3 py-2 border ' . ($error ? 'border-red-500' : 'border-gray-300') . ' rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500']) }} />
    @if ($error)
        <p class="mt-1 text-sm text-red-500">{{ $error }}</p>
    @endif
</div>
