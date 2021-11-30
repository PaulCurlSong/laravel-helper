<?php 
namespace MingYu\LaravelHelper\Services;

use HelloBase\Putter as HelloBasePutter;
use HelloBase\Table as HelloBaseTable;
use HelloBase\Connection as HelloBaseConnection;
use Hbase\Mutation;

class HBaseService extends HelloBaseConnection
{
    public function __construct($config)
    {
        parent::__construct($config);
        parent::connect();
    }

    public function table($name): HelloBaseTable
    {
        return new Table($name, $this);
    }
}

class Table extends HelloBaseTable
{
    public function batchPut(array $values): bool
    {
        try {
            $putter = new Putter($this);
            $putter->batchPick($values);
            return $putter->send() > 0;
        } catch (Exception $exception) {
            throw $exception;
        }
    }
}

class Putter extends HelloBasePutter
{
    public function batchPick(array $data)
    {
        foreach ($data as $row => $columns) {
          
            if (!isset($this->mutations[$row])) {
                $this->mutations[$row] = [];
            }
            
            foreach ($columns as $column => $value) {
                $this->mutations[$row][] = new Mutation([
                    'column' => $column,
                    'value' => $value,
                    'isDelete' => false
                ]);
            }
        }
    }
}
}