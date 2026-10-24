@props(['size' => 48, 'shadow' => false])

<img
    src="{{ asset('images/logo-ntb.png') }}"
    alt="Logo Provinsi Nusa Tenggara Barat"
    style="height: {{ (int) $size }}px; width: auto; max-width: 100%; object-fit: contain; flex: 0 0 auto; @if ($shadow) filter: drop-shadow(0 0 2px rgba(255, 255, 255, 0.35)); @endif"
    {{ $attributes }}
>