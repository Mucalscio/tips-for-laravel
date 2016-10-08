<?php
namespace App\Http\Controllers\Docs;

use App\Http\Controllers\Controller;
use App\Model\Docs;
use App\Model\DocsInterfaceCategory;
use Illuminate\Http\Request;
use DB;
use Redirect;
use Validator;

class CategoryController extends Controller{

    public $create_rule = [
        'name' => 'required|max:64',
    ];

    public function category_list($doc_id)
    {
        $data['data'] = DocsInterfaceCategory::where('doc_id',$doc_id)->get()->toArray();
        return response()->json( formatReturnData(1, $data) );
    }

    public function create($doc_id, Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, $this->create_rule);
        if ($validator->fails()) {
            $error = $validator->errors()->first();
            return response()->json( formatReturnData(-2 ,$error) );
        }
        $num = DocsInterfaceCategory::where(['name' => $data['name'], 'doc_id' => $doc_id])->count();
        if($num > 0) {
            return response()->json( formatReturnData(-1, '该分类已存在' ) );
        }
        $category = new DocsInterfaceCategory();
        $category->doc_id = $doc_id;
        $category->name = $data['name'];
        $category->save();
        if(!empty($category->id)) {
            return response()->json( formatReturnData(1, $category->toArray()) );
        } else {
            return response()->json( formatReturnData(-3, '创建失败' ) );
        }
    }

    public function delete($id)
    {
        $res = DocsInterfaceCategory::where('id',$id)->delete();
        if($res) {
            return response()->json( formatReturnData(1, "删除成功") );
        } else {
            return response()->json( formatReturnData(-1, "删除失败") );
        }
    }

}