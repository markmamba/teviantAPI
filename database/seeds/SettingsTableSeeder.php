<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingsTableSeeder extends Seeder
{
    /**
     * The settings to add.
     */
    protected $settings = [
        [
            'key'         => 'contact_email',
            'name'        => 'Contact form email address',
            'description' => 'The email address that all emails from the contact form will go to.',
            'value'       => 'admin@teviant.com',
            'field'       => '{"name":"value","label":"Value","type":"email"}',
            'active'      => 1,
        ],
        [
            'key'           => 'contact_cc',
            'name'          => 'Contact form CC field',
            'description'   => 'Email addresses separated by comma, to be included as CC in the email sent by the contact form.',
            'value'         => '',
            'field'         => '{"name":"value","label":"Value","type":"text"}',
            'active'        => 1,

        ],
        [
            'key'           => 'contact_bcc',
            'name'          => 'Contact form BCC field',
            'description'   => 'Email addresses separated by comma, to be included as BCC in the email sent by the contact form.',
            'value'         => '',
            'field'         => '{"name":"value","label":"Value","type":"email"}',
            'active'        => 1,
        ],
        [
            'key'         => 'motto',
            'name'        => 'Motto',
            'description' => 'Website motto',
            'value'       => 'this is the value',
            'field'       => '{"name":"value","label":"Value","type":"textarea"}',
            'active'      => 1,
        ],
        [
            'key'         => 'inventory_low_stock_level',
            'name'        => 'Inventory Low Stock Level',
            'description' => 'The low stock level for the inventory.',
            'value'       => 5,
            'field'       => '{"name":"value","label":"Value","type":"number"}',
            'active'      => 1,
        ],
        [
            'key'         => 'auto_sync_order_statuses',
            'name'        => 'Auto Sync Order Statuses',
            'description' => 'Set whether to automatically synchronise order statuses between the OMS and the CMS app.',
            'value'       => 0,
            'field'       => '{"name":"value","label":"Turn On","type":"checkbox"}',
            'active'      => 1,
        ],
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->settings as $index => $setting) {
            $result = DB::table('settings')->insert($setting);

            if (!$result) {
                $this->command->info("Insert failed at record $index.");

                return;
            }
        }

        $this->command->info('Inserted '.count($this->settings).' records.');
    }
}
