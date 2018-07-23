<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;

class CreateContractServicesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create(Config::get('ore.contract-service.table'), function (Blueprint $table) {
            $table->increments('id');
            $table->string('code');

            $table->integer('customer_id')->unsigned();
            $table->foreign('customer_id')->references('id')->on(Config::get('ore.customer.table'));

            $table->integer('address_id')->unsigned();
            $table->foreign('address_id')->references('id')->on(Config::get('ore.address.table'));

            $table->integer('contract_id')->unsigned();
            $table->foreign('contract_id')->references('id')->on(Config::get('ore.contract.table'));

            $table->integer('service_id')->unsigned();
            $table->foreign('service_id')->references('id')->on(Config::get('ore.recurring-service.table'));

            $table->integer('tax_id')->unsigned()->nullable();
            $table->foreign('tax_id')->references('id')->on(Config::get('ore.tax.table'));

            $table->string('frequency_unit');
            $table->integer('frequency_value');
            $table->integer('renewals')->default(0);

            $table->float('price')->default(0);
            $table->float('price_start')->default(0);
            $table->float('price_end')->default(0);

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists(Config::get('ore.contract-service.table'));
    }
}
