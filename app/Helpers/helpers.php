<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

/**
 * Cek apakah user sedang login adalah admin
 */
if (! function_exists('isAdmin')) {
    function isAdmin(): bool
    {
        return Auth::check() && Auth::user()->role === 1;
    }
}

/**
 * Cek apakah user sedang login adalah pekerja
 */
if (! function_exists('isPekerja')) {
    function isPekerja(): bool
    {
        return Auth::check() && Auth::user()->role === 2;
    }
}

/**
 * Ambil user yang sedang login
 */
if (! function_exists('currentUser')) {
    function currentUser()
    {
        return Auth::user();
    }
}

/**
 * Format tanggal ke format Indonesia (contoh: 01 September 2025)
 */
if (! function_exists('formatTanggal')) {
    function formatTanggal($date): string
    {
        return \Carbon\Carbon::parse($date)->translatedFormat('d F Y');
    }
}

/**
 * Batasi panjang teks dengan ellipsis (...)
 */
if (! function_exists('limitText')) {
    function limitText(string $text, int $limit = 50): string
    {
        return Str::limit($text, $limit);
    }
}

/**
 * Buat flash message (session) lebih singkat
 */
if (! function_exists('flash')) {
    function flash(string $key, string $message): void
    {
        session()->flash($key, $message);
    }
}
