<?php

namespace Database\Seeders;


use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;


class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('payment_methods')->insert([
            'id'       => Str::uuid(),
            'name'     => 'pix',
            'slug'     => 'pix'
        ]);

        DB::table('payment_methods')->insert([
            'id'       => Str::uuid(),
            'name'     => 'ticket',
            'slug'     => 'ticket'
        ]);

        DB::table('payment_methods')->insert([
            'id'       => Str::uuid(),
            'name'     => 'bank transfer',
            'slug'     => 'bank-transfer'
        ]);
    }
}
