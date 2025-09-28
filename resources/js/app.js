// resources/js/app.js
import './../../vendor/power-components/livewire-powergrid/dist/powergrid'
import mask from '@alpinejs/mask'

// Registrar el plugin cuando Alpine esté disponible
document.addEventListener('alpine:init', () => {
    window.Alpine.plugin(mask)
})