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
        Schema::create('deleted_inventories', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('purchase_order_no');
            $table->string('supplier_name');
            $table->string('supplier_email');
            $table->string('supplier_address');
            $table->string('supplier_contactno');
            $table->string('supplier_faxno');
            $table->foreignId('department_id')->constrained();
            $table->string('asset_location');
            $table->string('asset_to');
            $table->string('asset_code');
            $table->string('asset_cat');
            $table->string('asset_type');
            $table->string('item_location');
            $table->string('serial_num');
            $table->string('microsoft_office');
            $table->string('tel_number');
            $table->string('nos');
            $table->string('description');
            $table->decimal('amount', 10, 2);
            $table->string('item');
            $table->string('id_tag')->nullable(false);
            $table->timestamp('deleted_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deleted_inventories');
    }
};
