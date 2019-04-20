<?php

namespace App\Http\Controllers;

use App\Managers\File\DatManager;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
	/**
	 * @var DatManager
	 */
	private $datManager;

	/**
	 * DashboardController constructor.
	 * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
	 */
	public function __construct() {
		$this->datManager = new DatManager();
		$this->datManager->processIn();
	}

	/**
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function index(){

      return view('welcome',[
      	'files' => $this->datManager->getFiles()
			]);
	}

	/**
	 * @param Request $request
	 * @return \Illuminate\Http\JsonResponse
	 * @throws \Illuminate\Validation\ValidationException
	 */
	public function ajaxGetOutFile(Request $request) {

		$this->validate($request,[
			'fileName' => 'required|file_dat_out'
		]);

		$file = $request->get('fileName');
		return response()->json([
			'ok' => true,
			'obj' => json_decode($this->datManager->getContentDoneFile($file),true)
		]);
	}
}
