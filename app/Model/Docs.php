<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Docs extends Model
{
    /*
     * 表名
     */
    protected $table = 'docs';

    /**
     * 定义一对多关联接口
     */
    public function docs_interface()
    {
        return $this->hasMany('App\Model\DocsInterface');
    }

    /**
     * 定义一对多关联接口
     */
    public function docs_interface_category()
    {
        return $this->hasMany('App\Model\DocsInterfaceCategory');
    }

}
