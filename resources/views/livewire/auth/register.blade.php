<div class="flex flex-col gap-6">
    <x-auth-header :title="__('Crear cuenta')" :description="__('Llena el formulario para poder crear uan cuenta')" />

    <!-- Session Status -->
    <x-auth-session-status class="text-center" :status="session('status')" />

    <form method="POST" wire:submit="register" class="flex flex-col gap-6">
        <!-- Name -->
        <flux:input
            wire:model="name"
            :label="__('Nombre completo')"
            type="text"
            required
            autofocus
            autocomplete="name"
            :placeholder="__('Nombre ')"
        />

        <!-- Email Address -->
        <flux:input
            wire:model="email"
            :label="__('Email address')"
            type="email"
            required
            autocomplete="email"
            placeholder="email@example.com"
        />
        <!-- Rol -->
        <flux:select wire:model="rol" 
            placeholder="Que tipo de usuario eres..."
            :label="__('Selecciona tu rol')"
            required>
            <flux:select.option>Cordinador</flux:select.option>
            <flux:select.option>Profesor</flux:select.option>
            <flux:select.option>Alumno</flux:select.option>
        </flux:select>

        <!-- Password -->
        <flux:input
            wire:model="password"
            :label="__('Constraseña')"
            type="password"
            required
            autocomplete="new-password"
            :placeholder="__('Contraseña')"
            viewable
        />
        
        <!-- Confirm Password -->
        <flux:input
            wire:model="password_confirmation"
            :label="__('Confirmar Contraseña')"
            type="password"
            required
            autocomplete="new-password"
            :placeholder="__('Confirmar Contraseña')"
            viewable
        />

        <div class="flex items-center justify-end">
            <flux:button type="submit" variant="primary" class="w-full">
                {{ __('Crear Cuenta') }}
            </flux:button>
        </div>
    </form>

    <div class="space-x-1 rtl:space-x-reverse text-center text-sm text-zinc-600 dark:text-zinc-400">
        <span>{{ __('Ya tienes cuenta?') }}</span>
        <flux:link :href="route('login')" wire:navigate>{{ __('iniciar sesion') }}</flux:link>
    </div>
</div>
