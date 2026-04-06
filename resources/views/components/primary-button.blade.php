<button {{ $attributes->merge(['type' => 'submit', 'class' => 'w-full flex justify-center items-center px-6 py-3 bg-orange-500 border border-transparent rounded-xl font-semibold text-sm text-white tracking-wide hover:bg-orange-600 focus:bg-orange-600 active:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-sm']) }}>
    {{ $slot }}
</button>
