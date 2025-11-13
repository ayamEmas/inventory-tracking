<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('disposals', function (Blueprint $table) {
            $table->string('id_tag')->nullable()->after('registrationSerialNum')->index();
        });

        // Backfill the new column with existing registrationSerialNum values
        DB::table('disposals')
            ->whereNull('id_tag')
            ->update(['id_tag' => DB::raw('registrationSerialNum')]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('disposals', function (Blueprint $table) {
            $table->dropColumn('id_tag');
        });
    }
};

