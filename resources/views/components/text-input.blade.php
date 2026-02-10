@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'shadow-sm h-11 w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 placeholder:text-gray-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 outline-none']) }}>
