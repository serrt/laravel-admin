<?php

use Illuminate\Database\Seeder;

class KeywordsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['key' => 'community', 'name' => '社别', 'children' => 10],
            ['key' => 'population_type', 'name' => '户籍类型', 'children' => ['农业户口', '城镇户口', '农转非', '农村居民']],
            ['key' => 'education', 'name' => '文化程度', 'children' => ['小学', '初中', '高中', '大学本科', '大学专科/高职', '文盲或半文盲', '研究生以上', '学龄前儿童']],
            ['key' => 'nation', 'name' => '民族', 'children' => ['汉族', '苗族', '藏族', '侗族', '彝族', '内蒙', '穿青人	', '土家族', '仡佬族']],
            ['key' => 'polity', 'name' => '政治面貌', 'children' => ['党员', '团员', '群众', '学龄前儿童']],
            ['key' => 'marry', 'name' => '婚姻状况', 'children' => ['未婚', '已婚', '离异', '再婚', '复婚', '丧偶']],
        ];
        $keywords_type = [];
        $keywords = [];
        foreach ($data as $key => $item) {
            $id = $key+1;
            array_push($keywords_type, ['id' => $id, 'key' => $item['key'], 'name' => $item['name']]);
            if (is_array($item['children'])) {
                foreach ($item['children'] as $key1 => $value) {
                    $sort = $key1+1;
                    array_push($keywords, ['type' => $id, 'type_key' => $item['key'], 'key' => $item['key'].'_'.$sort, 'name' => $value, 'sort' => $sort]);
                }
            } elseif (is_integer($item['children'])) {
                $i = 1;
                while ($i <= 10) {
                    array_push($keywords, ['type' => $id, 'type_key' => $item['key'], 'key' => $item['key'].'_'.$i, 'name' => $i.$item['name'], 'sort' => $i]);
                    $i++;
                }
            }
        }
        DB::table('keywords_type')->delete();
        DB::table('keywords')->delete();
        DB::table('keywords_type')->insert($keywords_type);
        DB::table('keywords')->insert($keywords);
    }
}
