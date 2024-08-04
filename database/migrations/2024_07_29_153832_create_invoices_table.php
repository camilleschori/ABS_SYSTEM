<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->integer('number');
            $table->date('date');
            $table->enum('type' , ['sales', 'purchases' , 'purchases_return', 'sales_return']);
            $table->unsignedBigInteger('profile_id')->nullable();
            $table->unsignedBigInteger('country_id');
            $table->unsignedBigInteger('province_id');
            $table->unsignedBigInteger('area_id')->nullable();
            $table->unsignedBigInteger('sub_area_id')->nullable();
            $table->string('address_title')->nullable();
            $table->string('address_phone')->nullable();
            $table->string('address_notes')->nullable();
            $table->unsignedBigInteger('price_group_id')->nullable();
            $table->float('total_amount' , 11, 2)->default(0);
            $table->float('discount_percentage' , 11, 2)->default(0);
            $table->float('discount_value' , 11, 2)->default(0);
            $table->float('total_amount_after_discount' , 11, 2)->default(0);
            $table->float('delivery_fees' , 11, 2)->default(0);
            $table->float('grand_total' , 11, 2)->default(0);
            $table->enum('payment_method' , ['cash', 'credit']);
            $table->enum('status' , ['pending', 'confirmed' , 'on_the_way', 'delivered', 'canceled']);
            $table->string('notes')->nullable();
            $table->boolean('stock_effection');
            $table->enum('effection_type' , ['in', 'out' , 'in_return', 'out_return']);
            $table->unsignedBigInteger('currency_id');
            $table->float('exchange_rate');
            $table->float('paid_amount')->default(0);
            $table->float('remaining_amount');
            $table->enum('payment_status' , ['paid', 'unpaid']);
            $table->timestamps();
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();

            $table->foreign('profile_id')->references('id')->on('profiles');
            $table->foreign('country_id')->references('id')->on('regions');
            $table->foreign('province_id')->references('id')->on('regions');
            $table->foreign('area_id')->references('id')->on('regions');
            $table->foreign('sub_area_id')->references('id')->on('regions');
            $table->foreign('price_group_id')->references('id')->on('price_groups');
            $table->foreign('currency_id')->references('id')->on('currencies');
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('updated_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
