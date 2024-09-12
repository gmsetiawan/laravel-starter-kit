<x-guest-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Components') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form action="">
                <x-input label="Name" placeholder="Enter your name" error="{{ $errors->first('name') }}"
                    class="my-custom-class" name="name" value="{{ old('name') }}" />
            </form>
        </div>
    </div>
</x-guest-layout>
