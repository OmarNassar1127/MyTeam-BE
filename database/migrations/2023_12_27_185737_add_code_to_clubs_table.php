<?php

use App\Models\Club;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('clubs', function (Blueprint $table) {
            $table->string('code')->after('president_user_id')->nullable();
        });

        $clubs = Club::all();
        foreach ($clubs as $club) {
            $club->code = Club::generateRandomCode();
            $club->save();
        }

        Schema::table('clubs', function (Blueprint $table) {
            $table->string('code')->unique()->change();
        });
    }

    public function down()
    {
        Schema::table('clubs', function (Blueprint $table) {
            $table->dropColumn('code');
        });
    }
};
