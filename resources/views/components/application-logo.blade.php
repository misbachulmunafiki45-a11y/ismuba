@php use Illuminate\Support\Facades\Storage; @endphp
<img src="{{ Storage::url('stm.png') }}" alt="STM Logo" {{ $attributes->merge(['class' => 'block h-9 w-auto']) }} />
