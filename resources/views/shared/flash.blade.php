@if ($flash = flash()->get())
    <div class="{{ $flash->class() }} p-5">
        {{ $flash->message() }}
    </div>
@endif
