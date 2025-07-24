@props(['status'])

@php
    $statusValue = strtolower($status);
    $isAlDia = in_array($statusValue, ['al día', 'al dia']);
    $isRetraso = $statusValue === 'retraso';
    $isMoroso = $statusValue === 'moroso';

    $classes = [
        'inline-flex', 'items-center', 'px-2', 'py-0.5', 'rounded-md', 'text-xs', 'font-medium', 'leading-5'
    ];
    
    $displayText = '';

    if ($isAlDia) {
        $classes = array_merge($classes, ['bg-green-100', 'text-green-800', 'dark:bg-green-800/30', 'dark:text-green-400']);
        $displayText = 'Al día';
    } elseif ($isRetraso) {
        $classes = array_merge($classes, ['bg-yellow-100', 'text-yellow-800', 'dark:bg-yellow-800/30', 'dark:text-yellow-400']);
        $displayText = 'Retraso';
    } elseif ($isMoroso) {
        $classes = array_merge($classes, ['bg-red-100', 'text-red-800', 'dark:bg-red-800/30', 'dark:text-red-400']);
        $displayText = 'Moroso';
    } else {
        $displayText = ucfirst($status);
    }
@endphp

<span @class($classes)>
    {{ $displayText }}
</span> 