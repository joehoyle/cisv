<?php
class WCache
{
	var $defmod=0755;
	var $surephp5=false;

	function WCache($path, $disable=false, $disable_output=false)
	{
		if(function_exists("version_compare"))$this->surephp5=version_compare(PHP_VERSION, '5.0.0', '>=');
		if(!is_dir($path))
		{
			$this->do_mkdir($path, $this->defmod);
			$disable=!is_dir($path);
		}
		if(!$disable && !is_writable($path))
		{
			@chmod($path, $this->defmod);
			$disable=!is_writable($path);
		}

		if(!in_array(substr($path,-1),array("\\","/"))) $path.="/";

		$this->path = $path;
		$this->disable = $disable;
		$this->disable_output = $disable_output;
		$this->stack = array();
		$this->output = null;
	}

	function _output($output)
	{
		$this->output = $output;
		if(!$this->disable_output) echo $output;
	}

	function _load($file, $time)
	{
		if($this->disable) return false;
		$filename = $this->path.$file;

		if(!file_exists($filename)) return false;
		if(time()-filemtime($filename)>$time) return false;

		return @file_get_contents($filename);
	}

	function _start($file, $time)
	{

		$data = $this->_load($file,$time);
		if($data===false)
		{
			$this->stack[count($this->stack)] = $file;
			if(!$this->disable_output)ob_start();
			return count($this->stack);
		}

		$data = $this->_unpack($data);
		$this->_output($data['__output__']);

		return $data;
	}

	function _unpack($data)
	{
		return unserialize($data);
	}

	function _pack($data)
	{
		return serialize($data);
	}

	function _getfsname($name)
	{
		return md5($name);
	}

	function mkdir_recursive($pathname, $mode)
	{
		is_dir(dirname($pathname)) || mkdir_recursive(dirname($pathname), $mode);
		return is_dir($pathname) || @mkdir($pathname, $mode);
	}

	function do_mkdir($pathname, $mode)
	{
		if($this->surephp5)@mkdir($pathname, $mode, true);
		else $this->mkdir_recursive($pathname, $mode);
	}

	function _formatfile($file, $group=false)
	{
		if(!is_string($file))$file=serialize($file);
		$file=$this->_getfsname($file);
		if($group)
		{
			if(!is_string($group))$group=serialize($group);
			$subdir=$this->_getfsname($group);
			if(!is_dir($this->path.$subdir))
			{
				$this->do_mkdir($this->path.$subdir, $this->defmod);
			}
			$file=$subdir."/".$file;
		}
		return $file;
	}

	function save($file, $time, $data=array(), $group=false)
	{
		if($this->disable) return false;

		$file=$this->_formatfile($file, $group);

		$time = intval($time);
		if($time < 3) $time=3;

		if(count($this->stack) && $file == $this->stack[count($this->stack)-1])
		{
			$filename = $this->path.$file;

			if(!$this->disable_output)
			{
				$data['__output__'] = ob_get_contents();
				ob_end_clean();
			}

			if(file_exists($filename) && !is_writable($filename))
			{
				trigger_error("Cache file not writeable!", E_USER_ERROR);
				return false;
			}

			$f = fopen($filename, 'w');
			if (flock($f, LOCK_EX))
			{
				fwrite($f, $this->_pack($data));
				flock($f, LOCK_UN);
			}
			fclose($f);

			$this->_output($data['__output__']);
			unset($this->stack[count($this->stack)-1]);

			return false;
		}
		elseif( count($this->stack) &&  in_array($file,$this->stack) )
		{
			trigger_error("Cache stack problem: ".$this->stack[count($this->stack)-1]." not properly finished!", E_USER_ERROR);
			return false;
		}
		else
		{
			$r = $this->_start($file,$time);
			if(is_int($r))
			{
				return $r;
			}
			else
			{
				for($i = 0;$i<count($data); $i++)
				{
					$data[$i] = $r[$i];
				}
				return false;
			}
		}
	}

	function _cleardir($dir, $exp=0)
	{
		$n=0;
		$dirstack=array();
		array_push($dirstack, $dir);
		do
		{
			$dir=array_pop($dirstack);
			if(!in_array(substr($dir,-1),array("\\","/"))) $dir.="/";

			$fs = @scandir($dir);
			foreach($fs as $f)
			{
				if(in_array($f, array(".","..")))continue;

				$fn=$dir.$f;
				if(!is_readable($fn))continue;
				if(is_file($fn))
				{
					if($exp > 0)
					{
						$ts=time()-filemtime($fn);
						if($ts < $exp)continue;
					}
					if($exp>=0)
					{
						@unlink($fn);
					}
					$n++;
				}
				elseif(is_dir($fn))
				{
					array_push($dirstack, $fn);
				}
			}
			if($exp==0)@rmdir($dir);

		}while(sizeof($dirstack)>0);

		return $n;
	}

	function clear($exp=0)
	{
		return $this->_cleardir($this->path, $exp);
	}

	function remove($file, $group=false)
	{
		if(!$file)return;
		$file=$this->_formatfile($file, $group);
		$filename = $this->path.$file;
		if (is_file($filename))
		{
			@unlink($filename);
		}
	}

	function remove_group($group)
	{
		if(!$group)return;
		$subdir=$this->_getfsname($group);
		if(!is_dir($this->path.$subdir))return;
		$this->_cleardir($this->path.$subdir);
	}

	function cachecount()
	{
		return $this->_cleardir($this->path, -1);
	}
}
?>