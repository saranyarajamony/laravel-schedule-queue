<?php

use App\Models\Plan;
use App\Models\Customer;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->string('status');
            //$table->foreignIdFor(Customer::class)->constrained()->index();
            //$table->foreignIdFor(Plan::class)->constrained()->index();
            $table->foreignId('customer_id')->index();
            $table->foreign('customer_id')->on('customers')->references('id')->cascadeOnDelete();
            $table->foreignId('plan_id')->index();
            $table->foreign('plan_id')->on('plans')->references('id')->cascadeOnDelete();

            $table->string('address_1');
            $table->string('address_2')->nullable();
            $table->string('city');
            $table->string('state');
            $table->string('postcode', 4);
            $table->string('order_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('applications');
    }
};
