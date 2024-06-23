<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
	private $controller_name_single = "User";
	private $controller_name_plural = "Users";
	private $route_name = "user";
	private $model_name = "users";

	/**
	 * Display a listing of the resource.
	 */
	public function index(Request $request) {
		$data = [];

		if($request->ajax()){
			return $data['html'];
		}
		return view("{$this->route_name}.list", compact('data'));
	}

	/**
	 * Show the form for creating a new resource.
	 */
	public function create(Request $request) {
		$data = [];

		if($request->ajax()){
			return $data['html'];
		}
		return view("{$this->route_name}.add", compact('data'));
	}

	/**
	 * Store a newly created resource in storage.
	 */
	public function store(Request $request) {
		// \Config::get('constants.statusDraftPublished');

		$rules = array(
			'first_name' => 'required',
			'last_name' => 'required',
			'email' => 'required',
			'contact_no' => 'required',
			// 'title' => 'required',
			// 'menu' => 'required|exists:menus,id',
			// 'permission' => 'required',
			// 'url' => 'required',
		);

		$validator = \Validator::make($request->all(), $rules);

		if ($validator->fails()) {
			return redirect()->back()->withErrors($validator)->withInput();
			// ->withInput($request->except('password'));
		}
		else {
			$request_data = $request->all();

			$this->UserObj->saveUpdateUser($request_data);

			// $request_data['create_or_skip'] = true;
			// $data = $this->TaskObj->saveUpdateTask($request_data);
			
			// if ($data == 'already_exist') {
				// if (isset($request_data['image_url'])) delete_files_from_storage($request_data['image_url']);
				// $flash_data = ['error_message', $this->controller_name_single.' is already exist.'];
			// }
			// else if ($data->id)
				$flash_data = ['message', $this->controller_name_single.' is created successfully.'];
		
			\Session::flash($flash_data[0], $flash_data[1]);
			return redirect("/{$this->route_name}");
		}
	}

	/**
	 * Display the specified resource.
	 */
	public function show(string $id) {
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 */
	public function edit(string $id) {
		//
	}

	/**
	 * Update the specified resource in storage.
	 */
	public function update(Request $request, string $id) {
	//
	}

	/**
	 * Remove the specified resource from storage.
	 */
	public function destroy(string $id)
	{
		//
	}	
}