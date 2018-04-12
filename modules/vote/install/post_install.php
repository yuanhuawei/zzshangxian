<?php
defined('PHP168_PATH') or die();

md($this_module->path .'js/', true);
md(CACHE_PATH . $this_system->name .'/modules/'. $this_module->name .'/vote/', true);