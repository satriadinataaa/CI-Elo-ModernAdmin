<?php
/**
 * This is project's console commands configuration for Robo task runner.
 *
 * @see http://robo.li/
 */

class RoboFile extends \Robo\Tasks
{
    private $host;
    private $dbname;
    private $username;
    private $password;
    private $pdo;

    public function __construct()
    {
        $this->host     = 'localhost';
        $this->dbname   = 'db_amr';
        $this->username = 'root';
        $this->password = '';
    }

    public function push($commitMessage, $origin = "origin", $branch = "master")
    {
        $this->say("Pushing code to repository...");
        $this->taskGitStack()
            ->stopOnFail()
            ->add('.')
            ->commit($commitMessage)
            ->push($origin, $branch)
            ->run();
    }

    public function test()
    {
        echo 'Robo installed';

        $this->connect_to_db();
        $columnUsage = $this->get_fk('pengguna');
        var_dump($columnUsage);
    }

    public function clear_models()
    {
        $models = scandir('./application/models');
        $models = array_diff($models, ['.', '..', 'index.html']);
        foreach ($models as $model)
        {
            @unlink('./application/models/' . $model);
        }
    }

    public function generate_models()
    {
        $this->connect_to_db();
        $sql = 'SHOW TABLES';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $tables = $stmt->fetchAll(PDO::FETCH_NUM);
        foreach ($tables as $table)
        {
            $sql = 'SHOW KEYS FROM ' . $table[0] . ' WHERE Key_name = \'PRIMARY\'';
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            $key = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->write_model($table[0], $key['Column_name']);
        }
    }

    private function write_model($table, $primaryKey)
    {
        $className = ucfirst($table) . '_m';
        $ref = $this->taskWriteToFile('./application/models/' . $className . '.php')
            ->line('<?php')
            ->line('defined(\'BASEPATH\') OR exit(\'No direct script access allowed\');')
            ->line('')
            ->line('use Illuminate\Database\Eloquent\Model as Eloquent;')
            ->line('')
            ->line('class ' . $className . ' extends Eloquent')
            ->line('{')
            ->line('    protected $table        = \'' . $table . '\';')
            ->line('    protected $primaryKey   = \'' . $primaryKey . '\';')
            ->line('');

        $fks = $this->get_fk($table);
        foreach ($fks as $fk)
        {
            $this->define_relationship($ref, [
                'table'             => $fk['REFERENCED_TABLE_NAME'],
                'class_name'        => ucfirst($fk['REFERENCED_TABLE_NAME']) . '_m',
                'local_key'         => $fk['REFERENCED_COLUMN_NAME'],
                'referenced_key'    => $fk['COLUMN_NAME']
            ]);            
        }
        
        $ref->line('}')
            ->run();
    }

    private function define_relationship(&$ref, $relationship)
    {
        $ref->line('    public function ' . $relationship['table'] . '()')
            ->line('    {')
            ->line('        require_once __DIR__ . \'/' . $relationship['class_name'] . '.php\';')
            ->line('        return $this->hasOne(\'' . $relationship['class_name'] . '\', \'' . $relationship['local_key'] . '\', \'' . $relationship['referenced_key'] . '\');')
            ->line('    }')
            ->line('');
    }

    private function get_fk($table)
    {
        $sql = 'SELECT 
                    TABLE_SCHEMA, TABLE_NAME,COLUMN_NAME,CONSTRAINT_NAME, REFERENCED_TABLE_NAME,REFERENCED_COLUMN_NAME
                FROM
                    INFORMATION_SCHEMA.KEY_COLUMN_USAGE
                WHERE 
                    TABLE_SCHEMA = \'' . $this->dbname . '\'
                    AND TABLE_NAME = \'' . $table . '\'
                    AND REFERENCED_TABLE_NAME IS NOT NULL';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    private function connect_to_db()
    {
        $this->pdo = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->dbname, $this->username, $this->password);
    }

    public function generate_crud_snippet($name, $table)
    {
        $this->connect_to_db();
        $columns = $this->get_columns($table);
        $className = ucfirst($name);
        $ref = $this->taskWriteToFile('./application/controllers/' . $className . '.php')
            ->line('<?php')
            ->line('defined(\'BASEPATH\') OR exit(\'No direct script access allowed\');')
            ->line('')
            ->line('class ' . $className . ' extends MY_Controller')
            ->line('{')
            ->line('');

        $this->generate_read($ref, $name, $table, $columns);
        $this->generate_detail($ref, $name, $table, $columns);
        $this->generate_add($ref, $name, $table, $columns);
        $this->generate_edit($ref, $name, $table, $columns);

        $ref->line('}')
            ->run();
    }

    private function generate_read(&$ref, $name, $table, $columns)
    {
        $modelName = ucfirst($table) . '_m';
        $ref->line('    public function ' . $table . '()')
            ->line('    {')
            ->line('        $this->data[\'' . $columns[0]['COLUMN_NAME'] . '\'] = $this->uri->segment(3);')
            ->line('        $this->load->model(\'' . $modelName . '\');')
            ->line('        if (isset($this->data[\'' . $columns[0]['COLUMN_NAME'] . '\']))')
            ->line('        {')
            ->line('            $data = ' . $modelName . '::find($this->data[\'' . $columns[0]['COLUMN_NAME'] . '\']);')
            ->line('            $data->delete();')
            ->line('            $this->flashmsg(\'Data successfully deleted\');')
            ->line('            redirect(\'' . $name . '/' . $table . '\');')
            ->line('        }')
            ->line('')
            ->line('        $this->data[\'' . $table . '\'] = ' . $modelName . '::get();')
            ->line('        $this->data[\'title\'] = \'' . ucwords(str_replace('_', ' ', $table)) . '\';')
            ->line('        $this->data[\'content\'] = \'' . $table . '\';')
            ->line('        $this->template($this->data, $this->module);')
            ->line('    }')
            ->line('');
    }

    private function generate_detail(&$ref, $name, $table, $columns)
    {
        $modelName = ucfirst($table) . '_m';
        $ref->line('    public function detail_' . $table . '()')
            ->line('    {')
            ->line('        $this->data[\'' . $columns[0]['COLUMN_NAME'] . '\'] = $this->uri->segment(3);')
            ->line('        $this->check_allowance(!isset($this->data[\'' . $columns[0]['COLUMN_NAME'] . '\']));')
            ->line('')
            ->line('        $this->load->model(\'' . $modelName . '\');')
            ->line('        $this->data[\'' . $table . '\'] = ' . $modelName . '::find($this->data[\'' . $columns[0]['COLUMN_NAME'] . '\']);')
            ->line('        $this->check_allowance(!isset($this->data[\'' . $table . '\']), [\'Data not found\', \'danger\']);')
            ->line('        $this->data[\'title\'] = \'Detail ' . ucwords(str_replace('_', ' ', $table)) . '\';')
            ->line('        $this->data[\'content\'] = \'detail_' . $table . '\';')
            ->line('        $this->template($this->data, $this->module);')
            ->line('    }')
            ->line('');
    }

    private function generate_add(&$ref, $name, $table, $columns)
    {
        $modelName = ucfirst($table) . '_m';
        $ref->line('    public function add_' . $table . '()')
            ->line('    {')
            ->line('        $this->load->model(\'' . $modelName . '\');')
            ->line('        if ($this->POST(\'submit\'))')
            ->line('        {')
            ->line('            $' . $table . ' = new ' . $modelName . '();');

        $blacklistedColumns = ['created_at', 'updated_at'];
        foreach ($columns as $column)
        {
            $column = $column['COLUMN_NAME'];
            if (in_array($column, $blacklistedColumns))
            {
                continue;
            }
            $ref->line('            $' . $table . '->' . $column . ' = $this->POST(\'' . $column . '\');');
        }

        $ref->line('            $' . $table . '->save();')
            ->line('            $this->flashmsg(\'Data successfully added\');')
            ->line('            redirect(\'' . $name . '/add_' . $table . '\');')
            ->line('        }')
            ->line('')
            ->line('        $this->data[\'title\'] = \'Add ' . ucwords(str_replace('_', ' ', $table)) . '\';')
            ->line('        $this->data[\'content\'] = \'add_' . $table . '\';')
            ->line('        $this->template($this->data, $this->module);')
            ->line('    }')
            ->line('');        
    }

    private function generate_edit(&$ref, $name, $table, $columns)
    {
        $modelName = ucfirst($table) . '_m';
        $ref->line('    public function edit_' . $table . '()')
            ->line('    {')
            ->line('        $this->data[\'' . $columns[0]['COLUMN_NAME'] . '\'] = $this->uri->segment(3);')
            ->line('        $this->check_allowance(!isset($this->data[\'' . $columns[0]['COLUMN_NAME'] . '\']));')
            ->line('')
            ->line('        $this->load->model(\'' . $modelName . '\');')
            ->line('        $this->data[\'' . $table . '\'] = ' . $modelName . '::find($this->data[\'' . $columns[0]['COLUMN_NAME'] . '\']);')
            ->line('        $this->check_allowance(!isset($this->data[\'' . $table . '\']), [\'Data not found\', \'danger\']);')
            ->line('')
            ->line('        if ($this->POST(\'submit\'))')
            ->line('        {');

        foreach ($columns as $column)
        {
            $column = $column['COLUMN_NAME'];
            $ref->line('            $this->data[\'' . $table . '\']->' . $column . ' = $this->POST(\'' . $column . '\');');
        }

        $ref->line('            $this->data[\'' . $table . '\']->save();')
            ->line('            $this->flashmsg(\'Data successfully edited\');')
            ->line('            redirect(\'' . $name . '/edit_' . $table . '/\' . $this->data[\'' . $columns[0]['COLUMN_NAME'] . '\']);')
            ->line('        }')
            ->line('')
            ->line('        $this->data[\'title\'] = \'Edit ' . ucwords(str_replace('_', ' ', $table)) . '\';')
            ->line('        $this->data[\'content\'] = \'edit_' . $table . '\';')
            ->line('        $this->template($this->data, $this->module);')
            ->line('    }')
            ->line('');        
    }

    private function get_columns($table)
    {
        $sql = 'SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = \'' . $this->dbname . '\' AND TABLE_NAME = \'' . $table . '\'';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function pp($commitMessage, $origin = "origin", $branch = "master")
    {
        $this->say("Pushing code to repository...");
        $this->taskGitStack()
            ->stopOnFail()
            ->add('.')
            ->commit($commitMessage)
            ->pull($origin, $branch)
            ->push($origin, $branch)
            ->run();
    }
}