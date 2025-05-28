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
        Schema::table('inventories', function (Blueprint $table) {
            $table->string('purchade_order_no')->nullable();
            $table->string('supplier_name')->nullable();
            $table->string('supplier_email')->nullable();
            $table->text('supplier_address')->nullable();
            $table->string('supplier_contactno')->nullable();
            $table->string('supplier_faxno')->nullable();
            $table->string('asset_location')->nullable();
            $table->string('asset_to')->nullable();
            $table->string('asset_code')->nullable();
            $table->string('asset_cat')->nullable();
            $table->string('asset_type')->nullable();
            $table->string('item_location')->nullable();
            $table->string('serial_num')->nullable();
            $table->string('microsoft_office')->nullable();
            $table->string('tel_number')->nullable();
            $table->string('nos')->nullable();
            $table->string('id_tag')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inventories', function (Blueprint $table) {
            $table->dropColumn([
                'purchade_order_no',
                'supplier_name',
                'supplier_email',
                'supplier_address',
                'supplier_contactno',
                'supplier_faxno',
                'asset_location',
                'asset_to',
                'asset_code',
                'asset_cat',
                'asset_type',
                'item_location',
                'serial_num',
                'microsoft_office',
                'tel_number',
                'nos',
                'id_tag',
            ]);
        });
    }
};
