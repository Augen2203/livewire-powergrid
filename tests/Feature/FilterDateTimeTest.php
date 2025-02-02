<?php

use function Pest\Livewire\livewire;

use PowerComponents\LivewirePowerGrid\Tests\{DishesCollectionTable, DishesTable};

it('properly filter the produced_at field between two dates', function () {
    livewire(DishesTable::class)
        ->set('filters', filterDateTime('produced_at', ['2021-02-02 00:00:00', '2021-04-04 00:00:00']))
        ->assertSee('Peixada da chef Nábia')
        ->assertSee('Carne Louca')
        ->assertSee('Bife à Rolê')
        ->assertDontSeeHtml('Francesinha vegana')
        ->assertSeeHtmlInOrder([
            'wire:model="filters.input_date_picker.produced_at"',
        ]);
});

it('properly filter the created_at field between two dates using collection table', function () {
    livewire(DishesCollectionTable::class)
        ->set('filters', filterDateTime('created_at', ['2021-01-01 00:00:00', '2021-04-04 00:00:00']))
        ->assertSeeText('Name 1')
        ->assertSeeText('Name 2')
        ->assertSeeText('Name 3')
        ->assertSeeText('Name 4')
        ->assertDontSeeHtml('Name 5')
        ->assertSeeHtmlInOrder([
            'wire:model="filters.input_date_picker.created_at"',
        ]);
});

it('properly filter the produced_at field between another two dates', function () {
    livewire(DishesTable::class)
        ->set('filters', filterDateTime('produced_at', ['2021-11-11 00:00:00', '2021-12-31 00:00:00']))
        ->assertDontSee('Peixada da chef Nábia')
        ->assertDontSee('Carne Louca')
        ->assertDontSee('Bife à Rolê')
        ->assertSeeHtmlInOrder([
            'wire:model="filters.input_date_picker.produced_at"',
        ]);
});

function filterDateTime(string $dataField, array $value): array
{
    return [
        'date_picker' => [
            $dataField => $value,
        ],
    ];
}
