<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;

class CreateContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(Config::get('ore.contract.table'), function (Blueprint $table) {
            $table->increments('id');
            $table->string('code');
            $table->text('notes')->nullable();

            $table->integer('customer_id')->unsigned();
            $table->foreign('customer_id')->references('id')->on(Config::get('ore.customer.table'));

            $table->integer('tax_id')->unsigned()->nullable();
            $table->foreign('tax_id')->references('id')->on(Config::get('ore.tax.table'));

            $table->string('country');
            $table->string('locale');
            $table->string('currency');

            $table->string('payment_method');

            $table->string('frequency_unit');
            $table->integer('frequency_value');
            $table->integer('renewals')->default(0);

            $table->date('starts_at')->nullable();
            $table->date('ends_at')->nullable();
            $table->date('last_bill_at')->nullable();
            $table->date('next_bill_at')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(Config::get('ore.contract.table'));
    }
}
