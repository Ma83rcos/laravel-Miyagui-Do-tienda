<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>@yield('title', 'Miyagui-Do Tienda Online')</title>

<!-- Tailwind CDN -->
<script src="https://cdn.tailwindcss.com"></script>

<!-- Configuración de colores personalizados -->
<script>
  tailwind.config = {
    theme: {
      extend: {
        colors: {
          primary: {
            DEFAULT: '#16a34a',
            700: '#15803d',
          }
        }
      }
    }
  }
</script>

<!-- Alpine.js -->
<script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

<!-- CSS para x-cloak -->
<style>
    [x-cloak] { display: none !important; }
</style>

@stack('styles')
