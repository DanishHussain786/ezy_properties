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
	public function index(Request $request)
	{
		$request_data = $request->all();

		// if ( (isset($request_data['search_user'])) && $request_data['search_user'] != '' ) {
		// }


		$request_data['paginate'] = 10;
		$data['records'] = $this->UserObj->getUser($request_data);
		$data['html'] = view("{$this->route_name}.ajax_records", compact('data'));

		if ($request->ajax()) {
			return $data['html'];
		}
		return view("{$this->route_name}.list", compact('data'));
	}

	/**
	 * Show the form for creating a new resource.
	 */
	public function create(Request $request)
	{
		$data = [];

		if ($request->ajax()) {
			return $data['html'];
		}
		return view("{$this->route_name}.add", compact('data'));
	}

	/**
	 * Store a newly created resource in storage.
	 */
	public function store(Request $request)
	{
		// \Config::get('constants.statusDraftPublished');
		$rules = array(
			'first_name' => 'required',
			'last_name' => 'required',
			'role' => 'required',
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
		} else {
			$request_data = $request->all();

			if (!isset($request_data['password']))
				$request_data['password'] = '12345678@9';

			if ($request->file('image')) {
				$extension = $request->image->getClientOriginalExtension();
				if ($extension == 'jpg' || $extension == 'jpeg' || $extension == 'png') {

					$imageData = array();
					// $imageData['fileName'] = time().'_'.$request->image->getClientOriginalName();
					$imageData['fileName'] = time() . '_' . rand(1000000, 9999999) . '.' . $extension;
					$imageData['uploadfileObj'] = $request->file('image');
					$imageData['fileObj'] = \Image::make($request->file('image')->getRealPath());
					$imageData['folderName'] = 'sub_menu_images';

					$uploadAssetRes = uploadAssets($imageData, $original = false, $optimized = true, $thumbnail = false);
					$data['asset_value'] = $uploadAssetRes;
					if (!$uploadAssetRes) {
						return back()->withErrors([
							'image' => 'Something wrong with your icon image, please try again later!',
						])->withInput();
					}
				} else {
					return back()->withErrors([
						'image' => 'The image format is not correct you can only upload (jpg, jpeg, png).',
					])->withInput();
				}
			}

			$this->UserObj->saveUpdateUser($request_data);

			// $request_data['create_or_skip'] = true;
			// $data = $this->TaskObj->saveUpdateTask($request_data);

			// if ($data == 'already_exist') {
			// if (isset($request_data['image_url'])) delete_files_from_storage($request_data['image_url']);
			// $flash_data = ['error_message', $this->controller_name_single.' is already exist.'];
			// }
			// else if ($data->id)
			$flash_data = ['message', $this->controller_name_single . ' is created successfully.'];

			\Session::flash($flash_data[0], $flash_data[1]);
			return redirect("/{$this->route_name}");
		}
	}

	/**
	 * Display the specified resource.
	 */
	public function show(Request $request, $id = 0)
	{
		// $id = \Crypt::decrypt($id); 
		$request_data = $request->all();
		if ($id != 0)
			$request_data['id'] = $id;

		$request_data = array();
		$request_data['id'] = $id;
		$request_data['detail'] = true;

		$data = $this->UserObj->getUser($request_data);
		return view("{$this->route_name}.partials.profile", compact('data'));
	}

	/**
	 * Show the form for editing the specified resource.
	 */
	public function edit($id = 0)
	{
		$request_data = array();
		$request_data['id'] = $id;
		$request_data['detail'] = true;

		$data = $this->UserObj->getUser($request_data);

		return view("{$this->route_name}.add", compact('data'));
	}

	/**
	 * Update the specified resource in storage.
	 */
	public function update(Request $request, string $id)
	{
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