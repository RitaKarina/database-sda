<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class CreateStaffUser extends Command
{
    protected $signature = 'staff:create';

    protected $description = 'Create an employee account using a hidden, validated password prompt';

    public function handle(): int
    {
        if (! $this->input->isInteractive()) {
            $this->error('Perintah ini harus dijalankan secara interaktif agar password tidak masuk ke riwayat perintah.');

            return self::FAILURE;
        }

        $name = trim((string) $this->ask('Nama pegawai'));
        $email = mb_strtolower(trim((string) $this->ask('Email pegawai')));
        $password = (string) $this->secret('Password (minimal 12 karakter)');
        $passwordConfirmation = (string) $this->secret('Konfirmasi password');

        $validator = Validator::make([
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'password_confirmation' => $passwordConfirmation,
        ], [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Password::min(12)],
        ], [
            'email.unique' => 'Email tersebut sudah terdaftar.',
            'password.confirmed' => 'Konfirmasi password tidak sama.',
            'password.min' => 'Password harus memiliki minimal 12 karakter.',
        ]);

        if ($validator->fails()) {
            $this->error($validator->errors()->first());

            return self::FAILURE;
        }

        User::query()->create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
        ]);

        $this->info('Akun pegawai berhasil dibuat.');

        return self::SUCCESS;
    }
}
