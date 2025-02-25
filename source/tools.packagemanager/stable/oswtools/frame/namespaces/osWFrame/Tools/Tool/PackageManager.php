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

namespace osWFrame\Tools\Tool;

use osWFrame\Core as Frame;
use osWFrame\Tools as Tools;

class PackageManager extends CoreTool {

	use Frame\BaseStaticTrait;

	/**
	 * Major-Version der Klasse.
	 */
	private const CLASS_MAJOR_VERSION=1;

	/**
	 * Minor-Version der Klasse.
	 */
	private const CLASS_MINOR_VERSION=0;

	/**
	 * Release-Version der Klasse.
	 */
	private const CLASS_RELEASE_VERSION=2;

	/**
	 * Extra-Version der Klasse.
	 * Zum Beispiel alpha, beta, rc1, rc2 ...
	 */
	private const CLASS_EXTRA_VERSION='';

	/**
	 * @var array
	 */
	protected array $packages_local=[];

	/**
	 * @var array
	 */
	protected array $packages=[];

	/**
	 * @var array
	 */
	protected array $server_list=[];

	/**
	 * @var string
	 */
	protected string $sl='';

	/**
	 * @var object|Tools\Manager|null
	 */
	protected ?object $Manager=null;

	/**
	 * PackagesManager constructor.
	 *
	 * @param string $serverlist
	 * @param string $package
	 * @param string $release
	 */
	public function __construct(string $serverlist, string $package, string $release) {
		parent::__construct($serverlist, $package, $release);
		$this->Manager=new Tools\Manager();
	}

	/**
	 * @return $this
	 */
	public function scanLocalPackages():self {
		if ($this->packages_local===[]) {
			$path=Frame\Settings::getStringVar('settings_abspath').'modules'.DIRECTORY_SEPARATOR;
			foreach (scandir($path) as $node) {
				if ((substr($node, 0, 6)=='packages.')&&($node!='packages.main.stable')) {
					$this->packages_local[$node]=$node;
				}
			}
		}

		return $this;
	}

	/**
	 * @return array
	 */
	public function getLocalPackages():array {
		$this->scanLocalPackages();

		return $this->packages_local;
	}

	/**
	 * @return $this
	 */
	public function loadPackages():self {
		if ($this->packages==[]) {
			$packages=self::getLocalPackages();
			$this->Manager->setKeys(['core'])->getServerPackageList()->checkPackageList();
			foreach ($this->Manager->getPackageList() as $current_serverlist=>$server_packages) {
				$this->packages[$current_serverlist]=[];
				foreach ($server_packages as $package_name=>$package_data) {
					$package=$package_data['package'].'.'.$package_data['release'];
					$this->packages[$current_serverlist][$package]=$package_data;
					if (isset($packages[$package])) {
						unset($packages[$package]);
					}
				}
			}

			$this->server_list=[''=>['info'=>['name'=>'*']]]+Tools\Server::getServerList();

			if ($packages!=[]) {
				$this->server_list['custom']['info']['name']='Custom';
				foreach ($packages as $package) {
					$file=Frame\Settings::getStringVar('settings_abspath').$package.DIRECTORY_SEPARATOR.'info.json';
					if (file_exists($file)) {
						$this->packages['custom'][$package]=json_decode(file_get_contents($file), true);
					} else {
						$this->packages['custom'][$package]=$package;
					}
				}
			}
		}

		return $this;
	}

	/**
	 * @return array
	 */
	public function getPackages():array {
		return $this->packages;
	}

	/**
	 * @return array
	 */
	public function getList():array {
		return $this->server_list;
	}

	/**
	 * @param string $sl
	 * @return $this
	 */
	public function setSL(string $sl):self {
		if (!isset($this->server_list[$sl])) {
			$sl='';
		}
		$this->sl=$sl;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getSL():string {
		return $this->sl;
	}

	/**
	 * @param string $link
	 * @param string $i
	 * @param array $package_data
	 * @param string $sl
	 * @return string
	 */
	public function outputOption(string $link, string $i, array $package_data, string $sl):string {
		$output='';
		if ($package_data['options']['install']==true) {
			$output.='<a title="Install" href="javascript:manager(\''.$i.'\', \''.$link.'\', \'install\', \''.$sl.'\', \''.$package_data['package'].'\', \''.$package_data['release'].'\')" class="install btn btn-primary btn-xs"><i class="fas fa-plus fa-fw"></i></a>';
		} else {
			$output.='<a title="Install" href="javascript:manager(\''.$i.'\', \''.$link.'\', \'install\', \''.$sl.'\', \''.$package_data['package'].'\', \''.$package_data['release'].'\')" class="install btn btn-primary btn-xs disabled"><i class="fas fa-plus fa-fw"></i></a>';
		}
		$output.=' ';
		if ($package_data['options']['update']==true) {
			$output.='<a title="Update" href="javascript:manager(\''.$i.'\', \''.$link.'\', \'update\', \''.$sl.'\', \''.$package_data['package'].'\', \''.$package_data['release'].'\')" class="update btn btn-primary btn-xs"><i class="fa fa-sync fa-fw"></i></a>';
		} else {
			$output.='<a title="Update" href="javascript:manager(\''.$i.'\', \''.$link.'\', \'update\', \''.$sl.'\', \''.$package_data['package'].'\', \''.$package_data['release'].'\')" class="update btn btn-primary btn-xs disabled"><i class="fa fa-sync fa-fw"></i></a>';
		}
		$output.=' ';
		if ($package_data['options']['remove']==true) {
			$output.='<a title="Remove" href="javascript:manager(\''.$i.'\', \''.$link.'\', \'remove\', \''.$sl.'\', \''.$package_data['package'].'\', \''.$package_data['release'].'\')" class="remove btn btn-primary btn-xs"><i class="fa fa-times fa-fw"></i></a>';
		} else {
			$output.='<a title="Remove" href="javascript:manager(\''.$i.'\', \''.$link.'\', \'remove\', \''.$sl.'\', \''.$package_data['package'].'\', \''.$package_data['release'].'\')" class="remove btn btn-primary btn-xs disabled"><i class="fa fa-times fa-fw"></i></a>';
		}

		return $output;
	}

	/**
	 * @param string $serverlist
	 * @param string $package
	 * @param string $release
	 * @return ?array
	 */
	public function getPackageDetails(string $serverlist, string $package, string $release):?array {
		return $this->Manager->getPackageDetails($serverlist, $package, $release);
	}

	/**
	 * @param string $serverlist
	 * @param string $package
	 * @param string $release
	 * @return bool
	 */
	public function installPackage(string $serverlist, string $package, string $release):bool {
		$status=$this->Manager->installPackage($serverlist, $package, $release);
		$this->Manager->checkPackageList();

		return $status;
	}

	/**
	 * @param string $serverlist
	 * @param string $package
	 * @param string $release
	 * @param bool $skip_create_files
	 * @return bool
	 */
	public function removePackage(string $serverlist, string $package, string $release, bool $skip_create_files=false):bool {
		$status=$this->Manager->removePackage($serverlist, $package, $release, $skip_create_files);
		$this->Manager->checkPackageList();

		return $status;
	}

	/**
	 * @return array
	 */
	public function getCheckList():array {
		$check_list=[];
		foreach ($this->Manager->getInstalledPackages() as $package) {
			$check_list[md5($package['serverlist'].'#'.$package['package'].'#'.$package['release'])]=$this->Manager->getPackageDetails($package['serverlist'], $package['package'], $package['release']);
		}

		return $check_list;
	}

}

?>