<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRegionsTable extends Migration
{

    public function up()
    {
        Schema::create('regions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('pid')->default(0);
            $table->string('name', 100);
            $table->integer('level')->default(1);
            $table->string('code')->nullable();
        });

        // 存储行政编码 数据源有问题，极力不建议使用
        // $this->fillRegionsWithCode();

        $this->fillRegionsWithoutCode();
    }

    public function fillRegionsWithoutCode()
    {
        $provinces = json_decode(file_get_contents(public_path('regions/data.json')), true);
        foreach ($provinces as $province) {
            $provinceId = DB::table('regions')->insertGetId(['name' => $province['name'], 'pid' => 0, 'level' => 1]);
            foreach ($province['city'] as $city) {
                $cityId = DB::table('regions')->insertGetId(['name' => $city['name'], 'pid' => $provinceId, 'level' => 2]);
                $areas = array_map(function ($area) use ($cityId) {
                    return ['name' => $area, 'pid' => $cityId, 'level' => 3];
                }, $city['area']);
                DB::table('regions')->insert($areas);
            }
        }
    }

    public function fillRegionsWithCode()
    {
        $provinces = json_decode(file_get_contents(public_path('regions/data.json')), true);
        foreach ($provinces as $province) {
            $provinceId = DB::table('regions')->insertGetId(['name' => $province['title'], 'code' => $province['ad_code'], 'pid' => 0, 'level' => 1]);
            foreach ($province['child'] as $city) {
                $cityId = DB::table('regions')->insertGetId(['name' => $city['title'], 'pid' => $provinceId, 'level' => 2, 'code' => $city['ad_code']]);
                $areas = array_map(function ($area) use ($cityId) {
                    return ['name' => $area['title'], 'pid' => $cityId, 'level' => 3, 'code' => $area['ad_code']];
                }, $city['child']);
                DB::table('regions')->insert($areas);
            }
        }
    }

    public function down()
    {
        Schema::dropIfExists('regions');
    }
}