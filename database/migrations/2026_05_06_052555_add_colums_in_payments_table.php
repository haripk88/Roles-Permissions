<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->decimal('wallet_balance', 10, 2)->default(0)->after('password');
        });
        Schema::table('payments', function (Blueprint $table) {
            $table->decimal('remaining_balance', 10, 2)->default(0)->after('amount');

            $table->enum('type', [
                'credit',
                'debit'
            ])->default('credit')->after('remaining_balance');

            $table->string('payment_method')->nullable()->after('type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn(['remaining_balance', 'type', 'payment_method']);
        });
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('wallet_balance');
        });
    }
};
