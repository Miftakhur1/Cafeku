<?php

namespace App\Filament\Resources\OrderItems\Schemas;

use App\Models\Order;
use App\Models\Products;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;

class OrderItemsForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->schema([
            Group::make()
                ->schema([
                    Section::make('Detail Item Pesanan')
                        ->description('Atur order, produk, jumlah, dan harga satuan.')
                        ->icon('heroicon-m-shopping-cart')
                        ->schema([
                            Select::make('order_id')
                                ->label('Order')
                                ->options(Order::pluck('order_number', 'id'))
                                ->searchable()
                                ->required(),

                            Select::make('product_id')
                                ->label('Produk')
                                ->options(Products::pluck('name', 'id'))
                                ->searchable()
                                ->preload()
                                ->required(),

                            TextInput::make('quantity')
                                ->label('Qty')
                                ->numeric()
                                ->default(1)
                                ->minValue(1)
                                ->required()
                                ->reactive()
                                ->afterStateUpdated(function ($state, Set $set, Get $get) {
                                    $quantity = (int) $state;
                                    $unitPrice = (float) ($get('unit_price') ?? 0);
                                    $set('subtotal', $quantity * $unitPrice);
                                }),

                            TextInput::make('unit_price')
                                ->label('Harga Satuan')
                                ->prefix('Rp')
                                ->numeric()
                                ->default(0)
                                ->required()
                                ->reactive()
                                ->afterStateUpdated(function ($state, Set $set, Get $get) {
                                    $quantity = (int) ($get('quantity') ?? 0);
                                    $set('subtotal', $quantity * (float) $state);
                                }),

                            TextInput::make('subtotal')
                                ->label('Subtotal')
                                ->prefix('Rp')
                                ->numeric()
                                ->default(0)
                                ->disabled()
                                ->dehydrated(),
                        ]),
                ]),
        ]);
    }
}
