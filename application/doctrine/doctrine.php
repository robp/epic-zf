<?php
// sets which "site" we're working on, including database connection.
$_SERVER['SERVER_NAME'] = 'pinciuc';
include('../global.php');

function my_autoloader($class)
{
    $path = realpath(dirname(__FILE__)) . '/models';
    $basepath = realpath(dirname(__FILE__)) . '/models/Base';

    if (strpos($class, 'Base_') === 0) {
        $filename = $basepath . '/' . substr($class, 5) . '.php';
    }
    else {
        $filename = $path . '/' . $class . '.php';
    }

    if (file_exists($filename)) {
        require_once($filename);
        return true;
    }

    return false;
}

spl_autoload_register('my_autoloader');

$bootstrap = $application->getBootstrap();
$bootstrap->bootstrap('doctrine');
$bootstrap->bootstrap('frontController');
$bootstrap->bootstrap('multisiteModules'); // allows us to use modules in site directories

$config = new Zend_Config_Ini('doctrine.ini', APPLICATION_ENV, TRUE);

$front = Zend_Controller_Front::getInstance();

// TODO: figure out how to load modules in correct order
//$modules = array_keys($front->getDispatcher()->getControllerDirectory());
$modules = array('menu', 'user', 'node', 'path', 'taxonomy', 'comment', 'admin', 'default');
$moduleDirs = array();

$autoloader = Zend_Loader_Autoloader::getInstance();
//$autoloader->registerNamespace('Base_');
//Zend_Debug::dump($autoloader);

if (isset($_SERVER['argv'][1]) && $_SERVER['argv'][1] == 'build-all-reload') {
    // Delete an existing models directory
    echo "Deleting existing models directory... ";
    system("rm -r {$config->models_path}");
    echo "done.\n";

//    echo "Deleting existing fixtures directory... ";
//    system("rm -r {$config->data_fixtures_path}");
//    echo "done.\n";

    // Build our schema.yml file.
    $schema = '';
    if (file_exists($config->yaml_schema_path . '.tpl')) {
        $schema .= file_get_contents($config->yaml_schema_path . '.tpl');
    }

    // Build our data.yml file.

    foreach ($modules as $module) {
        $moduleDir = $front->getModuleDirectory($module);
//        echo "Front->getmoduledir: " . $front->getModuleDirectory($module) . "\n";
        $yamlSchema = $moduleDir . DIRECTORY_SEPARATOR . 'doctrine' . DIRECTORY_SEPARATOR . $config->yaml_schema_path;
//        $fixtureDir = $moduleDir . DIRECTORY_SEPARATOR . 'doctrine' . DIRECTORY_SEPARATOR . $config->data_fixtures_path;
        $moduleDirs[$module] = $moduleDir;

        if (file_exists($yamlSchema)) {
            echo "Found yaml schema file for module '$module'.\n";
            $schema .= "\n\n" . file_get_contents($yamlSchema);
        }
//        if (file_exists($fixtureDir)) {
//            echo "Copying fixtures from $fixtureDir to $config->data_fixtures_path\n";
//            copyFixtures($fixtureDir, dirname(__FILE__) . DIRECTORY_SEPARATOR . $config->data_fixtures_path, $module);
//        }
    }

    echo "Writing merged yaml schema file... ";
    $fp = fopen($config->yaml_schema_path, 'w');
    fwrite($fp, $schema);
    fclose($fp);
    echo "done.\n";
}

echo "\nExecuting Doctrine...\n\n";
$cli = new Doctrine_Cli($config->toArray());

if (isset($_SERVER['argv'][1]) && $_SERVER['argv'][1] == 'build-all-reload') {
    echo "Rebuilding database...\n";
    $cli->run(array('./doctrine', 'rebuild-db'));
    $data_fixtures_path = $config->data_fixtures_path;
    foreach ($modules as $module) {
        $moduleDir = $moduleDirs[$module];
        $fixtureDir = $moduleDir . DIRECTORY_SEPARATOR . 'doctrine' . DIRECTORY_SEPARATOR . $data_fixtures_path;
//        echo "fixtureDir = $fixtureDir\n";
        if (file_exists($fixtureDir)) {
            echo "Loading data for module '$module'...\n";
            $config->data_fixtures_path = $fixtureDir;
            $cli = new Doctrine_Cli($config->toArray());
            $cli->run(array('./doctrine', 'load-data', 'true'));
        }
    }
    // reset this
    $config->data_fixtures_path = $data_fixtures_path;
}
else {
    $cli->run($_SERVER['argv']);
}

if (isset($_SERVER['argv'][1]) && $_SERVER['argv'][1] == 'build-all-reload') {
    // Now we need to fix the generated Base class names inside those files.
    echo "\nFixing Base model class names... ";
    fixModels($config->models_path);
    fixModels($config->models_path . DIRECTORY_SEPARATOR . 'Base');
    echo "done.\n";


    // Now we need to move the generated models to the model directories.
    echo "\nCopying models to module locations... ";
    copyModels($config->models_path, TRUE);
    copyModels($config->models_path . DIRECTORY_SEPARATOR . 'Base');
    echo "done.\n";
}

echo "\n";

// -------------------
// functions
// -------------------

function copyFixtures($src, $dest, $module) {
    chdir($src);
    $files = scandir('.');
    foreach ($files as $file) {
        $pathinfo = pathinfo($file);
        if ($pathinfo['extension'] == 'yml') {
            $destFile = $module . '-' . $file;
            $target = $dest . DIRECTORY_SEPARATOR . $destFile;
            if (!file_exists(dirname($target))) {
                mkdir(dirname($target), 0777, TRUE);
            }
//            echo "$target... ";
            copy($file, $target);
//            echo "ok\n";
        }
    }
    chdir(dirname(__file__));
}

function copyModels($path, $check = FALSE) {
    global $moduleDirs;
    chdir(dirname(__file__) . DIRECTORY_SEPARATOR . $path);
    $files = scandir('.');

    foreach ($files as $file) {
        $components = explode('_', $file);
        if (count($components) >= 3 && $components[1] == 'Model') {
            $moduleName = strtolower($components[0]);
            $modelDir = $moduleDirs[$moduleName] . DIRECTORY_SEPARATOR . $path;
            $target = implode(DIRECTORY_SEPARATOR, array_merge(array($modelDir), array_slice($components, 2)));
            if (!file_exists(dirname($target))) {
                mkdir(dirname($target), 0777, TRUE);
            }
            if (!$check || strstr($file, 'Table.php') || !file_exists($target)) {
//                echo "$target... ";
                copy($file, $target);
//                echo "ok\n";
            }
        }
    }
    chdir(dirname(__file__));
}

function fixModels($path) {
    global $moduleDirs;
    chdir(dirname(__file__) . DIRECTORY_SEPARATOR . $path);
    $files = scandir('.');

    foreach ($files as $file) {
        $info = pathinfo($file);
        $components = explode('_', $info['filename']);
        if (count($components) >= 3 && $components[1] == 'Model') {
            $search = implode('_', array_merge(array('Base'), $components));
            $replace = implode('_', array($components[0], $components[1], 'Base')) . '_' . implode('_', array_slice($components, 2));
//            echo "$file: $search becomes $replace... ";
            $contents = file_get_contents($file);
            $contents = str_replace($search, $replace, $contents);
            $fp = fopen($file, 'w');
            fwrite($fp, $contents);
            fclose($fp);
//            echo "ok\n";
        }
    }
    chdir(dirname(__file__));
}
