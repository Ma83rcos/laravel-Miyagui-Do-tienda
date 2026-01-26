<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>@yield('title', 'Miyagui-Do Tienda Online')</title>

{{-- Tailwind CDN --}}
<script src="https://cdn.tailwindcss.com"></script>

{{-- Configuración de colores personalizados --}}
<script>
  tailwind.config = {
    theme: {
      extend: {
        colors: {
          primary: {
            DEFAULT: '#16a34a', // verde principal
            700: '#15803d',     // verde para hover
          }
        }
      }
    }
  }
</script>
{{-- Alpine.js para interactividad, como desaparecer flash messages --}}
<script src="//unpkg.com/alpinejs" defer></script>


@stack('styles')
