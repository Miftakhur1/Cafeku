<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique(); // ID Pesanan unik (Contoh: ORD-ABC123)
            $table->string('customer_name');
            $table->enum('service_type', ['dine-in', 'delivery'])->default('dine-in');
            $table->string('table_number')->nullable();
            
            // Kontak & Alamat (Opsional jika Delivery)
            $table->string('phone')->nullable();
            $table->text('address')->nullable();
            
            // Status & Pembayaran
            $table->enum('status', ['pending', 'processing', 'completed', 'cancelled'])->default('pending');
            $table->string('payment_method')->nullable(); // Cash, QRIS, dll
            
            // Menggunakan decimal(12, 2) sesuai standar produk kamu
            $table->decimal('total_price', 12, 2)->default(0); 
            
            $table->softDeletes(); // Penting untuk TrashedFilter di Filament
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};