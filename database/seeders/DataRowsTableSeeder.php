<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use TCG\Voyager\Models\DataRow;
use TCG\Voyager\Models\DataType;

class DataRowsTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     */
    public function run()
    {
        $moduleDataRows = $this->getDataRows();

        foreach ($moduleDataRows as $module => $dataRows) {

            $dataType = DataType::where('slug', $module)->firstOrFail();

            // reset order
            $order = 1;

            foreach ($dataRows as $columnName => $dataRow) {

                $dataRowModel = $this->dataRow($dataType, $columnName);

                $dataRow['order'] = $order;

                if ($dataRowModel->exists) {

                    $dataRowModel->update($dataRow);

                } else {

                    $dataRowModel->fill($dataRow)->save();
                }

                $order++;
            }
        }
    }

    /**
     * [dataRow...].
     *
     * @return array
     */
    protected function getDataRows()
    {
        return [
            'users' => [
                'id' => [
                    'type'         => 'number',
                    'display_name' => __('voyager::seeders.data_rows.id'),
                    'required'     => 1,
                    'browse'       => 0,
                    'read'         => 0,
                    'edit'         => 0,
                    'add'          => 0,
                    'delete'       => 0,
                    'order'        => 1,
                ],
                'avatar' => [
                    'type'         => 'image',
                    'display_name' => __('voyager::seeders.data_rows.avatar'),
                    'required'     => 0,
                    'browse'       => 1,
                    'read'         => 1,
                    'edit'         => 1,
                    'add'          => 1,
                    'delete'       => 1,
                    'order'        => 8,
                ],
                'name' => [
                    'type'         => 'text',
                    'display_name' => __('voyager::seeders.data_rows.name'),
                    'required'     => 1,
                    'browse'       => 1,
                    'read'         => 1,
                    'edit'         => 1,
                    'add'          => 1,
                    'delete'       => 1,
                    'order'        => 2,
                ],
                'email' => [
                    'type'         => 'text',
                    'display_name' => __('voyager::seeders.data_rows.email'),
                    'required'     => 1,
                    'browse'       => 1,
                    'read'         => 1,
                    'edit'         => 1,
                    'add'          => 1,
                    'delete'       => 1,
                    'order'        => 3,
                ],
                'password' => [
                    'type'         => 'password',
                    'display_name' => __('voyager::seeders.data_rows.password'),
                    'required'     => 1,
                    'browse'       => 0,
                    'read'         => 0,
                    'edit'         => 1,
                    'add'          => 1,
                    'delete'       => 0,
                    'order'        => 4,
                ],
                'remember_token' => [
                    'type'         => 'text',
                    'display_name' => __('voyager::seeders.data_rows.remember_token'),
                    'required'     => 0,
                    'browse'       => 0,
                    'read'         => 0,
                    'edit'         => 0,
                    'add'          => 0,
                    'delete'       => 0,
                    'order'        => 5,
                ],
                'role_id' => [
                    'type'         => 'text',
                    'display_name' => __('voyager::seeders.data_rows.role'),
                    'required'     => 1,
                    'browse'       => 1,
                    'read'         => 1,
                    'edit'         => 1,
                    'add'          => 1,
                    'delete'       => 1,
                    'order'        => 9,
                ],
                'created_by' => [
                    'type'         => 'number',
                    'display_name' => 'Created By',
                    'required'     => 1,
                    'browse'       => 0,
                    'read'         => 0,
                    'edit'         => 0,
                    'add'          => 0,
                    'delete'       => 1,
                    'details'      => [
                        'relationship' => [
                            'key'   => 'id',
                            'label' => 'name'
                        ]
                    ]
                ],
                'updated_by' => [
                    'type'         => 'number',
                    'display_name' => 'Updated By',
                    'required'     => 1,
                    'browse'       => 0,
                    'read'         => 0,
                    'edit'         => 0,
                    'add'          => 0,
                    'delete'       => 1,
                    'details'      => [
                        'relationship' => [
                            'key'   => 'id',
                            'label' => 'name'
                        ]
                    ]
                ],
                'created_at' => [
                    'type'         => 'timestamp',
                    'display_name' => __('voyager::seeders.data_rows.created_at'),
                    'required'     => 0,
                    'browse'       => 1,
                    'read'         => 1,
                    'edit'         => 0,
                    'add'          => 0,
                    'delete'       => 0,
                    'order'        => 6,
                ],
                'updated_at' => [
                    'type'         => 'timestamp',
                    'display_name' => __('voyager::seeders.data_rows.updated_at'),
                    'required'     => 0,
                    'browse'       => 0,
                    'read'         => 0,
                    'edit'         => 0,
                    'add'          => 0,
                    'delete'       => 0,
                    'order'        => 7,
                ],
                'user_belongsto_role_relationship' => [
                    'type'         => 'relationship',
                    'display_name' => __('voyager::seeders.data_rows.role'),
                    'required'     => 0,
                    'browse'       => 1,
                    'read'         => 1,
                    'edit'         => 1,
                    'add'          => 1,
                    'delete'       => 0,
                    'details'      => [
                        'model'       => 'TCG\\Voyager\\Models\\Role',
                        'table'       => 'roles',
                        'type'        => 'belongsTo',
                        'column'      => 'role_id',
                        'key'         => 'id',
                        'label'       => 'display_name',
                        'pivot_table' => 'roles',
                        'pivot'       => 0,
                    ],
                    'order'        => 10,
                ],
                'user_belongstomany_role_relationship' => [
                    'type'         => 'relationship',
                    'display_name' => __('voyager::seeders.data_rows.roles'),
                    'required'     => 0,
                    'browse'       => 1,
                    'read'         => 1,
                    'edit'         => 1,
                    'add'          => 1,
                    'delete'       => 0,
                    'details'      => [
                        'model'       => 'TCG\\Voyager\\Models\\Role',
                        'table'       => 'roles',
                        'type'        => 'belongsToMany',
                        'column'      => 'id',
                        'key'         => 'id',
                        'label'       => 'display_name',
                        'pivot_table' => 'user_roles',
                        'pivot'       => '1',
                        'taggable'    => '0',
                    ],
                    'order'        => 11,
                ],
                'users_belongsto_created_user_relationship' => [
                    'type'         => 'relationship',
                    'display_name' => 'Created User',
                    'required'     => 1,
                    'browse'       => 0,
                    'read'         => 1,
                    'edit'         => 0,
                    'add'          => 0,
                    'delete'       => 1,
                    'details'      => [
                        'model'         => 'App\\Models\\User',
                        'table'         => 'users',
                        'type'          => 'belongsTo',
                        'column'        => 'created_by',
                        'key'           => 'id',
                        'label'         => 'name',
                        'pivot_table'   => 'data_rows',
                        'pivot'         => 0,
                        'taggable'      => 0

                    ]
                ],
                'users_belongsto_updated_user_relationship' => [
                    'type'         => 'relationship',
                    'display_name' => 'Updated User',
                    'required'     => 1,
                    'browse'       => 0,
                    'read'         => 1,
                    'edit'         => 0,
                    'add'          => 0,
                    'delete'       => 1,
                    'details'      => [
                        'model'         => 'App\\Models\\User',
                        'table'         => 'users',
                        'type'          => 'belongsTo',
                        'column'        => 'updated_by',
                        'key'           => 'id',
                        'label'         => 'name',
                        'pivot_table'   => 'data_rows',
                        'pivot'         => 0,
                        'taggable'      => 0

                    ]
                ],
                'settings' => [
                    'type'         => 'hidden',
                    'display_name' => 'Settings',
                    'required'     => 0,
                    'browse'       => 0,
                    'read'         => 0,
                    'edit'         => 0,
                    'add'          => 0,
                    'delete'       => 0,
                    'order'        => 12,
                ]
            ],
            'menus' => [
                'id' => [
                    'type'         => 'number',
                    'display_name' => __('voyager::seeders.data_rows.id'),
                    'required'     => 1,
                    'browse'       => 0,
                    'read'         => 0,
                    'edit'         => 0,
                    'add'          => 0,
                    'delete'       => 0,
                    'order'        => 1,
                ],
                'name' => [
                    'type'         => 'text',
                    'display_name' => __('voyager::seeders.data_rows.name'),
                    'required'     => 1,
                    'browse'       => 1,
                    'read'         => 1,
                    'edit'         => 1,
                    'add'          => 1,
                    'delete'       => 1,
                    'order'        => 2,
                ],
                'created_at' => [
                    'type'         => 'timestamp',
                    'display_name' => __('voyager::seeders.data_rows.created_at'),
                    'required'     => 0,
                    'browse'       => 1,
                    'read'         => 1,
                    'edit'         => 0,
                    'add'          => 0,
                    'delete'       => 0,
                    'order'        => 6,
                ],
                'updated_at' => [
                    'type'         => 'timestamp',
                    'display_name' => __('voyager::seeders.data_rows.updated_at'),
                    'required'     => 0,
                    'browse'       => 0,
                    'read'         => 0,
                    'edit'         => 0,
                    'add'          => 0,
                    'delete'       => 0,
                    'order'        => 7,
                ],
            ],
            'roles' => [
                'id' => [
                    'type'         => 'number',
                    'display_name' => __('voyager::seeders.data_rows.id'),
                    'required'     => 1,
                    'browse'       => 0,
                    'read'         => 0,
                    'edit'         => 0,
                    'add'          => 0,
                    'delete'       => 0,
                    'order'        => 1,
                ],
                'name' => [
                    'type'         => 'text',
                    'display_name' => __('voyager::seeders.data_rows.name'),
                    'required'     => 1,
                    'browse'       => 1,
                    'read'         => 1,
                    'edit'         => 1,
                    'add'          => 1,
                    'delete'       => 1,
                    'order'        => 2,
                ],
                'created_at' => [
                    'type'         => 'timestamp',
                    'display_name' => __('voyager::seeders.data_rows.created_at'),
                    'required'     => 0,
                    'browse'       => 1,
                    'read'         => 1,
                    'edit'         => 0,
                    'add'          => 0,
                    'delete'       => 0,
                    'order'        => 6,
                ],
                'updated_at' => [
                    'type'         => 'timestamp',
                    'display_name' => __('voyager::seeders.data_rows.updated_at'),
                    'required'     => 0,
                    'browse'       => 0,
                    'read'         => 0,
                    'edit'         => 0,
                    'add'          => 0,
                    'delete'       => 0,
                    'order'        => 7,
                ],
                'display_name' => [
                    'type'         => 'text',
                    'display_name' => __('voyager::seeders.data_rows.display_name'),
                    'required'     => 1,
                    'browse'       => 1,
                    'read'         => 1,
                    'edit'         => 1,
                    'add'          => 1,
                    'delete'       => 1,
                    'order'        => 5,
                ],
            ]
        ];
    }

    /**
     * [dataRow description].
     *
     * @param [type] $type  [description]
     * @param [type] $field [description]
     *
     * @return [type] [description]
     */
    protected function dataRow($type, $field)
    {
        return DataRow::firstOrNew([
            'data_type_id' => $type->id,
            'field'        => $field,
        ]);
    }
}
