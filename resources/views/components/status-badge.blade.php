@props(['status'])

@php
    $statusValue = strtolower($status);
    $isActive = $statusValue === 'active' || $statusValue === 'activo';
    $isInactive = $statusValue === 'inactive' || $statusValue === 'inactivo';

    $classes = [
        'inline-flex', 'items-center', 'px-2', 'py-0.5', 'rounded-md', 'text-xs', 'font-medium', 'leading-5'
    ];
    
    if ($isActive) {
        $classes = array_merge($classes, ['bg-green-100', 'text-green-800', 'dark:bg-green-800/30', 'dark:text-green-400']);
        $displayText = 'Activo';
    } elseif ($isInactive) {
        $classes = array_merge($classes, ['bg-red-100', 'text-red-800', 'dark:bg-red-800/30', 'dark:text-red-400']);
        $displayText = 'Inactivo';
    } else {
        $displayText = ucfirst($status);
    }
@endphp

<span @class($classes)>
    {{ $displayText }}
</span>
