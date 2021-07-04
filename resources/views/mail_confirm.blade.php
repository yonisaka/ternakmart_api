@component('mail::message')
# Registrasi Akun Berhasil

Silahkan klik Verifikasi Akun untuk melakukan verifikasi

@component('mail::button', ['url' => $url])
Verifikasi Akun
@endcomponent

Thanks,<br>
@endcomponent