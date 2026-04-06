@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'w-full border border-gray-300 focus:border-orange-500 focus:ring-orange-500 rounded-xl shadow-sm px-4 py-2.5 text-gray-900 placeholder-gray-400 transition']) }}>
