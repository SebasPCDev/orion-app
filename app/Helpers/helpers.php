<?php

if (!function_exists('monthToSpanish')) {
    /**
     * Convierte el nombre de un mes en inglés a español
     * 
     * @param string $englishMonth Nombre del mes en inglés (ej: "January", "February")
     * @return string Nombre del mes en español
     * @throws InvalidArgumentException Si el mes no es válido
     */
    function monthToSpanish(string $englishMonth): string
    {
        $months = [
            'January' => 'Enero',
            'February' => 'Febrero',
            'March' => 'Marzo',
            'April' => 'Abril',
            'May' => 'Mayo',
            'June' => 'Junio',
            'July' => 'Julio',
            'August' => 'Agosto',
            'September' => 'Septiembre',
            'October' => 'Octubre',
            'November' => 'Noviembre',
            'December' => 'Diciembre'
        ];

        // Normalizar la entrada para que funcione con diferentes formatos
        $normalizedMonth = ucfirst(strtolower(trim($englishMonth)));

        if (!array_key_exists($normalizedMonth, $months)) {
            throw new InvalidArgumentException("El mes '{$englishMonth}' no es válido. Los meses válidos son: " . implode(', ', array_keys($months)));
        }

        return $months[$normalizedMonth];
    }
}

if (!function_exists('monthToSpanishShort')) {
    /**
     * Convierte el nombre de un mes en inglés a español (versión abreviada)
     * 
     * @param string $englishMonth Nombre del mes en inglés (ej: "Jan", "Feb" o "January", "February")
     * @return string Nombre del mes en español abreviado (ej: "Ene", "Feb")
     * @throws InvalidArgumentException Si el mes no es válido
     */
    function monthToSpanishShort(string $englishMonth): string
    {
        $monthsShort = [
            // Versiones completas
            'January' => 'Ene',
            'February' => 'Feb',
            'March' => 'Mar',
            'April' => 'Abr',
            'May' => 'May',
            'June' => 'Jun',
            'July' => 'Jul',
            'August' => 'Ago',
            'September' => 'Sep',
            'October' => 'Oct',
            'November' => 'Nov',
            'December' => 'Dic',
            // Versiones abreviadas en inglés
            'Jan' => 'Ene',
            'Feb' => 'Feb',
            'Mar' => 'Mar',
            'Apr' => 'Abr',
            'May' => 'May',
            'Jun' => 'Jun',
            'Jul' => 'Jul',
            'Aug' => 'Ago',
            'Sep' => 'Sep',
            'Oct' => 'Oct',
            'Nov' => 'Nov',
            'Dec' => 'Dic'
        ];

        // Normalizar la entrada
        $normalizedMonth = ucfirst(strtolower(trim($englishMonth)));

        if (!array_key_exists($normalizedMonth, $monthsShort)) {
            throw new InvalidArgumentException("El mes '{$englishMonth}' no es válido. Los meses válidos son: " . implode(', ', array_unique(array_keys($monthsShort))));
        }

        return $monthsShort[$normalizedMonth];
    }
}
