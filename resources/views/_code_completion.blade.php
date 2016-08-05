{!! $open !!}
@if($blueprint)
namespace Illuminate\Database\Schema {

interface BlueprintFluent
{
    /**
     *
     * @return BlueprintFluent
    */
    public function first();

    /**
    *
    * @return BlueprintFluent
    */
    public function after($column);

    /**
    *
    * @return BlueprintFluent
    */
    public function nullable();

    /**
    * @return BlueprintFluent
    *
    */
    public function default($value);

    /**
    *
    * @return BlueprintFluent
    */
    public function unsigned();

    /**
    *
    * @return BlueprintFluent
    */
    public function change();

    /**
    *
    * @return BlueprintFluent
    */
    public function unique();
    }

    interface BlueprintForeignFluent
    {
    /**
    *
    * @return BlueprintForeignReferencesFluent
    */
    public function references($column);
    }

    interface BlueprintForeignReferencesFluent
    {
    /**
    *
    * @param $table
    *
    * @return \Illuminate\Database\Schema\BlueprintForeignReferencesOnFluent
    */
    public function on($table);
    }

    interface BlueprintForeignReferencesOnFluent
    {
    /** @return BlueprintForeignReferencesOnFluent */
    public function onDelete($arg);

    /** @return BlueprintForeignReferencesOnFluent */
    public function onUpdate($arg);
    }

    class Blueprint
    {

    /**
    * Create a new char column on the table.
    *
    * @param  string  $column
    * @param  int  $length
    * @return BlueprintFluent
    */
    public function char($column, $length = 255)
    {
    return $this->addColumn('char', $column, compact('length'));
    }

    /**
    * Create a new string column on the table.
    *
    * @param  string  $column
    * @param  int  $length
    * @return BlueprintFluent
    */
    public function string($column, $length = 255)
    {
    return $this->addColumn('string', $column, compact('length'));
    }

    /**
    * Create a new text column on the table.
    *
    * @param  string  $column
    * @return BlueprintFluent
    */
    public function text($column)
    {
    return $this->addColumn('text', $column);
    }

    /**
    * Create a new medium text column on the table.
    *
    * @param  string  $column
    * @return BlueprintFluent
    */
    public function mediumText($column)
    {
    return $this->addColumn('mediumText', $column);
    }

    /**
    * Create a new long text column on the table.
    *
    * @param  string  $column
    * @return BlueprintFluent
    */
    public function longText($column)
    {
    return $this->addColumn('longText', $column);
    }

    /**
    * Create a new integer (4-byte) column on the table.
    *
    * @param  string  $column
    * @param  bool  $autoIncrement
    * @param  bool  $unsigned
    * @return BlueprintFluent
    */
    public function integer($column, $autoIncrement = false, $unsigned = false)
    {
    return $this->addColumn('integer', $column, compact('autoIncrement', 'unsigned'));
    }

    /**
    * Create a new tiny integer (1-byte) column on the table.
    *
    * @param  string  $column
    * @param  bool  $autoIncrement
    * @param  bool  $unsigned
    * @return BlueprintFluent
    */
    public function tinyInteger($column, $autoIncrement = false, $unsigned = false)
    {
    return $this->addColumn('tinyInteger', $column, compact('autoIncrement', 'unsigned'));
    }

    /**
    * Create a new small integer (2-byte) column on the table.
    *
    * @param  string  $column
    * @param  bool  $autoIncrement
    * @param  bool  $unsigned
    * @return BlueprintFluent
    */
    public function smallInteger($column, $autoIncrement = false, $unsigned = false)
    {
    return $this->addColumn('smallInteger', $column, compact('autoIncrement', 'unsigned'));
    }

    /**
    * Create a new medium integer (3-byte) column on the table.
    *
    * @param  string  $column
    * @param  bool  $autoIncrement
    * @param  bool  $unsigned
    * @return BlueprintFluent
    */
    public function mediumInteger($column, $autoIncrement = false, $unsigned = false)
    {
    return $this->addColumn('mediumInteger', $column, compact('autoIncrement', 'unsigned'));
    }

    /**
    * Create a new big integer (8-byte) column on the table.
    *
    * @param  string  $column
    * @param  bool  $autoIncrement
    * @param  bool  $unsigned
    * @return BlueprintFluent
    */
    public function bigInteger($column, $autoIncrement = false, $unsigned = false)
    {
    return $this->addColumn('bigInteger', $column, compact('autoIncrement', 'unsigned'));
    }

    /**
    * Create a new unsigned tiny integer (1-byte) column on the table.
    *
    * @param  string  $column
    * @param  bool  $autoIncrement
    * @return BlueprintFluent
    */
    public function unsignedTinyInteger($column, $autoIncrement = false)
    {
    return $this->tinyInteger($column, $autoIncrement, true);
    }

    /**
    * Create a new unsigned small integer (2-byte) column on the table.
    *
    * @param  string  $column
    * @param  bool  $autoIncrement
    * @return BlueprintFluent
    */
    public function unsignedSmallInteger($column, $autoIncrement = false)
    {
    return $this->smallInteger($column, $autoIncrement, true);
    }

    /**
    * Create a new unsigned medium integer (3-byte) column on the table.
    *
    * @param  string  $column
    * @param  bool  $autoIncrement
    * @return BlueprintFluent
    */
    public function unsignedMediumInteger($column, $autoIncrement = false)
    {
    return $this->mediumInteger($column, $autoIncrement, true);
    }

    /**
    * Create a new unsigned integer (4-byte) column on the table.
    *
    * @param  string  $column
    * @param  bool  $autoIncrement
    * @return BlueprintFluent
    */
    public function unsignedInteger($column, $autoIncrement = false)
    {
    return $this->integer($column, $autoIncrement, true);
    }

    /**
    * Create a new unsigned big integer (8-byte) column on the table.
    *
    * @param  string  $column
    * @param  bool  $autoIncrement
    * @return BlueprintFluent
    */
    public function unsignedBigInteger($column, $autoIncrement = false)
    {
    return $this->bigInteger($column, $autoIncrement, true);
    }

    /**
    * Create a new float column on the table.
    *
    * @param  string  $column
    * @param  int     $total
    * @param  int     $places
    * @return BlueprintFluent
    */
    public function float($column, $total = 8, $places = 2)
    {
    return $this->addColumn('float', $column, compact('total', 'places'));
    }

    /**
    * Create a new double column on the table.
    *
    * @param  string   $column
    * @param  int|null    $total
    * @param  int|null $places
    * @return BlueprintFluent
    */
    public function double($column, $total = null, $places = null)
    {
    return $this->addColumn('double', $column, compact('total', 'places'));
    }

    /**
    * Create a new decimal column on the table.
    *
    * @param  string  $column
    * @param  int     $total
    * @param  int     $places
    * @return BlueprintFluent
    */
    public function decimal($column, $total = 8, $places = 2)
    {
    return $this->addColumn('decimal', $column, compact('total', 'places'));
    }

    /**
    * Create a new boolean column on the table.
    *
    * @param  string  $column
    * @return BlueprintFluent
    */
    public function boolean($column)
    {
    return $this->addColumn('boolean', $column);
    }

    /**
    * Create a new enum column on the table.
    *
    * @param  string  $column
    * @param  array   $allowed
    * @return BlueprintFluent
    */
    public function enum($column, array $allowed)
    {
    return $this->addColumn('enum', $column, compact('allowed'));
    }

    /**
    * Create a new json column on the table.
    *
    * @param  string  $column
    * @return BlueprintFluent
    */
    public function json($column)
    {
    return $this->addColumn('json', $column);
    }

    /**
    * Create a new jsonb column on the table.
    *
    * @param  string  $column
    * @return BlueprintFluent
    */
    public function jsonb($column)
    {
    return $this->addColumn('jsonb', $column);
    }

    /**
    * Create a new date column on the table.
    *
    * @param  string  $column
    * @return BlueprintFluent
    */
    public function date($column)
    {
    return $this->addColumn('date', $column);
    }

    /**
    * Create a new date-time column on the table.
    *
    * @param  string  $column
    * @return BlueprintFluent
    */
    public function dateTime($column)
    {
    return $this->addColumn('dateTime', $column);
    }

    /**
    * Create a new date-time column (with time zone) on the table.
    *
    * @param  string  $column
    * @return BlueprintFluent
    */
    public function dateTimeTz($column)
    {
    return $this->addColumn('dateTimeTz', $column);
    }

    /**
    * Create a new time column on the table.
    *
    * @param  string  $column
    * @return BlueprintFluent
    */
    public function time($column)
    {
    return $this->addColumn('time', $column);
    }

    /**
    * Create a new time column (with time zone) on the table.
    *
    * @param  string  $column
    * @return BlueprintFluent
    */
    public function timeTz($column)
    {
    return $this->addColumn('timeTz', $column);
    }

    /**
    * Create a new timestamp column on the table.
    *
    * @param  string  $column
    * @return BlueprintFluent
    */
    public function timestamp($column)
    {
    return $this->addColumn('timestamp', $column);
    }

    /**
    * Create a new timestamp (with time zone) column on the table.
    *
    * @param  string  $column
    * @return BlueprintFluent
    */
    public function timestampTz($column)
    {
    return $this->addColumn('timestampTz', $column);
    }


    /**
    * Specify a foreign key for the table.
    *
    * @param  string|array  $columns
    * @param  string  $name
    * @return BlueprintForeignFluent
    */
    public function foreign($columns, $name = null)
    {
    return $this->indexCommand('foreign', $columns, $name);
    }

    }
}
@endif