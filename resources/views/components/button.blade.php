<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex border border-transparent rounded-md font-semibold text-xs tracking-widest transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
