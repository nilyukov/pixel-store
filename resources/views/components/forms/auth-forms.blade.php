<div class="max-w-[640px] mt-12 mx-auto p-6 xs:p-8 md:p-12 2xl:p-16 rounded-[20px] bg-purple">
    <h1 class="mb-5 text-lg font-semibold">{{ $title }}</h1>
    <form class="space-y-3" action="{{ $action }}" method="{{ $method }}">
        {{ $slot }}
    </form>

    {{ $socialAuth ?? null }}

    {{ $buttons ?? null }}
</div>
