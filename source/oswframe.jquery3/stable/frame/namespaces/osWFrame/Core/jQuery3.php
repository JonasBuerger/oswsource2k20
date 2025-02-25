<?php

/**
 * This file is part of the osWFrame package
 *
 * @author Juergen Schwind
 * @copyright Copyright (c) JBS New Media GmbH - Juergen Schwind (https://jbs-newmedia.com)
 * @package osWFrame
 * @link https://oswframe.com
 * @license MIT License
 */

namespace osWFrame\Core;

class jQuery3 {

	use BaseStaticTrait;
	use BaseTemplateBridgeTrait;

	/**
	 * Major-Version der Klasse.
	 */
	private const CLASS_MAJOR_VERSION=1;

	/**
	 * Minor-Version der Klasse.
	 */
	private const CLASS_MINOR_VERSION=1;

	/**
	 * Release-Version der Klasse.
	 */
	private const CLASS_RELEASE_VERSION=4;

	/**
	 * Extra-Version der Klasse.
	 * Zum Beispiel alpha, beta, rc1, rc2 ...
	 */
	private const CLASS_EXTRA_VERSION='';

	/**
	 * jQuery3 Version.
	 *
	 * @var string
	 */
	protected const CURRENT_RESOURCE_VERSION='3.6.1';

	/**
	 * Verwaltet die geladenen Plugins.
	 *
	 * @var array
	 */
	protected array $loaded_plugins=[];

	/**
	 * Speichert alle verfügbaren Versionen.
	 *
	 * @var array
	 */
	protected array $versions=[];

	/**
	 * @var string
	 */
	protected $version='';

	/**
	 * @var bool
	 */
	protected $min=true;

	/**
	 * jQuery3 constructor.
	 *
	 * @param object $Template
	 */
	public function __construct(object $Template) {
		$this->setTemplate($Template);
		$this->setVersion('current');
	}

	/**
	 * @param string $version
	 * @return $this
	 */
	public function setVersion(string $version):self {
		if ($version=='current') {
			$this->version=$this->getCurrentVersion();
		} else {
			if (in_array($version, $this->getVersions())) {
				$this->version=$version;
			} else {
				$this->version=$this->getCurrentVersion();
			}
		}

		return $this;
	}

	/**
	 * @return string
	 */
	public function getVersion():string {
		return $this->version;
	}

	/**
	 * @param bool $min
	 * @return $this
	 */
	public function setMin(bool $min):self {
		$this->min=$min;

		return $this;
	}

	/**
	 * @return bool
	 */
	public function getMin():bool {
		return $this->min;
	}

	/**
	 * @return $this
	 */
	public function load():self {
		$version=$this->getVersion();
		$min=$this->getMin();

		$name=$version.'.resource';
		if (Resource::existsResource($this->getClassName(), $name)!==true) {
			$files=['js'.DIRECTORY_SEPARATOR.'jquery.js', 'js'.DIRECTORY_SEPARATOR.'jquery.min.js', 'js'.DIRECTORY_SEPARATOR.'jquery.min.map'];
			Resource::copyResourcePath('frame'.DIRECTORY_SEPARATOR.'resources'.DIRECTORY_SEPARATOR.'jquery3'.DIRECTORY_SEPARATOR.$version.DIRECTORY_SEPARATOR, 'jquery3'.DIRECTORY_SEPARATOR.$version.DIRECTORY_SEPARATOR, $files);
			Resource::writeResource($this->getClassName(), $name, time());
		}
		$path=Resource::getRelDir().'jquery3'.DIRECTORY_SEPARATOR.$version.DIRECTORY_SEPARATOR;
		if ($min===true) {
			$jsfiles=[$path.'js'.DIRECTORY_SEPARATOR.'jquery.min.js'];
		} else {
			$jsfiles=[$path.'js'.DIRECTORY_SEPARATOR.'jquery.js'];
		}
		$this->addTemplateJSFiles('head', $jsfiles);

		return $this;
	}

	/**
	 * Gibt die aktuelle Version zurück.
	 *
	 * @return string
	 */
	public function getCurrentVersion() {
		return self::CURRENT_RESOURCE_VERSION;
	}

	/**
	 * Gibt alle verfügbaren Versionen zurück.
	 *
	 * @return array
	 */
	public function getVersions():array {
		if ($this->versions==[]) {
			$this->versions=Filesystem::trimPathInArray(Settings::getStringVar('settings_abspath').'frame'.DIRECTORY_SEPARATOR.'resources'.DIRECTORY_SEPARATOR.'jquery3'.DIRECTORY_SEPARATOR, Filesystem::scanDirsToArray(Settings::getStringVar('settings_abspath').'frame'.DIRECTORY_SEPARATOR.'resources'.DIRECTORY_SEPARATOR.'jquery3'.DIRECTORY_SEPARATOR, false));
		}

		return $this->versions;
	}

	/**
	 * Lädt einen Plugin.
	 *
	 * @param string $plugin_name
	 * @param array $options
	 * @return bool
	 */
	public function loadPlugin(string $plugin_name, array $options=[]):bool {
		$plugin_name=strtolower($plugin_name);
		if (isset($this->loaded_plugins[$plugin_name])) {
			return true;
		}

		$loader=Settings::getStringVar('settings_abspath').'frame'.DIRECTORY_SEPARATOR.'resources'.DIRECTORY_SEPARATOR.'jquery3'.DIRECTORY_SEPARATOR.'plugins'.DIRECTORY_SEPARATOR.$plugin_name.DIRECTORY_SEPARATOR.'loader.inc.php';
		if (file_exists($loader)) {
			include $loader;
			$this->loaded_plugins[$plugin_name]=true;

			return true;
		}

		return false;
	}

}

?>