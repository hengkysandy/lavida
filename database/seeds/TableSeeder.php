<?php

use Illuminate\Database\Seeder;

class TableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'id' => '1',
                'name' => 'admin',
                'email' => 'admin@gmail.com',
                'password' => bcrypt('admin1'),
                'remember_token' => '',
                'created_at' => '2017-01-25 08:29:08',
                'updated_at' => '2017-01-25 10:39:40'
            ]
        ]);

        DB::table('suppliers')->insert([
            [
                'id' => '1',
                'supplier_code' => 'SU1234',
                'supplier_name' => 'supplier1',
                'pic_name' => 'supplier1pic',
                'pic_contact' => '081208120812',
                'pic_email' => 'supplier1@gmail.com',
                'pic_phone' => '123412341234',
                'supplier_location' => 'supplier1 location',
                'supplier_description' => 'supplier1 description',
                'status' => '1',
                'created_at' => '2017-01-25 08:29:08',
                'updated_at' => '2017-01-25 10:39:40'
            ],
            [
                'id' => '2',
                'supplier_code' => 'SU1235',
                'supplier_name' => 'supplier2',
                'pic_name' => 'supplier2pic',
                'pic_contact' => '082208220822',
                'pic_email' => 'supplier2@gmail.com',
                'pic_phone' => '223422342234',
                'supplier_location' => 'supplier2 location',
                'supplier_description' => 'supplier2 description',
                'status' => '1',
                'created_at' => '2017-02-25 08:29:08',
                'updated_at' => '2017-02-25 10:39:40'
            ]
        ]);

        DB::table('customers')->insert([
            [
                'id' => '1',
                'customer_code' => 'CU1234',
                'customer_name' => 'customer1',
                'pic_name' => 'customer1pic',
                'pic_contact' => '081208120812',
                'pic_email' => 'customer1@gmail.com',
                'pic_phone' => '123412341234',
                'customer_location' => 'customer1 location',
                'customer_description' => 'customer1 description',
                'status' => 'active',
                'created_at' => '2017-01-25 08:29:08',
                'updated_at' => '2017-01-25 10:39:40'
            ],
            [
                'id' => '2',
                'customer_code' => 'CU1235',
                'customer_name' => 'customer2',
                'pic_name' => 'customer2pic',
                'pic_contact' => '082208220822',
                'pic_email' => 'customer2@gmail.com',
                'pic_phone' => '223422342234',
                'customer_location' => 'customer2 location',
                'customer_description' => 'customer2 description',
                'status' => 'active',
                'created_at' => '2027-02-25 08:29:08',
                'updated_at' => '2027-02-25 20:39:40'
            ]
        ]);
    }
}
