<?php
namespace app\gui;

class View {
    /**
     * Location of view templates.
     *
     * @var string
     */
    public $path;

    /**
     * File extension.
     *
     * @var string
     */
    public $extension = '.html';

    /**
     * View variables.
     *
     * @var array
     */
    protected $vars = array();

    /**
     * Template file.
     *
     * @var string
     */
    private $tpl;

    /**
     * Template cache.
     *
     * @var string
     */
    public $cache;

    /**
     * Template cache time.
     *
     * @var string
     */
    public $cacheTime;

    /**
     * Template replace.
     *
     * @var string
     */
    private $system_replace = array(
        '~\{(\$[a-z0-9_]+)\}~i' => '<?php echo $1 ?>',
        # {$name}
        '~\{(\$[a-z0-9_]+)\.([a-z0-9_]+)\}~i' => '<?php echo $1[\'$2\'] ?>',
        # {$arr.key}
        '~\{(\$[a-z0-9_]+)\.([a-z0-9_]+)\.([a-z0-9_]+)\}~i' => '<?php echo $1[\'$2\'][\'$3\'] ?>',
        # {$arr.key.key2}
        '~\{(include_once|require_once|include|require)\s*\(\s*(.+?)\s*\)\s*\s*\}~i' => '<?php include \$this->_include($2, __FILE__) ?>',
        # {include('inc/top.php')}
        '~\{:(.+?)\}~' => '<?php echo $1 ?>',
        # {:strip_tags($a)}
        '~\{\~(.+?)\}~' => '<?php $1 ?>',
        # {~var_dump($a)}
        '~<\?=\s*~' => '<?php echo ',
        # <?=
        '~\{loop\s+(\S+)\s+(\S+)\}~' => '<?php if(is_array(\\1)) foreach(\\1 as \\2) { ?>',
        # {loop $array $vaule}
        '~\{loop\s+(\S+)\s+(\S+)\s+(\S+)\}~' => '<?php if(is_array(\\1)) foreach (\\1 as \\2 => \\3) { ?>',
        # {loop $array $key $value}
        '~\{\/loop\}~' => '<?php } ?>',
        # {/loop}
        '~\{if\s+(.+?)\}~' => '<?php if (\\1) { ?>',
        # {if condition}
        '~\{elseif\s+(.+?)\}~' => '<?php }elseif(\\1){ ?>',
        # {elseif condition}
        '~\{else\}~' => '<?php }else{ ?>',
        # {else}
        '~\{\/if\}~' => '<?php } ?>',
        # {/if}
    );

    /**
     * Constructor.
     *
     * @param string $path Path to templates directory
     */
    public function __construct($path = '.') {
        $this->path = $path;
    }

    /**
     * Gets a template variable.
     *
     * @param string $key Key
     * @return mixed Value
     */
    public function get($key) {
        return isset($this->vars[$key]) ? $this->vars[$key] : null;
    }

    /**
     * Sets a template variable.
     *
     * @param mixed $key Key
     * @param string $value Value
     */
    public function set($key, $value = null) {
        if (is_array($key) || is_object($key)) {
            foreach ($key as $k => $v) {
                $this->vars[$k] = $v;
            }
        }
        else {
            $this->vars[$key] = $value;
        }
    }

    /**
     * Checks if a template variable is set.
     *
     * @param string $key Key
     * @return boolean If key exists
     */
    public function has($key) {
        return isset($this->vars[$key]);
    }

    /**
     * Unsets a template variable. If no key is passed in, clear all variables.
     *
     * @param string $key Key
     */
    public function clear($key = null) {
        if (is_null($key)) {
            $this->vars = array();
        }
        else {
            unset($this->vars[$key]);
        }
    }

    /**
     * Renders a template.
     *
     * @param string $file Template file
     * @param array $data Template data
     * @throws \Exception If template not found
     */
    public function render($file, $data = null) {
        $this->tpl = $this->getXhtml($file);

        if (!file_exists($this->tpl)) {
            throw new \Exception("Template file not found: {$this->tpl}.");
        }

        if (is_array($data)) {
            $this->vars = array_merge($this->vars, $data);
        }

        extract($this->vars);

        if(!preg_match("/^[A-Za-z0-9_\-\:\/\\\]+$/", $this->cache)) {
            throw new \Exception("Template cache dir not found: {__DIR__}.");
        };

        if(!is_dir($this->cache)) {
            $this->mkdirs($this->cache);
        }

        $tmpPath = $this->cache.'/'.md5(str_replace('/', '_', $this->tpl).'iO%F3@tc#UG&c3*Io$ec!dk').$this->extension;
        if (!$this->isCached($tmpPath)) {
            $tpl = preg_replace(array_keys($this->system_replace), $this->system_replace, @file_get_contents($this->tpl));
            @file_put_contents($tmpPath, $tpl, LOCK_EX);
        }

        include $tmpPath;
    }

    /**
     * Gets the full path to a template file.
     *
     * @param string $file Template file
     * @return string Template file location
     */
    public function isCached($path) {
        if (!file_exists($path)) {
            return false;
        }
        $cacheTime = $this->cacheTime;
        if ($cacheTime < 0) {
            return true;
        }
        if (time() - filemtime($path) > $cacheTime) {
            return false;
        }
        return true;
    }

    /**
     * Gets the output of a template.
     *
     * @param string $file Template file
     * @param array $data Template data
     * @return string Output of template
     */
    public function fetch($file, $data = null) {
        ob_start();

        $this->render($file, $data);
        $output = ob_get_clean();

        return $output;
    }

    /**
     * Checks if a template file exists.
     *
     * @param string $file Template file
     * @return bool Template file exists
     */
    public function exists($file) {
        return file_exists($this->getXhtml($file));
    }

    /**
     * Gets the full path to a template file.
     *
     * @param string $file Template file
     * @return string Template file location
     */
    public function getXhtml($file) {
        $ext = $this->extension;

        if (!empty($ext) && (substr($file, -1 * strlen($ext)) != $ext)) {
            $file .= $ext;
        }

        if ((substr($file, 0, 1) == '/')) {
            return $file;
        }
        
        return $this->path.'/'.$file;
    }

    /**
     * Create Cache Template Directory.
     *
     * @param string $path Template Directory
     * @return string Template Directory location
     */
    private function mkdirs($path) {
        if(!is_dir($path)) {
            $this->mkdirs(dirname($path));
            if(!mkdir($path, 0755)) {
                return false;
            }
        }
        return true;
    }

    /**
     * Displays escaped output.
     *
     * @param string $str String to escape
     * @return string Escaped string
     */
    public function e($str) {
        echo htmlentities($str);
    }
}
