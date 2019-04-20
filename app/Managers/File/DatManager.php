<?php


namespace App\Managers\File;

use App\Managers\File\Types\FileDat;
use Illuminate\Support\Facades\Storage;

class DatManager
{
	/**
	 * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
	 */
	public function processIn() {
	  foreach (Storage::disk('dat')->allFiles('in') as $file) {
			if (preg_match("/([a-zA-Z0-9\s_\\.\-\(\):])+(.dat)$/",$file)) {
				$rows = Storage::disk('dat')->get($file);
				$results = (new FileDat($rows))->analyze();
				$this->createDoneFile($file,$results);
			}
	  }
	}

	/**
	 * @return array
	 */
	public function getFiles(){
		$it = [];
		foreach (Storage::disk('dat')->allFiles('out') as $file) {
			if (preg_match("/([a-zA-Z0-9\s_\\.\-\(\):])+(.dat)$/",$file)) {
				$it[] = $file;
			}
		}
		return $it;
	}
	/**
	 * @param $file
	 * @param $content
	 */
	private function createDoneFile($file, $content) {
		preg_match("/(?<=in\/)(.*)(?=.dat)/",$file,$mat);
		$fileName = $mat[0];
		Storage::disk('dat')->put("out/{$fileName}.done.dat",json_encode($content));
	}

	/**
	 * @param $fileName
	 * @return bool
	 */
	public function getContentDoneFile($fileName){
		return Storage::disk('dat')->get($fileName);
	}
}
