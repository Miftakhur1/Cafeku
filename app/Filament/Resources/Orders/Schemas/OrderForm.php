<?php

namespace App\Filament\Resources\Orders\Schemas;

use App\Models\Products;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;

class OrderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->schema([

                    // =======================
                    // KOLOM KIRI (UTAMA)
                    // =======================
                    Group::make()
                        ->schema([
                            Section::make('Informasi Pesanan')
                                ->description('Detail pelanggan dan metode layanan.')
                                ->icon('heroicon-m-user-circle')
                                ->columns(['md' => 2, 'default' => 1])
                                ->schema([
                                    TextInput::make('order_number')
                                        ->label('Order ID')
                                        ->default('ORD-' . strtoupper(str()->random(6)))
                                        ->disabled()
                                        ->dehydrated()
                                        ->required(),

                                    TextInput::make('customer_name')
                                        ->label('Nama Pelanggan')
                                        ->placeholder('Masukkan nama lengkap')
                                        ->required(),

                                    Select::make('service_type')
                                        ->label('Tipe Layanan')
                                        ->options([
                                            'dine-in' => 'Dine In',
                                            'delivery' => 'Delivery',
                                        ])
                                        ->default('dine-in')
                                        ->native(false)
                                        ->live()
                                        ->required(),

                                    TextInput::make('table_number')
                                        ->label('Nomor Meja')
                                        ->placeholder('Contoh: A-12')
                                        ->visible(fn (Get $get) => $get('service_type') === 'dine-in')
                                        ->required(fn (Get $get) => $get('service_type') === 'dine-in'),

                                    TextInput::make('phone')
                                        ->label('No. WhatsApp')
                                        ->tel()
                                        ->placeholder('0812...')
                                        ->visible(fn (Get $get) => $get('service_type') === 'delivery')
                                        ->required(fn (Get $get) => $get('service_type') === 'delivery'),

                                    Textarea::make('address')
                                        ->label('Alamat Pengiriman')
                                        ->columnSpanFull()
                                        ->rows(3)
                                        ->visible(fn (Get $get) => $get('service_type') === 'delivery')
                                        ->required(fn (Get $get) => $get('service_type') === 'delivery'),
                                ]),

                            Section::make('Pembayaran')
                                ->description('Status dan ringkasan biaya.')
                                ->icon('heroicon-m-credit-card')
                                ->columns(['md' => 2, 'default' => 1])
                                ->schema([
                                    Select::make('status')
                                        ->options([
                                            'pending' => 'Pending',
                                            'processing' => 'Diproses',
                                            'completed' => 'Selesai',
                                            'cancelled' => 'Batal',
                                        ])
                                        ->default('pending')
                                        ->native(false)
                                        ->required(),

                                    Select::make('payment_method')
                                        ->label('Metode Pembayaran')
                                        ->options([
                                            'cash' => 'Tunai (Cash)',
                                            'qris' => 'QRIS',
                                            'transfer' => 'Transfer Bank',
                                            'ovo' => 'OVO',
                                            'gopay' => 'GoPay',
                                        ])
                                        ->native(false)
                                        ->required(),

                                    TextInput::make('total_price')
                                        ->label('Total yang Harus Dibayar')
                                        ->prefix('Rp')
                                        ->numeric()
                                        ->readOnly() // Gunakan readOnly agar tetap terkirim di form
                                        ->extraInputAttributes(['class' => 'text-2xl font-bold text-primary-600'])
                                        ->columnSpanFull(),
                                ]),
                        ]),

                    // =======================
                    // KOLOM KANAN (PRODUK)
                    // =======================
                    Group::make()
                        ->schema([
                            Section::make('Item Pesanan')
                                ->description('Daftar menu yang dipesan')
                                ->icon('heroicon-m-shopping-bag')
                                ->schema([
                                    Repeater::make('items')
                                        ->relationship()
                                        ->schema([
                                            Select::make('product_id')
                                                ->label('Pilih Produk')
                                                ->options(Products::pluck('name', 'id'))
                                                ->searchable()
                                                ->preload()
                                                ->required()
                                                ->reactive()
                                                ->afterStateUpdated(function ($state, Set $set, Get $get) {
                                                    $product = Products::find($state);
                                                    $price = $product?->price ?? 0;
                                                    $set('unit_price', $price);
                                                    $quantity = (int) ($get('quantity') ?? 1);
                                                    $set('subtotal', $quantity * (float) $price);
                                                }),

                                            TextInput::make('quantity')
                                                ->label('Qty')
                                                ->numeric()
                                                ->default(1)
                                                ->minValue(1)
                                                ->required()
                                                ->reactive()
                                                ->live()
                                                ->afterStateUpdated(function ($state, Set $set, Get $get) {
                                                    $quantity = (int) $state;
                                                    $unitPrice = (float) ($get('unit_price') ?? 0);
                                                    $set('subtotal', $quantity * $unitPrice);
                                                }),

                                            TextInput::make('unit_price')
                                                ->label('Harga Satuan')
                                                ->prefix('Rp')
                                                ->disabled()
                                                ->dehydrated(),

                                            TextInput::make('subtotal')
                                                ->label('Subtotal')
                                                ->prefix('Rp')
                                                ->default(0)
                                                ->disabled()
                                                ->dehydrated(),

                                        ])
                                        ->itemLabel(fn (array $state): ?string => 
                                            Products::find($state['product_id'])?->name ?? 'Produk Baru'
                                        )
                                        ->collapsible()
                                        ->defaultItems(1)
                                        ->addActionLabel('Tambah Item')
                                        ->live()
                                        ->afterStateUpdated(function (Get $get, Set $set) {
                                            $items = $get('items') ?? [];
                                            $total = 0;
                                            foreach ($items as $item) {
                                                $quantity = (int) ($item['quantity'] ?? 0);
                                                $unitPrice = (float) ($item['unit_price'] ?? 0);
                                                $total += $quantity * $unitPrice;
                                            }
                                            $set('total_price', $total);
                                        }),
                                ]),
                        ]),

        ]);
    }
}