<?php

namespace KitLoong\MigrationsGenerator\Repositories;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use KitLoong\MigrationsGenerator\Repositories\Entities\MySQL\ShowColumn;

class MySQLRepository extends Repository
{
    /**
     * Show column by table and column name.
     *
     * @param  string  $table  Table name.
     * @param  string  $column  Column name.
     * @return \KitLoong\MigrationsGenerator\Repositories\Entities\MySQL\ShowColumn|null
     */
    public function showColumn(string $table, string $column): ?ShowColumn
    {
        $result = DB::selectOne("SHOW COLUMNS FROM `$table` where Field = '$column'");
        return $result === null ? null : new ShowColumn($result);
    }

    /**
     * Get enum values.
     *
     * @param  string  $table  Table name.
     * @param  string  $column  Column name.
     * @return \Illuminate\Support\Collection<string>
     */
    public function getEnumPresetValues(string $table, string $column): Collection
    {
        $result = DB::selectOne("SHOW COLUMNS FROM `$table` where Field = '$column' AND Type LIKE 'enum(%'");
        if ($result === null) {
            return new Collection();
        }

        $showColumn = new ShowColumn($result);
        $value      = substr(
            str_replace('enum(\'', '', $showColumn->getType()),
            0,
            -2
        );
        return new Collection(explode("','", $value));
    }

    /**
     * Get set values.
     *
     * @param  string  $table  Table name.
     * @param  string  $column  Column name.
     * @return \Illuminate\Support\Collection<string>
     */
    public function getSetPresetValues(string $table, string $column): Collection
    {
        $result = DB::selectOne("SHOW COLUMNS FROM `$table` where Field = '$column' AND Type LIKE 'set(%'");
        if ($result === null) {
            return new Collection();
        }

        $showColumn = new ShowColumn($result);
        $value      = substr(
            str_replace('set(\'', '', $showColumn->getType()),
            0,
            -2
        );
        return new Collection(explode("','", $value));
    }

    /**
     * Checks if column has `on update CURRENT_TIMESTAMP`
     *
     * @param  string  $table  Table name.
     * @param  string  $column  Column name.
     * @return bool
     */
    public function isOnUpdateCurrentTimestamp(string $table, string $column): bool
    {
        // MySQL5.7 shows "on update CURRENT_TIMESTAMP"
        // MySQL8 shows "DEFAULT_GENERATED on update CURRENT_TIMESTAMP"
        $result = DB::selectOne(
            "SHOW COLUMNS FROM `$table`
                WHERE Field = '$column'
                    AND Type = 'timestamp'
                    AND EXTRA LIKE '%on update CURRENT_TIMESTAMP%'"
        );
        return !($result === null);
    }
}
