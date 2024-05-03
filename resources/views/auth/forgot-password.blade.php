@extends('layouts.auth')

@section('title', 'Забыли пароль')

@section('content')
    <x-forms.auth-forms title="Забыли пароль" action="{{ route('password.email') }}" method="POST">
        @csrf

        <x-forms.text-input
            name="email"
            type="email"
            placeholder="E-mail"
            required
            :isError="$errors->has('email')"
        />
        @error('email')
            <x-forms.error :message="$message" />
        @enderror

        <x-forms.primary-button>Отправить</x-forms.primary-button>
    </x-forms.auth-forms>
@endsection
