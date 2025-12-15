<?php

return [

    [
        'id' => 1,
        'name' => 'Descuento Primavera',
        'slug' => 'descuento-primavera',
        'discount_percentage' => 20,
        'description' => 'Un 20% de descuento primavera en productos seleccionados.',
        'start_date' => '2025-03-01',
        'end_date' => '2025-03-31',
        'active' => true,
        'product_ids' => [1, 2, 5]
    ],

    [
        'id' => 2,
        'name' => 'Oferta Verano',
        'slug' => 'oferta-verano',
        'discount_percentage' => 15,
        'description' => 'Un 15% de descuento en artículos de verano.',
        'start_date' => '2025-06-01',
        'end_date' => '2025-06-30',
        'active' => true,
        'product_ids' => [3, 4]
    ],

    [
        'id' => 3,
        'name' => 'Black Friday',
        'slug' => 'black-friday',
        'discount_percentage' => 40,
        'description' => 'Un 40% semana black-friday productos seleccionados.',
        'start_date' => '2025-11-11',
        'end_date' => '2025-11-18',
        'active' => false,
        'product_ids' => [1, 3, 4, 6]
    ],

];

